<x-cashier-layout page-title="Beranda">
            <div>
                <header class="mb-8 flex flex-wrap items-center justify-between gap-4">
                    <div>
                        <p class="text-sm text-[#8A7769]">Restoe Boemi / Workspace</p>
                        <h2 class="mt-1 text-2xl font-bold tracking-tight">Dashboard</h2>
                        <p class="mt-2 text-sm text-[#76685E]">
                            Selamat datang kembali, {{ auth()->user()->name }}.
                        </p>
                    </div>

                    <a href="{{ route('cashier.orders.create') }}"
                        class="inline-flex items-center rounded-lg bg-[#710014] px-5 py-3 text-sm font-semibold text-white transition hover:bg-[#570010]">
                        + Buat Pesanan
                    </a>
                </header>

                <!-- Date -->
                <div class="mb-5 flex items-center justify-between">
                    <h3 class="text-sm font-semibold uppercase tracking-wider text-[#76685E]">
                        Ringkasan Hari Ini
                    </h3>
                    <p class="text-sm text-[#76685E]">
                        {{ now()->translatedFormat('l, d F Y') }}
                    </p>
                </div>

                <!-- Statistics -->
                <section class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">

                    <div class="rounded-xl border border-[#E5D6C3] border-t-2 border-t-[#710014] bg-white p-6">
                        <p class="text-sm text-[#88796D]">Omzet Hari Ini</p>
                        <p class="mt-3 text-2xl font-bold">
                            Rp{{ number_format((float) $todayRevenue, 0, ',', '.') }}
                        </p>
                        <p class="mt-2 text-xs text-[#88796D]">Transaksi berstatus lunas</p>
                    </div>

                    <div class="rounded-xl border border-[#E5D6C3] border-t-2 border-t-[#710014] bg-white p-6">
                        <p class="text-sm text-[#88796D]">Total Transaksi</p>
                        <p class="mt-3 text-2xl font-bold">{{ $todayTransactions }}</p>
                        <p class="mt-2 text-xs text-[#88796D]">Pesanan dibuat hari ini</p>
                    </div>

                    <div class="rounded-xl border border-[#E5D6C3] border-t-2 border-t-[#710014] bg-white p-6">
                        <p class="text-sm text-[#88796D]">Pesanan Aktif</p>
                        <p class="mt-3 text-2xl font-bold">{{ $activeOrders }}</p>
                        <p class="mt-2 text-xs text-[#88796D]">Menunggu atau sedang diproses</p>
                    </div>

                    <div class="rounded-xl border border-[#E5D6C3] border-t-2 border-t-[#710014] bg-white p-6">
                        <p class="text-sm text-[#88796D]">Pesanan Selesai</p>
                        <p class="mt-3 text-2xl font-bold">{{ $completedOrders }}</p>
                        <p class="mt-2 text-xs text-[#88796D]">Selesai hari ini</p>
                    </div>

                </section>
                <!-- Table Status -->
                <section class="mt-8 overflow-hidden rounded-xl border border-[#E5D6C3] bg-white">

                    <div class="border-b border-[#EEE5DA] px-6 py-5">
                        <h3 class="font-bold">Status Meja</h3>
                        <p class="mt-1 text-xs text-[#88796D]">
                            Pantau ketersediaan meja dan kosongkan meja setelah pelanggan selesai.
                        </p>
                    </div>

                    @if (session('success'))
                    <div class="mx-6 mt-4 rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-800">
                        {{ session('success') }}
                    </div>
                    @endif

                    @if (session('error'))
                    <div role="alert" class="mx-6 mt-4 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800">
                        {{ session('error') }}
                    </div>
                    @endif

                    <div class="grid grid-cols-1 gap-4 p-6 sm:grid-cols-2 xl:grid-cols-3">
                        @forelse ($tables as $table)
                        @php
                        $tableStatus = [
                        'available' => ['Tersedia', 'bg-green-100 text-green-800'],
                        'occupied' => ['Terisi', 'bg-red-100 text-red-800'],
                        'reserved' => ['Dipesan', 'bg-amber-100 text-amber-800'],
                        'maintenance' => ['Maintenance', 'bg-gray-100 text-gray-700'],
                        ];

                        $statusInfo = $tableStatus[$table->status] ?? ['Tidak diketahui', 'bg-gray-100 text-gray-700'];
                        @endphp

                        <div class="rounded-xl border border-[#E5D6C3] bg-[#FAF7F2] p-5">
                            <div class="flex items-start justify-between gap-3">
                                <div>
                                    <p class="text-xs text-[#88796D]">Meja</p>
                                    <h4 class="mt-1 text-xl font-bold">
                                        {{ $table->table_number }}
                                    </h4>
                                    <p class="mt-1 text-xs text-[#88796D]">
                                        {{ $table->name ?: 'Meja Restoe Boemi' }}
                                        · Kapasitas {{ $table->capacity }} orang
                                    </p>
                                </div>

                                <span class="rounded-full px-3 py-1 text-xs font-semibold {{ $statusInfo[1] }}">
                                    {{ $statusInfo[0] }}
                                </span>
                            </div>

                            @if ($table->status === 'occupied')
                            <form action="{{ route('cashier.tables.clear', $table) }}"
                                method="POST"
                                class="mt-5"
                                data-confirm-title="Kosongkan meja?"
                                data-confirm-message="Yakin pelanggan sudah selesai dan meja '{{ $table->table_number }}' ingin dikosongkan?"
                                data-confirm-action="Kosongkan meja">
                                @csrf

                                <button type="submit"
                                    class="w-full rounded-lg bg-[#710014] px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-[#570010]">
                                    Kosongkan Meja
                                </button>
                            </form>
                            @endif
                        </div>
                        @empty
                        <div class="col-span-full py-8 text-center text-sm text-[#88796D]">
                            Belum ada meja yang terdaftar.
                        </div>
                        @endforelse
                    </div>
                </section>
                <!-- Recent Orders -->
                <section class="mt-8 overflow-hidden rounded-xl border border-[#E5D6C3] bg-white">

                    <div class="flex flex-wrap items-center justify-between gap-3 border-b border-[#EEE5DA] px-6 py-5">
                        <div>
                            <h3 class="font-bold">Pesanan Terbaru</h3>
                            <p class="mt-1 text-xs text-[#88796D]">Aktivitas pesanan yang masuk ke sistem</p>
                        </div>
                        <span class="text-xs text-[#88796D]">8 pesanan terakhir</span>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm">
                            <thead class="bg-[#FAF7F2] text-xs uppercase tracking-wider text-[#88796D]">
                                <tr>
                                    <th class="px-6 py-4 font-semibold">Nomor Pesanan</th>
                                    <th class="px-6 py-4 font-semibold">Pelanggan</th>
                                    <th class="px-6 py-4 font-semibold">Meja</th>
                                    <th class="px-6 py-4 font-semibold">Total</th>
                                    <th class="px-6 py-4 font-semibold">Status</th>
                                    <th class="px-6 py-4 font-semibold">Waktu</th>
                                </tr>
                            </thead>

                            <tbody class="divide-y divide-[#EEE5DA]">
                                @forelse ($recentOrders as $order)
                                <tr class="hover:bg-[#FCFAF7]">
                                    <td class="whitespace-nowrap px-6 py-4 font-semibold">
                                        {{ $order->order_number }}
                                    </td>
                                    <td class="whitespace-nowrap px-6 py-4">
                                        {{ $order->customer_name ?: 'Pelanggan' }}
                                    </td>
                                    <td class="whitespace-nowrap px-6 py-4">
                                        {{ $order->diningTable?->table_number ?? 'Takeaway' }}
                                    </td>
                                    <td class="whitespace-nowrap px-6 py-4">
                                        Rp{{ number_format((float) $order->total, 0, ',', '.') }}
                                    </td>
                                    <td class="whitespace-nowrap px-6 py-4">
                                        @php
                                        $statusLabels = [
                                        'new' => 'Baru',
                                        'preparing' => 'Diproses',
                                        'completed' => 'Selesai',
                                        'cancelled' => 'Dibatalkan',
                                        ];
                                        @endphp
                                        <span class="rounded-full bg-[#F5EFE6] px-3 py-1 text-xs font-medium">
                                            {{ $statusLabels[$order->status] ?? ucfirst($order->status) }}
                                        </span>
                                    </td>
                                    <td class="whitespace-nowrap px-6 py-4 text-[#88796D]">
                                        {{ $order->created_at->format('H:i') }}
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-12 text-center text-[#88796D]">
                                        Belum ada pesanan masuk.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </section>

                <footer class="mt-8 text-xs text-[#9A897B]">
                    RESTOE BOEMI POS · Cashier Workspace
                </footer>

            </div>
</x-cashier-layout>