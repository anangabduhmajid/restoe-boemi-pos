<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Restoe Boemi POS') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            --rb-maroon: #710014;
            --rb-maroon-light: #8C2637;
            --rb-cream: #F5EFE6;
            --rb-black: #161616;
            --rb-vintage: #B38F6F;
            --rb-muted: #76543A;
            --rb-line: #E5D6C3;
        }

        body {
            background: var(--rb-cream);
            color: var(--rb-black);
        }

        .rb-serif {
            font-family: Georgia, 'Times New Roman', serif;
        }

        .rb-sidebar-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 14px;
            border-radius: 5px;
            color: #F5EFE6;
            font-size: 13px;
            transition: background .2s ease;
        }

        .rb-sidebar-link:hover {
            background: rgba(255, 255, 255, .10);
        }

        .rb-sidebar-link.active {
            background: var(--rb-maroon-light);
            color: white;
        }

        .rb-sidebar-icon {
            width: 20px;
            text-align: center;
            color: #D8BCA7;
        }

        .rb-label {
            color: var(--rb-muted);
            font-size: 10px;
            letter-spacing: .16em;
            text-transform: uppercase;
        }

        .rb-divider {
            border-color: var(--rb-line);
        }

        .rb-stat {
            border-top: 2px solid var(--rb-maroon);
            padding-top: 16px;
        }

        .rb-chart-bar {
            background: var(--rb-vintage);
            transition: opacity .2s ease;
        }

        .rb-chart-bar:hover {
            opacity: .65;
        }

        .rb-chart-bar.highlight {
            background: var(--rb-maroon);
        }

        .rb-topbar {
            display: flex;
            min-height: 82px;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
            border-bottom: 1px solid var(--rb-line);
            background: #fffdf9;
            padding: 13px clamp(18px, 3vw, 42px);
        }

        .rb-topbar__identity {
            display: flex;
            min-width: 0;
            align-items: center;
            gap: 13px;
        }

        .rb-topbar__seal {
            display: flex;
            width: 42px;
            height: 42px;
            flex: 0 0 auto;
            align-items: center;
            justify-content: center;
            border: 1px solid #710014;
            border-radius: 50%;
            background: #f5efe6;
            color: #710014;
            font-family: Georgia, 'Times New Roman', serif;
            font-size: 15px;
            font-weight: 700;
            letter-spacing: -.05em;
        }

        .rb-topbar__context {
            min-width: 0;
        }

        .rb-topbar__eyebrow {
            margin: 0;
            color: #710014;
            font-size: 9px;
            font-weight: 700;
            letter-spacing: .18em;
            text-transform: uppercase;
        }

        .rb-topbar__location {
            display: flex;
            flex-wrap: wrap;
            align-items: baseline;
            gap: 7px;
            margin: 5px 0 0;
            color: #211a17;
            font-family: Georgia, 'Times New Roman', serif;
            font-size: 16px;
            line-height: 1.2;
        }

        .rb-topbar__separator {
            color: #b6a8a0;
            font-family: Arial, Helvetica, sans-serif;
            font-size: 12px;
        }

        .rb-topbar__section {
            color: #55504c;
            font-family: Arial, Helvetica, sans-serif;
            font-size: 11px;
        }

        .rb-topbar__account {
            display: flex;
            flex: 0 0 auto;
            align-items: center;
            gap: 12px;
        }

        .rb-topbar__profile {
            display: flex;
            align-items: center;
            gap: 9px;
        }

        .rb-topbar__avatar {
            display: flex;
            width: 36px;
            height: 36px;
            flex: 0 0 auto;
            align-items: center;
            justify-content: center;
            border: 2px solid #f5efe6;
            border-radius: 50%;
            background: #710014;
            color: #fff;
            font-family: Georgia, 'Times New Roman', serif;
            font-size: 13px;
            font-weight: 700;
        }

        .rb-topbar__profile-details {
            max-width: 180px;
        }

        .rb-topbar__name {
            overflow: hidden;
            margin: 0;
            color: #211a17;
            font-size: 11px;
            font-weight: 700;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .rb-topbar__role {
            margin: 3px 0 0;
            color: #806e61;
            font-size: 9px;
        }

        .rb-topbar__logout {
            min-height: 34px;
            border: 1px solid #d4cdc4;
            border-radius: 5px;
            background: transparent;
            padding: 0 11px;
            color: #710014;
            font: inherit;
            font-size: 10px;
            font-weight: 700;
            cursor: pointer;
            transition: background-color .15s ease, border-color .15s ease;
        }

        .rb-topbar__logout:hover {
            border-color: #710014;
            background: #f5efe6;
        }

        .rb-topbar__logout:focus-visible {
            outline: 3px solid rgba(113, 0, 20, .2);
            outline-offset: 2px;
        }

        @media (max-width: 620px) {
            .rb-topbar {
                min-height: 70px;
                gap: 12px;
                padding: 11px 16px;
            }

            .rb-topbar__identity {
                gap: 9px;
            }

            .rb-topbar__seal {
                width: 34px;
                height: 34px;
                font-size: 12px;
            }

            .rb-topbar__eyebrow {
                font-size: 8px;
            }

            .rb-topbar__location {
                font-size: 14px;
            }

            .rb-topbar__section {
                font-size: 10px;
            }

            .rb-topbar__account {
                gap: 8px;
            }

            .rb-topbar__profile {
                gap: 6px;
            }

            .rb-topbar__avatar {
                width: 31px;
                height: 31px;
            }

            .rb-topbar__profile-details {
                max-width: 115px;
            }

            .rb-topbar__role {
                display: none;
            }

            .rb-topbar__logout {
                min-height: 32px;
                padding: 0 8px;
            }
        }

        @media (max-width: 390px) {
            .rb-topbar__seal {
                display: none;
            }

            .rb-topbar__profile-details {
                max-width: 88px;
            }

            .rb-topbar__logout {
                font-size: 9px;
            }
        }
    </style>
</head>

<body class="antialiased">

    <div class="min-h-screen md:flex">

        <!-- SIDEBAR -->
        <aside class="w-full md:w-[250px] shrink-0 bg-[#710014] text-white flex flex-col">

            <!-- BRAND -->
            <div class="px-7 pt-9 pb-8 border-b border-white/15">
                <div class="flex items-center gap-4">
                    <img src="{{ asset('images/customer/logo-restoe.png') }}"
                        alt="Logo Restoe Boemi"
                        class="h-16 w-16 shrink-0 rounded-full border border-[#E5D6C3] bg-[#F5EFE6] p-1 object-contain">
                    <div class="min-w-0">
                        <p class="text-[9px] tracking-[.3em] text-[#D8BCA7] uppercase">
                            Indonesian Heritage Cafe
                        </p>
                        <h1 class="rb-serif mt-2 text-[24px] leading-tight tracking-wide">
                            RESTOE<br>BOEMI
                        </h1>
                    </div>
                </div>

                <p class="text-[10px] tracking-[.2em] text-[#E5D6C3] mt-3">
                    KOPI · RASA · CERITA
                </p>

            </div>

            <!-- NAVIGATION -->

            <nav class="flex-1 px-4 py-7">

                <p class="px-3 mb-3 text-[9px] font-semibold tracking-[.2em] text-[#D8BCA7] uppercase">
                    Overview
                </p>

                <a href="{{ route('owner.dashboard') }}"
                    class="rb-sidebar-link {{ request()->routeIs('owner.dashboard') ? 'active' : '' }}">
                    <span class="rb-sidebar-icon">▦</span>
                    <span>Dashboard</span>
                </a>

                <p class="px-3 mt-9 mb-3 text-[9px] font-semibold tracking-[.2em] text-[#D8BCA7] uppercase">
                    Operations
                </p>

                <div class="space-y-1">

                    <a href="{{ route('owner.categories.index') }}"
                        class="rb-sidebar-link {{ request()->routeIs('owner.categories.*') ? 'active' : '' }}">
                        <span class="rb-sidebar-icon">▤</span>
                        <span>Kategori</span>
                    </a>

                    <a href="{{ route('owner.menus.index') }}"
                        class="rb-sidebar-link {{ request()->routeIs('owner.menus.*') ? 'active' : '' }}">
                        <span class="rb-sidebar-icon">◈</span>
                        <span>Menu Produk</span>
                    </a>

                    <a href="{{ route('owner.orders.index') }}"
                        class="rb-sidebar-link {{ request()->routeIs('owner.orders.*') ? 'active' : '' }}">
                        <span class="rb-sidebar-icon">▤</span>
                        <span>Orders</span>
                    </a>

                    <a href="{{ route('owner.transactions.index') }}"
                        class="rb-sidebar-link {{ request()->routeIs('owner.transactions.*') ? 'active' : '' }}">
                        <span class="rb-sidebar-icon">Rp</span>
                        <span>Transactions</span>
                    </a>

                    <a href="{{ route('owner.tables.index') }}"
                        class="rb-sidebar-link {{ request()->routeIs('owner.tables.*') ? 'active' : '' }}">
                        <span class="rb-sidebar-icon">▦</span>
                        <span>Tables</span>
                    </a>

                </div>

                <p class="px-3 mt-9 mb-3 text-[9px] font-semibold tracking-[.2em] text-[#D8BCA7] uppercase">
                    Business
                </p>

                <div class="space-y-1">

                    <a href="{{ route('owner.reports.index') }}"
                        class="rb-sidebar-link {{ request()->routeIs('owner.reports.*') ? 'active' : '' }}">
                        <span class="rb-sidebar-icon">Rp</span>
                        <span>Reports</span>
                    </a>

                    <a href="{{ route('owner.customers.index') }}"
                        class="rb-sidebar-link {{ request()->routeIs('owner.customers.*') ? 'active' : '' }}">
                        <span class="rb-sidebar-icon">C</span>
                        <span>Customers</span>
                    </a>

                </div>

                <p class="px-3 mt-9 mb-3 text-[9px] font-semibold tracking-[.2em] text-[#D8BCA7] uppercase">
                    System
                </p>

                <a href="{{ route('owner.users.index') }}"
                    class="rb-sidebar-link {{ request()->routeIs('owner.users.*') ? 'active' : '' }}">
                    <span>User Management</span>
                </a>
            </nav>

            <!-- SIDEBAR FOOTER -->
            <div class="px-7 py-6 border-t border-white/15">

                <p class="text-[9px] tracking-[.15em] text-[#E5D6C3]">
                    A TASTE OF HERITAGE
                </p>

                <p class="rb-serif text-sm mt-2">
                    A Place to Belong.
                </p>

                <p class="text-[9px] text-[#D8BCA7] mt-5">
                    RESTOE BOEMI POS · V1.0
                </p>

            </div>

        </aside>

        <!-- MAIN CONTENT -->
        <div class="flex-1 min-w-0 flex flex-col">

            <!-- TOPBAR -->
            <header class="rb-topbar">
                <div class="rb-topbar__identity">
                    <span class="rb-topbar__seal" aria-hidden="true">RB</span>
                    <div class="rb-topbar__context">
                        <p class="rb-topbar__eyebrow">Ruang Pemilik</p>
                        <p class="rb-topbar__location">
                            <span>Restoe Boemi</span>
                            <span class="rb-topbar__separator" aria-hidden="true">/</span>
                            <span class="rb-topbar__section">
                                @if (request()->routeIs('owner.dashboard'))
                                Beranda
                                @elseif (request()->routeIs('owner.categories.*'))
                                Kategori
                                @elseif (request()->routeIs('owner.menus.*'))
                                Menu Produk
                                @elseif (request()->routeIs('owner.tables.*'))
                                Meja & QR
                                @elseif (request()->routeIs('owner.orders.*'))
                                Pesanan
                                @elseif (request()->routeIs('owner.transactions.*'))
                                Transactions
                                @elseif (request()->routeIs('owner.customers.*'))
                                Customers
                                @elseif (request()->routeIs('owner.reports.*'))
                                Reports
                                @elseif (request()->routeIs('owner.users.*'))
                                User Management
                                @else
                                Ruang Usaha
                                @endif
                            </span>
                        </p>
                    </div>
                </div>

                <div class="rb-topbar__account">
                    <div class="rb-topbar__profile">
                        <span class="rb-topbar__avatar" aria-hidden="true">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </span>
                        <div class="rb-topbar__profile-details">
                            <p class="rb-topbar__name">{{ auth()->user()->name }}</p>
                            <p class="rb-topbar__role">Pemilik Restoe Boemi</p>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="rb-topbar__logout">Keluar</button>
                    </form>
                </div>
            </header>

            <!-- PAGE CONTENT -->
            <main class="flex-1 px-5 md:px-10 py-8 md:py-10">
                {{ $slot }}
            </main>

            <!-- FOOTER -->
            <footer class="px-5 md:px-10 py-5 border-t border-[#E5D6C3] flex flex-wrap justify-between gap-2">

                <p class="text-[10px] text-[#76543A]">
                    © {{ date('Y') }} RESTOE BOEMI. All rights reserved.
                </p>

                <p class="text-[10px] text-[#76543A]">
                    Kopi · Rasa · Cerita
                </p>

            </footer>

        </div>

    </div>

    <x-notification-system theme="admin" />
</body>

</html>