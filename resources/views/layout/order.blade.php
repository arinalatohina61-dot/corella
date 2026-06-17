@extends('layout.layouts')
@section('title', 'Заказ №' . $order->code)

@section('content')
    <div class="order-detail-page">
        <nav class="breadcrumbs">
            <div class="order-detail-container">
                <div class="order-detail-header">
                    <h1 class="order-detail-title">Заказ №{{ $order->code }}</h1>
                    <div class="order-actions">
                        <a href="{{ route('profile.order.print', $order->id) }}" target="_blank" class="order-action-btn">
                            <span class="btn-icon">🖨</span>
                            Распечатать
                        </a>
                    </div>
                </div>

                <div class="order-info-grid">
                    <!-- Основная информация -->
                    <div class="order-info-section">
                        <h2 class="section-title">Информация о заказе</h2>
                        <div class="info-cards">
                            <div class="info-card">
                                <div class="info-label">Дата оформления</div>
                                <div class="info-value">{{ \Carbon\Carbon::parse($order->created_at)->format('d.m.Y H:i') }}</div>
                            </div>

                            <div class="info-card">
                                <div class="info-label">Статус</div>
                                <div class="order-status {{ strtolower($order->status) }}">{{ ucfirst($order->status) }}</div>
                            </div>

                            <div class="info-card">
                                <div class="info-label">Итого</div>
                                <div class="info-value total-amount">{{ number_format($order->total_amount, 0, ',', ' ') }} ₽</div>
                            </div>
                        </div>
                    </div>

                    <!-- Товары в заказе -->
                    <div class="order-items-section">
                        <h2 class="section-title">Товары в заказе</h2>
                        <div class="order-items-list">
                            @foreach($order->orderDetails as $item)
                                <div class="order-item-card">
                                    <div class="item-info">
                                        <div class="item-name">{{ $item->product->name }}</div>
                                        <div class="item-details">
                                            <span class="item-quantity">{{ $item->quantity }} шт.</span>
                                            <span class="item-price">{{ number_format($item->price_at_order, 0, ',', ' ') }} ₽</span>
                                        </div>
                                    </div>
                                    <div class="item-total">
                                        {{ number_format($item->quantity * $item->price_at_order, 0, ',', ' ') }} ₽
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Итоговая сумма -->
                    <div class="order-summary-section">
                        <div class="summary-total">
                            <span class="total-label">Итого к оплате</span>
                            <span class="total-value">{{ number_format($order->total_amount, 0, ',', ' ') }} ₽</span>
                        </div>
                    </div>
                </div>

                <div class="back-to-orders">
                    <a href="{{ route('profile.orders') }}" class="back-link">
                        <span class="link-icon">←</span>
                        Вернуться к заказам
                    </a>
                </div>
            </div>
    </div>


@endsection

