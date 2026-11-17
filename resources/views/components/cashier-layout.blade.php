@props([
    'pageTitle' => 'Dashboard',
    'active' => 'dashboard',
])

@php
    $cashierNotificationSnapshot = \App\Models\Order::query()
        ->selectRaw('COALESCE(MAX(id), 0) AS latest_id')
        ->selectRaw(
            'COALESCE(SUM(CASE WHEN payment_status = ? AND status <> ? THEN 1 ELSE 0 END), 0) AS pending_count',
            ['unpaid', 'cancelled']
        )
        ->first();
@endphp

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $pageTitle }} | Restoe Boemi POS</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        [x-cloak] {
            display: none !important;
        }

        html,
        body {
            width: 100%;
            height: 100%;
            margin: 0;
        }

        body.cashier-body {
            overflow: hidden;
            background: #4A0D0D;
            color: #211D1A;
        }

        .cashier-shell,
        .cashier-shell * {
            box-sizing: border-box;
        }

        .cashier-shell {
            display: flex;
            width: 100%;
            height: 100vh;
            gap: 12px;
            padding: 12px;
            overflow: hidden;
            background: #4A0D0D;
            font-family: Figtree, Inter, Arial, sans-serif;
        }

        .cashier-sidebar {
            position: sticky;
            top: 12px;
            display: flex;
            width: 220px;
            height: calc(100vh - 24px);
            flex: 0 0 220px;
            flex-direction: column;
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, .08);
            border-radius: 20px;
            background: #5A1212;
            padding: 24px 20px;
            color: #fff;
        }

        .cashier-sidebar__brand-row {
            display: flex;
            min-height: 34px;
            align-items: center;
            justify-content: space-between;
            gap: 6px;
        }

        .cashier-sidebar__brand {
            color: #E85D3F;
            font-size: 18px;
            font-weight: 800;
            letter-spacing: -.06em;
            line-height: 1;
            text-decoration: none;
            white-space: nowrap;
        }

        .cashier-sidebar__role {
            flex: 0 0 auto;
            border: 1px solid rgba(232, 93, 63, .55);
            border-radius: 999px;
            padding: 5px 8px;
            color: #F5A08C;
            font-size: 9px;
            font-weight: 700;
        }

        .cashier-sidebar__close {
            display: none;
            border: 0;
            border-radius: 999px;
            background: #FFFDF8;
            padding: 8px 12px;
            color: #4A0D0D;
            font: inherit;
            font-size: 10px;
            font-weight: 700;
            cursor: pointer;
        }

        .cashier-sidebar__user {
            margin-top: 20px;
            padding-bottom: 20px;
            border-bottom: 1px solid rgba(255, 255, 255, .18);
        }

        .cashier-sidebar__user-name {
            overflow: hidden;
            color: #fff;
            font-size: 13px;
            font-weight: 700;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .cashier-sidebar__user-role {
            margin-top: 4px;
            color: #F5A08C;
            font-size: 11px;
        }

        .cashier-sidebar__nav {
            min-height: 0;
            flex: 1 1 auto;
            margin: 18px -8px 12px;
            overflow-y: auto;
            padding: 0 8px;
        }

        .cashier-sidebar__section {
            margin: 0 0 8px;
            padding: 0 13px;
            color: #F5A08C;
            font-size: 9px;
            font-weight: 700;
            letter-spacing: .16em;
            text-transform: uppercase;
        }

        .cashier-nav-link {
            display: flex;
            min-height: 42px;
            align-items: center;
            gap: 12px;
            margin: 3px 0;
            border-radius: 999px;
            padding: 10px 13px;
            color: #F5A08C;
            font-size: 13px;
            font-weight: 700;
            line-height: 1.25;
            text-decoration: none;
            transition: background-color .16s ease, color .16s ease;
        }

        .cashier-nav-link:hover {
            background: #4A0D0D;
            color: #fff;
        }

        .cashier-nav-link.is-active {
            background: #E85D3F;
            color: #fff;
        }

        .cashier-nav-icon {
            display: flex;
            width: 19px;
            height: 19px;
            flex: 0 0 19px;
            align-items: center;
            justify-content: center;
        }

        .cashier-nav-icon svg {
            width: 19px;
            height: 19px;
        }

        .cashier-nav-count {
            min-width: 20px;
            margin-left: auto;
            border-radius: 999px;
            background: #E85D3F;
            padding: 3px 6px;
            color: #fff;
            font-size: 10px;
            font-weight: 800;
            line-height: 1.2;
            text-align: center;
        }

        .cashier-nav-link:focus-visible,
        .cashier-sidebar__close:focus-visible,
        .cashier-menu-toggle:focus-visible {
            outline: 3px solid rgba(232, 93, 63, .45);
            outline-offset: 2px;
        }

        .cashier-sidebar__account {
            flex: 0 0 auto;
            margin: 0 -8px;
            border-top: 1px solid rgba(255, 255, 255, .2);
            padding: 14px 8px 0;
        }

        .cashier-sidebar__account .cashier-sidebar__section {
            margin-bottom: 6px;
        }

        .cashier-sidebar__logout {
            width: 100%;
            border: 0;
            background: transparent;
            text-align: left;
            cursor: pointer;
        }

        .cashier-sidebar__footer {
            flex: 0 0 auto;
            margin-top: 12px;
            border-top: 1px solid rgba(255, 255, 255, .22);
            padding-top: 13px;
            color: #fff;
            font-size: 10px;
            line-height: 1.5;
        }

        .cashier-panel {
            display: flex;
            min-width: 0;
            height: calc(100vh - 24px);
            flex: 1 1 auto;
            flex-direction: column;
            overflow: hidden;
            border-radius: 20px;
            background: #FFFDF8;
        }

        .cashier-topbar {
            display: flex;
            height: 64px;
            min-height: 64px;
            flex: 0 0 64px;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            border-bottom: 1px solid #E8DED2;
            background: #FFFDF8;
            padding: 0 24px;
        }

        .cashier-topbar__identity {
            display: flex;
            min-width: 0;
            align-items: center;
            gap: 12px;
        }

        .cashier-topbar__title {
            min-width: 0;
        }

        .cashier-topbar__eyebrow {
            color: #4A0D0D;
            font-size: 9px;
            font-weight: 800;
            letter-spacing: .16em;
            line-height: 1.2;
        }

        .cashier-topbar__page {
            overflow: hidden;
            margin-top: 3px;
            color: #806E61;
            font-size: 11px;
            line-height: 1.2;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .cashier-topbar__name {
            overflow: hidden;
            max-width: 190px;
            color: #211D1A;
            font-size: 11px;
            font-weight: 700;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .cashier-topbar__actions {
            display: flex;
            min-width: 0;
            align-items: center;
            justify-content: flex-end;
            gap: 14px;
        }

        .cashier-notification-status {
            color: #806E61;
            font-size: 10px;
            white-space: nowrap;
        }

        .cashier-sound-toggle {
            flex: 0 0 auto;
            border: 1px solid #E8DED2;
            border-radius: 999px;
            background: #F5EFE6;
            padding: 8px 11px;
            color: #4A0D0D;
            font: inherit;
            font-size: 10px;
            font-weight: 700;
            cursor: pointer;
            transition: background-color .16s ease, color .16s ease;
        }

        .cashier-sound-toggle:hover {
            background: #E85D3F;
            color: #fff;
        }

        .cashier-sound-toggle:focus-visible,
        .cashier-order-toast__close:focus-visible,
        .cashier-order-toast__link:focus-visible {
            outline: 3px solid rgba(232, 93, 63, .45);
            outline-offset: 2px;
        }

        .cashier-menu-toggle {
            display: none;
            width: 38px;
            height: 38px;
            flex: 0 0 38px;
            align-items: center;
            justify-content: center;
            border: 0;
            border-radius: 50%;
            background: #5A1212;
            color: #fff;
            cursor: pointer;
        }

        .cashier-menu-toggle svg {
            width: 20px;
            height: 20px;
        }

        .cashier-content-scroll {
            min-height: 0;
            flex: 1 1 auto;
            overflow-x: hidden;
            overflow-y: auto;
            padding: 24px;
            overscroll-behavior: contain;
        }

        .cashier-backdrop {
            display: none;
        }

        .cashier-order-notifications {
            position: fixed;
            z-index: 45;
            top: 88px;
            right: 28px;
            display: grid;
            width: min(380px, calc(100vw - 32px));
            max-height: calc(100vh - 112px);
            gap: 12px;
            overflow-y: auto;
            pointer-events: none;
        }

        .cashier-order-toast {
            overflow: hidden;
            border: 1px solid #E8DCCF;
            border-left: 4px solid #4A0D0D;
            border-radius: 16px;
            background: #FFFDF8;
            padding: 16px;
            box-shadow: 0 16px 40px rgba(39, 19, 16, .2);
            pointer-events: auto;
            animation: cashier-toast-in .24s ease-out both;
        }

        .cashier-order-toast__header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
        }

        .cashier-order-toast__label {
            border-radius: 999px;
            background: #E85D3F;
            padding: 5px 9px;
            color: #fff;
            font-size: 9px;
            font-weight: 800;
            letter-spacing: .12em;
        }

        .cashier-order-toast__close {
            display: inline-flex;
            width: 28px;
            height: 28px;
            align-items: center;
            justify-content: center;
            border: 0;
            border-radius: 50%;
            background: #F5EFE6;
            color: #4A0D0D;
            font-size: 20px;
            line-height: 1;
            cursor: pointer;
        }

        .cashier-order-toast__number {
            margin-top: 10px;
            color: #4A0D0D;
            font-size: 16px;
            font-weight: 800;
        }

        .cashier-order-toast__details {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 12px;
            margin-top: 12px;
        }

        .cashier-order-toast__term {
            color: #806E61;
            font-size: 10px;
        }

        .cashier-order-toast__value {
            margin-top: 3px;
            color: #211D1A;
            font-size: 12px;
            font-weight: 700;
            overflow-wrap: anywhere;
        }

        .cashier-order-toast__value.is-highlighted {
            color: #E85D3F;
        }

        .cashier-order-toast__time {
            margin-top: 12px;
            color: #806E61;
            font-size: 10px;
        }

        .cashier-order-toast__link {
            display: inline-flex;
            margin-top: 12px;
            border-radius: 999px;
            background: #4A0D0D;
            padding: 8px 12px;
            color: #fff;
            font-size: 11px;
            font-weight: 700;
            text-decoration: none;
        }

        .cashier-order-toast__link:hover {
            background: #E85D3F;
        }

        .cashier-order-toast__audio-hint:not(:empty) {
            margin-top: 10px;
            color: #806E61;
            font-size: 10px;
        }

        @keyframes cashier-toast-in {
            from {
                opacity: 0;
                transform: translateX(18px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @media (max-width: 1023px) {
            .cashier-shell {
                display: block;
                height: 100vh;
                padding: 12px;
                background: #4A0D0D;
            }

            .cashier-sidebar {
                position: fixed;
                z-index: 51;
                top: 0;
                left: 0;
                width: min(85vw, 300px);
                max-width: 300px;
                height: 100vh;
                border: 0;
                border-radius: 0 24px 24px 0;
                background: #4A0D0D;
                box-shadow: 16px 0 44px rgba(0, 0, 0, .2);
                transform: translateX(-105%);
                transition: transform .24s ease;
            }

            .cashier-sidebar.is-open {
                transform: translateX(0);
            }

            .cashier-sidebar__close {
                display: inline-flex;
                align-items: center;
                justify-content: center;
            }

            .cashier-backdrop {
                position: fixed;
                z-index: 50;
                display: block;
                inset: 0;
                background: rgba(0, 0, 0, .5);
            }

            .cashier-panel {
                width: 100%;
                height: calc(100vh - 24px);
            }

            .cashier-menu-toggle {
                display: inline-flex;
            }

            .cashier-topbar__actions {
                gap: 8px;
            }

            .cashier-notification-status {
                display: none;
            }

            .cashier-content-scroll {
                padding: 20px;
            }

            .cashier-order-notifications {
                top: 80px;
                right: 20px;
            }
        }

        @media (max-width: 520px) {
            .cashier-sidebar__brand {
                font-size: 17px;
            }

            .cashier-topbar {
                gap: 8px;
                padding: 0 12px;
            }

            .cashier-topbar__identity {
                gap: 8px;
            }

            .cashier-topbar__name {
                max-width: 85px;
                font-size: 10px;
            }

            .cashier-sound-toggle {
                padding: 7px 9px;
                font-size: 9px;
            }

            .cashier-content-scroll {
                padding: 16px;
            }

            .cashier-order-notifications {
                right: 16px;
                width: calc(100vw - 32px);
            }
        }
    </style>
</head>

<body class="cashier-body antialiased">
    <div
        x-data="{ sidebarOpen: false }"
        @keydown.escape.window="sidebarOpen = false"
        class="cashier-shell"
        data-cashier-notifications
        data-poll-url="{{ route('cashier.orders.notifications') }}"
        data-initial-order-id="{{ $cashierNotificationSnapshot->latest_id }}">

        <div
            x-cloak
            x-show="sidebarOpen"
            x-transition.opacity
            class="cashier-backdrop"
            aria-hidden="true"
            @click="sidebarOpen = false"></div>

        <aside
            class="cashier-sidebar"
            :class="{ 'is-open': sidebarOpen }"
            aria-label="Navigasi Kasir">
            <div class="cashier-sidebar__brand-row">
                <a href="{{ route('cashier.dashboard') }}" class="cashier-sidebar__brand">restoe boemi</a>
                <span class="cashier-sidebar__role">Cashier</span>
                <button
                    type="button"
                    class="cashier-sidebar__close"
                    aria-label="Close sidebar"
                    @click="sidebarOpen = false">
                    Close
                </button>
            </div>

            <div class="cashier-sidebar__user">
                <p class="cashier-sidebar__user-name">{{ auth()->user()->name }}</p>
                <p class="cashier-sidebar__user-role">Petugas Kasir</p>
            </div>

            <nav class="cashier-sidebar__nav" aria-label="Menu utama Kasir">
                <p class="cashier-sidebar__section">Menu Utama</p>

                <a
                    href="{{ route('cashier.dashboard') }}"
                    class="cashier-nav-link {{ request()->routeIs('cashier.dashboard') ? 'is-active' : '' }}"
                    @if (request()->routeIs('cashier.dashboard')) aria-current="page" @endif
                    @click="sidebarOpen = false">
                    <span class="cashier-nav-icon" aria-hidden="true">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4 4h7v7H4V4Zm9 0h7v4h-7V4Zm0 6h7v10h-7V10ZM4 13h7v7H4v-7Z" />
                        </svg>
                    </span>
                    Dashboard
                </a>
                <a
                    href="{{ route('cashier.orders.create') }}"
                    class="cashier-nav-link {{ request()->routeIs('cashier.orders.create') ? 'is-active' : '' }}"
                    @if (request()->routeIs('cashier.orders.create')) aria-current="page" @endif
                    @click="sidebarOpen = false">
                    <span class="cashier-nav-icon" aria-hidden="true">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M6 4h12a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2Zm3 4h6m-6 4h6m-6 4h3" />
                        </svg>
                    </span>
                    Buat Pesanan
                </a>
                <a
                    href="{{ route('cashier.payments.index') }}"
                    class="cashier-nav-link {{ request()->routeIs('cashier.payments.*') ? 'is-active' : '' }}"
                    @if (request()->routeIs('cashier.payments.*')) aria-current="page" @endif
                    @click="sidebarOpen = false">
                    <span class="cashier-nav-icon" aria-hidden="true">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 7h18v12H3V7Zm0 4h18M7 15h3" />
                        </svg>
                    </span>
                    Pembayaran
                    <span
                        id="cashier-payment-pending-count"
                        class="cashier-nav-count"
                        @if ((int) $cashierNotificationSnapshot->pending_count === 0) hidden @endif
                        aria-label="{{ (int) $cashierNotificationSnapshot->pending_count }} pesanan belum dibayar">
                        {{ (int) $cashierNotificationSnapshot->pending_count > 99 ? '99+' : (int) $cashierNotificationSnapshot->pending_count }}
                    </span>
                </a>
            </nav>

            <div class="cashier-sidebar__account">
                <p class="cashier-sidebar__section">Account</p>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="cashier-nav-link cashier-sidebar__logout">
                        <span class="cashier-nav-icon" aria-hidden="true">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M10 17l5-5-5-5m5 5H3m9-9h6a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-6" />
                            </svg>
                        </span>
                        Keluar
                    </button>
                </form>
            </div>

            <footer class="cashier-sidebar__footer">
                2026 © Restoe Boemi. All rights reserved.
            </footer>
        </aside>

        <main class="cashier-panel">
            <header class="cashier-topbar">
                <div class="cashier-topbar__identity">
                    <button
                        type="button"
                        class="cashier-menu-toggle"
                        aria-label="Buka navigasi Kasir"
                        @click="sidebarOpen = true">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                    <div class="cashier-topbar__title">
                        <p class="cashier-topbar__eyebrow">RUANG KASIR</p>
                        <p class="cashier-topbar__page">{{ $pageTitle }}</p>
                    </div>
                </div>
                <div class="cashier-topbar__actions">
                    <span id="cashier-notification-status" class="cashier-notification-status" aria-live="polite">
                        Notifikasi real-time aktif
                    </span>
                    <button
                        type="button"
                        id="cashier-sound-toggle"
                        class="cashier-sound-toggle"
                        aria-pressed="false">
                        Suara: Mati
                    </button>
                    <p class="cashier-topbar__name">{{ auth()->user()->name }}</p>
                </div>
            </header>

            <div class="cashier-content-scroll">
                {{ $slot }}
            </div>
        </main>
    </div>
    <div
        id="cashier-order-notifications"
        class="cashier-order-notifications"
        role="region"
        aria-label="Notifikasi pesanan baru"
        aria-live="polite"
        aria-relevant="additions"></div>
    <x-notification-system theme="admin" />
</body>

</html>
