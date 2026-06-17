@extends('layout.layouts')
@section('title', 'Чек заказа №' . $order->code)

@section('content')
    <div class="receipt-page">
        <div class="receipt-container">
            <div class="receipt-header">
                <div class="document-type">
                    <h2 class="document-title">ЧЕК ЗАКАЗА</h2>
                </div>
            </div>

            <div class="receipt-content">
                <!-- Информация о заказе -->
                <div class="receipt-section">
                    <div class="section-row two-column">
                        <div class="info-block">
                            <div class="info-label">Номер заказа</div>
                            <div class="info-value">{{ $order->code }}</div>
                        </div>
                        <div class="info-block">
                            <div class="info-label">Дата и время</div>
                            <div class="info-value">{{ \Carbon\Carbon::parse($order->order_date)->format('d.m.Y H:i') }}</div>
                        </div>
                    </div>
                </div>

                <!-- Товары -->
                <div class="receipt-section">
                    <div class="section-header">
                        <h3 class="section-title">Товары</h3>
                    </div>

                    <div class="items-table">
                        <div class="table-header">
                            <div class="header-cell name-col">Наименование</div>
                            <div class="header-cell qty-col">Кол-во</div>
                            <div class="header-cell price-col">Цена</div>
                            <div class="header-cell total-col">Сумма</div>
                        </div>

                        @foreach($order->items as $item)
                            <div class="table-row">
                                <div class="table-cell name-col">
                                    <div class="product-name">{{ $item->product->name ?? 'Товар удален' }}</div>
                                </div>
                                <div class="table-cell qty-col">
                                    <div class="product-quantity">{{ $item->quantity }} шт.</div>
                                </div>
                                <div class="table-cell price-col">
                                    <div class="product-price">{{ number_format($item->price_at_order, 0, ',', ' ') }} ₽</div>
                                </div>
                                <div class="table-cell total-col">
                                    <div class="product-total">{{ number_format($item->quantity * $item->price_at_order, 0, ',', ' ') }} ₽</div>
                                </div>
                            </div>
                        @endforeach

                    </div>
                </div>

                <!-- Итоги -->
                <div class="receipt-section">
                    <div class="total-block">
                        <div class="total-row">
                            <span class="total-label">Сумма товаров</span>
                            <span class="total-value">{{ number_format($order->total_amount, 0, ',', ' ') }} ₽</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="receipt-actions">
                <a href="{{ route('profile.order.download', $order->id) }}" class="download-btn">
                    <span class="btn-icon">📥</span>
                    Скачать PDF
                </a>
                <button onclick="window.print()" class="print-btn">
                    <span class="btn-icon">🖨</span>
                    Распечатать
                </button>
            </div>
        </div>
    </div>
@endsection

