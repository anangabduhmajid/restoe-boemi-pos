<x-kitchen-layout page-title="Pesanan Dapur" active="dashboard">

        @if (session('success'))
        <div class="mb-6 rounded-lg border border-green-200 bg-green-50 px-5 py-3 text-sm text-green-800">
            {{ session('success') }}
        </div>
        @endif

        <div class="mb-8">
            <p class="text-xs font-semibold uppercase tracking-[0.2em] text-[#8B6B52]">
                Kitchen Operations
            </p>
            <h2 class="mt-2 text-3xl font-bold">Pesanan Dapur</h2>
            <p class="mt-2 text-sm text-[#76543A]">
                Kelola pesanan yang sedang menunggu dan diproses.
            </p>
        </div>

        {{-- SUMMARY --}}
        <div class="mb-8 grid grid-cols-1 gap-4 sm:grid-cols-3">

            <div class="rounded-2xl border border-[#F0E6D8] bg-white p-4">
                <p class="text-sm text-[#76543A]">Pesanan Baru</p>
                <p class="mt-2 text-3xl font-bold">{{ $newOrders }}</p>
            </div>

            <div class="rounded-2xl border border-[#F0E6D8] bg-white p-4">
                <p class="text-sm text-[#76543A]">Sedang Dimasak</p>
                <p class="mt-2 text-3xl font-bold">{{ $preparingOrders }}</p>
            </div>

            <div class="rounded-2xl border border-[#F0E6D8] bg-white p-4">
                <p class="text-sm text-[#76543A]">Selesai Hari Ini</p>
                <p class="mt-2 text-3xl font-bold">{{ $completedToday }}</p>
            </div>

        </div>


        {{-- ACTIVE ORDERS --}}
        <div class="mb-5">
            <h3 class="text-xl font-bold">Pesanan Aktif</h3>
            <p class="mt-1 text-sm text-[#76543A]">
                Pantau pesanan baru dan pesanan yang sedang diproses.
            </p>
        </div>

        <div class="grid grid-cols-1 gap-4 lg:grid-cols-2">
            {{-- PESANAN BARU --}}
            <section>
                <div class="mb-4 flex items-center justify-between">
                    <h3 class="font-bold">Pesanan Baru</h3>
                    <span class="rounded-full bg-amber-100 px-3 py-1 text-xs font-bold text-amber-800">
                        {{ $newOrdersList->count() }} Pesanan
                    </span>
                </div>

                <div class="space-y-4">
                    @forelse ($newOrdersList as $order)
                    <div
                        data-new-order-id="{{ $order->id }}"
                        class="overflow-hidden rounded-2xl border border-[#F0E6D8] bg-white shadow-sm">
                        <div class="flex items-center justify-between border-b border-[#F0E6D8] px-4 py-3">
                            <div>
                                <p class="font-bold">{{ $order->order_number }}</p>

                                <div class="mt-2 flex flex-wrap items-center gap-2">
                                    <span class="rounded-full px-3 py-1 text-xs font-bold
                {{ $order->order_type === 'dine_in'
                    ? 'bg-[#F5EFE6] text-[#710014]'
                    : 'bg-purple-100 text-purple-800' }}">
                                        {{ $order->order_type === 'dine_in' ? 'DINE IN' : 'TAKEAWAY' }}
                                    </span>
                                    <span class="rounded-full px-3 py-1 text-xs font-bold
    {{ $order->user_id === null
        ? 'bg-blue-100 text-blue-800'
        : 'bg-green-100 text-green-800' }}">
                                        {{ $order->user_id === null ? 'QR MENU' : 'KASIR' }}
                                    </span>
                                    @php
                                    $orderTime = $order->ordered_at ?? $order->created_at;
                                    $waitingMinutes = (int) $orderTime->diffInMinutes(now());
                                    @endphp

                                    <div class="flex flex-wrap items-center gap-2">
                                        <span class="text-xs text-[#76543A]">
                                            {{ $orderTime->format('H:i') }}
                                        </span>

                                        <span class="rounded-full px-2 py-1 text-[10px] font-extrabold
        {{ $waitingMinutes >= 20
            ? 'bg-red-100 text-red-800'
            : ($waitingMinutes >= 10
                ? 'bg-amber-100 text-amber-800'
                : 'bg-green-100 text-green-800') }}">
                                            {{ $waitingMinutes }} MENIT
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <span class="rounded-full bg-amber-100 px-3 py-1 text-xs font-bold text-amber-800">
                                BARU
                            </span>
                        </div>

                        <div class="p-4">
                            <div class="mb-3 grid grid-cols-2 gap-3 text-sm">
                                <p>Pelanggan: <strong>{{ $order->customer_name ?: 'Pelanggan' }}</strong></p>
                                <p>Meja: <strong>{{ $order->diningTable?->table_number ?? '-' }}</strong></p>
                            </div>

                            <div class="space-y-2 border-t border-[#F0E6D8] pt-3">
                                @foreach ($order->items as $item)
                                <div class="flex justify-between gap-3 text-base font-bold">
                                    <span>{{ $item->menu_name }}</span>
                                    <strong class="shrink-0">x{{ $item->quantity }}</strong>
                                </div>

                                @if ($item->notes)
                                <p class="text-[11px] italic text-pink-700">
                                    Catatan: {{ $item->notes }}
                                </p>
                                @endif
                                @endforeach
                                @if ($order->notes)
                                <p class="text-[11px] italic text-pink-700">
                                    Catatan Pesanan: {{ $order->notes }}
                                </p>
                                @endif
                            </div>

                            <form method="POST"
                                action="{{ route('kitchen.orders.start', $order) }}"
                                class="mt-5">
                                @csrf
                                @method('PATCH')

                                <button type="submit"
                                    class="h-12 w-full rounded-xl bg-[#6B0F0F] px-4 text-sm font-bold text-white hover:bg-[#4A0D0D]">
                                    MULAI DIMASAK
                                </button>
                            </form>
                        </div>
                    </div>
                    @empty
                    <div class="rounded-xl border border-dashed border-[#D8C5AF] bg-white p-8 text-center">
                        <p class="font-semibold">Tidak ada pesanan baru</p>
                        <p class="mt-1 text-xs text-[#76543A]">
                            Pesanan dari kasir akan muncul di sini.
                        </p>
                    </div>
                    @endforelse
                </div>
            </section>

            {{-- SEDANG DIMASAK --}}
            <section>
                <div class="mb-4 flex items-center justify-between">
                    <h3 class="font-bold">Sedang Dimasak</h3>
                    <span class="rounded-full bg-blue-100 px-3 py-1 text-xs font-bold text-blue-800">
                        {{ $preparingOrdersList->count() }} Pesanan
                    </span>
                </div>

                <div class="space-y-4">
                    @forelse ($preparingOrdersList as $order)
                    <div class="overflow-hidden rounded-2xl border border-[#F0E6D8] bg-white shadow-sm">

                        <div class="flex items-center justify-between border-b border-[#F0E6D8] px-4 py-3">
                            <div>
                                <p class="font-bold">{{ $order->order_number }}</p>

                                <div class="mt-2 flex flex-wrap items-center gap-2">
                                    <span class="rounded-full px-3 py-1 text-xs font-bold
                {{ $order->order_type === 'dine_in'
                    ? 'bg-[#F5EFE6] text-[#710014]'
                    : 'bg-purple-100 text-purple-800' }}">
                                        {{ $order->order_type === 'dine_in' ? 'DINE IN' : 'TAKEAWAY' }}
                                    </span>
                                    <span class="rounded-full px-3 py-1 text-xs font-bold
    {{ $order->user_id === null
        ? 'bg-blue-100 text-blue-800'
        : 'bg-green-100 text-green-800' }}">
                                        {{ $order->user_id === null ? 'QR MENU' : 'KASIR' }}
                                    </span>

                                    @php
                                    $orderTime = $order->ordered_at ?? $order->created_at;
                                    $waitingMinutes = (int) $orderTime->diffInMinutes(now());
                                    @endphp

                                    <div class="flex flex-wrap items-center gap-2">
                                        <span class="text-xs text-[#76543A]">
                                            {{ $orderTime->format('H:i') }}
                                        </span>

                                        <span class="rounded-full px-2 py-1 text-[10px] font-extrabold
        {{ $waitingMinutes >= 20
            ? 'bg-red-100 text-red-800'
            : ($waitingMinutes >= 10
                ? 'bg-amber-100 text-amber-800'
                : 'bg-green-100 text-green-800') }}">
                                            {{ $waitingMinutes }} MENIT
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <span class="rounded-full bg-blue-100 px-3 py-1 text-xs font-bold text-blue-800">
                                DIMASAK
                            </span>
                        </div>
                        <div class="p-4">
                            <div class="mb-3 grid grid-cols-2 gap-3 text-sm">
                                <p>Pelanggan: <strong>{{ $order->customer_name ?: 'Pelanggan' }}</strong></p>
                                <p>Meja: <strong>{{ $order->diningTable?->table_number ?? '-' }}</strong></p>
                            </div>

                            <div class="space-y-2 border-t border-[#F0E6D8] pt-3">
                                @foreach ($order->items as $item)
                                <div class="flex justify-between gap-3 text-base font-bold">
                                    <span>{{ $item->menu_name }}</span>
                                    <strong class="shrink-0">x{{ $item->quantity }}</strong>
                                </div>

                                @if ($item->notes)
                                <p class="text-[11px] italic text-pink-700">
                                    Catatan: {{ $item->notes }}
                                </p>
                                @endif
                                @endforeach
                                @if ($order->notes)
                                <p class="text-[11px] italic text-pink-700">
                                    Catatan Pesanan: {{ $order->notes }}
                                </p>
                                @endif
                            </div>

                            <form method="POST"
                                action="{{ route('kitchen.orders.complete', $order) }}"
                                class="mt-5">
                                @csrf
                                @method('PATCH')

                                <button type="submit"
                                    class="h-12 w-full rounded-xl bg-[#1E7A34] px-4 text-sm font-bold text-white hover:bg-green-800">
                                    SELESAIKAN PESANAN
                                </button>
                            </form>
                        </div>
                    </div>
                    @empty
                    <div class="rounded-xl border border-dashed border-[#D8C5AF] bg-white p-8 text-center">
                        <p class="font-semibold">Belum ada pesanan yang dimasak</p>
                        <p class="mt-1 text-xs text-[#76543A]">
                            Pesanan yang mulai diproses akan muncul di sini.
                        </p>
                    </div>
                    @endforelse
                </div>
            </section>

        </div>

    <script>
        const currentOrderIds = Array.from(
            document.querySelectorAll('[data-new-order-id]')
        ).map(element => element.dataset.newOrderId);

        const storageKey = 'restoe_boemi_kitchen_order_ids';
        const previousOrderIds = JSON.parse(
            sessionStorage.getItem(storageKey) || 'null'
        );

        // Simpan ID pesanan pertama kali tanpa membunyikan alarm.
        if (previousOrderIds === null) {
            sessionStorage.setItem(storageKey, JSON.stringify(currentOrderIds));
        } else {
            const newOrders = currentOrderIds.filter(
                id => !previousOrderIds.includes(id)
            );

            if (newOrders.length > 0) {
                console.log('Pesanan baru masuk:', newOrders);

                try {
                    const audioContext = new(
                        window.AudioContext || window.webkitAudioContext
                    )();

                    const oscillator = audioContext.createOscillator();
                    const gainNode = audioContext.createGain();

                    oscillator.connect(gainNode);
                    gainNode.connect(audioContext.destination);

                    oscillator.type = 'sine';
                    oscillator.frequency.setValueAtTime(880, audioContext.currentTime);

                    gainNode.gain.setValueAtTime(0.3, audioContext.currentTime);
                    gainNode.gain.exponentialRampToValueAtTime(
                        0.01,
                        audioContext.currentTime + 0.5
                    );

                    oscillator.start();
                    oscillator.stop(audioContext.currentTime + 0.5);
                } catch (error) {
                    console.log('Suara notifikasi tidak dapat diputar:', error);
                }
            }

            sessionStorage.setItem(storageKey, JSON.stringify(currentOrderIds));
        }

        // Perbarui tampilan Kitchen setiap 5 detik.
        setInterval(function() {
            window.location.reload();
        }, 5000);
    </script>
    </x-kitchen-layout>