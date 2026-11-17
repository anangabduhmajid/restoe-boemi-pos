<x-app-layout>
    <style>
        .customers-page {
            max-width: 1440px;
            margin: 0 auto;
            color: #211D1A;
        }

        .customers-card {
            background: #fff;
            border: 1px solid #E9DED2;
            border-radius: 16px;
            padding: 20px;
        }

        .customers-stat-label {
            color: #81756B;
            font-size: 13px;
        }

        .customers-stat-value {
            font-size: 26px;
            font-weight: 750;
            margin-top: 8px;
        }

        .customers-input {
            width: 100%;
            border: 1px solid #E5D9CC;
            border-radius: 10px;
            padding: 11px 14px;
            background: #fff;
            outline: none;
        }

        .customers-input:focus {
            border-color: #710014;
        }

        .customers-table {
            width: 100%;
            border-collapse: collapse;
        }

        .customers-table th {
            color: #81756B;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: .06em;
            font-weight: 700;
            text-align: left;
            padding: 14px 16px;
            background: #FAF7F2;
        }

        .customers-table td {
            padding: 16px;
            border-top: 1px solid #F0E8DF;
            font-size: 13px;
            vertical-align: middle;
        }

        .customers-link {
            color: #710014;
            font-weight: 700;
            text-decoration: none;
        }

        .customers-link:hover {
            text-decoration: underline;
        }

        .customers-avatar {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #F3E6E4;
            color: #710014;
            font-weight: 800;
            flex-shrink: 0;
        }

        @media(max-width: 700px) {
            .customers-table-wrap {
                overflow-x: auto;
            }

            .customers-table {
                min-width: 700px;
            }

            .customers-stat-value {
                font-size: 22px;
            }
        }
    </style>

    <div class="customers-page space-y-6">
        @if (session('success'))
        <div class="p-4 rounded-lg bg-green-50 border border-green-200 text-green-800 text-sm font-semibold">
            {{ session('success') }}
        </div>
        @endif

        @if (session('error'))
        <div class="p-4 rounded-lg bg-red-50 border border-red-200 text-red-800 text-sm font-semibold">
            {{ session('error') }}
        </div>
        @endif
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <p class="text-xs font-bold uppercase tracking-widest text-[#8A7768]">Database Pelanggan</p>
                <h1 class="text-2xl font-extrabold mt-1">Customers</h1>
                <p class="text-sm text-[#81756B] mt-1">
                    Kenali pelanggan dan lihat riwayat pesanan mereka.
                </p>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div class="customers-card">
                <p class="customers-stat-label">Total Pelanggan</p>
                <p class="customers-stat-value">{{ number_format($totalCustomers, 0, ',', '.') }}</p>
                <p class="text-xs text-[#8A7768] mt-2">Nama pelanggan unik yang pernah memesan</p>
            </div>

            <div class="customers-card">
                <p class="customers-stat-label">Total Pesanan Pelanggan</p>
                <p class="customers-stat-value">{{ number_format($totalCustomerOrders, 0, ',', '.') }}</p>
                <p class="text-xs text-[#8A7768] mt-2">Seluruh pesanan dengan nama pelanggan</p>
            </div>
        </div>

        <div class="customers-card">
            <form method="GET" action="{{ route('owner.customers.index') }}"
                class="flex flex-col sm:flex-row gap-3">
                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Cari nama pelanggan..."
                    class="customers-input">

                <div class="flex gap-2">
                    <button type="submit"
                        class="px-5 py-3 rounded-lg bg-[#710014] text-white text-sm font-bold hover:bg-[#570010]">
                        Cari
                    </button>

                    <a href="{{ route('owner.customers.index') }}"
                        class="px-5 py-3 rounded-lg border border-[#E5D9CC] text-sm font-semibold text-[#5E5148] hover:bg-[#FAF7F2]">
                        Reset
                    </a>
                </div>
            </form>
        </div>

        <div class="customers-card !p-0 overflow-hidden">
            <div class="p-5 flex items-center justify-between gap-3">
                <div>
                    <h2 class="font-extrabold text-lg">Daftar Pelanggan</h2>
                    <p class="text-xs text-[#81756B] mt-1">Data berdasarkan nama pada pesanan</p>
                </div>
                <span class="text-xs font-semibold text-[#81756B]">
                    {{ $customers->total() }} pelanggan
                </span>
            </div>

            <div class="customers-table-wrap">
                <table class="customers-table">
                    <thead>
                        <tr>
                            <th>Pelanggan</th>
                            <th>Jumlah Pesanan</th>
                            <th>Total Belanja Lunas</th>
                            <th>Pesanan Terakhir</th>
                            <th class="text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($customers as $customer)
                        <tr>
                            <td>
                                <div class="flex items-center gap-3">
                                    <div class="customers-avatar">
                                        {{ strtoupper(substr($customer->customer_name, 0, 1)) }}
                                    </div>
                                    <span class="font-bold">{{ $customer->customer_name }}</span>
                                </div>
                            </td>
                            <td>{{ number_format($customer->orders_count, 0, ',', '.') }} pesanan</td>
                            <td class="font-bold text-[#710014]">
                                Rp {{ number_format($customer->total_spent, 0, ',', '.') }}
                            </td>
                            <td>
                                {{ $customer->last_order_at
                                        ? \Illuminate\Support\Carbon::parse($customer->last_order_at)->format('d M Y, H:i')
                                        : '-' }}
                            </td>

                            <td class="text-right">
                                <div class="flex items-center justify-end gap-4">
                                    <a href="{{ route('owner.customers.show', ['customer' => $customer->customer_name]) }}"
                                        class="customers-link">
                                        Detail →
                                    </a>

                                    <form method="POST"
                                        action="{{ route('owner.customers.destroy', ['customer' => $customer->customer_name]) }}"
                                        onsubmit="return confirm('Yakin ingin menghapus pelanggan ini dari daftar? Riwayat transaksi tetap tersimpan, tetapi nama pelanggan pada transaksi akan dikosongkan.');">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                            class="text-red-700 font-bold hover:text-red-900">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>

                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-12">
                                <p class="font-bold text-[#5E5148]">Belum ada data pelanggan</p>
                                <p class="text-xs text-[#8A7768] mt-1">
                                    Pelanggan akan muncul setelah ada pesanan dengan nama pelanggan.
                                </p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($customers->hasPages())
            <div class="p-5 border-t border-[#F0E8DF]">
                {{ $customers->links() }}
            </div>
            @endif
        </div>
    </div>
</x-app-layout>