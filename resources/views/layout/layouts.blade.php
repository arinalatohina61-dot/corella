<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="icon" href="{{ asset('image/logo.jpg') }}">
    <style>
        /* Стили для слайдера */
        .slider-section {
            padding: 40px 0;
        }

        .slider-container {
            max-width: 1400px;
            margin: 0 auto;
            position: relative;
            overflow: hidden;
            border-radius: 12px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.5);
        }

        .slider-wrapper {
            display: flex;
            transition: transform 0.5s cubic-bezier(0.4, 0, 0.2, 1);
            height: 700px;
            width: 100%;
        }

        .slider-slide {
            flex: 0 0 100%;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            width: 100%;
        }

        .slide-image {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            filter: grayscale(100%) brightness(0.7);
            transition: filter 1s ease;
        }

        .slider-slide.active .slide-image {
            filter: grayscale(0%) brightness(0.9);
        }

        .slide-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(
                135deg,
                rgba(0,0,0,0.8) 0%,
                rgba(0,0,0,0.4) 50%,
                rgba(0,0,0,0.8) 100%
            );
            z-index: 1;
            opacity: 0.9;
        }

        .slide-content {
            position: relative;
            z-index: 3;
            text-align: center;
            color: #fff;
            padding: 0 40px;
            max-width: 800px;
            text-shadow: 0 2px 10px rgba(0,0,0,0.5);
            width: 100%;
            box-sizing: border-box;
        }

        .slide-title {
            font-size: 56px;
            font-weight: 300;
            margin-bottom: 25px;
            letter-spacing: 3px;
            text-transform: uppercase;
            line-height: 1.2;
        }

        .slide-subtitle {
            font-size: 20px;
            color: #ddd;
            margin-bottom: 40px;
            line-height: 1.8;
            font-weight: 300;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }

        .slide-button {
            display: inline-block;
            padding: 18px 48px;
            background: transparent;
            color: #fff;
            border: 1px solid rgba(255,255,255,0.8);
            text-decoration: none;
            font-size: 14px;
            letter-spacing: 2px;
            text-transform: uppercase;
            transition: all 0.4s ease;
            position: relative;
            overflow: hidden;
            backdrop-filter: blur(10px);
            background: rgba(255,255,255,0.05);
        }

        .slide-button:before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.7s ease;
            z-index: -1;
        }

        .slide-button:hover {
            color: #000;
            background: #fff;
            border-color: #fff;
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(255,255,255,0.1);
        }

        .slide-button:hover:before {
            left: 100%;
        }

        .slider-controls {
            position: absolute;
            top: 50%;
            width: 100%;
            display: flex;
            justify-content: space-between;
            padding: 0 40px;
            transform: translateY(-50%);
            z-index: 4;
        }

        .slider-btn {
            width: 60px;
            height: 60px;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.15);
            color: #fff;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
            backdrop-filter: blur(20px);
            font-size: 18px;
        }

        .slider-btn:hover {
            background: rgba(255, 255, 255, 0.15);
            transform: scale(1.15);
            border-color: rgba(255,255,255,0.3);
            box-shadow: 0 5px 20px rgba(255,255,255,0.1);
        }

        .slider-dots {
            position: absolute;
            bottom: 40px;
            left: 0;
            width: 100%;
            display: flex;
            justify-content: center;
            gap: 16px;
            z-index: 4;
        }

        .slider-dot {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.3);
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .slider-dot:before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: #fff;
            transition: left 0.3s ease;
        }

        .slider-dot.active {
            border-color: #fff;
            transform: scale(1.3);
        }

        .slider-dot.active:before {
            left: 0;
        }

        .slide-number {
            position: absolute;
            bottom: 40px;
            right: 50px;
            color: #fff;
            font-size: 14px;
            letter-spacing: 3px;
            z-index: 4;
            opacity: 0.5;
            font-weight: 300;
        }

        /* Анимация появления */
        .slide-content {
            opacity: 0;
            transform: translateY(40px);
            transition: all 0.8s ease 0.3s;
        }

        .slider-slide.active .slide-content {
            opacity: 1;
            transform: translateY(0);
        }

        .slide-title {
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.8s ease 0.5s;
        }

        .slider-slide.active .slide-title {
            opacity: 1;
            transform: translateY(0);
        }

        .slide-subtitle {
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.8s ease 0.7s;
        }

        .slider-slide.active .slide-subtitle {
            opacity: 1;
            transform: translateY(0);
        }

        .slide-button {
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.8s ease 0.9s;
        }

        .slider-slide.active .slide-button {
            opacity: 1;
            transform: translateY(0);
        }

        /* Декоративные элементы */
        .slide-line {
            position: absolute;
            width: 1px;
            height: 0;
            background: rgba(255, 255, 255, 0.1);
            top: 0;
            transition: height 1.2s ease 0.5s;
            z-index: 2;
        }

        .slider-slide.active .slide-line {
            height: 100%;
        }

        .slide-line.left {
            left: 20%;
        }

        .slide-line.right {
            right: 20%;
        }

        .slide-corner {
            position: absolute;
            width: 60px;
            height: 60px;
            z-index: 2;
        }

        .corner-tl {
            top: 30px;
            left: 30px;
            border-top: 1px solid rgba(255,255,255,0.2);
            border-left: 1px solid rgba(255,255,255,0.2);
        }

        .corner-tr {
            top: 30px;
            right: 30px;
            border-top: 1px solid rgba(255,255,255,0.2);
            border-right: 1px solid rgba(255,255,255,0.2);
        }

        .corner-bl {
            bottom: 30px;
            left: 30px;
            border-bottom: 1px solid rgba(255,255,255,0.2);
            border-left: 1px solid rgba(255,255,255,0.2);
        }

        .corner-br {
            bottom: 30px;
            right: 30px;
            border-bottom: 1px solid rgba(255,255,255,0.2);
            border-right: 1px solid rgba(255,255,255,0.2);
        }

        /* ===== АДАПТИВНОСТЬ СЛАЙДЕРА ===== */
        @media (max-width: 1200px) {
            .slider-wrapper {
                height: 600px;
            }

            .slide-title {
                font-size: 48px;
            }
        }

        @media (max-width: 992px) {
            .slider-wrapper {
                height: 550px;
            }

            .slide-title {
                font-size: 42px;
                letter-spacing: 2px;
            }

            .slide-subtitle {
                font-size: 18px;
                margin-bottom: 35px;
            }

            .slide-button {
                padding: 16px 40px;
            }

            .slider-btn {
                width: 55px;
                height: 55px;
            }

            .slide-corner {
                width: 50px;
                height: 50px;
            }
        }

        @media (max-width: 768px) {
            .slider-section {
                padding: 20px 0;
            }

            .slider-wrapper {
                height: 500px;
            }

            .slide-title {
                font-size: 36px;
                letter-spacing: 2px;
                margin-bottom: 20px;
            }

            .slide-subtitle {
                font-size: 16px;
                margin-bottom: 30px;
                line-height: 1.6;
            }

            .slide-button {
                padding: 15px 35px;
                font-size: 13px;
                letter-spacing: 1.5px;
            }

            .slider-btn {
                width: 50px;
                height: 50px;
                font-size: 16px;
            }

            .slider-controls {
                padding: 0 25px;
            }

            .slide-corner {
                width: 40px;
                height: 40px;
            }

            .corner-tl, .corner-tr, .corner-bl, .corner-br {
                top: 20px;
                right: 20px;
                left: 20px;
                bottom: 20px;
            }

            .slider-dots {
                bottom: 30px;
                gap: 12px;
            }

            .slider-dot {
                width: 10px;
                height: 10px;
            }

            .slide-number {
                bottom: 30px;
                right: 30px;
                font-size: 12px;
            }
        }

        @media (max-width: 576px) {
            .slider-wrapper {
                height: 450px;
            }

            .slide-content {
                padding: 0 25px;
            }

            .slide-title {
                font-size: 32px;
                margin-bottom: 18px;
            }

            .slide-subtitle {
                font-size: 15px;
                margin-bottom: 25px;
            }

            .slide-button {
                padding: 14px 30px;
                font-size: 12px;
            }

            .slider-btn {
                width: 45px;
                height: 45px;
                font-size: 14px;
            }

            .slider-controls {
                padding: 0 20px;
            }

            .slide-corner {
                width: 35px;
                height: 35px;
            }

            .corner-tl, .corner-tr, .corner-bl, .corner-br {
                top: 15px;
                right: 15px;
                left: 15px;
                bottom: 15px;
            }

            .slider-dots {
                bottom: 25px;
                gap: 10px;
            }

            .slider-dot {
                width: 9px;
                height: 9px;
            }

            .slide-number {
                bottom: 25px;
                right: 25px;
                font-size: 11px;
            }
        }

        @media (max-width: 480px) {
            .slider-wrapper {
                height: 400px;
            }

            .slide-title {
                font-size: 28px;
                letter-spacing: 1.5px;
                margin-bottom: 15px;
            }

            .slide-subtitle {
                font-size: 14px;
                margin-bottom: 22px;
                line-height: 1.5;
            }

            .slide-button {
                padding: 13px 28px;
                font-size: 11px;
                letter-spacing: 1px;
            }

            .slider-btn {
                width: 40px;
                height: 40px;
                font-size: 13px;
            }

            .slider-controls {
                padding: 0 15px;
            }

            .slide-corner {
                width: 30px;
                height: 30px;
            }

            .corner-tl, .corner-tr, .corner-bl, .corner-br {
                top: 12px;
                right: 12px;
                left: 12px;
                bottom: 12px;
            }

            .slider-dots {
                bottom: 20px;
                gap: 8px;
            }

            .slider-dot {
                width: 8px;
                height: 8px;
            }

            .slide-number {
                bottom: 20px;
                right: 20px;
                font-size: 10px;
                letter-spacing: 2px;
            }
        }

        @media (max-width: 360px) {
            .slider-wrapper {
                height: 380px;
            }

            .slide-title {
                font-size: 24px;
            }

            .slide-subtitle {
                font-size: 13px;
            }

            .slide-button {
                padding: 12px 25px;
                font-size: 10px;
            }
        }

        /* ===== АДАПТИВНОСТЬ HEADER ===== */
        @media (max-width: 992px) {
            .header-container {
                padding: 0 15px;
            }

            .nav-links a {
                font-size: 13px;
            }

            .logo {
                font-size: 24px;
            }

            .header-icons {
                gap: 15px;
            }

            .header-icon {
                font-size: 18px;
            }
        }

        @media (max-width: 768px) {
            .header {
                padding: 15px 0;
            }

            .header-container {
                flex-wrap: wrap;
                gap: 10px;
            }

            .nav-left {
                order: 2;
                flex: 1;
            }

            .logo {
                order: 1;
                flex: 0 0 auto;
                font-size: 22px;
            }

            .nav-right {
                order: 3;
                flex: 0 0 auto;
            }

            .nav-links a {
                font-size: 12px;
                letter-spacing: 1px;
            }

            .header-icons {
                gap: 12px;
            }

            .header-icon {
                font-size: 16px;
            }

            .cart-count {
                font-size: 10px;
                min-width: 16px;
                height: 16px;
            }
        }

        @media (max-width: 576px) {
            .header {
                padding: 12px 0;
            }

            .header-container {
                padding: 0 12px;
            }

            .logo {
                font-size: 20px;
            }

            .nav-left {
                display: none;
            }

            .nav-right {
                margin-left: auto;
            }

            .header-icons {
                gap: 10px;
            }

            .header-icon {
                font-size: 15px;
            }
        }

        @media (max-width: 480px) {
            .logo {
                font-size: 18px;
            }

            .header-icon {
                font-size: 14px;
            }

            .cart-count {
                font-size: 9px;
                min-width: 14px;
                height: 14px;
            }
        }

        /* ===== АДАПТИВНОСТЬ BREADCRUMBS ===== */
        @media (max-width: 768px) {
            .breadcrumbs {
                font-size: 12px;
                padding: 12px 0;
            }

            .breadcrumbs a,
            .breadcrumbs .current {
                font-size: 12px;
            }

            .separator {
                margin: 0 6px;
            }
        }

        @media (max-width: 576px) {
            .breadcrumbs {
                font-size: 11px;
                padding: 10px 0;
                overflow-x: auto;
                white-space: nowrap;
                -webkit-overflow-scrolling: touch;
                scrollbar-width: none;
            }

            .breadcrumbs::-webkit-scrollbar {
                display: none;
            }

            .breadcrumbs a,
            .breadcrumbs .current {
                font-size: 11px;
            }

            .separator {
                margin: 0 5px;
            }
        }

        @media (max-width: 480px) {
            .breadcrumbs {
                font-size: 10px;
            }

            .breadcrumbs a,
            .breadcrumbs .current {
                font-size: 10px;
            }
        }

        /* ===== АДАПТИВНОСТЬ FOOTER ===== */
        @media (max-width: 992px) {
            .footer-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 30px;
            }

            .footer-logo {
                font-size: 20px;
            }

            .footer-title {
                font-size: 14px;
            }

            .footer-list li a {
                font-size: 13px;
            }
        }

        @media (max-width: 768px) {
            .site-footer {
                padding: 40px 0 30px;
            }

            .footer-grid {
                grid-template-columns: 1fr;
                gap: 25px;
                text-align: center;
            }

            .footer-logo {
                font-size: 18px;
                margin-bottom: 10px;
            }

            .footer-title {
                font-size: 13px;
                margin-bottom: 12px;
            }

            .footer-list li {
                margin-bottom: 8px;
            }

            .footer-list li a {
                font-size: 12px;
            }
        }

        @media (max-width: 576px) {
            .site-footer {
                padding: 35px 0 25px;
            }

            .footer-grid {
                gap: 20px;
            }

            .footer-logo {
                font-size: 16px;
            }

            .footer-title {
                font-size: 12px;
                margin-bottom: 10px;
            }

            .footer-list li {
                margin-bottom: 6px;
            }

            .footer-list li a {
                font-size: 11px;
            }
        }

        @media (max-width: 480px) {
            .site-footer {
                padding: 30px 0 20px;
            }

            .footer-logo {
                font-size: 15px;
            }

            .footer-title {
                font-size: 11px;
            }

            .footer-list li a {
                font-size: 10px;
            }
        }
    </style>
