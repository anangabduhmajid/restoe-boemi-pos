
<x-app-layout>
    <div class="mx-auto max-w-5xl space-y-6">

        {{-- Header --}}
        <div>
            <a href="{{ route('owner.orders.index') }}"
                class="text-sm text-gray-500 hover:text-gray-900">
                ← Kembali ke Orders
            </a>

            <div class="mt-3 flex flex-col justify-between gap-3 sm:flex-row sm:items-center">
                <div>
                    <p class="text-sm uppercase tracking-widest text-amber-800">
                        Order Detail
                    </p>
                    <h1 class="mt-1 text-2xl font-bold text-gray-900">
                        {{ $order->order_number }}
                    </h1>
                    <p class="mt-1 text-sm text-gray-500">
                        {{ $order->created_at->format('d F Y, H:i') }}
                    </p>
                </div>

                @php
                    $statusLabels = [
                        'new' => 'Baru',
                        'preparing' => 'Disiapkan',
                        'completed' => 'Selesai',
                        'cancelled' => 'Dibatalkan',
                    ];

                    $statusStyles = [
                        'new' => 'bg-blue-100 text-blue-800',
                        'preparing' => 'bg-amber-100 text-amber-800',
                        'completed' => 'bg-green-100 text-green-800',
                        'cancelled' => 'bg-red-100 text-red-800',
                    ];
                @endphp

                <span class="inline-flex w-fit rounded-full px-4 py-2 text-sm font-semibold {{ $statusStyles[$order->status] ?? 'bg-gray-100 text-gray-700' }}">
                    {{ $statusLabels[$order->status] ?? ucfirst($order->status) }}
                </span>
            </div>
        </div>

        {{-- Informasi Pesanan --}}
        <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
            <div class="rounded-xl border border-gray-200 bg-white p-5">
                <h2 class="mb-4 font-semibold text-gray-900">
                    Informasi Pelanggan
                </h2>

                <div class="space-y-3 text-sm">
                    <div class="flex justify-between gap-4">
                        <span class="text-gray-500">Nama</span>
                        <span class="font-medium text-gray-900">
                            {{ $order->customer_name ?? 'Pelanggan' }}
                        </span>
                    </div>

                    <div class="flex justify-between gap-4">
                        <span class="text-gray-500">Tipe Pesanan</span>
                        <span class="font-medium text-gray-900">
                            {{ ucfirst(str_replace('_', ' ', $order->order_type)) }}
                        </span>
                    </div>

                    <div class="flex justify-between gap-4">
                        <span class="text-gray-500">Meja</span>
                        <span class="font-medium text-gray-900">
                            {{ $order->diningTable?->table_number ?? 'Tidak ada meja' }}
                        </span>
                    </div>
                </div>
            </div>

            <div class="rounded-xl border border-gray-200 bg-white p-5">
                <h2 class="mb-4 font-semibold text-gray-900">
                    Informasi Pembayaran
                </h2>

                <div class="space-y-3 text-sm">
                    <div class="flex justify-between gap-4">
                        <span class="text-gray-500">Metode</span>
                        <span class="font-medium text-gray-900">
                            {{ $order->payment_method ? strtoupper($order->payment_method) : 'Belum ditentukan' }}
                        </span>
                    </div>

                    <div class="flex justify-between gap-4">
                        <span class="text-gray-500">Status</span>
                        <span class="font-medium text-gray-900">
                            {{ ucfirst($order->payment_status) }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Detail Item --}}
        <div class="overflow-hidden rounded-xl border border-gray-200 bg-white">
            <div class="border-b border-gray-200 px-5 py-4">
                <h2 class="font-semibold text-gray-900">
                    Item Pesanan
                </h2>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead class="bg-gray-50 text-left text-xs uppercase text-gray-500">
                        <tr>
                            <th class="px-5 py-3">Menu</th>
                            <th class="px-5 py-3 text-right">Harga</th>
                            <th class="px-5 py-3 text-center">Jumlah</th>
                            <th class="px-5 py-3 text-right">Subtotal</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-100">
                        @forelse ($order->items as $item)
                            <tr>
                                <td class="px-5 py-4">
                                    <p class="font-medium text-gray-900">
                                        {{ $item->menu_name }}
                                    </p>

                                    @if ($item->notes)
                                        <p class="mt-1 text-xs text-gray-500">
                                            Catatan: {{ $item->notes }}
                                        </p>
                                    @endif
                                </td>

                                <td class="whitespace-nowrap px-5 py-4 text-right text-gray-600">
                                    Rp{{ number_format((float) $item->price, 0, ',', '.') }}
                                </td>

                                <td class="px-5 py-4 text-center text-gray-600">
                                    {{ $item->quantity }}
                                </td>

                                <td class="whitespace-nowrap px-5 py-4 text-right font-medium text-gray-900">
                                    Rp{{ number_format((float) $item->subtotal, 0, ',', '.') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-5 py-8 text-center text-gray-500">
                                    Belum ada item pesanan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Ringkasan Harga --}}
            <div class="border-t border-gray-200 bg-gray-50 p-5">
                <div class="ml-auto max-w-sm space-y-3 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-500">Subtotal</span>
                        <span class="text-gray-900">
                            Rp{{ number_format((float) $order->subtotal, 0, ',', '.') }}
                        </span>
                    </div>

                    <div class="flex justify-between">
                        <span class="text-gray-500">Pajak</span>
                        <span class="text-gray-900">
                            Rp{{ number_format((float) $order->tax, 0, ',', '.') }}
                        </span>
                    </div>

                    <div class="flex justify-between">
                        <span class="text-gray-500">Diskon</span>
                        <span class="text-gray-900">
                            Rp{{ number_format((float) $order->discount, 0, ',', '.') }}
                        </span>
                    </div>

                    <div class="flex justify-between border-t border-gray-300 pt-3 text-base font-bold">
                        <span>Total Pembayaran</span>
                        <span class="text-gray-900">
                            Rp{{ number_format((float) $order->total, 0, ',', '.') }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Catatan --}}
        @if ($order->notes)
            <div class="rounded-xl border border-gray-200 bg-white p-5">
                <h2 class="font-semibold text-gray-900">Catatan Pesanan</h2>
                <p class="mt-2 text-sm text-gray-600">
                    {{ $order->notes }}
                </p>
            </div>
        @endif

    </div>
</x-app-layout>
