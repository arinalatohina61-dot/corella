@extends('layout.layouts')
@section('title', 'Оформление доставки - Заказ №' . $order->code)

@section('content')
    <div class="delivery-form-page">
        <div class="container">
            <h1>Оформление доставки</h1>
            <p class="order-reference">Заказ №{{ $order->code }}</p>

            <form action="{{ route('delivery.store', $order) }}" method="POST">
                @csrf

                <div class="form-section">
                    <h2>Информация о получателе</h2>

                    <div class="form-group">
                        <label for="recipient_name">ФИО получателя *</label>
                        <input type="text" name="recipient_name" id="recipient_name"
                               value="{{ old('recipient_name') }}" required>
                        @error('recipient_name')
                        <span class="error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="phone">Телефон *</label>
                        <input type="tel" name="phone" id="phone"
                               value="{{ old('phone') }}" required
                               placeholder="+7 (___) ___-__-__">
                        @error('phone')
                        <span class="error">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="form-section">
                    <h2>Способ доставки</h2>

                    <div class="delivery-methods">
                        <label class="delivery-method">
                            <input type="radio" name="delivery_method" value="courier"
                                   {{ old('delivery_method', 'courier') == 'courier' ? 'checked' : '' }} required>
                            <div class="method-info">
                                <strong>Курьером по Магнитогорску</strong>
                                <span class="method-price">от 300 ₽ (бесплатно от 5000 ₽)</span>
                            </div>
                        </label>

                        <label class="delivery-method">
                            <input type="radio" name="delivery_method" value="pickup"
                                {{ old('delivery_method') == 'pickup' ? 'checked' : '' }}>
                            <div class="method-info">
                                <strong>Самовывоз</strong>
                                <span class="method-price">Бесплатно</span>
                            </div>
                        </label>
                    </div>
                </div>

                <div class="form-section" id="address-section">
                    <h2>Адрес доставки</h2>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="city">Город *</label>
                            <input type="text" name="city" id="city"
                                   value="Магнитогорск" readonly required
                                   style="background-color: #f5f5f5; cursor: not-allowed; color: #666;">
                        </div>

                        <div class="form-group">
                            <label for="district">Район доставки *</label>
                            <select name="district" id="district" required>
                                <option value="">Выберите район</option>
                                <option value="pravoberezhny" {{ old('district') == 'pravoberezhny' ? 'selected' : '' }}>Правобережный</option>
                                <option value="levoberezhny" {{ old('district') == 'levoberezhny' ? 'selected' : '' }}>Левобережный</option>
                                <option value="settlement" {{ old('district') == 'settlement' ? 'selected' : '' }}>Поселок</option>
                            </select>
                            @error('district')
                            <span class="error">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="address">Адрес (улица, дом, квартира) *</label>
                        <textarea name="address" id="address" rows="3" required
                                  placeholder="Улица, дом, квартира">{{ old('address') }}</textarea>
                        @error('address')
                        <span class="error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="delivery-cost-block">
                        <label class="cost-label">Итоговая стоимость доставки</label>
                        <div class="cost-value">
                            <span id="display-delivery-cost">0</span> ₽
                        </div>
                        <input type="hidden" name="delivery_cost" id="delivery_cost_input" value="0">
                        <small class="cost-hint">* Стоимость рассчитывается автоматически в зависимости от выбранного района и способа доставки</small>
                    </div>

                    <div class="form-group">
                        <label for="delivery_date">Желаемая дата доставки</label>
                        <input type="date" name="delivery_date" id="delivery_date"
                               value="{{ old('delivery_date') }}" min="{{ date('Y-m-d', strtotime('+1 day')) }}">
                    </div>

                    <div class="form-group">
                        <label for="delivery_notes">Комментарий к заказу</label>
                        <textarea name="delivery_notes" id="delivery_notes" rows="3"
                                  placeholder="Дополнительная информация для курьера">{{ old('delivery_notes') }}</textarea>
                    </div>
                </div>

                <div class="form-actions">
                    <a href="{{ route('profile.order.show', $order) }}" class="btn btn-secondary">
                        Назад к заказу
                    </a>
                    <button type="submit" class="btn btn-primary">
                        Подтвердить доставку
                    </button>
                </div>
            </form>
        </div>
    </div>

    <style>
        .delivery-form-page {
            max-width: 1200px;
            margin: 0 auto;
            padding: 40px 20px;
            font-family: 'Helvetica Neue', Arial, sans-serif;
            color: #000;
            background: #fff;
            min-height: 70vh;
        }

        .delivery-form-page .container {
            max-width: 800px;
            margin: 0 auto;
        }

        .delivery-form-page h1 {
            font-size: 32px;
            font-weight: 400;
            margin-bottom: 10px;
            letter-spacing: -0.5px;
        }

        .order-reference {
            font-size: 14px;
            color: #666;
            margin-bottom: 50px;
        }

        .form-section {
            margin-bottom: 40px;
            padding: 35px;
            border: 1px solid #eaeaea;
            background: #fff;
        }

        .form-section h2 {
            font-size: 20px;
            font-weight: 500;
            margin: 0 0 25px;
            padding-bottom: 15px;
            border-bottom: 1px solid #eaeaea;
        }

        .form-group {
            margin-bottom: 25px;
        }

        .form-group:last-child {
            margin-bottom: 0;
        }

        .form-group label {
            display: block;
            font-size: 13px;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 10px;
            color: #666;
        }

        .form-group input,
        .form-group textarea,
        .form-group select {
            width: 100%;
            padding: 15px;
            border: 1px solid #ddd;
            font-size: 15px;
            background: #fff;
            color: #000;
            transition: border-color 0.3s ease;
            box-sizing: border-box;
        }

        .form-group input:focus,
        .form-group textarea:focus,
        .form-group select:focus {
            outline: none;
            border-color: #000;
        }

        .form-group textarea {
            resize: vertical;
            min-height: 100px;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .delivery-methods {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .delivery-method {
            display: flex;
            align-items: flex-start;
            gap: 15px;
            padding: 20px;
            border: 1px solid #eaeaea;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .delivery-method:hover {
            border-color: #999;
            background: #fafafa;
        }

        .delivery-method input[type="radio"] {
            margin-top: 4px;
            accent-color: #000;
        }

        .method-info {
            display: flex;
            flex-direction: column;
            gap: 5px;
        }

        .method-info strong {
            font-size: 16px;
            font-weight: 500;
            color: #000;
        }

        .method-price {
            font-size: 14px;
            color: #666;
        }

        .delivery-cost-block {
            background: #f9f9f9;
            padding: 20px;
            border: 1px solid #eaeaea;
            margin-bottom: 25px;
        }

        .cost-label {
            display: block;
            font-size: 13px;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #666;
            margin-bottom: 5px;
        }

        .cost-value {
            font-size: 24px;
            font-weight: 500;
            color: #000;
        }

        .cost-hint {
            color: #666;
            font-size: 12px;
            display: block;
            margin-top: 5px;
        }

        .form-actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 20px;
            margin-top: 50px;
            padding-top: 30px;
            border-top: 1px solid #eaeaea;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 16px 32px;
            font-size: 14px;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 1px;
            text-decoration: none;
            border: 1px solid #000;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-primary {
            background: #000;
            color: #fff;
        }

        .btn-primary:hover {
            background: #fff;
            color: #000;
        }

        .btn-secondary {
            background: #fff;
            color: #000;
        }

        .btn-secondary:hover {
            background: #000;
            color: #fff;
        }

        .error {
            display: block;
            margin-top: 8px;
            font-size: 13px;
            color: #d32f2f;
        }

        input::placeholder,
        textarea::placeholder {
            color: #999;
        }

        /* ===== АДАПТИВНОСТЬ — ПЛАНШЕТЫ ===== */
        @media (max-width: 1024px) {
            .delivery-form-page {
                padding: 30px 16px;
            }

            .delivery-form-page h1 {
                font-size: 28px;
            }

            .order-reference {
                margin-bottom: 40px;
            }

            .form-section {
                padding: 30px 25px;
                margin-bottom: 30px;
            }

            .form-section h2 {
                font-size: 19px;
                margin-bottom: 22px;
            }

            .form-group {
                margin-bottom: 22px;
            }

            .form-group input,
            .form-group textarea,
            .form-group select {
                padding: 14px;
                font-size: 14px;
            }

            .delivery-method {
                padding: 18px;
            }

            .method-info strong {
                font-size: 15px;
            }

            .method-price {
                font-size: 13px;
            }

            .delivery-cost-block {
                padding: 18px;
            }

            .cost-value {
                font-size: 22px;
            }

            .form-actions {
                margin-top: 40px;
                padding-top: 25px;
            }

            .btn {
                padding: 15px 28px;
                font-size: 13px;
            }
        }

        /* ===== АДАПТИВНОСТЬ — МАЛЕНЬКИЕ ПЛАНШЕТЫ ===== */
        @media (max-width: 768px) {
            .delivery-form-page {
                padding: 24px 12px;
            }

            .delivery-form-page h1 {
                font-size: 24px;
            }

            .order-reference {
                font-size: 13px;
                margin-bottom: 30px;
            }

            .form-section {
                padding: 24px 20px;
                margin-bottom: 24px;
            }

            .form-section h2 {
                font-size: 18px;
                margin-bottom: 20px;
                padding-bottom: 12px;
            }

            .form-group {
                margin-bottom: 20px;
            }

            .form-group label {
                font-size: 12px;
                margin-bottom: 8px;
            }

            .form-group input,
            .form-group textarea,
            .form-group select {
                padding: 13px;
                font-size: 14px;
            }

            .form-group textarea {
                min-height: 80px;
            }

            /* Grid в одну колонку */
            .form-row {
                grid-template-columns: 1fr;
                gap: 0;
            }

            .delivery-methods {
                gap: 12px;
            }

            .delivery-method {
                padding: 16px;
                gap: 12px;
            }

            .delivery-method input[type="radio"] {
                margin-top: 3px;
            }

            .method-info strong {
                font-size: 15px;
            }

            .method-price {
                font-size: 13px;
            }

            .delivery-cost-block {
                padding: 16px;
                margin-bottom: 20px;
            }

            .cost-label {
                font-size: 12px;
            }

            .cost-value {
                font-size: 20px;
            }

            .cost-hint {
                font-size: 11px;
            }

            /* Кнопки в столбик */
            .form-actions {
                flex-direction: column;
                margin-top: 30px;
                padding-top: 20px;
                gap: 12px;
            }

            .btn {
                width: 100%;
                padding: 14px 24px;
                font-size: 13px;
            }

            .error {
                font-size: 12px;
                margin-top: 6px;
            }
        }

        /* ===== АДАПТИВНОСТЬ — МОБИЛЬНЫЕ ===== */
        @media (max-width: 480px) {
            .delivery-form-page {
                padding: 20px 10px;
            }

            .delivery-form-page h1 {
                font-size: 22px;
                letter-spacing: 0;
            }

            .order-reference {
                font-size: 12px;
                margin-bottom: 24px;
            }

            .form-section {
                padding: 20px 16px;
                margin-bottom: 20px;
            }

            .form-section h2 {
                font-size: 17px;
                margin-bottom: 18px;
                padding-bottom: 10px;
            }

            .form-group {
                margin-bottom: 18px;
            }

            .form-group label {
                font-size: 11px;
                margin-bottom: 7px;
                letter-spacing: 0.8px;
            }

            .form-group input,
            .form-group textarea,
            .form-group select {
                padding: 12px;
                font-size: 14px;
            }

            .form-group textarea {
                min-height: 70px;
            }

            .delivery-methods {
                gap: 10px;
            }

            .delivery-method {
                padding: 14px;
                gap: 10px;
            }

            .delivery-method input[type="radio"] {
                margin-top: 2px;
                flex-shrink: 0;
            }

            .method-info {
                gap: 3px;
            }

            .method-info strong {
                font-size: 14px;
                line-height: 1.3;
            }

            .method-price {
                font-size: 12px;
            }

            .delivery-cost-block {
                padding: 14px;
                margin-bottom: 18px;
            }

            .cost-label {
                font-size: 11px;
                letter-spacing: 0.8px;
            }

            .cost-value {
                font-size: 20px;
            }

            .cost-hint {
                font-size: 11px;
                line-height: 1.4;
            }

            .form-actions {
                margin-top: 24px;
                padding-top: 16px;
                gap: 10px;
            }

            .btn {
                padding: 13px 20px;
                font-size: 12px;
                letter-spacing: 0.8px;
            }

            .error {
                font-size: 11px;
                margin-top: 5px;
            }
        }

        /* ===== АДАПТИВНОСТЬ — ОЧЕНЬ МАЛЕНЬКИЕ ЭКРАНЫ ===== */
        @media (max-width: 360px) {
            .delivery-form-page {
                padding: 16px 8px;
            }

            .delivery-form-page h1 {
                font-size: 20px;
            }

            .order-reference {
                font-size: 11px;
                margin-bottom: 20px;
            }

            .form-section {
                padding: 16px 12px;
                margin-bottom: 16px;
            }

            .form-section h2 {
                font-size: 16px;
                margin-bottom: 16px;
            }

            .form-group {
                margin-bottom: 16px;
            }

            .form-group label {
                font-size: 11px;
                margin-bottom: 6px;
            }

            .form-group input,
            .form-group textarea,
            .form-group select {
                padding: 11px;
                font-size: 13px;
            }

            .delivery-method {
                padding: 12px;
                gap: 8px;
            }

            .method-info strong {
                font-size: 13px;
            }

            .method-price {
                font-size: 11px;
            }

            .delivery-cost-block {
                padding: 12px;
            }

            .cost-value {
                font-size: 18px;
            }

            .btn {
                padding: 12px 16px;
                font-size: 11px;
            }
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const districtSelect = document.getElementById('district');
            const deliveryMethods = document.querySelectorAll('input[name="delivery_method"]');
            const displayCost = document.getElementById('display-delivery-cost');
            const hiddenCostInput = document.getElementById('delivery_cost_input');

            const courierPrices = {
                'pravoberezhny': 300,
                'levoberezhny': 500,
                'settlement': 700
            };

            const pickupPrice = 0;

            function calculateDeliveryCost() {
                const selectedMethod = document.querySelector('input[name="delivery_method"]:checked').value;
                const selectedDistrict = districtSelect.value;
                let cost = 0;

                if (selectedMethod === 'pickup') {
                    cost = pickupPrice;
                } else if (selectedMethod === 'courier') {
                    if (selectedDistrict && courierPrices[selectedDistrict] !== undefined) {
                        cost = courierPrices[selectedDistrict];
                    } else {
                        cost = 0;
                    }
                }

                displayCost.textContent = cost;
                hiddenCostInput.value = cost;
            }

            districtSelect.addEventListener('change', calculateDeliveryCost);
            deliveryMethods.forEach(radio => {
                radio.addEventListener('change', calculateDeliveryCost);
            });

            calculateDeliveryCost();
        });
    </script>
@endsection
