<x-app-layout>
    <style>
        .categories-page,
        .categories-page * { box-sizing: border-box; }

        .categories-page {
            display: grid;
            width: 100%;
            max-width: 1440px;
            gap: 20px;
            color: #211a17;
        }

        .categories-page__header {
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            gap: 18px;
            padding-bottom: 18px;
            border-bottom: 1px solid #ded7ce;
        }

        .categories-page__eyebrow {
            margin: 0 0 7px;
            color: #710014;
            font-size: 10px;
            font-weight: 700;
            letter-spacing: .14em;
            text-transform: uppercase;
        }

        .categories-page__title {
            margin: 0;
            color: #211a17;
            font-family: Georgia, 'Times New Roman', serif;
            font-size: clamp(25px, 3vw, 34px);
            line-height: 1.15;
        }

        .categories-page__subtitle {
            margin: 7px 0 0;
            color: #55504c;
            font-size: 13px;
            line-height: 1.5;
        }

        .categories-page__button {
            display: inline-flex;
            min-height: 42px;
            align-items: center;
            justify-content: center;
            gap: 7px;
            border: 1px solid transparent;
            border-radius: 6px;
            padding: 0 15px;
            font: inherit;
            font-size: 12px;
            font-weight: 700;
            text-decoration: none;
            white-space: nowrap;
            cursor: pointer;
            transition: background-color .15s ease, border-color .15s ease;
        }

        .categories-page__button--primary {
            border-color: #710014;
            background: #710014;
            color: #fff;
        }

        .categories-page__button--primary:hover {
            border-color: #560010;
            background: #560010;
        }

        .categories-page__button--secondary {
            border-color: #d4cdc4;
            background: #fffdf9;
            color: #343130;
        }

        .categories-page__button--secondary:hover { background: #f5efe6; }

        .categories-page__button:focus-visible,
        .categories-page__action:focus-visible,
        .categories-page__control:focus-visible {
            outline: 3px solid rgba(113, 0, 20, .2);
            outline-offset: 2px;
        }

        .categories-page__notice {
            border: 1px solid #d4cdc4;
            border-left: 4px solid #710014;
            border-radius: 6px;
            background: #f5efe6;
            padding: 12px 15px;
            color: #343130;
            font-size: 12px;
        }

        .categories-page__stats {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 12px;
        }

        .categories-page__stat {
            display: flex;
            min-height: 82px;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            border: 1px solid #ded7ce;
            border-top: 3px solid #710014;
            border-radius: 7px;
            background: #fffdf9;
            padding: 13px 15px;
        }

        .categories-page__stat:nth-child(2) { border-top-color: #343130; }
        .categories-page__stat:nth-child(3) { border-top-color: #806e61; }

        .categories-page__stat-label {
            margin: 0;
            color: #55504c;
            font-size: 11px;
            font-weight: 700;
        }

        .categories-page__stat-note {
            margin: 5px 0 0;
            color: #806e61;
            font-size: 10px;
        }

        .categories-page__stat-value {
            color: #211a17;
            font-family: Georgia, 'Times New Roman', serif;
            font-size: 24px;
            font-weight: 700;
        }

        .categories-page__panel {
            overflow: hidden;
            border: 1px solid #ded7ce;
            border-radius: 8px;
            background: #fffdf9;
        }

        .categories-page__panel-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            padding: 15px 18px;
            border-bottom: 1px solid #ded7ce;
            background: #f5efe6;
        }

        .categories-page__panel-title {
            margin: 0;
            color: #211a17;
            font-family: Georgia, 'Times New Roman', serif;
            font-size: 19px;
        }

        .categories-page__panel-note {
            margin: 4px 0 0;
            color: #55504c;
            font-size: 11px;
        }

        .categories-page__count {
            flex: 0 0 auto;
            color: #55504c;
            font-size: 11px;
        }

        .categories-page__filters {
            display: grid;
            grid-template-columns: minmax(220px, 1fr) minmax(170px, 220px) auto auto;
            align-items: end;
            gap: 10px;
            padding: 14px 18px;
            border-bottom: 1px solid #ded7ce;
        }

        .categories-page__label {
            display: block;
            margin-bottom: 5px;
            color: #343130;
            font-size: 10px;
            font-weight: 700;
        }

        .categories-page__control {
            display: block;
            width: 100%;
            min-height: 40px;
            border: 1px solid #d4cdc4;
            border-radius: 5px;
            background: #fffdf9;
            padding: 8px 10px;
            color: #211a17;
            font: inherit;
            font-size: 11px;
        }

        .categories-page__control:focus {
            border-color: #710014;
            box-shadow: 0 0 0 3px rgba(113, 0, 20, .12);
            outline: 0;
        }

        .categories-page__grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 12px;
            padding: 16px;
        }

        .categories-page__card {
            display: flex;
            min-width: 0;
            flex-direction: column;
            border: 1px solid #ded7ce;
            border-radius: 7px;
            background: #fffdf9;
            padding: 14px;
            transition: border-color .15s ease, box-shadow .15s ease;
        }

        .categories-page__card:hover {
            border-color: #b6a8a0;
            box-shadow: 0 4px 12px rgba(33, 26, 23, .06);
        }

        .categories-page__card-top {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 9px;
        }

        .categories-page__name {
            margin: 0;
            color: #211a17;
            font-size: 14px;
            font-weight: 700;
            line-height: 1.35;
            overflow-wrap: anywhere;
        }

        .categories-page__slug {
            display: inline-block;
            max-width: 100%;
            overflow: hidden;
            margin-top: 6px;
            border-radius: 4px;
            background: #f5efe6;
            padding: 4px 6px;
            color: #55504c;
            font-family: Consolas, monospace;
            font-size: 9px;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .categories-page__status {
            flex: 0 0 auto;
            border: 1px solid #d8c2c5;
            border-radius: 999px;
            background: #f5e9eb;
            padding: 4px 8px;
            color: #710014;
            font-size: 9px;
            font-weight: 700;
        }

        .categories-page__status--inactive {
            border-color: #ded7ce;
            background: #e8e4de;
            color: #55504c;
        }

        .categories-page__description {
            display: -webkit-box;
            min-height: 34px;
            overflow: hidden;
            margin: 10px 0 12px;
            color: #55504c;
            font-size: 11px;
            line-height: 1.5;
            line-clamp: 2;
            -webkit-box-orient: vertical;
            -webkit-line-clamp: 2;
        }

        .categories-page__details {
            display: flex;
            justify-content: space-between;
            gap: 8px;
            margin-top: auto;
            border-top: 1px solid #eee9e2;
            padding-top: 10px;
            color: #55504c;
            font-size: 10px;
        }

        .categories-page__details strong { color: #211a17; }

        .categories-page__actions {
            display: flex;
            gap: 6px;
            margin-top: 12px;
        }

        .categories-page__actions form { margin: 0; }

        .categories-page__action {
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

        .categories-page__action:hover { background: #f5efe6; }
        .categories-page__action--delete { border-color: #d8c2c5; color: #710014; }

        .categories-page__empty {
            grid-column: 1 / -1;
            padding: 38px 18px;
            color: #55504c;
            text-align: center;
        }

        .categories-page__empty h3 {
            margin: 0;
            color: #211a17;
            font-family: Georgia, 'Times New Roman', serif;
            font-size: 19px;
        }

        .categories-page__empty p {
            margin: 7px 0 14px;
            font-size: 12px;
            line-height: 1.5;
        }

        .categories-page__pagination { border-top: 1px solid #ded7ce; padding: 13px 16px; }

        @media (max-width: 1050px) {
            .categories-page__grid { grid-template-columns: repeat(2, minmax(0, 1fr)); }
        }

        @media (max-width: 780px) {
            .categories-page__filters { grid-template-columns: 1fr 1fr; }
            .categories-page__filters > :first-child { grid-column: 1 / -1; }
        }

        @media (max-width: 620px) {
            .categories-page { gap: 15px; }
            .categories-page__header { align-items: stretch; flex-direction: column; }
            .categories-page__header > .categories-page__button { width: 100%; }
            .categories-page__stats { grid-template-columns: 1fr; gap: 8px; }
            .categories-page__stat { min-height: 65px; padding: 10px 12px; }
            .categories-page__stat-value { font-size: 21px; }
            .categories-page__panel-head { align-items: flex-start; flex-direction: column; }
            .categories-page__filters { grid-template-columns: 1fr; padding: 12px; }
            .categories-page__filters > :first-child { grid-column: auto; }
            .categories-page__filters > .categories-page__button { width: 100%; }
            .categories-page__grid { grid-template-columns: 1fr; gap: 9px; padding: 10px; }
        }
    </style>

    <div class="categories-page">
        <header class="categories-page__header">
            <div>
                <p class="categories-page__eyebrow">Katalog / Pengelompokan</p>
                <h1 class="categories-page__title">Kategori Menu</h1>
                <p class="categories-page__subtitle">
                    Kelompokkan hidangan agar menu Restoe Boemi mudah dijelajahi.
                </p>
            </div>
            <a href="{{ route('owner.categories.create') }}"
                class="categories-page__button categories-page__button--primary">
                <span aria-hidden="true">+</span> Tambah Kategori
            </a>
        </header>

        @if (session('success'))
            <div role="status" class="categories-page__notice">{{ session('success') }}</div>
        @endif

        @if (session('error'))
            <div role="alert" class="categories-page__notice">{{ session('error') }}</div>
        @endif

        <section class="categories-page__stats" aria-label="Ringkasan kategori">
            <article class="categories-page__stat">
                <div>
                    <p class="categories-page__stat-label">Total kategori</p>
                    <p class="categories-page__stat-note">Seluruh kategori terdaftar</p>
                </div>
                <span class="categories-page__stat-value">{{ $totalCategories }}</span>
            </article>
            <article class="categories-page__stat">
                <div>
                    <p class="categories-page__stat-label">Kategori aktif</p>
                    <p class="categories-page__stat-note">Siap digunakan pada menu</p>
                </div>
                <span class="categories-page__stat-value">{{ $activeCategories }}</span>
            </article>
            <article class="categories-page__stat">
                <div>
                    <p class="categories-page__stat-label">Kategori nonaktif</p>
                    <p class="categories-page__stat-note">Tidak ditampilkan di katalog</p>
                </div>
                <span class="categories-page__stat-value">{{ $inactiveCategories }}</span>
            </article>
        </section>

        <section class="categories-page__panel">
            <header class="categories-page__panel-head">
                <div>
                    <h2 class="categories-page__panel-title">Daftar Kategori</h2>
                    <p class="categories-page__panel-note">Cari, filter, dan kelola pengelompokan menu.</p>
                </div>
                <p class="categories-page__count">
                    {{ $categories->firstItem() ?? 0 }}–{{ $categories->lastItem() ?? 0 }}
                    dari {{ $categories->total() }} kategori
                </p>
            </header>

            <form method="GET" action="{{ route('owner.categories.index') }}"
                class="categories-page__filters">
                <div>
                    <label for="search" class="categories-page__label">Cari kategori</label>
                    <input id="search" name="search" type="search" value="{{ $search }}"
                        placeholder="Nama, slug, atau deskripsi" class="categories-page__control">
                </div>
                <div>
                    <label for="status" class="categories-page__label">Status</label>
                    <select id="status" name="status" class="categories-page__control">
                        <option value="" @selected($status === '')>Semua status</option>
                        <option value="active" @selected($status === 'active')>Aktif</option>
                        <option value="inactive" @selected($status === 'inactive')>Nonaktif</option>
                    </select>
                </div>
                <button type="submit" class="categories-page__button categories-page__button--primary">
                    Terapkan
                </button>
                @if ($search !== '' || $status !== '')
                    <a href="{{ route('owner.categories.index') }}"
                        class="categories-page__button categories-page__button--secondary">
                        Reset
                    </a>
                @endif
            </form>

            <div class="categories-page__grid">
                @forelse ($categories as $category)
                    <article class="categories-page__card">
                        <div class="categories-page__card-top">
                            <div>
                                <h3 class="categories-page__name">{{ $category->name }}</h3>
                                <span class="categories-page__slug">{{ $category->slug }}</span>
                            </div>
                            <span class="categories-page__status {{ $category->is_active ? '' : 'categories-page__status--inactive' }}">
                                {{ $category->is_active ? 'Aktif' : 'Nonaktif' }}
                            </span>
                        </div>

                        <p class="categories-page__description">
                            {{ $category->description ?: 'Belum ada deskripsi kategori.' }}
                        </p>

                        <div class="categories-page__details">
                            <span><strong>{{ $category->menus_count }}</strong> produk</span>
                            <span>Urutan <strong>{{ $category->sort_order }}</strong></span>
                        </div>

                        <div class="categories-page__actions">
                            <a href="{{ route('owner.categories.edit', $category) }}"
                                class="categories-page__action">Edit</a>
                            <form action="{{ route('owner.categories.destroy', $category) }}" method="POST"
                                data-confirm-title="Hapus kategori?"
                                data-confirm-message="Yakin ingin menghapus kategori '{{ $category->name }}'? Aksi ini tidak dapat dibatalkan."
                                data-confirm-action="Hapus"
                                data-confirm-type="danger">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="categories-page__action categories-page__action--delete">
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </article>
                @empty
                    <div class="categories-page__empty">
                        <h3>{{ $search !== '' || $status !== '' ? 'Kategori tidak ditemukan' : 'Belum ada kategori' }}</h3>
                        <p>
                            {{ $search !== '' || $status !== ''
                                ? 'Coba ubah pencarian atau filter status.'
                                : 'Tambahkan kategori pertama agar produk lebih mudah dikelola.' }}
                        </p>
                        @if ($search !== '' || $status !== '')
                            <a href="{{ route('owner.categories.index') }}"
                                class="categories-page__button categories-page__button--secondary">
                                Hapus filter
                            </a>
                        @else
                            <a href="{{ route('owner.categories.create') }}"
                                class="categories-page__button categories-page__button--primary">
                                + Tambah Kategori
                            </a>
                        @endif
                    </div>
                @endforelse
            </div>

            @if ($categories->hasPages())
                <div class="categories-page__pagination">{{ $categories->links() }}</div>
            @endif
        </section>
    </div>
</x-app-layout>
