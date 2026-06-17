@extends('layout.layouts')
@section('title', 'Корзина')

@section('content')
    <div class="cart-container">
        <h1 class="cart-title">ВАША КОРЗИНА</h1>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @php($cart = session('cart', []))

        @if(count($cart) > 0)
            <div class="cart-items">
                @foreach($cart as $id => $item)
                    <div class="cart-item">
                        <img src="{{ asset($item['image']) }}" alt="{{ $item['name'] }}" class="cart-item-image">

                        <div class="cart-item-info">
                            <h3 class="cart-item-name">{{ $item['name'] }}</h3>

                            <div class="cart-item-details">
                                <div class="cart-item-main">

                                    <div class="cart-item-controls">
                                        <p class="cart-item-price">Цена: {{ number_format($item['price'], 0, ',', ' ') }} ₽</p>
                                        <div class="quantity-control">
                                            <a href="{{ route('cart.decrease', $id) }}" class="quantity-btn minus">–</a>
                                            <span class="quantity-value">{{ $item['quantity'] }}</span>
                                            <a href="{{ route('cart.increase', $id) }}" class="quantity-btn plus">+</a>
                                        </div>
                                    </div>
                                </div>
                                <p class="cart-item-total">{{ number_format($item['price'] * $item['quantity'], 0, ',', ' ') }} ₽</p>
                            </div>

                            @if(isset($item['options']) && count($item['options']) > 0)
                                <div class="cart-item-options">
                                    <p class="options-title">Дополнительные опции:</p>
                                    @foreach($item['options'] as $option => $value)
                                        <p class="option-item">{{ $option }}: {{ $value }}</p>
                                    @endforeach
                                </div>
                            @endif
                        </div>

                        <a href="{{ route('cart.remove', $id) }}" class="cart-item-remove">×</a>
                    </div>
                @endforeach
            </div>

            <div class="cart-summary">
                <div class="summary-wrapper">
                    <div class="summary-total">
                        <span class="total-label">Итого</span>
                        <span class="total-value">{{ number_format($total, 0, ',', ' ') }} ₽</span>
                    </div>
                </div>
            </div>

            <div class="cart-actions">
                <a href="{{ route('cart.clear') }}" class="btn-clear">ОЧИСТИТЬ КОРЗИНУ</a>

                <div class="action-buttons">
                    <a href="{{ route('products.index') }}" class="btn-continue">ПРОДОЛЖИТЬ ПОКУПКИ</a>

                    <a href="{{ route('checkout') }}" class="btn-checkout">ОФОРМИТЬ ЗАКАЗ</a>
                </div>
            </div>
        @else
            <div class="empty-cart">
                <div class="empty-cart-content">
                    <p class="empty-cart-text">В вашей корзине пока нет товаров</p>
                    <a href="{{ route('products.index') }}" class="btn-empty-cart">ПЕРЕЙТИ К ТОВАРАМ</a>
                </div>
            </div>
        @endif
    </div>
@endsection

