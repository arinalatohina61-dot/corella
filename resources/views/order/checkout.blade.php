@extends('layout.layouts')
@section('title', 'Оформление заказа')

@section('content')
    <div class="checkout-container">

        <h1 class="checkout-title">Оформление заказа</h1>

        <div class="checkout-grid">
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
                                <span class="detail-value">
                                    @if(!empty($product->width) && !empty($product->height))
                                        {{ $product->width }}×{{ $product->height }} см
                                    @elseif(!empty($product->width))
                                        {{ $product->width }} см
                                    @elseif(!empty($product->height))
                                        {{ $product->height }} см
                                    @else
                                        Не указан
                                    @endif
                                </span>
                            </div>
                            @if(!empty($product->light_requirement))
                                <div class="detail-row">
                                    <span class="detail-label">Требования к освещению:</span>
                                    <span class="detail-value">{{ $product->light_requirement }}</span>
                                </div>
                            @endif
                            <div class="detail-row">
                                <span class="detail-label">Количество:</span>
                                <span class="detail-value">{{ $product->quantity }} шт.</span>
                            </div>
                        </div>

                        <div style="display:flex;align-items: center;justify-content: right">
                            <div>
                                <span class="item-total-price" style="font-weight: 500;">{{ number_format($product->price * $product->quantity, 0, ',', ' ') }} ₽</span>
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
                                <div class="payment-card selected">
                                    <div class="payment-icon">💳</div>
                                    <div class="payment-info">
                                        <div class="payment-title">Банковская карта</div>
                                        <div class="payment-desc">Оплата онлайн через платежный шлюз</div>
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

                        <div id="delivery-notice" style="display:none;margin-top:20px;padding:20px;background:#ffafaf1a;border:1px solid #eaeaea;border-radius:0px;color:#666;font-size:14px;">
                            <strong>📦 Обратите внимание:</strong> После подтверждения заказа наличными, вам потребуется пройти шаг оформления адреса доставки.
                        </div>
                    </div>

                    <div class="form-footer">
                        <button type="submit" class="submit-order-btn">
                            <span class="submit-text" id="submit-btn-text">ПЕРЕЙТИ К ОПЛАТЕ</span>
                            <span class="submit-price">{{ number_format($total, 0, ',', ' ') }} ₽</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.querySelectorAll('input[name="payment_method"]').forEach(radio => {
            radio.addEventListener('change', function() {
                const notice = document.getElementById('delivery-notice');
                const btnText = document.getElementById('submit-btn-text');

                document.querySelectorAll('.payment-card').forEach(card => {
                    card.classList.remove('selected');
                });

                this.closest('.payment-method').querySelector('.payment-card').classList.add('selected');

                if (this.value === 'cash') {
                    notice.style.display = 'block';
                    btnText.textContent = 'ПОДТВЕРДИТЬ ЗАКАЗ';
                } else {
                    notice.style.display = 'none';
                    btnText.textContent = 'ПЕРЕЙТИ К ОПЛАТЕ';
                }
            });
        });

        const checkedRadio = document.querySelector('input[name="payment_method"]:checked');
        if (checkedRadio) {
            checkedRadio.closest('.payment-method').querySelector('.payment-card').classList.add('selected');

            if (checkedRadio.value === 'cash') {
                document.getElementById('delivery-notice').style.display = 'block';
                document.getElementById('submit-btn-text').textContent = 'ПОДТВЕРДИТЬ ЗАКАЗ';
            } else {
                document.getElementById('delivery-notice').style.display = 'none';
                document.getElementById('submit-btn-text').textContent = 'ПЕРЕЙТИ К ОПЛАТЕ';
            }
        }
    </script>
@endsection

