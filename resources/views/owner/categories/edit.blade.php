<x-app-layout>
    <style>
        .category-form-page,
        .category-form-page * { box-sizing: border-box; }

        .category-form-page {
            display: grid;
            width: 100%;
            max-width: 860px;
            gap: 18px;
            color: #211a17;
        }

        .category-form-page__header {
            padding-bottom: 17px;
            border-bottom: 1px solid #ded7ce;
        }

        .category-form-page__back {
            display: inline-block;
            margin-bottom: 12px;
            color: #55504c;
            font-size: 12px;
            font-weight: 600;
            text-decoration: none;
        }

        .category-form-page__back:hover { color: #710014; }

        .category-form-page__eyebrow {
            margin: 0 0 7px;
            color: #710014;
            font-size: 10px;
            font-weight: 700;
            letter-spacing: .14em;
            text-transform: uppercase;
        }

        .category-form-page__title {
            margin: 0;
            color: #211a17;
            font-family: Georgia, 'Times New Roman', serif;
            font-size: clamp(25px, 3vw, 33px);
            line-height: 1.15;
        }

        .category-form-page__subtitle {
            margin: 7px 0 0;
            color: #55504c;
            font-size: 13px;
            line-height: 1.5;
        }

        .category-form-page__card {
            overflow: hidden;
            border: 1px solid #ded7ce;
            border-radius: 8px;
            background: #fffdf9;
        }

        .category-form-page__card-head {
            padding: 15px 20px;
            border-bottom: 1px solid #ded7ce;
            background: #f5efe6;
        }

        .category-form-page__card-title {
            margin: 0;
            color: #211a17;
            font-family: Georgia, 'Times New Roman', serif;
            font-size: 18px;
        }

        .category-form-page__card-note {
            margin: 4px 0 0;
            color: #55504c;
            font-size: 11px;
        }

        .category-form-page__fields {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 16px;
            padding: 20px;
        }

        .category-form-page__field { min-width: 0; }
        .category-form-page__field--wide { grid-column: 1 / -1; }

        .category-form-page__label {
            display: block;
            margin-bottom: 6px;
            color: #343130;
            font-size: 11px;
            font-weight: 700;
        }

        .category-form-page__required { color: #710014; }

        .category-form-page__control {
            display: block;
            width: 100%;
            min-height: 42px;
            border: 1px solid #d4cdc4;
            border-radius: 6px;
            background: #fffdf9;
            padding: 9px 11px;
            color: #211a17;
            font: inherit;
            font-size: 12px;
        }

        .category-form-page__control:focus {
            border-color: #710014;
            box-shadow: 0 0 0 3px rgba(113, 0, 20, .12);
            outline: 0;
        }

        .category-form-page__control:focus-visible,
        .category-form-page__back:focus-visible,
        .category-form-page__button:focus-visible {
            outline: 3px solid rgba(113, 0, 20, .2);
            outline-offset: 2px;
        }

        .category-form-page__control--textarea {
            min-height: 105px;
            resize: vertical;
        }

        .category-form-page__help,
        .category-form-page__error {
            margin: 5px 0 0;
            font-size: 10px;
            line-height: 1.5;
        }

        .category-form-page__help { color: #806e61; }
        .category-form-page__error { color: #710014; }

        .category-form-page__toggle {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            border: 1px solid #ded7ce;
            border-radius: 6px;
            background: #f5efe6;
            padding: 12px;
            cursor: pointer;
        }

        .category-form-page__toggle input {
            width: 16px;
            height: 16px;
            flex: 0 0 auto;
            margin: 1px 0 0;
            accent-color: #710014;
        }

        .category-form-page__toggle strong {
            display: block;
            color: #343130;
            font-size: 12px;
        }

        .category-form-page__toggle span span {
            display: block;
            margin-top: 4px;
            color: #55504c;
            font-size: 10px;
            line-height: 1.5;
        }

        .category-form-page__actions {
            display: flex;
            justify-content: flex-end;
            gap: 9px;
            padding: 14px 20px;
            border-top: 1px solid #ded7ce;
            background: #f5efe6;
        }

        .category-form-page__button {
            display: inline-flex;
            min-height: 40px;
            align-items: center;
            justify-content: center;
            border: 1px solid #d4cdc4;
            border-radius: 6px;
            background: #fffdf9;
            padding: 0 15px;
            color: #343130;
            font: inherit;
            font-size: 12px;
            font-weight: 700;
            text-decoration: none;
            white-space: nowrap;
            cursor: pointer;
        }

        .category-form-page__button:hover { background: #f5efe6; }

        .category-form-page__button--primary {
            border-color: #710014;
            background: #710014;
            color: #fff;
        }

        .category-form-page__button--primary:hover {
            border-color: #560010;
            background: #560010;
        }

        @media (max-width: 620px) {
            .category-form-page { gap: 15px; }
            .category-form-page__fields { grid-template-columns: 1fr; gap: 14px; padding: 16px; }
            .category-form-page__field--wide { grid-column: auto; }
            .category-form-page__actions { padding: 12px 16px; }
            .category-form-page__button { flex: 1; padding: 0 9px; }
        }
    </style>

    <div class="category-form-page">
        <header class="category-form-page__header">
            <a href="{{ route('owner.categories.index') }}" class="category-form-page__back">
                &larr; Kembali ke Kategori
            </a>
            <p class="category-form-page__eyebrow">Katalog / Perbarui kategori</p>
            <h1 class="category-form-page__title">Edit Kategori</h1>
            <p class="category-form-page__subtitle">
                Perbarui informasi kategori {{ $category->name }}.
            </p>
        </header>

        <form action="{{ route('owner.categories.update', $category) }}" method="POST"
            class="category-form-page__card">
            @csrf
            @method('PUT')
            <header class="category-form-page__card-head">
                <h2 class="category-form-page__card-title">Informasi Kategori</h2>
                <p class="category-form-page__card-note">
                    <span class="category-form-page__required">*</span> Kolom wajib diisi.
                </p>
            </header>

            <div class="category-form-page__fields">
                <div class="category-form-page__field">
                    <label for="name" class="category-form-page__label">
                        Nama Kategori <span class="category-form-page__required">*</span>
                    </label>
                    <input type="text" id="name" name="name"
                        value="{{ old('name', $category->name) }}" placeholder="Contoh: Kopi Nusantara"
                        required maxlength="100" class="category-form-page__control">
                    @error('name')
                        <p class="category-form-page__error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="category-form-page__field">
                    <label for="sort_order" class="category-form-page__label">Urutan Tampilan</label>
                    <input type="number" id="sort_order" name="sort_order" min="0"
                        value="{{ old('sort_order', $category->sort_order) }}"
                        class="category-form-page__control">
                    <p class="category-form-page__help">Angka lebih kecil ditampilkan lebih dahulu.</p>
                    @error('sort_order')
                        <p class="category-form-page__error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="category-form-page__field category-form-page__field--wide">
                    <label for="description" class="category-form-page__label">Deskripsi</label>
                    <textarea id="description" name="description" rows="4"
                        placeholder="Tuliskan keterangan singkat kategori..."
                        class="category-form-page__control category-form-page__control--textarea">{{ old('description', $category->description) }}</textarea>
                    @error('description')
                        <p class="category-form-page__error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="category-form-page__field category-form-page__field--wide">
                    <label class="category-form-page__toggle">
                        <input type="hidden" name="is_active" value="0">
                        <input type="checkbox" name="is_active" value="1"
                            @checked((bool) old('is_active', $category->is_active))>
                        <span>
                            <strong>Aktifkan kategori</strong>
                            <span>Kategori aktif dapat dipilih saat mengelola produk.</span>
                        </span>
                    </label>
                    @error('is_active')
                        <p class="category-form-page__error">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="category-form-page__actions">
                <a href="{{ route('owner.categories.index') }}" class="category-form-page__button">Batal</a>
                <button type="submit"
                    class="category-form-page__button category-form-page__button--primary">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
