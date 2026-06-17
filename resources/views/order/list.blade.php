@extends('layout.layouts')
@section('title', 'Мои заказы')

@section('content')
    <div class="orders-page">
        <div class="orders-container">
            <div class="orders-header">
                <h1 class="orders-title">Мои заказы</h1>
            </div>

            @if($orders->count() > 0)
                <div class="orders-list">
                    @foreach($orders as $order)
                        <div class="order-card">
                            <div class="order-card-header">
                                <div class="order-number">Заказ №{{ $order->code }}</div>
                                <div class="order-date">{{ \Carbon\Carbon::parse($order->created_at)->format('d.m.Y H:i') }}</div>
                            </div>

                            <div class="order-card-body">
                                <div class="order-info-row">
                                    <div class="order-info-item">
                                        <span class="info-label">Сумма</span>
                                        <span class="info-value">{{ number_format($order->total_amount, 0, ',', ' ') }} ₽</span>
                                    </div>
                                    <div class="order-info-item">
                                        <span class="info-label">Статус</span>
                                        <span class="order-status {{ strtolower($order->status) }}">{{ ucfirst($order->status) }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="order-card-footer">
                                <a href="{{ route('profile.order.show', $order->id) }}" class="order-action-btn view-btn">
                                    <span class="btn-icon">👁</span>
                                    Подробнее
                                </a>
                                <a href="{{ route('profile.order.print', $order->id) }}" target="_blank" class="order-action-btn print-btn">
                                    <span class="btn-icon">🖨</span>
                                    Распечатать
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="empty-orders">
                    <div class="empty-icon">📦</div>
                    <h2 class="empty-title">Заказов пока нет</h2>
                    <p class="empty-text">Здесь будут отображаться ваши заказы</p>
                    <a href="{{ route('products.index') }}" class="empty-action-btn">Перейти в каталог</a>
                </div>
            @endif
        </div>
    </div>
@endsection

<style>
    .orders-page {
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

    .orders-container {
        max-width: 800px;
        margin: 0 auto;
    }

    .orders-header {
        margin-bottom: 50px;
        text-align: center;
    }

    .orders-title {
        font-size: 32px;
        font-weight: 400;
        margin: 0;
        letter-spacing: -0.5px;
        color: #000;
    }

    .orders-list {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .order-card {
        border: 1px solid #eaeaea;
        background: #fff;
        padding: 30px;
        transition: all 0.3s ease;
    }

    .order-card:hover {
        border-color: #000;
    }

    .order-card-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 25px;
        flex-wrap: wrap;
        gap: 15px;
    }

    .order-number {
        font-size: 18px;
        font-weight: 500;
        color: #000;
        letter-spacing: 0.5px;
    }

    .order-date {
        font-size: 14px;
        color: #666;
    }

    .order-card-body {
        margin-bottom: 30px;
        padding-bottom: 25px;
        border-bottom: 1px solid #f5f5f5;
    }

    .order-info-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 20px;
    }

    .order-info-item {
        display: flex;
        flex-direction: column;
        gap: 5px;
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
        font-weight: 500;
        color: #000;
    }

    .order-status {
        display: inline-block;
        padding: 6px 15px;
        font-size: 12px;
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

    .order-card-footer {
        display: flex;
        gap: 15px;
        flex-wrap: wrap;
    }

    .order-action-btn {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        padding: 12px 24px;
        font-size: 14px;
        font-weight: 500;
        text-decoration: none;
        border: 1px solid;
        background: #fff;
        transition: all 0.3s ease;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .view-btn {
        color: #000;
        border-color: #000;
    }

    .view-btn:hover {
        background: #000;
        color: #fff;
    }

    .print-btn {
        color: #666;
        border-color: #ddd;
    }

    .print-btn:hover {
        background: #f5f5f5;
        border-color: #666;
        color: #000;
    }

    .btn-icon {
        font-size: 16px;
    }

    .empty-orders {
        padding: 80px 20px;
        border: 1px solid #eaeaea;
        text-align: center;
        background: #fafafa;
    }

    .empty-icon {
        font-size: 60px;
        margin-bottom: 30px;
        display: block;
        opacity: 0.5;
    }

    .empty-title {
        font-size: 24px;
        font-weight: 400;
        margin: 0 0 15px 0;
        color: #000;
        letter-spacing: -0.5px;
    }

    .empty-text {
        font-size: 16px;
        color: #666;
        margin: 0 0 30px 0;
        line-height: 1.6;
    }

    .empty-action-btn {
        display: inline-block;
        padding: 15px 40px;
        background: #000;
        color: #fff;
        text-decoration: none;
        border: 1px solid #000;
        font-size: 14px;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 1px;
        transition: all 0.3s ease;
    }

    .empty-action-btn:hover {
        background: #333;
        border-color: #333;
    }

    @media (max-width: 768px) {
        .orders-page {
            padding: 20px 15px;
        }

        .breadcrumbs {
            margin-bottom: 30px;
        }

        .orders-title {
            font-size: 24px;
        }

        .order-card {
            padding: 20px;
        }

        .order-card-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 10px;
        }

        .order-info-row {
            flex-direction: column;
            align-items: flex-start;
            gap: 15px;
        }

        .order-card-footer {
            flex-direction: column;
        }

        .order-action-btn {
            width: 100%;
            justify-content: center;
        }

        .empty-orders {
            padding: 40px 20px;
        }

        .empty-icon {
            font-size: 40px;
            margin-bottom: 20px;
        }

        .empty-title {
            font-size: 20px;
        }
    }
</style>
