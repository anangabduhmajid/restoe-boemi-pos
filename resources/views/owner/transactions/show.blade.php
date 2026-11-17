
<x-app-layout>
    <div class="mx-auto max-w-5xl space-y-6 text-[#211a17]">

        <div class="flex flex-wrap items-start justify-between gap-4 border-b border-[#ded7ce] pb-5">
            <div>
                <p class="mb-2 text-[10px] font-bold uppercase tracking-[.14em] text-[#710014]">
                    Keuangan / Transactions
                </p>
                <h1 class="font-serif text-3xl">Detail Transaksi</h1>
                <p class="mt-2 text-sm text-[#806e61]">
                    {{ $order->order_number }}
                </p>
            </div>

            <a href="{{ route('owner.transactions.index') }}"
                class="rounded border border-[#710014] px-4 py-2 text-xs font-bold text-[#710014] hover:bg-[#710014] hover:text-white">
                Kembali
            </a>
        </div>

        <section class="grid gap-4 sm:grid-cols-2">
            <div class="rounded-lg border border-[#ded7ce] border-t-[3px] border-t-[#710014] bg-[#fffdf9] p-5">
                <p class="text-[10px] font-bold uppercase tracking-wider text-[#806e61]">
                    Total Transaksi
                </p>
                <p class="mt-2 font-serif text-2xl font-bold text-[#710014]">
                    Rp {{ number_format((float) $order->total, 0, ',', '.') }}
                </p>
            </div>

            <div class="rounded-lg border border-[#ded7ce] border-t-[3px] border-t-[#806e61] bg-[#fffdf9] p-5">
                <p class="text-[10px] font-bold uppercase tracking-wider text-[#806e61]">
                    Status Pembayaran
                </p>
                <p class="mt-2 text-xl font-bold">
                    {{ ucfirst($order->payment_status ?? 'Belum dibayar') }}
                </p>
                <p class="mt-1 text-xs text-[#806e61]">
                    Metode: {{ $order->payment_method ? strtoupper($order->payment_method) : 'Belum ditentukan' }}
                </p>
            </div>
        </section>

        <section class="rounded-lg border border-[#ded7ce] bg-[#fffdf9]">
            <div class="border-b border-[#ded7ce] bg-[#f5efe6] px-5 py-4">
                <h2 class="font-serif text-lg">Informasi Pesanan</h2>
            </div>

            <div class="grid gap-5 p-5 sm:grid-cols-2">
                <div>
                    <p class="text-[10px] uppercase tracking-wider text-[#806e61]">Pelanggan</p>
                    <p class="mt-1 text-sm font-semibold">
                        {{ $order->customer_name ?: 'Pelanggan' }}
                    </p>
                </div>

                <div>
                    <p class="text-[10px] uppercase tracking-wider text-[#806e61]">Nomor Pesanan</p>
                    <p class="mt-1 text-sm font-semibold">{{ $order->order_number }}</p>
                </div>

                <div>
                    <p class="text-[10px] uppercase tracking-wider text-[#806e61]">Tanggal Pesanan</p>
                    <p class="mt-1 text-sm font-semibold">
                        {{ ($order->ordered_at ?? $order->created_at)?->format('d/m/Y H:i') ?? '-' }}
                    </p>
                </div>

                <div>
                    <p class="text-[10px] uppercase tracking-wider text-[#806e61]">Meja</p>
                    <p class="mt-1 text-sm font-semibold">
                        {{ $order->diningTable?->table_number
                            ? 'Meja ' . $order->diningTable->table_number
                            : ($order->order_type === 'takeaway' ? 'Take Away' : 'Tidak ditentukan') }}
                    </p>
                </div>

                <div>
                    <p class="text-[10px] uppercase tracking-wider text-[#806e61]">Tipe Pesanan</p>
                    <p class="mt-1 text-sm font-semibold">
                        {{ $order->order_type === 'dine_in' ? 'Dine In' : ucfirst(str_replace('_', ' ', $order->order_type)) }}
                    </p>
                </div>

                <div>
                    <p class="text-[10px] uppercase tracking-wider text-[#806e61]">Status Pesanan</p>
                    <p class="mt-1 text-sm font-semibold">{{ ucfirst($order->status) }}</p>
                </div>
            </div>
        </section>

        <section class="overflow-hidden rounded-lg border border-[#ded7ce] bg-[#fffdf9]">
            <div class="border-b border-[#ded7ce] bg-[#f5efe6] px-5 py-4">
                <h2 class="font-serif text-lg">Rincian Item</h2>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full min-w-[540px] text-left">
                    <thead class="bg-[#fffaf2] text-[9px] uppercase tracking-wider text-[#806e61]">
                        <tr>
                            <th class="px-5 py-3">Menu</th>
                            <th class="px-5 py-3 text-center">Jumlah</th>
                            <th class="px-5 py-3 text-right">Harga</th>
                            <th class="px-5 py-3 text-right">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($order->items as $item)
                            <tr class="border-t border-[#eee9e2] text-xs">
                                <td class="px-5 py-4 font-semibold">{{ $item->menu_name }}</td>
                                <td class="px-5 py-4 text-center">{{ $item->quantity }}</td>
                                <td class="px-5 py-4 text-right whitespace-nowrap">
                                    Rp {{ number_format((float) $item->price, 0, ',', '.') }}
                                </td>
                                <td class="px-5 py-4 text-right font-semibold whitespace-nowrap">
                                    Rp {{ number_format((float) $item->subtotal, 0, ',', '.') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-5 py-8 text-center text-xs text-[#806e61]">
                                    Tidak ada item pada pesanan ini.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="border-t border-[#ded7ce] p-5">
                <div class="ml-auto grid max-w-xs gap-3 text-xs">
                    <div class="flex justify-between gap-4">
                        <span class="text-[#806e61]">Subtotal</span>
                        <span>Rp {{ number_format((float) $order->subtotal, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between gap-4">
                        <span class="text-[#806e61]">Pajak</span>
                        <span>Rp {{ number_format((float) $order->tax, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between gap-4">
                        <span class="text-[#806e61]">Diskon</span>
                        <span>Rp {{ number_format((float) $order->discount, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between gap-4 border-t border-[#ded7ce] pt-3 text-base font-bold text-[#710014]">
                        <span>Total</span>
                        <span>Rp {{ number_format((float) $order->total, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>
        </section>

        @if ($order->notes)
            <section class="rounded-lg border border-[#ded7ce] bg-[#fffdf9] p-5">
                <h2 class="font-serif text-lg">Catatan Pesanan</h2>
                <p class="mt-2 text-sm text-[#55504c]">{{ $order->notes }}</p>
            </section>
        @endif
    </div>
</x-app-layout>
