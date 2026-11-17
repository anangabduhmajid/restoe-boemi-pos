<x-app-layout>
    <style>
        .table-form-page,
        .table-form-page * { box-sizing: border-box; }

        .table-form-page {
            display: grid;
            width: 100%;
            max-width: 820px;
            gap: 18px;
            color: #211a17;
        }

        .table-form-page__header {
            padding-bottom: 17px;
            border-bottom: 1px solid #ded7ce;
        }

        .table-form-page__back {
            display: inline-block;
            margin-bottom: 13px;
            color: #55504c;
            font-size: 12px;
            font-weight: 600;
            text-decoration: none;
        }

        .table-form-page__back:hover { color: #710014; }

        .table-form-page__eyebrow {
            margin: 0 0 7px;
            color: #710014;
            font-size: 10px;
            font-weight: 700;
            letter-spacing: .14em;
            text-transform: uppercase;
        }

        .table-form-page__title {
            margin: 0;
            color: #211a17;
            font-family: Georgia, 'Times New Roman', serif;
            font-size: clamp(24px, 3vw, 32px);
            line-height: 1.2;
        }

        .table-form-page__subtitle {
            margin: 7px 0 0;
            color: #55504c;
            font-size: 13px;
            line-height: 1.5;
        }

        .table-form-page__card {
            overflow: hidden;
            border: 1px solid #ded7ce;
            border-radius: 8px;
            background: #fffdf9;
        }

        .table-form-page__card-head {
            padding: 15px 20px;
            border-bottom: 1px solid #ded7ce;
            background: #f5efe6;
        }

        .table-form-page__card-title {
            margin: 0;
            color: #211a17;
            font-family: Georgia, 'Times New Roman', serif;
            font-size: 18px;
        }

        .table-form-page__card-note {
            margin: 4px 0 0;
            color: #55504c;
            font-size: 11px;
        }

        .table-form-page__required { color: #710014; }

        .table-form-page__fields {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 16px;
            padding: 20px;
        }

        .table-form-page__field { min-width: 0; }

        .table-form-page__label {
            display: block;
            margin-bottom: 6px;
            color: #343130;
            font-size: 11px;
            font-weight: 700;
        }

        .table-form-page__control {
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

        .table-form-page__control:focus {
            border-color: #710014;
            box-shadow: 0 0 0 3px rgba(113, 0, 20, .12);
            outline: 0;
        }

        .table-form-page__control:focus-visible,
        .table-form-page__back:focus-visible,
        .table-form-page__button:focus-visible {
            outline: 3px solid rgba(113, 0, 20, .2);
            outline-offset: 2px;
        }

        .table-form-page__error {
            margin: 5px 0 0;
            color: #710014;
            font-size: 11px;
        }

        .table-form-page__actions {
            display: flex;
            justify-content: flex-end;
            gap: 9px;
            padding: 14px 20px;
            border-top: 1px solid #ded7ce;
            background: #f5efe6;
        }

        .table-form-page__button {
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

        .table-form-page__button:hover { background: #f5efe6; }

        .table-form-page__button--primary {
            border-color: #710014;
            background: #710014;
            color: #fff;
        }

        .table-form-page__button--primary:hover {
            border-color: #560010;
            background: #560010;
        }

        @media (max-width: 600px) {
            .table-form-page { gap: 15px; }
            .table-form-page__fields { grid-template-columns: 1fr; gap: 14px; padding: 16px; }
            .table-form-page__actions { padding: 12px 16px; }
            .table-form-page__button { flex: 1; padding: 0 9px; }
        }
    </style>

    <div class="table-form-page">
        <header class="table-form-page__header">
            <a href="{{ route('owner.tables.index') }}" class="table-form-page__back">
                &larr; Kembali ke Manajemen Meja
            </a>
            <p class="table-form-page__eyebrow">Operasional / Meja baru</p>
            <h1 class="table-form-page__title">Tambah Meja</h1>
            <p class="table-form-page__subtitle">Masukkan informasi dasar meja restoran.</p>
        </header>

        <section class="table-form-page__card">
            <header class="table-form-page__card-head">
                <h2 class="table-form-page__card-title">Detail Meja</h2>
                <p class="table-form-page__card-note">
                    <span class="table-form-page__required">*</span> Kolom wajib diisi.
                </p>
            </header>

            <form action="{{ route('owner.tables.store') }}" method="POST">
                @csrf
                <div class="table-form-page__fields">
                    <div class="table-form-page__field">
                        <label for="table_number" class="table-form-page__label">
                            Nomor Meja <span class="table-form-page__required">*</span>
                        </label>
                        <input type="text" id="table_number" name="table_number"
                            value="{{ old('table_number') }}" placeholder="Contoh: T01"
                            maxlength="20" required class="table-form-page__control">
                        @error('table_number')
                            <p class="table-form-page__error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="table-form-page__field">
                        <label for="name" class="table-form-page__label">Nama / Area</label>
                        <input type="text" id="name" name="name" value="{{ old('name') }}"
                            placeholder="Contoh: Area Teras" maxlength="100"
                            class="table-form-page__control">
                        @error('name')
                            <p class="table-form-page__error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="table-form-page__field">
                        <label for="capacity" class="table-form-page__label">
                            Kapasitas Tempat Duduk <span class="table-form-page__required">*</span>
                        </label>
                        <input type="number" id="capacity" name="capacity"
                            value="{{ old('capacity', 2) }}" min="1" max="255"
                            required class="table-form-page__control">
                        @error('capacity')
                            <p class="table-form-page__error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="table-form-page__field">
                        <label for="status" class="table-form-page__label">
                            Status Meja <span class="table-form-page__required">*</span>
                        </label>
                        <select id="status" name="status" required class="table-form-page__control">
                            <option value="available" @selected(old('status', 'available') === 'available')>Tersedia</option>
                            <option value="occupied" @selected(old('status') === 'occupied')>Terisi</option>
                            <option value="reserved" @selected(old('status') === 'reserved')>Reservasi</option>
                            <option value="maintenance" @selected(old('status') === 'maintenance')>Perawatan</option>
                        </select>
                        @error('status')
                            <p class="table-form-page__error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="table-form-page__field">
                        <label for="sort_order" class="table-form-page__label">Urutan Tampilan</label>
                        <input type="number" id="sort_order" name="sort_order"
                            value="{{ old('sort_order', 0) }}" min="0"
                            class="table-form-page__control">
                        @error('sort_order')
                            <p class="table-form-page__error">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="table-form-page__actions">
                    <a href="{{ route('owner.tables.index') }}"
                        class="table-form-page__button">Batal</a>
                    <button type="submit"
                        class="table-form-page__button table-form-page__button--primary">
                        Simpan Meja
                    </button>
                </div>
            </form>
        </section>
    </div>
</x-app-layout>
