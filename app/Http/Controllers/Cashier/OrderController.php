<?php

namespace App\Http\Controllers\Cashier;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\DiningTable;
use App\Models\Menu;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class OrderController extends Controller
{
    public function dashboard()
    {
        $today = now()->toDateString();

        $todayRevenue = Order::whereDate('created_at', $today)
            ->where('payment_status', 'paid')
            ->sum('total');

        $todayTransactions = Order::whereDate('created_at', $today)->count();

        $activeOrders = Order::whereIn('status', ['new', 'preparing'])
            ->count();

        $completedOrders = Order::whereDate('created_at', $today)
            ->where('status', 'completed')
            ->count();

        $recentOrders = Order::with('diningTable')
            ->latest()
            ->take(8)
            ->get();

        $tables = DiningTable::orderBy('sort_order')
            ->orderBy('table_number')
            ->get();

        return view('cashier.dashboard', compact(
            'todayRevenue',
            'todayTransactions',
            'activeOrders',
            'completedOrders',
            'recentOrders',
            'tables'
        ));
    }

    public function create()
    {
        $categories = Category::where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        $menus = Menu::where('is_available', true)
            ->with('category')
            ->orderBy('sort_order')
            ->get();

        $tables = DiningTable::where('status', 'available')
            ->orderBy('sort_order')
            ->orderBy('table_number')
            ->get();

        return view('cashier.orders.create', compact(
            'categories',
            'menus',
            'tables'
        ));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_name' => ['nullable', 'string', 'max:100'],
            'order_type' => ['required', 'in:dine_in,takeaway'],
            'dining_table_id' => [
                'nullable',
                'required_if:order_type,dine_in',
                'integer',
                'exists:dining_tables,id',
            ],
            'items' => ['required', 'array', 'min:1'],
            'items.*.menu_id' => [
                'required',
                'integer',
                'distinct',
                'exists:menus,id',
            ],
            'items.*.quantity' => [
                'required',
                'integer',
                'min:1',
                'max:100',
            ],
        ]);

        $order = DB::transaction(function () use ($validated) {
            $menuIds = collect($validated['items'])
                ->pluck('menu_id')
                ->unique()
                ->values();

            $menus = Menu::whereIn('id', $menuIds)
                ->where('is_available', true)
                ->lockForUpdate()
                ->get()
                ->keyBy('id');

            if ($menus->count() !== $menuIds->count()) {
                throw ValidationException::withMessages([
                    'items' => 'Ada menu yang tidak tersedia. Silakan periksa kembali pesanan.',
                ]);
            }

            $table = null;

            if ($validated['order_type'] === 'dine_in') {
                $table = DiningTable::whereKey($validated['dining_table_id'])
                    ->lockForUpdate()
                    ->first();

                if (!$table || $table->status !== 'available') {
                    throw ValidationException::withMessages([
                        'dining_table_id' => 'Meja tidak tersedia. Silakan pilih meja lain.',
                    ]);
                }
            }

            $subtotal = 0;

            foreach ($validated['items'] as $item) {
                $menu = $menus->get($item['menu_id']);
                $subtotal += (float) $menu->price * (int) $item['quantity'];
            }

            $order = Order::create([
                'order_number' => 'RB-' . now()->format('YmdHis') . '-' . Str::upper(Str::random(4)),
                'dining_table_id' => $table?->id,
                'user_id' => auth()->id(),
                'customer_name' => $validated['customer_name'] ?? null,
                'order_type' => $validated['order_type'],
                'status' => 'new',
                'payment_status' => 'unpaid',
                'payment_method' => null,
                'subtotal' => $subtotal,
                'tax' => 0,
                'discount' => 0,
                'total' => $subtotal,
                'notes' => null,
                'ordered_at' => now(),
            ]);

            foreach ($validated['items'] as $item) {
                $menu = $menus->get($item['menu_id']);
                $quantity = (int) $item['quantity'];
                $price = (float) $menu->price;

                OrderItem::create([
                    'order_id' => $order->id,
                    'menu_id' => $menu->id,
                    'menu_name' => $menu->name,
                    'price' => $price,
                    'quantity' => $quantity,
                    'subtotal' => $price * $quantity,
                    'notes' => null,
                ]);
            }
            if ($table) {
                $table->update([
                    'status' => 'occupied',
                ]);
            }
            return $order;
        });

        return redirect()
            ->route('cashier.payments.show', $order->id)
            ->with('success', 'Pesanan berhasil dibuat. Silakan lanjutkan pembayaran.');
    }
}
