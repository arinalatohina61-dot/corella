@extends('layout.layouts')

@section('title', 'Регистрация')

@section('content')
    <style>
        footer, header, .breadcrumbs {
            display: none;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html, body {
            overflow: hidden;
            height: 100%;
        }

        :root {
            --black: #000000;
            --white: #FFFFFF;
            --gray-50: #FAFAFA;
            --gray-100: #F5F5F5;
            --gray-200: #EEEEEE;
            --gray-300: #E0E0E0;
            --gray-400: #BDBDBD;
            --gray-500: #9E9E9E;
            --gray-600: #757575;
            --gray-700: #616161;
            --gray-800: #424242;
            --gray-900: #212121;
            --transition: all 0.3s ease;
        }

        /* Main Container - Grid Layout */
        .registration-container {
            display: grid;
            grid-template-columns: 1fr 1fr;
            height: 100vh;
            background: var(--white);
            overflow: hidden;
        }

        @media (max-width: 1024px) {
            .registration-container {
                grid-template-columns: 1fr;
                grid-template-rows: 1fr 1fr;
                height: 100vh;
            }
        }

        /* Left Side - Fullscreen Image */
        .registration-image {
            position: relative;
            overflow: hidden;
            height: 100vh;
            width: 100%;
        }

        .plant-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center;
            display: block;
        }

        /* Overlay для лучшей читаемости текста на изображении */
        .image-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(
                135deg,
                rgba(0, 0, 0, 0.1) 0%,
                rgba(0, 0, 0, 0) 50%,
                rgba(0, 0, 0, 0.1) 100%
            );
            pointer-events: none;
        }

        /* Image placeholder если нет картинки */
        .image-placeholder {
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, var(--gray-100) 0%, var(--gray-200) 100%);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 1.5rem;
            position: relative;
        }

        .placeholder-icon {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            background: var(--gray-200);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1rem;
        }

        .placeholder-icon i {
            font-size: 4rem;
            color: var(--gray-400);
        }

        .placeholder-text {
            text-align: center;
            color: var(--gray-600);
            z-index: 1;
        }

        .placeholder-text h3 {
            font-size: 1.5rem;
            font-weight: 400;
            margin-bottom: 0.5rem;
            color: var(--gray-800);
        }

        .placeholder-text p {
            font-size: 0.875rem;
            line-height: 1.5;
            max-width: 300px;
        }

        /* Right Side - Form with Scroll */
        .registration-form-section {
            position: relative;
            overflow-y: auto;
            height: 100vh;
            background: var(--white);
            padding: 0;
        }

        .form-wrapper {
            min-height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 3rem 2rem;
            max-width: 600px;
            margin: 0 auto;
        }

        @media (max-width: 1024px) {
            .registration-form-section {
                height: auto;
                max-height: 50vh;
                overflow-y: auto;
            }

            .form-wrapper {
                padding: 2rem 1.5rem;
                justify-content: flex-start;
            }
        }

        .form-header {
            margin-bottom: 3rem;
            text-align: center;
        }

        .logo {
            display: inline-flex;
            align-items: center;
            gap: 0.75rem;
            margin-bottom: 2rem;
            font-family: 'Playfair Display', serif;
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--black);
            text-decoration: none;
        }

        .logo-icon {
            width: 40px;
            height: 40px;
            background: var(--black);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--white);
        }

        .logo-icon i {
            font-size: 1.25rem;
        }

        .form-title {
            font-family: 'Playfair Display', serif;
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--black);
            margin-bottom: 0.5rem;
            line-height: 1.1;
        }

        .form-subtitle {
            font-size: 1rem;
            color: var(--gray-600);
            line-height: 1.5;
            margin-bottom: 2rem;
        }

        /* Form Styles */
        .registration-form {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .form-label {
            font-size: 0.875rem;
            font-weight: 500;
            color: var(--gray-800);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .label-text {
            display: flex;
            align-items: center;
            gap: 0.25rem;
        }

        .required {
            color: var(--gray-700);
            font-size: 0.75rem;
        }

        /* Input fields */
        .input-wrapper {
            position: relative;
            display: flex;
            align-items: center;
            border: 1px solid var(--gray-300);
            border-radius: 8px;
            transition: var(--transition);
            overflow: hidden;
            background: var(--white);
        }

        .input-wrapper:hover {
            border-color: var(--gray-400);
        }

        .input-wrapper:focus-within {
            border-color: var(--black);
            box-shadow: 0 0 0 2px rgba(0, 0, 0, 0.05);
        }

        .input-wrapper.error {
            border-color: var(--gray-700);
            animation: shake 0.5s ease;
        }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-5px); }
            75% { transform: translateX(5px); }
        }

        .input-wrapper input {
            flex: 1;
            padding: 1rem 1.25rem;
            border: none;
            font-size: 1rem;
            color: var(--black);
            background: transparent;
            outline: none;
            width: 100%;
            font-family: inherit;
        }

        .input-wrapper input::placeholder {
            color: var(--gray-400);
        }

        .input-icon {
            width: 48px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--gray-500);
            font-size: 1rem;
        }

        .toggle-password {
            position: absolute;
            right: 1rem;
            background: none;
            border: none;
            color: var(--gray-400);
            cursor: pointer;
            padding: 0.5rem;
            border-radius: 4px;
            transition: var(--transition);
            z-index: 3;
        }

        .toggle-password:hover {
            color: var(--black);
            background: var(--gray-100);
        }

        .toggle-password i {
            font-size: 1.125rem;
        }

        /* Error messages */
        .error-message {
            font-size: 0.75rem;
            color: var(--gray-700);
            margin-top: 0.25rem;
            padding-left: 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.375rem;
        }

        .error-message::before {
            content: '!';
            width: 16px;
            height: 16px;
            background: var(--gray-700);
            color: var(--white);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.7rem;
            font-weight: bold;
        }

        .error-card {
            padding: 1rem;
            background: var(--gray-50);
            border: 1px solid var(--gray-300);
            border-radius: 8px;
            font-size: 0.875rem;
            text-align: center;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.75rem;
            animation: slideIn 0.5s ease;
            color: red;
        }
        .error-card i {
            color: red;
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

        /* Submit button */
        .btn-submit {
            padding: 1rem;
            background: var(--black);
            color: var(--white);
            border: 1px solid var(--black);
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 500;
            cursor: pointer;
            transition: var(--transition);
            margin-top: 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.75rem;
            position: relative;
            overflow: hidden;
        }

        .btn-submit:hover:not(:disabled) {
            background: var(--gray-900);
            border-color: var(--gray-900);
            transform: translateY(-1px);
        }

        .btn-submit:disabled {
            opacity: 0.5;
            cursor: not-allowed;
            transform: none;
        }

        .btn-submit i {
            font-size: 1.125rem;
        }

        /* Login link */
        .form-footer {
            text-align: center;
            margin-top: 2rem;
            padding-top: 2rem;
            border-top: 1px solid var(--gray-200);
        }

        .footer-text {
            font-size: 0.875rem;
            color: var(--gray-600);
        }

        .footer-link {
            color: var(--black);
            font-weight: 500;
            text-decoration: none;
            margin-left: 0.5rem;
            transition: var(--transition);
        }

        .footer-link:hover {
            text-decoration: underline;
        }

        /* Terms checkbox */
        .checkbox-group {
            margin-top: 1rem;
            padding: 1rem;
            background: var(--gray-50);
            border-radius: 8px;
            border: 1px solid var(--gray-200);
        }

        .checkbox-label {
            display: flex;
            align-items: flex-start;
            gap: 0.75rem;
            cursor: pointer;
            font-size: 0.875rem;
            color: var(--gray-800);
            line-height: 1.5;
        }

        .checkbox-label input[type="checkbox"] {
            display: none;
        }

        .checkbox-custom {
            width: 20px;
            height: 20px;
            border: 1px solid var(--gray-300);
            border-radius: 4px;
            position: relative;
            transition: var(--transition);
            flex-shrink: 0;
            margin-top: 0.125rem;
            background: var(--white);
        }

        .checkbox-label input[type="checkbox"]:checked + .checkbox-custom {
            background: var(--black);
            border-color: var(--black);
        }

        .checkbox-label input[type="checkbox"]:checked + .checkbox-custom::after {
            content: '✓';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: var(--white);
            font-size: 0.75rem;
            font-weight: bold;
        }

        .terms-link {
            color: var(--black);
            text-decoration: underline;
            transition: var(--transition);
        }

        .terms-link:hover {
            color: var(--gray-700);
        }

        /* Loading spinner */
        .spinner {
            width: 20px;
            height: 20px;
            border: 2px solid var(--gray-300);
            border-top-color: var(--black);
            border-radius: 50%;
            animation: spin 0.6s linear infinite;
            display: inline-block;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        /* Responsive */
        @media (max-width: 1024px) {
            .registration-container {
                grid-template-rows: 1fr 1fr;
                height: 100vh;
            }

            .registration-image {
                height: 50vh;
                min-height: 300px;
            }

            .registration-form-section {
                height: 50vh;
                max-height: none;
                overflow-y: auto;
            }

            .form-wrapper {
                padding: 1.5rem;
            }

            .form-title {
                font-size: 2rem;
            }
        }

        @media (max-width: 480px) {
            .registration-image {
                height: 40vh;
                min-height: 250px;
            }

            .registration-form-section {
                height: 60vh;
            }

            .form-wrapper {
                padding: 1.25rem;
            }

            .form-title {
                font-size: 1.75rem;
            }

            .placeholder-icon {
                width: 80px;
                height: 80px;
            }

            .placeholder-icon i {
                font-size: 2.5rem;
            }
        }

        /* Custom scrollbar for form section */
        .registration-form-section::-webkit-scrollbar {
            width: 6px;
        }

        .registration-form-section::-webkit-scrollbar-track {
            background: var(--gray-100);
        }

        .registration-form-section::-webkit-scrollbar-thumb {
            background: var(--gray-400);
            border-radius: 3px;
        }

        .registration-form-section::-webkit-scrollbar-thumb:hover {
            background: var(--gray-500);
        }
        .form-box {
            display: flex;
            gap: 10px;
        }
    </style>

    <div class="registration-container">
        <div class="registration-image">
            <img src="{{ asset('image/register-image.jpg') }}" alt="Комнатные растения" class="plant-image">
            <div class="image-overlay"></div>
        </div>

        <!-- Right Side - Form with Scroll -->
        <div class="registration-form-section">
            <div class="form-wrapper">
                <div class="form-header">
                    <h1 class="form-title">Регистрация</h1>
                    <p class="form-subtitle">Создайте аккаунт для удобных покупок</p>
                </div>

                <form action="{{ route('signup.send') }}" method="post" class="registration-form" id="registrationForm">
                    @csrf

                    <div class="form-box">
                        <!-- Name -->
                        <div class="form-group">
                            <label for="name" class="form-label">
                                <span class="label-text">Имя <span class="required">*</span></span>
                            </label>
                            <div class="input-wrapper @error('name') error @enderror">
                                <div class="input-icon">
                                    <i class="fas fa-user"></i>
                                </div>
                                <input
                                    type="text"
                                    id="name"
                                    name="name"
                                    placeholder="Введите имя"
                                    value="{{ old('name') }}"
                                >
                            </div>
                            @error('name')
                            <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Surname -->
                        <div class="form-group">
                            <label for="surname" class="form-label">
                                <span class="label-text">Фамилия <span class="required">*</span></span>
                            </label>
                            <div class="input-wrapper @error('surname') error @enderror">
                                <div class="input-icon">
                                    <i class="fas fa-user"></i>
                                </div>
                                <input
                                    type="text"
                                    id="surname"
                                    name="surname"
                                    placeholder="Введите фамилию"
                                    value="{{ old('surname') }}"
                                >
                            </div>
                            @error('surname')
                            <div class="error-message">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Email -->
                    <div class="form-group">
                        <label for="email" class="form-label">
                            <span class="label-text">Email <span class="required">*</span></span>
                        </label>
                        <div class="input-wrapper @error('email') error @enderror">
                            <div class="input-icon">
                                <i class="fas fa-envelope"></i>
                            </div>
                            <input
                                type="email"
                                id="email"
                                name="email"
                                placeholder="Введите email"
                                value="{{ old('email') }}"
                            >
                        </div>
                        @error('email')
                        <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Phone -->
                    <div class="form-group">
                        <label for="phone" class="form-label">
                            <span class="label-text">Телефон <span class="required">*</span></span>
                        </label>
                        <div class="input-wrapper @error('phone') error @enderror">
                            <div class="input-icon">
                                <i class="fas fa-phone"></i>
                            </div>
                            <input
                                type="tel"
                                id="phone"
                                name="phone"
                                placeholder="Введите телефон"
                                value="{{ old('phone') }}"
                            >
                        </div>
                        @error('phone')
                        <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="form-group">
                        <label for="password" class="form-label">
                            <span class="label-text">Пароль <span class="required">*</span></span>
                        </label>
                        <div class="input-wrapper @error('password') error @enderror">
                            <div class="input-icon">
                                <i class="fas fa-lock"></i>
                            </div>
                            <input
                                type="password"
                                id="password"
                                name="password"
                                placeholder="Введите пароль"
                            >
                        </div>
                        @error('password')
                        <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    @error('auth_error')
                    <div class="error-card">
                        <i class="fas fa-exclamation-circle"></i>
                        {{ $message }}
                    </div>
                    @enderror

                    <!-- Submit button -->
                    <button type="submit" class="btn-submit" id="submitBtn">
                        <i class="fas fa-user-plus"></i>
                        <span>Зарегистрироваться</span>
                    </button>

                    <!-- Login link -->
                    <div class="form-footer">
                        <p class="footer-text">
                            Уже есть аккаунт?
                            <a href="{{ route('login1') }}" class="footer-link">
                                Войти
                            </a>
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Success Modal -->
    <div id="successModal" class="modal-overlay" style="display: none;">
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-icon">
                    <i class="fas fa-check"></i>
                </div>
                <h2 class="modal-title">Регистрация успешна!</h2>
                <p class="modal-subtitle">Добро пожаловать в Зеленый Дом</p>
            </div>
            <div class="modal-body">
                <p>Ваш аккаунт успешно создан. На указанный email отправлено письмо с подтверждением.</p>
                <p>Теперь вы можете войти в систему и начать покупки.</p>
            </div>
            <div class="modal-footer">
                <button class="modal-btn-secondary" onclick="closeModal()">
                    Продолжить
                </button>
                <button class="modal-btn-primary" onclick="window.location.href='{{ route('login1') }}'">
                    Войти в аккаунт
                </button>
            </div>
        </div>
    </div>
@endsection
