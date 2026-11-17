<x-app-layout>
    <style>
        .orders-page,
        .orders-page * { box-sizing: border-box; }

        .orders-page {
            display: grid;
            width: 100%;
            max-width: 1440px;
            gap: 20px;
            color: #211a17;
        }

        .orders-page__header {
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            gap: 16px;
            padding-bottom: 17px;
            border-bottom: 1px solid #ded7ce;
        }

        .orders-page__eyebrow {
            margin: 0 0 7px;
            color: #710014;
            font-size: 10px;
            font-weight: 700;
            letter-spacing: .14em;
            text-transform: uppercase;
        }

        .orders-page__title {
            margin: 0;
            color: #211a17;
            font-family: Georgia, 'Times New Roman', serif;
            font-size: clamp(26px, 3vw, 35px);
            line-height: 1.15;
        }

        .orders-page__subtitle {
            margin: 7px 0 0;
            color: #55504c;
            font-size: 13px;
            line-height: 1.5;
        }

        .orders-page__stats {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 12px;
        }

        .orders-page__stat {
            display: flex;
            min-width: 0;
            min-height: 84px;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
            border: 1px solid #ded7ce;
            border-top: 3px solid #710014;
            border-radius: 7px;
            background: #fffdf9;
            padding: 13px 15px;
        }

        .orders-page__stat:nth-child(2) { border-top-color: #8c2637; }
        .orders-page__stat:nth-child(3) { border-top-color: #806e61; }
        .orders-page__stat:nth-child(4) { border-top-color: #343130; }

        .orders-page__stat-label {
            margin: 0;
            color: #55504c;
            font-size: 11px;
            font-weight: 700;
        }

        .orders-page__stat-value {
            color: #211a17;
            font-family: Georgia, 'Times New Roman', serif;
            font-size: 25px;
            font-weight: 700;
        }

        .orders-page__filter {
            display: grid;
            grid-template-columns: minmax(220px, 1fr) minmax(170px, 230px) auto auto;
            align-items: end;
            gap: 10px;
            border: 1px solid #ded7ce;
            border-radius: 8px;
            background: #fffdf9;
            padding: 14px;
        }

        .orders-page__filter-field { min-width: 0; }

        .orders-page__label {
            display: block;
            margin-bottom: 5px;
            color: #343130;
            font-size: 10px;
            font-weight: 700;
        }

        .orders-page__control {
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

        .orders-page__control:focus {
            border-color: #710014;
            box-shadow: 0 0 0 3px rgba(113, 0, 20, .12);
            outline: 0;
        }

        .orders-page__control:focus-visible,
        .orders-page__button:focus-visible,
        .orders-page__detail:focus-visible {
            outline: 3px solid rgba(113, 0, 20, .2);
            outline-offset: 2px;
        }

        .orders-page__button {
            display: inline-flex;
            min-height: 40px;
            align-items: center;
            justify-content: center;
            border: 1px solid #710014;
            border-radius: 5px;
            background: #710014;
            padding: 0 14px;
            color: #fff;
            font: inherit;
            font-size: 11px;
            font-weight: 700;
            text-decoration: none;
            white-space: nowrap;
            cursor: pointer;
        }

        .orders-page__button:hover { background: #560010; }

        .orders-page__button--reset {
            border-color: #d4cdc4;
            background: #fffdf9;
            color: #343130;
        }

        .orders-page__button--reset:hover {
            border-color: #b6a8a0;
            background: #f5efe6;
        }

        .orders-page__panel {
            overflow: hidden;
            border: 1px solid #ded7ce;
            border-radius: 8px;
            background: #fffdf9;
        }

        .orders-page__panel-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            border-bottom: 1px solid #ded7ce;
            background: #f5efe6;
            padding: 15px 18px;
        }

        .orders-page__panel-title {
            margin: 0;
            color: #211a17;
            font-family: Georgia, 'Times New Roman', serif;
            font-size: 19px;
        }

        .orders-page__panel-note {
            margin: 4px 0 0;
            color: #55504c;
            font-size: 10px;
        }

        .orders-page__count {
            flex: 0 0 auto;
            color: #55504c;
            font-size: 10px;
        }

        .orders-page__grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 12px;
            padding: 14px;
        }

        .orders-page__card {
            min-width: 0;
            border: 1px solid #ded7ce;
            border-radius: 7px;
            background: #fffdf9;
            padding: 14px;
        }

        .orders-page__card-head {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 10px;
            padding-bottom: 11px;
            border-bottom: 1px solid #eee9e2;
        }

        .orders-page__number {
            margin: 0;
            color: #211a17;
            font-size: 13px;
            font-weight: 700;
            overflow-wrap: anywhere;
        }

        .orders-page__time {
            margin: 4px 0 0;
            color: #806e61;
            font-size: 10px;
        }

        .orders-page__status {
            flex: 0 0 auto;
            border: 1px solid #d8c2c5;
            border-radius: 999px;
            background: #f5e9eb;
            padding: 4px 8px;
            color: #710014;
            font-size: 9px;
            font-weight: 700;
            white-space: nowrap;
        }

        .orders-page__status--preparing {
            border-color: #d4cdc4;
            background: #f5efe6;
            color: #343130;
        }

        .orders-page__status--completed {
            border-color: #343130;
            background: #343130;
            color: #fffdf9;
        }

        .orders-page__status--cancelled {
            border-color: #ded7ce;
            background: #e8e4de;
            color: #55504c;
        }

        .orders-page__info {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 11px;
            padding: 12px 0;
        }

        .orders-page__info-label {
            display: block;
            margin-bottom: 4px;
            color: #806e61;
            font-size: 9px;
            letter-spacing: .04em;
            text-transform: uppercase;
        }

        .orders-page__info-value {
            display: block;
            overflow: hidden;
            color: #343130;
            font-size: 11px;
            font-weight: 600;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .orders-page__summary {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
            border-top: 1px solid #eee9e2;
            padding-top: 11px;
        }

        .orders-page__items {
            color: #55504c;
            font-size: 10px;
        }

        .orders-page__total {
            color: #710014;
            font-family: Georgia, 'Times New Roman', serif;
            font-size: 17px;
            font-weight: 700;
            white-space: nowrap;
        }

        .orders-page__card-foot {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
            margin-top: 11px;
        }

        .orders-page__payment {
            color: #55504c;
            font-size: 10px;
        }

        .orders-page__detail {
            display: inline-flex;
            min-height: 32px;
            align-items: center;
            justify-content: center;
            border: 1px solid #710014;
            border-radius: 5px;
            background: #fffdf9;
            padding: 0 10px;
            color: #710014;
            font-size: 10px;
            font-weight: 700;
            text-decoration: none;
            white-space: nowrap;
        }

        .orders-page__detail:hover {
            background: #710014;
            color: #fff;
        }

        .orders-page__empty {
            grid-column: 1 / -1;
            padding: 42px 18px;
            color: #55504c;
            text-align: center;
        }

        .orders-page__empty-mark {
            display: inline-flex;
            width: 42px;
            height: 42px;
            align-items: center;
            justify-content: center;
            border: 1px solid #d8c2c5;
            border-radius: 50%;
            background: #f5e9eb;
            color: #710014;
            font-family: Georgia, 'Times New Roman', serif;
            font-size: 20px;
        }

        .orders-page__empty h3 {
            margin: 11px 0 0;
            color: #211a17;
            font-family: Georgia, 'Times New Roman', serif;
            font-size: 18px;
        }

        .orders-page__empty p {
            margin: 6px 0 0;
            color: #55504c;
            font-size: 11px;
        }

        .orders-page__pagination { border-top: 1px solid #ded7ce; padding: 13px 16px; }

        @media (max-width: 1050px) {
            .orders-page__stats { grid-template-columns: repeat(2, minmax(0, 1fr)); }
            .orders-page__filter { grid-template-columns: minmax(0, 1fr) minmax(160px, .7fr); }
            .orders-page__filter > .orders-page__button { width: 100%; }
        }

        @media (max-width: 700px) {
            .orders-page { gap: 15px; }
            .orders-page__header { align-items: flex-start; }
            .orders-page__stats { gap: 8px; }
            .orders-page__stat { min-height: 68px; padding: 10px 12px; }
            .orders-page__stat-value { font-size: 21px; }
            .orders-page__filter { grid-template-columns: 1fr; }
            .orders-page__grid { grid-template-columns: 1fr; gap: 9px; padding: 10px; }
            .orders-page__panel-head { align-items: flex-start; flex-direction: column; }
        }

        @media (max-width: 430px) {
            .orders-page__stats { grid-template-columns: 1fr; }
            .orders-page__stat { min-height: 60px; }
            .orders-page__card { padding: 12px; }
        }
    </style>

    <div class="orders-page">
        <header class="orders-page__header">
            <div>
                <p class="orders-page__eyebrow">Operasional / Pesanan</p>
                <h1 class="orders-page__title">Orders</h1>
                <p class="orders-page__subtitle">Pantau dan kelola pesanan Restoe Boemi.</p>
            </div>
        </header>

        <section class="orders-page__stats" aria-label="Ringkasan pesanan">
            <article class="orders-page__stat">
                <p class="orders-page__stat-label">Total pesanan</p>
                <span class="orders-page__stat-value">{{ $totalOrders }}</span>
            </article>
            <article class="orders-page__stat">
                <p class="orders-page__stat-label">Pesanan baru</p>
                <span class="orders-page__stat-value">{{ $newOrders }}</span>
            </article>
            <article class="orders-page__stat">
                <p class="orders-page__stat-label">Sedang disiapkan</p>
                <span class="orders-page__stat-value">{{ $processingOrders }}</span>
            </article>
            <article class="orders-page__stat">
                <p class="orders-page__stat-label">Selesai</p>
                <span class="orders-page__stat-value">{{ $completedOrders }}</span>
            </article>
        </section>

        <form method="GET" action="{{ route('owner.orders.index') }}" class="orders-page__filter">
            <div class="orders-page__filter-field">
                <label for="order-search" class="orders-page__label">Cari pesanan</label>
                <input id="order-search" type="search" name="search" value="{{ request('search') }}"
                    placeholder="Nomor pesanan atau nama pelanggan"
                    class="orders-page__control">
            </div>
            <div class="orders-page__filter-field">
                <label for="order-status" class="orders-page__label">Status pesanan</label>
                <select id="order-status" name="status" class="orders-page__control">
                    <option value="">Semua status</option>
                    <option value="new" @selected(request('status') === 'new')>Baru</option>
                    <option value="preparing" @selected(request('status') === 'preparing')>Disiapkan</option>
                    <option value="completed" @selected(request('status') === 'completed')>Selesai</option>
                    <option value="cancelled" @selected(request('status') === 'cancelled')>Dibatalkan</option>
                </select>
            </div>
            <button type="submit" class="orders-page__button">Terapkan</button>
            <a href="{{ route('owner.orders.index') }}"
                class="orders-page__button orders-page__button--reset">Reset</a>
        </form>

        <section class="orders-page__panel">
            <header class="orders-page__panel-head">
                <div>
                    <h2 class="orders-page__panel-title">Daftar Pesanan</h2>
                    <p class="orders-page__panel-note">Pantau meja, item, pembayaran, dan progres pesanan.</p>
                </div>
                <span class="orders-page__count">{{ $orders->total() }} pesanan</span>
            </header>

            <div class="orders-page__grid">
                @forelse ($orders as $order)
                    @php
                        $statusClasses = [
                            'new' => '',
                            'preparing' => 'orders-page__status--preparing',
                            'completed' => 'orders-page__status--completed',
                            'cancelled' => 'orders-page__status--cancelled',
                        ];
                        $statusLabels = [
                            'new' => 'Baru',
                            'preparing' => 'Disiapkan',
                            'completed' => 'Selesai',
                            'cancelled' => 'Dibatalkan',
                        ];
                    @endphp
                    <article class="orders-page__card">
                        <header class="orders-page__card-head">
                            <div>
                                <h3 class="orders-page__number">{{ $order->order_number }}</h3>
                                <p class="orders-page__time">{{ $order->created_at->format('d/m/Y · H:i') }}</p>
                            </div>
                            <span class="orders-page__status {{ $statusClasses[$order->status] ?? '' }}">
                                {{ $statusLabels[$order->status] ?? ucfirst($order->status) }}
                            </span>
                        </header>

                        <div class="orders-page__info">
                            <div>
                                <span class="orders-page__info-label">Pelanggan</span>
                                <span class="orders-page__info-value">{{ $order->customer_name ?? 'Pelanggan' }}</span>
                            </div>
                            <div>
                                <span class="orders-page__info-label">Meja</span>
                                <span class="orders-page__info-value">
                                    {{ $order->diningTable?->table_number ?? 'Take Away' }}
                                </span>
                            </div>
                        </div>

                        <div class="orders-page__summary">
                            <span class="orders-page__items">{{ $order->items->sum('quantity') }} item</span>
                            <strong class="orders-page__total">
                                Rp {{ number_format((float) $order->total, 0, ',', '.') }}
                            </strong>
                        </div>

                        <footer class="orders-page__card-foot">
                            <span class="orders-page__payment">
                                Pembayaran: {{ ucfirst($order->payment_status) }}
                            </span>
                            <a href="{{ route('owner.orders.show', $order) }}" class="orders-page__detail">
                                Detail <span aria-hidden="true">&rarr;</span>
                            </a>
                        </footer>
                    </article>
                @empty
                    <div class="orders-page__empty">
                        <span class="orders-page__empty-mark" aria-hidden="true">—</span>
                        <h3>Belum ada pesanan</h3>
                        <p>Pesanan pelanggan akan muncul di halaman ini.</p>
                    </div>
                @endforelse
            </div>

            @if ($orders->hasPages())
                <div class="orders-page__pagination">{{ $orders->links() }}</div>
            @endif
        </section>
    </div>
</x-app-layout>
