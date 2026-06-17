@extends('users.layout')
@section('product', 'Создание товара')

@section('content')
    <style>
        /* 1. БАЗОВЫЕ СТИЛИ */
        * {
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            background: #f5f7fa;
            color: #333;
            margin: 0;
            padding: 0;
        }

        /* 2. КОНТЕЙНЕР РЕДАКТИРОВАНИЯ */
        .edit-row {
            display: flex;
            gap: 130px;
            max-width: 1400px;
            justify-content: center;
            margin: 30px auto;
            padding: 50px 20px;
            min-height: calc(100vh - 120px);
        }

        /* 3. КОЛОНКА С ИЗОБРАЖЕНИЕМ */
        .edit-image-column {
            flex: 0 0 380px;
            background: white;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.06);
            border: 1px solid #e1e5e9;
            height: fit-content;
            position: sticky;
            top: 30px;
        }

        .edit-image-column h3 {
            color: #2c3e50;
            margin: 0 0 25px 0;
            font-size: 20px;
            font-weight: 600;
            padding-bottom: 15px;
        }

        /* Текущее изображение */
        .current-img {
            width: 100%;
            height: 320px;
            object-fit: contain;
            border-radius: 8px;
            border: 2px solid #e8e9ec;
            padding: 8px;
            background: #fafbfc;
            margin-bottom: 25px;
            transition: transform 0.2s;
        }

        .current-img:hover {
            transform: scale(1.02);
        }

        /* Заглушка для отсутствующего изображения */
        .image-placeholder {
            width: 100%;
            height: 320px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f8f9fa;
            border: 2px dashed #d0d7de;
            border-radius: 8px;
            margin: 0 0 25px 0;
            color: #999;
            font-size: 14px;
        }

        /* 4. КОЛОНКА С ФОРМОЙ */
        .edit-form-column {
            flex: 1;
            min-width: 0;
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.06);
            border: 1px solid #e1e5e9;
        }

        .edit-form-column h2 {
            color: #2c3e50;
            margin: 0 0 25px 0;
            font-size: 24px;
            font-weight: 400;
            line-height: 1.3;
        }

        /* 5. ФОРМА И ЭЛЕМЕНТЫ */
        form {
            margin-top: 15px;
        }

        .form-group {
            margin-bottom: 24px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #2c3e50;
            font-weight: 600;
            font-size: 14px;
            letter-spacing: 0.2px;
        }

        .form-group label::after {
            content: " *";
            color: #e74c3c;
            font-weight: normal;
        }

        /* 6. ПОЛЯ ВВОДА */
        input[type="text"],
        input[type="number"],
        textarea,
        select {
            width: 100%;
            padding: 12px 16px;
            border: 1px solid #dce1e6;
            border-radius: 8px;
            font-size: 14px;
            font-family: inherit;
            transition: all 0.2s ease;
            background: #fff;
            color: #333;
        }

        input[type="text"]:hover,
        input[type="number"]:hover,
        textarea:hover,
        select:hover {
            border-color: #a0aec0;
        }

        input[type="text"]:focus,
        input[type="number"]:focus,
        textarea:focus,
        select:focus {
            outline: none;
            border-color: #3498db;
            box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.1);
            background: #fff;
        }

        /* Плейсхолдеры */
        ::placeholder {
            color: #a0a6b0;
            opacity: 1;
        }

        /* 7. ФАЙЛОВЫЙ ИНПУТ */
        input[type="file"] {
            width: 100%;
            padding: 14px;
            border: 2px dashed #cbd5e0;
            border-radius: 8px;
            background: #f8f9fa;
            cursor: pointer;
            font-size: 14px;
            transition: all 0.2s;
        }

        input[type="file"]:hover {
            border-color: #3498db;
            background: #f0f7ff;
        }

        input[type="file"]::file-selector-button {
            padding: 8px 16px;
            background: #333;
            color: white;
            border: none;
            border-radius: 6px;
            font-weight: 500;
            cursor: pointer;
            margin-right: 12px;
            transition: background 0.2s;
            font-size: 13px;
        }

        /* 8. TEXTAREA */
        textarea {
            min-height: 120px;
            resize: vertical;
            line-height: 1.5;
        }

        /* 9. SELECT */
        select {
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='%23555' viewBox='0 0 16 16'%3E%3Cpath d='M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 16px center;
            background-size: 12px;
            padding-right: 45px;
            cursor: pointer;
        }

        /* 10. КНОПКИ */
        .form-buttons {
            display: flex;
            gap: 12px;
            margin-top: 32px;
            padding-top: 24px;
            border-top: 1px solid #edf2f7;
        }

        .btn-save {
            background: #333;
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
            flex: 1;
            max-width: 200px;
            letter-spacing: 0.2px;
        }

        .btn-save:hover {
            background: #000;
            transform: translateY(-1px);
            box-shadow: 0 2px 8px rgba(41, 128, 185, 0.2);
        }

        .btn-save:active {
            transform: translateY(0);
        }

        .btn-cancel {
            background: white;
            color: #555;
            border: 1px solid #dce1e6;
            padding: 12px 24px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            text-decoration: none;
            text-align: center;
            transition: all 0.2s;
            flex: 1;
            max-width: 120px;
            letter-spacing: 0.2px;
        }

        .btn-cancel:hover {
            background: #f8f9fa;
            border-color: #c2c7d0;
            transform: translateY(-1px);
            color: #333;
        }

        /* 11. СООБЩЕНИЯ ОБ ОШИБКАХ */
        .alert-danger {
            background: #fff5f5;
            border: 1px solid #fed7d7;
            border-radius: 8px;
            padding: 16px 20px;
            margin-bottom: 24px;
            color: #c53030;
            position: relative;
        }

        .alert-danger::before {
            content: "⚠";
            position: absolute;
            left: 20px;
            top: 16px;
            font-size: 16px;
        }

        .alert-danger ul {
            margin: 0;
            padding-left: 30px;
            list-style: none;
        }

        .alert-danger li {
            margin: 6px 0;
            font-size: 14px;
            font-weight: 500;
            position: relative;
            line-height: 1.4;
        }

        .alert-danger li::before {
            content: "•";
            position: absolute;
            left: -15px;
            color: #c53030;
            font-size: 16px;
        }

        .form-group:last-child::after {
            display: none;
        }

        /* 13. АДАПТИВНОСТЬ — БОЛЬШИЕ ЭКРАНЫ */
        @media (max-width: 1200px) {
            .edit-row {
                max-width: 95%;
                gap: 40px;
                padding: 40px 20px;
            }

            .edit-image-column {
                flex: 0 0 340px;
            }

            .current-img,
            .image-placeholder {
                height: 280px;
            }
        }

        /* 13. АДАПТИВНОСТЬ — ПЛАНШЕТЫ */
        @media (max-width: 992px) {
            .edit-row {
                flex-direction: column;
                gap: 24px;
                max-width: 90%;
                padding: 30px 20px;
            }

            .edit-image-column {
                flex: none;
                width: 100%;
                max-width: 500px;
                margin: 0 auto;
                position: static;
            }

            .edit-form-column {
                width: 100%;
            }

            .current-img,
            .image-placeholder {
                height: 300px;
            }

            .edit-form-column h2 {
                font-size: 22px;
            }

            .form-buttons {
                flex-direction: row;
                gap: 12px;
            }

            .btn-save,
            .btn-cancel {
                max-width: none;
            }
        }

        /* 14. АДАПТИВНОСТЬ — МАЛЕНЬКИЕ ПЛАНШЕТЫ */
        @media (max-width: 768px) {
            .edit-row {
                margin: 20px auto;
                padding: 20px 15px;
                max-width: 100%;
            }

            .edit-image-column,
            .edit-form-column {
                padding: 20px;
                border-radius: 10px;
            }

            .edit-image-column h3 {
                font-size: 18px;
                margin-bottom: 20px;
            }

            .edit-form-column h2 {
                font-size: 20px;
                margin-bottom: 20px;
            }

            .current-img,
            .image-placeholder {
                height: 260px;
                margin-bottom: 20px;
            }

            .form-group {
                margin-bottom: 20px;
            }

            .form-group label {
                font-size: 13px;
                margin-bottom: 6px;
            }

            input[type="text"],
            input[type="number"],
            textarea,
            select {
                padding: 10px 12px;
                font-size: 13px;
            }

            input[type="file"] {
                padding: 12px;
                font-size: 13px;
            }

            input[type="file"]::file-selector-button {
                padding: 6px 12px;
                font-size: 12px;
            }

            textarea {
                min-height: 100px;
            }

            /* Grid для высота/ширина */
            .form-group > div[style*="grid-template-columns"] {
                grid-template-columns: 1fr !important;
                gap: 12px !important;
            }

            /* Flex для освещенность/категория */
            .form-group > div[style*="display: flex"] {
                flex-direction: column !important;
                gap: 12px !important;
            }

            .form-group > div[style*="display: flex"] .form-group {
                width: 100% !important;
            }

            /* Кнопки */
            .form-buttons {
                flex-direction: column;
                gap: 10px;
                margin-top: 24px;
                padding-top: 20px;
            }

            .btn-save,
            .btn-cancel {
                max-width: 100%;
                width: 100%;
                padding: 11px 20px;
                font-size: 13px;
            }

            /* Alert */
            .alert-danger {
                padding: 14px 16px;
                margin-bottom: 20px;
            }

            .alert-danger::before {
                left: 16px;
                top: 14px;
                font-size: 14px;
            }

            .alert-danger ul {
                padding-left: 26px;
            }

            .alert-danger li {
                font-size: 13px;
                margin: 5px 0;
            }
        }

        /* 15. АДАПТИВНОСТЬ — МОБИЛЬНЫЕ */
        @media (max-width: 480px) {
            .edit-row {
                margin: 15px auto;
                padding: 15px 10px;
                min-height: auto;
            }

            .edit-image-column,
            .edit-form-column {
                padding: 16px;
                border-radius: 8px;
            }

            .edit-image-column h3 {
                font-size: 17px;
                margin-bottom: 16px;
                padding-bottom: 12px;
            }

            .edit-form-column h2 {
                font-size: 18px;
                margin-bottom: 16px;
                line-height: 1.4;
            }

            .current-img,
            .image-placeholder {
                height: 220px;
                margin-bottom: 16px;
                border-radius: 6px;
            }

            .form-group {
                margin-bottom: 16px;
            }

            .form-group label {
                font-size: 12px;
                margin-bottom: 5px;
            }

            input[type="text"],
            input[type="number"],
            textarea,
            select {
                padding: 9px 10px;
                font-size: 13px;
                border-radius: 6px;
            }

            input[type="file"] {
                padding: 10px;
                font-size: 12px;
                border-radius: 6px;
            }

            input[type="file"]::file-selector-button {
                padding: 5px 10px;
                font-size: 11px;
                margin-right: 8px;
            }

            textarea {
                min-height: 90px;
                font-size: 13px;
            }

            select {
                padding-right: 35px;
                background-position: right 12px center;
            }

            /* Grid для высота/ширина */
            .form-group > div[style*="grid-template-columns"] {
                gap: 10px !important;
            }

            /* Flex для освещенность/категория */
            .form-group > div[style*="display: flex"] {
                gap: 10px !important;
            }

            /* Кнопки */
            .form-buttons {
                flex-direction: column;
                gap: 8px;
                margin-top: 20px;
                padding-top: 16px;
            }

            .btn-save,
            .btn-cancel {
                padding: 10px 16px;
                font-size: 13px;
                border-radius: 6px;
            }

            /* Alert */
            .alert-danger {
                padding: 12px 14px;
                margin-bottom: 16px;
                border-radius: 6px;
            }

            .alert-danger::before {
                left: 14px;
                top: 12px;
                font-size: 13px;
            }

            .alert-danger ul {
                padding-left: 22px;
            }

            .alert-danger li {
                font-size: 12px;
                margin: 4px 0;
                line-height: 1.3;
            }

            .alert-danger li::before {
                font-size: 14px;
                left: -12px;
            }

            /* Hint */
            .hint {
                font-size: 11px;
            }
        }

        /* 16. АДАПТИВНОСТЬ — ОЧЕНЬ МАЛЕНЬКИЕ ЭКРАНЫ */
        @media (max-width: 360px) {
            .edit-row {
                padding: 10px 8px;
            }

            .edit-image-column,
            .edit-form-column {
                padding: 14px;
            }

            .edit-image-column h3 {
                font-size: 16px;
            }

            .edit-form-column h2 {
                font-size: 17px;
            }

            .current-img,
            .image-placeholder {
                height: 200px;
            }

            input[type="text"],
            input[type="number"],
            textarea,
            select {
                padding: 8px 9px;
                font-size: 12px;
            }

            .btn-save,
            .btn-cancel {
                padding: 9px 14px;
                font-size: 12px;
            }
        }

        /* 17. АНИМАЦИИ И МИКРОИНТЕРАКЦИИ */
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

        .edit-image-column,
        .edit-form-column {
            animation: fadeIn 0.3s ease-out;
        }

        /* 18. УТИЛИТАРНЫЕ КЛАССЫ */
        .hint {
            font-size: 12px;
            color: #666;
            margin-top: 4px;
            display: block;
            font-weight: normal;
        }

        .required::after {
            content: " *";
            color: #e74c3c;
        }

        /* 19. ФОКУС ДЛЯ ДОСТУПНОСТИ */
        :focus-visible {
            outline: 2px solid #3498db;
            outline-offset: 2px;
        }

        /* 20. СКРОЛЛБАР ДЛЯ TEXTAREA */
        textarea::-webkit-scrollbar {
            width: 6px;
        }

        textarea::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 3px;
        }

        textarea::-webkit-scrollbar-thumb {
            background: #c1c1c1;
            border-radius: 3px;
        }

        textarea::-webkit-scrollbar-thumb:hover {
            background: #a8a8a8;
        }
    </style>
    <div>


        <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data" class="edit-row">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif


            @csrf
            @method('POST')
            <div class="edit-image-column">
                <h3>Изображение товара</h3>
                <div class="image-placeholder">
                    <span>Нет изображения</span>
                </div>

                <div class="form-group">
                    <label for="image">Заменить изображение</label>
                    <input type="file" name="image" id="image" accept="image/*">
                    <span class="hint">Форматы: JPEG, PNG, GIF. Макс. размер: 5MB</span>
                </div>
            </div>

            <div class="edit-form-column">
                <h2>Добавить товар</h2>


                <div class="form-group">
                    <label for="name">Название товара</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}" required
                           placeholder="Введите название товара">
                </div>

                <div class="form-group">
                    <label for="price">Цена (руб.)</label>
                    <input type="number" step="0.01" name="price" id="price" value="{{ old('price') }}" required
                           placeholder="0.00">
                </div>

                <div class="form-group">
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                        <div>
                            <label for="height">Высота (см)</label>
                            <input type="number" step="1" name="height" id="height" value="{{ old('height') }}" required
                                   placeholder="100">
                        </div>
                        <div>
                            <label for="width">Ширина (см)</label>
                            <input type="number" step="1" name="width" id="width" value="{{ old('width') }}" required
                                   placeholder="50">
                        </div>
                    </div>
                </div>

                <div style="display: flex;justify-content: space-between;align-items: center;gap: 20px">
                    <div class="form-group" style="width: 100%">
                        <label for="light_requirement">Освещённость </label>
                        <select name="light_requirement" id="light_requirement" >
                            <option value="">— Выберите освещённость —</option>
                            <option value="низкое" {{ old('light_requirement') == 'низкое' ? 'selected' : '' }}>Низкое</option>
                            <option value="среднее" {{ old('light_requirement') == 'среднее' ? 'selected' : '' }}>Среднее</option>
                            <option value="высокое" {{ old('light_requirement') == 'высокое' ? 'selected' : '' }}>Высокое</option>
                        </select>
                    </div>

                    <div class="form-group" style="width: 100%">
                        <label for="category_id">Категория </label>
                        <select name="category_id" id="category_id" >
                            <option value="">— Выберите категорию —</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                                    {{ $cat->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label for="description">Описание и характеристики</label>
                    <textarea name="description" id="description" rows="5" required
                              placeholder="Опишите товар, его особенности и характеристики">{{ old('description') }}</textarea>
                </div>

                <div class="form-buttons">
                    <button type="submit" class="btn-save">
                        <span>💾 Сохранить изменения</span>
                    </button>
                    <a href="{{ route('products.panel') }}" class="btn-cancel">
                        <span>← Назад</span>
                    </a>
                </div>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // 1. Валидация полей
            const requiredFields = document.querySelectorAll('input[required], textarea[required], select[required]');

            requiredFields.forEach(field => {
                field.addEventListener('invalid', function(e) {
                    e.preventDefault();
                    this.style.borderColor = '#e74c3c';
                    this.style.boxShadow = '0 0 0 3px rgba(231, 76, 60, 0.1)';

                    if (!document.querySelector('.scrolled-to-error')) {
                        this.scrollIntoView({ behavior: 'smooth', block: 'center' });
                        this.classList.add('scrolled-to-error');
                    }
                });

                field.addEventListener('input', function() {
                    if (this.checkValidity()) {
                        this.style.boxShadow = '0 0 0 3px rgba(52, 152, 219, 0.1)';
                    }
                });
            });

            // 2. Предпросмотр изображения
            const imageInput = document.getElementById('image');
            const currentImg = document.querySelector('.current-img');
            const placeholder = document.querySelector('.image-placeholder');

            if (imageInput) {
                imageInput.addEventListener('change', function(e) {
                    const file = e.target.files[0];
                    if (file && file.type.startsWith('image/')) {
                        // Проверка размера файла (5MB)
                        if (file.size > 5 * 1024 * 1024) {
                            alert('Файл слишком большой. Максимальный размер: 5MB');
                            this.value = '';
                            return;
                        }

                        const reader = new FileReader();
                        reader.onload = function(e) {
                            if (currentImg) {
                                currentImg.src = e.target.result;
                            } else if (placeholder) {
                                placeholder.innerHTML = `
                                    <img src="${e.target.result}"
                                         style="width: 100%; height: 100%; object-fit: contain; border-radius: 6px;">
                                `;
                            }
                        };
                        reader.readAsDataURL(file);
                    }
                });
            }

            // 3. Подсветка измененных полей
            const form = document.querySelector('form');
            if (form) {
                const inputs = form.querySelectorAll('input, textarea, select');
                const initialValues = {};

                inputs.forEach(input => {
                    if (input.name) {
                        initialValues[input.name] = input.value;

                        input.addEventListener('change', function() {
                            if (this.value !== initialValues[this.name]) {
                                this.style.backgroundColor = '#f0f7ff';
                            } else {
                                this.style.backgroundColor = '';
                                this.style.borderColor = '';
                            }
                        });
                    }
                });
            }

            // 4. Горячие клавиши
            document.addEventListener('keydown', function(e) {
                // Ctrl+S для сохранения
                if ((e.ctrlKey || e.metaKey) && e.key === 's') {
                    e.preventDefault();
                    document.querySelector('.btn-save').click();
                }
                // Escape для отмены
                if (e.key === 'Escape') {
                    const cancelBtn = document.querySelector('.btn-cancel');
                    if (cancelBtn) {
                        cancelBtn.click();
                    }
                }
            });

            // 5. Автофокус на первом поле
            const firstInput = document.querySelector('input[required]');
            if (firstInput && !firstInput.value) {
                firstInput.focus();
            }
        });
    </script>
@endsection
