<x-app-layout>
    <style>
        .menu-form-page,
        .menu-form-page * { box-sizing: border-box; }

        .menu-form-page {
            display: grid;
            width: 100%;
            max-width: 900px;
            gap: 18px;
            color: #211a17;
        }

        .menu-form-page__header {
            padding-bottom: 17px;
            border-bottom: 1px solid #ded7ce;
        }

        .menu-form-page__eyebrow {
            margin: 0 0 7px;
            color: #710014;
            font-size: 10px;
            font-weight: 700;
            letter-spacing: .14em;
            text-transform: uppercase;
        }

        .menu-form-page__title {
            margin: 0;
            color: #211a17;
            font-family: Georgia, 'Times New Roman', serif;
            font-size: clamp(25px, 3vw, 33px);
            line-height: 1.15;
        }

        .menu-form-page__subtitle {
            margin: 7px 0 0;
            color: #55504c;
            font-size: 13px;
            line-height: 1.5;
        }

        .menu-form-page__notice {
            border: 1px solid #d8c2c5;
            border-left: 4px solid #710014;
            border-radius: 6px;
            background: #f5e9eb;
            padding: 12px 15px;
            color: #560010;
            font-size: 12px;
        }

        .menu-form-page__notice ul { margin: 7px 0 0; padding-left: 18px; }

        .menu-form-page__card {
            overflow: hidden;
            border: 1px solid #ded7ce;
            border-radius: 8px;
            background: #fffdf9;
        }

        .menu-form-page__card-head {
            padding: 15px 20px;
            border-bottom: 1px solid #ded7ce;
            background: #f5efe6;
        }

        .menu-form-page__card-title {
            margin: 0;
            color: #211a17;
            font-family: Georgia, 'Times New Roman', serif;
            font-size: 18px;
        }

        .menu-form-page__card-note {
            margin: 4px 0 0;
            color: #55504c;
            font-size: 11px;
        }

        .menu-form-page__callout {
            margin: 16px 20px 0;
            border: 1px solid #d4cdc4;
            border-radius: 6px;
            background: #f5efe6;
            padding: 11px 13px;
            color: #343130;
            font-size: 11px;
            line-height: 1.5;
        }

        .menu-form-page__callout a { color: #710014; font-weight: 700; }

        .menu-form-page__fields {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 16px;
            padding: 20px;
        }

        .menu-form-page__field { min-width: 0; }
        .menu-form-page__field--wide { grid-column: 1 / -1; }

        .menu-form-page__label {
            display: block;
            margin-bottom: 6px;
            color: #343130;
            font-size: 11px;
            font-weight: 700;
        }

        .menu-form-page__required { color: #710014; }

        .menu-form-page__control {
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

        .menu-form-page__control:focus {
            border-color: #710014;
            box-shadow: 0 0 0 3px rgba(113, 0, 20, .12);
            outline: 0;
        }

        .menu-form-page__control:focus-visible,
        .menu-form-page__button:focus-visible {
            outline: 3px solid rgba(113, 0, 20, .2);
            outline-offset: 2px;
        }

        .menu-form-page__control--textarea {
            min-height: 110px;
            resize: vertical;
        }

        .menu-form-page__control--file { min-height: 45px; padding: 6px; }

        .menu-form-page__control--file::file-selector-button {
            min-height: 31px;
            margin-right: 10px;
            border: 0;
            border-radius: 4px;
            background: #f5efe6;
            padding: 0 10px;
            color: #710014;
            font-size: 11px;
            font-weight: 700;
            cursor: pointer;
        }

        .menu-form-page__help {
            margin: 6px 0 0;
            color: #806e61;
            font-size: 10px;
            line-height: 1.5;
        }

        .menu-form-page__error {
            margin: 5px 0 0;
            color: #710014;
            font-size: 11px;
        }

        .menu-form-page__availability {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            border: 1px solid #ded7ce;
            border-radius: 6px;
            background: #f5efe6;
            padding: 12px;
            cursor: pointer;
        }

        .menu-form-page__availability input {
            width: 16px;
            height: 16px;
            flex: 0 0 auto;
            margin: 1px 0 0;
            accent-color: #710014;
        }

        .menu-form-page__availability strong {
            display: block;
            color: #343130;
            font-size: 12px;
        }

        .menu-form-page__availability span span {
            display: block;
            margin-top: 4px;
            color: #55504c;
            font-size: 10px;
        }

        .menu-form-page__preview {
            display: block;
            width: 100%;
            max-width: 260px;
            aspect-ratio: 4 / 3;
            margin-bottom: 10px;
            border: 1px solid #ded7ce;
            border-radius: 6px;
            object-fit: cover;
        }

        .menu-form-page__actions {
            display: flex;
            justify-content: flex-end;
            gap: 9px;
            padding: 14px 20px;
            border-top: 1px solid #ded7ce;
            background: #f5efe6;
        }

        .menu-form-page__button {
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

        .menu-form-page__button:hover { background: #f5efe6; }

        .menu-form-page__button--primary {
            border-color: #710014;
            background: #710014;
            color: #fff;
        }

        .menu-form-page__button--primary:hover {
            border-color: #560010;
            background: #560010;
        }

        @media (max-width: 650px) {
            .menu-form-page { gap: 15px; }
            .menu-form-page__fields { grid-template-columns: 1fr; gap: 14px; padding: 16px; }
            .menu-form-page__field--wide { grid-column: auto; }
            .menu-form-page__callout { margin: 14px 16px 0; }
            .menu-form-page__actions { padding: 12px 16px; }
            .menu-form-page__button { flex: 1; padding: 0 9px; }
        }
    </style>

    <div class="menu-form-page">
        <header class="menu-form-page__header">
            <p class="menu-form-page__eyebrow">Katalog / Menu Produk / Edit</p>
            <h1 class="menu-form-page__title">Edit Produk</h1>
            <p class="menu-form-page__subtitle">
                Perbarui informasi produk {{ $menu->name }}.
            </p>
        </header>

        @if ($errors->any())
            <div role="alert" class="menu-form-page__notice">
                <strong>Periksa kembali input berikut:</strong>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('owner.menus.update', $menu) }}" method="POST"
            enctype="multipart/form-data" class="menu-form-page__card">
            @csrf
            @method('PUT')
            <header class="menu-form-page__card-head">
                <h2 class="menu-form-page__card-title">Informasi Produk</h2>
                <p class="menu-form-page__card-note">Perbarui data produk sesuai kebutuhan.</p>
            </header>

            <div class="menu-form-page__fields">
                <div class="menu-form-page__field">
                    <label for="name" class="menu-form-page__label">
                        Nama Produk <span class="menu-form-page__required">*</span>
                    </label>
                    <input id="name" name="name" type="text"
                        value="{{ old('name', $menu->name) }}" required maxlength="150"
                        class="menu-form-page__control">
                    @error('name')
                        <p class="menu-form-page__error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="menu-form-page__field">
                    <label for="category_id" class="menu-form-page__label">
                        Kategori <span class="menu-form-page__required">*</span>
                    </label>
                    <select id="category_id" name="category_id" required class="menu-form-page__control">
                        <option value="">Pilih kategori</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}"
                                @selected(old('category_id', $menu->category_id) == $category->id)>
                                {{ $category->name }}{{ ! $category->is_active ? ' (Nonaktif)' : '' }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <p class="menu-form-page__error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="menu-form-page__field menu-form-page__field--wide">
                    <label for="description" class="menu-form-page__label">Deskripsi Produk</label>
                    <textarea id="description" name="description" rows="4"
                        class="menu-form-page__control menu-form-page__control--textarea">{{ old('description', $menu->description) }}</textarea>
                    @error('description')
                        <p class="menu-form-page__error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="menu-form-page__field">
                    <label for="price" class="menu-form-page__label">
                        Harga Jual (Rp) <span class="menu-form-page__required">*</span>
                    </label>
                    <input id="price" name="price" type="number"
                        value="{{ old('price', $menu->price) }}" required min="0"
                        max="9999999999.99" step="0.01" class="menu-form-page__control">
                    @error('price')
                        <p class="menu-form-page__error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="menu-form-page__field">
                    <label for="sort_order" class="menu-form-page__label">Urutan Tampilan</label>
                    <input id="sort_order" name="sort_order" type="number"
                        value="{{ old('sort_order', $menu->sort_order) }}" min="0"
                        class="menu-form-page__control">
                    @error('sort_order')
                        <p class="menu-form-page__error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="menu-form-page__field menu-form-page__field--wide">
                    <label for="image" class="menu-form-page__label">Foto Produk</label>
                    @if ($menu->image_path)
                        <img src="{{ asset('storage/' . $menu->image_path) }}"
                            alt="{{ $menu->name }}" class="menu-form-page__preview">
                        <p class="menu-form-page__help">
                            Foto saat ini. Pilih file baru jika ingin menggantinya.
                        </p>
                    @else
                        <p class="menu-form-page__help">Produk belum memiliki foto.</p>
                    @endif
                    <input id="image" name="image" type="file" accept=".jpg,.jpeg,.png,.webp"
                        class="menu-form-page__control menu-form-page__control--file">
                    <p class="menu-form-page__help">JPG, JPEG, PNG, atau WEBP. Maksimal 2 MB.</p>
                    @error('image')
                        <p class="menu-form-page__error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="menu-form-page__field menu-form-page__field--wide">
                    <label class="menu-form-page__availability">
                        <input type="checkbox" name="is_available" value="1"
                            @checked(old('is_available', $menu->is_available) == 1)>
                        <span>
                            <strong>Produk tersedia</strong>
                            <span>Produk dapat dipesan oleh pelanggan.</span>
                        </span>
                    </label>
                </div>
            </div>

            <div class="menu-form-page__actions">
                <a href="{{ route('owner.menus.index') }}" class="menu-form-page__button">Batal</a>
                <button type="submit"
                    class="menu-form-page__button menu-form-page__button--primary">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
