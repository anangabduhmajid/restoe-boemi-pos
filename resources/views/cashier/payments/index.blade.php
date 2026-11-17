<x-cashier-layout page-title="Pembayaran" active="payments">

    <div class="mb-8 flex flex-wrap items-center justify-between gap-4">
        <div>
            <p class="text-sm text-[#8A7769]">Restoe Boemi / Workspace / Pembayaran</p>
            <h1 class="mt-1 text-2xl font-bold">Pembayaran Pesanan</h1>
            <p class="mt-2 text-sm text-[#76685E]">
                Kelola pesanan pelanggan yang belum menyelesaikan pembayaran.
            </p>
        </div>

        <a href="{{ route('cashier.orders.create') }}"
            class="rounded-lg bg-[#710014] px-5 py-3 text-sm font-semibold text-white transition hover:bg-[#570010]">
            + Buat Pesanan
        </a>
    </div>

    @if (session('success'))
    <div class="mb-6 rounded-xl border border-green-200 bg-green-50 px-5 py-4 text-sm text-green-800">
        {{ session('success') }}
    </div>
    @endif

    @if (session('error'))
    <div class="mb-6 rounded-xl border border-red-200 bg-red-50 px-5 py-4 text-sm text-red-800">
        {{ session('error') }}
    </div>
    @endif

    {{-- RINGKASAN --}}
    <section class="mb-8 grid grid-cols-1 gap-4 sm:grid-cols-3">

        <div class="rounded-xl border border-[#E5D6C3] border-t-2 border-t-[#710014] bg-white p-6">
            <p class="text-sm text-[#88796D]">Pesanan Belum Lunas</p>
            <p id="cashier-pending-count" class="mt-3 text-2xl font-bold">{{ number_format($totalUnpaid) }}</p>
            <p class="mt-2 text-xs text-[#88796D]">Pesanan menunggu pembayaran</p>
        </div>

        <div class="rounded-xl border border-[#E5D6C3] border-t-2 border-t-[#710014] bg-white p-6">
            <p class="text-sm text-[#88796D]">Total Tagihan</p>
            <p id="cashier-pending-total" class="mt-3 text-2xl font-bold">
                Rp{{ number_format((float) $totalReceivable, 0, ',', '.') }}
            </p>
            <p class="mt-2 text-xs text-[#88796D]">Akumulasi tagihan belum lunas</p>
        </div>

        <div class="rounded-xl border border-[#E5D6C3] border-t-2 border-t-[#710014] bg-white p-6">
            <p class="text-sm text-[#88796D]">Pembayaran Hari Ini</p>
            <p class="mt-3 text-2xl font-bold">
                Rp{{ number_format((float) $todayPaid, 0, ',', '.') }}
            </p>
            <p class="mt-2 text-xs text-[#88796D]">Total pesanan yang sudah lunas</p>
        </div>

    </section>

    {{-- DAFTAR PESANAN --}}
    <section class="overflow-hidden rounded-xl border border-[#E5D6C3] bg-white">

        <div class="flex flex-wrap items-center justify-between gap-4 border-b border-[#EEE5DA] px-6 py-5">
            <div>
                <h2 class="font-bold">Daftar Tagihan</h2>
                <p class="mt-1 text-xs text-[#88796D]">
                    Pilih pesanan untuk melihat detail dan memproses pembayaran.
                </p>
            </div>

            <form method="GET" action="{{ route('cashier.payments.index') }}"
                class="flex gap-2">
                <input type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Cari nomor / pelanggan..."
                    class="w-52 rounded-lg border border-[#E5D6C3] px-3 py-2 text-sm outline-none focus:border-[#710014]">

                <button type="submit"
                    class="rounded-lg bg-[#710014] px-4 py-2 text-sm font-semibold text-white hover:bg-[#570010]">
                    Cari
                </button>
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-[#FAF7F2] text-xs uppercase tracking-wider text-[#88796D]">
                    <tr>
                        <th class="px-6 py-4">Nomor Pesanan</th>
                        <th class="px-6 py-4">Pelanggan</th>
                        <th class="px-6 py-4">Tipe</th>
                        <th class="px-6 py-4">Metode Pembayaran</th>
                        <th class="px-6 py-4">Total Tagihan</th>
                        <th class="px-6 py-4">Waktu</th>
                        <th class="px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>

                <tbody
                    class="divide-y divide-[#EEE5DA]"
                    data-cashier-payment-list
                    data-cashier-payments-page="{{ $unpaidOrders->currentPage() }}"
                    data-cashier-payments-search="{{ request('search', '') }}">
                    @forelse ($unpaidOrders as $order)
                    <tr class="transition hover:bg-[#FCFAF7]" data-order-id="{{ $order->id }}">
                        <td class="whitespace-nowrap px-6 py-4 font-semibold">
                            {{ $order->order_number }}
                        </td>

                        <td class="whitespace-nowrap px-6 py-4">
                            {{ $order->customer_name ?: 'Pelanggan' }}
                        </td>

                        <td class="whitespace-nowrap px-6 py-4">
                            @if ($order->order_type === 'dine_in')
                            <span class="rounded-full bg-[#F5EFE6] px-3 py-1 text-xs font-medium">
                                Dine In
                            </span>
                            <p class="mt-1 text-xs text-[#88796D]">
                                Meja {{ $order->diningTable?->table_number ?? '-' }}
                            </p>
                            @else
                            <span class="rounded-full bg-[#F5EFE6] px-3 py-1 text-xs font-medium">
                                Takeaway
                            </span>
                            @endif
                        </td>
                        <td class="whitespace-nowrap px-6 py-4">
                            @php
                            $requestedMethod = $order->requested_payment_method;

                            $methodLabels = [
                            'cash' => 'Tunai',
                            'transfer' => 'Transfer Bank',
                            'qris' => 'QRIS',
                            'debit' => 'Kartu Debit',
                            ];
                            @endphp

                            @if ($requestedMethod)
                            <span class="rounded-full bg-[#F5EFE6] px-3 py-1.5 text-xs font-semibold text-[#710014]">
                                {{ $methodLabels[$requestedMethod] ?? strtoupper($requestedMethod) }}
                            </span>
                            @else
                            <span class="text-xs text-[#88796D]">
                                Belum ditentukan
                            </span>
                            @endif
                        </td>
                        <td class="whitespace-nowrap px-6 py-4 font-semibold">
                            Rp{{ number_format((float) $order->total, 0, ',', '.') }}
                        </td>

                        <td class="whitespace-nowrap px-6 py-4 text-[#88796D]">
                            {{ $order->created_at->format('d/m/Y H:i') }}
                        </td>

                        <td class="whitespace-nowrap px-6 py-4 text-right">
                            <a href="{{ route('cashier.payments.show', $order) }}"
                                class="inline-flex rounded-lg bg-[#710014] px-4 py-2 text-xs font-semibold text-white transition hover:bg-[#570010]">
                                Proses Pembayaran
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr data-empty-payment-row>
                        <td colspan="7" class="px-6 py-14 text-center">
                            <p class="font-semibold text-[#211D1A]">
                                Tidak ada tagihan
                            </p>
                            <p class="mt-2 text-sm text-[#88796D]">
                                Belum ada pesanan yang menunggu pembayaran.
                            </p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="border-t border-[#EEE5DA] px-6 py-4">
            {{ $unpaidOrders->links() }}
        </div>

    </section>

</x-cashier-layout>