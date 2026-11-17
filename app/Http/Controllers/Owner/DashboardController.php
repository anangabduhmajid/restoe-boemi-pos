<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $today = now()->toDateString();

        // Transaksi yang pembayarannya sudah berhasil
        $paidOrders = DB::table('orders')
            ->where('payment_status', 'paid')
            ->whereNotNull('paid_at')
            ->where('status', '!=', 'cancelled');

        // Ringkasan dashboard
        $todayOrders = (clone $paidOrders)
            ->whereDate('paid_at', $today);

        $stats = [
            [
                'label' => 'Total Sales',
                'value' => 'Rp ' . number_format(
                    (clone $todayOrders)->sum('total'),
                    0,
                    ',',
                    '.'
                ),
                'description' => 'Paid revenue today',
                'symbol' => 'Rp',
            ],
            [
                'label' => 'Transactions',
                'value' => (string) (clone $todayOrders)->count(),
                'description' => 'Paid transactions today',
                'symbol' => '#',
            ],
            [
                'label' => 'Active Orders',
                'value' => (string) DB::table('orders')
                    ->where('payment_status', 'paid')
                    ->whereIn('status', ['new', 'preparing'])
                    ->count(),
                'description' => 'Waiting and preparing',
                'symbol' => 'O',
            ],
            [
                'label' => 'Items Sold',
                'value' => (string) DB::table('order_items')
                    ->join('orders', 'orders.id', '=', 'order_items.order_id')
                    ->where('orders.payment_status', 'paid')
                    ->whereNotNull('orders.paid_at')
                    ->where('orders.status', '!=', 'cancelled')
                    ->whereDate('orders.paid_at', $today)
                    ->sum('order_items.quantity'),
                'description' => 'Paid menu quantities today',
                'symbol' => 'M',
            ],
        ];

        // Grafik pendapatan 7 hari terakhir
        $weeklyRevenue = collect(range(6, 0))->map(function ($daysAgo) use ($paidOrders) {
            $date = now()->subDays($daysAgo);

            $amount = (clone $paidOrders)
                ->whereDate('paid_at', $date->toDateString())
                ->sum('total');

            return [
                'day' => strtoupper($date->format('D')),
                'amount' => (float) $amount,
            ];
        });

        $maxRevenue = max($weeklyRevenue->max('amount'), 1);

        $weeklyRevenue = $weeklyRevenue->map(function ($revenue) use ($maxRevenue) {
            $revenue['height'] = max(
                4,
                (int) round(($revenue['amount'] / $maxRevenue) * 100)
            );

            return $revenue;
        });

        // Menu terlaris berdasarkan item dari pesanan yang dibayar
        $bestSellers = DB::table('order_items')
            ->join('orders', 'orders.id', '=', 'order_items.order_id')
            ->where('orders.payment_status', 'paid')
            ->whereNotNull('orders.paid_at')
            ->where('orders.status', '!=', 'cancelled')
            ->whereDate('orders.paid_at', $today)
            ->select(
                'order_items.menu_name as name',
                DB::raw('SUM(order_items.quantity) as sold')
            )
            ->groupBy('order_items.menu_name')
            ->orderByDesc('sold')
            ->limit(4)
            ->get()
            ->map(function ($product) {
                return [
                    'name' => $product->name,
                    'sold' => (int) $product->sold,
                    'category' => 'Menu',
                ];
            });

        // Pesanan terbaru
        $orders = DB::table('orders')
            ->leftJoin('dining_tables', 'dining_tables.id', '=', 'orders.dining_table_id')
            ->where('orders.payment_status', 'paid')
            ->whereNotNull('orders.paid_at')
            ->where('orders.status', '!=', 'cancelled')
            ->select(
                'orders.order_number as id',
                'orders.customer_name as customer',
                'orders.paid_at',
                'orders.total',
                'orders.status',
                'orders.order_type',
                'dining_tables.table_number'
            )
            ->orderByDesc('orders.paid_at')
            ->limit(5)
            ->get()
            ->map(function ($order) {
                return [
                    'id' => $order->id,
                    'customer' => $order->customer ?: 'Guest',
                    'time' => Carbon::parse($order->paid_at)->format('H:i'),
                    'table' => $order->table_number
                        ? 'Table ' . $order->table_number
                        : 'Takeaway',
                    'total' => (float) $order->total,
                    'status' => ucfirst($order->status),
                ];
            });

        return view('owner.dashboard', compact(
            'stats',
            'weeklyRevenue',
            'bestSellers',
            'orders'
        ));
    }
}
