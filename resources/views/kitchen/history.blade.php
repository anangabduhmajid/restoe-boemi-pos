<x-kitchen-layout page-title="Riwayat Pesanan" active="history">

        <div class="mb-8 flex flex-wrap items-center justify-between gap-4">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.2em] text-[#8B6B52]">
                    Kitchen Operations
                </p>
                <h2 class="mt-2 text-3xl font-bold">Riwayat Pesanan</h2>
                <p class="mt-2 text-sm text-[#76543A]">
                    Daftar pesanan yang sudah selesai diproses dapur.
                </p>
            </div>

            <a href="{{ route('kitchen.dashboard') }}"
                class="inline-flex h-12 items-center justify-center rounded-full bg-[#6B0F0F] px-6 text-sm font-bold text-white hover:bg-[#4A0D0D]">
                KEMBALI KE DAPUR
            </a>
        </div>

        @if (session('success'))
        <div class="mb-6 rounded-lg border border-green-200 bg-green-50 px-5 py-3 text-sm text-green-800">
            {{ session('success') }}
        </div>
        @endif

        <div class="overflow-hidden rounded-2xl border border-[#F0E6D8] bg-white">

            <div class="border-b border-[#F0E6D8] px-5 py-4">
                <h3 class="font-bold">Pesanan Selesai</h3>
                <p class="mt-1 text-xs text-[#76543A]">
                    Total {{ $orders->total() }} pesanan
                </p>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full min-w-[1050px] table-fixed text-left text-xs lg:min-w-0">
                    <colgroup>
                        <col style="width: 13%">
                        <col style="width: 13%">
                        <col style="width: 9%">
                        <col style="width: 9%">
                        <col style="width: 6%">
                        <col style="width: 25%">
                        <col style="width: 8%">
                        <col style="width: 10%">
                        <col style="width: 7%">
                    </colgroup>
                    <thead class="bg-[#F9F1E8] text-[10px] font-bold uppercase tracking-wider text-[#76543A]">
                        <tr>
                            <th class="px-2 py-4">Nomor Pesanan</th>
                            <th class="px-2 py-4">Pelanggan</th>
                            <th class="px-2 py-4">Sumber</th>
                            <th class="px-2 py-4">Jenis</th>
                            <th class="px-2 py-4">Meja</th>
                            <th class="px-2 py-4">Menu</th>
                            <th class="px-2 py-4">Total</th>
                            <th class="px-2 py-4">Waktu Selesai</th>
                            <th class="px-2 py-4">Status</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-[#E5D6C3]">

                        @forelse ($orders as $order)
                        <tr>
                            <td class="break-all px-2 py-4 font-bold">
                                {{ $order->order_number }}
                            </td>

                            <td class="break-words px-2 py-4">
                                {{ $order->customer_name ?: 'Pelanggan' }}
                            </td>
                            <td class="px-2 py-4">
                                <span class="whitespace-nowrap rounded-full px-2 py-1 text-[9px] font-bold
        {{ $order->user_id === null
            ? 'bg-blue-100 text-blue-800'
            : 'bg-green-100 text-green-800' }}">
                                    {{ $order->user_id === null ? 'QR MENU' : 'KASIR' }}
                                </span>
                            </td>

                            <td class="px-2 py-4">
                                <span class="whitespace-nowrap rounded-full px-2 py-1 text-[9px] font-bold
        {{ $order->order_type === 'dine_in'
            ? 'bg-[#F5EFE6] text-[#710014]'
            : 'bg-purple-100 text-purple-800' }}">
                                    {{ $order->order_type === 'dine_in' ? 'DINE IN' : 'TAKEAWAY' }}
                                </span>
                            </td>

                            <td class="px-2 py-4">
                                {{ $order->diningTable?->table_number ?? '-' }}
                            </td>

                            <td class="break-words px-2 py-4">
                                <div class="space-y-1">
                                @foreach ($order->items as $item)
                                    <div>
                                    <p class="text-xs font-semibold leading-snug">
                                        {{ $item->menu_name }}
                                        <span class="whitespace-nowrap text-[#8B6B52]">x{{ $item->quantity }}</span>
                                    </p>

                                    @if ($item->notes)
                                    <p class="text-[10px] italic text-pink-700">
                                        Catatan: {{ $item->notes }}
                                    </p>
                                    @endif
                                    </div>
                                @endforeach
                                @if ($order->notes)
                                <p class="text-[10px] italic text-pink-700">
                                    Catatan Pesanan: {{ $order->notes }}
                                </p>
                                @endif
                                </div>
                            </td>

                            <td class="whitespace-nowrap px-2 py-4 font-semibold">
                                Rp{{ number_format((float) $order->total, 0, ',', '.') }}
                            </td>

                            <td class="px-2 py-4">
                                {{ $order->completed_at?->format('d/m/Y H:i') ?? '-' }}
                            </td>

                            <td class="px-2 py-4">
                                <span class="whitespace-nowrap rounded-full bg-green-100 px-2 py-1 text-[9px] font-bold text-green-800">
                                    SELESAI
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="px-5 py-14 text-center">
                                <p class="font-bold">Belum ada riwayat pesanan</p>
                                <p class="mt-2 text-xs text-[#76543A]">
                                    Pesanan yang selesai diproses akan muncul di sini.
                                </p>
                            </td>
                        </tr>
                        @endforelse

                    </tbody>
                </table>
            </div>

            @if ($orders->hasPages())
            <div class="border-t border-[#E5D6C3] px-5 py-4">
                {{ $orders->links() }}
            </div>
            @endif

        </div>

</x-kitchen-layout>