
<x-app-layout>
    <style>
        .qr-page {
            display: grid;
            width: 100%;
            max-width: 840px;
            gap: 24px;
            margin: 0;
        }

        .qr-page__header {
            display: grid;
            gap: 8px;
        }

        .qr-page__back {
            width: fit-content;
            color: #65564c;
            font-size: 13px;
            text-decoration: none;
        }

        .qr-page__back:hover {
            color: #710014;
            text-decoration: underline;
        }

        .qr-page__title {
            margin: 8px 0 0;
            color: #211a17;
            font-family: Georgia, 'Times New Roman', serif;
            font-size: clamp(24px, 4vw, 32px);
            line-height: 1.2;
        }

        .qr-page__details {
            margin: 0;
            color: #806e61;
            font-size: 14px;
            line-height: 1.5;
        }

        .qr-page__card {
            width: min(100%, 560px);
            margin: 0;
            border: 1px solid #e8ded3;
            border-radius: 12px;
            background: #fff;
            padding: clamp(20px, 4vw, 36px);
            text-align: center;
            box-shadow: 0 8px 24px rgba(38, 25, 16, .06);
        }

        .qr-page__brand {
            margin: 0;
            color: #710014;
            font-family: Georgia, 'Times New Roman', serif;
            font-size: 22px;
            letter-spacing: .06em;
        }

        .qr-page__table {
            margin: 6px 0 20px;
            color: #806e61;
            font-size: 13px;
        }

        .qr-page__image {
            display: block;
            width: min(100%, 320px);
            height: auto;
            aspect-ratio: 1;
            margin: 0 auto;
            background: #fff;
        }

        .qr-page__hint {
            margin: 18px 0 0;
            color: #65564c;
            font-size: 14px;
            line-height: 1.5;
        }

        .qr-page__url {
            margin: 10px 0 0;
            overflow-wrap: anywhere;
            color: #710014;
            font-size: 12px;
            line-height: 1.5;
        }

        .qr-page__url a {
            color: inherit;
        }

        .qr-page__warning {
            margin-top: 12px;
            border-left: 3px solid #710014;
            background: #f5efe6;
            padding: 12px;
            color: #51443b;
            font-size: 13px;
            line-height: 1.5;
        }

        .qr-page__actions {
            display: flex;
            justify-content: flex-start;
            gap: 12px;
        }

        .qr-page__button {
            display: inline-flex;
            min-height: 44px;
            align-items: center;
            justify-content: center;
            border: 1px solid #710014;
            border-radius: 7px;
            padding: 0 18px;
            font-size: 14px;
            font-weight: 600;
            text-decoration: none;
            cursor: pointer;
        }

        .qr-page__button--primary {
            background: #710014;
            color: #fff;
        }

        .qr-page__button--primary:hover {
            background: #560010;
        }

        .qr-page__button--secondary {
            border-color: #c9b9aa;
            background: #fff;
            color: #51443b;
        }

        .qr-page__button--secondary:hover {
            background: #f8f4ef;
        }

        .qr-page__button:focus-visible,
        .qr-page__back:focus-visible {
            outline: 3px solid rgba(113, 0, 20, .2);
            outline-offset: 3px;
        }

        @media (max-width: 560px) {
            .qr-page__card {
                width: 100%;
                padding: 20px 16px;
            }

            .qr-page__actions {
                align-items: flex-start;
                flex-direction: column;
            }

            .qr-page__button {
                width: min(100%, 420px);
            }
        }

        @media print {
            body * {
                visibility: hidden !important;
            }

            .qr-print,
            .qr-print * {
                visibility: visible !important;
            }

            .qr-print {
                position: absolute !important;
                top: 0 !important;
                left: 0 !important;
                width: 100% !important;
                max-width: none !important;
                border: 0 !important;
                box-shadow: none !important;
            }

            .qr-no-print {
                display: none !important;
            }
        }
    </style>

    <div class="qr-page">
        <div class="qr-page__header qr-no-print">
            <a href="{{ route('owner.tables.index') }}"
                class="qr-page__back">
                ← Kembali ke Daftar Meja
            </a>

            <h1 class="qr-page__title">
                QR Code Meja {{ $table->table_number }}
            </h1>

            <p class="qr-page__details">
                {{ $table->name ?: 'Meja Restoe Boemi' }}
                · Kapasitas {{ $table->capacity }} orang
            </p>

            @php($qrHost = parse_url($menuUrl, PHP_URL_HOST))
            @if (in_array($qrHost, ['localhost', '127.0.0.1', '::1', '[::1]'], true))
                <p class="qr-page__warning">
                    Alamat ini hanya bisa dibuka dari komputer ini. Untuk tes lewat HP, isi
                    <code>PUBLIC_MENU_URL</code> dengan alamat IPv4 komputer dan jalankan server
                    agar dapat diakses melalui jaringan lokal.
                </p>
            @endif
        </div>

        <section class="qr-page__card qr-print">
            <img src="{{ asset('images/customer/logo-restoe.png') }}"
                alt="Logo Restoe Boemi"
                width="72"
                height="72"
                style="display:block;width:72px;height:72px;margin:0 auto 12px;border:1px solid #e8ded3;border-radius:50%;background:#f5efe6;padding:4px;object-fit:contain;">
            <h2 class="qr-page__brand">
                RESTOE BOEMI
            </h2>
            <p class="qr-page__table">Menu digital · Meja {{ $table->table_number }}</p>
            <img
                src="{{ route('owner.tables.qr.image', $table) }}"
                alt="QR Code Meja {{ $table->table_number }}"
                width="350"
                height="350"
                class="qr-page__image"
            >

            <p class="qr-page__hint">
                Scan QR Code untuk membuka menu digital meja ini.
            </p>
            <p class="qr-page__url">
                <a href="{{ $menuUrl }}">{{ $menuUrl }}</a>
            </p>
        </section>

        <div class="qr-page__actions qr-no-print">
            <a href="{{ route('owner.tables.qr.image', $table) }}"
                target="_blank"
                rel="noopener"
                class="qr-page__button qr-page__button--primary">
                Buka QR Code
            </a>
            <button type="button"
                onclick="window.print()"
                class="qr-page__button qr-page__button--secondary">
                Cetak QR Code
            </button>
        </div>
    </div>
</x-app-layout>