</head>
<body>
<header class="header">
    <div class="container header-container">
        <nav class="nav-left nav-links">
            <a href="/list">каталог</a>
        </nav>

        <a href="/" class="logo">корелла</a>

        <nav class="nav-right nav-links">

            <div class="header-icons">
                @if(auth('client')->check())
                    <a href="/profile" class="header-icon" title="Профиль">
                        <i class="far fa-user"></i>
                    </a>
                @else
                    <a href="/login" class="header-icon" title="Профиль">
                        <i class="far fa-user"></i>
                    </a>
                @endif

                <a href="{{ route('cart.index') }}" class="header-icon cart-icon" title="Корзина">
                    <i class="fas fa-shopping-bag"></i>
                    <span class="cart-count">
                        {{ array_sum(array_column(session('cart', []), 'quantity')) }}
                    </span>
                </a>

                <a href="/logout">
                    <i class="fas fa-sign-out-alt"></i>
                </a>
            </div>
        </nav>
    </div>
</header>

<div class="container">
    <div class="breadcrumbs">
        @if(request()->is('/'))
            <span class="current">Главная</span>
        @else
            <a href="/">Главная</a>

            @if(request()->is('list*'))
                <span class="separator">/</span>
                <span class="current">Каталог</span>
            @elseif(request()->is('products/*'))
                <span class="separator">/</span>
                <a href="/list">Каталог</a>
                <span class="separator">/</span>
                <span class="current">{{ $product->name ?? 'Товар' }}</span>
            @elseif(request()->is('cart*'))
                <span class="separator">/</span>
                <a href="/list">Каталог</a>
                <span class="separator">/</span>
                <span class="current">Корзина</span>
            @elseif(request()->is('profile/*'))
                <span class="separator">/</span>
                <span class="current">Профиль</span>
            @elseif(request()->is('login*'))
                <span class="separator">/</span>
                <span class="current">Вход</span>
            @elseif(request()->is('register*'))
                <span class="separator">/</span>
                <span class="current">Регистрация</span>
            @else
                <span class="separator">/</span>
                <span class="current">@yield('title', 'Страница')</span>
            @endif
        @endif
    </div>
</div>

@if(request()->is('/'))
    @include('paginations.slider')
@endif


<div class="content">
    @yield('content')
</div>

<footer class="site-footer">
    <div class="container">
        <div class="footer-grid">
            <div class="footer-column">
                <div class="footer-logo">CORELLA NATURALE</div>
            </div>

            <div class="footer-column">
                <h4 class="footer-title">Каталог</h4>
                <ul class="footer-list">
                    <li><a href="#">Декоративно-лиственные</a></li>
                    <li><a href="#">Декоративно-цветущие</a></li>
                    <li><a href="#">Кактусы</a></li>
                    <li><a href="#">Суккуленты</a></li>
                </ul>
            </div>

            <div class="footer-column">
                <h4 class="footer-title">Сервис</h4>
                <ul class="footer-list">
                    <li><a href="#">Гарантия</a></li>
                    <li><a href="#">Рекомендации по уходу</a></li>
                </ul>
            </div>

            <div class="footer-column">
                <h4 class="footer-title">Сотрудникам</h4>
                <ul class="footer-list">
                    <li><a href="/staff/login">войти</a></li>
                </ul>
            </div>
        </div>
    </div>
</footer>


</body>
</html>
