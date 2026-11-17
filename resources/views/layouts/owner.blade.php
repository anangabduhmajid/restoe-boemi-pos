@php
    $navigation = [
        [
            'label' => 'Dashboard',
            'route' => 'owner.dashboard',
            'active' => ['owner.dashboard'],
            'icon' => 'dashboard',
        ],
        [
            'label' => 'Laporan',
            'route' => 'owner.reports.index',
            'active' => ['owner.reports.*'],
            'icon' => 'report',
        ],
        [
            'label' => 'Menu & Kategori',
            'icon' => 'menu',
            'children' => [
                [
                    'label' => 'Menu Produk',
                    'route' => 'owner.menus.index',
                    'active' => ['owner.menus.*'],
                ],
                [
                    'label' => 'Kategori',
                    'route' => 'owner.categories.index',
                    'active' => ['owner.categories.*'],
                ],
            ],
        ],
        [
            'label' => 'Meja',
            'route' => 'owner.tables.index',
            'active' => ['owner.tables.*'],
            'icon' => 'table',
        ],
        [
            'label' => 'Pengguna',
            'route' => 'owner.users.index',
            'active' => ['owner.users.*'],
            'icon' => 'users',
        ],
        [
            'label' => 'Pesanan',
            'route' => 'owner.orders.index',
            'active' => ['owner.orders.*'],
            'icon' => 'orders',
        ],
        [
            'label' => 'Transaksi',
            'route' => 'owner.transactions.index',
            'active' => ['owner.transactions.*'],
            'icon' => 'payment',
        ],
        [
            'label' => 'Pelanggan',
            'route' => 'owner.customers.index',
            'active' => ['owner.customers.*'],
            'icon' => 'users',
        ],
        [
            'label' => 'Business Assistant / AI',
            'route' => 'owner.dashboard',
            'anchor' => '#business-assistant',
            'active' => [],
            'icon' => 'spark',
        ],
    ];

    $sectionLabel = 'Beranda';

    if (request()->routeIs('owner.reports.*')) {
        $sectionLabel = 'Laporan';
    } elseif (request()->routeIs('owner.menus.*')) {
        $sectionLabel = 'Menu Produk';
    } elseif (request()->routeIs('owner.categories.*')) {
        $sectionLabel = 'Kategori';
    } elseif (request()->routeIs('owner.tables.*')) {
        $sectionLabel = 'Meja';
    } elseif (request()->routeIs('owner.users.*')) {
        $sectionLabel = 'Pengguna';
    } elseif (request()->routeIs('owner.orders.*')) {
        $sectionLabel = 'Pesanan';
    } elseif (request()->routeIs('owner.transactions.*')) {
        $sectionLabel = 'Transaksi';
    } elseif (request()->routeIs('owner.customers.*')) {
        $sectionLabel = 'Pelanggan';
    }
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Restoe Boemi POS') }}</title>

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

        body.owner-body {
            overflow: hidden;
            background: #4A0D0D;
            color: #211D1A;
        }

        .owner-shell,
        .owner-shell * {
            box-sizing: border-box;
        }

        .owner-shell {
            display: flex;
            width: 100%;
            height: 100vh;
            gap: 12px;
            padding: 12px;
            overflow: hidden;
            background: #4A0D0D;
            font-family: Figtree, Inter, Arial, sans-serif;
        }

        .owner-sidebar {
            position: sticky;
            top: 12px;
            display: flex;
            width: 280px;
            height: calc(100vh - 24px);
            flex: 0 0 280px;
            flex-direction: column;
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, .08);
            border-radius: 20px;
            background: #5A1212;
            padding: 24px 20px;
            color: #fff;
        }

        .owner-sidebar__brand-row {
            display: flex;
            min-height: 34px;
            align-items: center;
            justify-content: space-between;
            gap: 8px;
        }

        .owner-sidebar__brand {
            color: #E85D3F;
            font-size: 22px;
            font-weight: 800;
            letter-spacing: -.06em;
            line-height: 1;
            text-decoration: none;
            white-space: nowrap;
        }

        .owner-sidebar__role {
            flex: 0 0 auto;
            border: 1px solid rgba(232, 93, 63, .55);
            border-radius: 999px;
            padding: 6px 11px;
            color: #F5A08C;
            font-size: 10px;
            font-weight: 700;
            letter-spacing: .04em;
        }

        .owner-sidebar__close {
            display: none;
            border: 0;
            border-radius: 999px;
            background: #FFFDF8;
            padding: 8px 14px;
            color: #4A0D0D;
            font: inherit;
            font-size: 11px;
            font-weight: 700;
            cursor: pointer;
        }

        .owner-sidebar__user {
            margin-top: 20px;
            padding-bottom: 20px;
            border-bottom: 1px solid rgba(255, 255, 255, .18);
        }

        .owner-sidebar__user-name {
            overflow: hidden;
            color: #fff;
            font-size: 13px;
            font-weight: 700;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .owner-sidebar__user-role {
            margin-top: 4px;
            color: #F5A08C;
            font-size: 11px;
        }

        .owner-sidebar__nav {
            min-height: 0;
            flex: 1 1 auto;
            margin: 18px -8px 12px;
            overflow-y: auto;
            padding: 0 8px;
            scrollbar-color: rgba(245, 160, 140, .5) transparent;
            scrollbar-width: thin;
        }

        .owner-sidebar__nav::-webkit-scrollbar {
            width: 5px;
        }

        .owner-sidebar__nav::-webkit-scrollbar-thumb {
            border-radius: 999px;
            background: rgba(245, 160, 140, .5);
        }

        .owner-nav-link,
        .owner-nav-heading {
            display: flex;
            min-height: 42px;
            align-items: center;
            gap: 12px;
            border-radius: 999px;
            padding: 10px 13px;
            color: #F5A08C;
            font-size: 13px;
            line-height: 1.25;
            text-decoration: none;
            transition: background-color .16s ease, color .16s ease;
        }

        .owner-nav-link {
            font-weight: 700;
        }

        .owner-nav-link:hover {
            background: #5A1212;
            color: #fff;
        }

        .owner-nav-link.is-active {
            background: #E85D3F;
            color: #fff;
        }

        .owner-nav-icon {
            display: flex;
            width: 19px;
            height: 19px;
            flex: 0 0 19px;
            align-items: center;
            justify-content: center;
        }

        .owner-nav-icon svg {
            width: 19px;
            height: 19px;
        }

        .owner-nav-heading {
            font-weight: 700;
        }

        .owner-nav-heading.is-open {
            color: #fff;
        }

        .owner-nav-submenu {
            margin: 2px 0 5px 22px;
            border-left: 1px solid rgba(255, 255, 255, .2);
            padding-left: 10px;
        }

        .owner-nav-sublink {
            display: block;
            margin: 2px 0;
            border-radius: 999px;
            padding: 9px 13px;
            color: #F5A08C;
            font-size: 12px;
            font-weight: 400;
            text-decoration: none;
            transition: background-color .16s ease, color .16s ease;
        }

        .owner-nav-sublink:hover {
            background: #5A1212;
            color: #fff;
        }

        .owner-nav-sublink.is-active {
            background: #E85D3F;
            color: #fff;
            font-weight: 600;
        }

        .owner-sidebar__footer {
            flex: 0 0 auto;
            border-top: 1px solid rgba(255, 255, 255, .22);
            padding-top: 13px;
            color: #fff;
            font-size: 10px;
            line-height: 1.5;
        }

        .owner-panel {
            display: flex;
            min-width: 0;
            height: calc(100vh - 24px);
            flex: 1 1 auto;
            flex-direction: column;
            overflow: hidden;
            border-radius: 20px;
            background: #FFFDF8;
        }

        .owner-topbar {
            display: flex;
            height: 64px;
            min-height: 64px;
            flex: 0 0 64px;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            border-bottom: 1px solid #E8DED2;
            background: #FFFDF8;
            padding: 0 32px;
        }

        .owner-topbar__identity,
        .owner-topbar__account {
            display: flex;
            min-width: 0;
            align-items: center;
        }

        .owner-topbar__identity {
            gap: 12px;
        }

        .owner-topbar__logo {
            display: block;
            width: 40px;
            height: 40px;
            flex: 0 0 40px;
            border-radius: 50%;
            border: 1px solid #E5D6C3;
            background: #F5EFE6;
            padding: 2px;
            object-fit: contain;
        }

        .owner-topbar__eyebrow {
            color: #4A0D0D;
            font-size: 9px;
            font-weight: 800;
            letter-spacing: .16em;
            line-height: 1.2;
        }

        .owner-topbar__section {
            margin-top: 3px;
            color: #806E61;
            font-size: 11px;
            line-height: 1.2;
        }

        .owner-topbar__account {
            flex: 0 0 auto;
            gap: 12px;
        }

        .owner-topbar__name {
            overflow: hidden;
            max-width: 190px;
            color: #211D1A;
            font-size: 11px;
            font-weight: 700;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .owner-topbar__logout {
            min-height: 34px;
            border: 1px solid #E4D7CA;
            border-radius: 999px;
            background: transparent;
            padding: 0 15px;
            color: #4A0D0D;
            font: inherit;
            font-size: 11px;
            font-weight: 700;
            cursor: pointer;
            transition: background-color .16s ease, color .16s ease;
        }

        .owner-topbar__logout:hover {
            background: #4A0D0D;
            color: #fff;
        }

        .owner-topbar__logout:focus-visible,
        .owner-menu-toggle:focus-visible,
        .owner-sidebar__close:focus-visible {
            outline: 3px solid rgba(232, 93, 63, .45);
            outline-offset: 2px;
        }

        .owner-menu-toggle {
            display: none;
            width: 38px;
            height: 38px;
            flex: 0 0 38px;
            align-items: center;
            justify-content: center;
            border: 0;
            border-radius: 50%;
            background: #4A0D0D;
            color: #fff;
            cursor: pointer;
        }

        .owner-menu-toggle svg {
            width: 20px;
            height: 20px;
        }

        .owner-page-scroll {
            min-height: 0;
            flex: 1 1 auto;
            overflow-x: hidden;
            overflow-y: auto;
            padding: 28px 32px;
            overscroll-behavior: contain;
        }

        .owner-page-scroll button {
            min-height: 40px;
            border-radius: 999px;
            font-weight: 700;
            cursor: pointer;
            transition: filter .16s ease, box-shadow .16s ease;
        }

        .owner-page-scroll button:not(:disabled):hover {
            filter: brightness(.95);
        }

        .owner-page-scroll button:disabled {
            cursor: not-allowed;
        }

        .owner-page-scroll a[class*="__button"],
        .owner-page-scroll a[class*="__action"],
        .owner-page-scroll a.orders-page__detail,
        .owner-page-scroll a.transaction-detail {
            display: inline-flex;
            min-height: 40px;
            align-items: center;
            justify-content: center;
            border-radius: 999px;
            padding: 8px 14px;
            font-weight: 700;
            text-align: center;
            text-decoration: none;
            transition: background-color .16s ease, border-color .16s ease, color .16s ease;
        }

        .owner-page-scroll a[class*="__action"]:not(.tables-page__action--primary):not(.tables-page__action--delete):hover,
        .owner-page-scroll a[class*="__button"]:not(.menu-catalog__button--primary):not(.tables-page__button--primary):not(.categories-page__button--primary):hover,
        .owner-page-scroll a.orders-page__detail:hover,
        .owner-page-scroll a.transaction-detail:hover {
            border-color: #E85D3F;
            background: #FFF1EA;
            color: #4A0D0D;
        }

        .owner-page-scroll button:focus-visible,
        .owner-page-scroll a[class*="__button"]:focus-visible,
        .owner-page-scroll a[class*="__action"]:focus-visible,
        .owner-page-scroll a.orders-page__detail:focus-visible,
        .owner-page-scroll a.transaction-detail:focus-visible {
            outline: 3px solid rgba(232, 93, 63, .45);
            outline-offset: 2px;
        }

        .owner-backdrop {
            display: none;
        }

        @media (max-width: 1023px) {
            .owner-shell {
                display: block;
                height: 100vh;
                padding: 12px;
                background: #4A0D0D;
            }

            .owner-sidebar {
                position: fixed;
                z-index: 51;
                top: 0;
                left: 0;
                width: min(85vw, 300px);
                max-width: 300px;
                height: 100vh;
                border-radius: 0 24px 24px 0;
                border: 0;
                background: #4A0D0D;
                padding: 24px 20px;
                box-shadow: 16px 0 44px rgba(0, 0, 0, .2);
                transform: translateX(-105%);
                transition: transform .24s ease;
            }

            .owner-sidebar.is-open {
                transform: translateX(0);
            }

            .owner-sidebar__close {
                display: inline-flex;
                align-items: center;
                justify-content: center;
            }

            .owner-backdrop {
                position: fixed;
                z-index: 50;
                display: block;
                inset: 0;
                background: rgba(0, 0, 0, .5);
            }

            .owner-panel {
                width: 100%;
                height: calc(100vh - 24px);
                border-radius: 20px;
            }

            .owner-topbar {
                gap: 10px;
                padding: 0 18px;
            }

            .owner-topbar__identity {
                gap: 9px;
            }

            .owner-menu-toggle {
                display: inline-flex;
            }

            .owner-page-scroll {
                padding: 24px 20px;
            }
        }

        @media (max-width: 520px) {
            .owner-sidebar__brand {
                font-size: 20px;
            }

            .owner-sidebar__role {
                padding: 5px 8px;
                font-size: 9px;
            }

            .owner-sidebar__close {
                padding: 8px 10px;
                font-size: 10px;
            }

            .owner-topbar {
                padding: 0 12px;
            }

            .owner-topbar__logo {
                width: 28px;
                height: 28px;
                flex-basis: 28px;
            }

            .owner-topbar__identity {
                gap: 8px;
            }

            .owner-topbar__section {
                display: none;
            }

            .owner-topbar__account {
                gap: 6px;
            }

            .owner-topbar__name {
                max-width: 60px;
                font-size: 10px;
            }

            .owner-topbar__logout {
                min-height: 32px;
                padding: 0 9px;
                font-size: 10px;
            }

            .owner-page-scroll {
                padding: 22px 14px;
            }

            .owner-page-scroll [class*="__actions"] {
                flex-wrap: wrap;
            }

            .owner-page-scroll [class*="__actions"] > a,
            .owner-page-scroll [class*="__actions"] > form {
                flex: 1 1 120px;
            }

            .owner-page-scroll [class*="__actions"] > form button {
                width: 100%;
            }
        }
    </style>
</head>

<body class="owner-body antialiased">
    <div
        x-data="{ sidebarOpen: false }"
        @keydown.escape.window="sidebarOpen = false"
        class="owner-shell">

        <div
            x-cloak
            x-show="sidebarOpen"
            x-transition.opacity
            class="owner-backdrop"
            aria-hidden="true"
            @click="sidebarOpen = false"></div>

        <aside
            class="owner-sidebar"
            :class="{ 'is-open': sidebarOpen }"
            aria-label="Navigasi Owner">
            <div class="owner-sidebar__brand-row">
                <a href="{{ route('owner.dashboard') }}" class="owner-sidebar__brand">restoe boemi</a>
                <span class="owner-sidebar__role">Owner</span>
                <button
                    type="button"
                    class="owner-sidebar__close"
                    aria-label="Close sidebar"
                    @click="sidebarOpen = false">
                    Close
                </button>
            </div>

            <div class="owner-sidebar__user">
                <p class="owner-sidebar__user-name">{{ auth()->user()->name }}</p>
                <p class="owner-sidebar__user-role">Pemilik Restoe Boemi</p>
            </div>

            <nav class="owner-sidebar__nav" aria-label="Menu utama Owner">
                @foreach ($navigation as $item)
                    @php
                        $isActive = collect($item['active'] ?? [])
                            ->contains(fn ($pattern) => request()->routeIs($pattern));
                        $childIsActive = collect($item['children'] ?? [])
                            ->contains(fn ($child) => collect($child['active'])
                                ->contains(fn ($pattern) => request()->routeIs($pattern)));
                    @endphp

                    @if (isset($item['children']))
                        <div>
                            <div class="owner-nav-heading {{ $childIsActive ? 'is-open' : '' }}">
                                <span class="owner-nav-icon" aria-hidden="true">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4 5.5A1.5 1.5 0 0 1 5.5 4H10v6H4V5.5ZM14 4h4.5A1.5 1.5 0 0 1 20 5.5V10h-6V4ZM4 14h6v6H5.5A1.5 1.5 0 0 1 4 18.5V14Zm10 0h6v4.5a1.5 1.5 0 0 1-1.5 1.5H14v-6Z" />
                                    </svg>
                                </span>
                                <span>{{ $item['label'] }}</span>
                            </div>
                            <div class="owner-nav-submenu">
                                @foreach ($item['children'] as $child)
                                    @php
                                        $childActive = collect($child['active'])
                                            ->contains(fn ($pattern) => request()->routeIs($pattern));
                                    @endphp
                                    <a
                                        href="{{ route($child['route']) }}"
                                        class="owner-nav-sublink {{ $childActive ? 'is-active' : '' }}"
                                        @if ($childActive) aria-current="page" @endif
                                        @click="sidebarOpen = false">
                                        {{ $child['label'] }}
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @else
                        <a
                            href="{{ route($item['route']) }}{{ $item['anchor'] ?? '' }}"
                            class="owner-nav-link {{ $isActive ? 'is-active' : '' }}"
                            @if ($isActive) aria-current="page" @endif
                            @click="sidebarOpen = false">
                            <span class="owner-nav-icon" aria-hidden="true">
                                @switch($item['icon'])
                                    @case('dashboard')
                                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4 4h7v7H4V4Zm9 0h7v4h-7V4Zm0 6h7v10h-7V10ZM4 13h7v7H4v-7Z" />
                                        </svg>
                                        @break
                                    @case('report')
                                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4 19V5m0 14h16M8 15v-4m4 4V7m4 8v-6m4 6V4" />
                                        </svg>
                                        @break
                                    @case('menu')
                                    @case('orders')
                                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M6 4h12a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2Zm3 4h6m-6 4h6m-6 4h3" />
                                        </svg>
                                        @break
                                    @case('table')
                                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4 6h16v4H4V6Zm2 4v8m12-8v8M9 10v8m6-8v8" />
                                        </svg>
                                        @break
                                    @case('users')
                                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M16 20v-1.5a3.5 3.5 0 0 0-3.5-3.5h-5A3.5 3.5 0 0 0 4 18.5V20m6-8a4 4 0 1 0 0-8 4 4 0 0 0 0 8Zm6-7.5a4 4 0 0 1 0 7.7m1 3.3h1.5a3.5 3.5 0 0 1 3.5 3.5V20" />
                                        </svg>
                                        @break
                                    @case('payment')
                                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3 7h18v12H3V7Zm0 4h18M7 15h3" />
                                        </svg>
                                        @break
                                    @case('spark')
                                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="m12 3 1.9 5.8L20 11l-6.1 2.2L12 19l-1.9-5.8L4 11l6.1-2.2L12 3Zm7 12 .9 2.1L22 18l-2.1.9L19 21l-.9-2.1L16 18l2.1-.9L19 15Z" />
                                        </svg>
                                        @break
                                @endswitch
                            </span>
                            <span>{{ $item['label'] }}</span>
                        </a>
                    @endif
                @endforeach
            </nav>

            <footer class="owner-sidebar__footer">
                2026 © Restoe Boemi. All rights reserved.
            </footer>
        </aside>

        <main class="owner-panel">
            <header class="owner-topbar">
                <div class="owner-topbar__identity">
                    <button
                        type="button"
                        class="owner-menu-toggle"
                        aria-label="Buka navigasi Owner"
                        @click="sidebarOpen = true">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                    <img
                        src="{{ asset('images/customer/logo-restoe.png') }}"
                        alt="Logo Restoe Boemi"
                        class="owner-topbar__logo">
                    <div>
                        <p class="owner-topbar__eyebrow">RUANG PEMILIK</p>
                        <p class="owner-topbar__section">{{ $sectionLabel }}</p>
                    </div>
                </div>

                <div class="owner-topbar__account">
                    <p class="owner-topbar__name">{{ auth()->user()->name }}</p>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="owner-topbar__logout">Keluar</button>
                    </form>
                </div>
            </header>

            <div class="owner-page-scroll">
                {{ $slot }}
            </div>
        </main>
    </div>
    <x-notification-system theme="admin" />
</body>

</html>
