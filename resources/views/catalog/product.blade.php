@extends('layout.layouts')
@section('title', $product->name)
@section('content')
    <style>
        /* ===== СТРАНИЦА ТОВАРА ===== */

        .product-detail-page {
            padding: 50px 0;
            min-height: calc(100vh - 200px);
        }

        .container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 20px;
        }

        /* ===== СЕТКА ТОВАРА ===== */
        .product-detail-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 60px;
            align-items: start;
        }

        /* ===== ИЗОБРАЖЕНИЕ ===== */
        .product-images-col {
            position: sticky;
            top: 30px;
        }

        .product-main-image-container {
            width: 100%;
            aspect-ratio: 1;
            background: #f8f8f8;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        .product-main-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .product-main-image:hover {
            transform: scale(1.02);
        }

        /* ===== ИНФОРМАЦИЯ О ТОВАРЕ ===== */
        .product-info-col {
            display: flex;
            flex-direction: column;
            gap: 24px;
        }

        .product-category-tag {
            display: inline-block;
            font-size: 12px;
            color: #999;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-weight: 500;
        }

        .product-title-h1 {
            font-size: 36px;
            font-weight: 400;
            color: #000;
            margin: 0;
            line-height: 1.2;
            letter-spacing: -0.5px;
        }

        /* ===== ЦЕНА ===== */
        .product-price-section {
            padding: 20px 0;
            border-top: 1px solid #eaeaea;
            border-bottom: 1px solid #eaeaea;
        }

        .product-current-price {
            font-size: 32px;
            font-weight: 400;
            color: #000;
            letter-spacing: -0.5px;
        }

        /* ===== КНОПКА КОРЗИНЫ ===== */
        .product-add-to-cart-section {
            margin: 10px 0;
        }

        .add-to-cart-btn {
            width: 100%;
            padding: 18px 32px;
            background: #000;
            color: #fff;
            border: 1px solid #000;
            border-radius: 0;
            font-size: 14px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .add-to-cart-btn:hover {
            background: #333;
            border-color: #333;
        }

        .add-to-cart-btn:active {
            transform: scale(0.98);
        }

        /* ===== ОПИСАНИЕ ===== */
        .product-features {
            padding: 20px 0;
        }

        .feature-sub {
            font-size: 15px;
            line-height: 1.7;
            color: #555;
            margin: 0;
        }

        /* ===== ХАРАКТЕРИСТИКИ ===== */
        .product-specifications {
            padding: 20px 0;
            border-top: 1px solid #eaeaea;
        }

        .spec-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 0;
            border-bottom: 1px solid #f5f5f5;
        }

        .spec-row:last-child {
            border-bottom: none;
        }

        .spec-label {
            font-size: 14px;
            color: #666;
        }

        .spec-label strong {
            font-weight: 600;
            color: #333;
        }

        .spec-value {
            font-size: 14px;
            color: #000;
            font-weight: 500;
            text-align: right;
        }

        /* ===== ПРИМЕЧАНИЕ ===== */
        .product-note {
            font-size: 12px;
            color: #999;
            font-style: italic;
            padding-top: 10px;
        }

        /* ===== АДМИН-КНОПКА ===== */
        .product-admin-actions {
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid #eaeaea;
        }

        .admin-edit-btn {
            display: inline-block;
            padding: 12px 24px;
            background: #fff;
            color: #000;
            border: 1px solid #000;
            border-radius: 0;
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .admin-edit-btn:hover {
            background: #000;
            color: #fff;
        }

        /* ===== АДАПТИВНОСТЬ — БОЛЬШИЕ ЭКРАНЫ ===== */
        @media (max-width: 1400px) {
            .container {
                max-width: 1200px;
            }

            .product-detail-grid {
                gap: 50px;
            }

            .product-title-h1 {
                font-size: 32px;
            }

            .product-current-price {
                font-size: 28px;
            }
        }

        /* ===== АДАПТИВНОСТЬ — ПЛАНШЕТЫ ===== */
        @media (max-width: 1024px) {
            .product-detail-page {
                padding: 40px 0;
            }

            .container {
                padding: 0 16px;
            }

            .product-detail-grid {
                gap: 40px;
            }

            .product-images-col {
                position: static;
            }

            .product-title-h1 {
                font-size: 28px;
            }

            .product-current-price {
                font-size: 26px;
            }

            .add-to-cart-btn {
                padding: 16px 28px;
                font-size: 13px;
            }

            .feature-sub {
                font-size: 14px;
            }

            .spec-row {
                padding: 10px 0;
            }

            .spec-label,
            .spec-value {
                font-size: 13px;
            }
        }

        /* ===== АДАПТИВНОСТЬ — МАЛЕНЬКИЕ ПЛАНШЕТЫ ===== */
        @media (max-width: 768px) {
            .product-detail-page {
                padding: 30px 0;
            }

            .container {
                padding: 0 12px;
            }

            .product-detail-grid {
                grid-template-columns: 1fr;
                gap: 30px;
            }

            .product-images-col {
                position: static;
            }

            .product-main-image-container {
                max-width: 500px;
                margin: 0 auto;
            }

            .product-info-col {
                gap: 20px;
            }

            .product-title-h1 {
                font-size: 26px;
            }

            .product-price-section {
                padding: 16px 0;
            }

            .product-current-price {
                font-size: 24px;
            }

            .add-to-cart-btn {
                padding: 15px 24px;
                font-size: 13px;
            }

            .product-features {
                padding: 16px 0;
            }

            .feature-sub {
                font-size: 14px;
                line-height: 1.6;
            }

            .product-specifications {
                padding: 16px 0;
            }

            .spec-row {
                padding: 10px 0;
            }

            .spec-label,
            .spec-value {
                font-size: 13px;
            }

            .product-note {
                font-size: 11px;
            }

            .admin-edit-btn {
                padding: 11px 20px;
                font-size: 13px;
            }
        }

        /* ===== АДАПТИВНОСТЬ — МОБИЛЬНЫЕ ===== */
        @media (max-width: 480px) {
            .product-detail-page {
                padding: 20px 0;
            }

            .container {
                padding: 0 10px;
            }

            .product-detail-grid {
                gap: 24px;
            }

            .product-main-image-container {
                max-width: 100%;
            }

            .product-info-col {
                gap: 16px;
            }

            .product-category-tag {
                font-size: 11px;
                letter-spacing: 0.8px;
            }

            .product-title-h1 {
                font-size: 22px;
                line-height: 1.3;
            }

            .product-price-section {
                padding: 14px 0;
            }

            .product-current-price {
                font-size: 22px;
            }

            .add-to-cart-btn {
                padding: 14px 20px;
                font-size: 12px;
                letter-spacing: 0.8px;
            }

            .product-features {
                padding: 14px 0;
            }

            .feature-sub {
                font-size: 13px;
                line-height: 1.6;
            }

            .product-specifications {
                padding: 14px 0;
            }

            .spec-row {
                padding: 9px 0;
            }

            .spec-label {
                font-size: 12px;
            }

            .spec-value {
                font-size: 12px;
            }

            .product-note {
                font-size: 10px;
                padding-top: 8px;
            }

            .product-admin-actions {
                margin-top: 16px;
                padding-top: 16px;
            }

            .admin-edit-btn {
                width: 100%;
                text-align: center;
                padding: 12px 18px;
                font-size: 12px;
            }
        }

        /* ===== АДАПТИВНОСТЬ — ОЧЕНЬ МАЛЕНЬКИЕ ЭКРАНЫ ===== */
        @media (max-width: 360px) {
            .product-detail-page {
                padding: 16px 0;
            }

            .container {
                padding: 0 8px;
            }

            .product-detail-grid {
                gap: 20px;
            }

            .product-info-col {
                gap: 14px;
            }

            .product-category-tag {
                font-size: 10px;
            }

            .product-title-h1 {
                font-size: 20px;
            }

            .product-current-price {
                font-size: 20px;
            }

            .add-to-cart-btn {
                padding: 13px 16px;
                font-size: 11px;
            }

            .feature-sub {
                font-size: 12px;
            }

            .spec-row {
                padding: 8px 0;
            }

            .spec-label,
            .spec-value {
                font-size: 11px;
            }

            .product-note {
                font-size: 9px;
            }

            .admin-edit-btn {
                padding: 11px 14px;
                font-size: 11px;
            }
        }
    </style>

    <div class="container product-detail-page">
        <div class="container">
            <div class="product-detail-grid">
                <div class="product-images-col">
                    <div class="product-main-image-container">
                        @if($product->image)
                            <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" class="product-main-image" id="mainImage">
                        @else
                            <img src="{{ asset('image/default.png') }}" alt="Нет изображения" class="product-main-image" id="mainImage">
                        @endif
                    </div>
                </div>

                <div class="product-info-col">
                    <div class="product-category-tag">{{ $product->category->name }}</div>
                    <h1 class="product-title-h1">{{ $product->name }}</h1>
                    <div class="product-price-section">
                        <div class="product-current-price">{{ number_format($product->price, 0, ',', ' ') }} руб.</div>
                    </div>

                    @auth('client')
                        <div class="product-add-to-cart-section">
                            <form action="{{ route('cart.add', $product->id) }}" method="POST" id="cartForm">
                                @csrf
                                <button type="submit" class="add-to-cart-btn">
                                    ДОБАВИТЬ В КОРЗИНУ
                                </button>
                            </form>
                        </div>
                    @endauth

                    <div class="product-features">
                        <p class="feature-sub">{{ $product->description }}</p>
                    </div>

                    <div class="product-specifications">
                        <div class="spec-row">
                            <span class="spec-label"><strong>Высота:</strong></span>
                            <span class="spec-value">{{ $product->height }} см.</span>
                        </div>
                        <div class="spec-row">
                            <span class="spec-label"><strong>Ширина:</strong></span>
                            <span class="spec-value">{{ $product->width }} см.</span>
                        </div>
                        <div class="spec-row">
                            <span class="spec-label"><strong>Категория:</strong></span>
                            <span class="spec-value">{{ $product->category->name }}</span>
                        </div>
                        <div class="spec-row">
                            <span class="spec-label"><strong>Требование к освещению:</strong></span>
                            <span class="spec-value">{{ $product->light_requirement }}</span>
                        </div>
                    </div>

                    <!-- Примечание -->
                    <div class="product-note">
                        *оттенок и рисунок на вашем экране могут отличаться от реального.
                    </div>

                    <!-- Админ панель -->
                    @auth
                        @if(Auth::user()->role_id !== 1)
                            <div class="product-admin-actions">
                                <a href="{{ route('products.edit', $product->id) }}" class="admin-edit-btn">
                                    ✏️ Редактировать товар
                                </a>
                            </div>
                        @endif
                    @endauth
                </div>
            </div>
        </div>
    </div>
@endsection
