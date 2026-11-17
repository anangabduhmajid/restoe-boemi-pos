<x-app-layout>
    <style>
        .menu-catalog,
        .menu-catalog * { box-sizing: border-box; }

        .menu-catalog {
            display: grid;
            width: 100%;
            gap: 20px;
            color: #211a17;
        }

        .menu-catalog__header {
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            gap: 18px;
            padding-bottom: 18px;
            border-bottom: 1px solid #ded7ce;
        }

        .menu-catalog__eyebrow {
            margin: 0 0 7px;
            color: #710014;
            font-size: 10px;
            font-weight: 700;
            letter-spacing: .14em;
            text-transform: uppercase;
        }

        .menu-catalog__title {
            margin: 0;
            color: #211a17;
            font-family: Georgia, 'Times New Roman', serif;
            font-size: clamp(25px, 3vw, 34px);
            line-height: 1.15;
        }

        .menu-catalog__subtitle {
            margin: 7px 0 0;
            color: #55504c;
            font-size: 13px;
            line-height: 1.5;
        }

        .menu-catalog__button {
            display: inline-flex;
            min-height: 42px;
            align-items: center;
            justify-content: center;
            gap: 8px;
            border: 1px solid transparent;
            border-radius: 6px;
            padding: 0 16px;
            color: #fff;
            font: inherit;
            font-size: 12px;
            font-weight: 700;
            text-decoration: none;
            white-space: nowrap;
            cursor: pointer;
            transition: background-color .15s ease, border-color .15s ease;
        }

        .menu-catalog__button--primary {
            border-color: #710014;
            background: #710014;
        }

        .menu-catalog__button--primary:hover {
            border-color: #560010;
            background: #560010;
        }

        .menu-catalog__button:focus-visible,
        .menu-catalog__action:focus-visible {
            outline: 3px solid rgba(113, 0, 20, .2);
            outline-offset: 2px;
        }

        .menu-catalog__notice {
            border: 1px solid #d4cdc4;
            border-left: 4px solid #710014;
            border-radius: 6px;
            background: #f5efe6;
            padding: 12px 15px;
            color: #343130;
            font-size: 13px;
        }

        .menu-catalog__stats {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 12px;
        }

        .menu-catalog__stat {
            display: flex;
            min-width: 0;
            min-height: 88px;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            border: 1px solid #ded7ce;
            border-top: 3px solid #710014;
            border-radius: 7px;
            background: #fffdf9;
            padding: 15px 17px;
        }

        .menu-catalog__stat:nth-child(2) { border-top-color: #343130; }
        .menu-catalog__stat:nth-child(3) { border-top-color: #806e61; }

        .menu-catalog__stat-label {
            margin: 0;
            color: #55504c;
            font-size: 11px;
            font-weight: 700;
        }

        .menu-catalog__stat-note {
            margin: 5px 0 0;
            color: #806e61;
            font-size: 10px;
        }

        .menu-catalog__stat-value {
            color: #211a17;
            font-family: Georgia, 'Times New Roman', serif;
            font-size: 25px;
            font-weight: 700;
        }

        .menu-catalog__panel {
            overflow: hidden;
            border: 1px solid #ded7ce;
            border-radius: 8px;
            background: #fffdf9;
        }

        .menu-catalog__panel-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 14px;
            padding: 15px 18px;
            border-bottom: 1px solid #ded7ce;
            background: #f5efe6;
        }

        .menu-catalog__panel-title {
            margin: 0;
            color: #211a17;
            font-family: Georgia, 'Times New Roman', serif;
            font-size: 19px;
        }

        .menu-catalog__panel-note {
            margin: 4px 0 0;
            color: #55504c;
            font-size: 11px;
        }

        .menu-catalog__count {
            flex: 0 0 auto;
            color: #55504c;
            font-size: 11px;
        }

        .menu-catalog__grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 14px;
            padding: 16px;
        }

        .menu-catalog__card {
            display: flex;
            min-width: 0;
            flex-direction: column;
            overflow: hidden;
            border: 1px solid #ded7ce;
            border-radius: 7px;
            background: #fffdf9;
            transition: border-color .15s ease, box-shadow .15s ease;
        }

        .menu-catalog__card:hover {
            border-color: #b6a8a0;
            box-shadow: 0 4px 14px rgba(33, 26, 23, .07);
        }

        .menu-catalog__photo {
            display: flex;
            width: 100%;
            aspect-ratio: 4 / 3;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            background: #f5efe6;
            color: #710014;
            font-family: Georgia, 'Times New Roman', serif;
            font-size: 42px;
        }

        .menu-catalog__photo img {
            display: block;
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .menu-catalog__body {
            display: flex;
            flex: 1;
            flex-direction: column;
            padding: 13px;
        }

        .menu-catalog__meta {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 8px;
            margin-bottom: 8px;
        }

        .menu-catalog__category {
            overflow: hidden;
            color: #710014;
            font-size: 9px;
            font-weight: 700;
            letter-spacing: .07em;
            text-overflow: ellipsis;
            text-transform: uppercase;
            white-space: nowrap;
        }

        .menu-catalog__availability {
            flex: 0 0 auto;
            border: 1px solid #d8c2c5;
            border-radius: 999px;
            background: #f5e9eb;
            padding: 4px 7px;
            color: #710014;
            font-size: 9px;
            font-weight: 700;
            white-space: nowrap;
        }

        .menu-catalog__availability--no {
            border-color: #ded7ce;
            background: #e8e4de;
            color: #55504c;
        }

        .menu-catalog__name {
            margin: 0;
            color: #211a17;
            font-size: 15px;
            font-weight: 700;
            line-height: 1.35;
        }

        .menu-catalog__description {
            display: -webkit-box;
            min-height: 34px;
            overflow: hidden;
            margin: 5px 0 12px;
            color: #55504c;
            font-size: 11px;
            line-height: 1.5;
            line-clamp: 2;
            -webkit-box-orient: vertical;
            -webkit-line-clamp: 2;
        }

        .menu-catalog__details {
            display: flex;
            align-items: baseline;
            justify-content: space-between;
            gap: 8px;
            margin-top: auto;
            padding-top: 10px;
            border-top: 1px solid #eee9e2;
        }

        .menu-catalog__price {
            color: #710014;
            font-family: Georgia, 'Times New Roman', serif;
            font-size: 16px;
            font-weight: 700;
            white-space: nowrap;
        }

        .menu-catalog__order {
            color: #806e61;
            font-size: 10px;
            text-align: right;
        }

        .menu-catalog__actions {
            display: flex;
            gap: 6px;
            margin-top: 11px;
        }

        .menu-catalog__actions form { margin: 0; }

        .menu-catalog__action {
            display: inline-flex;
            min-height: 31px;
            align-items: center;
            justify-content: center;
            border: 1px solid #d4cdc4;
            border-radius: 5px;
            background: #fffdf9;
            padding: 0 10px;
            color: #343130;
            font: inherit;
            font-size: 10px;
            font-weight: 700;
            text-decoration: none;
            cursor: pointer;
        }

        .menu-catalog__action:hover { background: #f5efe6; }
        .menu-catalog__action--delete { border-color: #d8c2c5; color: #710014; }

        .menu-catalog__empty {
            grid-column: 1 / -1;
            padding: 38px 18px;
            color: #55504c;
            text-align: center;
        }

        .menu-catalog__empty h3 {
            margin: 0;
            color: #211a17;
            font-family: Georgia, 'Times New Roman', serif;
            font-size: 19px;
        }

        .menu-catalog__empty p {
            margin: 7px 0 15px;
            font-size: 12px;
            line-height: 1.5;
        }

        .menu-catalog__pagination { border-top: 1px solid #ded7ce; padding: 13px 16px; }

        @media (max-width: 1050px) {
            .menu-catalog__grid { grid-template-columns: repeat(2, minmax(0, 1fr)); }
        }

        @media (max-width: 680px) {
            .menu-catalog { gap: 15px; }
            .menu-catalog__header { align-items: stretch; flex-direction: column; }
            .menu-catalog__header > .menu-catalog__button { width: 100%; }
            .menu-catalog__stats { grid-template-columns: 1fr; gap: 8px; }
            .menu-catalog__stat { min-height: 66px; padding: 10px 12px; }
            .menu-catalog__stat-value { font-size: 21px; }
            .menu-catalog__panel-head { align-items: flex-start; flex-direction: column; }
            .menu-catalog__grid { grid-template-columns: 1fr; gap: 11px; padding: 11px; }
            .menu-catalog__photo { aspect-ratio: 16 / 9; }
        }
    </style>

    <div class="menu-catalog">
        <header class="menu-catalog__header">
            <div>
                <p class="menu-catalog__eyebrow">Katalog / Menu Produk</p>
                <h1 class="menu-catalog__title">Menu Produk</h1>
                <p class="menu-catalog__subtitle">
                    Kelola makanan dan minuman yang tersedia di Restoe Boemi.
                </p>
            </div>
            <a href="{{ route('owner.menus.create') }}" class="menu-catalog__button menu-catalog__button--primary">
                <span aria-hidden="true">+</span> Tambah Produk
            </a>
        </header>

        @if (session('success'))
            <div role="status" class="menu-catalog__notice">{{ session('success') }}</div>
        @endif

        @if (session('error'))
            <div role="alert" class="menu-catalog__notice">{{ session('error') }}</div>
        @endif

        <section class="menu-catalog__stats" aria-label="Ringkasan produk">
            <article class="menu-catalog__stat">
                <div>
                    <p class="menu-catalog__stat-label">Total produk</p>
                    <p class="menu-catalog__stat-note">Produk terdaftar</p>
                </div>
                <span class="menu-catalog__stat-value">{{ \App\Models\Menu::count() }}</span>
            </article>
            <article class="menu-catalog__stat">
                <div>
                    <p class="menu-catalog__stat-label">Produk tersedia</p>
                    <p class="menu-catalog__stat-note">Siap dipesan pelanggan</p>
                </div>
                <span class="menu-catalog__stat-value">
                    {{ \App\Models\Menu::where('is_available', true)->count() }}
                </span>
            </article>
            <article class="menu-catalog__stat">
                <div>
                    <p class="menu-catalog__stat-label">Tidak tersedia</p>
                    <p class="menu-catalog__stat-note">Tidak dapat dipesan</p>
                </div>
                <span class="menu-catalog__stat-value">
                    {{ \App\Models\Menu::where('is_available', false)->count() }}
                </span>
            </article>
        </section>

        <section class="menu-catalog__panel">
            <header class="menu-catalog__panel-head">
                <div>
                    <h2 class="menu-catalog__panel-title">Daftar Produk</h2>
                    <p class="menu-catalog__panel-note">Foto, kategori, harga, dan ketersediaan.</p>
                </div>
                <p class="menu-catalog__count">
                    {{ $menus->firstItem() ?? 0 }}–{{ $menus->lastItem() ?? 0 }}
                    dari {{ $menus->total() }} produk
                </p>
            </header>

            <div class="menu-catalog__grid">
                @forelse ($menus as $menu)
                    <article class="menu-catalog__card">
                        <div class="menu-catalog__photo">
                            @if ($menu->image_path)
                                <img src="{{ asset('storage/' . $menu->image_path) }}"
                                    alt="{{ $menu->name }}" loading="lazy">
                            @else
                                <span aria-hidden="true">{{ strtoupper(substr($menu->name, 0, 1)) }}</span>
                            @endif
                        </div>

                        <div class="menu-catalog__body">
                            <div class="menu-catalog__meta">
                                <span class="menu-catalog__category">
                                    {{ $menu->category?->name ?? 'Tanpa kategori' }}
                                </span>
                                <span class="menu-catalog__availability {{ $menu->is_available ? '' : 'menu-catalog__availability--no' }}">
                                    {{ $menu->is_available ? 'Tersedia' : 'Tidak tersedia' }}
                                </span>
                            </div>

                            <h3 class="menu-catalog__name">{{ $menu->name }}</h3>
                            <p class="menu-catalog__description">
                                {{ $menu->description ?: 'Belum ada deskripsi produk.' }}
                            </p>

                            <div class="menu-catalog__details">
                                <span class="menu-catalog__price">
                                    Rp {{ number_format((float) $menu->price, 0, ',', '.') }}
                                </span>
                                <span class="menu-catalog__order">Urutan {{ $menu->sort_order }}</span>
                            </div>

                            <div class="menu-catalog__actions">
                                <a href="{{ route('owner.menus.edit', $menu) }}" class="menu-catalog__action">
                                    Edit
                                </a>
                                <form action="{{ route('owner.menus.destroy', $menu) }}" method="POST"
                                    data-confirm-title="Hapus menu?"
                                    data-confirm-message="Yakin ingin menghapus menu '{{ $menu->name }}'? Aksi ini tidak dapat dibatalkan."
                                    data-confirm-action="Hapus"
                                    data-confirm-type="danger">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="menu-catalog__action menu-catalog__action--delete">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </div>
                    </article>
                @empty
                    <div class="menu-catalog__empty">
                        <h3>Belum Ada Produk</h3>
                        <p>Tambahkan produk pertama untuk mulai mengelola katalog makanan dan minuman.</p>
                        <a href="{{ route('owner.menus.create') }}"
                            class="menu-catalog__button menu-catalog__button--primary">
                            + Tambah Produk
                        </a>
                    </div>
                @endforelse
            </div>

            @if ($menus->hasPages())
                <div class="menu-catalog__pagination">{{ $menus->links() }}</div>
            @endif
        </section>
    </div>
</x-app-layout>
