<x-cashier-layout page-title="Point of Sale">

            {{-- SUCCESS POPUP --}}
            @if (session('success'))
            <div id="successModal"
                role="dialog"
                aria-modal="true"
                aria-labelledby="successModalTitle"
                style="position:fixed;inset:0;z-index:9999;display:flex;align-items:center;justify-content:center;padding:16px;background:rgba(22,16,17,.72);backdrop-filter:blur(4px);">

                <div style="width:100%;max-width:440px;max-height:calc(100vh - 32px);overflow-y:auto;border:1px solid #E5D6C3;border-radius:20px;background:#FAF8F4;box-shadow:0 24px 70px rgba(0,0,0,.35);">
                    <div style="height:8px;background:#710014;"></div>

                    <div style="padding:32px 28px;text-align:center;">
                        <div style="display:flex;width:72px;height:72px;margin:0 auto;align-items:center;justify-content:center;border-radius:50%;background:#DCFCE7;">
                            <svg style="width:36px;height:36px;color:#15803D;"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2.5"
                                    d="M5 13l4 4L19 7" />
                            </svg>
                        </div>

                        <p style="margin:22px 0 0;color:#8B5B3E;font-size:11px;font-weight:700;letter-spacing:.24em;text-transform:uppercase;">
                            Restoe Boemi POS
                        </p>

                        <h2 id="successModalTitle" style="margin:10px 0 0;color:#211D1A;font-size:26px;font-weight:800;line-height:1.2;">
                            Pesanan Berhasil!
                        </h2>

                        <p style="margin:10px 0 0;color:#70665E;font-size:14px;line-height:1.6;">
                            Pesanan telah berhasil disimpan ke dalam sistem.
                        </p>

                        <div style="margin-top:24px;padding:18px 20px;border:1px solid #E5D6C3;border-radius:12px;background:#F2EBE1;">
                            <p style="margin:0;color:#70665E;font-size:10px;font-weight:700;letter-spacing:.2em;text-transform:uppercase;">
                                Nomor Pesanan
                            </p>

                            <p style="margin:8px 0 0;overflow-wrap:anywhere;color:#710014;font-size:19px;font-weight:900;letter-spacing:.04em;">
                                {{ session('success') }}
                            </p>
                        </div>

                        <div style="display:flex;margin-top:18px;align-items:center;justify-content:center;gap:8px;color:#15803D;font-size:12px;font-weight:600;">
                            <span style="width:8px;height:8px;border-radius:50%;background:#16A34A;"></span>
                            Tersimpan di database
                        </div>

                        <button type="button"
                            onclick="document.getElementById('successModal').remove()"
                            style="width:100%;margin-top:26px;padding:14px 20px;border:0;border-radius:10px;background:#710014;color:#fff;font-size:13px;font-weight:800;letter-spacing:.08em;cursor:pointer;"
                            onmouseover="this.style.backgroundColor='#52000F'"
                            onmouseout="this.style.backgroundColor='#710014'">
                            LANJUTKAN KE POS
                        </button>

                    </div>
                </div>
            </div>
            @endif

            <div>

                {{-- PAGE TITLE --}}
                <div class="mb-7 flex flex-col justify-between gap-3 sm:flex-row sm:items-end">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-[0.25em] text-[#710014]">
                            Kasir / Pesanan
                        </p>
                        <h1 class="mt-2 text-3xl font-bold tracking-tight">
                            Buat Pesanan
                        </h1>
                        <p class="mt-2 text-sm text-stone-500">
                            Pilih menu, atur pesanan, dan siapkan transaksi pelanggan.
                        </p>
                    </div>

                    <div class="rounded-lg border border-[#E5D6C3] bg-white px-4 py-3">
                        <p class="text-[10px] uppercase tracking-widest text-stone-500">Tanggal operasional</p>
                        <p class="mt-1 text-sm font-semibold">{{ now()->translatedFormat('l, d F Y') }}</p>
                    </div>
                </div>

                {{-- CONTENT GRID --}}
                <div class="grid grid-cols-1 items-start gap-6 xl:grid-cols-[minmax(0,1fr)_370px]">

                    {{-- MENU AREA --}}
                    <section class="min-w-0 xl:h-[calc(100vh-140px)] xl:overflow-y-auto xl:overscroll-contain">

                        {{-- SEARCH --}}
                        <div class="mb-5 flex flex-col gap-3 sm:flex-row">
                            <div class="relative flex-1">
                                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-stone-400">⌕</span>
                                <input
                                    id="menuSearch"
                                    type="search"
                                    placeholder="Cari nama menu..."
                                    class="w-full rounded-lg border-[#e2d9ce] bg-white py-3 pl-11 pr-4 text-sm focus:border-[#710014] focus:ring-[#710014]">
                            </div>
                            <div class="flex items-center rounded-lg border border-[#e2d9ce] bg-white px-4 text-sm text-stone-500">
                                {{ $menus->count() }} menu tersedia
                            </div>
                        </div>

                        {{-- CATEGORY FILTER --}}
                        <div class="mb-6">
                            <div class="flex gap-2 overflow-x-auto pb-2">
                                <button type="button"
                                    data-category="all"
                                    class="category-button shrink-0 rounded-lg bg-[#710014] px-4 py-2.5 text-xs font-semibold text-white">
                                    Semua Menu
                                </button>

                                @foreach ($categories as $category)
                                <button type="button"
                                    data-category="{{ $category->id }}"
                                    class="category-button shrink-0 rounded-lg border border-[#e2d9ce] bg-white px-4 py-2.5 text-xs font-medium text-stone-600 hover:border-[#710014]">
                                    {{ $category->name }}
                                </button>
                                @endforeach
                            </div>
                        </div>

                        {{-- MENU LIST --}}
                        <div class="mb-4 flex items-center justify-between">
                            <h3 class="font-bold">Daftar Menu</h3>
                            <span class="text-xs text-stone-400">Pilih menu untuk menambahkan</span>
                        </div>

                        <div id="menuGrid" class="grid grid-cols-1 gap-4 sm:grid-cols-2 2xl:grid-cols-3">

                            @forelse ($menus as $menu)
                            <button type="button"
                                class="menu-card group overflow-hidden rounded-xl border border-[#E5D6C3] bg-white text-left transition hover:-translate-y-0.5 hover:border-[#710014] hover:shadow-md"
                                data-id="{{ $menu->id }}"
                                data-name="{{ $menu->name }}"
                                data-price="{{ $menu->price }}"
                                data-category="{{ $menu->category_id }}">

                                <div class="relative h-40 overflow-hidden bg-[#e9e0d4]">
                                    @if ($menu->image_path)
                                    <img
                                        src="{{ asset('storage/' . $menu->image_path) }}"
                                        alt="{{ $menu->name }}"
                                        class="h-full w-full object-cover transition duration-300 group-hover:scale-105">
                                    @else
                                    <div class="flex h-full items-center justify-center text-4xl text-[#710014]">
                                        ☕
                                    </div>
                                    @endif

                                    <span class="absolute right-3 top-3 rounded bg-[#710014]/90 px-2.5 py-1 text-[10px] font-medium text-white">
                                        {{ $menu->category->name ?? 'Menu' }}
                                    </span>
                                </div>

                                <div class="p-4">
                                    <h4 class="font-semibold text-[#211D1A]">
                                        {{ $menu->name }}
                                    </h4>

                                    <div class="mt-4 flex items-center justify-between">
                                        <span class="text-sm font-bold text-[#710014]">
                                            Rp {{ number_format($menu->price, 0, ',', '.') }}
                                        </span>
                                        <span class="flex h-8 w-8 items-center justify-center rounded-full bg-[#f5e9eb] text-lg text-[#710014] transition group-hover:bg-[#710014] group-hover:text-white">
                                            +
                                        </span>
                                    </div>
                                </div>
                            </button>
                            @empty
                            <div class="rounded-xl border border-dashed border-[#d8cbbd] p-12 text-center sm:col-span-2 2xl:col-span-3">
                                <p class="font-semibold text-stone-600">Belum ada menu tersedia</p>
                                <p class="mt-1 text-sm text-stone-400">Tambahkan menu melalui akun owner.</p>
                            </div>
                            @endforelse

                        </div>

                        <div id="noSearchResult" class="hidden rounded-xl border border-dashed border-[#d8cbbd] p-10 text-center text-sm text-stone-500">
                            Menu tidak ditemukan.
                        </div>

                    </section>

                    {{-- ORDER PANEL --}}
                    <aside class="rounded-xl border border-[#e3d9cd] bg-white xl:sticky xl:top-6 xl:h-[calc(100vh-140px)] xl:overflow-y-auto xl:overscroll-contain">

                        <div class="border-b border-[#560010] bg-[#710014] px-5 py-5 text-[#F5EFE6]">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-[10px] font-semibold uppercase tracking-[0.25em] text-[#E8CFC2]">
                                        Pesanan Aktif
                                    </p>
                                    <h3 class="mt-1 text-xl font-bold text-white">Keranjang</h3>
                                </div>
                                <span id="cartCount" class="rounded-full bg-[#F5EFE6] px-3 py-1 text-xs font-bold text-[#710014]">0 item</span>
                            </div>
                        </div>

                        <div class="space-y-4 p-5">

                            <div>
                                <label class="mb-2 block text-xs font-semibold text-stone-600">
                                    Nama pelanggan
                                </label>
                                <input id="customerName" type="text"
                                    placeholder="Nama pelanggan (opsional)"
                                    class="w-full rounded-lg border-[#e2d9ce] bg-white text-sm focus:border-[#710014] focus:ring-[#710014]">
                            </div>

                            <div>
                                <label class="mb-2 block text-xs font-semibold text-stone-600">
                                    Tipe pesanan
                                </label>
                                <select id="orderType"
                                    class="w-full rounded-lg border-[#e2d9ce] bg-white text-sm focus:border-[#710014] focus:ring-[#710014]">
                                    <option value="dine_in">Makan di tempat</option>
                                    <option value="takeaway">Bawa pulang</option>
                                </select>
                            </div>

                            <div id="tableWrapper">
                                <label class="mb-2 block text-xs font-semibold text-stone-600">
                                    Nomor meja
                                </label>
                                <select id="diningTable"
                                    class="w-full rounded-lg border-[#e2d9ce] bg-white text-sm focus:border-[#710014] focus:ring-[#710014]">
                                    <option value="">Pilih meja</option>
                                    @foreach ($tables as $table)
                                    <option value="{{ $table->id }}">
                                        {{ $table->table_number }}
                                        {{ $table->name ? '· ' . $table->name : '' }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>

                        </div>

                        <div class="border-y border-[#e9e0d5] px-5 py-4">
                            <div class="mb-4 flex items-center justify-between">
                                <h4 class="text-sm font-bold">Item Pesanan</h4>
                                <button type="button" id="clearCart"
                                    class="text-xs font-semibold text-[#710014] hover:underline">
                                    Kosongkan
                                </button>
                            </div>

                            <div id="cartItems" class="space-y-4">
                                <div id="emptyCart" class="py-10 text-center">
                                    <div class="text-3xl text-[#c7b8a7]">▤</div>
                                    <p class="mt-3 text-sm font-medium text-stone-500">Belum ada pesanan</p>
                                    <p class="mt-1 text-xs text-stone-400">Pilih menu dari katalog</p>
                                </div>
                            </div>
                        </div>

                        <div class="space-y-3 p-5">
                            <div class="flex justify-between text-sm text-stone-500">
                                <span>Jumlah item</span>
                                <span id="summaryQuantity">0</span>
                            </div>

                            <div class="flex justify-between text-sm text-stone-500">
                                <span>Subtotal</span>
                                <span id="cartSubtotal">Rp 0</span>
                            </div>

                            <div class="border-t border-dashed border-[#d9cdbf] pt-4">
                                <div class="flex items-center justify-between">
                                    <span class="font-bold">Total pembayaran</span>
                                    <span id="cartTotal" class="text-xl font-black text-[#710014]">Rp 0</span>
                                </div>
                            </div>

                            <button type="button" id="submitOrder"
                                class="w-full rounded-lg bg-[#710014] px-5 py-4 text-sm font-bold tracking-wide text-white transition hover:bg-[#52000f] disabled:cursor-not-allowed disabled:opacity-40">
                                BUAT PESANAN
                            </button>

                            <p class="text-center text-[10px] leading-relaxed text-stone-400">
                                Pesanan akan langsung disimpan ke sistem. Status pembayaran awal: belum dibayar.
                            </p>
                        </div>

                    </aside>

                </div>
            </div>
    
    <script>
        const cart = new Map();
        let activeCategory = 'all';

        const rupiah = value => 'Rp ' + Number(value).toLocaleString('id-ID');

        const escapeHtml = value => String(value).replace(/[&<>"']/g, char => ({
            '&': '&amp;',
            '<': '&lt;',
            '>': '&gt;',
            '"': '&quot;',
            "'": '&#039;'
        })[char]);

        // FILTER KATEGORI
        document.querySelectorAll('.category-button').forEach(button => {
            button.addEventListener('click', () => {
                activeCategory = button.dataset.category;

                document.querySelectorAll('.category-button').forEach(item => {
                    item.className = item === button ?
                        'category-button shrink-0 rounded-lg bg-[#710014] px-4 py-2.5 text-xs font-semibold text-white' :
                        'category-button shrink-0 rounded-lg border border-[#e2d9ce] bg-white px-4 py-2.5 text-xs font-medium text-stone-600 hover:border-[#710014]';
                });

                filterMenus();
            });
        });

        // PENCARIAN MENU
        document.getElementById('menuSearch').addEventListener('input', filterMenus);

        function filterMenus() {
            const keyword = document.getElementById('menuSearch').value.toLowerCase();
            let visible = 0;

            document.querySelectorAll('.menu-card').forEach(card => {
                const categoryMatch = activeCategory === 'all' ||
                    card.dataset.category === activeCategory;

                const searchMatch = card.dataset.name.toLowerCase().includes(keyword);
                const show = categoryMatch && searchMatch;

                card.classList.toggle('hidden', !show);

                if (show) visible++;
            });

            document.getElementById('noSearchResult').classList.toggle('hidden', visible > 0);
        }

        // TAMBAH MENU
        document.querySelectorAll('.menu-card').forEach(card => {
            card.addEventListener('click', () => {
                const id = Number(card.dataset.id);
                const existing = cart.get(id);

                if (existing) {
                    existing.quantity++;
                } else {
                    cart.set(id, {
                        id,
                        name: card.dataset.name,
                        price: Number(card.dataset.price),
                        quantity: 1
                    });
                }

                renderCart();
            });
        });

        function updateQuantity(id, change) {
            const item = cart.get(id);
            if (!item) return;

            item.quantity += change;

            if (item.quantity <= 0) {
                cart.delete(id);
            }

            renderCart();
        }

        function renderCart() {
            const container = document.getElementById('cartItems');
            const items = [...cart.values()];

            const quantity = items.reduce((sum, item) => sum + item.quantity, 0);
            const subtotal = items.reduce((sum, item) => sum + item.price * item.quantity, 0);

            document.getElementById('cartCount').textContent = quantity + ' item';
            document.getElementById('summaryQuantity').textContent = quantity;
            document.getElementById('cartSubtotal').textContent = rupiah(subtotal);
            document.getElementById('cartTotal').textContent = rupiah(subtotal);
            document.getElementById('submitOrder').disabled = items.length === 0;

            if (items.length === 0) {
                container.innerHTML = `
                <div class="py-10 text-center">
                    <div class="text-3xl text-[#c7b8a7]">▤</div>
                    <p class="mt-3 text-sm font-medium text-stone-500">Belum ada pesanan</p>
                    <p class="mt-1 text-xs text-stone-400">Pilih menu dari katalog</p>
                </div>`;
                return;
            }

            container.innerHTML = items.map(item => `
            <div class="border-b border-[#eee6dc] pb-4 last:border-0">
                <div class="flex justify-between gap-3">
                    <div class="min-w-0">
                        <p class="truncate text-sm font-semibold text-[#211D1A]">${escapeHtml(item.name)}</p>
                        <p class="mt-1 text-xs text-stone-500">${rupiah(item.price)}</p>
                    </div>
                    <p class="whitespace-nowrap text-sm font-semibold">${rupiah(item.price * item.quantity)}</p>
                </div>

                <div class="mt-3 flex items-center gap-3">
                    <button type="button" data-id="${item.id}" data-change="-1"
                        class="quantity-button flex h-7 w-7 items-center justify-center rounded border border-[#ded3c6] text-sm hover:border-[#710014] hover:bg-[#F5EFE6] hover:text-[#710014]">−</button>
                    <span class="min-w-4 text-center text-xs font-semibold">${item.quantity}</span>
                    <button type="button" data-id="${item.id}" data-change="1"
                        class="quantity-button flex h-7 w-7 items-center justify-center rounded border border-[#ded3c6] text-sm hover:border-[#710014] hover:bg-[#F5EFE6] hover:text-[#710014]">+</button>
                    <button type="button" data-id="${item.id}" data-change="remove"
                        class="remove-button ml-auto text-xs font-semibold text-[#710014] hover:underline">Hapus</button>
                </div>
            </div>
        `).join('');

            container.querySelectorAll('.quantity-button').forEach(button => {
                button.addEventListener('click', () => {
                    updateQuantity(Number(button.dataset.id), Number(button.dataset.change));
                });
            });

            container.querySelectorAll('.remove-button').forEach(button => {
                button.addEventListener('click', () => {
                    cart.delete(Number(button.dataset.id));
                    renderCart();
                });
            });
        }

        // TIPE PESANAN
        document.getElementById('orderType').addEventListener('change', event => {
            const isDineIn = event.target.value === 'dine_in';
            document.getElementById('tableWrapper').classList.toggle('hidden', !isDineIn);
        });

        // KOSONGKAN KERANJANG
        document.getElementById('clearCart').addEventListener('click', () => {
            cart.clear();
            renderCart();
        });

        // KIRIM PESANAN KE LARAVEL
        document.getElementById('submitOrder').addEventListener('click', () => {
            if (cart.size === 0) {
                alert('Keranjang masih kosong.');
                return;
            }

            const customerName = document.getElementById('customerName').value.trim();
            const orderType = document.getElementById('orderType').value;
            const diningTable = document.getElementById('diningTable').value;

            if (orderType === 'dine_in' && !diningTable) {
                alert('Silakan pilih nomor meja terlebih dahulu.');
                return;
            }

            const form = document.createElement('form');
            form.method = 'POST';
            form.action = @json(route('cashier.orders.store'));

            const addInput = (name, value) => {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = name;
                input.value = value;
                form.appendChild(input);
            };

            addInput('_token', @json(csrf_token()));
            addInput('customer_name', customerName);
            addInput('order_type', orderType);

            if (orderType === 'dine_in') {
                addInput('dining_table_id', diningTable);
            }

            [...cart.values()].forEach((item, index) => {
                addInput(`items[${index}][menu_id]`, item.id);
                addInput(`items[${index}][quantity]`, item.quantity);
            });

            document.body.appendChild(form);

            const button = document.getElementById('submitOrder');
            button.disabled = true;
            button.textContent = 'MENYIMPAN PESANAN...';

            form.submit();
        });

        renderCart();
    </script>

</x-cashier-layout>