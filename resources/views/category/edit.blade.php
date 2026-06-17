@extends('users.layout')

@section('content')
    <style>
        /* ===== СТИЛИ АДМИНСКОЙ ЧАСТИ (ЧЕРНО-БЕЛАЯ СХЕМА) ===== */

        :root {
            --bg-main: #f8f9fa;
            --bg-card: #ffffff;
            --bg-hover: #f0f0f0;
            --bg-active: #e8e8e8;
            --border: #e0e0e0;
            --border-dark: #d0d0d0;
            --text-primary: #1a1a1a;
            --text-secondary: #666666;
            --text-muted: #999999;
            --accent-primary: #333333;
            --accent-hover: #1a1a1a;
            --success: #10b981;
            --danger: #ef4444;
            --warning: #f59e0b;
            --shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
            --shadow-hover: 0 4px 12px rgba(0, 0, 0, 0.08);
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

        /* КНОПКА ДОБАВЛЕНИЯ */
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
            white-space: nowrap;
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
            box-shadow: var(--shadow-hover);
        }

        .btn-primary:active {
            transform: translateY(0);
        }

        /* УВЕДОМЛЕНИЯ */
        .alert {
            padding: 16px 20px;
            border-radius: 8px;
            margin: 20px 0;
            font-size: 14px;
            border: 1px solid transparent;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .alert:before {
            font-size: 16px;
        }

        .alert-success {
            background: rgba(16, 185, 129, 0.1);
            border-color: rgba(16, 185, 129, 0.2);
            color: var(--success);
        }

        .alert-success:before {
            content: "✓";
        }

        .alert-danger {
            background: rgba(239, 68, 68, 0.1);
            border-color: rgba(239, 68, 68, 0.2);
            color: var(--danger);
        }

        .alert-danger:before {
            content: "⚠";
        }

        /* СЕТКА КАТЕГОРИЙ */
        .products-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            gap: 20px;
            margin: 30px 0;
        }

        /* КАРТОЧКА КАТЕГОРИИ */
        .category-card {
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 24px;
            transition: all 0.3s ease;
            display: flex;
            flex-direction: column;
            height: 100%;
        }

        .category-card:hover {
            border-color: var(--border-dark);
            box-shadow: var(--shadow-hover);
            transform: translateY(-2px);
        }

        .title {
            font-size: 18px;
            font-weight: 700;
            color: var(--text-primary);
            margin: 0 0 12px 0;
            line-height: 1.3;
            word-break: break-word;
        }

        .description {
            font-size: 14px;
            color: var(--text-secondary);
            margin: 0 0 20px 0;
            line-height: 1.5;
            flex-grow: 1;
            word-break: break-word;
        }

        /* КНОПКИ ДЕЙСТВИЙ */
        .actions {
            display: flex;
            gap: 12px;
            margin-top: auto;
            padding-top: 20px;
            border-top: 1px solid var(--border);
        }

        .actions form {
            flex: 1;
            display: flex;
        }

        .btn-edit,
        .btn-delete {
            flex: 1;
            padding: 10px 16px;
            font-size: 13px;
            font-weight: 600;
            text-align: center;
            width: 100%;
        }

        .btn-edit {
            background: var(--text-primary);
            color: var(--bg-card);
            border: 1px solid var(--border);
        }

        .btn-edit:hover {
            background: var(--bg-hover);
            border-color: var(--border-dark);
        }

        .btn-delete {
            background: var(--bg-card);
            color: var(--danger);
            border: 1px solid rgba(239, 68, 68, 0.3);
        }

        .btn-delete:hover {
            background: rgba(239, 68, 68, 0.1);
            border-color: var(--danger);
        }

        /* СООБЩЕНИЕ О ПУСТОМ СПИСКЕ */
        .products-grid + p {
            text-align: center;
            padding: 60px 20px;
            color: var(--text-muted);
            font-size: 16px;
            background: var(--bg-card);
            border-radius: 12px;
            border: 1px solid var(--border);
        }

        /* СТАТУС-ИНДИКАТОРЫ */
        .status-indicator {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 12px;
            padding: 4px 12px;
            border-radius: 20px;
            font-weight: 600;
            margin-left: auto;
        }

        .status-active {
            background: rgba(16, 185, 129, 0.1);
            color: var(--success);
        }

        .status-inactive {
            background: rgba(156, 163, 175, 0.1);
            color: var(--text-muted);
        }

        /* ПОИСК И ФИЛЬТРЫ */
        .admin-toolbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin: 20px 0;
            gap: 20px;
            flex-wrap: wrap;
        }

        .search-box {
            position: relative;
            flex: 1;
            max-width: 400px;
        }

        .search-box input {
            width: 100%;
            padding: 12px 16px 12px 40px;
            border: 1px solid var(--border);
            border-radius: 8px;
            font-size: 14px;
            background: var(--bg-card);
            color: var(--text-primary);
            transition: all 0.2s ease;
        }

        .search-box input:focus {
            outline: none;
            border-color: var(--accent-primary);
            box-shadow: 0 0 0 3px rgba(0, 0, 0, 0.05);
        }

        .search-box:before {
            content: "🔍";
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
            font-size: 14px;
        }

        .filters {
            display: flex;
            gap: 12px;
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

        /* СТАТИСТИКА */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 20px;
            margin: 30px 0;
        }

        .stat-card {
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 24px;
            text-align: center;
        }

        .stat-value {
            font-size: 32px;
            font-weight: 700;
            color: var(--text-primary);
            margin: 8px 0;
        }

        .stat-label {
            font-size: 14px;
            color: var(--text-secondary);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        /* ПАГИНАЦИЯ */
        .pagination {
            display: flex;
            justify-content: center;
            gap: 8px;
            margin: 40px 0 20px;
            flex-wrap: wrap;
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

        /* ===== АДАПТИВНОСТЬ ===== */

        /* Планшеты и небольшие экраны */
        @media (max-width: 992px) {
            .products-grid {
                grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
                gap: 18px;
            }

            .stats-grid {
                grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            }
        }

        /* Мобильные устройства */
        @media (max-width: 768px) {
            .container {
                padding: 0 15px;
            }

            .content_row {
                padding: 20px 0;
            }

            .content_row h3 {
                font-size: 22px;
            }

            .admin-toolbar {
                flex-direction: column;
                align-items: stretch;
                gap: 15px;
                margin: 15px 0;
            }

            .admin-toolbar > div {
                width: 100%;
            }

            .admin-toolbar .btn-primary {
                width: 100%;
                justify-content: center;
            }

            .search-box {
                max-width: 100%;
            }

            .filters {
                overflow-x: auto;
                padding-bottom: 8px;
                -webkit-overflow-scrolling: touch;
                scrollbar-width: none;
            }

            .filters::-webkit-scrollbar {
                display: none;
            }

            .filter-btn {
                flex-shrink: 0;
            }

            .products-grid {
                grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
                gap: 15px;
                margin: 20px 0;
            }

            .category-card {
                padding: 20px;
            }

            .title {
                font-size: 17px;
            }

            .stats-grid {
                grid-template-columns: 1fr 1fr;
                gap: 15px;
            }

            .stat-card {
                padding: 18px;
            }

            .stat-value {
                font-size: 26px;
            }

            .stat-label {
                font-size: 12px;
            }
        }

        /* Маленькие мобильные */
        @media (max-width: 480px) {
            .container {
                padding: 0 12px;
            }

            .content_row h3 {
                font-size: 20px;
            }

            .products-grid {
                grid-template-columns: 1fr;
                gap: 12px;
            }

            .category-card {
                padding: 18px;
            }

            .title {
                font-size: 16px;
                margin-bottom: 8px;
            }

            .description {
                font-size: 13px;
                margin-bottom: 15px;
            }

            .actions {
                flex-direction: column;
                gap: 10px;
                padding-top: 15px;
            }

            .actions form {
                width: 100%;
            }

            .btn-edit,
            .btn-delete {
                width: 100%;
                padding: 12px 16px;
                font-size: 14px;
            }

            .btn {
                padding: 11px 20px;
                font-size: 13px;
            }

            .btn-primary {
                width: 100%;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }

            .alert {
                padding: 14px 16px;
                font-size: 13px;
            }

            .pagination {
                gap: 4px;
            }

            .page-link {
                padding: 6px 10px;
                font-size: 13px;
            }
        }

        /* Очень маленькие экраны */
        @media (max-width: 360px) {
            .content_row h3 {
                font-size: 18px;
            }

            .category-card {
                padding: 15px;
            }
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

        .category-card {
            animation: fadeIn 0.3s ease-out;
            animation-fill-mode: both;
        }

        .category-card:nth-child(odd) {
            animation-delay: 0.1s;
        }

        .category-card:nth-child(even) {
            animation-delay: 0.2s;
        }

        /* УТИЛИТЫ */
        .loading {
            opacity: 0.6;
            pointer-events: none;
        }

        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: var(--text-muted);
        }

        .empty-state svg {
            width: 64px;
            height: 64px;
            margin-bottom: 20px;
            opacity: 0.5;
        }

        @media (max-width: 480px) {
            .empty-state {
                padding: 40px 15px;
            }

            .empty-state svg {
                width: 48px;
                height: 48px;
            }

            .empty-state h3 {
                font-size: 18px;
            }

            .empty-state p {
                font-size: 13px;
            }
        }
    </style>

    <div class="container">
        <div class="edit-row">
            <form action="{{ route('category.update', $category) }}" method="POST" id="categoryForm">
                @csrf
                @method('PUT')

                <div class="edit-form-column">
                    <h2>Редактировать категорию</h2>

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="form-group">
                        <label for="name">Название категории</label>
                        <input type="text"
                               name="name"
                               id="name"
                               value="{{ old('name', $category->name) }}"
                               placeholder="Введите название категории"
                               maxlength="100"
                               required
                               autofocus>
                        @error('name')
                        <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="description">Описание категории</label>
                        <textarea name="description"
                                  id="description"
                                  placeholder="Опишите назначение и особенности категории..."
                                  maxlength="500">{{ old('description', $category->description) }}</textarea>
                        @error('description')
                        <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-buttons">
                        <button type="submit" class="btn-save" id="submitBtn">
                            <span>Сохранить изменения</span>
                        </button>
                        <a href="{{ route('category.index') }}" class="btn-cancel">
                            <span>Вернуться к списку</span>
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('categoryForm');
            const submitBtn = document.getElementById('submitBtn');
            const nameInput = document.getElementById('name');

            if (form) {
                form.addEventListener('submit', function(e) {
                    const name = nameInput.value.trim();

                    if (name.length < 2) {
                        e.preventDefault();
                        alert('Название категории должно содержать минимум 2 символа');
                        nameInput.focus();
                        return;
                    }

                    if (name.length > 100) {
                        e.preventDefault();
                        alert('Название категории не должно превышать 100 символов');
                        nameInput.focus();
                        return;
                    }

                    submitBtn.disabled = true;
                    submitBtn.classList.add('loading');
                    submitBtn.innerHTML = '<span>🔄</span><span>Сохранение...</span>';
                });
            }

            document.addEventListener('keydown', function(e) {
                if ((e.ctrlKey || e.metaKey) && e.key === 's') {
                    e.preventDefault();
                    submitBtn.click();
                }

                if (e.key === 'Escape') {
                    const cancelBtn = document.querySelector('.btn-cancel');
                    if (cancelBtn) {
                        cancelBtn.click();
                    }
                }
            });

            if (nameInput) {
                setTimeout(() => {
                    nameInput.focus();
                    nameInput.setSelectionRange(nameInput.value.length, nameInput.value.length);
                }, 100);
            }
        });
    </script>
@endsection
