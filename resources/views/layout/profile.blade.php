@extends('layout.layouts')
@section('title', 'Профиль')

@section('content')
    <div class="profile-page">
        <div class="profile-container">
            <div class="profile-card">
                <div class="profile-header">
                    <h1 class="profile-title">Профиль</h1>
                </div>

                @if(session('success'))
                    <div class="profile-alert success">
                        <div class="alert-icon">✓</div>
                        <div class="alert-text">{{ session('success') }}</div>
                    </div>
                @endif

                @if(session('error'))
                    <div class="profile-alert error">
                        <div class="alert-icon">!</div>
                        <div class="alert-text">{{ session('error') }}</div>
                    </div>
                @endif

                <div class="profile-info">
                    <div class="info-item">
                        <div class="info-label">Имя</div>
                        <div class="info-value">{{ $user->name }}</div>
                    </div>

                    <div class="info-item">
                        <div class="info-label">Фамилия</div>
                        <div class="info-value">{{ $user->surname }}</div>
                    </div>

                    <div class="info-item">
                        <div class="info-label">Email</div>
                        <div class="info-value">{{ $user->email }}</div>
                    </div>

                    <div class="info-item">
                        <div class="info-label">Телефон</div>
                        <div class="info-value">{{ $user->phone }}</div>
                    </div>

                    <div class="info-item">
                        <div class="info-label">Мои заказы</div>
                        <div class="info-action">
                            <a href="{{ route('profile.orders') }}" class="orders-link">
                                <span class="link-text">Перейти к заказам</span>
                                <span class="link-arrow">→</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

