@extends('layout.layouts')
@section('title', 'Оформление заказа')

@section('content')
    <div class="checkout-container">

        <h1 class="checkout-title">Оформление заказа</h1>

        <div class="checkout-grid">
            <!-- Левая колонка - Информация о заказе -->
            <div class="order-summary">
                <div class="summary-header">
                    <h2 class="summary-title">Ваш заказ</h2>
                </div>

                @foreach($products as $product)
                    <div class="order-item">

                        <div class="item-header">
                            <h3 class="item-name">{{ $product->name }}</h3>
                        </div>

                        <div class="item-details">
                            <div class="detail-row">
                                <span class="detail-label">Размер:</span>
                                <span class="detail-value">{{ $product->width }}×{{ $product->height }} см</span>
                            </div>
                            @if(isset($product->light_requirement))
                                <div class="detail-row">
                                    <span class="detail-label">Требования к освещению:</span>
                                    <span class="detail-value">{{ $product->light_requirement }}</span>
                                </div>
                            @endif
                        </div>

                        <div style="display:flex;align-items: center;justify-content: right">
                            <div>
                                <span class="total-value" id="total-sum">{{ $product->price }} ₽</span>
                            </div>
                        </div>
                    </div>
                @endforeach

                <div class="order-total">
                    <div class="total-row">
                        <span class="total-label">Сумма:</span>
                        <span class="total-value" id="total-sum">{{ number_format($total, 0, ',', ' ') }} ₽</span>
                    </div>
                </div>

                <div class="back-to-catalog">
                    <a href="{{ route('products.index') }}" class="back-link">
                        ← ВЕРНУТЬСЯ В КАТАЛОГ
                    </a>
                </div>
            </div>

            <script>
                function updateQuantity(productId, change) {
                    let url = change > 0
                        ? `/cart/increase/${productId}`
                        : `/cart/decrease/${productId}`;

                    fetch(url)
                        .then(response => response.json())
                        .then(data => {
                            document.getElementById(`quantity-${productId}`).textContent = data.quantity;

                            const priceEl = document.getElementById(`price-${productId}`);
                            const pricePerItem = parseInt(priceEl.dataset.price);
                            priceEl.textContent = new Intl.NumberFormat('ru-RU').format(pricePerItem * data.quantity) + ' ₽';

                            document.getElementById('total-sum').textContent = new Intl.NumberFormat('ru-RU').format(data.total) + ' ₽';
                        })
                        .catch(err => console.error(err));
                }
            </script>


            <!-- Правая колонка - Форма оформления -->
            <div class="checkout-form">
                <form action="{{ route('checkout.store') }}" method="POST" class="order-form">
                    @csrf

                    <div class="form-section">
                        <h2 class="form-section-title">Контактные данные</h2>

                        <div class="contact-data-grid">
                            <div class="contact-data-row">
                                <div class="contact-data-item">
                                    <span class="contact-data-label">Имя</span>
                                    <span class="contact-data-value">{{ auth('client')->user()->name }}</span>
                                </div>
                                <div class="contact-data-item">
                                    <span class="contact-data-label">Фамилия</span>
                                    <span class="contact-data-value">{{ auth('client')->user()->surname }}</span>
                                </div>
                            </div>

                            <div class="contact-data-row">
                                <div class="contact-data-item">
                                    <span class="contact-data-label">Телефон</span>
                                    <span class="contact-data-value">{{ auth('client')->user()->phone }}</span>
                                </div>
                                <div class="contact-data-item">
                                    <span class="contact-data-label">E-mail</span>
                                    <span class="contact-data-value">{{ auth('client')->user()->email }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-section">
                        <h2 class="form-section-title">Способ оплаты</h2>

                        <div class="payment-methods">
                            <label class="payment-method">
                                <input type="radio" name="payment_method" value="card" checked class="payment-input">
                                <div class="payment-card">
                                    <div class="payment-icon">💳</div>
                                    <div class="payment-info">
                                        <div class="payment-title">Банковская карта</div>
                                        <div class="payment-desc">Оплата онлайн картой</div>
                                    </div>
                                </div>
                            </label>

                            <label class="payment-method">
                                <input type="radio" name="payment_method" value="cash" class="payment-input">
                                <div class="payment-card">
                                    <div class="payment-icon">💵</div>
                                    <div class="payment-info">
                                        <div class="payment-title">Наличные при получении</div>
                                        <div class="payment-desc">Оплата курьеру при доставке</div>
                                    </div>
                                </div>
                            </label>
                        </div>

                        <!-- Уведомление для наличных -->
                        <div id="delivery-notice" style="display:none;margin-top:20px;padding:20px;background:#f0f9ff;border:1px solid #bae6fd;border-radius:8px;color:#0284c7;font-size:14px;">
                            <strong>📦 Важно!</strong> После подтверждения заказа вам нужно будет указать адрес доставки.
                        </div>
                    </div>

                    <div class="form-footer">
                        <button type="submit" class="submit-order-btn">
                            <span class="submit-text">ПОДТВЕРДИТЬ ЗАКАЗ</span>
                            <span class="submit-price">{{ number_format($total, 0, ',', ' ') }} ₽</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Показываем уведомление если выбрано "наличные"
        document.querySelectorAll('input[name="payment_method"]').forEach(radio => {
            radio.addEventListener('change', function() {
                const notice = document.getElementById('delivery-notice');
                if (this.value === 'cash') {
                    notice.style.display = 'block';
                } else {
                    notice.style.display = 'none';
                }
            });
        });

        // Проверяем при загрузке страницы
        const checkedRadio = document.querySelector('input[name="payment_method"]:checked');
        if (checkedRadio && checkedRadio.value === 'cash') {
            document.getElementById('delivery-notice').style.display = 'block';
        }
    </script>
@endsection

<style>
    /* Контактные данные пользователя */
    .checkout-contact-data {
        margin-bottom: 40px;
    }

    .contact-data-grid {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .contact-data-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
    }

    @media (max-width: 768px) {
        .contact-data-row {
            grid-template-columns: 1fr;
            gap: 15px;
        }
    }

    .contact-data-item {
        display: flex;
        flex-direction: column;
        padding: 20px;
        border: 1px solid #eaeaea;
        background: #fafafa;
        min-height: 80px;
        justify-content: center;
    }

    .contact-data-label {
        font-size: 12px;
        font-weight: 500;
        color: #666;
        text-transform: uppercase;
        letter-spacing: 1px;
        margin-bottom: 8px;
    }

    .contact-data-value {
        font-size: 16px;
        color: #000;
        font-weight: 400;
        line-height: 1.4;
    }

    /* Альтернативный вариант - более компактный */
    .contact-data-compact {
        border: 1px solid #eaeaea;
        padding: 30px;
        background: #fff;
    }

    .contact-data-compact .contact-data-item {
        display: flex;
        align-items: center;
        padding: 15px 0;
        border: none;
        background: transparent;
        min-height: auto;
        border-bottom: 1px solid #f5f5f5;
    }

    .contact-data-compact .contact-data-item:last-child {
        border-bottom: none;
    }

    .contact-data-compact .contact-data-label {
        min-width: 100px;
        margin-bottom: 0;
        margin-right: 20px;
    }

    .contact-data-compact .contact-data-value {
        flex: 1;
    }
    /* Базовые стили */
    .checkout-container {
        max-width: 1400px;
        margin: 0 auto;
        padding: 40px 20px;
        font-family: 'Helvetica Neue', Arial, sans-serif;
        color: #000;
        background: #fff;
    }

    /* Хлебные крошки */
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

    /* Заголовок */
    .checkout-title {
        font-size: 32px;
        font-weight: 400;
        text-align: center;
        margin: 0 0 50px 0;
        letter-spacing: -0.5px;
    }

    /* Основная сетка */
    .checkout-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 60px;
        max-width: 1200px;
        margin: 0 auto;
    }

    @media (max-width: 992px) {
        .checkout-grid {
            grid-template-columns: 1fr;
            gap: 40px;
        }
    }

    /* Сумма заказа */
    .order-summary {
        position: sticky;
        top: 40px;
        align-self: start;
        border: 1px solid #eaeaea;
        padding: 30px;
        background: #fff;
    }

    .summary-header {
        margin-bottom: 30px;
        padding-bottom: 20px;
        border-bottom: 1px solid #eaeaea;
    }

    .summary-title {
        font-size: 20px;
        font-weight: 500;
        margin: 0;
        letter-spacing: -0.3px;
    }

    /* Элемент заказа */
    .order-item {
        margin-bottom: 40px;
        padding-bottom: 30px;
        border-bottom: 1px solid #f5f5f5;
    }

    .item-header {
        margin-bottom: 20px;
    }

    .item-name {
        font-size: 18px;
        font-weight: 500;
        margin: 0 0 10px 0;
    }

    .item-details {
        margin-bottom: 25px;
    }

    .detail-row {
        display: flex;
        margin-bottom: 8px;
        font-size: 14px;
        line-height: 1.5;
    }

    .detail-label {
        min-width: 140px;
        color: #666;
        text-transform: lowercase;
    }

    .detail-value {
        color: #000;
        flex: 1;
    }

    /* Количество и цена */
    .item-quantity-price {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-top: 20px;
        border-top: 1px solid #f5f5f5;
    }

    .quantity-selector {
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .quantity-label {
        font-size: 14px;
        color: #666;
    }

    .quantity-control {
        display: flex;
        align-items: center;
        background: #f5f5f5;
        border-radius: 4px;
        overflow: hidden;
    }

    .quantity-btn {
        width: 36px;
        height: 36px;
        background: transparent;
        border: none;
        font-size: 18px;
        color: #666;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .quantity-btn:hover {
        background: #e0e0e0;
        color: #000;
    }

    .quantity-value {
        width: 40px;
        text-align: center;
        font-size: 16px;
        font-weight: 500;
    }

    .item-price {
        font-size: 24px;
        font-weight: 500;
        color: #000;
    }

    /* Итоговая сумма */
    .order-total {
        margin-bottom: 30px;
    }

    .total-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 20px;
        padding: 15px 0;
        border-top: 1px solid #eaeaea;
    }

    .total-label {
        font-weight: 500;
    }

    .total-value {
        font-weight: 500;
    }

    /* Возврат в каталог */
    .back-to-catalog {
        margin-top: 30px;
        padding-top: 30px;
        border-top: 1px solid #eaeaea;
    }

    .back-link {
        color: #000;
        text-decoration: none;
        font-size: 14px;
        font-weight: 500;
        letter-spacing: 1px;
        text-transform: uppercase;
        transition: color 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 10px;
    }

    .back-link:hover {
        color: #666;
    }

    /* Форма оформления */
    .form-section {
        margin-bottom: 40px;
        padding-bottom: 30px;
        border-bottom: 1px solid #eaeaea;
    }

    .form-section:last-of-type {
        border-bottom: none;
        margin-bottom: 0;
    }

    .form-section-title {
        font-size: 18px;
        font-weight: 500;
        margin: 0 0 25px 0;
        letter-spacing: -0.3px;
    }

    .form-row {
        display: grid;
        gap: 20px;
    }

    .form-row.two-column {
        grid-template-columns: 1fr 1fr;
    }

    @media (max-width: 768px) {
        .form-row.two-column {
            grid-template-columns: 1fr;
        }
    }

    .form-group {
        margin-bottom: 25px;
    }

    .form-group:last-child {
        margin-bottom: 0;
    }

    .form-label {
        display: block;
        font-size: 14px;
        font-weight: 500;
        margin-bottom: 8px;
        color: #666;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .form-input {
        width: 100%;
        padding: 12px 15px;
        border: 1px solid #e0e0e0;
        background: #fff;
        font-size: 16px;
        color: #000;
        transition: all 0.3s ease;
        font-family: 'Helvetica Neue', Arial, sans-serif;
    }

    .form-input:focus {
        outline: none;
        border-color: #000;
    }

    .form-input::placeholder {
        color: #999;
    }

    /* Телефон */
    .phone-input-wrapper {
        display: flex;
        align-items: center;
        border: 1px solid #e0e0e0;
        background: #fff;
    }

    .phone-prefix {
        padding: 12px 15px;
        background: #f5f5f5;
        font-size: 16px;
        color: #666;
        border-right: 1px solid #e0e0e0;
    }

    .phone-input {
        border: none;
        padding-left: 15px;
    }

    .phone-input:focus {
        border: none;
        outline: none;
    }

    /* Платежные методы */
    .payment-methods {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .payment-method {
        cursor: pointer;
    }

    .payment-input {
        display: none;
    }

    .payment-input:checked + .payment-card {
        border-color: #000;
        background: #fafafa;
    }

    .payment-card {
        display: flex;
        align-items: center;
        gap: 15px;
        padding: 20px;
        border: 1px solid #e0e0e0;
        background: #fff;
        transition: all 0.3s ease;
    }

    .payment-card:hover {
        border-color: #999;
    }

    .payment-icon {
        font-size: 24px;
    }

    .payment-info {
        flex: 1;
    }

    .payment-title {
        font-size: 16px;
        font-weight: 500;
        margin-bottom: 4px;
    }

    .payment-desc {
        font-size: 14px;
        color: #666;
    }

    /* Комментарий */
    .form-textarea {
        width: 100%;
        padding: 12px 15px;
        border: 1px solid #e0e0e0;
        background: #fff;
        font-size: 16px;
        color: #000;
        transition: all 0.3s ease;
        font-family: 'Helvetica Neue', Arial, sans-serif;
        resize: vertical;
        min-height: 120px;
    }

    .form-textarea:focus {
        outline: none;
        border-color: #000;
    }

    .form-textarea::placeholder {
        color: #999;
    }

    /* Подвал формы */
    .form-footer {
        margin-top: 40px;
    }

    .agreement {
        margin-bottom: 30px;
    }

    .agreement-checkbox {
        display: flex;
        align-items: flex-start;
        gap: 12px;
        cursor: pointer;
        font-size: 14px;
        color: #666;
        line-height: 1.5;
    }

    .agreement-input {
        margin-top: 3px;
        flex-shrink: 0;
    }

    .agreement-link {
        color: #000;
        text-decoration: none;
        border-bottom: 1px solid transparent;
        transition: border-color 0.3s ease;
    }

    .agreement-link:hover {
        border-bottom-color: #000;
    }

    /* Кнопка подтверждения */
    .submit-order-btn {
        width: 100%;
        background: #000;
        color: #fff;
        border: 1px solid #000;
        padding: 20px;
        font-size: 16px;
        text-transform: uppercase;
        letter-spacing: 1px;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-weight: 500;
    }

    .submit-order-btn:hover {
        background: #333;
        border-color: #333;
    }

    .submit-price {
        font-weight: 400;
    }

    /* Мобильная адаптация */
    @media (max-width: 768px) {
        .checkout-container {
            padding: 20px 15px;
        }

        .checkout-title {
            font-size: 24px;
            margin-bottom: 30px;
        }

        .order-summary {
            padding: 20px;
        }

        .item-quantity-price {
            flex-direction: column;
            align-items: flex-start;
            gap: 15px;
        }

        .item-price {
            align-self: flex-end;
        }

        .submit-order-btn {
            flex-direction: column;
            gap: 10px;
            text-align: center;
        }

        .payment-card {
            padding: 15px;
        }
    }
</style>
