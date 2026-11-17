<?php

namespace App\Http\Controllers\Cashier;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\DiningTable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class PaymentController extends Controller
{
    public function index(Request $request): View
    {
        $query = Order::with(['diningTable', 'items'])
            ->where('payment_status', 'unpaid')
            ->where('status', '!=', 'cancelled')
            ->latest();

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('order_number', 'like', "%{$search}%")
                    ->orWhere('customer_name', 'like', "%{$search}%");
            });
        }

        $unpaidOrders = $query->paginate(10)->withQueryString();

        $totalUnpaid = Order::where('payment_status', 'unpaid')
            ->where('status', '!=', 'cancelled')
            ->count();

        $totalReceivable = Order::where('payment_status', 'unpaid')
            ->where('status', '!=', 'cancelled')
            ->sum('total');

        $todayPaid = Order::where('payment_status', 'paid')
            ->whereDate('paid_at', today())
            ->sum('total');

        return view('cashier.payments.index', compact(
            'unpaidOrders',
            'totalUnpaid',
            'totalReceivable',
            'todayPaid'
        ));
    }

    public function show(Order $order): View|RedirectResponse
    {
        if ($order->payment_status !== 'unpaid') {
            return redirect()
                ->route('cashier.payments.index')
                ->with('error', 'Pesanan ini sudah dibayar.');
        }

        if ($order->status === 'cancelled') {
            return redirect()
                ->route('cashier.payments.index')
                ->with('error', 'Pesanan yang dibatalkan tidak dapat dibayar.');
        }

        $order->load(['items', 'diningTable']);

        return view('cashier.payments.show', compact('order'));
    }

    public function pay(Request $request, Order $order): RedirectResponse
    {
        $validated = $request->validate([
            'payment_method' => [
                'required',
                'in:cash,transfer,qris,debit',
            ],
            'cash_received' => [
                'required_if:payment_method,cash',
                'nullable',
                'numeric',
                'min:0',
            ],
        ], [
            'payment_method.required' => 'Pilih metode pembayaran.',
            'payment_method.in' => 'Metode pembayaran tidak valid.',
            'cash_received.required_if' => 'Masukkan jumlah uang yang diterima.',
            'cash_received.numeric' => 'Jumlah uang harus berupa angka.',
            'cash_received.min' => 'Jumlah uang tidak boleh negatif.',
        ]);

        DB::transaction(function () use ($order, $validated) {
            $lockedOrder = Order::whereKey($order->id)
                ->lockForUpdate()
                ->firstOrFail();

            if ($lockedOrder->payment_status === 'paid') {
                throw ValidationException::withMessages([
                    'payment_method' => 'Pesanan ini sudah dibayar sebelumnya.',
                ]);
            }

            if ($lockedOrder->status === 'cancelled') {
                throw ValidationException::withMessages([
                    'payment_method' => 'Pesanan yang dibatalkan tidak dapat dibayar.',
                ]);
            }

            if (
                $validated['payment_method'] === 'cash'
                && (float) $validated['cash_received'] < (float) $lockedOrder->total
            ) {
                throw ValidationException::withMessages([
                    'cash_received' => 'Uang yang diterima masih kurang dari total tagihan.',
                ]);
            }

            // Untuk pesanan dine-in, kunci dan periksa meja.
            if ($lockedOrder->order_type === 'dine_in' && $lockedOrder->dining_table_id) {
                $lockedTable = DiningTable::whereKey($lockedOrder->dining_table_id)
                    ->lockForUpdate()
                    ->firstOrFail();

                if (! in_array($lockedTable->status, ['available', 'occupied'], true)) {
                    throw ValidationException::withMessages([
                        'payment_method' => 'Meja tidak tersedia. Hubungi Owner sebelum melanjutkan pembayaran.',
                    ]);
                }

                $lockedTable->update([
                    'status' => 'occupied',
                ]);
            }

            $lockedOrder->update([
                'payment_status' => 'paid',
                'payment_method' => $validated['payment_method'],
                'paid_at' => now(),
            ]);
        });

        return redirect()
            ->route('cashier.payments.index')
            ->with(
                'success',
                'Pembayaran berhasil dikonfirmasi. Pesanan ' .
                $order->order_number . ' sudah lunas.'
            );
    }
}
