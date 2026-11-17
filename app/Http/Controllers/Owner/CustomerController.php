<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CustomerController extends Controller
{
    /**
     * Menampilkan daftar pelanggan berdasarkan riwayat pesanan.
     */
    public function index(Request $request): View
    {
        $query = Order::query()
            ->select('customer_name')
            ->selectRaw('COUNT(*) as orders_count')
            ->selectRaw('SUM(CASE WHEN payment_status = ? THEN total ELSE 0 END) as total_spent', ['paid'])
            ->selectRaw('MAX(created_at) as last_order_at')
            ->whereNotNull('customer_name')
            ->where('customer_name', '<>', '')
            ->groupBy('customer_name');

        if ($request->filled('search')) {
            $query->where('customer_name', 'like', '%' . $request->search . '%');
        }

        $customers = $query
            ->orderByDesc('last_order_at')
            ->paginate(10)
            ->withQueryString();

        $totalCustomers = Order::query()
            ->whereNotNull('customer_name')
            ->where('customer_name', '<>', '')
            ->distinct()
            ->count('customer_name');

        $totalCustomerOrders = Order::query()
            ->whereNotNull('customer_name')
            ->where('customer_name', '<>', '')
            ->count();

        return view('owner.customers.index', compact(
            'customers',
            'totalCustomers',
            'totalCustomerOrders'
        ));
    }

    /**
     * Menampilkan riwayat pesanan pelanggan.
     */
    public function show(string $customer): View
    {
        $orders = Order::with(['items', 'diningTable'])
            ->where('customer_name', $customer)
            ->latest('created_at')
            ->paginate(10);

        $totalOrders = Order::where('customer_name', $customer)->count();

        $totalSpent = Order::where('customer_name', $customer)
            ->where('payment_status', 'paid')
            ->sum('total');


        return view('owner.customers.show', compact(
            'customer',
            'orders',
            'totalOrders',
            'totalSpent'
        ));
    }

    /**
     * Menghapus identitas pelanggan tanpa menghapus riwayat transaksi.
     */
    public function destroy(string $customer)
    {
        $updated = Order::where('customer_name', $customer)
            ->update(['customer_name' => null]);

        if ($updated === 0) {
            return redirect()
                ->route('owner.customers.index')
                ->with('error', 'Pelanggan tidak ditemukan.');
        }

        return redirect()
            ->route('owner.customers.index')
            ->with('success', 'Nama pelanggan berhasil dihapus. Riwayat transaksi tetap tersimpan.');
    }
}
