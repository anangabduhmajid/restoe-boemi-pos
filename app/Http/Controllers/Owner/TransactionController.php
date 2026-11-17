<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TransactionController extends Controller
{
    public function index(Request $request): View
    {
        $query = Order::query()
            ->with(['diningTable', 'items'])
            ->latest('created_at');

        if ($request->filled('payment_status')) {
            $query->where('payment_status', $request->payment_status);
        }

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('order_number', 'like', "%{$search}%")
                    ->orWhere('customer_name', 'like', "%{$search}%");
            });
        }

        if ($request->filled('payment_method')) {
            $query->where('payment_method', $request->payment_method);
        }

        $transactions = $query->paginate(10)->withQueryString();

        $totalTransactions = Order::count();

        $paidTransactions = Order::where('payment_status', 'paid')->count();

        $unpaidTransactions = Order::where('payment_status', 'unpaid')->count();

        $totalRevenue = Order::where('payment_status', 'paid')->sum('total');

        return view('owner.transactions.index', compact(
            'transactions',
            'totalTransactions',
            'paidTransactions',
            'unpaidTransactions',
            'totalRevenue'
        ));
    }

    public function show(Order $order): View
    {
        $order->load(['diningTable', 'items', 'user']);

        return view('owner.transactions.show', compact('order'));
    }
}
