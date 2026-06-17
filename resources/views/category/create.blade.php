@extends('users.layout')

@section('content')
    <style>
        /* ===== СТИЛИ ФОРМ КАТЕГОРИЙ (ЧЕРНО-БЕЛАЯ СХЕМА) ===== */

        :root {
            --bg-main: #f8f9fa;
            --bg-card: #ffffff;
            --bg-hover: #f5f5f5;
            --bg-active: #f0f0f0;
            --border: #e0e0e0;
            --border-dark: #d0d0d0;
            --border-focus: #333333;
            --text-primary: #1a1a1a;
            --text-secondary: #666666;
            --text-muted: #999999;
            --accent-primary: #333333;
            --accent-hover: #1a1a1a;
            --success: #10b981;
            --danger: #ef4444;
            --warning: #f59e0b;
            --info: #3b82f6;
            --shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
            --shadow-hover: 0 4px 12px rgba(0, 0, 0, 0.08);
            --shadow-focus: 0 0 0 3px rgba(0, 0, 0, 0.1);
        }

        /* КОНТЕЙНЕР ФОРМЫ */
        .edit-row {
            display: flex;
            justify-content: center;
            align-items: flex-start;
            padding: 40px 0;
        }

        /* ФОРМА */
        form {
            width: 100%;
            max-width: 800px;
        }

        .edit-form-column {
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 40px;
            box-shadow: var(--shadow);
            transition: all 0.3s ease;
        }

        .edit-form-column:hover {
            box-shadow: var(--shadow-hover);
        }

        /* ЗАГОЛОВОК */
        h2 {
            font-size: 28px;
            font-weight: 700;
            color: var(--text-primary);
            margin: 0 0 30px 0;
            padding-bottom: 20px;
            position: relative;
        }

        /* УВЕДОМЛЕНИЯ ОБ ОШИБКАХ */
        .alert {
            padding: 16px 20px;
            border-radius: 8px;
            margin-bottom: 30px;
            font-size: 14px;
            border: 1px solid transparent;
            animation: slideDown 0.3s ease-out;
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

        .alert-danger {
            background: rgba(239, 68, 68, 0.05);
            border-color: rgba(239, 68, 68, 0.2);
            color: var(--danger);
        }

        .alert-danger ul {
            margin: 0;
            padding-left: 20px;
        }

        .alert-danger li {
            margin: 6px 0;
            position: relative;
        }

        .alert-danger li:before {
            content: "•";
            position: absolute;
            left: -15px;
            color: var(--danger);
        }

        /* ГРУППЫ ПОЛЕЙ */
        .form-group {
            margin-bottom: 30px;
            position: relative;
        }

        .form-group:last-child {
            margin-bottom: 0;
        }

        /* ЛЕЙБЛЫ */
        label {
            display: block;
            margin-bottom: 8px;
            font-size: 14px;
            font-weight: 600;
            color: var(--text-primary);
        }

        label:after {
            content: " *";
            color: var(--danger);
            font-weight: normal;
        }

        /* ПОЛЯ ВВОДА */
        input[type="text"],
        textarea {
            width: 100%;
            padding: 14px 16px;
            border: 1px solid var(--border);
            border-radius: 8px;
            font-size: 15px;
            font-family: inherit;
            color: var(--text-primary);
            background: var(--bg-card);
            transition: all 0.2s ease;
            resize: vertical;
        }

        input[type="text"]:hover,
        textarea:hover {
            border-color: var(--border-dark);
            background: var(--bg-hover);
        }

        input[type="text"]:focus,
        textarea:focus {
            outline: none;
            border-color: var(--border-focus);
            background: var(--bg-card);
            box-shadow: var(--shadow-focus);
        }

        /* ПЛЕЙСХОЛДЕРЫ */
        ::placeholder {
            color: var(--text-muted);
            opacity: 1;
        }

        /* TEXTAREA */
        textarea {
            min-height: 150px;
            line-height: 1.6;
        }

        /* СООБЩЕНИЯ ОБ ОШИБКАХ ПОЛЕЙ */
        .form-error {
            font-size: 12px;
            color: var(--danger);
            margin-top: 6px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .form-error:before {
            content: "⚠";
            font-size: 12px;
        }

        /* КНОПКИ */
        .form-buttons {
            display: flex;
            gap: 16px;
            margin-top: 40px;
            padding-top: 30px;
            border-top: 1px solid var(--border);
        }

        .btn-save,
        .btn-cancel {
            flex: 1;
            padding: 14px 24px;
            font-size: 15px;
            font-weight: 600;
            text-align: center;
            text-decoration: none;
            border-radius: 8px;
            border: 1px solid transparent;
            cursor: pointer;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .btn-save {
            background: var(--accent-primary);
            color: white;
        }

        .btn-save:hover {
            background: var(--accent-hover);
            transform: translateY(-1px);
            box-shadow: var(--shadow-hover);
        }

        .btn-save:active {
            transform: translateY(0);
        }

        .btn-save:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
        }

        .btn-cancel {
            background: var(--bg-card);
            color: var(--text-primary);
            border-color: var(--border);
        }

        .btn-cancel:hover {
            background: var(--bg-hover);
            border-color: var(--border-dark);
            transform: translateY(-1px);
        }

        /* ИНДИКАТОРЫ */
        .char-count {
            position: absolute;
            right: 0;
            top: 0;
            font-size: 12px;
            color: var(--text-muted);
        }

        .required-hint {
            font-size: 12px;
            color: var(--text-muted);
            margin-top: 4px;
            display: block;
        }

        .required-hint:before {
            content: "* ";
            color: var(--danger);
        }

        /* ПРЕДПРОСМОТР */
        .preview-section {
            margin-top: 30px;
            padding: 20px;
            background: var(--bg-hover);
            border-radius: 8px;
            border: 1px solid var(--border);
        }

        .preview-section h3 {
            font-size: 16px;
            font-weight: 600;
            color: var(--text-secondary);
            margin-bottom: 12px;
        }

        .preview-content {
            font-size: 14px;
            color: var(--text-primary);
            line-height: 1.5;
        }

        /* ===== АДАПТИВНОСТЬ — ПЛАНШЕТЫ ===== */
        @media (max-width: 1024px) {
            .edit-row {
                padding: 30px 16px;
            }

            form {
                max-width: 700px;
            }

            .edit-form-column {
                padding: 35px 30px;
            }

            h2 {
                font-size: 26px;
                margin-bottom: 28px;
                padding-bottom: 18px;
            }

            .form-group {
                margin-bottom: 28px;
            }

            input[type="text"],
            textarea {
                padding: 13px 15px;
                font-size: 15px;
            }

            textarea {
                min-height: 140px;
            }

            .form-buttons {
                margin-top: 35px;
                padding-top: 25px;
                gap: 14px;
            }

            .btn-save,
            .btn-cancel {
                padding: 13px 22px;
                font-size: 14px;
            }

            .alert {
                padding: 15px 18px;
                margin-bottom: 28px;
            }
        }

        /* ===== АДАПТИВНОСТЬ — МАЛЕНЬКИЕ ПЛАНШЕТЫ ===== */
        @media (max-width: 768px) {
            .edit-row {
                padding: 24px 12px;
            }

            form {
                max-width: 100%;
            }

            .edit-form-column {
                padding: 28px 22px;
                border-radius: 10px;
            }

            h2 {
                font-size: 23px;
                margin-bottom: 24px;
                padding-bottom: 16px;
            }

            .form-group {
                margin-bottom: 24px;
            }

            label {
                font-size: 13px;
                margin-bottom: 7px;
            }

            input[type="text"],
            textarea {
                padding: 12px 14px;
                font-size: 14px;
                border-radius: 6px;
            }

            textarea {
                min-height: 120px;
            }

            .form-error {
                font-size: 11px;
                margin-top: 5px;
            }

            /* Кнопки в столбик */
            .form-buttons {
                flex-direction: column;
                margin-top: 30px;
                padding-top: 22px;
                gap: 10px;
            }

            .btn-save,
            .btn-cancel {
                width: 100%;
                padding: 13px 20px;
                font-size: 14px;
            }

            /* Уведомления */
            .alert {
                padding: 14px 16px;
                margin-bottom: 24px;
                font-size: 13px;
                border-radius: 6px;
            }

            .alert-danger ul {
                padding-left: 18px;
            }

            .alert-danger li {
                margin: 5px 0;
                font-size: 13px;
            }

            .alert-danger li:before {
                left: -14px;
                font-size: 13px;
            }

            /* Предпросмотр */
            .preview-section {
                margin-top: 24px;
                padding: 16px;
                border-radius: 6px;
            }

            .preview-section h3 {
                font-size: 15px;
                margin-bottom: 10px;
            }

            .preview-content {
                font-size: 13px;
            }
        }

        /* ===== АДАПТИВНОСТЬ — МОБИЛЬНЫЕ ===== */
        @media (max-width: 480px) {
            .edit-row {
                padding: 20px 10px;
            }

            .edit-form-column {
                padding: 22px 16px;
                border-radius: 8px;
            }

            h2 {
                font-size: 20px;
                padding-bottom: 14px;
                margin-bottom: 20px;
                line-height: 1.3;
            }

            .form-group {
                margin-bottom: 22px;
            }

            label {
                font-size: 13px;
                margin-bottom: 6px;
            }

            input[type="text"],
            textarea {
                padding: 11px 12px;
                font-size: 14px;
                border-radius: 6px;
            }

            textarea {
                min-height: 110px;
                line-height: 1.5;
            }

            .form-error {
                font-size: 11px;
            }

            /* Кнопки */
            .form-buttons {
                margin-top: 26px;
                padding-top: 18px;
                gap: 8px;
            }

            .btn-save,
            .btn-cancel {
                padding: 12px 18px;
                font-size: 13px;
                border-radius: 6px;
            }

            /* Уведомления */
            .alert {
                padding: 12px 14px;
                margin-bottom: 20px;
                font-size: 12px;
                border-radius: 6px;
            }

            .alert-danger ul {
                padding-left: 16px;
            }

            .alert-danger li {
                margin: 4px 0;
                font-size: 12px;
                line-height: 1.4;
            }

            .alert-danger li:before {
                left: -13px;
                font-size: 12px;
            }

            /* Предпросмотр */
            .preview-section {
                margin-top: 20px;
                padding: 14px;
            }

            .preview-section h3 {
                font-size: 14px;
            }

            .preview-content {
                font-size: 12px;
            }

            /* Индикаторы */
            .char-count {
                font-size: 11px;
            }

            .required-hint {
                font-size: 11px;
            }
        }

        /* ===== АДАПТИВНОСТЬ — ОЧЕНЬ МАЛЕНЬКИЕ ЭКРАНЫ ===== */
        @media (max-width: 360px) {
            .edit-row {
                padding: 16px 8px;
            }

            .edit-form-column {
                padding: 18px 14px;
                border-radius: 6px;
            }

            h2 {
                font-size: 18px;
                padding-bottom: 12px;
                margin-bottom: 18px;
            }

            .form-group {
                margin-bottom: 18px;
            }

            label {
                font-size: 12px;
                margin-bottom: 5px;
            }

            input[type="text"],
            textarea {
                padding: 10px 11px;
                font-size: 13px;
                border-radius: 5px;
            }

            textarea {
                min-height: 100px;
            }

            .form-error {
                font-size: 10px;
            }

            /* Кнопки */
            .form-buttons {
                margin-top: 22px;
                padding-top: 14px;
                gap: 6px;
            }

            .btn-save,
            .btn-cancel {
                padding: 11px 14px;
                font-size: 12px;
                border-radius: 5px;
            }

            /* Уведомления */
            .alert {
                padding: 10px 12px;
                margin-bottom: 16px;
                font-size: 11px;
            }

            .alert-danger li {
                font-size: 11px;
            }

            /* Предпросмотр */
            .preview-section {
                padding: 12px;
                margin-top: 16px;
            }

            .preview-section h3 {
                font-size: 13px;
            }

            .preview-content {
                font-size: 11px;
            }
        }

        /* АНИМАЦИИ */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .edit-form-column {
            animation: fadeIn 0.4s ease-out;
        }

        /* ПРОГРЕСС БАР */
        .progress-bar {
            height: 4px;
            background: var(--border);
            border-radius: 2px;
            overflow: hidden;
            margin-top: 8px;
        }

        .progress-bar-fill {
            height: 100%;
            background: var(--accent-primary);
            transition: width 0.3s ease;
        }

        /* ВАЛИДАЦИЯ */
        input:valid {
            border-color: var(--border);
        }

        input:invalid:not(:placeholder-shown) {
            border-color: var(--danger);
        }

        /* ЗАГРУЗКА */
        .loading {
            opacity: 0.7;
            pointer-events: none;
            position: relative;
        }

        .loading:after {
            content: "";
            position: absolute;
            top: 50%;
            left: 50%;
            width: 20px;
            height: 20px;
            margin: -10px 0 0 -10px;
            border: 2px solid var(--border);
            border-top-color: var(--accent-primary);
            border-radius: 50%;
            animation: spin 0.8s linear infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }
    </style>

    <div class="container">
        <div class="edit-row">
            <form action="{{ route('category.store') }}" method="POST" id="categoryForm">
                <div class="edit-form-column">
                    <h2>Добавить категорию</h2>
                    @csrf

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
                        <div style="position: relative;">
                            <input type="text"
                                   name="name"
                                   id="name"
                                   value="{{ old('name') }}"
                                   placeholder="Введите название категории"
                                   maxlength="100"
                                   required
                                   autofocus>
                        </div>
                        @error('name')
                        <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="description">Описание категории</label>
                        <div style="position: relative;">
                            <textarea name="description"
                                      id="description"
                                      placeholder="Опишите назначение и особенности категории..."
                                      maxlength="500">{{ old('description') }}</textarea>
                        </div>
                        @error('description')
                        <p class="form-error">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-buttons">
                        <button type="submit" class="btn-save" id="submitBtn">
                            <span>Создать категорию</span>
                        </button>
                        <a href="{{ route('category.index') }}" class="btn-cancel">
                            <span>Отмена</span>
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const nameInput = document.getElementById('name');
            const descriptionInput = document.getElementById('description');
            const form = document.getElementById('categoryForm');
            const submitBtn = document.getElementById('submitBtn');

            // Валидация формы
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

                    // Показываем состояние загрузки
                    submitBtn.disabled = true;
                    submitBtn.classList.add('loading');
                    submitBtn.innerHTML = '<span>🔄</span><span>Создание...</span>';
                });
            }

            // Автосохранение в localStorage
            const saveToStorage = debounce(function() {
                const formData = {
                    name: nameInput.value,
                    description: descriptionInput.value
                };
                localStorage.setItem('categoryDraft', JSON.stringify(formData));
            }, 1000);

            if (nameInput) nameInput.addEventListener('input', saveToStorage);
            if (descriptionInput) descriptionInput.addEventListener('input', saveToStorage);

            // Загрузка черновика
            const draft = localStorage.getItem('categoryDraft');
            if (draft && nameInput && !nameInput.value && descriptionInput && !descriptionInput.value) {
                try {
                    const parsed = JSON.parse(draft);
                    if (parsed.name) nameInput.value = parsed.name;
                    if (parsed.description) descriptionInput.value = parsed.description;

                    if (confirm('Найдены несохраненные данные. Восстановить?')) {
                        // Данные уже восстановлены
                    } else {
                        nameInput.value = '';
                        descriptionInput.value = '';
                        localStorage.removeItem('categoryDraft');
                    }
                } catch (e) {
                    console.error('Error loading draft:', e);
                }
            }

            // Очистка localStorage при успешной отправке
            window.addEventListener('beforeunload', function() {
                if (localStorage.getItem('categoryDraft')) {
                    return 'У вас есть несохраненные изменения. Вы уверены, что хотите уйти?';
                }
            });

            // Горячие клавиши
            document.addEventListener('keydown', function(e) {
                // Ctrl+S для сохранения
                if ((e.ctrlKey || e.metaKey) && e.key === 's') {
                    e.preventDefault();
                    submitBtn.click();
                }

                // Escape для отмены
                if (e.key === 'Escape') {
                    const cancelBtn = document.querySelector('.btn-cancel');
                    if (cancelBtn) {
                        cancelBtn.click();
                    }
                }
            });

            // Дебаунс функция
            function debounce(func, wait) {
                let timeout;
                return function executedFunction(...args) {
                    const later = () => {
                        clearTimeout(timeout);
                        func(...args);
                    };
                    clearTimeout(timeout);
                    timeout = setTimeout(later, wait);
                };
            }

            // Фокус на первое поле
            if (nameInput) {
                setTimeout(() => {
                    nameInput.focus();
                    nameInput.setSelectionRange(nameInput.value.length, nameInput.value.length);
                }, 100);
            }
        });
    </script>
@endsection