<style>
    .profile-page {
        max-width: 1200px;
        margin: 0 auto;
        padding: 40px 20px;
        font-family: 'Helvetica Neue', Arial, sans-serif;
        color: #000;
        background: #fff;
        min-height: 70vh;
    }

    .breadcrumbs {
        margin-bottom: 60px;
        font-size: 14px;
        color: #666;
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 8px;
    }

    .breadcrumb-link {
        color: #666;
        text-decoration: none;
        transition: color 0.3s ease;
    }

    .breadcrumb-link:hover {
        color: #000;
    }

    .breadcrumb-separator {
        color: #999;
        margin: 0 5px;
    }

    .breadcrumb-current {
        color: #000;
        font-weight: 500;
    }

    .profile-container {
        max-width: 600px;
        margin: 0 auto;
    }

    .profile-card {
        border: 1px solid #eaeaea;
        background: #fff;
        padding: 50px;
    }

    .profile-header {
        margin-bottom: 50px;
        text-align: center;
    }

    .profile-title {
        font-size: 32px;
        font-weight: 400;
        margin: 0;
        letter-spacing: -0.5px;
        color: #000;
    }

    .profile-alert {
        display: flex;
        align-items: center;
        gap: 15px;
        padding: 20px;
        margin-bottom: 40px;
        border: 1px solid;
        background: #fafafa;
    }

    .profile-alert.success {
        border-color: #000;
        color: #000;
    }

    .profile-alert.error {
        border-color: #dc3545;
        color: #721c24;
    }

    .alert-icon {
        font-size: 20px;
        font-weight: bold;
        width: 24px;
        text-align: center;
        flex-shrink: 0;
    }

    .alert-text {
        font-size: 16px;
        line-height: 1.4;
    }

    .profile-info {
        display: flex;
        flex-direction: column;
        gap: 30px;
    }

    .info-item {
        display: flex;
        flex-direction: column;
        gap: 10px;
        padding-bottom: 30px;
        border-bottom: 1px solid #f5f5f5;
    }

    .info-item:last-child {
        border-bottom: none;
        padding-bottom: 0;
    }

    .info-label {
        font-size: 12px;
        font-weight: 500;
        color: #666;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .info-value {
        font-size: 18px;
        color: #000;
        font-weight: 400;
        line-height: 1.4;
        word-break: break-word;
    }

    .info-action {
        margin-top: 5px;
    }

    .orders-link {
        display: inline-flex;
        align-items: center;
        gap: 12px;
        color: #000;
        text-decoration: none;
        font-size: 16px;
        font-weight: 500;
        padding: 12px 20px;
        border: 1px solid #000;
        background: #fff;
        transition: all 0.3s ease;
    }

    .orders-link:hover {
        background: #000;
        color: #fff;
    }

    .link-arrow {
        font-size: 18px;
        transition: transform 0.3s ease;
    }

    .orders-link:hover .link-arrow {
        transform: translateX(5px);
    }

    /* ===== АДАПТИВНОСТЬ ===== */

    /* Планшеты и небольшие десктопы */
    @media (max-width: 992px) {
        .profile-page {
            padding: 35px 20px;
        }

        .profile-card {
            padding: 40px;
        }

        .profile-header {
            margin-bottom: 40px;
        }

        .profile-title {
            font-size: 28px;
        }

        .profile-alert {
            padding: 18px;
            margin-bottom: 35px;
        }

        .alert-text {
            font-size: 15px;
        }

        .profile-info {
            gap: 25px;
        }

        .info-item {
            padding-bottom: 25px;
        }

        .info-value {
            font-size: 17px;
        }

        .orders-link {
            font-size: 15px;
            padding: 11px 18px;
        }
    }

    /* Планшеты в портретной ориентации */
    @media (max-width: 768px) {
        .profile-page {
            padding: 25px 15px;
        }

        .breadcrumbs {
            margin-bottom: 30px;
        }

        .profile-card {
            padding: 30px 20px;
        }

        .profile-header {
            margin-bottom: 35px;
        }

        .profile-title {
            font-size: 24px;
        }

        .profile-alert {
            flex-direction: column;
            text-align: center;
            gap: 10px;
            padding: 15px;
            margin-bottom: 30px;
        }

        .alert-icon {
            font-size: 18px;
        }

        .alert-text {
            font-size: 14px;
        }

        .profile-info {
            gap: 22px;
        }

        .info-item {
            gap: 8px;
            padding-bottom: 22px;
        }

        .info-label {
            font-size: 11px;
        }

        .info-value {
            font-size: 16px;
        }

        .orders-link {
            width: 100%;
            justify-content: space-between;
            font-size: 14px;
            padding: 12px 18px;
        }
    }

    /* Мобильные устройства */
    @media (max-width: 576px) {
        .profile-page {
            padding: 20px 12px;
        }

        .profile-card {
            padding: 25px 18px;
        }

        .profile-header {
            margin-bottom: 30px;
        }

        .profile-title {
            font-size: 22px;
        }

        .profile-alert {
            padding: 14px;
            margin-bottom: 25px;
            gap: 8px;
        }

        .alert-icon {
            font-size: 16px;
            width: 20px;
        }

        .alert-text {
            font-size: 13px;
        }

        .profile-info {
            gap: 20px;
        }

        .info-item {
            gap: 6px;
            padding-bottom: 20px;
        }

        .info-label {
            font-size: 10px;
            letter-spacing: 0.8px;
        }

        .info-value {
            font-size: 15px;
        }

        .orders-link {
            padding: 11px 16px;
            font-size: 13px;
            gap: 10px;
        }

        .link-arrow {
            font-size: 16px;
        }
    }

    /* Маленькие мобильные устройства */
    @media (max-width: 480px) {
        .profile-page {
            padding: 18px 10px;
        }

        .profile-card {
            padding: 22px 15px;
        }

        .profile-header {
            margin-bottom: 25px;
        }

        .profile-title {
            font-size: 20px;
        }

        .profile-alert {
            padding: 12px;
            margin-bottom: 22px;
        }

        .alert-icon {
            font-size: 15px;
        }

        .alert-text {
            font-size: 12px;
        }

        .profile-info {
            gap: 18px;
        }

        .info-item {
            gap: 5px;
            padding-bottom: 18px;
        }

        .info-label {
            font-size: 9px;
        }

        .info-value {
            font-size: 14px;
        }

        .orders-link {
            padding: 10px 14px;
            font-size: 12px;
            letter-spacing: 0.5px;
        }

        .link-arrow {
            font-size: 15px;
        }
    }

    /* Очень маленькие экраны */
    @media (max-width: 360px) {
        .profile-page {
            padding: 15px 8px;
        }

        .profile-card {
            padding: 18px 12px;
        }

        .profile-title {
            font-size: 18px;
        }

        .profile-alert {
            padding: 10px;
            margin-bottom: 18px;
        }

        .alert-icon {
            font-size: 14px;
        }

        .alert-text {
            font-size: 11px;
        }

        .profile-info {
            gap: 15px;
        }

        .info-item {
            padding-bottom: 15px;
        }

        .info-value {
            font-size: 13px;
        }

        .orders-link {
            padding: 9px 12px;
            font-size: 11px;
        }
    }
</style>
