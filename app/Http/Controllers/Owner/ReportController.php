<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class ReportController extends Controller
{
    public function index(Request $request): View
    {
        $validated = $request->validate([
            'start_date' => ['nullable', 'date'],
            'end_date' => ['nullable', 'date', 'after_or_equal:start_date'],
        ]);

        $startDate = $validated['start_date']
            ?? now()->startOfMonth()->toDateString();

        $endDate = $validated['end_date']
            ?? now()->toDateString();

        // Transaksi yang sudah dibayar dan bukan pesanan batal.
        // Semua laporan menggunakan tanggal pembayaran (paid_at).
        $ordersQuery = Order::query()
            ->where('payment_status', 'paid')
            ->whereNotNull('paid_at')
            ->where('status', '!=', 'cancelled')
            ->whereDate('paid_at', '>=', $startDate)
            ->whereDate('paid_at', '<=', $endDate);

        // Jumlah transaksi lunas.
        $paidOrders = (clone $ordersQuery)->count();

        // Jumlah omzet dari transaksi lunas.
        $totalRevenue = (clone $ordersQuery)->sum('total');

        // Jumlah transaksi sama dengan jumlah pesanan lunas.
        $totalOrders = $paidOrders;

        // Tidak menghitung pesanan yang belum dibayar sebagai transaksi.
        $unpaidOrders = Order::query()
            ->where('payment_status', 'unpaid')
            ->whereDate('created_at', '>=', $startDate)
            ->whereDate('created_at', '<=', $endDate)
            ->count();

        $averageTransaction = $paidOrders > 0
            ? $totalRevenue / $paidOrders
            : 0;

        // Omzet harian berdasarkan tanggal pembayaran.
        $dailyRevenue = (clone $ordersQuery)
            ->selectRaw('DATE(paid_at) as report_date')
            ->selectRaw('SUM(total) as revenue')
            ->groupBy(DB::raw('DATE(paid_at)'))
            ->orderBy('report_date')
            ->get()
            ->keyBy('report_date');

        $trend = collect();

        $period = Carbon::parse($startDate)->startOfDay();
        $lastDay = Carbon::parse($endDate)->startOfDay();

        while ($period->lte($lastDay)) {
            $date = $period->toDateString();

            $trend->push([
                'date' => $date,
                'label' => $period->format('d M'),
                'revenue' => (float) ($dailyRevenue[$date]->revenue ?? 0),
            ]);

            $period->addDay();
        }

        $maxDailyRevenue = max(
            1,
            (float) $trend->max('revenue')
        );

        // Menu terlaris berdasarkan pesanan lunas dan tanggal pembayaran.
        $bestSellingMenus = DB::table('order_items')
            ->join('orders', 'orders.id', '=', 'order_items.order_id')
            ->where('orders.payment_status', 'paid')
            ->whereNotNull('orders.paid_at')
            ->where('orders.status', '!=', 'cancelled')
            ->whereDate('orders.paid_at', '>=', $startDate)
            ->whereDate('orders.paid_at', '<=', $endDate)
            ->select('order_items.menu_name')
            ->selectRaw('SUM(order_items.quantity) as total_quantity')
            ->selectRaw('SUM(order_items.subtotal) as total_sales')
            ->groupBy('order_items.menu_name')
            ->orderByDesc('total_quantity')
            ->limit(10)
            ->get();

        return view('owner.reports.index', compact(
            'startDate',
            'endDate',
            'totalOrders',
            'paidOrders',
            'unpaidOrders',
            'totalRevenue',
            'averageTransaction',
            'trend',
            'maxDailyRevenue',
            'bestSellingMenus'
        ));
    }
}
