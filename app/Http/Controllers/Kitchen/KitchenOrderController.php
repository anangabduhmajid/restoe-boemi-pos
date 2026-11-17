<?php

namespace App\Http\Controllers\Kitchen;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;

class KitchenOrderController extends Controller
{
    /**
     * Menampilkan pesanan aktif dan ringkasan dapur.
     */

    public function index(): View
    {
        $orders = Order::with(['items', 'diningTable'])
            ->where('payment_status', 'paid')
            ->whereIn('status', ['new', 'preparing'])
            ->orderByDesc('ordered_at')
            ->get();

        $newOrdersList = $orders->where('status', 'new');

        $preparingOrdersList = $orders->where('status', 'preparing');

        $newOrders = $newOrdersList->count();

        $preparingOrders = $preparingOrdersList->count();

        $completedToday = Order::where('status', 'completed')
            ->whereDate('completed_at', today())
            ->count();

        return view('kitchen.dashboard', compact(
            'newOrders',
            'preparingOrders',
            'completedToday',
            'newOrdersList',
            'preparingOrdersList'
        ));
    }


    /**
     * Memulai proses pengerjaan pesanan.
     */
    public function startPreparing(Order $order): RedirectResponse
    {
        $updated = DB::transaction(function () use ($order) {
            $lockedOrder = Order::whereKey($order->id)
                ->lockForUpdate()
                ->firstOrFail();

            if (
                $lockedOrder->payment_status !== 'paid' ||
                $lockedOrder->status !== 'new'
            ) {
                return false;
            }

            $lockedOrder->update([
                'status' => 'preparing',
            ]);

            return true;
        });

        if (! $updated) {
            return back()->with(
                'error',
                'Pesanan tidak dapat dimulai karena statusnya sudah berubah.'
            );
        }

        return back()->with('success', 'Pesanan mulai dimasak.');
    }

    /**
     * Menandai pesanan telah selesai.
     */
    public function complete(Order $order): RedirectResponse
    {
        $updated = DB::transaction(function () use ($order) {
            $lockedOrder = Order::whereKey($order->id)
                ->lockForUpdate()
                ->firstOrFail();

            if (
                $lockedOrder->payment_status !== 'paid' ||
                $lockedOrder->status !== 'preparing'
            ) {
                return false;
            }

            $lockedOrder->update([
                'status' => 'completed',
                'completed_at' => now(),
            ]);

            return true;
        });

        if (! $updated) {
            return back()->with(
                'error',
                'Pesanan tidak dapat diselesaikan karena statusnya sudah berubah.'
            );
        }

        return back()->with('success', 'Pesanan berhasil diselesaikan.');
    }

    /**
     * Menampilkan riwayat pesanan yang selesai.
     */
    public function history(): View
    {
        $orders = Order::with(['items', 'diningTable'])
            ->where('status', 'completed')
            ->latest('completed_at')
            ->paginate(15);

        return view('kitchen.history', compact('orders'));
    }
}
