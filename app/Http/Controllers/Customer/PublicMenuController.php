<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\DiningTable;
use App\Models\Menu;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class PublicMenuController extends Controller
{
    public function show(DiningTable $table): View
    {
        $categories = Category::query()
            ->where('is_active', true)
            ->whereHas('menus')
            ->with(['menus' => fn($query) => $query
                ->orderBy('sort_order')
                ->orderBy('name')])
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        return view('menu.index', compact('table', 'categories'));
    }

    public function store(Request $request, DiningTable $table): RedirectResponse
    {
        $validated = $request->validate([
            'customer_name' => ['required', 'string', 'max:100'],
            'notes' => ['nullable', 'string', 'max:1000'],
            'payment_method' => ['required', 'in:cash,transfer,qris,debit'],
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
        ], [
            'payment_method.required' => 'Silakan pilih metode pembayaran.',
            'payment_method.in' => 'Metode pembayaran tidak valid.',
        ]);

        $order = DB::transaction(function () use ($validated, $table) {

            // Kunci meja selama proses pembuatan pesanan.
            $lockedTable = DiningTable::whereKey($table->id)
                ->lockForUpdate()
                ->firstOrFail();

            // Meja available dan occupied boleh menerima pesanan QR.
            // Meja reserved dan maintenance tidak boleh menerima pesanan.
            if (! in_array($lockedTable->status, ['available', 'occupied'], true)) {
                throw ValidationException::withMessages([
                    'items' => 'Meja ini sedang tidak tersedia untuk pemesanan. Silakan hubungi petugas.',
                ]);
            }

            $menuIds = collect($validated['items'])
                ->pluck('menu_id')
                ->unique()
                ->values();

            $menus = Menu::query()
                ->whereIn('id', $menuIds)
                ->where('is_available', true)
                ->lockForUpdate()
                ->get()
                ->keyBy('id');

            if ($menus->count() !== $menuIds->count()) {
                throw ValidationException::withMessages([
                    'items' => 'Ada menu yang sudah tidak tersedia. Silakan periksa kembali pesananmu.',
                ]);
            }

            $subtotal = 0;

            foreach ($validated['items'] as $item) {
                $subtotal += $menus[$item['menu_id']]->price * $item['quantity'];
            }

            $order = Order::create([
                'order_number' => 'RB-' . now()->format('YmdHis') . '-' . Str::upper(Str::random(4)),
                'dining_table_id' => $lockedTable->id,
                'user_id' => null,
                'customer_name' => $validated['customer_name'],
                'order_type' => 'dine_in',
                'status' => 'new',
                'payment_status' => 'unpaid',
                'payment_method' => null,
                'requested_payment_method' => $validated['payment_method'],
                'subtotal' => $subtotal,
                'tax' => 0,
                'discount' => 0,
                'total' => $subtotal,
                'notes' => $validated['notes'] ?? null,
                'ordered_at' => now(),
            ]);

            foreach ($validated['items'] as $item) {
                $menu = $menus[$item['menu_id']];
                $quantity = $item['quantity'];

                $order->items()->create([
                    'menu_id' => $menu->id,
                    'menu_name' => $menu->name,
                    'price' => $menu->price,
                    'quantity' => $quantity,
                    'subtotal' => $menu->price * $quantity,
                ]);
            }
            $lockedTable->update([
                'status' => 'occupied',
            ]);
            return $order;
        });

        return redirect()
            ->route('menu.show', $table->qr_token)
            ->with(
                'success',
                'Pesanan ' . $order->order_number .
                    ' berhasil dikirim! Metode pembayaran: ' .
                    strtoupper($order->requested_payment_method) . '.'
            );
    }
}
