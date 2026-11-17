
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Restoe Boemi POS') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-[#F5EFE6] font-sans text-[#211D1A] antialiased">

    <main class="flex min-h-screen flex-col lg:flex-row">

        <!-- Brand Panel -->
        <section class="relative flex min-h-[260px] flex-col justify-between overflow-hidden bg-[#710014] px-7 py-8 text-[#F5EFE6] sm:px-12 sm:py-10 lg:min-h-screen lg:w-[46%] lg:px-16 lg:py-14">

            <div class="absolute -right-24 -top-24 h-80 w-80 rounded-full border border-white/10"></div>
            <div class="absolute -bottom-32 -left-24 h-96 w-96 rounded-full border border-white/10"></div>

            <a href="/" class="relative z-10 inline-flex w-fit items-center gap-4">
                <img src="{{ asset('images/customer/logo-restoe.png') }}"
                    alt="Logo Restoe Boemi"
                    class="h-16 w-16 rounded-full border border-[#E5D6C3] bg-[#F5EFE6] p-1 object-contain sm:h-20 sm:w-20">

                <div>
                    <p class="text-[10px] uppercase tracking-[0.22em] text-[#D9BDA8]">
                        Kopi · Rasa · Cerita
                    </p>
                    <h1 class="mt-1 text-xl font-extrabold tracking-[0.12em] sm:text-2xl">
                        RESTOE<br>BOEMI
                    </h1>
                </div>
            </a>

            <div class="relative z-10 my-10 max-w-lg lg:my-0">
                <p class="text-xs font-semibold uppercase tracking-[0.25em] text-[#D9BDA8]">
                    Restaurant Management System
                </p>

                <h2 class="mt-5 text-3xl font-bold leading-tight sm:text-4xl lg:text-5xl">
                    Selamat Datang di
                    <span class="text-[#D9BDA8]">Restoe Boemi.</span>
                </h2>

                <p class="mt-5 max-w-md text-sm leading-7 text-[#F0DDD2] sm:text-base">
                    Satu sistem untuk mengelola pesanan, pembayaran,
                    operasional dapur, dan perkembangan bisnis restoran.
                </p>
            </div>

            <div class="relative z-10 border-t border-white/15 pt-5">
                <p class="text-xs text-[#D9BDA8]">
                    RESTOE BOEMI POS · Sistem Operasional Restoran
                </p>
            </div>

        </section>

        <!-- Form Panel -->
        <section class="flex flex-1 items-center justify-center px-5 py-12 sm:px-10 lg:min-h-screen lg:px-16">

            <div class="w-full max-w-md">

                <div class="mb-8 lg:hidden">
                    <p class="text-xs font-semibold uppercase tracking-[0.2em] text-[#710014]">
                        Restoe Boemi POS
                    </p>
                </div>

                {{ $slot }}

                <p class="mt-10 text-center text-xs text-[#9A897B]">
                    © {{ date('Y') }} Restoe Boemi. All rights reserved.
                </p>

            </div>

        </section>

    </main>

    <x-notification-system theme="admin" />
</body>
</html>
