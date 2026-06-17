@extends('users.layout')

@section('content')
    <style>
        :root {
            --bg-main: #f8f9fa;
            --bg-card: #ffffff;
            --bg-hover: #f5f5f5;
            --bg-active: #f0f0f0;
            --bg-dark: #333333;
            --bg-light: #fafafa;
            --border: #e0e0e0;
            --border-dark: #d0d0d0;
            --text-primary: #1a1a1a;
            --text-secondary: #666666;
            --text-muted: #999999;
            --text-light: #cccccc;
            --accent-primary: #333333;
            --accent-hover: #1a1a1a;
            --success: #10b981;
            --danger: #ef4444;
            --warning: #f59e0b;
            --info: #3b82f6;
            --new: #3b82f6;
            --process: #f59e0b;
            --completed: #10b981;
            --cancelled: #ef4444;
            --shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
            --shadow-hover: 0 4px 12px rgba(0, 0, 0, 0.08);
            --shadow-card: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            background: var(--bg-main);
            color: var(--text-primary);
            line-height: 1.5;
        }

        .container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 20px;
        }

        /* ШАПКА */
        .content_row {
            padding: 30px 0;
        }

        .content_row h3 {
            font-size: 28px;
            font-weight: 700;
            color: var(--text-primary);
            margin: 0;
        }

        /* СЕТКА ЗАКАЗОВ */
        .products-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(380px, 1fr));
            gap: 20px;
            margin: 30px 0;
        }

        /* КАРТОЧКА ЗАКАЗА */
        .order-card {
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 24px;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .order-card:hover {
            border-color: var(--border-dark);
            box-shadow: var(--shadow-hover);
            transform: translateY(-2px);
        }

        /* ИНДИКАТОР СТАТУСА */
        .status-badge {
            position: absolute;
            top: 0;
            right: 0;
            padding: 8px 16px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-radius: 0 12px 0 12px;
            color: white;
        }

        .status-new {
            background: var(--new);
        }

        .status-process {
            background: var(--process);
        }

        .status-completed {
            background: var(--completed);
        }

        .status-cancelled {
            background: var(--cancelled);
        }

        /* ИНФОРМАЦИЯ О КЛИЕНТЕ */
        .client-info {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 20px;
            padding-bottom: 16px;
            border-bottom: 1px solid var(--border);
        }

        .client-avatar {
            width: 40px;
            height: 40px;
            background: var(--bg-dark);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            font-size: 16px;
        }

        .client-details {
            flex: 1;
        }

        .client-name {
            font-size: 18px;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 4px;
        }

        .order-id {
            font-size: 13px;
            color: var(--text-muted);
            font-family: 'Courier New', monospace;
            background: var(--bg-light);
            padding: 2px 6px;
            border-radius: 4px;
            border: 1px solid var(--border);
        }

        /* ДЕТАЛИ ЗАКАЗА */
        .order-details {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 16px;
            margin-bottom: 24px;
        }

        .detail-item {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .detail-label {
            font-size: 12px;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-weight: 600;
        }

        .detail-value {
            font-size: 14px;
            color: var(--text-primary);
            font-weight: 500;
        }

        .detail-value b {
            font-weight: 700;
            color: var(--text-primary);
        }

        .detail-value.total {
            font-size: 16px;
            font-weight: 700;
            color: var(--accent-primary);
        }

        .detail-value.payment {
            padding: 4px 8px;
            background: var(--bg-light);
            border-radius: 4px;
            display: inline-block;
            font-size: 12px;
            font-weight: 600;
        }

        /* ФОРМА ИЗМЕНЕНИЯ СТАТУСА */
        .status-form {
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid var(--border);
        }

        .form-group {
            margin-bottom: 16px;
        }

        .form-control {
            width: 100%;
            padding: 10px 14px;
            border: 1px solid var(--border);
            border-radius: 8px;
            font-size: 14px;
            font-family: inherit;
            color: var(--text-primary);
            background: var(--bg-card);
            transition: all 0.2s ease;
            cursor: pointer;
        }

        .form-control:hover {
            border-color: var(--border-dark);
        }

        .form-control:focus {
            outline: none;
            border-color: var(--accent-primary);
            box-shadow: 0 0 0 3px rgba(0, 0, 0, 0.05);
        }

        .status-select {
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='%231a1a1a' viewBox='0 0 16 16'%3E%3Cpath d='M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 14px center;
            background-size: 12px;
            padding-right: 36px;
        }

        /* ПРИЧИНА ОТМЕНЫ */
        .cancel-reason-block {
            margin-top: 16px;
            padding: 16px;
            background: var(--bg-light);
            border-radius: 8px;
            border: 1px solid var(--border);
            animation: slideDown 0.3s ease;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .cancel-reason-block label {
            display: block;
            margin-bottom: 8px;
            font-size: 13px;
            font-weight: 600;
            color: var(--danger);
        }

        .cancel-reason-block textarea {
            min-height: 80px;
            resize: vertical;
        }

        /* КНОПКИ */
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 12px 24px;
            font-size: 14px;
            font-weight: 600;
            text-decoration: none;
            border-radius: 8px;
            transition: all 0.2s ease;
            cursor: pointer;
            border: 1px solid transparent;
            gap: 8px;
            width: 100%;
        }

        .btn-primary {
            background: var(--accent-primary);
            color: white;
            border-color: var(--accent-primary);
        }

        .btn-primary:hover {
            background: var(--accent-hover);
            border-color: var(--accent-hover);
            transform: translateY(-1px);
            box-shadow: var(--shadow);
        }

        .btn-primary:active {
            transform: translateY(0);
        }

        .btn-primary:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
        }

        /* УВЕДОМЛЕНИЯ */
        .alert {
            padding: 16px 20px;
            border-radius: 8px;
            margin: 20px 0;
            font-size: 14px;
            border: 1px solid transparent;
            animation: slideDown 0.3s ease;
        }

        .alert-success {
            background: rgba(16, 185, 129, 0.1);
            border-color: rgba(16, 185, 129, 0.2);
            color: var(--success);
        }

        .alert-danger {
            background: rgba(239, 68, 68, 0.1);
            border-color: rgba(239, 68, 68, 0.2);
            color: var(--danger);
        }

        /* ПУСТОЙ СПИСОК */
        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: var(--text-muted);
            background: var(--bg-card);
            border-radius: 12px;
            border: 1px solid var(--border);
            margin: 40px 0;
        }

        .empty-state svg {
            width: 64px;
            height: 64px;
            margin-bottom: 20px;
            opacity: 0.5;
            stroke: currentColor;
        }

        /* ФИЛЬТРЫ И ПОИСК */
        .orders-toolbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin: 20px 0;
            gap: 20px;
            flex-wrap: wrap;
        }

        .stats-summary {
            display: flex;
            gap: 16px;
        }

        .stat-item {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 8px 16px;
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: 8px;
            font-size: 13px;
            font-weight: 600;
        }

        .stat-count {
            color: var(--accent-primary);
            font-size: 18px;
            font-weight: 700;
        }

        .filters {
            display: flex;
            gap: 8px;
        }

        .filter-btn {
            padding: 8px 16px;
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: 6px;
            font-size: 13px;
            color: var(--text-secondary);
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .filter-btn:hover,
        .filter-btn.active {
            background: var(--accent-primary);
            color: white;
            border-color: var(--accent-primary);
        }

        /* АНИМАЦИИ */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .order-card {
            animation: fadeIn 0.3s ease-out;
            animation-fill-mode: both;
        }

        .order-card:nth-child(odd) {
            animation-delay: 0.1s;
        }

        .order-card:nth-child(even) {
            animation-delay: 0.2s;
        }

        /* ПАГИНАЦИЯ */
        .pagination {
            display: flex;
            justify-content: center;
            gap: 8px;
            margin: 40px 0 20px;
        }

        .page-link {
            padding: 8px 14px;
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: 6px;
            color: var(--text-primary);
            text-decoration: none;
            font-size: 14px;
            transition: all 0.2s ease;
        }

        .page-link:hover {
            background: var(--bg-hover);
            border-color: var(--border-dark);
        }

        .page-link.active {
            background: var(--accent-primary);
            color: white;
            border-color: var(--accent-primary);
        }

        .page-link.disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        /* АДАПТИВНОСТЬ */
        @media (max-width: 768px) {
            .container {
                padding: 0 15px;
            }

            .content_row {
                padding: 20px 0;
            }

            .content_row h3 {
                font-size: 24px;
            }

            .products-grid {
                grid-template-columns: 1fr;
                gap: 16px;
            }

            .order-details {
                grid-template-columns: 1fr;
                gap: 12px;
            }

            .orders-toolbar {
                flex-direction: column;
                align-items: stretch;
            }

            .stats-summary {
                justify-content: center;
                flex-wrap: wrap;
            }

            .filters {
                overflow-x: auto;
                padding-bottom: 10px;
            }
        }

        @media (max-width: 480px) {
            .order-card {
                padding: 20px;
            }

            .client-info {
                flex-direction: column;
                align-items: flex-start;
                gap: 8px;
            }

            .client-avatar {
                width: 32px;
                height: 32px;
                font-size: 14px;
            }

            .btn {
                padding: 10px 20px;
                font-size: 13px;
            }

            .status-badge {
                font-size: 10px;
                padding: 6px 12px;
            }
        }

        /* ИКОНКИ ДЛЯ ПЛАТЕЖНЫХ МЕТОДОВ */
        .payment-icon {
            display: inline-block;
            margin-right: 6px;
            font-size: 12px;
        }

        .cash:before {
            content: "💵";
        }

        .card:before {
            content: "💳";
        }

        .online:before {
            content: "🌐";
        }

        /* ТАЙМЛАЙН */
        .timeline {
            margin-top: 16px;
            padding: 12px;
            background: var(--bg-light);
            border-radius: 8px;
            border: 1px solid var(--border);
        }

        .timeline-item {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 12px;
            color: var(--text-muted);
            margin-bottom: 6px;
        }

        .timeline-item:last-child {
            margin-bottom: 0;
        }

        .timeline-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: var(--border);
        }

        .timeline-dot.active {
            background: var(--accent-primary);
        }
    </style>

    <div class="container">
        <div class="content_row">
            @auth
                <div class="orders-toolbar">
                    <div style="display: flex; align-items: center; gap: 20px;">
                        <h3>Управление заказами</h3>
                    </div>
                </div>
            @endauth

            @if(session()->has('success'))
                <div class="alert alert-success">
                    <span>✅</span>
                    {{ session()->get('success') }}
                </div>
            @endif

            @if(session()->has('error'))
                <div class="alert alert-danger">
                    <span>⚠️</span>
                    {{ session()->get('error') }}
                </div>
            @endif
        </div>

        @if($orders->count() > 0)
            <div class="products-grid" id="ordersGrid">
                @foreach($orders as $order)
                    @php
                        $statusClass = '';
                        switch($order->status) {
                            case 'новый': $statusClass = 'status-new'; break;
                            case 'в процессе': $statusClass = 'status-process'; break;
                            case 'завершенный': $statusClass = 'status-completed'; break;
                            case 'отмененный': $statusClass = 'status-cancelled'; break;
                        }

                        $paymentIcon = '';
                        switch($order->payment_method) {
                            case 'наличные': $paymentIcon = 'cash'; break;
                            case 'карта': $paymentIcon = 'card'; break;
                            case 'онлайн': $paymentIcon = 'online'; break;
                        }

                        $avatarLetter = mb_strtoupper(mb_substr($order->client->name, 0, 1));
                    @endphp

                    <div class="order-card" data-status="{{ $order->status }}" data-order-id="{{ $order->id }}">
                        <div class="status-badge {{ $statusClass }}">
                            {{ $order->status }}
                        </div>

                        <div class="client-info">
                            <div class="client-avatar">
                                {{ $avatarLetter }}
                            </div>
                            <div class="client-details">
                                <div class="client-name">{{ $order->client->name }}</div>
                                <div class="order-id">Заказ #{{ $order->id }}</div>
                            </div>
                        </div>

                        <div class="order-details">
                            <div class="detail-item">
                                <span class="detail-label">Дата заказа</span>
                                <span class="detail-value">
                                    {{ $order->created_at->format('d.m.Y H:i') }}
                                </span>
                            </div>

                            <div class="detail-item">
                                <span class="detail-label">Сумма заказа</span>
                                <span class="detail-value total">
                                    {{ number_format($order->total_amount, 2, '.', ' ') }} ₽
                                </span>
                            </div>

                            <div class="detail-item">
                                <span class="detail-label">Способ оплаты</span>
                                <span class="detail-value">
                                    <span class="payment-icon {{ $paymentIcon }}"></span>
                                    {{ $order->payment_method }}
                                </span>
                            </div>

                            <div class="detail-item">
                                <span class="detail-label">Текущий статус </span>
                                <span class="detail-value">
                                    <b>{{ $order->status }}</b>
                                </span>
                            </div>
                        </div>

                        @php
                            $user = auth()->user();
                            $updateRoute = null;

                            if($user) {
                                $roleName = strtolower($user->role->name);
                                if($roleName === 'admin') {
                                    $updateRoute = route('admin.order.update', $order);
                                } elseif($roleName === 'manager') {
                                    $updateRoute = route('staff.order.update', $order);
                                }
                            }
                        @endphp

                        @if(!$user)
                            <a href="{{ route('staff.login') }}">Вход</a>
                        @else
                            <form action="{{ $updateRoute }}" method="post"  class="status-form">
                                @csrf
                                @method('PATCH')

                                <div class="form-group">
                                    <select name="status" class="form-control status-select"
                                            data-order="{{ $order->id }}"
                                            onchange="updateStatusSelect(this)">
                                        <option value="новый" {{ $order->status === 'новый' ? 'selected' : '' }}>Новый заказ</option>
                                        <option value="в процессе" {{ $order->status === 'в процессе' ? 'selected' : '' }}>В процессе</option>
                                        <option value="завершенный" {{ $order->status === 'завершенный' ? 'selected' : '' }}>Завершенный</option>
                                        <option value="отмененный" {{ $order->status === 'отмененный' ? 'selected' : '' }}>Отмененный</option>
                                    </select>
                                </div>

                                <div class="cancel-reason-block" style="{{ $order->status === 'отмененный' ? '' : 'display:none;' }}">
                                    <label>Причина отмены:</label>
                                    <textarea name="cancel" class="form-control" rows="2"
                                              placeholder="Укажите причину отмены заказа...">{{ $order->cancel }}</textarea>
                                </div>

                                <button type="submit" class="btn btn-primary" onclick="submitStatusForm(this)">
                                    <span>Обновить статус</span>
                                </button>
                            </form>
                        @endif
                    </div>
                @endforeach
            </div>

            <p>{{ $updateRoute }}</p>
        @else
            <div class="empty-state">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                          d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
                <h3 style="margin-bottom: 10px; color: var(--text-primary);">Заказы не найдены</h3>
                <p style="color: var(--text-muted);">Когда поступят новые заказы, они появятся здесь</p>
            </div>
        @endif

        <script>
            window.updateStatusSelect = function(select) {
                const form = select.closest('form');
                const cancelBlock = form.querySelector('.cancel-reason-block');
                const btn = form.querySelector('.btn-primary');

                if (select.value === 'отмененный') {
                    cancelBlock.style.display = '';
                    btn.innerHTML = '<span></span><span>Отменить заказ</span>';
                } else {
                    cancelBlock.style.display = 'none';
                    btn.innerHTML = '<span></span><span>Обновить статус</span>';
                }

                // Подсветка опции
                const options = select.querySelectorAll('option');
                options.forEach(opt => {
                    opt.style.backgroundColor = '';
                });
                select.querySelector('option:checked').style.backgroundColor = 'var(--bg-hover)';
            };
        </script>
    </div>
@endsection
