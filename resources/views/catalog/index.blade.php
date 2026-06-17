@extends('users.layout')

@section('content')
    <style>
        :root {
            --admin-bg: #f5f7fa;
            --admin-card: #ffffff;
            --admin-border: #e4e7eb;
            --admin-primary: #4f46e5;
            --admin-primary-hover: #4338ca;
            --admin-secondary: #6b7280;
            --admin-success: #10b981;
            --admin-danger: #ef4444;
            --admin-warning: #f59e0b;
            --admin-info: #3b82f6;
            --admin-text: #1f2937;
            --admin-text-light: #6b7280;
            --admin-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            --admin-shadow-lg: 0 10px 25px rgba(0, 0, 0, 0.1);
            --admin-radius: 8px;
            --admin-radius-sm: 4px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
        }

        body {
            background-color: var(--admin-bg);
            color: var(--admin-text);
            line-height: 1.6;
            min-height: 100vh;
        }

        .admin-container {
            max-width: 1600px;
            margin: 0 auto;
            padding: 30px;
        }

        /* Header стили */
        .admin-header {
            background: var(--admin-card);
            padding: 24px 30px;
            border-radius: var(--admin-radius);
            box-shadow: var(--admin-shadow);
            margin-bottom: 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 20px;
            border-left: 4px solid var(--admin-primary);
            position: relative;
            overflow: hidden;
        }

        .admin-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 3px;
            background: linear-gradient(90deg, var(--admin-primary), var(--admin-info));
        }

        .admin-header h3 {
            font-size: 1.75rem;
            font-weight: 700;
            color: var(--admin-text);
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .admin-header h3::before {
            content: '📦';
            font-size: 1.5rem;
        }

        .header-stats {
            display: flex;
            gap: 20px;
            font-size: 0.9rem;
            color: var(--admin-text-light);
        }

        .stat-item {
            display: flex;
            align-items: center;
            gap: 6px;
            padding: 6px 12px;
            background: var(--admin-bg);
            border-radius: var(--admin-radius-sm);
        }

        /* Кнопки */
        .btn {
            padding: 10px 24px;
            border: none;
            border-radius: var(--admin-radius-sm);
            font-weight: 600;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.2s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
            white-space: nowrap;
        }

        .btn-primary {
            background: #333;
            color: white;
        }

        .btn-primary:hover {
            background: var(--admin-primary-hover);
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(79, 70, 229, 0.4);
        }

        .btn-sm {
            padding: 6px 12px;
            font-size: 12px;
        }

        .btn-edit {
            background: var(--admin-info);
            color: white;
            border: 1px solid var(--admin-info);
        }

        .btn-delete {
            background: white;
            color: var(--admin-danger);
            border: 1px solid var(--admin-danger);
        }

        .btn-edit:hover {
            background: #2563eb;
            border-color: #2563eb;
        }

        .btn-delete:hover {
            background: var(--admin-danger);
            color: white;
        }

        .btn-group {
            display: flex;
            gap: 10px;
            align-items: center;
        }

        /* Контейнер страницы */
        .page-container {
            padding-top: 50px;
        }

        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            gap: 16px;
            flex-wrap: wrap;
        }

        .page-header h3 {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--admin-text);
            margin: 0;
        }

        /* Карточки товаров */
        .products-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .product-card {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 15px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            transition: all 0.3s ease;
            background: var(--admin-card);
        }

        .product-card:hover {
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            transform: translateY(-2px);
        }

        .product-image {
            text-align: center;
            margin-bottom: 10px;
            background: #fff;
            border-radius: 5px;
            overflow: hidden;
        }

        .product-image img {
            max-width: 100%;
            max-height: 150px;
            object-fit: cover;
            border-radius: 5px;
            transition: transform 0.3s ease;
        }

        .product-card:hover .product-image img {
            transform: scale(1.05);
        }

        .no-image {
            width: 100%;
            height: 150px;
            background: #f0f0f0;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 5px;
            color: var(--admin-text-light);
            font-size: 14px;
        }

        .product-card h4 {
            margin: 5px 0;
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--admin-text);
            line-height: 1.4;
        }

        .product-card p {
            margin: 5px 0;
        }

        .product-description {
            font-size: 0.9rem;
            color: #555;
            line-height: 1.5;
        }

        .product-price {
            font-weight: 600;
            font-size: 1rem;
            color: var(--admin-text);
        }

        .product-category {
            font-size: 0.8rem;
            color: #777;
        }

        .product-actions {
            display: flex;
            justify-content: space-between;
            margin-top: 10px;
            gap: 10px;
        }

        .product-actions form {
            margin: 0;
            flex: 1;
        }

        .product-actions .btn {
            width: 100%;
            justify-content: center;
        }

        /* Уведомления */
        .alert {
            padding: 16px 24px;
            border-radius: var(--admin-radius-sm);
            margin-bottom: 24px;
            border-left: 4px solid transparent;
            background: var(--admin-card);
            box-shadow: var(--admin-shadow);
            display: flex;
            align-items: center;
            gap: 12px;
            animation: slideIn 0.3s ease;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .alert-success {
            border-left-color: var(--admin-success);
            background: linear-gradient(90deg, #ecfdf5, #d1fae5);
        }

        .alert-danger {
            border-left-color: var(--admin-danger);
            background: linear-gradient(90deg, #fef2f2, #fee2e2);
        }

        .alert::before {
            font-size: 1.2rem;
        }

        .alert-success::before {
            content: '✅';
        }

        .alert-danger::before {
            content: '❌';
        }

        /* Пагинация */
        .pagination-container {
            background: var(--admin-card);
            padding: 20px;
            border-radius: var(--admin-radius);
            box-shadow: var(--admin-shadow);
            margin-top: 30px;
        }

        .pagination {
            display: flex;
            justify-content: center;
            gap: 8px;
            list-style: none;
            flex-wrap: wrap;
        }

        .pagination li {
            margin: 2px;
        }

        .pagination a,
        .pagination span {
            display: block;
            padding: 8px 16px;
            background: white;
            border: 1px solid var(--admin-border);
            border-radius: var(--admin-radius-sm);
            color: var(--admin-text);
            text-decoration: none;
            font-weight: 500;
            transition: all 0.2s ease;
            min-width: 40px;
            text-align: center;
        }

        .pagination a:hover {
            background: var(--admin-bg);
            border-color: var(--admin-primary);
        }

        .pagination .active span {
            background: var(--admin-primary);
            color: white;
            border-color: var(--admin-primary);
        }

        /* Состояние пустого списка */
        .empty-state {
            text-align: center;
            padding: 60px 20px;
            background: var(--admin-card);
            border-radius: var(--admin-radius);
            box-shadow: var(--admin-shadow);
            margin: 40px 0;
        }

        .empty-state-icon {
            font-size: 4rem;
            margin-bottom: 20px;
            opacity: 0.5;
        }

        .empty-state h4 {
            font-size: 1.5rem;
            margin-bottom: 12px;
            color: var(--admin-text);
        }

        .empty-state p {
            color: var(--admin-text-light);
            margin-bottom: 24px;
            max-width: 400px;
            margin-left: auto;
            margin-right: auto;
        }

        /* ===== АДАПТИВНОСТЬ — БОЛЬШИЕ ЭКРАНЫ ===== */
        @media (max-width: 1400px) {
            .admin-container {
                padding: 24px;
            }

            .products-grid {
                grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
                gap: 18px;
            }
        }

        /* ===== АДАПТИВНОСТЬ — ПЛАНШЕТЫ ===== */
        @media (max-width: 1024px) {
            .admin-container {
                padding: 20px;
            }

            .page-container {
                padding-top: 40px;
            }

            .products-grid {
                grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
                gap: 16px;
            }

            .product-card {
                padding: 14px;
            }

            .product-image img,
            .no-image {
                max-height: 140px;
                height: 140px;
            }

            .product-card h4 {
                font-size: 1rem;
            }

            .product-description {
                font-size: 0.85rem;
            }

            .btn {
                padding: 9px 20px;
                font-size: 13px;
            }

            .btn-sm {
                padding: 5px 10px;
                font-size: 11px;
            }
        }

        /* ===== АДАПТИВНОСТЬ — МАЛЕНЬКИЕ ПЛАНШЕТЫ ===== */
        @media (max-width: 768px) {
            .admin-container {
                padding: 16px;
            }

            .page-container {
                padding-top: 30px;
            }

            .page-header {
                flex-direction: column;
                align-items: stretch;
                gap: 12px;
                margin-bottom: 16px;
            }

            .page-header h3 {
                font-size: 1.3rem;
                text-align: center;
            }

            .page-header .btn {
                width: 100%;
                justify-content: center;
            }

            .products-grid {
                grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
                gap: 14px;
                margin-bottom: 24px;
            }

            .product-card {
                padding: 12px;
            }

            .product-image img,
            .no-image {
                max-height: 130px;
                height: 130px;
            }

            .product-card h4 {
                font-size: 0.95rem;
            }

            .product-description {
                font-size: 0.8rem;
            }

            .product-price {
                font-size: 0.95rem;
            }

            .product-category {
                font-size: 0.75rem;
            }

            .product-actions {
                flex-direction: column;
                gap: 8px;
                margin-top: 12px;
            }

            .product-actions form {
                width: 100%;
            }

            .product-actions .btn {
                width: 100%;
                padding: 8px 12px;
                font-size: 12px;
            }

            /* Alerts */
            .alert {
                padding: 14px 18px;
                margin-bottom: 20px;
                font-size: 14px;
            }

            .alert::before {
                font-size: 1.1rem;
            }

            /* Пагинация */
            .pagination-container {
                padding: 16px;
                margin-top: 24px;
            }

            .pagination {
                gap: 6px;
            }

            .pagination a,
            .pagination span {
                padding: 6px 12px;
                font-size: 13px;
                min-width: 36px;
            }

            /* Empty state */
            .empty-state {
                padding: 40px 16px;
                margin: 30px 0;
            }

            .empty-state-icon {
                font-size: 3rem;
            }

            .empty-state h4 {
                font-size: 1.3rem;
            }

            .empty-state p {
                font-size: 14px;
                margin-bottom: 20px;
            }
        }

        /* ===== АДАПТИВНОСТЬ — МОБИЛЬНЫЕ ===== */
        @media (max-width: 480px) {
            .admin-container {
                padding: 12px;
            }

            .page-container {
                padding-top: 20px;
            }

            .page-header {
                gap: 10px;
                margin-bottom: 14px;
            }

            .page-header h3 {
                font-size: 1.2rem;
            }

            .btn {
                padding: 10px 16px;
                font-size: 13px;
            }

            .btn-sm {
                padding: 7px 12px;
                font-size: 12px;
            }

            .products-grid {
                grid-template-columns: 1fr;
                gap: 12px;
                margin-bottom: 20px;
            }

            .product-card {
                padding: 12px;
                border-radius: 6px;
            }

            .product-image img,
            .no-image {
                max-height: 180px;
                height: 180px;
            }

            .product-card h4 {
                font-size: 1rem;
                margin: 8px 0 4px;
            }

            .product-description {
                font-size: 0.85rem;
                margin: 4px 0;
            }

            .product-price {
                font-size: 1rem;
                margin: 6px 0;
            }

            .product-category {
                font-size: 0.8rem;
                margin: 4px 0;
            }

            .product-actions {
                flex-direction: column;
                gap: 8px;
                margin-top: 12px;
                padding-top: 12px;
                border-top: 1px solid var(--admin-border);
            }

            .product-actions .btn {
                width: 100%;
                padding: 9px 14px;
                font-size: 13px;
            }

            /* Alerts */
            .alert {
                padding: 12px 14px;
                margin-bottom: 16px;
                font-size: 13px;
                border-radius: 6px;
            }

            .alert::before {
                font-size: 1rem;
            }

            /* Пагинация */
            .pagination-container {
                padding: 12px;
                margin-top: 20px;
                border-radius: 6px;
            }

            .pagination {
                gap: 4px;
            }

            .pagination a,
            .pagination span {
                padding: 6px 10px;
                font-size: 12px;
                min-width: 32px;
                border-radius: 4px;
            }

            /* Empty state */
            .empty-state {
                padding: 30px 12px;
                margin: 20px 0;
                border-radius: 6px;
            }

            .empty-state-icon {
                font-size: 2.5rem;
                margin-bottom: 16px;
            }

            .empty-state h4 {
                font-size: 1.1rem;
                margin-bottom: 10px;
            }

            .empty-state p {
                font-size: 13px;
                margin-bottom: 16px;
            }
        }

        /* ===== АДАПТИВНОСТЬ — ОЧЕНЬ МАЛЕНЬКИЕ ЭКРАНЫ ===== */
        @media (max-width: 360px) {
            .admin-container {
                padding: 10px 8px;
            }

            .page-header h3 {
                font-size: 1.1rem;
            }

            .btn {
                padding: 9px 14px;
                font-size: 12px;
            }

            .products-grid {
                gap: 10px;
            }

            .product-card {
                padding: 10px;
            }

            .product-image img,
            .no-image {
                max-height: 160px;
                height: 160px;
            }

            .product-card h4 {
                font-size: 0.95rem;
            }

            .product-description {
                font-size: 0.8rem;
            }

            .product-price {
                font-size: 0.95rem;
            }

            .product-actions .btn {
                padding: 8px 12px;
                font-size: 12px;
            }

            .pagination a,
            .pagination span {
                padding: 5px 8px;
                font-size: 11px;
                min-width: 28px;
            }
        }

        /* Темная тема */
        @media (prefers-color-scheme: dark) {
            :root {
                --admin-bg: #1a1a1a;
                --admin-card: #2d2d2d;
                --admin-border: #404040;
                --admin-primary: #6366f1;
                --admin-primary-hover: #4f46e5;
                --admin-text: #f3f4f6;
                --admin-text-light: #9ca3af;
            }

            .alert-success {
                background: linear-gradient(90deg, #064e3b, #065f46);
            }

            .alert-danger {
                background: linear-gradient(90deg, #7f1d1d, #991b1b);
            }

            .product-image {
                background: #2d2d2d !important;
            }

            .no-image {
                background: #404040;
                color: #9ca3af;
            }

            .pagination a,
            .pagination span {
                background: #2d2d2d;
                color: #f3f4f6;
            }
        }
    </style>

    <div class="page-container">
        @auth
            <div class="page-header">
                <h3>Список товаров</h3>
                <a href="{{ route('products.create') }}" class="btn btn-primary">Добавить товар</a>
            </div>
        @endauth

        @if(session()->has('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if(session()->has('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        @if($products->count() > 0)
            <div class="products-grid">
                @foreach($products as $product)
                    <div class="product-card">
                        <div class="product-image">
                            @if($product->image && file_exists(public_path($product->image)))
                                <img src="{{ asset($product->image) }}" alt="{{ $product->name }}">
                            @else
                                <div class="no-image">Нет изображения</div>
                            @endif
                        </div>
                        <h4>{{ $product->name }}</h4>
                        <p class="product-description">{{ Str::limit($product->description, 80) }}</p>
                        <p class="product-price">Цена: {{ $product->price }} руб.</p>
                        <p class="product-category">Категория: {{ $product->category->name ?? '-' }}</p>

                        <div class="product-actions">
                            <a href="{{ route('products.edit', $product->id) }}" class="btn btn-primary btn-sm">Редактировать</a>

                            <form action="{{ route('products.destroy', $product->id) }}" method="POST">
                                @csrf
                                @method('GET')
                                <button type="submit" class="btn btn-delete btn-sm" onclick="return confirm('Вы уверены, что хотите удалить товар?')">Удалить</button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="pagination-container">
                {{ $products->links() }}
            </div>
        @else
            <div class="empty-state">
                <div class="empty-state-icon">📦</div>
                <h4>Товары не найдены</h4>
                <p>Добавьте первый товар, чтобы начать работу с системой</p>
                <a href="{{ route('products.create') }}" class="btn btn-primary">Добавить товар</a>
            </div>
        @endif
    </div>
@endsection
