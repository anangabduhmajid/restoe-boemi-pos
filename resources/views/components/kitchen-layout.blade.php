@props([
    'pageTitle' => 'Dashboard',
    'active' => 'dashboard',
])

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $pageTitle }} | Restoe Boemi Kitchen</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        html,
        body {
            width: 100%;
            height: 100%;
            margin: 0;
        }

        body.kitchen-body {
            overflow: hidden;
            background: #4A0D0D;
            color: #211D1A;
        }

        .kitchen-shell,
        .kitchen-shell * {
            box-sizing: border-box;
        }

        .kitchen-shell {
            width: 100%;
            height: 100vh;
            padding: 12px;
            overflow: hidden;
            background: #4A0D0D;
            font-family: Figtree, Inter, Arial, sans-serif;
        }

        .kitchen-panel {
            display: flex;
            width: 100%;
            height: calc(100vh - 24px);
            flex-direction: column;
            overflow: hidden;
            border-radius: 20px;
            background: #FFFDF8;
        }

        .kitchen-topbar {
            display: grid;
            min-width: 0;
            height: 64px;
            min-height: 64px;
            flex: 0 0 64px;
            grid-template-columns: minmax(0, 1fr) auto minmax(0, 1fr);
            grid-template-areas: "brand nav actions";
            align-items: center;
            gap: 20px;
            border-bottom: 1px solid #E8DED2;
            background: #FFFDF8;
            padding: 0 28px;
        }

        .kitchen-brand {
            min-width: 0;
            grid-area: brand;
            text-decoration: none;
        }

        .kitchen-brand__name {
            color: #E85D3F;
            font-size: 19px;
            font-weight: 800;
            letter-spacing: -.06em;
            line-height: 1;
        }

        .kitchen-brand__subtitle {
            margin-top: 5px;
            color: #806E61;
            font-size: 8px;
            font-weight: 700;
            letter-spacing: .16em;
        }

        .kitchen-nav {
            display: flex;
            height: 100%;
            align-items: center;
            justify-content: center;
            gap: 24px;
            grid-area: nav;
        }

        .kitchen-nav__link {
            display: inline-flex;
            height: 100%;
            align-items: center;
            border-bottom: 2px solid transparent;
            color: #806E61;
            font-size: 12px;
            font-weight: 600;
            text-decoration: none;
            white-space: nowrap;
        }

        .kitchen-nav__link:hover {
            color: #4A0D0D;
        }

        .kitchen-nav__link.is-active {
            border-bottom-color: #4A0D0D;
            color: #4A0D0D;
            font-weight: 800;
        }

        .kitchen-topbar__actions {
            display: flex;
            min-width: 0;
            align-items: center;
            justify-content: flex-end;
            gap: 16px;
            grid-area: actions;
        }

        .kitchen-user {
            min-width: 0;
            text-align: right;
        }

        .kitchen-user__name {
            overflow: hidden;
            color: #211D1A;
            font-size: 11px;
            font-weight: 700;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .kitchen-user__role {
            margin-top: 2px;
            color: #806E61;
            font-size: 10px;
            white-space: nowrap;
        }

        .kitchen-logout {
            display: inline-flex;
            min-height: 38px;
            align-items: center;
            justify-content: center;
            border: 0;
            border-radius: 999px;
            background: #6B0F0F;
            padding: 0 16px;
            color: #fff;
            font: inherit;
            font-size: 11px;
            font-weight: 700;
            cursor: pointer;
            transition: background-color .16s ease;
        }

        .kitchen-logout:hover {
            background: #4A0D0D;
        }

        .kitchen-content-scroll {
            min-height: 0;
            flex: 1 1 auto;
            overflow-x: hidden;
            overflow-y: auto;
            padding: 24px 28px;
            overscroll-behavior: contain;
        }

        .kitchen-logout:focus-visible,
        .kitchen-nav__link:focus-visible {
            outline: 3px solid rgba(232, 93, 63, .45);
            outline-offset: 3px;
        }

        @media (max-width: 1023px) {
            .kitchen-topbar {
                grid-template-columns: minmax(0, 1fr) auto;
                grid-template-rows: 1fr 32px;
                grid-template-areas:
                    "brand actions"
                    "nav nav";
                height: 100px;
                min-height: 100px;
                flex-basis: 100px;
                gap: 4px 12px;
                padding: 8px 20px 0;
            }

            .kitchen-nav {
                width: 100%;
                gap: 28px;
            }

            .kitchen-nav__link {
                font-size: 11px;
            }

            .kitchen-topbar__actions {
                gap: 10px;
            }

            .kitchen-content-scroll {
                padding: 20px;
            }
        }

        @media (max-width: 520px) {
            .kitchen-topbar {
                grid-template-rows: 1fr 32px;
                padding-right: 12px;
                padding-left: 12px;
            }

            .kitchen-brand__name {
                font-size: 17px;
            }

            .kitchen-brand__subtitle {
                font-size: 7px;
            }

            .kitchen-user__name {
                max-width: 75px;
                font-size: 10px;
            }

            .kitchen-user__role {
                font-size: 9px;
            }

            .kitchen-logout {
                min-height: 36px;
                padding: 0 11px;
                font-size: 10px;
            }

            .kitchen-nav {
                gap: 20px;
            }

            .kitchen-content-scroll {
                padding: 16px;
            }
        }
    </style>
</head>

<body class="kitchen-body antialiased">
    <div class="kitchen-shell">
        <div class="kitchen-panel">
            <header class="kitchen-topbar">
                <a href="{{ route('kitchen.dashboard') }}" class="kitchen-brand">
                    <p class="kitchen-brand__name">restoe boemi</p>
                    <p class="kitchen-brand__subtitle">KITCHEN DISPLAY SYSTEM</p>
                </a>

                <nav class="kitchen-nav" aria-label="Navigasi Kitchen">
                    <a
                        href="{{ route('kitchen.dashboard') }}"
                        class="kitchen-nav__link {{ $active === 'dashboard' ? 'is-active' : '' }}"
                        @if ($active === 'dashboard') aria-current="page" @endif>
                        Dashboard
                    </a>
                    <a
                        href="{{ route('kitchen.history') }}"
                        class="kitchen-nav__link {{ $active === 'history' ? 'is-active' : '' }}"
                        @if ($active === 'history') aria-current="page" @endif>
                        Riwayat Pesanan
                    </a>
                </nav>

                <div class="kitchen-topbar__actions">
                    <div class="kitchen-user">
                        <p class="kitchen-user__name">{{ auth()->user()->name }}</p>
                        <p class="kitchen-user__role">Kitchen Staff</p>
                    </div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="kitchen-logout">Logout</button>
                    </form>
                </div>
            </header>

            <main class="kitchen-content-scroll">
                {{ $slot }}
            </main>
        </div>
    </div>
    <x-notification-system theme="admin" />
</body>

</html>
