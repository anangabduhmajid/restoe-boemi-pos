<x-app-layout>
    <style>
        .tables-page,
        .tables-page * {
            box-sizing: border-box;
        }

        .tables-page {
            display: grid;
            width: 100%;
            gap: 20px;
            color: #211a17;
        }

        .tables-page__header {
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            gap: 18px;
            padding-bottom: 18px;
            border-bottom: 1px solid #ded7ce;
        }

        .tables-page__eyebrow {
            margin: 0 0 7px;
            color: #710014;
            font-size: 10px;
            font-weight: 700;
            letter-spacing: .14em;
            text-transform: uppercase;
        }

        .tables-page__title {
            margin: 0;
            color: #211a17;
            font-family: Georgia, 'Times New Roman', serif;
            font-size: clamp(25px, 3vw, 33px);
            line-height: 1.15;
        }

        .tables-page__subtitle {
            margin: 7px 0 0;
            color: #55504c;
            font-size: 13px;
            line-height: 1.5;
        }

        .tables-page__button {
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
            transition: background-color .15s ease, border-color .15s ease, color .15s ease;
        }

        .tables-page__button--primary {
            border-color: #710014;
            background: #710014;
            color: #fff;
        }

        .tables-page__button--primary:hover {
            border-color: #560010;
            background: #560010;
        }

        .tables-page__button--secondary {
            border-color: #d4cdc4;
            background: #fffdf9;
            color: #343130;
        }

        .tables-page__button--secondary:hover {
            background: #f5efe6;
        }

        .tables-page__button:focus-visible,
        .tables-page__action:focus-visible {
            outline: 3px solid rgba(113, 0, 20, .2);
            outline-offset: 2px;
        }

        .tables-page__notice {
            border: 1px solid #d4cdc4;
            border-left: 4px solid #710014;
            border-radius: 6px;
            background: #f5efe6;
            padding: 12px 15px;
            color: #343130;
            font-size: 13px;
        }

        .tables-page__notice ul {
            margin: 7px 0 0;
            padding-left: 18px;
        }

        .tables-page__stats {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 12px;
        }

        .tables-page__stat {
            display: flex;
            min-width: 0;
            min-height: 76px;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            border: 1px solid #ded7ce;
            border-top: 3px solid #710014;
            border-radius: 7px;
            background: #fffdf9;
            padding: 13px 15px;
        }

        .tables-page__stat:nth-child(3) {
            border-top-color: #343130;
        }

        .tables-page__stat:nth-child(4) {
            border-top-color: #806e61;
        }

        .tables-page__stat-label {
            margin: 0;
            color: #55504c;
            font-size: 11px;
            font-weight: 600;
        }

        .tables-page__stat-value {
            color: #211a17;
            font-family: Georgia, 'Times New Roman', serif;
            font-size: 24px;
            font-weight: 700;
        }

        .tables-page__panel {
            overflow: hidden;
            border: 1px solid #ded7ce;
            border-radius: 8px;
            background: #fffdf9;
        }

        .tables-page__panel-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            padding: 15px 18px;
            border-bottom: 1px solid #ded7ce;
            background: #f5efe6;
        }

        .tables-page__panel-title {
            margin: 0;
            color: #211a17;
            font-family: Georgia, 'Times New Roman', serif;
            font-size: 19px;
        }

        .tables-page__panel-note {
            margin: 4px 0 0;
            color: #55504c;
            font-size: 11px;
        }

        .tables-page__table-wrap {
            overflow-x: auto;
        }

        .tables-page__table {
            width: 100%;
            min-width: 700px;
            border-collapse: collapse;
            text-align: left;
            font-size: 12px;
        }

        .tables-page__table th {
            padding: 12px 16px;
            border-bottom: 1px solid #ded7ce;
            background: #fffdf9;
            color: #55504c;
            font-size: 10px;
            font-weight: 700;
            letter-spacing: .06em;
            text-transform: uppercase;
        }

        .tables-page__table td {
            padding: 13px 16px;
            border-bottom: 1px solid #eee9e2;
            color: #55504c;
            vertical-align: middle;
        }

        .tables-page__table tbody tr:last-child td {
            border-bottom: 0;
        }

        .tables-page__table tbody tr:hover {
            background: #fcfaf6;
        }

        .tables-page__table .tables-page__table-number {
            color: #211a17;
            font-weight: 700;
        }

        .tables-page__table .tables-page__actions-cell {
            text-align: right;
        }

        .tables-page__status {
            display: inline-flex;
            min-height: 24px;
            align-items: center;
            border: 1px solid #d4cdc4;
            border-radius: 999px;
            background: #f5efe6;
            padding: 3px 9px;
            color: #343130;
            font-size: 10px;
            font-weight: 700;
            white-space: nowrap;
        }

        .tables-page__status--available {
            border-color: #d8c2c5;
            background: #f5e9eb;
            color: #710014;
        }

        .tables-page__status--occupied {
            border-color: #343130;
            background: #343130;
            color: #fffdf9;
        }

        .tables-page__status--reserved {
            border-color: #d4cdc4;
            background: #f5efe6;
            color: #343130;
        }

        .tables-page__status--maintenance {
            border-color: #ded7ce;
            background: #e8e4de;
            color: #55504c;
        }

        .tables-page__actions {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 6px;
        }

        .tables-page__actions form {
            margin: 0;
        }

        .tables-page__action {
            display: inline-flex;
            min-height: 31px;
            align-items: center;
            justify-content: center;
            border: 1px solid #d4cdc4;
            border-radius: 5px;
            background: #fffdf9;
            padding: 0 9px;
            color: #343130;
            font: inherit;
            font-size: 10px;
            font-weight: 700;
            text-decoration: none;
            white-space: nowrap;
            cursor: pointer;
        }

        .tables-page__action:hover {
            background: #f5efe6;
        }

        .tables-page__action--primary {
            border-color: #710014;
            color: #710014;
        }

        .tables-page__action--delete {
            border-color: #d8c2c5;
            color: #710014;
        }

        .tables-page__empty {
            padding: 36px 18px !important;
            color: #55504c !important;
            text-align: center;
        }

        .tables-page__empty strong {
            display: block;
            color: #211a17;
            font-family: Georgia, 'Times New Roman', serif;
            font-size: 18px;
        }

        .tables-page__empty p {
            margin: 6px 0 14px;
        }

        .tables-page__pagination {
            border-top: 1px solid #ded7ce;
            padding: 13px 16px;
        }

        @media (max-width: 900px) {
            .tables-page__stats {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 600px) {
            .tables-page {
                gap: 15px;
            }

            .tables-page__header {
                align-items: stretch;
                flex-direction: column;
            }

            .tables-page__header>.tables-page__button {
                width: 100%;
            }

            .tables-page__stat {
                min-height: 66px;
                padding: 10px 12px;
            }

            .tables-page__stat-value {
                font-size: 21px;
            }

            .tables-page__panel-head {
                align-items: flex-start;
                flex-direction: column;
            }

            .tables-page__actions {
                justify-content: flex-start;
            }
        }
    </style>

    <div class="tables-page">
        <header class="tables-page__header">
            <div>
                <p class="tables-page__eyebrow">Operasional / Area makan</p>
                <h1 class="tables-page__title">Manajemen Meja</h1>
                <p class="tables-page__subtitle">
                    Kelola kapasitas, status, dan QR untuk meja restoran.
                </p>
            </div>

            <a href="{{ route('owner.tables.create') }}" class="tables-page__button tables-page__button--primary">
                <span aria-hidden="true">+</span> Tambah Meja
            </a>
        </header>

        @if (session('success'))
        <div role="status" class="tables-page__notice">{{ session('success') }}</div>
        @endif
        @if (session('error'))
        <div role="alert" class="tables-page__notice">
            {{ session('error') }}
        </div>
        @endif
        @if ($errors->any())
        <div role="alert" class="tables-page__notice">
            <strong>Periksa kembali data yang diisi.</strong>
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <section class="tables-page__stats" aria-label="Ringkasan meja">
            <article class="tables-page__stat">
                <p class="tables-page__stat-label">Total meja</p>
                <span class="tables-page__stat-value">{{ $tables->total() }}</span>
            </article>

            @foreach ([
            'available' => 'Tersedia',
            'occupied' => 'Terisi',
            'reserved' => 'Reservasi',
            ] as $status => $label)
            <article class="tables-page__stat">
                <p class="tables-page__stat-label">{{ $label }}</p>
                <span class="tables-page__stat-value">
                    {{ \App\Models\DiningTable::where('status', $status)->count() }}
                </span>
            </article>
            @endforeach
        </section>

        <section class="tables-page__panel">
            <header class="tables-page__panel-head">
                <div>
                    <h2 class="tables-page__panel-title">Daftar Meja</h2>
                    <p class="tables-page__panel-note">Akses QR dan kelola informasi setiap meja.</p>
                </div>
                <p class="tables-page__panel-note">
                    {{ $tables->firstItem() ?? 0 }}–{{ $tables->lastItem() ?? 0 }}
                    dari {{ $tables->total() }} meja
                </p>
            </header>

            <div class="tables-page__table-wrap">
                <table class="tables-page__table">
                    <thead>
                        <tr>
                            <th scope="col">Meja</th>
                            <th scope="col">Nama / Area</th>
                            <th scope="col">Kapasitas</th>
                            <th scope="col">Status</th>
                            <th scope="col" style="text-align:right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($tables as $table)
                        @php
                        $statusLabels = [
                        'available' => 'Tersedia',
                        'occupied' => 'Terisi',
                        'reserved' => 'Reservasi',
                        'maintenance' => 'Perawatan',
                        ];
                        $statusClasses = [
                        'available' => 'tables-page__status--available',
                        'occupied' => 'tables-page__status--occupied',
                        'reserved' => 'tables-page__status--reserved',
                        'maintenance' => 'tables-page__status--maintenance',
                        ];
                        @endphp
                        <tr>
                            <td class="tables-page__table-number">{{ $table->table_number }}</td>
                            <td>{{ $table->name ?: '-' }}</td>
                            <td>{{ $table->capacity }} orang</td>
                            <td>
                                <span class="tables-page__status {{ $statusClasses[$table->status] ?? '' }}">
                                    {{ $statusLabels[$table->status] ?? $table->status }}
                                </span>
                            </td>
                            <td class="tables-page__actions-cell">
                                <div class="tables-page__actions">
                                    <a href="{{ route('owner.tables.qr', $table) }}"
                                        class="tables-page__action tables-page__action--primary">QR Code</a>
                                    <a href="{{ route('owner.tables.edit', $table) }}"
                                        class="tables-page__action">Edit</a>
                                    @if ($table->status === 'occupied')
                                    <form action="{{ route('owner.tables.clear', $table) }}" method="POST"
                                        data-confirm-title="Kosongkan meja?"
                                        data-confirm-message="Yakin pesanan di meja '{{ $table->table_number }}' sudah selesai dan meja ingin dikosongkan?"
                                        data-confirm-action="Kosongkan meja">
                                        @csrf
                                        <button type="submit" class="tables-page__action tables-page__action--primary">
                                            Kosongkan
                                        </button>
                                    </form>
                                    @endif
                                    <form action="{{ route('owner.tables.destroy', $table) }}" method="POST"
                                        data-confirm-title="Hapus meja?"
                                        data-confirm-message="Yakin ingin menghapus meja '{{ $table->table_number }}'? Aksi ini tidak dapat dibatalkan."
                                        data-confirm-action="Hapus"
                                        data-confirm-type="danger">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="tables-page__action tables-page__action--delete">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="tables-page__empty">
                                <strong>Belum ada data meja</strong>
                                <p>Tambahkan meja pertama untuk mulai mengelola area restoran.</p>
                                <a href="{{ route('owner.tables.create') }}"
                                    class="tables-page__button tables-page__button--primary">
                                    + Tambah Meja
                                </a>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($tables->hasPages())
            <div class="tables-page__pagination">{{ $tables->links() }}</div>
            @endif
        </section>
    </div>
</x-app-layout>