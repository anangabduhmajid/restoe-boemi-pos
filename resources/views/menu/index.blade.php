<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restoe Boemi | Digital Menu</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Nunito:wght@600;700;800;900&display=swap" rel="stylesheet">
    <style>
        body {
            overflow-x: hidden;
            font-family: 'Inter', sans-serif;
        }

        .rb-customer-nav {
            background-color: #4A0D0D;
            border-bottom: 1px solid rgba(255, 255, 255, .1);
        }

        .rb-customer-nav__inner {
            display: flex;
            width: 100%;
            max-width: 1100px;
            margin: 0 auto;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            padding: 16px;
        }

        .rb-customer-nav__brand {
            display: flex;
            min-width: 0;
            flex: 1 1 auto;
            flex-direction: column;
            align-items: flex-start;
            gap: 3px;
            color: #FFFDF8;
            text-decoration: none;
        }

        .rb-customer-nav__name {
            display: block;
            color: #E85D3F;
            font-size: 16px;
            font-weight: 900;
            letter-spacing: -.03em;
            line-height: 1;
        }

        .rb-customer-nav__cart.rb-cart-wiggle svg {
            animation: rb-cart-wiggle .36s ease;
        }

        .rb-customer-nav__count.rb-count-pop {
            animation: rb-count-pop .32s ease;
        }

        @keyframes rb-cart-wiggle {
            0%, 100% { transform: rotate(0); }
            25% { transform: rotate(-12deg); }
            75% { transform: rotate(12deg); }
        }

        @keyframes rb-count-pop {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.35); }
        }

        .rb-customer-nav__tagline {
            display: block;
            color: #FFFDF8;
            font-size: 8px;
            font-weight: 700;
            letter-spacing: .12em;
            line-height: 1.2;
        }

        .rb-customer-nav__cart {
            display: inline-flex;
            position: relative;
            width: 44px;
            height: 44px;
            flex: 0 0 auto;
            align-items: center;
            justify-content: center;
            border-radius: 999px;
            color: #FFFDF8;
            text-decoration: none;
            transition: background-color .2s ease, transform .2s ease;
        }

        .rb-customer-nav__brand:focus-visible,
        .rb-customer-nav__cart:focus-visible {
            outline: 2px solid #FFFDF8;
            outline-offset: 3px;
        }

        .rb-customer-nav__cart:hover {
            background: rgba(255, 253, 248, .12);
            transform: translateY(-1px);
        }

        .rb-customer-nav__count {
            position: absolute;
            top: 0;
            right: -2px;
            display: inline-flex;
            min-width: 19px;
            height: 19px;
            align-items: center;
            justify-content: center;
            border: 2px solid #4A0D0D;
            border-radius: 999px;
            background: #E85D3F;
            padding: 0 4px;
            color: #3D0C0C;
            font-size: 10px;
            font-weight: 800;
            line-height: 1;
        }

        .rb-hero {
            position: relative;
            min-height: clamp(520px, calc(100svh - 64px), 760px);
            overflow: hidden;
            isolation: isolate;
            background: #4A0D0D;
        }

        .rb-hero__overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(90deg, rgba(74, 13, 13, .85) 0%, rgba(74, 13, 13, .35) 100%);
        }

        .rb-hero__inner {
            position: relative;
            display: flex;
            width: 100%;
            min-height: inherit;
            max-width: 1100px;
            align-items: center;
            margin: 0 auto;
            padding: 48px 16px;
        }

        .rb-hero__copy {
            position: relative;
            z-index: 2;
            width: 100%;
            max-width: 570px;
            padding-bottom: 130px;
            color: #FFFDF8;
        }

        .rb-hero__eyebrow {
            margin-bottom: 14px;
            color: #FFFDF8;
            font-size: 11px;
            font-weight: 800;
            letter-spacing: .18em;
        }

        .rb-hero__title {
            font-family: 'Nunito', sans-serif;
            font-size: clamp(2.35rem, 10vw, 4.75rem);
            font-weight: 800;
            letter-spacing: normal;
            line-height: 1.1;
        }

        .rb-hero__title span {
            color: #E85D3F;
            text-shadow: 0 1px 5px rgba(0, 0, 0, .35);
        }

        .rb-hero__subtitle {
            max-width: 54ch;
            margin-top: 16px;
            color: #FFFDF8;
            font-size: 15px;
            line-height: 1.5;
        }

        .rb-hero__cta {
            display: inline-flex;
            min-height: 48px;
            align-items: center;
            justify-content: center;
            margin-top: 24px;
            border-radius: 999px;
            background: #FFFDF8;
            padding: 0 22px;
            color: #4A0D0D;
            box-shadow: 0 8px 24px rgba(0, 0, 0, .22);
            font-size: 11px;
            font-weight: 800;
            letter-spacing: .08em;
            text-decoration: none;
            transition: transform .2s ease, box-shadow .2s ease;
        }

        .rb-hero__cta:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 28px rgba(0, 0, 0, .28);
        }

        .rb-hero__cta:focus-visible {
            outline: 3px solid #E85D3F;
            outline-offset: 3px;
        }

        .rb-menu-section {
            background: #4A0D0D;
            padding: 64px 16px 80px;
            color: #FFFDF8;
        }

        .rb-menu-content {
            width: 100%;
            max-width: 1100px;
            margin: 0 auto;
        }

        .rb-menu-heading {
            margin-bottom: 28px;
            text-align: center;
        }

        .rb-customer-name-error {
            display: flex;
            align-items: flex-start;
            gap: 6px;
            margin-top: 6px;
            color: #C62828;
            font-size: 13px;
            line-height: 1.4;
        }

        .rb-customer-name-error[hidden] {
            display: none;
        }

        .rb-customer-name-error svg {
            width: 15px;
            height: 15px;
            flex: 0 0 15px;
            margin-top: 1px;
            fill: none;
            stroke: currentColor;
            stroke-linecap: round;
            stroke-width: 1.5;
        }

        .rb-menu-kicker {
            color: #F5A08C;
            font-size: 11px;
            font-weight: 800;
            letter-spacing: .16em;
        }

        .rb-menu-title {
            margin-top: 10px;
            font-family: 'Nunito', sans-serif;
            font-size: clamp(2rem, 7vw, 3rem);
            font-weight: 900;
            line-height: 1.1;
        }

        .rb-menu-title span {
            color: #E85D3F;
        }

        .rb-menu-intro {
            margin-top: 10px;
            color: #FFFDF8;
            font-size: 14px;
        }

        .rb-menu-tools {
            display: grid;
            gap: 14px;
            max-width: 760px;
            margin: 0 auto 28px;
        }

        .rb-menu-search {
            position: relative;
        }

        .rb-menu-search svg {
            position: absolute;
            top: 50%;
            left: 16px;
            width: 19px;
            height: 19px;
            color: #76543A;
            transform: translateY(-50%);
            pointer-events: none;
        }

        .rb-menu-search input {
            width: 100%;
            min-height: 48px;
            border: 1px solid #E5D6C3;
            border-radius: 999px;
            background: #FFFDF8;
            padding: 0 18px 0 46px;
            color: #211D1A;
            font: inherit;
            font-size: 14px;
        }

        .rb-menu-search input::placeholder {
            color: #76543A;
            opacity: 1;
        }

        .rb-menu-search input:focus-visible {
            border-color: #E85D3F;
            outline: 3px solid rgba(232, 93, 63, .35);
            outline-offset: 2px;
        }

        .rb-menu-categories {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 8px;
        }

        .rb-menu-filter {
            display: inline-flex;
            min-height: 40px;
            align-items: center;
            justify-content: center;
            border: 1px solid rgba(255, 253, 248, .45);
            border-radius: 999px;
            background: #FFFDF8;
            padding: 0 16px;
            color: #4A0D0D;
            font-size: 12px;
            font-weight: 800;
            cursor: pointer;
            transition: background-color .18s ease, color .18s ease, transform .18s ease;
        }

        .rb-menu-filter:hover {
            transform: translateY(-1px);
        }

        .rb-menu-filter.is-active {
            border-color: #E85D3F;
            background: #E85D3F;
            color: #FFFDF8;
        }

        .rb-menu-filter:focus-visible,
        .rb-menu-card__action:focus-visible {
            outline: 3px solid #E85D3F;
            outline-offset: 2px;
        }

        .rb-menu-category {
            margin-top: 40px;
            scroll-margin-top: 88px;
        }

        .rb-menu-category__heading {
            margin-bottom: 16px;
        }

        .rb-menu-category__title {
            color: #FFFDF8;
            font-family: 'Nunito', sans-serif;
            font-size: 22px;
            font-weight: 900;
        }

        .rb-menu-category__description {
            margin-top: 4px;
            color: #F9D9CF;
            font-size: 13px;
        }

        .rb-menu-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 12px;
        }

        .rb-menu-card {
            min-width: 0;
            overflow: hidden;
            border: 1px solid rgba(255, 253, 248, .2);
            border-radius: 16px;
            background: #FFFDF8;
            color: #211D1A;
            box-shadow: 0 8px 20px rgba(0, 0, 0, .14);
            opacity: 0;
            transform: translateY(14px);
            transition: opacity .4s ease, transform .4s ease;
            transition-delay: var(--menu-card-delay, 0ms);
        }

        .rb-menu-card.is-visible {
            opacity: 1;
            transform: translateY(0);
        }

        .rb-menu-card--bounce {
            animation: rb-menu-bounce .3s ease;
        }

        .rb-menu-card__image,
        .rb-menu-card__placeholder {
            display: flex;
            width: 100%;
            aspect-ratio: 1 / 1;
            align-items: center;
            justify-content: center;
        }

        .rb-menu-card__image {
            object-fit: cover;
        }

        .rb-menu-card__placeholder {
            flex-direction: column;
            gap: 8px;
            background: #F9F1E8;
            color: #76543A;
            font-size: 11px;
            font-weight: 600;
        }

        .rb-menu-card__placeholder svg {
            width: 42px;
            height: 42px;
            color: #6B0F0F;
        }

        .rb-menu-card__body {
            padding: 12px;
        }

        .rb-menu-card__name {
            color: #211D1A;
            font-size: 14px;
            font-weight: 800;
            line-height: 1.35;
        }

        .rb-menu-card__description {
            display: -webkit-box;
            min-height: 34px;
            overflow: hidden;
            margin-top: 5px;
            color: #5F5149;
            font-size: 12px;
            line-height: 1.45;
            -webkit-box-orient: vertical;
            -webkit-line-clamp: 2;
        }

        .rb-menu-card__footer {
            display: flex;
            flex-direction: column;
            align-items: stretch;
            gap: 8px;
            margin-top: 12px;
        }

        .rb-menu-card__price {
            color: #4A0D0D;
            font-size: 14px;
            font-weight: 900;
            line-height: 1.2;
        }

        .rb-menu-card__sold-out {
            display: inline-flex;
            margin-top: 6px;
            border-radius: 999px;
            background: #F9F1E8;
            padding: 4px 9px;
            color: #4A0D0D;
            font-size: 10px;
            font-weight: 800;
        }

        .rb-menu-card__controls {
            display: flex;
            min-height: 38px;
            align-items: center;
            justify-content: flex-end;
            gap: 5px;
        }

        .rb-menu-card__action {
            display: inline-flex;
            min-width: 34px;
            min-height: 36px;
            align-items: center;
            justify-content: center;
            border: 1px solid #6B0F0F;
            border-radius: 999px;
            background: #6B0F0F;
            padding: 0 12px;
            color: #FFFDF8;
            font-size: 11px;
            font-weight: 800;
            line-height: 1;
            white-space: nowrap;
            cursor: pointer;
            transition: background-color .18s ease, transform .18s ease;
        }

        .rb-menu-card__action:hover:not(:disabled) {
            background: #4A0D0D;
            transform: translateY(-1px);
        }

        .rb-menu-card__action:disabled {
            border-color: #B5A9A1;
            background: #E5DDD7;
            color: #5F5149;
            cursor: not-allowed;
        }

        .rb-menu-card__action.is-unavailable {
            border-color: #B5A9A1;
            background: #E5DDD7;
            color: #5F5149;
            cursor: pointer;
        }

        .rb-menu-card__action--step {
            width: 34px;
            padding: 0;
            font-size: 18px;
        }

        .rb-menu-card__action--added {
            width: 34px;
            padding: 0;
            font-size: 19px;
        }

        .rb-menu-card__quantity {
            min-width: 18px;
            color: #4A0D0D;
            font-size: 13px;
            font-weight: 900;
            text-align: center;
        }

        .rb-menu-card__quantity[hidden],
        .rb-menu-card__action[hidden] {
            display: none;
        }

        .rb-menu-empty {
            margin-top: 22px;
            border-radius: 16px;
            background: rgba(255, 253, 248, .1);
            padding: 28px 16px;
            color: #FFFDF8;
            font-size: 14px;
            text-align: center;
        }

        .rb-checkout-section {
            background: #FFFDF8;
            padding: 64px 16px 80px;
            color: #211D1A;
        }

        .rb-success-screen {
            position: relative;
            isolation: isolate;
            display: grid;
            min-height: calc(100vh - 64px);
            min-height: calc(100svh - 64px);
            overflow: hidden;
            place-items: center;
            background: #FFFDF8;
            padding: 32px 16px 48px;
            color: #211D1A;
        }

        .rb-success-content {
            position: relative;
            z-index: 1;
            display: flex;
            width: 100%;
            max-width: 560px;
            flex-direction: column;
            align-items: center;
            text-align: center;
        }

        .rb-success-mascot {
            width: min(54vw, 220px);
            height: auto;
            filter: drop-shadow(0 14px 12px rgba(74, 13, 13, .16));
            animation: rb-success-pop .55s cubic-bezier(.2, .8, .2, 1) both;
        }

        .rb-success-confetti {
            position: absolute;
            z-index: 0;
            font-size: clamp(20px, 6vw, 32px);
            animation: rb-success-confetti 3.2s ease-in-out infinite;
        }

        .rb-success-confetti--coffee {
            top: 16%;
            left: max(8%, calc(50% - 230px));
        }

        .rb-success-confetti--leaf {
            top: 25%;
            right: max(8%, calc(50% - 230px));
            animation-delay: -1.1s;
        }

        .rb-success-confetti--coffee-small {
            right: max(14%, calc(50% - 275px));
            bottom: 20%;
            font-size: 21px;
            animation-delay: -2s;
        }

        .rb-success-kicker {
            margin-top: 12px;
            color: #6B0F0F;
            font-size: 11px;
            font-weight: 800;
            letter-spacing: .18em;
        }

        .rb-success-title {
            max-width: 17ch;
            margin-top: 8px;
            color: #4A0D0D;
            font-family: 'Nunito', sans-serif;
            font-size: clamp(28px, 8vw, 44px);
            font-weight: 900;
            line-height: 1.08;
        }

        .rb-success-title span {
            color: #B73D2B;
        }

        .rb-success-copy {
            max-width: 38ch;
            margin-top: 12px;
            color: #4F423B;
            font-size: 14px;
            line-height: 1.6;
        }

        .rb-success-message {
            max-width: 100%;
            margin-top: 10px;
            color: #5F5149;
            font-size: 12px;
            line-height: 1.5;
            overflow-wrap: anywhere;
        }

        .rb-success-button {
            display: inline-flex;
            width: min(100%, 320px);
            min-height: 52px;
            align-items: center;
            justify-content: center;
            margin-top: 24px;
            border-radius: 14px;
            background: #6B0F0F;
            padding: 0 22px;
            color: #FFFDF8;
            font-size: 12px;
            font-weight: 800;
            letter-spacing: .06em;
            text-decoration: none;
            transition: background-color .18s ease, transform .18s ease;
        }

        .rb-success-button:hover {
            background: #4A0D0D;
            transform: translateY(-1px);
        }

        .rb-success-button:focus-visible {
            outline: 3px solid #E85D3F;
            outline-offset: 3px;
        }

        @keyframes rb-success-pop {
            from { opacity: 0; transform: scale(.72); }
            to { opacity: 1; transform: scale(1); }
        }

        @keyframes rb-success-confetti {
            0%, 100% { opacity: .7; transform: translateY(0) rotate(-8deg); }
            50% { opacity: 1; transform: translateY(-10px) rotate(8deg); }
        }

        .rb-checkout-content {
            width: 100%;
            max-width: 760px;
            margin: 0 auto;
        }

        .rb-checkout-heading {
            margin-bottom: 24px;
            text-align: center;
        }

        .rb-checkout-kicker {
            color: #6B0F0F;
            font-size: 11px;
            font-weight: 800;
            letter-spacing: .16em;
        }

        .rb-checkout-title {
            margin-top: 8px;
            color: #211D1A;
            font-family: 'Nunito', sans-serif;
            font-size: clamp(1.8rem, 7vw, 2.5rem);
            font-weight: 900;
            line-height: 1.1;
        }

        .rb-checkout-intro {
            margin-top: 8px;
            color: #5F5149;
            font-size: 14px;
        }

        .rb-checkout-items {
            display: grid;
            gap: 10px;
        }

        .rb-checkout-item {
            display: flex;
            min-width: 0;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            border: 1px solid #F0E6D8;
            border-radius: 14px;
            background: #FFFFFF;
            padding: 12px;
        }

        .rb-checkout-item__info {
            min-width: 0;
        }

        .rb-checkout-item__name {
            color: #211D1A;
            font-size: 14px;
            font-weight: 800;
            overflow-wrap: anywhere;
        }

        .rb-checkout-item__price {
            margin-top: 3px;
            color: #5F5149;
            font-size: 12px;
        }

        .rb-checkout-item__controls {
            display: flex;
            flex: 0 0 auto;
            align-items: center;
            gap: 8px;
        }

        .rb-checkout-item__quantity-button {
            display: inline-flex;
            width: 36px;
            height: 36px;
            align-items: center;
            justify-content: center;
            border: 1px solid #6B0F0F;
            border-radius: 999px;
            background: #FFFDF8;
            color: #6B0F0F;
            font-size: 20px;
            font-weight: 700;
            cursor: pointer;
        }

        .rb-checkout-item__quantity-button--plus {
            background: #6B0F0F;
            color: #FFFDF8;
        }

        .rb-checkout-item__quantity-button:hover:not(:disabled) {
            background: #F9F1E8;
        }

        .rb-checkout-item__quantity-button--plus:hover:not(:disabled) {
            background: #4A0D0D;
        }

        .rb-checkout-item__quantity-button:disabled {
            border-color: #D8C8B7;
            background: #E5DDD7;
            color: #5F5149;
            cursor: not-allowed;
        }

        .rb-checkout-item__quantity {
            min-width: 20px;
            color: #211D1A;
            font-size: 14px;
            font-weight: 800;
            text-align: center;
        }

        .rb-checkout-empty {
            border: 1px dashed #D8C8B7;
            border-radius: 16px;
            background: #F9F1E8;
            padding: 24px 16px;
            color: #4A0D0D;
            text-align: center;
        }

        .rb-checkout-empty p {
            font-size: 14px;
            font-weight: 600;
        }

        .rb-checkout-back-menu {
            display: inline-flex;
            min-height: 42px;
            align-items: center;
            justify-content: center;
            margin-top: 14px;
            border-radius: 999px;
            background: #6B0F0F;
            padding: 0 18px;
            color: #FFFDF8;
            font-size: 11px;
            font-weight: 800;
            letter-spacing: .06em;
            text-decoration: none;
        }

        .rb-checkout-total {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            margin-top: 14px;
            border-radius: 14px;
            background: #F9F1E8;
            padding: 16px;
            color: #4A0D0D;
            font-size: 14px;
        }

        .rb-checkout-total strong {
            font-size: 18px;
            font-weight: 900;
            text-align: right;
        }

        .rb-checkout-form {
            margin-top: 24px;
            border: 1px solid #F0E6D8;
            border-radius: 20px;
            background: #FFFFFF;
            padding: 18px;
            box-shadow: 0 10px 28px rgba(74, 13, 13, .07);
        }

        .rb-checkout-fields {
            display: grid;
            gap: 18px;
        }

        .rb-checkout-label {
            display: block;
            margin-bottom: 8px;
            color: #211D1A;
            font-size: 13px;
            font-weight: 800;
        }

        .rb-checkout-input {
            display: block;
            width: 100%;
            min-height: 48px;
            border: 1px solid #D8C8B7;
            border-radius: 12px;
            background: #FFFDF8;
            padding: 12px 14px;
            color: #211D1A;
            font: inherit;
            font-size: 14px;
        }

        .rb-checkout-input:focus-visible {
            border-color: #E85D3F;
            outline: 3px solid rgba(232, 93, 63, .25);
            outline-offset: 2px;
        }

        .rb-checkout-input--textarea {
            min-height: 104px;
            resize: vertical;
        }

        .rb-payment-heading {
            margin-bottom: 10px;
            color: #211D1A;
            font-size: 13px;
            font-weight: 800;
        }

        .rb-payment-methods {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 10px;
        }

        .rb-payment-option {
            position: relative;
            min-width: 0;
            cursor: pointer;
        }

        .rb-payment-option input {
            position: absolute;
            width: 1px;
            height: 1px;
            overflow: hidden;
            clip: rect(0, 0, 0, 0);
            white-space: nowrap;
            clip-path: inset(50%);
        }

        .rb-payment-card {
            position: relative;
            display: block;
            min-height: 82px;
            border: 1px solid #D8C8B7;
            border-radius: 14px;
            background: #FFFFFF;
            padding: 12px 38px 12px 12px;
            transition: border-color .18s ease, background-color .18s ease;
        }

        .rb-payment-card::after {
            position: absolute;
            top: 10px;
            right: 10px;
            display: inline-flex;
            width: 19px;
            height: 19px;
            align-items: center;
            justify-content: center;
            border-radius: 999px;
            background: #E85D3F;
            color: #FFFDF8;
            content: "✓";
            font-size: 12px;
            font-weight: 900;
            line-height: 1;
            opacity: 0;
            transform: scale(.8);
            transition: opacity .18s ease, transform .18s ease;
        }

        .rb-payment-option input:checked + .rb-payment-card {
            border: 2px solid #E85D3F;
            background: #F9F1E8;
            padding: 11px 37px 11px 11px;
        }

        .rb-payment-option input:focus-visible + .rb-payment-card {
            outline: 3px solid rgba(232, 93, 63, .3);
            outline-offset: 2px;
        }

        .rb-payment-card__name {
            display: block;
            padding-right: 22px;
            color: #211D1A;
            font-size: 13px;
            font-weight: 800;
        }

        .rb-payment-card__help {
            display: block;
            margin-top: 4px;
            color: #5F5149;
            font-size: 11px;
            line-height: 1.35;
        }

        .rb-payment-option input:checked + .rb-payment-card::after {
            opacity: 1;
            transform: scale(1);
        }

        .rb-checkout-payment-help {
            margin-top: 12px;
            color: #5F5149;
            font-size: 12px;
            line-height: 1.5;
        }

        .rb-checkout-hint {
            margin-top: 18px;
            border-radius: 10px;
            background: #F9F1E8;
            padding: 10px 12px;
            color: #4A0D0D;
            font-size: 13px;
            font-weight: 700;
            text-align: center;
        }

        .rb-checkout-mascot {
            display: flex;
            min-height: 112px;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 2px;
            margin-top: 14px;
            color: #6B0F0F;
            font-size: 12px;
            font-weight: 700;
            text-align: center;
        }

        .rb-checkout-mascot img {
            display: block;
            width: 160px;
            max-width: 100%;
            height: auto;
            filter: drop-shadow(0 8px 6px rgba(74, 13, 13, .16));
            animation: rb-checkout-jump 3s ease-in-out infinite;
        }

        .rb-checkout-submit {
            display: flex;
            width: 100%;
            min-height: 52px;
            align-items: center;
            justify-content: center;
            margin-top: 8px;
            border: 0;
            border-radius: 14px;
            background: #6B0F0F;
            padding: 0 18px;
            color: #FFFDF8;
            font-size: 13px;
            font-weight: 900;
            letter-spacing: .08em;
            cursor: pointer;
            transition: background-color .18s ease, transform .18s ease;
        }

        .rb-checkout-submit:hover {
            background: #4A0D0D;
        }

        .rb-checkout-submit:focus-visible,
        .rb-checkout-back-menu:focus-visible,
        .rb-checkout-item__quantity-button:focus-visible {
            outline: 3px solid #E85D3F;
            outline-offset: 3px;
        }

        .rb-checkout-submit.rb-checkout-shake {
            animation: rb-checkout-shake .36s ease;
        }

        @keyframes rb-checkout-jump {
            0%, 88%, 100% { transform: translateY(0); }
            92% { transform: translateY(-7px); }
            96% { transform: translateY(0); }
        }

        @keyframes rb-checkout-shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-6px); }
            50% { transform: translateX(6px); }
            75% { transform: translateX(-3px); }
        }

        @keyframes rb-menu-bounce {
            0%, 100% { transform: translateY(0) scale(1); }
            45% { transform: translateY(-5px) scale(1.02); }
        }

        .rb-boemi-mascot {
            display: block;
            width: 100%;
            height: auto;
            max-width: none;
            max-height: none;
            filter: drop-shadow(0 13px 10px rgba(0, 0, 0, .24));
            animation: boemi-float 2.5s ease-in-out infinite;
        }

        .rb-boemi-mascot-wrap {
            position: absolute;
            z-index: 3;
            right: 8px;
            bottom: 0;
            width: 220px;
        }

        .rb-boemi-speech {
            position: absolute;
            right: 0;
            bottom: calc(100% + 8px);
            z-index: 2;
            width: max-content;
            max-width: calc(100vw - 32px);
            border: 1px solid #E8D8C8;
            border-radius: 999px;
            background: #FFFDF8;
            padding: 9px 13px;
            color: #4A0D0D;
            font-size: 12px;
            font-weight: 800;
            line-height: 1.2;
            white-space: nowrap;
            box-shadow: 0 6px 18px rgba(0, 0, 0, .2);
        }

        .rb-boemi-speech::after {
            position: absolute;
            right: 24px;
            bottom: -6px;
            width: 10px;
            height: 10px;
            border-right: 1px solid #E8D8C8;
            border-bottom: 1px solid #E8D8C8;
            background: #FFFDF8;
            content: "";
            transform: rotate(45deg);
        }

        .rb-hero__decor {
            position: absolute;
            z-index: 1;
            width: 36px;
            height: 36px;
            animation: boemi-float 2.5s ease-in-out infinite;
        }

        .rb-hero__decor svg {
            display: block;
            width: 100%;
            height: 100%;
        }

        .rb-hero__decor--bean {
            right: 22%;
            bottom: 27%;
            width: 28px;
            animation-delay: -.6s;
        }

        .rb-hero__decor--leaf {
            right: 3%;
            bottom: 45%;
            width: 36px;
            animation-delay: -1.3s;
        }

        .rb-hero__decor--steam {
            right: 14%;
            bottom: 58%;
            width: 34px;
            animation-delay: -.9s;
        }

        @keyframes boemi-float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-8px); }
        }

        @media (min-width: 768px) {
            .rb-menu-section {
                padding: 76px 24px 96px;
            }

            .rb-menu-grid {
                grid-template-columns: repeat(3, minmax(0, 1fr));
                gap: 18px;
            }

            .rb-menu-card__body {
                padding: 16px;
            }

            .rb-checkout-form {
                padding: 24px;
            }

            .rb-menu-card__footer {
                flex-direction: row;
                align-items: center;
                justify-content: space-between;
                gap: 10px;
            }

            .rb-hero__copy {
                width: min(60%, 570px);
                padding-bottom: 0;
            }

            .rb-boemi-mascot-wrap {
                width: 320px;
            }
        }

        @media (prefers-reduced-motion: reduce) {
            .rb-customer-nav__cart,
            .rb-hero__cta,
            .rb-boemi-mascot,
            .rb-hero__decor,
            .rb-menu-filter,
            .rb-menu-card__action,
            .rb-success-mascot,
            .rb-success-confetti,
            .rb-success-button,
            .rb-customer-nav__cart.rb-cart-wiggle svg,
            .rb-customer-nav__count.rb-count-pop {
                animation: none !important;
                transition: none !important;
            }

            .rb-menu-card {
                opacity: 1;
                transform: none;
                transition: none;
            }

            .rb-menu-card--bounce {
                animation: none !important;
            }

            .rb-checkout-mascot img,
            .rb-checkout-submit.rb-checkout-shake {
                animation: none !important;
            }

            .rb-payment-card,
            .rb-payment-card::after,
            .rb-checkout-submit {
                transition: none;
            }
        }
    </style>
