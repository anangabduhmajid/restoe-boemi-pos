
<x-app-layout>
    <style>
        .customer-detail-page { max-width: 1440px; margin: 0 auto; color: #211D1A; }
        .customer-detail-card {
            background: #fff; border: 1px solid #E9DED2;
            border-radius: 16px; padding: 20px;
        }
        .customer-detail-table { width: 100%; border-collapse: collapse; }
        .customer-detail-table th {
            background: #FAF7F2; color: #81756B; text-align: left;
            padding: 14px 16px; font-size: 11px;
            text-transform: uppercase; letter-spacing: .05em;
        }
        .customer-detail-table td {
            padding: 15px 16px; border-top: 1px solid #F0E8DF;
            font-size: 13px;
        }
        .customer-status {
            display: inline-block; padding: 5px 9px; border-radius: 20px;
            font-size: 11px; font-weight: 700;
        }
        @media(max-width: 700px) {
            .customer-detail-table-wrap { overflow-x: auto; }
            .customer-detail-table { min-width: 720px; }
        }
    </style>

    <div class="customer-detail-page space-y-6">
        <div>
            <a href="{{ route('owner.customers.index') }}"
                class="text-sm font-semibold text-[#710014] hover:underline">
                ← Kembali ke Customers
            </a>

            <div class="mt-4">
                <p class="text-xs font-bold uppercase tracking-widest text-[#8A7768]">
                    Detail Pelanggan
                </p>
                <h1 class="text-2xl font-extrabold mt-1">{{ $customer }}</h1>
                <p class="text-sm text-[#81756B] mt-1">Riwayat transaksi dan pesanan pelanggan.</p>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div class="customer-detail-card">
                <p class="text-sm text-[#81756B]">Total Pesanan</p>
                <p class="text-2xl font-extrabold mt-2">
                    {{ number_format($totalOrders, 0, ',', '.') }}
                </p>
            </div>

            <div class="customer-detail-card">
                <p class="text-sm text-[#81756B]">Total Belanja Lunas</p>
                <p class="text-2xl font-extrabold text-[#710014] mt-2">
                    Rp {{ number_format($totalSpent, 0, ',', '.') }}
                </p>
            </div>
        </div>

        <div class="customer-detail-card !p-0 overflow-hidden">
            <div class="p-5">
                <h2 class="font-extrabold text-lg">Riwayat Pesanan</h2>
                <p class="text-xs text-[#81756B] mt-1">
                    Seluruh pesanan atas nama {{ $customer }}
                </p>
            </div>

            <div class="customer-detail-table-wrap">
                <table class="customer-detail-table">
                    <thead>
                        <tr>
                            <th>Nomor Pesanan</th>
                            <th>Tanggal</th>
                            <th>Meja / Tipe</th>
                            <th>Total</th>
                            <th>Pembayaran</th>
                            <th>Status Pesanan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($orders as $order)
                            <tr>
                                <td class="font-bold">{{ $order->order_number }}</td>
                                <td>
                                    {{ $order->created_at
                                        ? $order->created_at->format('d M Y, H:i')
                                        : '-' }}
                                </td>
                                <td>
                                    {{ $order->diningTable?->name
                                        ?? ($order->order_type === 'takeaway' ? 'Takeaway' : 'QR / Meja') }}
                                </td>
                                <td class="font-bold">
                                    Rp {{ number_format($order->total, 0, ',', '.') }}
                                </td>
                                <td>
                                    @if ($order->payment_status === 'paid')
                                        <span class="customer-status bg-green-100 text-green-700">Lunas</span>
                                    @else
                                        <span class="customer-status bg-yellow-100 text-yellow-700">Belum Lunas</span>
                                    @endif
                                </td>
                                <td>
                                    {{ ucfirst(str_replace('_', ' ', $order->status ?? '-')) }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-12 text-[#81756B]">
                                    Belum ada riwayat pesanan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($orders->hasPages())
                <div class="p-5 border-t border-[#F0E8DF]">
                    {{ $orders->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
