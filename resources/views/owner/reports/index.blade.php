
<x-app-layout>
    <style>
        .reports-page {
            max-width: 1440px;
            margin: 0 auto;
            color: #211D1A;
        }

        .reports-card {
            background: #fff;
            border: 1px solid #E9DED2;
            border-radius: 16px;
            padding: 20px;
        }

        .reports-label {
            color: #81756B;
            font-size: 13px;
        }

        .reports-value {
            font-size: 26px;
            font-weight: 800;
            margin-top: 9px;
            color: #211D1A;
        }

        .reports-input {
            width: 100%;
            border: 1px solid #E5D9CC;
            border-radius: 10px;
            padding: 10px 12px;
            background: #fff;
            outline: none;
            color: #211D1A;
        }

        .reports-input:focus {
            border-color: #710014;
        }

        .reports-table {
            width: 100%;
            border-collapse: collapse;
        }

        .reports-table th {
            background: #FAF7F2;
            color: #81756B;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: .05em;
            text-align: left;
            padding: 14px 16px;
        }

        .reports-table td {
            padding: 15px 16px;
            border-top: 1px solid #F0E8DF;
            font-size: 13px;
        }

        .reports-bar-track {
            height: 9px;
            background: #F2EAE2;
            border-radius: 20px;
            overflow: hidden;
        }

        .reports-bar {
            height: 100%;
            background: #710014;
            border-radius: 20px;
            min-width: 2px;
        }

        .reports-chart-wrap {
            display: flex;
            flex-direction: column;
            gap: 17px;
        }

        .report-print-header {
            display: none;
        }

        @media(max-width: 700px) {
            .reports-table-wrap {
                overflow-x: auto;
            }

            .reports-table {
                min-width: 600px;
            }

            .reports-value {
                font-size: 22px;
            }
        }

        /* Pengaturan khusus cetak */
        @media print {
            @page {
                size: A4 portrait;
                margin: 14mm;
            }

            body * {
                visibility: hidden !important;
            }

            #reports-print-area,
            #reports-print-area * {
                visibility: visible !important;
            }

            #reports-print-area {
                position: absolute !important;
                left: 0 !important;
                top: 0 !important;
                width: 100% !important;
                max-width: none !important;
                margin: 0 !important;
                padding: 0 !important;
            }

            .reports-no-print {
                display: none !important;
            }

            .report-print-header {
                display: block !important;
                text-align: center;
                margin-bottom: 24px;
                padding-bottom: 18px;
                border-bottom: 2px solid #710014;
            }

            body {
                background: #ffffff !important;
                color: #211D1A !important;
            }

            .reports-card {
                box-shadow: none !important;
                break-inside: avoid;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }

            .reports-table-wrap {
                overflow: visible !important;
            }

            .reports-table {
                width: 100% !important;
                min-width: 0 !important;
            }

            .reports-table th {
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }

            .reports-bar,
            .reports-bar-track {
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
        }
    </style>

    <div id="reports-print-area" class="reports-page space-y-6">

        {{-- Header khusus cetak --}}
        <div class="report-print-header">
            <p class="text-sm font-bold tracking-widest text-[#710014]">
                RESTOE BOEMI
            </p>

            <h1 class="mt-2 text-2xl font-extrabold">
                LAPORAN PENJUALAN
            </h1>

            <p class="mt-2 text-sm">
                Periode:
                {{ \Carbon\Carbon::parse($startDate)->format('d M Y') }}
                -
                {{ \Carbon\Carbon::parse($endDate)->format('d M Y') }}
            </p>

            <p class="mt-1 text-xs text-gray-500">
                Dicetak: {{ now()->format('d M Y H:i') }} WIB
            </p>
        </div>

        {{-- Header halaman --}}
        <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4 reports-no-print">
            <div>
                <p class="text-xs font-bold uppercase tracking-widest text-[#8A7768]">
                    Business Analytics
                </p>

                <h1 class="text-2xl font-extrabold mt-1">
                    Reports
                </h1>

                <p class="text-sm text-[#81756B] mt-1">
                    Pantau performa penjualan dan perkembangan bisnis Restoe Boemi.
                </p>
            </div>

            <button
                type="button"
                onclick="window.print()"
                class="inline-flex items-center justify-center gap-2 rounded-lg bg-[#710014] px-5 py-3 text-sm font-bold text-white hover:bg-[#570010]">
                Cetak Laporan
            </button>
        </div>

        {{-- Filter periode --}}
        <div class="reports-card reports-no-print">
            <form method="GET"
                action="{{ route('owner.reports.index') }}"
                class="grid grid-cols-1 sm:grid-cols-3 gap-4 items-end">

                <div>
                    <label class="block text-xs font-bold text-[#81756B] mb-2">
                        Tanggal Mulai
                    </label>

                    <input
                        type="date"
                        name="start_date"
                        value="{{ $startDate }}"
                        class="reports-input">
                </div>

                <div>
                    <label class="block text-xs font-bold text-[#81756B] mb-2">
                        Tanggal Akhir
                    </label>

                    <input
                        type="date"
                        name="end_date"
                        value="{{ $endDate }}"
                        class="reports-input">
                </div>

                <div class="flex gap-2">
                    <button
                        type="submit"
                        class="flex-1 rounded-lg bg-[#710014] px-4 py-3 text-sm font-bold text-white hover:bg-[#570010]">
                        Terapkan
                    </button>

                    <a
                        href="{{ route('owner.reports.index') }}"
                        class="rounded-lg border border-[#E5D9CC] px-4 py-3 text-sm font-semibold text-[#5E5148] hover:bg-[#FAF7F2]">
                        Reset
                    </a>
                </div>
            </form>

            <p class="text-xs text-[#8A7768] mt-3">
                Periode:
                {{ \Illuminate\Support\Carbon::parse($startDate)->format('d M Y') }}
                -
                {{ \Illuminate\Support\Carbon::parse($endDate)->format('d M Y') }}
            </p>
        </div>

        {{-- Summary cards --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4">

            <div class="reports-card">
                <p class="reports-label">Total Omzet</p>

                <p class="reports-value text-[#710014]">
                    Rp {{ number_format($totalRevenue, 0, ',', '.') }}
                </p>

                <p class="text-xs text-[#8A7768] mt-2">
                    Dari pembayaran lunas
                </p>
            </div>

            <div class="reports-card">
                <p class="reports-label">Total Pesanan</p>

                <p class="reports-value">
                    {{ number_format($totalOrders, 0, ',', '.') }}
                </p>

                <p class="text-xs text-[#8A7768] mt-2">
                    Jumlah transaksi yang sudah lunas
                </p>
            </div>

            <div class="reports-card">
                <p class="reports-label">Pesanan Lunas</p>

                <p class="reports-value text-green-700">
                    {{ number_format($paidOrders, 0, ',', '.') }}
                </p>

                <p class="text-xs text-[#8A7768] mt-2">
                    Pembayaran berhasil
                </p>
            </div>

            <div class="reports-card">
                <p class="reports-label">Belum Dibayar</p>

                <p class="reports-value text-amber-600">
                    {{ number_format($unpaidOrders, 0, ',', '.') }}
                </p>

                <p class="text-xs text-[#8A7768] mt-2">
                    Pesanan belum lunas
                </p>
            </div>

        </div>

        {{-- Average transaction --}}
        <div class="reports-card flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <p class="text-sm font-bold">
                    Rata-rata Nilai Transaksi
                </p>

                <p class="text-xs text-[#81756B] mt-1">
                    Rata-rata omzet per pesanan yang sudah lunas.
                </p>
            </div>

            <p class="text-xl font-extrabold text-[#710014]">
                Rp {{ number_format($averageTransaction, 0, ',', '.') }}
            </p>
        </div>

        {{-- Revenue trend --}}
        <div class="reports-card">
            <div class="mb-6">
                <h2 class="text-lg font-extrabold">
                    Tren Pendapatan Harian
                </h2>

                <p class="text-xs text-[#81756B] mt-1">
                    Omzet per hari berdasarkan transaksi lunas.
                </p>
            </div>

            @if ($trend->isEmpty())
                <div class="py-10 text-center text-sm text-[#81756B]">
                    Belum ada data pendapatan pada periode ini.
                </div>
            @else
                <div class="reports-chart-wrap">
                    @foreach ($trend as $day)
                        @php
                            $percentage = $maxDailyRevenue > 0
                                ? ($day['revenue'] / $maxDailyRevenue) * 100
                                : 0;
                        @endphp

                        <div class="grid grid-cols-1 sm:grid-cols-[75px_1fr_150px] gap-2 sm:items-center">
                            <p class="text-xs font-semibold text-[#81756B]">
                                {{ $day['label'] }}
                            </p>

                            <div class="reports-bar-track">
                                <div
                                    class="reports-bar"
                                    style="width: {{ $percentage }}%">
                                </div>
                            </div>

                            <p class="text-xs font-bold sm:text-right">
                                Rp {{ number_format($day['revenue'], 0, ',', '.') }}
                            </p>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        {{-- Best selling menus --}}
        <div class="reports-card !p-0 overflow-hidden">
            <div class="p-5">
                <h2 class="text-lg font-extrabold">
                    Menu Terlaris
                </h2>

                <p class="text-xs text-[#81756B] mt-1">
                    Maksimal 10 menu berdasarkan jumlah item yang terjual dan sudah dibayar.
                </p>
            </div>

            <div class="reports-table-wrap">
                <table class="reports-table">
                    <thead>
                        <tr>
                            <th>Peringkat</th>
                            <th>Nama Menu</th>
                            <th>Jumlah Terjual</th>
                            <th>Total Penjualan</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($bestSellingMenus as $index => $menu)
                            <tr>
                                <td class="font-bold text-[#710014]">
                                    #{{ $index + 1 }}
                                </td>

                                <td class="font-semibold">
                                    {{ $menu->menu_name }}
                                </td>

                                <td>
                                    {{ number_format($menu->total_quantity, 0, ',', '.') }}
                                    item
                                </td>

                                <td class="font-bold">
                                    Rp {{ number_format($menu->total_sales, 0, ',', '.') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-10 text-[#81756B]">
                                    Belum ada data penjualan menu yang lunas pada periode ini.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Footer laporan --}}
        <p class="text-xs text-[#8A7768] text-center pb-4">
            Laporan Restoe Boemi | Omzet dihitung dari pesanan berstatus paid.
        </p>

    </div>
</x-app-layout>