<style>
    .cart-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 40px 20px;
        font-family: 'Helvetica Neue', Arial, sans-serif;
    }

    .cart-title {
        font-size: 32px;
        font-weight: 400;
        text-align: center;
        margin-bottom: 50px;
        letter-spacing: -0.5px;
        color: #000;
    }

    .alert-success {
        background: #f5f5f5;
        border: 1px solid #ddd;
        padding: 15px;
        margin-bottom: 30px;
        border-radius: 4px;
        color: #333;
    }

    .cart-items {
        margin-bottom: 50px;
    }

    .cart-item {
        display: flex;
        margin-bottom: 30px;
        padding: 30px;
        border: 1px solid #eaeaea;
        border-radius: 0;
        align-items: flex-start;
        background: #fff;
        position: relative;
    }

    .cart-item-image {
        width: 180px;
        height: 180px;
        object-fit: cover;
        border-radius: 0;
        margin-right: 30px;
        flex-shrink: 0;
    }

    .cart-item-info {
        flex: 1;
    }

    .cart-item-name {
        font-size: 20px;
        font-weight: 400;
        margin: 0 0 15px 0;
        color: #000;
        letter-spacing: -0.3px;
    }

    .cart-item-details {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }

    .cart-item-sku {
        margin: 0 0 8px 0;
        font-size: 14px;
        color: #666;
    }

    .cart-item-controls {
        display: flex;
        align-items: center;
        gap: 20px;
    }

    .cart-item-price {
        margin: 0;
        font-size: 16px;
        color: #333;
        font-weight: 500;
    }

    .quantity-control {
        display: flex;
        align-items: center;
        background: #f5f5f5;
        padding: 5px 15px;
        border-radius: 4px;
    }

    .quantity-btn {
        padding: 5px 15px;
        background: transparent;
        border: none;
        font-size: 20px;
        color: #666;
        text-decoration: none;
        cursor: pointer;
        transition: color 0.3s ease;
    }

    .quantity-btn:hover {
        color: #000;
    }

    .quantity-value {
        font-size: 16px;
        font-weight: 400;
        margin: 0 20px;
    }

    .cart-item-total {
        font-size: 24px;
        font-weight: 400;
        margin: 0;
        color: #000;
    }

    .cart-item-options {
        margin-top: 20px;
        padding-top: 20px;
        border-top: 1px solid #f0f0f0;
    }

    .options-title {
        margin: 0 0 10px 0;
        font-size: 14px;
        color: #666;
    }

    .option-item {
        margin: 0 0 5px 0;
        font-size: 14px;
        color: #333;
    }

    .cart-item-remove {
        position: absolute;
        top: 30px;
        right: 30px;
        padding: 0;
        background: none;
        border: none;
        font-size: 30px;
        color: #999;
        text-decoration: none;
        cursor: pointer;
        line-height: 1;
        transition: color 0.3s ease;
    }

    .cart-item-remove:hover {
        color: #000;
    }

    .cart-summary {
        padding-top: 40px;
    }

    .summary-wrapper {
        margin-left: auto;
    }

    .summary-row {
        display: flex;
        justify-content: space-between;
        margin-bottom: 20px;
    }

    .summary-label {
        font-size: 18px;
        color: #666;
    }

    .summary-value {
        font-size: 18px;
        font-weight: 500;
        color: #000;
    }

    .summary-total {
        display: flex;
        justify-content: space-between;
        margin-bottom: 40px;
        padding-top: 20px;
        border-top: 1px solid #eaeaea;
    }

    .total-label {
        font-size: 24px;
        color: #000;
    }

    .total-value {
        font-size: 24px;
        font-weight: 400;
        color: #000;
    }

    .cart-actions {
        margin-top: 40px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 20px;
    }

    .btn-clear,
    .btn-continue,
    .btn-checkout,
    .btn-empty-cart {
        padding: 15px 30px;
        background: transparent;
        color: #666;
        text-decoration: none;
        border: 1px solid #ddd;
        border-radius: 0;
        font-size: 16px;
        transition: all 0.3s ease;
        cursor: pointer;
        display: inline-block;
        text-align: center;
    }

    .btn-continue {
        padding: 15px 30px;
        color: #000;
        border: 1px solid #000;
    }

    .btn-checkout,
    .btn-empty-cart {
        padding: 15px 40px;
        background: #000;
        color: #fff;
        border: 1px solid #000;
    }

    .btn-empty-cart {
        margin-top: 15px;
    }

    .btn-clear:hover {
        background-color: #f5f5f5;
        border-color: #666;
    }

    .btn-continue:hover {
        background-color: #000;
        color: #fff;
    }

    .btn-checkout:hover,
    .btn-empty-cart:hover {
        background-color: #333;
        border-color: #333;
    }

    .action-buttons {
        display: flex;
        gap: 20px;
    }

    .empty-cart {
        text-align: center;
        padding: 80px 20px;
        background: #fff;
        border: 1px solid #eaeaea;
    }

    .empty-cart-content {
        max-width: 400px;
        margin: 0 auto;
    }

    .empty-cart-text {
        font-size: 18px;
        color: #666;
        margin-bottom: 30px;
        line-height: 1.6;
    }

    /* ===== АДАПТИВНОСТЬ — ПЛАНШЕТЫ ===== */
    @media (max-width: 1024px) {
        .cart-container {
            padding: 30px 16px;
        }

        .cart-title {
            font-size: 28px;
            margin-bottom: 40px;
        }

        .cart-item {
            padding: 24px;
            margin-bottom: 24px;
        }

        .cart-item-image {
            width: 160px;
            height: 160px;
            margin-right: 24px;
        }

        .cart-item-name {
            font-size: 18px;
        }

        .cart-item-controls {
            gap: 16px;
        }

        .cart-item-price {
            font-size: 15px;
        }

        .quantity-value {
            font-size: 15px;
            margin: 0 16px;
        }

        .cart-item-total {
            font-size: 22px;
        }

        .cart-item-remove {
            top: 24px;
            right: 24px;
            font-size: 28px;
        }

        .total-label,
        .total-value {
            font-size: 22px;
        }

        .btn-clear,
        .btn-continue,
        .btn-checkout {
            padding: 14px 24px;
            font-size: 15px;
        }
    }

    /* ===== АДАПТИВНОСТЬ — МАЛЕНЬКИЕ ПЛАНШЕТЫ ===== */
    @media (max-width: 900px) {
        .cart-item {
            padding: 20px;
        }

        .cart-item-image {
            width: 140px;
            height: 140px;
            margin-right: 20px;
        }

        .cart-item-name {
            font-size: 17px;
            margin-bottom: 12px;
        }

        .cart-item-details {
            flex-direction: column;
            align-items: flex-start;
            gap: 12px;
            margin-bottom: 16px;
        }

        .cart-item-total {
            font-size: 20px;
            align-self: flex-start;
        }

        .cart-item-controls {
            flex-wrap: wrap;
            gap: 12px;
        }

        .cart-item-remove {
            top: 20px;
            right: 20px;
            font-size: 26px;
        }

        .cart-actions {
            flex-direction: column;
            align-items: stretch;
            gap: 12px;
        }

        .action-buttons {
            flex-direction: column;
            gap: 12px;
        }

        .btn-clear,
        .btn-continue,
        .btn-checkout {
            width: 100%;
            text-align: center;
            padding: 14px 20px;
        }

        .summary-wrapper {
            width: 100%;
        }
    }

    /* ===== АДАПТИВНОСТЬ — МОБИЛЬНЫЕ ===== */
    @media (max-width: 768px) {
        .cart-container {
            padding: 24px 12px;
        }

        .cart-title {
            font-size: 24px;
            margin-bottom: 30px;
            letter-spacing: 0;
        }

        .alert-success {
            padding: 12px;
            margin-bottom: 20px;
            font-size: 14px;
        }

        .cart-items {
            margin-bottom: 30px;
        }

        .cart-item {
            flex-direction: column;
            padding: 16px;
            margin-bottom: 16px;
        }

        .cart-item-image {
            width: 100%;
            height: auto;
            max-height: 300px;
            margin-right: 0;
            margin-bottom: 16px;
        }

        .cart-item-name {
            font-size: 17px;
            margin-bottom: 12px;
            padding-right: 30px;
        }

        .cart-item-details {
            flex-direction: column;
            align-items: flex-start;
            gap: 12px;
            margin-bottom: 12px;
        }

        .cart-item-controls {
            flex-wrap: wrap;
            gap: 10px;
            width: 100%;
        }

        .cart-item-price {
            font-size: 14px;
        }

        .quantity-control {
            padding: 4px 12px;
        }

        .quantity-btn {
            padding: 4px 12px;
            font-size: 18px;
        }

        .quantity-value {
            font-size: 15px;
            margin: 0 12px;
        }

        .cart-item-total {
            font-size: 20px;
            align-self: flex-end;
            width: 100%;
            text-align: right;
            padding-top: 12px;
            border-top: 1px solid #f0f0f0;
        }

        .cart-item-options {
            margin-top: 12px;
            padding-top: 12px;
        }

        .options-title,
        .option-item {
            font-size: 13px;
        }

        .cart-item-remove {
            top: 16px;
            right: 16px;
            font-size: 28px;
            padding: 4px 8px;
            z-index: 1;
        }

        /* Summary */
        .cart-summary {
            padding-top: 24px;
        }

        .summary-wrapper {
            width: 100%;
            margin-left: 0;
        }

        .summary-total {
            margin-bottom: 24px;
            padding-top: 16px;
        }

        .total-label,
        .total-value {
            font-size: 20px;
        }

        /* Actions */
        .cart-actions {
            margin-top: 24px;
            flex-direction: column;
            align-items: stretch;
            gap: 10px;
        }

        .action-buttons {
            flex-direction: column;
            width: 100%;
            gap: 10px;
        }

        .btn-clear,
        .btn-continue,
        .btn-checkout {
            width: 100%;
            text-align: center;
            padding: 14px 20px;
            font-size: 14px;
        }

        /* Empty cart */
        .empty-cart {
            padding: 50px 16px;
        }

        .empty-cart-text {
            font-size: 16px;
            margin-bottom: 24px;
        }

        .btn-empty-cart {
            width: 100%;
            padding: 14px 20px;
            font-size: 14px;
            margin-top: 12px;
        }
    }

    /* ===== АДАПТИВНОСТЬ — МАЛЕНЬКИЕ ЭКРАНЫ ===== */
    @media (max-width: 480px) {
        .cart-container {
            padding: 20px 10px;
        }

        .cart-title {
            font-size: 20px;
            margin-bottom: 24px;
        }

        .alert-success {
            padding: 10px;
            font-size: 13px;
            margin-bottom: 16px;
        }

        .cart-item {
            padding: 14px;
            margin-bottom: 12px;
        }

        .cart-item-image {
            max-height: 240px;
            margin-bottom: 14px;
        }

        .cart-item-name {
            font-size: 16px;
            margin-bottom: 10px;
            line-height: 1.3;
        }

        .cart-item-details {
            gap: 10px;
            margin-bottom: 10px;
        }

        .cart-item-controls {
            gap: 8px;
        }

        .cart-item-price {
            font-size: 13px;
        }

        .quantity-control {
            padding: 3px 10px;
        }

        .quantity-btn {
            padding: 3px 10px;
            font-size: 16px;
        }

        .quantity-value {
            font-size: 14px;
            margin: 0 10px;
        }

        .cart-item-total {
            font-size: 18px;
            padding-top: 10px;
        }

        .cart-item-options {
            margin-top: 10px;
            padding-top: 10px;
        }

        .options-title,
        .option-item {
            font-size: 12px;
        }

        .cart-item-remove {
            top: 14px;
            right: 14px;
            font-size: 26px;
        }

        /* Summary */
        .cart-summary {
            padding-top: 20px;
        }

        .summary-total {
            margin-bottom: 20px;
            padding-top: 12px;
        }

        .total-label,
        .total-value {
            font-size: 18px;
        }

        /* Actions */
        .cart-actions {
            margin-top: 20px;
            gap: 8px;
        }

        .action-buttons {
            gap: 8px;
        }

        .btn-clear,
        .btn-continue,
        .btn-checkout {
            padding: 12px 16px;
            font-size: 13px;
            letter-spacing: 0.3px;
        }

        /* Empty cart */
        .empty-cart {
            padding: 40px 12px;
        }

        .empty-cart-text {
            font-size: 15px;
            margin-bottom: 20px;
            line-height: 1.5;
        }

        .btn-empty-cart {
            padding: 12px 16px;
            font-size: 13px;
        }
    }
</style>
