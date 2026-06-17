@extends('layout.layouts')
@section('title', 'Доставка заказа №' . $order->code)

@section('content')
    <div class="delivery-detail-page">
        <div class="container">
            <h1>Информация о доставке</h1>
            <p class="order-reference">Заказ №{{ $order->code }}</p>

            @if($delivery)
                <div class="delivery-info-grid">
                    <div class="info-section">
                        <h2>Получатель</h2>
                        <div class="info-card">
                            <div class="info-label">ФИО</div>
                            <div class="info-value">{{ $delivery->recipient_name }}</div>
                        </div>
                        <div class="info-card">
                            <div class="info-label">Телефон</div>
                            <div class="info-value">{{ $delivery->phone }}</div>
                        </div>
                    </div>

                    <div class="info-section">
                        <h2>Способ доставки</h2>
                        <div class="info-card">
                            <div class="info-label">Метод</div>
                            <div class="info-value">{{ $delivery->getDeliveryMethodLabel() }}</div>
                        </div>
                        <div class="info-card">
                            <div class="info-label">Стоимость</div>
                            <div class="info-value">{{ number_format($delivery->delivery_cost, 0, ',', ' ') }} ₽</div>
                        </div>
                        <div class="info-card">
                            <div class="info-label">Статус</div>
                            <div class="delivery-status {{ $delivery->delivery_status }}">
                                {{ $delivery->getDeliveryStatusLabel() }}
                            </div>
                        </div>
                    </div>

                    <div class="info-section full-width">
                        <h2>Адрес доставки</h2>
                        <div class="info-card">
                            <div class="info-label">Город</div>
                            <div class="info-value">{{ $delivery->city }}</div>
                        </div>

                        @if(!empty($delivery->district))
                            <div class="info-card">
                                <div class="info-label">Район</div>
                                <div class="info-value">
                                    @if($delivery->district == 'pravoberezhny')
                                        Правобережный
                                    @elseif($delivery->district == 'levoberezhny')
                                        Левобережный
                                    @elseif($delivery->district == 'settlement')
                                        Поселок / Пригород
                                    @else
                                        {{ ucfirst($delivery->district) }}
                                    @endif
                                </div>
                            </div>
                        @endif

                        <div class="info-card">
                            <div class="info-label">Адрес</div>
                            <div class="info-value">{{ $delivery->address }}</div>
                        </div>

                        @if($delivery->postal_code)
                            <div class="info-card">
                                <div class="info-label">Индекс</div>
                                <div class="info-value">{{ $delivery->postal_code }}</div>
                            </div>
                        @endif

                        @if($delivery->delivery_date)
                            <div class="info-card">
                                <div class="info-label">Желаемая дата</div>
                                <div class="info-value">{{ \Carbon\Carbon::parse($delivery->delivery_date)->format('d.m.Y') }}</div>
                            </div>
                        @endif

                        @if($delivery->tracking_number)
                            <div class="info-card">
                                <div class="info-label">Трекер-номер</div>
                                <div class="info-value">{{ $delivery->tracking_number }}</div>
                            </div>
                        @endif

                        @if($delivery->delivery_notes)
                            <div class="info-card">
                                <div class="info-label">Комментарий</div>
                                <div class="info-value">{{ $delivery->delivery_notes }}</div>
                            </div>
                        @endif
                    </div>
                </div>

                @if($delivery->delivery_status !== 'delivered' && $delivery->delivery_status !== 'cancelled')
                    <div class="delivery-actions" style="margin-top: 30px;">
                        <a href="{{ route('delivery.edit', $order) }}" class="btn btn-primary">
                            Изменить доставку
                        </a>
                    </div>
                @endif

            @else
                <div class="no-delivery">
                    <p>Информация о доставке еще не добавлена</p>
                    <a href="{{ route('delivery.create', $order) }}" class="btn btn-primary">
                        Оформить доставку
                    </a>
                </div>
            @endif

            <div class="back-link" style="margin-top: 40px;">
                <a href="{{ route('profile.order.show', $order) }}" style="color: #666; text-decoration: none; font-size: 14px;">← Вернуться к заказу</a>
            </div>
        </div>
    </div>

    <style>
        /* Стили оставлены идентичными вашему исходному коду для сохранения дизайна */
        .delivery-detail-page {
            max-width: 1200px;
            margin: 0 auto;
            padding: 40px 20px;
            font-family: 'Helvetica Neue', Arial, sans-serif;
            color: #000;
            background: #fff;
            min-height: 70vh;
        }

        .delivery-detail-page .container {
            max-width: 800px;
            margin: 0 auto;
        }

        .delivery-detail-page h1 {
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

        .delivery-info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
        }

        .info-section {
            padding: 35px;
            border: 1px solid #eaeaea;
            background: #fff;
        }

        .info-section.full-width {
            grid-column: 1 / -1;
        }

        .info-section h2 {
            font-size: 20px;
            font-weight: 500;
            margin: 0 0 25px;
            padding-bottom: 15px;
            border-bottom: 1px solid #eaeaea;
        }

        .info-card {
            margin-bottom: 20px;
        }

        .info-card:last-child {
            margin-bottom: 0;
        }

        .info-label {
            font-size: 12px;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: #666;
            margin-bottom: 5px;
        }

        .info-value {
            font-size: 16px;
            color: #000;
            font-weight: 400;
            word-break: break-word;
        }

        .delivery-status {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 4px;
            font-size: 13px;
            font-weight: 500;
            text-transform: uppercase;
        }

        .delivery-status.pending { background: #fff3cd; color: #856404; }
        .delivery-status.processing { background: #cce5ff; color: #004085; }
        .delivery-status.delivered { background: #d4edda; color: #155724; }
        .delivery-status.cancelled { background: #f8d7da; color: #721c24; }

        .delivery-actions {
            grid-column: 1 / -1;
            display: flex;
            justify-content: flex-end;
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

        .no-delivery {
            text-align: center;
            padding: 60px 20px;
            border: 1px solid #eaeaea;
        }

        .no-delivery p {
            font-size: 16px;
            color: #666;
            margin-bottom: 30px;
        }

        /* ===== АДАПТИВНОСТЬ ===== */

        /* Планшеты и небольшие десктопы */
        @media (max-width: 992px) {
            .delivery-detail-page {
                padding: 35px 20px;
            }

            .delivery-detail-page h1 {
                font-size: 28px;
            }

            .order-reference {
                margin-bottom: 40px;
            }

            .delivery-info-grid {
                gap: 25px;
            }

            .info-section {
                padding: 30px;
            }

            .info-section h2 {
                font-size: 18px;
                margin-bottom: 20px;
            }
        }

        /* Планшеты в портретной ориентации */
        @media (max-width: 768px) {
            .delivery-detail-page {
                padding: 30px 15px;
            }

            .delivery-detail-page h1 {
                font-size: 26px;
            }

            .order-reference {
                font-size: 13px;
                margin-bottom: 35px;
            }

            .delivery-info-grid {
                grid-template-columns: 1fr;
                gap: 20px;
            }

            .info-section {
                padding: 25px 20px;
            }

            .info-section h2 {
                font-size: 18px;
                margin-bottom: 20px;
                padding-bottom: 12px;
            }

            .info-value {
                font-size: 15px;
            }

            .delivery-actions {
                justify-content: center;
            }

            .btn {
                width: 100%;
                padding: 14px 28px;
            }

            .no-delivery {
                padding: 50px 20px;
            }

            .no-delivery p {
                font-size: 15px;
            }

            .back-link {
                margin-top: 30px !important;
            }
        }

        /* Мобильные устройства */
        @media (max-width: 576px) {
            .delivery-detail-page {
                padding: 25px 12px;
            }

            .delivery-detail-page h1 {
                font-size: 24px;
                margin-bottom: 8px;
            }

            .order-reference {
                font-size: 12px;
                margin-bottom: 30px;
            }

            .info-section {
                padding: 20px 18px;
            }

            .info-section h2 {
                font-size: 17px;
                margin-bottom: 18px;
                padding-bottom: 10px;
            }

            .info-card {
                margin-bottom: 18px;
            }

            .info-label {
                font-size: 11px;
                letter-spacing: 0.8px;
            }

            .info-value {
                font-size: 14px;
            }

            .delivery-status {
                font-size: 12px;
                padding: 5px 10px;
            }

            .btn {
                padding: 13px 24px;
                font-size: 13px;
                letter-spacing: 0.8px;
            }

            .no-delivery {
                padding: 40px 15px;
            }

            .no-delivery p {
                font-size: 14px;
                margin-bottom: 25px;
            }

            .back-link {
                margin-top: 25px !important;
            }

            .back-link a {
                font-size: 13px !important;
            }
        }

        /* Маленькие мобильные устройства */
        @media (max-width: 480px) {
            .delivery-detail-page {
                padding: 20px 10px;
            }

            .delivery-detail-page h1 {
                font-size: 22px;
            }

            .order-reference {
                margin-bottom: 25px;
            }

            .info-section {
                padding: 18px 15px;
            }

            .info-section h2 {
                font-size: 16px;
                margin-bottom: 15px;
            }

            .info-card {
                margin-bottom: 15px;
            }

            .info-label {
                font-size: 10px;
                margin-bottom: 4px;
            }

            .info-value {
                font-size: 13px;
            }

            .delivery-status {
                font-size: 11px;
                padding: 4px 8px;
            }

            .btn {
                padding: 12px 20px;
                font-size: 12px;
            }

            .no-delivery {
                padding: 35px 12px;
            }

            .no-delivery p {
                font-size: 13px;
            }

            .back-link a {
                font-size: 12px !important;
            }
        }

        /* Очень маленькие экраны */
        @media (max-width: 360px) {
            .delivery-detail-page h1 {
                font-size: 20px;
            }

            .info-section {
                padding: 15px 12px;
            }

            .info-section h2 {
                font-size: 15px;
            }

            .info-value {
                font-size: 12px;
            }

            .btn {
                padding: 11px 18px;
                font-size: 11px;
            }
        }
    </style>
@endsection
