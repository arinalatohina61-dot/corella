@extends('users.layout')

@section('title', 'Добавление сотрудника')

@section('content')
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        .container {
            display: flex;
            justify-content: center;
        }

        /* 2. КАРТОЧКА ФОРМЫ */
        .form-card {
            margin-top: 50px;
            background: white;
            border-radius: 16px;
            box-shadow: 0 8px 40px rgba(0, 0, 0, 0.12);
            width: 100%;
            max-width: 800px;
            overflow: hidden;
            border: 1px solid #e9ecef;
        }

        /* 3. ЗАГОЛОВОК ФОРМЫ */
        .form-header {
            padding: 40px 40px 30px;
            border-bottom: 1px solid #e9ecef;
            background: linear-gradient(to right, #f8f9fa, #ffffff);
            position: relative;
        }

        .form-header h2 {
            font-size: 28px;
            font-weight: 700;
            color: #212529;
            letter-spacing: -0.5px;
            margin-bottom: 8px;
        }

        .form-subtitle {
            color: #6c757d;
            font-size: 15px;
            font-weight: 400;
        }

        .back-link {
            position: absolute;
            top: 40px;
            right: 40px;
            color: #6c757d;
            text-decoration: none;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 6px;
            transition: all 0.2s ease;
        }

        .back-link:hover {
            color: #212529;
            transform: translateX(-2px);
        }

        .back-link::before {
            content: "←";
            font-size: 16px;
        }

        /* 4. ТЕЛО ФОРМЫ */
        .form-body {
            padding: 40px;
        }

        form {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 28px;
        }

        /* 5. ГРУППЫ ПОЛЕЙ */
        .form-group {
            position: relative;
            margin-bottom: 0;
        }

        .form-group.full-width {
            grid-column: 1 / -1;
        }

        .form-label {
            display: block;
            margin-bottom: 12px;
            color: #212529;
            font-weight: 600;
            font-size: 15px;
            letter-spacing: 0.2px;
            position: relative;
        }

        .form-label::after {
            content: "*";
            color: #dc3545;
            margin-left: 4px;
            font-weight: normal;
        }

        /* 6. ПОЛЯ ВВОДА */
        .form-input {
            width: 100%;
            padding: 16px 20px;
            border: 2px solid #e0e2e7;
            border-radius: 10px;
            font-size: 15px;
            font-family: inherit;
            transition: all 0.25s ease;
            background: white;
            color: #212529;
        }

        .form-input:hover {
            border-color: #b0b7c3;
        }

        .form-input:focus {
            outline: none;
            border-color: #212529;
            box-shadow: 0 0 0 3px rgba(33, 37, 41, 0.1);
            background: #fafbfc;
        }

        .form-input::placeholder {
            color: #a0a6b0;
        }

        /* 7. ПАРОЛЬ */
        .password-field {
            position: relative;
        }

        .toggle-password {
            position: absolute;
            right: 16px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #6c757d;
            cursor: pointer;
            padding: 4px;
            font-size: 18px;
            transition: color 0.2s ease;
        }

        .toggle-password:hover {
            color: #212529;
        }

        /* 8. ПОДСКАЗКИ */
        .form-hint {
            font-size: 13px;
            color: #6c757d;
            margin-top: 8px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .form-hint::before {
            content: "💡";
            font-size: 12px;
            opacity: 0.6;
        }

        /* 9. СООБЩЕНИЯ ОБ ОШИБКАХ */
        .error-message {
            color: #dc3545;
            font-size: 13px;
            margin-top: 8px;
            display: flex;
            align-items: center;
            gap: 6px;
            animation: slideDown 0.3s ease;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-5px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .has-error .form-input {
            border-color: #dc3545 !important;
            background: #fffafa;
        }

        .has-error .form-input:focus {
            box-shadow: 0 0 0 3px rgba(220, 53, 69, 0.1);
        }

        /* 10. ГЛОБАЛЬНЫЕ ОШИБКИ */
        .alert-danger {
            background: linear-gradient(135deg, #ffebee, #ffcdd2);
            border: 2px solid #dc3545;
            border-radius: 10px;
            padding: 20px 25px;
            margin-bottom: 30px;
            color: #721c24;
            position: relative;
            animation: slideIn 0.3s ease;
            grid-column: 1 / -1;
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


        .alert-danger p {
            margin: 0;
            padding: 4px 0 4px 30px;
            position: relative;
        }

        .alert-danger p::before {
            content: "•";
            position: absolute;
            left: 10px;
            color: #721c24;
            font-size: 18px;
        }

        /* 11. КНОПКА ОТПРАВКИ */
        .form-actions {
            grid-column: 1 / -1;
            padding-top: 30px;
            border-top: 1px solid #e9ecef;
            margin-top: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 20px;
        }

        .btn-submit {
            display: inline-flex;
            align-items: center;
            gap: 12px;
            padding: 18px 40px;
            background: #212529;
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.25s ease;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            min-width: 200px;
        }

        .btn-submit:hover {
            background: #343a40;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
        }

        .btn-submit:active {
            transform: translateY(0);
        }

        .btn-submit:hover::after {
            transform: translateX(4px);
        }

        .btn-cancel {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 16px 32px;
            background: white;
            color: #6c757d;
            border: 2px solid #e0e2e7;
            border-radius: 10px;
            font-size: 15px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.25s ease;
        }

        .btn-cancel:hover {
            background: #f8f9fa;
            border-color: #b0b7c3;
            color: #212529;
            transform: translateY(-2px);
        }

        /* 12. ПРЕДПРОСМОТР СОТРУДНИКА */
        .employee-preview {
            grid-column: 1 / -1;
            background: #f8f9fa;
            border-radius: 12px;
            padding: 25px;
            margin-top: 10px;
            border: 1px solid #e9ecef;
            display: none;
        }

        .employee-preview.visible {
            display: block;
            animation: fadeIn 0.3s ease;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        .preview-title {
            font-size: 15px;
            font-weight: 600;
            color: #6c757d;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .preview-content {
            display: flex;
            gap: 30px;
            align-items: center;
        }

        .preview-avatar {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: #212529;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 32px;
            font-weight: 600;
        }

        .preview-details {
            flex: 1;
        }

        .preview-name {
            font-size: 20px;
            font-weight: 700;
            color: #212529;
            margin-bottom: 5px;
        }

        .preview-email {
            color: #6c757d;
            font-size: 15px;
            margin-bottom: 10px;
        }

        .preview-id {
            font-size: 13px;
            color: #a0a6b0;
            font-family: 'Courier New', monospace;
        }

        /* 13. СИЛА ПАРОЛЯ */
        .password-strength {
            margin-top: 8px;
            height: 4px;
            background: #e9ecef;
            border-radius: 2px;
            overflow: hidden;
            position: relative;
        }

        .strength-meter {
            height: 100%;
            width: 0%;
            background: #6c757d;
            transition: all 0.3s ease;
            border-radius: 2px;
        }

        .strength-text {
            font-size: 12px;
            color: #6c757d;
            margin-top: 4px;
            text-align: right;
        }

        /* 14. ГЕНЕРАТОР ПАРОЛЕЙ */
        .password-generator {
            margin-top: 10px;
            display: flex;
            gap: 10px;
            align-items: center;
        }

        .generate-btn {
            padding: 8px 16px;
            background: #f8f9fa;
            border: 1px solid #e0e2e7;
            border-radius: 6px;
            color: #6c757d;
            font-size: 13px;
            cursor: pointer;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .generate-btn:hover {
            background: #e9ecef;
            border-color: #b0b7c3;
            color: #212529;
        }

        .copy-password {
            padding: 8px 16px;
            background: #f8f9fa;
            border: 1px solid #e0e2e7;
            border-radius: 6px;
            color: #6c757d;
            font-size: 13px;
            cursor: pointer;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .copy-password:hover {
            background: #e9ecef;
            border-color: #b0b7c3;
            color: #212529;
        }

        /* 15. АДАПТИВНОСТЬ — ПЛАНШЕТ */
        @media (max-width: 1024px) {
            .form-card {
                max-width: 90%;
                margin-top: 40px;
            }

            .form-header {
                padding: 35px 35px 25px;
            }

            .form-body {
                padding: 35px;
            }

            form {
                gap: 24px;
            }
        }

        /* 15. АДАПТИВНОСТЬ — МОБИЛЬНЫЕ */
        @media (max-width: 768px) {
            .container {
                padding: 20px 15px;
                align-items: flex-start;
            }

            .form-card {
                margin-top: 20px;
                border-radius: 12px;
                max-width: 100%;
            }

            .form-header {
                padding: 25px 20px 20px;
            }

            .form-header h2 {
                font-size: 24px;
                padding-right: 0;
            }

            .form-body {
                padding: 25px 20px;
            }

            form {
                grid-template-columns: 1fr;
                gap: 20px;
            }

            .form-group.full-width {
                grid-column: 1;
            }

            .form-label {
                font-size: 14px;
                margin-bottom: 10px;
            }

            .form-input {
                padding: 14px 16px;
                font-size: 16px; /* предотвращает зум на iOS */
            }

            .back-link {
                position: relative;
                top: 0;
                right: 0;
                margin-top: 12px;
                display: inline-flex;
            }

            /* Глобальные ошибки */
            .alert-danger {
                padding: 15px 18px;
                margin-bottom: 20px;
            }

            .alert-danger p {
                font-size: 14px;
                padding-left: 25px;
            }

            .alert-danger p::before {
                font-size: 16px;
            }

            /* Ошибки полей */
            .error-message {
                font-size: 12px;
            }

            /* Кнопки действий */
            .form-actions {
                flex-direction: column;
                gap: 12px;
                padding-top: 20px;
            }

            .btn-submit,
            .btn-cancel {
                width: 100%;
                justify-content: center;
                padding: 16px 24px;
            }

            .btn-submit {
                font-size: 15px;
                min-width: auto;
            }

            .btn-cancel {
                font-size: 14px;
            }

            /* Превью сотрудника */
            .preview-content {
                flex-direction: column;
                text-align: center;
                gap: 15px;
            }

            .preview-avatar {
                width: 70px;
                height: 70px;
                font-size: 28px;
            }

            .preview-name {
                font-size: 18px;
            }

            .preview-email {
                font-size: 14px;
            }

            /* Генератор паролей */
            .password-generator {
                flex-wrap: wrap;
                gap: 8px;
            }

            .generate-btn,
            .copy-password {
                font-size: 12px;
                padding: 7px 12px;
            }

            /* Сообщение об успехе */
            .success-message {
                top: 15px;
                right: 15px;
                left: 15px;
                padding: 15px 20px;
                font-size: 14px;
            }
        }

        /* 16. АДАПТИВНОСТЬ — МАЛЕНЬКИЕ ЭКРАНЫ */
        @media (max-width: 480px) {
            .container {
                padding: 10px;
            }

            .form-card {
                border-radius: 10px;
                margin-top: 10px;
            }

            .form-header {
                padding: 20px 15px 15px;
            }

            .form-header h2 {
                font-size: 20px;
                line-height: 1.3;
            }

            .form-subtitle {
                font-size: 13px;
            }

            .form-body {
                padding: 20px 15px;
            }

            form {
                gap: 18px;
            }

            .form-label {
                font-size: 13px;
                margin-bottom: 8px;
            }

            .form-input {
                padding: 12px 14px;
                font-size: 15px;
                border-radius: 8px;
            }

            .toggle-password {
                right: 12px;
                font-size: 16px;
            }

            /* Ошибки */
            .alert-danger {
                padding: 12px 15px;
                border-radius: 8px;
            }

            .alert-danger p {
                font-size: 13px;
                padding-left: 22px;
            }

            .error-message {
                font-size: 11px;
                margin-top: 6px;
            }

            /* Кнопки */
            .form-actions {
                padding-top: 15px;
                gap: 10px;
            }

            .btn-submit,
            .btn-cancel {
                padding: 14px 20px;
                border-radius: 8px;
            }

            .btn-submit {
                font-size: 14px;
            }

            .btn-cancel {
                font-size: 13px;
            }

            /* Превью */
            .employee-preview {
                padding: 15px;
                border-radius: 8px;
            }

            .preview-avatar {
                width: 60px;
                height: 60px;
                font-size: 24px;
            }

            .preview-name {
                font-size: 16px;
            }

            .preview-email {
                font-size: 13px;
            }

            .preview-id {
                font-size: 11px;
            }

            /* Успех */
            .success-message {
                top: 10px;
                right: 10px;
                left: 10px;
                padding: 12px 15px;
                font-size: 13px;
                border-radius: 8px;
            }

            /* Загрузка */
            .loading-spinner {
                width: 40px;
                height: 40px;
            }
        }

        /* 17. АНИМАЦИИ ЗАГРУЗКИ */
        .loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(255, 255, 255, 0.9);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }

        .loading-spinner {
            width: 50px;
            height: 50px;
            border: 3px solid #f3f3f3;
            border-top: 3px solid #212529;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        /* 18. УСПЕШНОЕ СООБЩЕНИЕ */
        .success-message {
            position: fixed;
            top: 30px;
            right: 30px;
            background: #212529;
            color: white;
            padding: 20px 25px;
            border-radius: 10px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
            display: none;
            align-items: center;
            gap: 12px;
            z-index: 1001;
            animation: slideInRight 0.3s ease;
        }

        @keyframes slideInRight {
            from {
                opacity: 0;
                transform: translateX(30px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        .success-message::before {
            content: "✓";
            font-size: 20px;
            color: #28a745;
        }

        /* 19. ТЕМНАЯ ТЕМА (АВТОМАТИЧЕСКАЯ) */
        @media (prefers-color-scheme: dark) {
            body {
                background: linear-gradient(135deg, #121212 0%, #1a1a1a 100%);
                color: #f8f9fa;
            }

            .form-card {
                background: #212529;
                border-color: #343a40;
            }

            .form-header {
                background: linear-gradient(to right, #2d3436, #212529);
                border-bottom-color: #343a40;
            }

            .form-header h2 {
                color: #f8f9fa;
            }

            .form-subtitle {
                color: #adb5bd;
            }

            .back-link {
                color: #adb5bd;
            }

            .back-link:hover {
                color: #f8f9fa;
            }

            .form-input {
                background: #2d3436;
                border-color: #495057;
                color: #f8f9fa;
            }

            .form-input:hover {
                border-color: #6c757d;
            }

            .form-input:focus {
                border-color: #f8f9fa;
                background: #343a40;
                box-shadow: 0 0 0 3px rgba(248, 249, 250, 0.1);
            }

            .form-label {
                color: #f8f9fa;
            }

            .employee-preview {
                background: #2d3436;
                border-color: #343a40;
            }

            .preview-name {
                color: #f8f9fa;
            }

            .preview-email {
                color: #adb5bd;
            }

            .btn-cancel {
                background: #2d3436;
                color: #adb5bd;
                border-color: #495057;
            }

            .btn-cancel:hover {
                background: #343a40;
                border-color: #6c757d;
                color: #f8f9fa;
            }

            .toggle-password {
                color: #adb5bd;
            }

            .toggle-password:hover {
                color: #f8f9fa;
            }

            .loading-overlay {
                background: rgba(18, 18, 18, 0.9);
            }

            .loading-spinner {
                border-color: #343a40;
                border-top-color: #f8f9fa;
            }

            /* Темная тема для мобильных */
            .success-message {
                background: #343a40;
                border: 1px solid #495057;
            }
        }
    </style>

    <div class="container">
        <div class="form-card">
            <div class="form-header">
                <h2>Добавить сотрудника</h2>
            </div>

            <div class="form-body">
                @if($errors->any())
                    <div class="alert-danger">
                        @foreach($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                <form action="{{ route('admin.store') }}" method="POST" id="employeeForm">
                    @csrf

                    <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                        <label class="form-label" for="name">Имя</label>
                        <input type="text" name="name" id="name" class="form-input"
                               value="{{ old('name') }}"
                               placeholder="Введите имя сотрудника"
                               required>
                        @if($errors->has('name'))
                            <div class="error-message">
                                {{ $errors->first('name') }}
                            </div>
                        @endif
                    </div>

                    <div class="form-group {{ $errors->has('surname') ? 'has-error' : '' }}">
                        <label class="form-label" for="surname">Фамилия</label>
                        <input type="text" name="surname" id="surname" class="form-input"
                               value="{{ old('surname') }}"
                               placeholder="Введите фамилию сотрудника"
                               required>
                        @if($errors->has('surname'))
                            <div class="error-message">
                                {{ $errors->first('surname') }}
                            </div>
                        @endif
                    </div>

                    <div class="form-group full-width {{ $errors->has('email') ? 'has-error' : '' }}">
                        <label class="form-label" for="email">Email</label>
                        <input type="email" name="email" id="email" class="form-input"
                               value="{{ old('email') }}"
                               placeholder="employee@company.com"
                               required>
                        @if($errors->has('email'))
                            <div class="error-message">
                                {{ $errors->first('email') }}
                            </div>
                        @endif
                    </div>

                    <div class="form-group full-width {{ $errors->has('password') ? 'has-error' : '' }}">
                        <label class="form-label" for="password">Пароль</label>
                        <div class="password-field">
                            <input type="password" name="password" id="password" class="form-input"
                                   placeholder="Создайте надежный пароль"
                                   required>
                            <button type="button" class="toggle-password" id="togglePassword"></button>
                        </div>

                        @if($errors->has('password'))
                            <div class="error-message">
                                {{ $errors->first('password') }}
                            </div>
                        @endif
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn-submit">
                            <span>Создать сотрудника</span>
                        </button>
                        <a href="{{ route('admin.employees') }}" class="btn-cancel">Отмена</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Индикатор загрузки -->
    <div class="loading-overlay" id="loadingOverlay">
        <div class="loading-spinner"></div>
    </div>

    <!-- Сообщение об успехе -->
    <div class="success-message" id="successMessage">
        Сотрудник успешно добавлен
    </div>

@endsection
