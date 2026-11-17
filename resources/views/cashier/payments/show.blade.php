<x-cashier-layout page-title="Detail Pembayaran" active="payments">

    <div class="mx-auto max-w-5xl space-y-6">

        {{-- Tombol kembali --}}
        <a href="{{ route('cashier.payments.index') }}"
            class="inline-flex items-center gap-2 text-sm font-semibold text-[#710014] hover:underline">
            ← Kembali ke Daftar Pembayaran
        </a>

        {{-- Informasi pesanan --}}
        <div class="rounded-2xl border border-[#E8DCCF] bg-white p-6 shadow-sm">
            <div class="flex flex-wrap items-start justify-between gap-4">
                <div>
                    <p class="text-sm text-gray-500">Nomor Pesanan</p>
                    <h2 class="mt-1 text-2xl font-bold text-[#211D1A]">
                        {{ $order->order_number }}
                    </h2>
                </div>

                <span class="rounded-full bg-amber-100 px-4 py-2 text-sm font-semibold text-amber-800">
                    Belum Dibayar
                </span>
            </div>

            <div class="mt-6 grid gap-4 border-t border-[#E8DCCF] pt-5 sm:grid-cols-2 lg:grid-cols-4">
                <div>
                    <p class="text-xs text-gray-500">Nama Pelanggan</p>
                    <p class="mt-1 font-semibold text-[#211D1A]">
                        {{ $order->customer_name ?: 'Pelanggan Umum' }}
                    </p>
                </div>

                <div>
                    <p class="text-xs text-gray-500">Tipe Pesanan</p>
                    <p class="mt-1 font-semibold text-[#211D1A]">
                        {{ $order->order_type === 'dine_in' ? 'Makan di Tempat' : 'Takeaway' }}
                    </p>
                </div>

                <div>
                    <p class="text-xs text-gray-500">Nomor Meja</p>
                    <p class="mt-1 font-semibold text-[#211D1A]">
                        {{ $order->diningTable->table_number ?? '-' }}
                    </p>
                </div>
                <div>
                    <p class="text-xs text-[#8B8178]">Pilihan Pembayaran Pelanggan</p>

                    @php
                    $requestedMethods = [
                    'cash' => 'Tunai',
                    'transfer' => 'Transfer Bank',
                    'qris' => 'QRIS',
                    'debit' => 'Kartu Debit',
                    ];
                    @endphp

                    <p class="mt-1 font-semibold text-[#710014]">
                        {{ $requestedMethods[$order->requested_payment_method] ?? 'Belum ditentukan' }}
                    </p>
                </div>
                <div>
                    <p class="text-xs text-gray-500">Waktu Pesanan</p>
                    <p class="mt-1 font-semibold text-[#211D1A]">
                        {{ $order->ordered_at ? $order->ordered_at->format('d/m/Y H:i') : $order->created_at->format('d/m/Y H:i') }}
                    </p>
                </div>
            </div>
        </div>

        {{-- Daftar menu --}}
        <div class="overflow-hidden rounded-2xl border border-[#E8DCCF] bg-white shadow-sm">
            <div class="border-b border-[#E8DCCF] px-6 py-5">
                <h3 class="text-lg font-bold text-[#211D1A]">Rincian Pesanan</h3>
                <p class="mt-1 text-sm text-gray-500">Daftar menu yang dipesan pelanggan.</p>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead class="bg-[#F5EFE6] text-[#211D1A]">
                        <tr>
                            <th class="px-6 py-4 font-semibold">Menu</th>
                            <th class="px-6 py-4 text-right font-semibold">Harga</th>
                            <th class="px-6 py-4 text-center font-semibold">Jumlah</th>
                            <th class="px-6 py-4 text-right font-semibold">Subtotal</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-[#F0E8DF]">
                        @foreach ($order->items as $item)
                        <tr>
                            <td class="px-6 py-4">
                                <p class="font-semibold text-[#211D1A]">
                                    {{ $item->menu_name }}
                                </p>

                                @if ($item->notes)
                                <p class="mt-1 text-xs text-gray-500">
                                    Catatan: {{ $item->notes }}
                                </p>
                                @endif
                            </td>

                            <td class="whitespace-nowrap px-6 py-4 text-right text-gray-600">
                                Rp{{ number_format($item->price, 0, ',', '.') }}
                            </td>

                            <td class="px-6 py-4 text-center text-gray-600">
                                {{ $item->quantity }}
                            </td>

                            <td class="whitespace-nowrap px-6 py-4 text-right font-semibold text-[#211D1A]">
                                Rp{{ number_format($item->subtotal, 0, ',', '.') }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Total pembayaran --}}
            <div class="border-t border-[#E8DCCF] bg-[#FFFCF8] p-6">
                <div class="ml-auto max-w-sm space-y-3 text-sm">
                    <div class="flex justify-between text-gray-600">
                        <span>Subtotal</span>
                        <span>Rp{{ number_format($order->subtotal, 0, ',', '.') }}</span>
                    </div>

                    <div class="flex justify-between text-gray-600">
                        <span>Pajak</span>
                        <span>Rp{{ number_format($order->tax, 0, ',', '.') }}</span>
                    </div>

                    <div class="flex justify-between text-gray-600">
                        <span>Diskon</span>
                        <span>Rp{{ number_format($order->discount, 0, ',', '.') }}</span>
                    </div>

                    <div class="flex justify-between border-t border-[#E8DCCF] pt-4 text-lg font-bold text-[#710014]">
                        <span>Total Tagihan</span>
                        <span>Rp{{ number_format($order->total, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Form pembayaran --}}
        <form action="{{ route('cashier.payments.pay', $order) }}" method="POST"
            class="space-y-6 rounded-2xl border border-[#E8DCCF] bg-white p-6 shadow-sm"
            data-confirm-title="Konfirmasi pembayaran?"
            data-confirm-message="Pastikan pembayaran pesanan '{{ $order->order_number }}' sudah diterima sebelum melanjutkan."
            data-confirm-action="Konfirmasi"
            data-confirm-type="default">
            @csrf

            <div>
                <h3 class="text-lg font-bold text-[#211D1A]">Konfirmasi Pembayaran</h3>
                <p class="mt-1 text-sm text-gray-500">
                    Pilih metode pembayaran yang digunakan pelanggan.
                </p>
            </div>

            @if ($errors->any())
            <div class="rounded-xl border border-red-200 bg-red-50 p-4 text-sm text-red-700">
                <p class="font-semibold">Pembayaran belum dapat diproses:</p>
                <ul class="mt-2 list-inside list-disc">
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <div>
                <label for="payment_method" class="mb-2 block text-sm font-semibold text-[#211D1A]">
                    Metode Pembayaran Aktual
                </label>

                <p class="mb-3 text-xs text-[#8B8178]">
                    Sesuaikan dengan metode yang benar-benar digunakan pelanggan. Kasir boleh mengganti pilihan awal pelanggan.
                </p>

                <select name="payment_method" id="payment_method" required
                    class="w-full rounded-xl border border-[#D8C9B9] bg-white px-4 py-3 text-sm text-[#211D1A] outline-none focus:border-[#710014] focus:ring-2 focus:ring-[#710014]/10">
                    <option value="cash" @selected(old('payment_method', $order->requested_payment_method) === 'cash')>Tunai</option>
                    <option value="transfer" @selected(old('payment_method', $order->requested_payment_method) === 'transfer')>Transfer Bank</option>
                    <option value="qris" @selected(old('payment_method', $order->requested_payment_method) === 'qris')>QRIS</option>
                    <option value="debit" @selected(old('payment_method', $order->requested_payment_method) === 'debit')>Kartu Debit</option>
                </select>

                @error('payment_method')
                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Input uang tunai --}}
            <div id="cash-section" class="hidden space-y-3 rounded-xl bg-[#F5EFE6] p-5">
                <div>
                    <label for="cash_received" class="mb-2 block text-sm font-semibold text-[#211D1A]">
                        Uang Diterima
                    </label>

                    <input type="number" name="cash_received" id="cash_received"
                        min="0" step="1" value="{{ old('cash_received') }}"
                        placeholder="Masukkan jumlah uang yang diterima"
                        class="w-full rounded-xl border border-[#D8C9B9] bg-white px-4 py-3 text-sm outline-none focus:border-[#710014]">

                    @error('cash_received')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-between text-sm">
                    <span class="text-gray-600">Total Tagihan</span>
                    <span class="font-semibold text-[#211D1A]">
                        Rp{{ number_format($order->total, 0, ',', '.') }}
                    </span>
                </div>

                <div class="flex justify-between border-t border-[#D8C9B9] pt-3 text-sm">
                    <span class="font-semibold text-[#211D1A]">Kembalian</span>
                    <span id="change-display" class="font-bold text-[#710014]">Rp0</span>
                </div>
            </div>

            <div id="noncash-warning"
                class="hidden rounded-xl border border-blue-200 bg-blue-50 p-4 text-sm text-blue-800">
                Pastikan pembayaran sudah diterima atau berhasil diverifikasi sebelum menekan tombol konfirmasi.
            </div>

            <div class="flex flex-col-reverse justify-end gap-3 border-t border-[#E8DCCF] pt-5 sm:flex-row">
                <a href="{{ route('cashier.payments.index') }}"
                    class="rounded-xl border border-[#D8C9B9] px-6 py-3 text-center text-sm font-semibold text-[#211D1A] hover:bg-[#F5EFE6]">
                    Batal
                </a>

                <button type="submit"
                    class="rounded-xl bg-[#710014] px-6 py-3 text-sm font-semibold text-white transition hover:bg-[#560010]">
                    Konfirmasi Pembayaran
                </button>
            </div>
        </form>

    </div>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const method = document.getElementById('payment_method');
            const cashSection = document.getElementById('cash-section');
            const cashInput = document.getElementById('cash_received');
            const noncashWarning = document.getElementById('noncash-warning');
            const changeDisplay = document.getElementById('change-display');

            const total = Number(@json((float) $order->total));

            function formatRupiah(value) {
                return 'Rp' + Math.max(0, value).toLocaleString('id-ID');
            }

            function updatePaymentForm() {
                const isCash = method.value === 'cash';

                cashSection.classList.toggle('hidden', !isCash);

                noncashWarning.classList.toggle(
                    'hidden',
                    method.value === '' || isCash
                );

                cashInput.required = isCash;

                updateChange();
            }

            function updateChange() {
                const received = Number(cashInput.value) || 0;
                const change = received - total;

                changeDisplay.textContent = formatRupiah(change);

                changeDisplay.classList.toggle('text-red-600', change < 0);
                changeDisplay.classList.toggle('text-[#710014]', change >= 0);
            }

            method.addEventListener('change', updatePaymentForm);
            cashInput.addEventListener('input', updateChange);

            updatePaymentForm();
        });
    </script>


</x-cashier-layout>