<style>
    /* Все ваши старые стили остаются нетронутыми */
    .checkout-contact-data { margin-bottom: 40px; }
    .contact-data-grid { display: flex; flex-direction: column; gap: 20px; }
    .contact-data-row { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
    @media (max-width: 768px) { .contact-data-row { grid-template-columns: 1fr; gap: 15px; } }
    .contact-data-item { display: flex; flex-direction: column; padding: 20px; border: 1px solid #eaeaea; background: #fafafa; min-height: 80px; justify-content: center; }
    .contact-data-label { font-size: 12px; font-weight: 500; color: #666; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 8px; }
    .contact-data-value { font-size: 16px; color: #000; font-weight: 400; line-height: 1.4; }

    .checkout-container { max-width: 1400px; margin: 0 auto; padding: 40px 20px; font-family: 'Helvetica Neue', Arial, sans-serif; color: #000; background: #fff; }
    .checkout-title { font-size: 32px; font-weight: 400; text-align: center; margin: 0 0 50px 0; letter-spacing: -0.5px; }
    .checkout-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 60px; max-width: 1200px; margin: 0 auto; }
    @media (max-width: 992px) { .checkout-grid { grid-template-columns: 1fr; gap: 40px; } }

    .order-summary { position: sticky; top: 40px; align-self: start; border: 1px solid #eaeaea; padding: 30px; background: #fff; }
    .summary-header { margin-bottom: 30px; padding-bottom: 20px; border-bottom: 1px solid #eaeaea; }
    .summary-title { font-size: 20px; font-weight: 500; margin: 0; letter-spacing: -0.3px; }
    .order-item { margin-bottom: 40px; padding-bottom: 30px; border-bottom: 1px solid #f5f5f5; }
    .item-header { margin-bottom: 20px; }
    .item-name { font-size: 18px; font-weight: 500; margin: 0 0 10px 0; }
    .item-details { margin-bottom: 25px; }
    .detail-row { display: flex; margin-bottom: 8px; font-size: 14px; line-height: 1.5; }
    .detail-label { min-width: 140px; color: #666; text-transform: lowercase; }
    .detail-value { color: #000; flex: 1; }

    .order-total { margin-bottom: 30px; }
    .total-row { display: flex; justify-content: space-between; align-items: center; font-size: 20px; padding: 15px 0; border-top: 1px solid #eaeaea; }
    .total-label { font-weight: 500; }
    .total-value { font-weight: 500; }
    .back-to-catalog { margin-top: 30px; padding-top: 30px; border-top: 1px solid #eaeaea; }
    .back-link { color: #000; text-decoration: none; font-size: 14px; font-weight: 500; letter-spacing: 1px; text-transform: uppercase; transition: color 0.3s ease; display: inline-flex; align-items: center; gap: 10px; }
    .back-link:hover { color: #666; }

    .form-section { margin-bottom: 40px; padding-bottom: 30px; border-bottom: 1px solid #eaeaea; }
    .form-section-title { font-size: 18px; font-weight: 500; margin: 0 0 25px 0; letter-spacing: -0.3px; }

    .payment-methods { display: flex; flex-direction: column; gap: 10px; }
    .payment-method { cursor: pointer; }
    .payment-input { display: none; }

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
    .payment-card.selected {
        border-color: #000;
        background: #fafafa;
        box-shadow: inset 0 0 0 1px #000;
    }

    .payment-icon { font-size: 24px; }
    .payment-info { flex: 1; }
    .payment-title { font-size: 16px; font-weight: 500; margin-bottom: 4px; }
    .payment-desc { font-size: 14px; color: #666; }

    .form-footer { margin-top: 40px; }
    .submit-order-btn { width: 100%; background: #000; color: #fff; border: 1px solid #000; padding: 20px; font-size: 16px; text-transform: uppercase; letter-spacing: 1px; cursor: pointer; transition: all 0.3s ease; display: flex; justify-content: space-between; align-items: center; font-weight: 500; }
    .submit-order-btn:hover { background: #333; border-color: #333; }
    .submit-price { font-weight: 400; }

    @media (max-width: 768px) {
        .checkout-container { padding: 20px 15px; }
        .checkout-title { font-size: 24px; margin-bottom: 30px; }
        .order-summary { padding: 20px; }
        .submit-order-btn { flex-direction: column; gap: 10px; text-align: center; }
        .payment-card { padding: 15px; }
    }
</style>
