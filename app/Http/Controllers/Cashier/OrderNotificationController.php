<?php

namespace App\Http\Controllers\Cashier;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OrderNotificationController extends Controller
{
    public function poll(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'after_id' => ['required', 'integer', 'min:0'],
        ]);

        $summary = Order::query()
            ->selectRaw('COALESCE(MAX(id), 0) AS latest_id')
            ->selectRaw(
                'COALESCE(SUM(CASE WHEN payment_status = ? AND status <> ? THEN 1 ELSE 0 END), 0) AS pending_count',
                ['unpaid', 'cancelled']
            )
            ->selectRaw(
                'COALESCE(SUM(CASE WHEN payment_status = ? AND status <> ? THEN total ELSE 0 END), 0) AS pending_total',
                ['unpaid', 'cancelled']
            )
            ->first();

        $latestId = (int) $summary->latest_id;
        $afterId = min((int) $validated['after_id'], $latestId);

        $orders = collect();

        if ($afterId < $latestId) {
            $orders = Order::query()
                ->select([
                    'id',
                    'order_number',
                    'dining_table_id',
                    'customer_name',
                    'order_type',
                    'requested_payment_method',
                    'total',
                    'ordered_at',
                    'created_at',
                ])
                ->with('diningTable:id,table_number')
                ->where('id', '>', $afterId)
                ->where('id', '<=', $latestId)
                ->where('status', 'new')
                ->where('payment_status', 'unpaid')
                ->orderBy('id')
                ->get()
                ->map(fn (Order $order): array => [
                    'id' => $order->id,
                    'order_number' => $order->order_number,
                    'customer_name' => $order->customer_name ?: 'Pelanggan',
                    'table_number' => $order->diningTable?->table_number,
                    'order_type' => $order->order_type,
                    'requested_payment_method' => $order->requested_payment_method,
                    'total' => $order->total,
                    'ordered_at' => ($order->ordered_at ?? $order->created_at)->toIso8601String(),
                    'detail_url' => route('cashier.payments.show', $order),
                ])
                ->values();
        }

        return response()->json([
            'latest_id' => $latestId,
            'pending_count' => (int) $summary->pending_count,
            'pending_total' => (string) $summary->pending_total,
            'orders' => $orders,
        ]);
    }
}
