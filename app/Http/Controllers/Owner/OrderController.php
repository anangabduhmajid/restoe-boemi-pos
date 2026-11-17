<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with(['diningTable', 'items'])
            ->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('order_number', 'like', "%{$search}%")
                    ->orWhere('customer_name', 'like', "%{$search}%");
            });
        }

        $orders = $query->paginate(10)->withQueryString();

        $totalOrders = Order::count();
        $newOrders = Order::where('status', 'new')->count();
        $processingOrders = Order::where('status', 'preparing')->count();
        $completedOrders = Order::where('status', 'completed')->count();

        return view('owner.orders.index', compact(
            'orders',
            'totalOrders',
            'newOrders',
            'processingOrders',
            'completedOrders'
        ));
    }

    // Menampilkan detail pesanan
    public function show(Order $order)
    {
        $order->load(['diningTable', 'user', 'items.menu']);

        return view('owner.orders.show', compact('order'));
    }
}