<style>
    .receipt-page {
        max-width: 1000px;
        margin: 0 auto;
        padding: 40px 20px;
        font-family: 'Helvetica Neue', Arial, sans-serif;
        color: #000;
        background: #fff;
        min-height: 70vh;
    }

    .breadcrumbs {
        margin-bottom: 40px;
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

    .receipt-container {
        border: 1px solid #000;
        background: #fff;
        padding: 50px;
        box-shadow: 0 5px 30px rgba(0, 0, 0, 0.1);
    }

    @media (max-width: 768px) {
        .receipt-container {
            padding: 30px 20px;
        }
    }

    /* Шапка чека */
    .receipt-header {
        margin-bottom: 50px;
        padding-bottom: 30px;
        border-bottom: 1px solid #eaeaea;
    }

    .company-info {
        text-align: center;
        margin-bottom: 30px;
    }

    .company-name {
        font-size: 28px;
        font-weight: 400;
        margin: 0 0 15px 0;
        letter-spacing: 2px;
        text-transform: uppercase;
    }

    .company-address,
    .company-contacts {
        font-size: 14px;
        color: #666;
        margin: 0 0 8px 0;
        line-height: 1.4;
    }

    .document-type {
        text-align: center;
    }

    .document-title {
        font-size: 24px;
        font-weight: 400;
        margin: 0;
        letter-spacing: 1px;
        text-transform: uppercase;
        position: relative;
        padding-bottom: 15px;
    }

    .document-title::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 50%;
        transform: translateX(-50%);
        width: 100px;
        height: 1px;
        background: #000;
    }

    /* Содержимое чека */
    .receipt-content {
        margin-bottom: 50px;
    }

    .receipt-section {
        margin-bottom: 40px;
    }

    .receipt-section:last-child {
        margin-bottom: 0;
    }

    .section-row {
        display: flex;
        gap: 40px;
    }

    .section-row.two-column {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 40px;
    }

    @media (max-width: 768px) {
        .section-row.two-column {
            grid-template-columns: 1fr;
            gap: 20px;
        }
    }

    .info-block {
        padding-bottom: 20px;
        border-bottom: 1px solid #f5f5f5;
    }

    .info-label {
        font-size: 12px;
        font-weight: 500;
        color: #666;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: 5px;
    }

    .info-value {
        font-size: 18px;
        font-weight: 400;
        color: #000;
    }

    /* Таблица товаров */
    .section-header {
        margin-bottom: 25px;
    }

    .section-title {
        font-size: 18px;
        font-weight: 500;
        margin: 0;
        letter-spacing: -0.3px;
    }

    .items-table {
        border-top: 1px solid #000;
        border-bottom: 1px solid #000;
    }

    .table-header {
        display: grid;
        grid-template-columns: 3fr 1fr 1fr 1fr;
        padding: 15px 0;
        border-bottom: 1px solid #eaeaea;
        font-size: 12px;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: #666;
    }

    .table-row {
        display: grid;
        grid-template-columns: 3fr 1fr 1fr 1fr;
        padding: 20px 0;
        border-bottom: 1px solid #f5f5f5;
    }

    .table-row:last-child {
        border-bottom: none;
    }

    .header-cell,
    .table-cell {
        padding: 0 10px;
    }

    .name-col {
        text-align: left;
    }

    .qty-col,
    .price-col,
    .total-col {
        text-align: center;
    }

    .product-name {
        font-size: 16px;
        font-weight: 400;
        color: #000;
        line-height: 1.4;
    }

    .product-quantity,
    .product-price,
    .product-total {
        font-size: 16px;
        color: #000;
    }

    .product-total {
        font-weight: 500;
    }

    /* Итоги */
    .total-block {
        max-width: 400px;
        margin-left: auto;
    }

    .total-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 15px 0;
        border-bottom: 1px solid #f5f5f5;
        font-size: 16px;
    }

    .total-row:last-child {
        border-bottom: none;
    }

    .total-label {
        color: #666;
    }

    .total-value {
        font-weight: 500;
        color: #000;
    }

    .total-row.main-total {
        font-size: 20px;
        padding-top: 25px;
        border-top: 1px solid #eaeaea;
        margin-top: 10px;
    }

    /* Подвал чека */
    .receipt-footer {
        margin-top: 60px;
        padding-top: 40px;
        border-top: 1px solid #eaeaea;
    }

    .footer-row {
        display: grid;
        grid-template-columns: 1fr 2fr;
        gap: 40px;
        align-items: center;
    }

    @media (max-width: 768px) {
        .footer-row {
            grid-template-columns: 1fr;
            gap: 30px;
        }
    }

    .qr-code-placeholder {
        text-align: center;
    }

    .qr-code {
        width: 100px;
        height: 100px;
        border: 1px solid #eaeaea;
        margin: 0 auto 15px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
        color: #999;
        background: #f5f5f5;
    }

    .qr-label {
        font-size: 12px;
        color: #666;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .footer-info {
        text-align: center;
    }

    .footer-text {
        font-size: 14px;
        color: #666;
        margin: 0 0 10px 0;
        line-height: 1.6;
    }

    /* Кнопки действий */
    .receipt-actions {
        display: flex;
        justify-content: center;
        gap: 20px;
        margin-top: 40px;
        padding-top: 40px;
        border-top: 1px solid #eaeaea;
    }

    .download-btn,
    .print-btn {
        display: inline-flex;
        align-items: center;
        gap: 10px;
        padding: 15px 30px;
        font-size: 14px;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 1px;
        text-decoration: none;
        border: 1px solid;
        cursor: pointer;
        transition: all 0.3s ease;
        background: #fff;
    }

    .download-btn {
        color: #000;
        border-color: #000;
    }

    .download-btn:hover {
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

    /* Стили для печати */
    @media print {
        .receipt-page {
            padding: 0;
        }

        .breadcrumbs,
        .receipt-actions {
            display: none;
        }

        .receipt-container {
            border: none;
            box-shadow: none;
            padding: 0;
        }

        .download-btn,
        .print-btn {
            display: none;
        }

        body {
            background: #fff;
        }
    }

    /* Мобильная адаптация */
    @media (max-width: 768px) {
        .receipt-page {
            padding: 20px 15px;
        }

        .breadcrumbs {
            margin-bottom: 30px;
        }

        .company-name {
            font-size: 24px;
        }

        .document-title {
            font-size: 20px;
        }

        .table-header,
        .table-row {
            grid-template-columns: 2fr 1fr 1fr 1fr;
            font-size: 12px;
        }

        .product-name {
            font-size: 14px;
        }

        .product-quantity,
        .product-price,
        .product-total {
            font-size: 14px;
        }

        .receipt-actions {
            flex-direction: column;
            gap: 15px;
        }

        .download-btn,
        .print-btn {
            width: 100%;
            justify-content: center;
        }
    }
</style>
