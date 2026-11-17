
<x-app-layout>
    <style>
        .transactions-page {
            display: grid;
            width: 100%;
            max-width: 1440px;
            gap: 20px;
            color: #211a17;
        }

        .transactions-header {
            padding-bottom: 17px;
            border-bottom: 1px solid #ded7ce;
        }

        .transactions-eyebrow {
            margin: 0 0 7px;
            color: #710014;
            font-size: 10px;
            font-weight: 700;
            letter-spacing: .14em;
            text-transform: uppercase;
        }

        .transactions-title {
            margin: 0;
            font-family: Georgia, 'Times New Roman', serif;
            font-size: clamp(26px, 3vw, 35px);
        }

        .transactions-subtitle {
            margin-top: 7px;
            color: #55504c;
            font-size: 13px;
        }

        .transactions-stats {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 12px;
        }

        .transactions-stat {
            min-width: 0;
            border: 1px solid #ded7ce;
            border-top: 3px solid #710014;
            border-radius: 7px;
            background: #fffdf9;
            padding: 15px;
        }

        .transactions-stat:nth-child(2) { border-top-color: #55734d; }
        .transactions-stat:nth-child(3) { border-top-color: #b38f6f; }
        .transactions-stat:nth-child(4) { border-top-color: #343130; }

        .transactions-stat-label {
            color: #55504c;
            font-size: 11px;
            font-weight: 700;
        }

        .transactions-stat-value {
            display: block;
            margin-top: 8px;
            color: #211a17;
            font-family: Georgia, 'Times New Roman', serif;
            font-size: clamp(19px, 2vw, 25px);
            font-weight: 700;
            overflow-wrap: anywhere;
        }

        .transactions-filter {
            display: grid;
            grid-template-columns: minmax(180px, 1fr) repeat(2, minmax(140px, 190px)) auto auto;
            align-items: end;
            gap: 10px;
            border: 1px solid #ded7ce;
            border-radius: 8px;
            background: #fffdf9;
            padding: 14px;
        }

        .transactions-label {
            display: block;
            margin-bottom: 5px;
            color: #343130;
            font-size: 10px;
            font-weight: 700;
        }

        .transactions-control {
            width: 100%;
            min-height: 40px;
            border: 1px solid #d4cdc4;
            border-radius: 5px;
            background: #fffdf9;
            padding: 8px 10px;
            color: #211a17;
            font-size: 11px;
        }

        .transactions-control:focus {
            border-color: #710014;
            outline: 0;
            box-shadow: 0 0 0 3px rgba(113, 0, 20, .12);
        }

        .transactions-button {
            display: inline-flex;
            min-height: 40px;
            align-items: center;
            justify-content: center;
            border: 1px solid #710014;
            border-radius: 5px;
            background: #710014;
            padding: 0 14px;
            color: white;
            font-size: 11px;
            font-weight: 700;
            text-decoration: none;
            white-space: nowrap;
            cursor: pointer;
        }

        .transactions-button:hover { background: #560010; }

        .transactions-button--reset {
            border-color: #d4cdc4;
            background: #fffdf9;
            color: #343130;
        }

        .transactions-button--reset:hover {
            background: #f5efe6;
        }

        .transactions-panel {
            overflow: hidden;
            border: 1px solid #ded7ce;
            border-radius: 8px;
            background: #fffdf9;
        }

        .transactions-panel-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            border-bottom: 1px solid #ded7ce;
            background: #f5efe6;
            padding: 15px 18px;
        }

        .transactions-panel-title {
            font-family: Georgia, 'Times New Roman', serif;
            font-size: 19px;
        }

        .transactions-panel-note,
        .transactions-count {
            color: #55504c;
            font-size: 10px;
        }

        .transactions-table-wrap { overflow-x: auto; }

        .transactions-table {
            width: 100%;
            border-collapse: collapse;
            min-width: 760px;
        }

        .transactions-table th {
            background: #fffaf2;
            padding: 13px 15px;
            color: #806e61;
            font-size: 9px;
            letter-spacing: .08em;
            text-align: left;
            text-transform: uppercase;
        }

        .transactions-table td {
            border-top: 1px solid #eee9e2;
            padding: 14px 15px;
            color: #343130;
            font-size: 11px;
            vertical-align: middle;
        }

        .transactions-table tbody tr:hover { background: #fffaf2; }

        .transaction-number {
            color: #710014;
            font-weight: 700;
        }

        .transaction-muted {
            display: block;
            margin-top: 4px;
            color: #806e61;
            font-size: 10px;
        }

        .transaction-amount {
            color: #710014;
            font-weight: 700;
            white-space: nowrap;
        }

        .transaction-badge {
            display: inline-flex;
            border: 1px solid #d4cdc4;
            border-radius: 999px;
            background: #f5efe6;
            padding: 5px 9px;
            color: #55504c;
            font-size: 9px;
            font-weight: 700;
            white-space: nowrap;
        }

        .transaction-badge--paid {
            border-color: #c8d8c1;
            background: #edf4e9;
            color: #385b31;
        }

        .transaction-detail {
            display: inline-flex;
            min-height: 31px;
            align-items: center;
            border: 1px solid #710014;
            border-radius: 5px;
            padding: 0 10px;
            color: #710014;
            font-size: 10px;
            font-weight: 700;
            text-decoration: none;
        }

        .transaction-detail:hover {
            background: #710014;
            color: white;
        }

        .transactions-empty {
            padding: 42px 18px;
            color: #55504c;
            text-align: center;
            font-size: 12px;
        }

        .transactions-pagination {
            border-top: 1px solid #ded7ce;
            padding: 13px 16px;
        }

        @media (max-width: 1100px) {
            .transactions-filter {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
            .transactions-stats {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 600px) {
            .transactions-filter,
            .transactions-stats {
                grid-template-columns: 1fr;
            }
            .transactions-filter > * { width: 100%; }
            .transactions-panel-head {
                align-items: flex-start;
                flex-direction: column;
            }
        }
    </style>

    <div class="transactions-page">
        <header class="transactions-header">
            <p class="transactions-eyebrow">Operasional / Keuangan</p>
            <h1 class="transactions-title">Transactions</h1>
            <p class="transactions-subtitle">
                Riwayat transaksi dan informasi pembayaran Restoe Boemi.
            </p>
        </header>

        <section class="transactions-stats">
            <article class="transactions-stat">
                <p class="transactions-stat-label">Total Transaksi</p>
                <strong class="transactions-stat-value">
                    {{ number_format($totalTransactions, 0, ',', '.') }}
                </strong>
            </article>

            <article class="transactions-stat">
                <p class="transactions-stat-label">Transaksi Lunas</p>
                <strong class="transactions-stat-value">
                    {{ number_format($paidTransactions, 0, ',', '.') }}
                </strong>
            </article>

            <article class="transactions-stat">
                <p class="transactions-stat-label">Belum Dibayar</p>
                <strong class="transactions-stat-value">
                    {{ number_format($unpaidTransactions, 0, ',', '.') }}
                </strong>
            </article>

            <article class="transactions-stat">
                <p class="transactions-stat-label">Total Omzet Lunas</p>
                <strong class="transactions-stat-value">
                    Rp {{ number_format((float) $totalRevenue, 0, ',', '.') }}
                </strong>
            </article>
        </section>

        <form method="GET" action="{{ route('owner.transactions.index') }}"
            class="transactions-filter">

            <div>
                <label for="transaction-search" class="transactions-label">Cari transaksi</label>
                <input id="transaction-search" type="search" name="search"
                    value="{{ request('search') }}"
                    placeholder="Nomor pesanan atau pelanggan"
                    class="transactions-control">
            </div>

            <div>
                <label for="payment-status" class="transactions-label">Status pembayaran</label>
                <select id="payment-status" name="payment_status" class="transactions-control">
                    <option value="">Semua status</option>
                    <option value="paid" @selected(request('payment_status') === 'paid')>Lunas</option>
                    <option value="unpaid" @selected(request('payment_status') === 'unpaid')>Belum dibayar</option>
                </select>
            </div>

            <div>
                <label for="payment-method" class="transactions-label">Metode pembayaran</label>
                <select id="payment-method" name="payment_method" class="transactions-control">
                    <option value="">Semua metode</option>
                    @foreach (['cash' => 'Tunai', 'transfer' => 'Transfer', 'qris' => 'QRIS', 'debit' => 'Debit'] as $value => $label)
                        <option value="{{ $value }}" @selected(request('payment_method') === $value)>
                            {{ $label }}
                        </option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="transactions-button">Terapkan</button>

            <a href="{{ route('owner.transactions.index') }}"
                class="transactions-button transactions-button--reset">Reset</a>
        </form>

        <section class="transactions-panel">
            <header class="transactions-panel-head">
                <div>
                    <h2 class="transactions-panel-title">Riwayat Transaksi</h2>
                    <p class="transactions-panel-note">
                        Catatan pembayaran dari pesanan QR Menu dan kasir.
                    </p>
                </div>
                <span class="transactions-count">
                    {{ $transactions->total() }} transaksi
                </span>
            </header>

            <div class="transactions-table-wrap">
                <table class="transactions-table">
                    <thead>
                        <tr>
                            <th>Nomor Transaksi</th>
                            <th>Pelanggan</th>
                            <th>Tanggal</th>
                            <th>Meja / Tipe</th>
                            <th>Total</th>
                            <th>Pembayaran</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($transactions as $transaction)
                            <tr>
                                <td>
                                    <span class="transaction-number">
                                        {{ $transaction->order_number }}
                                    </span>
                                    <span class="transaction-muted">
                                        {{ $transaction->items->sum('quantity') }} item
                                    </span>
                                </td>

                                <td>
                                    {{ $transaction->customer_name ?: 'Pelanggan' }}
                                </td>

                                <td>
                                    {{ ($transaction->ordered_at ?? $transaction->created_at)?->format('d/m/Y') ?? '-' }}
                                    <span class="transaction-muted">
                                        {{ ($transaction->ordered_at ?? $transaction->created_at)?->format('H:i') ?? '-' }}
                                    </span>
                                </td>

                                <td>
                                    {{ $transaction->diningTable?->table_number
                                        ? 'Meja ' . $transaction->diningTable->table_number
                                        : ($transaction->order_type === 'takeaway' ? 'Take Away' : 'QR / Meja') }}
                                </td>

                                <td>
                                    <span class="transaction-amount">
                                        Rp {{ number_format((float) $transaction->total, 0, ',', '.') }}
                                    </span>
                                </td>

                                <td>
                                    @if ($transaction->payment_status === 'paid')
                                        <span class="transaction-badge transaction-badge--paid">Lunas</span>
                                    @else
                                        <span class="transaction-badge">
                                            {{ ucfirst($transaction->payment_status ?? 'Belum dibayar') }}
                                        </span>
                                    @endif
                                    <span class="transaction-muted">
                                        {{ $transaction->payment_method
                                            ? strtoupper($transaction->payment_method)
                                            : 'Metode belum diisi' }}
                                    </span>
                                </td>

                                <td>
                                    <a href="{{ route('owner.transactions.show', $transaction) }}"
                                        class="transaction-detail">
                                        Detail
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="transactions-empty">
                                    Belum ada transaksi yang sesuai dengan pencarian.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($transactions->hasPages())
                <div class="transactions-pagination">
                    {{ $transactions->links() }}
                </div>
            @endif
        </section>
    </div>
</x-app-layout>
