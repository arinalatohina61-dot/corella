@extends('layout.layouts')
@section('title', 'Заказ оформлен')

@section('content')
    <div class="order-confirmation">
        <div class="confirmation-container">
            <!-- Иконка успеха -->
            <div class="confirmation-icon">
                <svg width="64" height="64" viewBox="0 0 64 64" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <circle cx="32" cy="32" r="32" fill="#000"/>
                    <path d="M20 32L28 40L44 24" stroke="white" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </div>

            <h1 class="confirmation-title">ЗАКАЗ ОФОРМЛЕН</h1>

            <p class="confirmation-subtitle">Спасибо за ваш заказ! В ближайшее время с вами свяжется наш менеджер для подтверждения деталей.</p>

            <div class="order-details">
                <div class="order-number">
                    <span class="order-number-label">Номер заказа</span>
                    <span class="order-number-value">{{ $order->code }}</span>
                </div>
            </div>

            <div class="confirmation-actions">
                <a href="{{ route('products.index') }}" class="btn-continue-shopping">
                    <span class="btn-arrow">←</span>
                    ВЕРНУТЬСЯ В КАТАЛОГ
                </a>
            </div>
        </div>
    </div>
@endsection

<style>
    /* Базовые стили */
    .order-confirmation {
        max-width: 1200px;
        margin: 0 auto;
        padding: 40px 20px;
        font-family: 'Helvetica Neue', Arial, sans-serif;
        color: #000;
        background: #fff;
        min-height: 70vh;
        display: flex;
        flex-direction: column;
    }

    /* Хлебные крошки */
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

    /* Основной контейнер */
    .confirmation-container {
        max-width: 800px;
        margin: 0 auto;
        text-align: center;
        flex: 1;
    }

    /* Иконка успеха */
    .confirmation-icon {
        margin-bottom: 30px;
    }

    .confirmation-icon svg {
        animation: scaleIn 0.5s ease-out;
    }

    @keyframes scaleIn {
        from {
            transform: scale(0);
            opacity: 0;
        }
        to {
            transform: scale(1);
            opacity: 1;
        }
    }

    /* Заголовки */
    .confirmation-title {
        font-size: 40px;
        font-weight: 400;
        margin: 0 0 20px 0;
        letter-spacing: -1px;
        line-height: 1.2;
    }

    .confirmation-subtitle {
        font-size: 18px;
        color: #666;
        line-height: 1.6;
        margin: 0 auto 50px;
        max-width: 600px;
    }

    /* Номер заказа */
    .order-number {
        display: inline-flex;
        flex-direction: column;
        gap: 10px;
        margin-bottom: 50px;
        padding: 25px 40px;
        border: 1px solid #eaeaea;
        background: #fafafa;
    }

    .order-number-label {
        font-size: 14px;
        font-weight: 500;
        color: #666;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .order-number-value {
        font-size: 28px;
        font-weight: 500;
        letter-spacing: 2px;
        font-family: 'Courier New', monospace;
    }

    /* Карточки информации */
    .order-info-cards {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 20px;
        margin-bottom: 60px;
    }

    @media (max-width: 768px) {
        .order-info-cards {
            grid-template-columns: 1fr;
            gap: 15px;
        }
    }

    .info-card {
        padding: 30px 25px;
        border: 1px solid #eaeaea;
        background: #fff;
        text-align: center;
        transition: transform 0.3s ease;
    }

    .info-card:hover {
        transform: translateY(-5px);
    }

    .info-icon {
        font-size: 32px;
        margin-bottom: 20px;
        display: block;
    }

    .info-content h3 {
        font-size: 16px;
        font-weight: 500;
        margin: 0 0 10px 0;
        letter-spacing: -0.3px;
    }

    .info-content p {
        font-size: 14px;
        color: #666;
        line-height: 1.5;
        margin: 0;
    }

    /* Кнопки действий */
    .confirmation-actions {
        display: flex;
        justify-content: center;
        gap: 20px;
        margin-bottom: 80px;
        flex-wrap: wrap;
    }

    .btn-continue-shopping {
        padding: 15px 30px;
        background: transparent;
        color: #000;
        text-decoration: none;
        border: 1px solid #000;
        font-size: 14px;
        text-transform: uppercase;
        letter-spacing: 1px;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 10px;
        font-weight: 500;
    }

    .btn-continue-shopping:hover {
        background: #000;
        color: #fff;
    }

    .btn-arrow {
        font-size: 18px;
    }

    .btn-track-order {
        padding: 15px 40px;
        background: #000;
        color: #fff;
        text-decoration: none;
        border: 1px solid #000;
        font-size: 14px;
        text-transform: uppercase;
        letter-spacing: 1px;
        transition: all 0.3s ease;
        font-weight: 500;
    }

    .btn-track-order:hover {
        background: #333;
        border-color: #333;
    }

    /* Что дальше? */
    .whats-next {
        margin-bottom: 60px;
        padding-top: 60px;
        border-top: 1px solid #eaeaea;
    }

    .whats-next-title {
        font-size: 24px;
        font-weight: 400;
        margin: 0 0 40px 0;
        text-align: center;
        letter-spacing: -0.5px;
    }

    .timeline {
        max-width: 600px;
        margin: 0 auto;
    }

    .timeline-step {
        display: flex;
        align-items: flex-start;
        gap: 25px;
        margin-bottom: 40px;
        position: relative;
    }

    .timeline-step:not(:last-child)::after {
        content: '';
        position: absolute;
        left: 32px;
        top: 60px;
        bottom: -40px;
        width: 1px;
        background: #eaeaea;
    }

    .step-number {
        width: 64px;
        height: 64px;
        border: 1px solid #000;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        font-weight: 500;
        flex-shrink: 0;
        position: relative;
        z-index: 1;
        background: #fff;
    }

    .step-content {
        text-align: left;
        padding-top: 10px;
    }

    .step-content h3 {
        font-size: 18px;
        font-weight: 500;
        margin: 0 0 10px 0;
        letter-spacing: -0.3px;
    }

    .step-content p {
        font-size: 15px;
        color: #666;
        line-height: 1.6;
        margin: 0;
    }

    /* Контакты поддержки */
    .contact-support {
        margin-top: 60px;
        padding-top: 40px;
        border-top: 1px solid #eaeaea;
        text-align: center;
    }

    .contact-support p {
        font-size: 16px;
        color: #666;
        margin: 0 0 20px 0;
    }

    .contact-methods {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 20px;
        flex-wrap: wrap;
    }

    .contact-link {
        color: #000;
        text-decoration: none;
        font-size: 18px;
        font-weight: 500;
        transition: color 0.3s ease;
    }

    .contact-link:hover {
        color: #666;
    }

    .contact-separator {
        color: #ccc;
        font-size: 24px;
    }

    /* Мобильная адаптация */
    @media (max-width: 768px) {
        .order-confirmation {
            padding: 20px 15px;
        }

        .breadcrumbs {
            margin-bottom: 30px;
        }

        .confirmation-title {
            font-size: 28px;
        }

        .confirmation-subtitle {
            font-size: 16px;
            margin-bottom: 30px;
        }

        .order-number {
            padding: 20px;
        }

        .order-number-value {
            font-size: 22px;
        }

        .confirmation-actions {
            flex-direction: column;
            align-items: stretch;
            gap: 15px;
        }

        .btn-continue-shopping,
        .btn-track-order {
            width: 100%;
            text-align: center;
            justify-content: center;
        }

        .timeline-step {
            flex-direction: column;
            align-items: center;
            text-align: center;
            gap: 15px;
        }

        .timeline-step:not(:last-child)::after {
            left: 50%;
            top: 64px;
            bottom: -40px;
            transform: translateX(-50%);
        }

        .step-content {
            text-align: center;
            padding-top: 0;
        }

        .contact-methods {
            flex-direction: column;
            gap: 10px;
        }

        .contact-separator {
            display: none;
        }
    }
</style>