</head>

<body class="bg-[#4A0D0D] text-[#211D1A] antialiased">

    <section id="welcome" aria-label="Sambutan">
        <div class="boemi-welcome-logo">
            restoe boemi
            <small>KOPI • RASA • CERITA</small>
        </div>
        <button class="boemi-welcome-skip" id="skip" type="button">Lewati</button>

        <span class="boemi-welcome-float" aria-hidden="true">☕</span>
        <span class="boemi-welcome-float" aria-hidden="true">🍃</span>
        <span class="boemi-welcome-float" aria-hidden="true">☕</span>
        <span class="boemi-welcome-float" aria-hidden="true">🍃</span>
        <span class="boemi-welcome-float" aria-hidden="true">☕</span>

        <div class="boemi-welcome-bubble" aria-live="polite">
            <span id="txt"></span><span class="boemi-welcome-caret"></span>
        </div>

        <div class="boemi-welcome-stage" id="stage" role="button" tabindex="0"
            aria-label="Si Boemi, ketuk untuk menyapa">
            <div class="boemi-welcome-shadow" aria-hidden="true"></div>
            <div class="boemi-welcome-rig" id="boemi-welcome-rig">
                <img src="{{ asset('images/mascot/boemi-wave.png') }}" alt="Si Boemi melambai"
                    width="700" height="380" decoding="async">
                <img src="{{ asset('images/mascot/boemi-point.png') }}" alt="Si Boemi menunjuk"
                    width="700" height="380" decoding="async">
                <img src="{{ asset('images/mascot/boemi-tray.png') }}" alt="Si Boemi membawa nampan"
                    width="700" height="380" decoding="async">
                <img src="{{ asset('images/mascot/boemi-thumbs.png') }}" alt="Si Boemi mengacungkan jempol"
                    width="700" height="380" decoding="async">
                <img src="{{ asset('images/mascot/boemi-idle.png') }}" alt="Si Boemi tersenyum"
                    width="700" height="380" decoding="async">
            </div>
        </div>

        <div class="boemi-welcome-dots" id="dots" aria-hidden="true">
            <i></i><i></i><i></i><i></i>
        </div>
        <button class="boemi-welcome-btn" id="go" type="button">Mulai Pesan</button>
    </section>

    <script>
        (function() {
            var W = document.getElementById('welcome');
            var imgs = Array.prototype.slice.call(document.querySelectorAll('#boemi-welcome-rig img'));
            var txt = document.getElementById('txt');
            var dots = Array.prototype.slice.call(document.querySelectorAll('#dots i'));
            var go = document.getElementById('go');
            var stage = document.getElementById('stage');
            var skip = document.getElementById('skip');
            var reduce = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
            var seq = [
                [0, 'Halo kak! Selamat datang di Restoe Boemi!'],
                [1, 'Duduk dulu, lihat menunya di sini ya!'],
                [2, 'Ada kopi dan camilan hangat buat kamu.'],
                [3, 'Pesan lewat HP, nanti kami antar!']
            ];
            var timers = [];
            var cur = -1;
            var typing = null;
            var closed = false;

            function later(callback, delay) {
                var timer = window.setTimeout(callback, delay);
                timers.push(timer);
                return timer;
            }

            function clearAll() {
                timers.forEach(function(timer) {
                    window.clearTimeout(timer);
                });
                timers = [];
                window.clearInterval(typing);
            }

            function type(text) {
                window.clearInterval(typing);
                txt.textContent = '';
                if (reduce) {
                    txt.textContent = text;
                    return;
                }

                var index = 0;
                typing = window.setInterval(function() {
                    txt.textContent = text.slice(0, ++index);
                    if (index >= text.length) window.clearInterval(typing);
                }, 38);
            }

            function show(index) {
                if (cur >= 0) {
                    imgs[cur].classList.remove('on');
                    imgs[cur].classList.add('off');
                }

                var image = imgs[index];
                image.classList.remove('off');
                void image.offsetWidth;
                image.classList.add('on');
                dots.forEach(function(dot, dotIndex) {
                    dot.classList.toggle('a', dotIndex === index);
                });
                cur = index;
            }

            function step(index) {
                if (closed) return;

                var current = seq[index];
                show(current[0]);
                type(current[1]);
                if (index === seq.length - 1) go.classList.add('show');

                var wait = Math.max(3000, current[1].length * 38 + 1600);
                later(function() {
                    step((index + 1) % seq.length);
                }, wait);
            }

            function start() {
                closed = false;
                W.classList.remove('out');
                go.classList.remove('show');
                cur = -1;
                imgs.forEach(function(image) {
                    image.classList.remove('on', 'off');
                });
                clearAll();
                later(function() {
                    step(0);
                }, 700);
                if (reduce) go.classList.add('show');
            }

            function close() {
                closed = true;
                clearAll();
                W.classList.add('out');
                try {
                    sessionStorage.setItem('boemi_welcome', '1');
                } catch (error) {
                    console.warn('Status sambutan tidak dapat disimpan ke sessionStorage.', error);
                }
            }

            var hi = ['Hai kak!', 'Kopi susu enak nih!', 'Yuk pesan!', 'Geli ih, hihi!', 'Mau yang manis atau pahit?'];
            var hiIndex = 0;

            function tap() {
                stage.classList.remove('hop');
                void stage.offsetWidth;
                stage.classList.add('hop');
                window.clearTimeout(stage._timer);
                stage._timer = window.setTimeout(function() {
                    stage.classList.remove('hop');
                }, 520);
                type(hi[hiIndex++ % hi.length]);
            }

            stage.addEventListener('click', tap);
            stage.addEventListener('keydown', function(event) {
                if (event.key === 'Enter' || event.key === ' ') {
                    event.preventDefault();
                    tap();
                }
            });
            go.addEventListener('click', close);
            skip.addEventListener('click', close);
            document.addEventListener('visibilitychange', function() {
                if (document.hidden) clearAll();
                else if (!closed) step(Math.max(cur, 0));
            });

            var seen = false;
            try {
                seen = sessionStorage.getItem('boemi_welcome') === '1';
            } catch (error) {
                seen = false;
                console.warn('Status sambutan tidak dapat dibaca dari sessionStorage.', error);
            }

            if (seen) {
                W.classList.add('out');
                closed = true;
            } else {
                start();
            }
        })();
    </script>

    {{-- NAVBAR --}}
    <nav class="rb-customer-nav sticky top-0 z-50 border-b border-white/10 bg-[#4A0D0D] text-[#FFFDF8]">
        <div class="rb-customer-nav__inner">
            <a href="{{ session('success') ? route('menu.show', $table->qr_token) : '#top' }}"
                class="rb-customer-nav__brand">
                <span class="rb-customer-nav__name">restoe boemi</span>
                <span class="rb-customer-nav__tagline">KOPI • RASA • CERITA</span>
            </a>

            <a href="{{ session('success') ? route('menu.show', $table->qr_token) : '#pesanan' }}"
                class="rb-customer-nav__cart"
                aria-label="{{ session('success') ? 'Kembali ke menu' : 'Lihat ringkasan pesanan' }}">
                <svg aria-hidden="true" width="23" height="23" viewBox="0 0 24 24" fill="none">
                    <path d="M3 4h2l2.2 10.1a2 2 0 0 0 2 1.6h8.5a2 2 0 0 0 1.9-1.4L21 8H6"
                        stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                    <circle cx="10" cy="19" r="1.4" fill="currentColor"/>
                    <circle cx="18" cy="19" r="1.4" fill="currentColor"/>
                </svg>
                <span id="nav-cart-count" class="rb-customer-nav__count" aria-live="polite">0</span>
            </a>
        </div>
    </nav>

    @if (session('success'))
    <main class="rb-success-screen">
        <span class="rb-success-confetti rb-success-confetti--coffee" aria-hidden="true">☕</span>
        <span class="rb-success-confetti rb-success-confetti--leaf" aria-hidden="true">🍃</span>
        <span class="rb-success-confetti rb-success-confetti--coffee-small" aria-hidden="true">☕</span>

        <section class="rb-success-content" role="status" aria-live="polite">
            <img
                class="rb-success-mascot"
                src="{{ asset('images/mascot/boemi-celebrate.png') }}"
                alt=""
                width="680"
                height="383"
                loading="lazy"
                decoding="async">

            <p class="rb-success-kicker">PESANAN DITERIMA</p>
            <h1 class="rb-success-title">Yeay! Pesanan Kamu <span>Lagi Dimasak!</span></h1>
            <p class="rb-success-copy">Pesananmu sudah masuk. Tim dapur akan segera menyiapkannya.</p>
            <p class="rb-success-message">{{ session('success') }}</p>
            <a href="{{ route('menu.show', $table->qr_token) }}" class="rb-success-button">
                KEMBALI KE MENU
            </a>
        </section>
    </main>
    @else
    @if ($errors->any())
    <div class="mx-auto max-w-7xl px-5 pt-4">
        <div role="alert" aria-live="assertive"
            class="border-l-4 border-[#710014] bg-[#F5EFE6] px-5 py-4 text-[#211D1A] shadow-lg">
            <p class="font-bold text-[#710014]">Pesanan belum terkirim</p>
            <p class="mt-1 text-sm">Periksa kembali informasi berikut:</p>
            <ul class="mt-2 list-inside list-disc space-y-1 text-sm">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
            <a href="#pesanan"
                class="mt-4 inline-flex min-h-11 items-center justify-center rounded-full bg-[#710014] px-5 text-xs font-bold tracking-wider text-[#F5EFE6] transition hover:bg-[#4B000D] focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#710014] focus-visible:ring-offset-2">
                PERIKSA PESANAN
            </a>
        </div>
    </div>
    @endif

    {{-- HERO --}}
    <section id="top" class="rb-hero">
        <img
            src="{{ asset('images/customer/foto1.jpg') }}"
            alt="Suasana Restoe Boemi"
            class="absolute inset-0 h-full w-full object-cover">

        <div class="rb-hero__overlay"></div>

        <div class="rb-hero__inner">
            <div class="rb-hero__copy">
                <p class="rb-hero__eyebrow">
                    KOPI • RASA • CERITA
                </p>

                <h1 class="rb-hero__title">
                    Setiap Rasa Punya <span>Cerita.</span>
                </h1>

                <p class="rb-hero__subtitle">
                    Nikmati secangkir kopi, hidangan pilihan, dan suasana hangat di setiap kunjungan.
                </p>

                <a href="#menu" class="rb-hero__cta">
                    JELAJAHI MENU
                </a>
            </div>

            <span class="rb-hero__decor rb-hero__decor--bean" aria-hidden="true">
                <svg viewBox="0 0 30 30" fill="none">
                    <ellipse cx="15" cy="15" rx="8" ry="11" transform="rotate(32 15 15)" fill="#E85D3F"/>
                    <path d="M10 22c4-5 6-10 10-15" stroke="#4A0D0D" stroke-width="2" stroke-linecap="round"/>
                </svg>
            </span>
            <span class="rb-hero__decor rb-hero__decor--leaf" aria-hidden="true">
                <svg viewBox="0 0 32 32" fill="none">
                    <path d="M26 5C13 5 5 10 6 20c1 6 8 8 13 4 5-4 7-11 7-19Z" fill="#87A96B"/>
                    <path d="M7 25c5-7 9-10 15-14" stroke="#4A0D0D" stroke-width="1.8" stroke-linecap="round"/>
                </svg>
            </span>
            <span class="rb-hero__decor rb-hero__decor--steam" aria-hidden="true">
                <svg viewBox="0 0 30 34" fill="none">
                    <path d="M7 29c0-5 5-5 5-10S8 14 8 9" stroke="#FFFDF8" stroke-width="2.5" stroke-linecap="round"/>
                    <path d="M18 29c0-5 5-5 5-10s-4-5-4-10" stroke="#E85D3F" stroke-width="2.5" stroke-linecap="round"/>
                </svg>
            </span>

        </div>
        <div class="rb-boemi-mascot-wrap">
            <span class="rb-boemi-speech">Halo! Mau ngopi apa?</span>
            <img
                class="rb-boemi-mascot"
                src="{{ asset('images/mascot/boemi-hero.png') }}"
                alt="Si Boemi, maskot barista Restoe Boemi"
                width="680"
                height="383"
                decoding="async">
        </div>
    </section>

    {{-- CERITA --}}
    <section id="cerita" class="bg-[#F5EFE6] px-6 py-20 md:py-28">
        <div class="mx-auto grid max-w-7xl items-center gap-12 md:grid-cols-2">
            <div>
                <p class="text-xs tracking-[0.3em] text-[#710014]">TENTANG RESTOE BOEMI</p>

                <h2 class="mt-5 font-serif text-4xl leading-tight md:text-5xl">
                    Lebih dari Sekadar
                    <span class="italic text-[#710014]">Secangkir Kopi.</span>
                </h2>

                <p class="mt-7 leading-8 text-[#76543A]">
                    Restoe Boemi hadir sebagai tempat untuk menikmati
                    waktu, berbagi cerita, dan menemukan rasa dalam
                    suasana yang hangat.
                </p>

                <p class="mt-4 leading-8 text-[#76543A]">
                    Dari aroma kopi hingga hidangan yang disajikan,
                    setiap detail menjadi bagian dari pengalaman
                    yang ingin kami bagikan.
                </p>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <img src="{{ asset('images/customer/foto2.jpg') }}"
                    alt="Interior coffee shop"
                    class="h-64 w-full rounded-sm object-cover md:h-80">

                <img src="{{ asset('images/customer/foto3.jpg') }}"
                    alt="Suasana kopi"
                    class="h-64 w-full rounded-sm object-cover md:h-80">
            </div>
        </div>
    </section>

    {{-- MENU --}}
    <section id="menu" class="rb-menu-section">
        <div class="rb-menu-content">
            <header class="rb-menu-heading">
                <p class="rb-menu-kicker">PILIHAN UNTUKMU</p>
                <h2 class="rb-menu-title">Menu <span>Favorit</span></h2>
                <p class="rb-menu-intro">Temukan menu favoritmu hari ini.</p>
            </header>

            <div class="rb-menu-tools">
                <label class="rb-menu-search">
                    <span class="sr-only">Cari menu</span>
                    <svg aria-hidden="true" viewBox="0 0 24 24" fill="none">
                        <circle cx="10.8" cy="10.8" r="6.8" stroke="currentColor" stroke-width="1.8"/>
                        <path d="m16 16 4.2 4.2" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"/>
                    </svg>
                    <input id="menu-search" type="search" placeholder="Cari menu..." autocomplete="off">
                </label>

                <div class="rb-menu-categories" role="group" aria-label="Filter kategori menu">
                    <button type="button" class="rb-menu-filter is-active" data-category-filter="all" aria-pressed="true">
                        Semua Menu
                    </button>
                    @foreach ($categories as $category)
                    <button type="button" class="rb-menu-filter" data-category-filter="{{ $category->id }}" aria-pressed="false">
                        {{ $category->name }}
                    </button>
                    @endforeach
                </div>
            </div>

            {{-- DAFTAR MENU --}}
            @forelse ($categories as $category)
            <section id="category-{{ $category->id }}" class="rb-menu-category" data-menu-category="{{ $category->id }}">
                <header class="rb-menu-category__heading">
                    <h3 class="rb-menu-category__title">{{ $category->name }}</h3>
                    @if ($category->description)
                    <p class="rb-menu-category__description">{{ $category->description }}</p>
                    @endif
                </header>

                <div class="rb-menu-grid">
                    @foreach ($category->menus as $menu)
                    <article
                        class="rb-menu-card"
                        data-menu-search="{{ $menu->name }} {{ $menu->description ?: 'Sajian pilihan dari Restoe Boemi.' }}"
                        style="--menu-card-delay: {{ min($loop->index, 5) * 55 }}ms;">
                        @if ($menu->image_path)
                        <img
                            src="{{ asset('storage/' . $menu->image_path) }}"
                            alt="{{ $menu->name }}"
                            loading="lazy"
                            decoding="async"
                            class="rb-menu-card__image">
                        @else
                        <div class="rb-menu-card__placeholder" role="img" aria-label="Foto {{ $menu->name }} belum tersedia">
                            <svg aria-hidden="true" viewBox="0 0 48 48" fill="none">
                                <path d="M11 18h25l-3 23H14l-3-23Z" stroke="currentColor" stroke-width="2.5" stroke-linejoin="round"/>
                                <path d="M36 21h2a5 5 0 0 1 0 10h-3M15 14c-2-2 2-3 0-5m9 5c-2-2 2-3 0-5m9 5c-2-2 2-3 0-5"
                                    stroke="currentColor" stroke-width="2.5" stroke-linecap="round"/>
                                <path d="M17 25h13" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"/>
                            </svg>
                            <span>Foto menu belum tersedia</span>
                        </div>
                        @endif

                        <div class="rb-menu-card__body">
                            <h4 class="rb-menu-card__name">{{ $menu->name }}</h4>
                            <p class="rb-menu-card__description">
                                {{ $menu->description ?: 'Sajian pilihan dari Restoe Boemi.' }}
                            </p>

                            <div class="rb-menu-card__footer">
                                <div>
                                    <p class="rb-menu-card__price">Rp {{ number_format($menu->price, 0, ',', '.') }}</p>
                                    @if (! $menu->is_available)
                                    <span class="rb-menu-card__sold-out">HABIS</span>
                                    @endif
                                </div>

                                <div class="rb-menu-card__controls">
                                    @if ($menu->is_available)
                                    <button
                                        type="button"
                                        class="rb-menu-card__action rb-menu-card__action--step menu-quantity-decrease"
                                        data-id="{{ $menu->id }}"
                                        aria-label="Kurangi {{ $menu->name }}"
                                        hidden>−</button>
                                    <span class="rb-menu-card__quantity menu-quantity-value" aria-live="polite" hidden>0</span>
                                    <button
                                        type="button"
                                        class="rb-menu-card__action add-to-cart"
                                        data-id="{{ $menu->id }}"
                                        data-name="{{ $menu->name }}"
                                        data-price="{{ $menu->price }}"
                                        data-available="1"
                                        aria-label="Tambah {{ $menu->name }} ke keranjang">
                                        + TAMBAH
                                    </button>
                                    @else
                                    <button
                                        type="button"
                                        class="rb-menu-card__action is-unavailable menu-unavailable"
                                        data-id="{{ $menu->id }}"
                                        data-name="{{ $menu->name }}"
                                        data-price="{{ $menu->price }}"
                                        data-available="0"
                                        aria-disabled="true"
                                        aria-label="{{ $menu->name }} sedang habis">
                                        HABIS
                                    </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </article>
                    @endforeach
                </div>
            </section>
            @empty
            <p class="rb-menu-empty">Menu belum tersedia.</p>
            @endforelse

            <p id="menu-search-empty" class="rb-menu-empty" role="status" hidden>
                Menu yang kamu cari belum ditemukan. Coba kata kunci lain, ya.
            </p>
        </div>
    </section>


    {{-- CHECKOUT --}}
    <section id="pesanan" class="rb-checkout-section">
        <div class="rb-checkout-content">
            <header class="rb-checkout-heading">
                <p class="rb-checkout-kicker">PILIHANMU</p>
                <h2 class="rb-checkout-title">Ringkasan Pesanan</h2>
                <p class="rb-checkout-intro">Periksa pesananmu sebelum dikirim ke dapur.</p>
            </header>

            <div id="cart-items" class="rb-checkout-items">
                <div class="rb-checkout-empty">
                    <p>Keranjang masih kosong. Yuk, pilih menu favoritmu!</p>
                    <a href="#menu" class="rb-checkout-back-menu">KEMBALI KE MENU</a>
                </div>
            </div>

            <div class="rb-checkout-total">
                <span>Total Pesanan</span>
                <strong id="cart-total">Rp 0</strong>
            </div>

            <form id="order-form"
                action="{{ route('menu.orders.store', $table->qr_token) }}"
                method="POST"
                data-old-items="{{ json_encode(old('items', [])) }}"
                class="rb-checkout-form">
                @csrf

                <div id="cart-hidden-inputs"></div>

                <div class="rb-checkout-fields">
                        <div>
                            <label for="customer_name" class="rb-checkout-label">
                                Nama Pemesan <span aria-hidden="true">*</span>
                            </label>
                            <input
                                type="text"
                                id="customer_name"
                                name="customer_name"
                                value="{{ old('customer_name') }}"
                                required
                                maxlength="100"
                                placeholder="Masukkan nama kamu"
                                aria-describedby="customer-name-error"
                                class="rb-checkout-input">
                            <p id="customer-name-error" class="rb-customer-name-error" role="alert" hidden>
                                <svg viewBox="0 0 16 16" aria-hidden="true"><circle cx="8" cy="8" r="6.5"/><path d="M8 4.5v4m0 2h.01"/></svg>
                                <span>Isi nama kamu dulu ya!</span>
                            </p>
                        </div>

                        <div>
                            <label for="notes" class="rb-checkout-label">
                                Catatan Pesanan
                                <span class="font-normal text-[#5F5149]">(Opsional)</span>
                            </label>
                            <textarea
                                id="notes"
                                name="notes"
                                rows="3"
                                maxlength="1000"
                                placeholder="Contoh: Tidak pakai gula, es sedikit..."
                                class="rb-checkout-input rb-checkout-input--textarea">{{ old('notes') }}</textarea>
                        </div>

                        <div>
                            <p class="rb-payment-heading">Metode Pembayaran</p>

                            <div class="rb-payment-methods">

                                <label class="rb-payment-option">
                                    <input
                                        type="radio"
                                        name="payment_method"
                                        value="cash"
                                        required
                                        {{ old('payment_method', 'cash') === 'cash' ? 'checked' : '' }}>

                                    <div class="rb-payment-card">
                                        <span class="rb-payment-card__name">Tunai</span>
                                        <span class="rb-payment-card__help">Bayar ke kasir</span>
                                    </div>
                                </label>

                                <label class="rb-payment-option">
                                    <input
                                        type="radio"
                                        name="payment_method"
                                        value="transfer"
                                        required
                                        {{ old('payment_method') === 'transfer' ? 'checked' : '' }}>

                                    <div class="rb-payment-card">
                                        <span class="rb-payment-card__name">Transfer</span>
                                        <span class="rb-payment-card__help">Transfer bank</span>
                                    </div>
                                </label>

                                <label class="rb-payment-option">
                                    <input
                                        type="radio"
                                        name="payment_method"
                                        value="qris"
                                        required
                                        {{ old('payment_method') === 'qris' ? 'checked' : '' }}>

                                    <div class="rb-payment-card">
                                        <span class="rb-payment-card__name">QRIS</span>
                                        <span class="rb-payment-card__help">Scan kode QR</span>
                                    </div>
                                </label>

                                <label class="rb-payment-option">
                                    <input
                                        type="radio"
                                        name="payment_method"
                                        value="debit"
                                        required
                                        {{ old('payment_method') === 'debit' ? 'checked' : '' }}>

                                    <div class="rb-payment-card">
                                        <span class="rb-payment-card__name">Debit</span>
                                        <span class="rb-payment-card__help">Kartu debit</span>
                                    </div>
                                </label>

                            </div>

                            <p class="rb-checkout-payment-help">
                                Pembayaran akan dikonfirmasi oleh kasir setelah pesanan diterima.
                            </p>
                        </div>
                </div>

                <div class="rb-checkout-mascot" aria-hidden="true">
                    <img
                        src="{{ asset('images/mascot/boemi-tray.png') }}"
                        alt=""
                        width="680"
                        height="383"
                        loading="lazy"
                        decoding="async">
                    <span>Si Boemi siap mengantar pesananmu!</span>
                </div>

                <button type="submit" id="submit-order" class="rb-checkout-submit">
                    KIRIM PESANAN
                </button>
            </form>
        </div>
    </section>


    {{-- GALERI --}}
    <section id="galeri" class="bg-[#710014] px-6 py-20 text-[#F5EFE6]">
        <div class="mx-auto max-w-7xl">
            <div class="mb-10 text-center">
                <p class="text-xs tracking-[0.35em] text-[#D8BDA5]">
                    A GLIMPSE OF OUR PLACE
                </p>
                <h2 class="mt-4 font-serif text-4xl">
                    The <span class="italic text-[#D8BDA5]">Atmosphere</span>
                </h2>
            </div>

            <div class="grid grid-cols-2 gap-3 md:grid-cols-4">
                <img src="{{ asset('images/customer/foto4.jpg') }}"
                    alt="Suasana Restoe Boemi"
                    class="h-52 w-full object-cover md:h-72">

                <img src="{{ asset('images/customer/foto5.jpg') }}"
                    alt="Pengalaman menikmati kopi"
                    class="h-52 w-full object-cover md:h-72">

                <img src="{{ asset('images/customer/foto6.jpg') }}"
                    alt="Detail coffee shop"
                    class="h-52 w-full object-cover md:h-72">

                <img src="{{ asset('images/customer/foto7.jpg') }}"
                    alt="Momen di coffee shop"
                    class="h-52 w-full object-cover md:h-72">
            </div>

            <div class="mt-3 grid grid-cols-2 gap-3">
                <img src="{{ asset('images/customer/foto8.jpg') }}"
                    alt="Suasana coffee shop"
                    class="h-48 w-full object-cover md:h-64">

                <img src="{{ asset('images/customer/foto9.jpg') }}"
                    alt="Momen menikmati hidangan"
                    class="h-48 w-full object-cover md:h-64">
            </div>
        </div>
    </section>

    {{-- FOOTER --}}
    <footer class="border-t border-white/10 bg-[#4B000D] px-6 py-10 text-center text-[#F5EFE6]">
        <h2 class="text-lg font-bold tracking-[0.25em]">RESTOE BOEMI</h2>
        <p class="mt-2 text-xs tracking-widest text-[#D8BDA5]">
            KOPI • RASA • CERITA
        </p>
        <p class="mt-6 text-xs text-[#F5EFE6]/50">
            © {{ date('Y') }} Restoe Boemi. All rights reserved.
        </p>
    </footer>

    {{-- CART SCRIPT --}}
    <script>
        const cart = new Map();
        const orderForm = document.getElementById('order-form');
        const navCartCount = document.getElementById('nav-cart-count');
        const navCart = document.querySelector('.rb-customer-nav__cart');
        const submitButton = document.getElementById('submit-order');
        const customerName = document.getElementById('customer_name');
        const customerNameError = document.getElementById('customer-name-error');
        const menuButtons = Array.from(document.querySelectorAll('.add-to-cart'));
        const unavailableButtons = Array.from(document.querySelectorAll('.menu-unavailable'));
        const menuSearch = document.getElementById('menu-search');
        const categoryFilterButtons = Array.from(document.querySelectorAll('[data-category-filter]'));
        const menuCategorySections = Array.from(document.querySelectorAll('[data-menu-category]'));
        const menuSearchEmpty = document.getElementById('menu-search-empty');

        function isMenuAvailable(id) {
            const button = menuButtons.find(
                menuButton => String(menuButton.dataset.id) === String(id)
            );

            return button?.dataset.available === '1';
        }
        let isSubmitting = false;

        const formatRupiah = (value) => {
            return 'Rp ' + Number(value).toLocaleString('id-ID');
        };

        function shakeSubmitButton() {
            submitButton.classList.remove('rb-checkout-shake');

            window.requestAnimationFrame(() => {
                submitButton.classList.add('rb-checkout-shake');
                window.setTimeout(() => {
                    submitButton.classList.remove('rb-checkout-shake');
                }, 400);
            });
        }

        function showNameError() {
            customerNameError.hidden = false;
            customerName.classList.add('rb-input-invalid');
            customerName.setAttribute('aria-invalid', 'true');
            shakeSubmitButton();
        }

        function clearNameError() {
            customerNameError.hidden = true;
            customerName.classList.remove('rb-input-invalid');
            customerName.removeAttribute('aria-invalid');
        }

        function warnEmptyCart() {
            shakeSubmitButton();
            window.toast.warning('Pilih dulu', 'Pilih menu dulu ya!');
        }

        customerName.addEventListener('invalid', event => {
            event.preventDefault();
            if (cart.size === 0) {
                warnEmptyCart();
            } else {
                showNameError();
                customerName.focus();
            }
        });

        customerName.addEventListener('input', () => {
            if (customerName.value.trim()) clearNameError();
        });

        function filterMenuCards() {
            const query = menuSearch.value.trim().toLocaleLowerCase('id-ID');
            const activeFilter = categoryFilterButtons.find(
                button => button.getAttribute('aria-pressed') === 'true'
            );
            const activeCategory = activeFilter?.dataset.categoryFilter || 'all';
            let hasResults = false;

            menuCategorySections.forEach(section => {
                const categoryMatches = activeCategory === 'all' ||
                    section.dataset.menuCategory === activeCategory;
                let visibleCards = 0;

                section.querySelectorAll('.rb-menu-card').forEach(card => {
                    const matchesSearch = card.dataset.menuSearch.toLocaleLowerCase('id-ID').includes(query);
                    card.hidden = !categoryMatches || !matchesSearch;
                    if (!card.hidden) visibleCards++;
                });

                section.hidden = visibleCards === 0;
                hasResults = hasResults || visibleCards > 0;
            });

            menuSearchEmpty.hidden = hasResults || menuCategorySections.length === 0;
        }

        categoryFilterButtons.forEach(button => {
            button.addEventListener('click', () => {
                categoryFilterButtons.forEach(filterButton => {
                    const isActive = filterButton === button;
                    filterButton.classList.toggle('is-active', isActive);
                    filterButton.setAttribute('aria-pressed', String(isActive));
                });

                filterMenuCards();
            });
        });

        menuSearch.addEventListener('input', filterMenuCards);

        const menuCards = Array.from(document.querySelectorAll('.rb-menu-card'));
        if ('IntersectionObserver' in window) {
            const menuCardObserver = new IntersectionObserver(entries => {
                entries.forEach(entry => {
                    if (!entry.isIntersecting) return;

                    entry.target.classList.add('is-visible');
                    menuCardObserver.unobserve(entry.target);
                });
            }, {
                rootMargin: '0px 0px 40px 0px',
                threshold: 0.05
            });

            menuCards.forEach(card => menuCardObserver.observe(card));
        } else {
            menuCards.forEach(card => card.classList.add('is-visible'));
        }

        function bounceMenuCard(button) {
            const card = button.closest('.rb-menu-card');
            if (!card) return;

            card.addEventListener('animationend', () => {
                card.classList.remove('rb-menu-card--bounce');
            }, { once: true });

            card.classList.remove('rb-menu-card--bounce');
            window.requestAnimationFrame(() => {
                card.classList.add('rb-menu-card--bounce');
            });
        }

        function animateCartHeader() {
            navCart.classList.remove('rb-cart-wiggle');
            navCartCount.classList.remove('rb-count-pop');
            window.requestAnimationFrame(() => {
                navCart.classList.add('rb-cart-wiggle');
                navCartCount.classList.add('rb-count-pop');
            });
        }

        function vibrateForAdd() {
            if (typeof navigator.vibrate === 'function') navigator.vibrate(30);
        }

        function renderCart() {
            const container = document.getElementById('cart-items');
            const totalElement = document.getElementById('cart-total');

            container.innerHTML = '';

            let total = 0;
            let itemCount = 0;

            if (cart.size === 0) {
                container.innerHTML = `
                    <div class="rb-checkout-empty">
                        <p>Keranjang masih kosong. Yuk, pilih menu favoritmu!</p>
                        <a href="#menu" class="rb-checkout-back-menu">KEMBALI KE MENU</a>
                    </div>
                `;
            }

            cart.forEach((item, id) => {
                const subtotal = item.price * item.quantity;
                total += subtotal;
                itemCount += item.quantity;

                const row = document.createElement('div');
                row.className = 'rb-checkout-item';

                const info = document.createElement('div');
                info.className = 'rb-checkout-item__info';

                const name = document.createElement('p');
                name.className = 'rb-checkout-item__name';
                name.textContent = item.name;

                const price = document.createElement('p');
                price.className = 'rb-checkout-item__price';
                price.textContent = formatRupiah(subtotal);

                info.append(name, price);

                const controls = document.createElement('div');
                controls.className = 'rb-checkout-item__controls';

                const minus = document.createElement('button');
                minus.type = 'button';
                minus.textContent = '-';
                minus.className = 'rb-checkout-item__quantity-button';
                minus.setAttribute('aria-label', `Kurangi ${item.name}`);
                minus.addEventListener('click', () => changeQuantity(id, -1));

                const quantity = document.createElement('span');
                quantity.textContent = item.quantity;
                quantity.className = 'rb-checkout-item__quantity';

                const plus = document.createElement('button');
                plus.type = 'button';
                plus.textContent = '+';
                plus.className = 'rb-checkout-item__quantity-button rb-checkout-item__quantity-button--plus';
                plus.setAttribute('aria-label', `Tambah ${item.name}`);
                plus.disabled = !isMenuAvailable(id);

                plus.addEventListener('click', () => changeQuantity(id, 1));

                controls.append(minus, quantity, plus);
                row.append(info, controls);
                container.appendChild(row);
            });

            totalElement.textContent = formatRupiah(total);
            navCartCount.textContent = itemCount;

            menuButtons.forEach(button => {
                const item = cart.get(String(button.dataset.id));
                const card = button.closest('.rb-menu-card');
                const decreaseButton = card.querySelector('.menu-quantity-decrease');
                const quantityValue = card.querySelector('.menu-quantity-value');

                button.textContent = item ? '+' : '+ TAMBAH';
                button.classList.toggle('rb-menu-card__action--added', Boolean(item));
                decreaseButton.hidden = !item;
                quantityValue.hidden = !item;
                quantityValue.textContent = item ? item.quantity : '0';
                button.setAttribute(
                    'aria-label',
                    item ?
                    `Tambah lagi ${button.dataset.name}; ${item.quantity} di keranjang` :
                    `Tambah ${button.dataset.name} ke keranjang`
                );
            });
        }

        function changeQuantity(id, amount) {
            const item = cart.get(String(id));

            if (!item) return;
            if (amount > 0 && !isMenuAvailable(id)) {
                window.toast.warning('Menu habis', `Maaf, ${item.name} sedang habis`);
                return;
            }

            if (amount > 0 && item.quantity >= 100) {
                window.toast.warning('Sudah cukup', 'Maksimal 100 porsi untuk satu menu.');
                return;
            }

            item.quantity += amount;
            const name = item.name;

            if (item.quantity <= 0) {
                cart.delete(String(id));
            }

            renderCart();
            if (amount > 0) {
                window.toast.success('Masuk keranjang', `${name} ditambahkan`);
                animateCartHeader();
                vibrateForAdd();
            } else if (!cart.has(String(id))) {
                window.toast.info('Dihapus', `${name} dihapus dari keranjang`);
            }
        }

        const previousItems = JSON.parse(orderForm.dataset.oldItems || '[]');
        const unavailablePreviousNames = [];
        if (Array.isArray(previousItems)) {
            previousItems.forEach(previousItem => {
                const id = String(previousItem.menu_id || '');
                const quantity = Number(previousItem.quantity);
                const button = menuButtons.find(menuButton => menuButton.dataset.id === id);
                const unavailableButton = unavailableButtons.find(menuButton => menuButton.dataset.id === id);

                if (
                    !button ||
                    !isMenuAvailable(id) ||
                    !Number.isInteger(quantity) ||
                    quantity < 1 ||
                    quantity > 100
                ) {
                    if (unavailableButton) unavailablePreviousNames.push(unavailableButton.dataset.name);
                    return;
                }

                cart.set(id, {
                    name: button.dataset.name,
                    price: Number(button.dataset.price),
                    quantity
                });
            });
        }
        if (unavailablePreviousNames.length) {
            document.addEventListener('DOMContentLoaded', () => {
                unavailablePreviousNames.forEach(name => {
                    window.toast.warning('Menu habis', `Maaf, ${name} sedang habis`);
                });
            }, { once: true });
        }

        document.querySelectorAll('.menu-quantity-decrease').forEach(button => {
            button.addEventListener('click', () => {
                changeQuantity(button.dataset.id, -1);
            });
        });

        menuButtons.forEach(button => {
            button.addEventListener('click', () => {
                const id = String(button.dataset.id);
                if (!isMenuAvailable(id)) {
                    window.toast.warning('Menu habis', `Maaf, ${button.dataset.name} sedang habis`);
                    return;
                }

                if (cart.has(id)) {
                    if (cart.get(id).quantity >= 100) {
                        window.toast.warning('Sudah cukup', 'Maksimal 100 porsi untuk satu menu.');
                        return;
                    }

                    cart.get(id).quantity++;
                } else {
                    cart.set(id, {
                        name: button.dataset.name,
                        price: Number(button.dataset.price),
                        quantity: 1
                    });
                }

                renderCart();
                bounceMenuCard(button);
                window.toast.success('Masuk keranjang', `${button.dataset.name} ditambahkan`);
                animateCartHeader();
                vibrateForAdd();
            });
        });

        unavailableButtons.forEach(button => {
            button.addEventListener('click', () => {
                window.toast.warning('Menu habis', `Maaf, ${button.dataset.name} sedang habis`);
            });
        });

        orderForm.addEventListener('submit', async function(event) {
            event.preventDefault();

            if (cart.size === 0) {
                warnEmptyCart();
                return;
            }

            if (!customerName.value.trim()) {
                showNameError();
                customerName.focus();
                return;
            }

            if (isSubmitting) {
                return;
            }

            const hiddenInputs = document.getElementById('cart-hidden-inputs');
            hiddenInputs.innerHTML = '';

            let index = 0;

            cart.forEach((item, id) => {
                const menuInput = document.createElement('input');
                menuInput.type = 'hidden';
                menuInput.name = `items[${index}][menu_id]`;
                menuInput.value = id;

                const quantityInput = document.createElement('input');
                quantityInput.type = 'hidden';
                quantityInput.name = `items[${index}][quantity]`;
                quantityInput.value = item.quantity;

                hiddenInputs.append(menuInput, quantityInput);

                index++;
            });

            isSubmitting = true;
            const originalButtonContent = submitButton.innerHTML;
            submitButton.disabled = true;
            submitButton.setAttribute('aria-busy', 'true');
            submitButton.innerHTML = '<span class="rb-button-spinner" aria-hidden="true"></span><span>Memproses...</span>';

            try {
                const response = await fetch(orderForm.action, {
                    method: 'POST',
                    body: new FormData(orderForm),
                    credentials: 'same-origin',
                    redirect: 'manual',
                    headers: {
                        'Accept': 'text/html',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });

                if (response.type === 'opaqueredirect' || (response.status >= 300 && response.status < 400)) {
                    window.location.assign(window.location.href);
                    return;
                }

                if (!response.ok) throw new Error(`Permintaan pesanan gagal (${response.status}).`);
                throw new Error('Respons pesanan tidak mengarahkan ke halaman hasil.');
            } catch (error) {
                console.error('Pesanan tidak berhasil dikirim.', error);
                isSubmitting = false;
                submitButton.disabled = false;
                submitButton.removeAttribute('aria-busy');
                submitButton.innerHTML = originalButtonContent;
                window.toast.error('Belum terkirim', 'Pesanan belum terkirim. Cek koneksi lalu coba lagi.');
            }
        });

        filterMenuCards();
        renderCart();
    </script>
    @endif

    <x-notification-system theme="customer" />
</body>

</html>