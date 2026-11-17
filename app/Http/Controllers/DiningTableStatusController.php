<?php

namespace App\Http\Controllers;

use App\Models\DiningTable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;

class DiningTableStatusController extends Controller
{
    public function clear(DiningTable $table): RedirectResponse
    {
        $result = DB::transaction(function () use ($table) {
            $lockedTable = DiningTable::whereKey($table->id)
                ->lockForUpdate()
                ->firstOrFail();

            if ($lockedTable->status !== 'occupied') {
                return 'not_occupied';
            }

            $hasActiveOrders = $lockedTable->id
                ? DB::table('orders')
                    ->where('dining_table_id', $lockedTable->id)
                    ->where('order_type', 'dine_in')
                    ->where('status', '!=', 'cancelled')
                    ->where(function ($query) {
                        $query->where('payment_status', '!=', 'paid')
                            ->orWhere('status', '!=', 'completed');
                    })
                    ->exists()
                : false;

            if ($hasActiveOrders) {
                return 'active_orders';
            }

            $lockedTable->update([
                'status' => 'available',
            ]);

            return 'cleared';
        });

        if ($result === 'active_orders') {
            return back()->with(
                'error',
                'Meja belum bisa dikosongkan karena masih ada pesanan yang belum dibayar atau belum selesai diproses.'
            );
        }

        if ($result === 'not_occupied') {
            return back()->with(
                'error',
                'Meja ini tidak sedang berstatus terisi.'
            );
        }

        return back()->with(
            'success',
            'Meja ' . $table->table_number . ' berhasil dikosongkan dan sekarang tersedia.'
        );
    }
}
