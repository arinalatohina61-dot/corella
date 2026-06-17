@extends('layout.layouts')
@section('content')
    <style>
        /* ===== КАТАЛОГ ТОВАРОВ ===== */

        .catalog-page {
            padding: 40px 0;
            min-height: calc(100vh - 200px);
        }

        .container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 20px;
        }

        /* ===== ФИЛЬТРЫ И СОРТИРОВКА ===== */
        .catalog-filters-top {
            margin-bottom: 40px;
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .filter-tags {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            padding-bottom: 16px;
            border-bottom: 1px solid #eaeaea;
        }

        .filter-tag {
            padding: 8px 18px;
            background: #fff;
            border: 1px solid #ddd;
            border-radius: 0;
            font-size: 14px;
            color: #666;
            cursor: pointer;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-weight: 500;
        }

        .filter-tag:hover {
            background: #f5f5f5;
            border-color: #999;
            color: #000;
        }

        .filter-tag.active {
            background: #000;
            color: #fff;
            border-color: #000;
        }

        .sort-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 20px;
            flex-wrap: wrap;
        }

        .items-count {
            font-size: 14px;
            color: #666;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .sort-select {
            padding: 10px 16px;
            border: 1px solid #ddd;
            border-radius: 0;
            font-size: 14px;
            color: #333;
            background: #fff;
            cursor: pointer;
            transition: all 0.3s ease;
            min-width: 250px;
        }

        .sort-select:hover {
            border-color: #999;
        }

        .sort-select:focus {
            outline: none;
            border-color: #000;
        }

        /* ===== СЕТКА ТОВАРОВ ===== */
        .products-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 30px;
            margin-bottom: 50px;
        }

        .product-card {
            text-decoration: none;
            color: inherit;
            transition: all 0.3s ease;
            display: flex;
            flex-direction: column;
        }

        .product-card:hover {
            transform: translateY(-4px);
        }

        .product-image-wrapper {
            position: relative;
            width: 100%;
            aspect-ratio: 1;
            overflow: hidden;
            background: #f8f8f8;
            margin-bottom: 16px;
        }

        .product-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.4s ease;
        }

        .product-card:hover .product-image {
            transform: scale(1.05);
        }

        .product-badges {
            position: absolute;
            top: 12px;
            left: 12px;
            display: flex;
            flex-direction: column;
            gap: 6px;
            z-index: 1;
        }

        .product-badge {
            padding: 4px 10px;
            background: #000;
            color: #fff;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-weight: 600;
        }

        .product-info {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .product-category {
            font-size: 12px;
            color: #999;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .product-title {
            font-size: 16px;
            font-weight: 500;
            color: #000;
            margin: 0;
            line-height: 1.4;
        }

        .product-price {
            font-size: 18px;
            font-weight: 600;
            color: #000;
            margin-top: 4px;
        }

        /* ===== ПАГИНАЦИЯ ===== */
        .pagination {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 50px;
            padding: 20px 0;
        }

        .pagination nav {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
            justify-content: center;
        }

        .pagination a,
        .pagination span {
            display: flex;
            align-items: center;
            justify-content: center;
            min-width: 40px;
            height: 40px;
            padding: 0 12px;
            border: 1px solid #ddd;
            background: #fff;
            color: #666;
            text-decoration: none;
            font-size: 14px;
            transition: all 0.3s ease;
        }

        .pagination a:hover {
            background: #f5f5f5;
            border-color: #999;
            color: #000;
        }

        .pagination .active span {
            background: #000;
            color: #fff;
            border-color: #000;
        }

        .pagination .disabled span {
            opacity: 0.4;
            cursor: not-allowed;
        }

        /* ===== ПУСТОЕ СОСТОЯНИЕ ===== */
        .products-grid p {
            grid-column: 1 / -1;
            text-align: center;
            padding: 60px 20px;
            font-size: 16px;
            color: #999;
        }

        /* ===== АДАПТИВНОСТЬ — БОЛЬШИЕ ЭКРАНЫ ===== */
        @media (max-width: 1400px) {
            .container {
                max-width: 1200px;
            }

            .products-grid {
                grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
                gap: 24px;
            }
        }

        /* ===== АДАПТИВНОСТЬ — ПЛАНШЕТЫ ===== */
        @media (max-width: 1024px) {
            .catalog-page {
                padding: 30px 0;
            }

            .container {
                max-width: 100%;
                padding: 0 16px;
            }

            .catalog-filters-top {
                margin-bottom: 30px;
                gap: 16px;
            }

            .filter-tags {
                gap: 8px;
                padding-bottom: 14px;
            }

            .filter-tag {
                padding: 7px 16px;
                font-size: 13px;
            }

            .sort-row {
                gap: 16px;
            }

            .items-count {
                font-size: 13px;
            }

            .sort-select {
                padding: 9px 14px;
                font-size: 13px;
                min-width: 220px;
            }

            .products-grid {
                grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
                gap: 20px;
                margin-bottom: 40px;
            }

            .product-image-wrapper {
                margin-bottom: 14px;
            }

            .product-badges {
                top: 10px;
                left: 10px;
                gap: 5px;
            }

            .product-badge {
                padding: 3px 8px;
                font-size: 10px;
            }

            .product-category {
                font-size: 11px;
            }

            .product-title {
                font-size: 15px;
            }

            .product-price {
                font-size: 17px;
            }

            .pagination {
                margin-top: 40px;
                padding: 16px 0;
            }

            .pagination a,
            .pagination span {
                min-width: 38px;
                height: 38px;
                font-size: 13px;
            }
        }

        /* ===== АДАПТИВНОСТЬ — МАЛЕНЬКИЕ ПЛАНШЕТЫ ===== */
        @media (max-width: 768px) {
            .catalog-page {
                padding: 24px 0;
            }

            .container {
                padding: 0 12px;
            }

            .catalog-filters-top {
                margin-bottom: 24px;
                gap: 14px;
            }

            .filter-tags {
                gap: 6px;
                padding-bottom: 12px;
            }

            .filter-tag {
                padding: 6px 14px;
                font-size: 12px;
            }

            .sort-row {
                flex-direction: column;
                align-items: stretch;
                gap: 12px;
            }

            .items-count {
                text-align: center;
                font-size: 12px;
            }

            .sort-select {
                width: 100%;
                min-width: auto;
                padding: 10px 14px;
                font-size: 13px;
            }

            .products-grid {
                grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
                gap: 16px;
                margin-bottom: 30px;
            }

            .product-card:hover {
                transform: none;
            }

            .product-image-wrapper {
                margin-bottom: 12px;
            }

            .product-badges {
                top: 8px;
                left: 8px;
            }

            .product-badge {
                padding: 3px 7px;
                font-size: 9px;
            }

            .product-info {
                gap: 6px;
            }

            .product-category {
                font-size: 10px;
            }

            .product-title {
                font-size: 14px;
            }

            .product-price {
                font-size: 16px;
                margin-top: 2px;
            }

            .pagination {
                margin-top: 30px;
                padding: 14px 0;
            }

            .pagination nav {
                gap: 6px;
            }

            .pagination a,
            .pagination span {
                min-width: 36px;
                height: 36px;
                padding: 0 10px;
                font-size: 12px;
            }

            .products-grid p {
                padding: 40px 16px;
                font-size: 15px;
            }
        }

        /* ===== АДАПТИВНОСТЬ — МОБИЛЬНЫЕ ===== */
        @media (max-width: 480px) {
            .catalog-page {
                padding: 20px 0;
            }

            .container {
                padding: 0 10px;
            }

            .catalog-filters-top {
                margin-bottom: 20px;
                gap: 12px;
            }

            .filter-tags {
                gap: 6px;
                padding-bottom: 10px;
                overflow-x: auto;
                flex-wrap: nowrap;
                -webkit-overflow-scrolling: touch;
                scrollbar-width: none;
            }

            .filter-tags::-webkit-scrollbar {
                display: none;
            }

            .filter-tag {
                padding: 6px 12px;
                font-size: 11px;
                white-space: nowrap;
                flex-shrink: 0;
            }

            .sort-row {
                gap: 10px;
            }

            .items-count {
                font-size: 11px;
            }

            .sort-select {
                padding: 9px 12px;
                font-size: 12px;
            }

            .products-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 12px;
                margin-bottom: 24px;
            }

            .product-image-wrapper {
                margin-bottom: 10px;
            }

            .product-badges {
                top: 6px;
                left: 6px;
                gap: 4px;
            }

            .product-badge {
                padding: 2px 6px;
                font-size: 8px;
            }

            .product-info {
                gap: 4px;
            }

            .product-category {
                font-size: 9px;
            }

            .product-title {
                font-size: 13px;
                line-height: 1.3;
            }

            .product-price {
                font-size: 14px;
                margin-top: 2px;
            }

            .pagination {
                margin-top: 24px;
                padding: 12px 0;
            }

            .pagination nav {
                gap: 4px;
            }

            .pagination a,
            .pagination span {
                min-width: 32px;
                height: 32px;
                padding: 0 8px;
                font-size: 11px;
            }

            .products-grid p {
                padding: 30px 12px;
                font-size: 14px;
            }
        }

        /* ===== АДАПТИВНОСТЬ — ОЧЕНЬ МАЛЕНЬКИЕ ЭКРАНЫ ===== */
        @media (max-width: 360px) {
            .catalog-page {
                padding: 16px 0;
            }

            .container {
                padding: 0 8px;
            }

            .catalog-filters-top {
                margin-bottom: 16px;
                gap: 10px;
            }

            .filter-tag {
                padding: 5px 10px;
                font-size: 10px;
            }

            .items-count {
                font-size: 10px;
            }

            .sort-select {
                padding: 8px 10px;
                font-size: 11px;
            }

            .products-grid {
                gap: 10px;
                margin-bottom: 20px;
            }

            .product-image-wrapper {
                margin-bottom: 8px;
            }

            .product-badge {
                padding: 2px 5px;
                font-size: 7px;
            }

            .product-category {
                font-size: 8px;
            }

            .product-title {
                font-size: 12px;
            }

            .product-price {
                font-size: 13px;
            }

            .pagination a,
            .pagination span {
                min-width: 28px;
                height: 28px;
                padding: 0 6px;
                font-size: 10px;
            }

            .products-grid p {
                padding: 24px 10px;
                font-size: 13px;
            }
        }
    </style>

    <main class="catalog-page">
        <div class="container">
            <div class="catalog-filters-top">
                <div class="filter-tags">
                    <div class="filter-tag {{ request('category') ? '' : 'active' }}" data-category="">
                        Все категории
                    </div>

                    @foreach($categories as $category)
                        <div class="filter-tag {{ request('category') == $category->id ? 'active' : '' }}"
                             data-category="{{ $category->id }}">
                            {{ $category->name }}
                        </div>
                    @endforeach
                </div>

                <div class="sort-row">
                    <div class="items-count">{{ $products->count() }} товаров</div>
                    <form method="GET" id="sortForm">
                        <select name="sort" class="sort-select" onchange="document.getElementById('sortForm').submit()">
                            <option value="default" {{ $sort == 'default' ? 'selected' : '' }}>По умолчанию</option>
                            <option value="price_asc" {{ $sort == 'price_asc' ? 'selected' : '' }}>По цене: от низкой к высокой</option>
                            <option value="price_desc" {{ $sort == 'price_desc' ? 'selected' : '' }}>По цене: от высокой к низкой</option>
                            <option value="name_asc" {{ $sort == 'name_asc' ? 'selected' : '' }}>По названию: А → Я</option>
                            <option value="name_desc" {{ $sort == 'name_desc' ? 'selected' : '' }}>По названию: Я → А</option>
                        </select>

                        @foreach(request()->except('sort', 'page') as $key => $value)
                            <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                        @endforeach
                    </form>
                </div>
            </div>

            <div class="products-grid">
                @forelse($products as $product)
                    <a href="{{ route('products.show', $product->id) }}" class="product-card">
                        <div class="product-image-wrapper">
                            <img src="{{ asset($product->image) }}" alt="{{ $product->name }}" class="product-image">

                            @if($product->badges && count($product->badges))
                                <div class="product-badges">
                                    @foreach($product->badges as $badge)
                                        <span class="product-badge">{{ $badge }}</span>
                                    @endforeach
                                </div>
                            @endif
                        </div>

                        <div class="product-info">
                            <div class="product-category">{{ $product->category->name }}</div>
                            <h3 class="product-title">{{ $product->name }}</h3>
                            <div class="product-price">от {{ number_format($product->price, 0, '.', ' ') }} ₽</div>
                        </div>
                    </a>
                @empty
                    <p>Товары не найдены.</p>
                @endforelse
            </div>

            <!-- Пагинация -->
            <div class="pagination">
                {{ $products->links('paginations.paginate') }}
            </div>
        </div>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            // --- ФИЛЬТРЫ ПО КАТЕГОРИЯМ ---
            const filterTags = document.querySelectorAll('.filter-tag');

            filterTags.forEach(tag => {
                tag.addEventListener('click', function() {
                    const categoryId = this.dataset.category;
                    const url = new URL(window.location.href);

                    // Меняем параметр category
                    if (categoryId) {
                        url.searchParams.set('category', categoryId);
                    } else {
                        url.searchParams.delete('category');
                    }

                    // Сбрасываем пагинацию
                    url.searchParams.delete('page');

                    window.location.href = url.toString();
                });
            });

        });
    </script>
@endsection