<style>
    .order-detail-page {
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

    .order-detail-container {
        max-width: 800px;
        margin: 0 auto;
    }

    .order-detail-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 50px;
        flex-wrap: wrap;
        gap: 20px;
    }

    .order-detail-title {
        font-size: 32px;
        font-weight: 400;
        margin: 0;
        letter-spacing: -0.5px;
        color: #000;
    }

    .order-actions {
        display: flex;
        gap: 15px;
    }

    .order-action-btn {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        padding: 12px 24px;
        border: 1px solid #ddd;
        background: #fff;
        color: #666;
        text-decoration: none;
        font-size: 14px;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 1px;
        transition: all 0.3s ease;
        white-space: nowrap;
    }

    .order-action-btn:hover {
        background: #f5f5f5;
        border-color: #666;
        color: #000;
    }

    .btn-icon {
        font-size: 16px;
    }

    .order-info-grid {
        display: flex;
        flex-direction: column;
        gap: 40px;
    }

    .section-title {
        font-size: 20px;
        font-weight: 500;
        margin: 0 0 25px 0;
        letter-spacing: -0.3px;
        padding-bottom: 15px;
        border-bottom: 1px solid #eaeaea;
    }

    /* Информация о заказе */
    .info-cards {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 20px;
    }

    .info-card {
        padding: 25px;
        border: 1px solid #eaeaea;
        background: #fff;
    }

    .info-label {
        font-size: 12px;
        font-weight: 500;
        color: #666;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: 8px;
    }

    .info-value {
        font-size: 18px;
        color: #000;
        font-weight: 400;
        line-height: 1.4;
        word-break: break-word;
    }

    .total-amount {
        font-size: 24px;
        font-weight: 500;
    }

    .order-status {
        display: inline-block;
        padding: 8px 20px;
        font-size: 14px;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 1px;
        border: 1px solid;
    }

    .order-status.new,
    .order-status.pending {
        background: #f5f5f5;
        border-color: #ddd;
        color: #666;
    }

    .order-status.processing {
        background: #e3f2fd;
        border-color: #bbdefb;
        color: #1976d2;
    }

    .order-status.shipped,
    .order-status.delivered {
        background: #e8f5e9;
        border-color: #c8e6c9;
        color: #388e3c;
    }

    .order-status.cancelled {
        background: #ffebee;
        border-color: #ffcdd2;
        color: #d32f2f;
    }

    /* Список товаров */
    .order-items-list {
        display: flex;
        flex-direction: column;
        gap: 15px;
    }

    .order-item-card {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 25px;
        border: 1px solid #eaeaea;
        background: #fff;
        gap: 20px;
    }

    .item-info {
        flex: 1;
    }

    .item-name {
        font-size: 18px;
        font-weight: 500;
        margin: 0 0 10px 0;
        color: #000;
        word-break: break-word;
    }

    .item-details {
        display: flex;
        gap: 20px;
        font-size: 14px;
        color: #666;
        flex-wrap: wrap;
    }

    .item-quantity {
        position: relative;
        padding-right: 20px;
    }

    .item-quantity::after {
        content: "×";
        position: absolute;
        right: 0;
        top: 0;
        color: #999;
    }

    .item-price {
        font-weight: 500;
    }

    .item-total {
        font-size: 20px;
        font-weight: 500;
        color: #000;
        min-width: 100px;
        text-align: right;
        white-space: nowrap;
    }

    /* Итоговая сумма */
    .order-summary-section {
        padding: 40px;
        border: 1px solid #eaeaea;
        background: #fafafa;
    }

    .summary-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 15px;
        font-size: 16px;
        color: #666;
    }

    .summary-total {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 25px;
        font-size: 20px;
        color: #000;
        gap: 15px;
        flex-wrap: wrap;
    }

    .total-label {
        font-weight: 500;
    }

    .total-value {
        font-weight: 500;
        white-space: nowrap;
    }

    /* Кнопка возврата */
    .back-to-orders {
        margin-top: 50px;
        padding-top: 30px;
        border-top: 1px solid #eaeaea;
        text-align: center;
    }

    .back-link {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        color: #000;
        text-decoration: none;
        font-size: 14px;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 1px;
        padding: 15px 30px;
        border: 1px solid #000;
        background: #fff;
        transition: all 0.3s ease;
    }

    .back-link:hover {
        background: #000;
        color: #fff;
    }

    .link-icon {
        font-size: 18px;
    }

    /* ===== АДАПТИВНОСТЬ ===== */

    /* Планшеты и небольшие десктопы */
    @media (max-width: 992px) {
        .order-detail-page {
            padding: 35px 20px;
        }

        .breadcrumbs {
            margin-bottom: 50px;
        }

        .order-detail-title {
            font-size: 28px;
        }

        .order-detail-header {
            margin-bottom: 40px;
        }

        .order-info-grid {
            gap: 35px;
        }

        .section-title {
            font-size: 18px;
            margin-bottom: 20px;
        }

        .info-cards {
            gap: 18px;
        }

        .info-card {
            padding: 22px;
        }

        .info-value {
            font-size: 16px;
        }

        .total-amount {
            font-size: 22px;
        }

        .order-item-card {
            padding: 22px;
        }

        .item-name {
            font-size: 16px;
        }

        .item-total {
            font-size: 18px;
        }

        .order-summary-section {
            padding: 35px;
        }

        .summary-total {
            font-size: 18px;
        }
    }

    /* Планшеты в портретной ориентации */
    @media (max-width: 768px) {
        .order-detail-page {
            padding: 25px 15px;
        }

        .breadcrumbs {
            margin-bottom: 35px;
            font-size: 13px;
        }

        .order-detail-title {
            font-size: 24px;
        }

        .order-detail-header {
            flex-direction: column;
            align-items: stretch;
            gap: 15px;
            margin-bottom: 35px;
        }

        .order-actions {
            width: 100%;
        }

        .order-action-btn {
            flex: 1;
            justify-content: center;
            padding: 11px 20px;
            font-size: 13px;
        }

        .order-info-grid {
            gap: 30px;
        }

        .section-title {
            font-size: 17px;
            margin-bottom: 18px;
            padding-bottom: 12px;
        }

        .info-cards {
            grid-template-columns: 1fr;
            gap: 15px;
        }

        .info-card {
            padding: 20px;
        }

        .info-label {
            font-size: 11px;
        }

        .info-value {
            font-size: 16px;
        }

        .total-amount {
            font-size: 20px;
        }

        .order-status {
            font-size: 13px;
            padding: 7px 18px;
        }

        .order-item-card {
            flex-direction: column;
            align-items: flex-start;
            gap: 15px;
            padding: 20px;
        }

        .item-name {
            font-size: 16px;
            margin-bottom: 8px;
        }

        .item-details {
            font-size: 13px;
            gap: 15px;
        }

        .item-total {
            text-align: left;
            min-width: auto;
            font-size: 18px;
        }

        .order-summary-section {
            padding: 30px 20px;
        }

        .summary-total {
            font-size: 17px;
            margin-top: 20px;
        }

        .back-to-orders {
            margin-top: 40px;
            padding-top: 25px;
        }

        .back-link {
            width: 100%;
            justify-content: center;
            padding: 13px 25px;
            font-size: 13px;
        }
    }

    /* Мобильные устройства */
    @media (max-width: 576px) {
        .order-detail-page {
            padding: 20px 12px;
        }

        .breadcrumbs {
            margin-bottom: 30px;
            font-size: 12px;
            gap: 6px;
        }

        .order-detail-title {
            font-size: 22px;
        }

        .order-detail-header {
            gap: 12px;
            margin-bottom: 30px;
        }

        .order-action-btn {
            padding: 10px 18px;
            font-size: 12px;
            letter-spacing: 0.8px;
        }

        .btn-icon {
            font-size: 14px;
        }

        .order-info-grid {
            gap: 25px;
        }

        .section-title {
            font-size: 16px;
            margin-bottom: 15px;
            padding-bottom: 10px;
        }

        .info-card {
            padding: 18px;
        }

        .info-label {
            font-size: 10px;
            letter-spacing: 0.8px;
            margin-bottom: 6px;
        }

        .info-value {
            font-size: 15px;
        }

        .total-amount {
            font-size: 18px;
        }

        .order-status {
            font-size: 12px;
            padding: 6px 15px;
            letter-spacing: 0.8px;
        }

        .order-items-list {
            gap: 12px;
        }

        .order-item-card {
            padding: 18px;
            gap: 12px;
        }

        .item-name {
            font-size: 15px;
            margin-bottom: 6px;
        }

        .item-details {
            font-size: 12px;
            gap: 12px;
        }

        .item-total {
            font-size: 17px;
        }

        .order-summary-section {
            padding: 25px 18px;
        }

        .summary-total {
            font-size: 16px;
            margin-top: 18px;
        }

        .back-to-orders {
            margin-top: 35px;
            padding-top: 20px;
        }

        .back-link {
            padding: 12px 20px;
            font-size: 12px;
            letter-spacing: 0.8px;
        }

        .link-icon {
            font-size: 16px;
        }
    }

    /* Маленькие мобильные устройства */
    @media (max-width: 480px) {
        .order-detail-page {
            padding: 18px 10px;
        }

        .breadcrumbs {
            margin-bottom: 25px;
            font-size: 11px;
        }

        .order-detail-title {
            font-size: 20px;
        }

        .order-detail-header {
            margin-bottom: 25px;
        }

        .order-action-btn {
            padding: 9px 15px;
            font-size: 11px;
        }

        .btn-icon {
            font-size: 13px;
        }

        .order-info-grid {
            gap: 22px;
        }

        .section-title {
            font-size: 15px;
            margin-bottom: 12px;
        }

        .info-card {
            padding: 15px;
        }

        .info-label {
            font-size: 9px;
            margin-bottom: 5px;
        }

        .info-value {
            font-size: 14px;
        }

        .total-amount {
            font-size: 17px;
        }

        .order-status {
            font-size: 11px;
            padding: 5px 12px;
        }

        .order-item-card {
            padding: 15px;
        }

        .item-name {
            font-size: 14px;
        }

        .item-details {
            font-size: 11px;
        }

        .item-total {
            font-size: 16px;
        }

        .order-summary-section {
            padding: 22px 15px;
        }

        .summary-total {
            font-size: 15px;
        }

        .back-link {
            padding: 11px 18px;
            font-size: 11px;
        }

        .link-icon {
            font-size: 15px;
        }
    }

    /* Очень маленькие экраны */
    @media (max-width: 360px) {
        .order-detail-page {
            padding: 15px 8px;
        }

        .order-detail-title {
            font-size: 18px;
        }

        .order-action-btn {
            padding: 8px 12px;
            font-size: 10px;
        }

        .info-card {
            padding: 12px;
        }

        .info-value {
            font-size: 13px;
        }

        .order-item-card {
            padding: 12px;
        }

        .item-name {
            font-size: 13px;
        }

        .item-details {
            font-size: 10px;
        }

        .order-summary-section {
            padding: 18px 12px;
        }

        .summary-total {
            font-size: 14px;
        }
    }
</style>
