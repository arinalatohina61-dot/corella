@extends('layout.layouts')

@section('title', 'Вход в аккаунт')

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
            height: 100%;
            overflow-x: hidden;
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

        .login-container {
            display: grid;
            grid-template-columns: 1fr 1fr;
            min-height: 100vh;
            min-height: 100dvh;
            background: var(--white);
        }

        @media (max-width: 1024px) {
            .login-container {
                grid-template-columns: 1fr;
                grid-template-rows: auto 1fr;
            }
        }

        .login-image {
            position: relative;
            overflow: hidden;
            height: 100vh;
            height: 100dvh;
            width: 100%;
        }

        .plant-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center;
            display: block;
        }

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

        .image-placeholder {
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, var(--gray-100) 0%, var(--gray-200) 100%);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 1.5rem;
        }

        .placeholder-icon {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            background: var(--gray-200);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .placeholder-icon i {
            font-size: 4rem;
            color: var(--gray-400);
        }

        .placeholder-text {
            text-align: center;
            color: var(--gray-600);
            padding: 0 2rem;
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
        }

        .login-form-section {
            position: relative;
            overflow-y: auto;
            height: 100vh;
            height: 100dvh;
            background: var(--white);
        }

        .form-wrapper {
            min-height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding: 3rem 2rem;
            max-width: 400px;
            margin: 0 auto;
        }

        @media (max-width: 1024px) {
            .login-image {
                height: 40vh;
                height: 40dvh;
                min-height: 250px;
            }

            .login-form-section {
                height: auto;
                min-height: 60vh;
                min-height: 60dvh;
                overflow-y: visible;
            }

            .form-wrapper {
                padding: 2rem 1.5rem;
                justify-content: flex-start;
                padding-top: 2rem;
                padding-bottom: 2rem;
            }
        }

        .form-header {
            margin-bottom: 3rem;
            text-align: center;
        }

        .form-title {
            font-family: 'Playfair Display', serif;
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--black);
            margin-bottom: 0.5rem;
        }

        .form-subtitle {
            font-size: 1rem;
            color: var(--gray-600);
        }

        .login-form {
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
        }

        .input-wrapper {
            position: relative;
            display: flex;
            align-items: center;
            border: 1px solid var(--gray-300);
            border-radius: 8px;
            transition: var(--transition);
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
            padding: 1rem 3rem 1rem 1.25rem;
            border: none;
            font-size: 1rem;
            color: var(--black);
            background: transparent;
            outline: none;
            width: 100%;
        }

        .input-wrapper input::placeholder {
            color: var(--gray-400);
        }

        .input-icon {
            position: absolute;
            left: 1rem;
            color: var(--gray-500);
            font-size: 1rem;
            pointer-events: none;
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

        .error-message {
            font-size: 0.75rem;
            color: var(--gray-700);
            margin-top: 0.25rem;
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
            background: var(--white);
            border: 1px solid var(--gray-300);
            border-radius: 8px;
            color: var(--gray-800);
            font-size: 0.875rem;
            text-align: center;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.75rem;
            animation: slideIn 0.5s ease;
        }

        @keyframes slideIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }

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
            margin-top: 0.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.75rem;
        }

        .btn-submit:hover:not(:disabled) {
            background: var(--gray-900);
            border-color: var(--gray-900);
            transform: translateY(-1px);
        }

        .btn-submit:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

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
        }

        .footer-link:hover {
            text-decoration: underline;
        }

        /* Toast Notification */
        .toast {
            position: fixed;
            top: 20px;
            right: 20px;
            background: var(--gray-800);
            color: var(--white);
            padding: 1rem 1.5rem;
            border-radius: 8px;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.16);
            z-index: 1200;
            animation: slideInRight 0.3s ease;
            max-width: 400px;
            font-size: 0.875rem;
        }

        @keyframes slideInRight {
            from { transform: translateX(100%); opacity: 0; }
            to { transform: translateX(0); opacity: 1; }
        }

        @keyframes slideOutRight {
            from { transform: translateX(0); opacity: 1; }
            to { transform: translateX(100%); opacity: 0; }
        }

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

        @media (max-width: 1024px) {
            .form-title {
                font-size: 2rem;
            }
        }

        @media (max-width: 768px) {
            .login-image {
                height: 35vh;
                height: 35dvh;
                min-height: 200px;
            }

            .form-wrapper {
                padding: 1.5rem 1.25rem;
            }

            .form-header {
                margin-bottom: 2rem;
            }

            .form-title {
                font-size: 1.875rem;
            }

            .form-subtitle {
                font-size: 0.9375rem;
            }

            .login-form {
                gap: 1.25rem;
            }

            .input-wrapper input {
                padding: 0.875rem 2.75rem 0.875rem 1.125rem;
                font-size: 0.9375rem;
            }

            .btn-submit {
                padding: 0.875rem;
                font-size: 0.9375rem;
            }
        }

        @media (max-width: 480px) {
            .login-image {
                height: 30vh;
                height: 30dvh;
                min-height: 180px;
            }

            .form-wrapper {
                padding: 1.25rem 1rem;
            }

            .form-header {
                margin-bottom: 1.5rem;
            }

            .form-title {
                font-size: 1.75rem;
            }

            .form-subtitle {
                font-size: 0.875rem;
            }

            .placeholder-icon {
                width: 80px;
                height: 80px;
            }

            .placeholder-icon i {
                font-size: 2.5rem;
            }

            .placeholder-text h3 {
                font-size: 1.25rem;
            }

            .placeholder-text p {
                font-size: 0.8125rem;
            }

            .login-form {
                gap: 1rem;
            }

            .form-label {
                font-size: 0.8125rem;
            }

            .input-wrapper input {
                padding: 0.75rem 2.5rem 0.75rem 1rem;
                font-size: 0.875rem;
            }

            .input-icon {
                font-size: 0.875rem;
            }

            .btn-submit {
                padding: 0.75rem;
                font-size: 0.875rem;
                gap: 0.5rem;
            }

            .form-footer {
                margin-top: 1.5rem;
                padding-top: 1.5rem;
            }

            .footer-text {
                font-size: 0.8125rem;
            }

            .toast {
                top: 10px;
                right: 10px;
                left: 10px;
                max-width: none;
                padding: 0.875rem 1.25rem;
                font-size: 0.8125rem;
            }
        }
    </style>

    <div class="login-container">
        <div class="login-image">
            @if(file_exists(public_path('image/login-image.jpg')))
                <img src="{{ asset('image/login-image.jpg') }}" alt="Комнатные растения" class="plant-image">
            @else
                <div class="image-placeholder">
                    <div class="placeholder-icon">
                        <i class="fas fa-leaf"></i>
                    </div>
                    <div class="placeholder-text">
                        <h3>Зеленый Дом</h3>
                        <p>Добро пожаловать в мир комнатных растений</p>
                    </div>
                </div>
            @endif
            <div class="image-overlay"></div>
        </div>

        <div class="login-form-section">
            <div class="form-wrapper">
                <div class="form-header">
                    <h1 class="form-title">Войти в аккаунт</h1>
                    <p class="form-subtitle">Войдите, чтобы продолжить покупки</p>
                </div>

                <form method="POST" action="{{ route('login') }}" class="login-form" id="loginForm">
                    @csrf

                    <div class="form-group">
                        <label for="email" class="form-label">Email адрес</label>
                        <div class="input-wrapper @error('email') error @enderror">
                            <div class="input-icon">
                                <i class="fas fa-envelope"></i>
                            </div>
                            <input
                                type="email"
                                id="email"
                                name="email"
                                value="{{ old('email') }}"
                                placeholder="your.email@example.com"
                                required
                                autofocus
                            >
                        </div>
                        @error('email')
                        <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="password" class="form-label">Пароль</label>
                        <div class="input-wrapper @error('password') error @enderror">
                            <div class="input-icon">
                                <i class="fas fa-lock"></i>
                            </div>
                            <input
                                type="password"
                                id="password"
                                name="password"
                                placeholder="Введите ваш пароль"
                                required
                            >
                            <button type="button" class="toggle-password" onclick="togglePasswordVisibility()">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                        @error('password')
                        <div class="error-message">{{ $message }}</div>
                        @enderror
                    </div>

                    @if ($errors->has('auth_error'))
                        <div class="error-card">
                            <i class="fas fa-exclamation-circle"></i>
                            {{ $errors->first('auth_error') }}
                        </div>
                    @endif

                    <button type="submit" class="btn-submit">
                        <i class="fas fa-sign-in-alt"></i>
                        <span>Войти в аккаунт</span>
                    </button>

                    <div class="form-footer">
                        <p class="footer-text">
                            Ещё нет аккаунта?
                            <a href="{{ route('signup') }}" class="footer-link">
                                Зарегистрироваться
                            </a>
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function togglePasswordVisibility() {
            const passwordInput = document.getElementById('password');
            const toggleButton = document.querySelector('.toggle-password i');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleButton.classList.remove('fa-eye');
                toggleButton.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                toggleButton.classList.remove('fa-eye-slash');
                toggleButton.classList.add('fa-eye');
            }
        }

        document.getElementById('loginForm').addEventListener('submit', function(e) {
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

            if (!emailRegex.test(email)) {
                e.preventDefault();
                showToast('Пожалуйста, введите корректный email адрес');
                return;
            }

            if (password.length < 6) {
                e.preventDefault();
                showToast('Пароль должен содержать минимум 6 символов');
                return;
            }

            const submitBtn = this.querySelector('.btn-submit');
            const originalText = submitBtn.innerHTML;
            submitBtn.innerHTML = '<div class="spinner"></div><span>Вход...</span>';
            submitBtn.disabled = true;

            setTimeout(() => {
                if (submitBtn.disabled) {
                    submitBtn.innerHTML = originalText;
                    submitBtn.disabled = false;
                }
            }, 3000);
        });

        function showToast(message) {
            const existingToast = document.querySelector('.toast');
            if (existingToast) {
                existingToast.remove();
            }

            const toast = document.createElement('div');
            toast.className = 'toast';
            toast.innerHTML = `
                <div class="toast-icon">i</div>
                <div class="toast-message">${message}</div>
            `;

            toast.style.cssText = `
                position: fixed;
                top: 20px;
                right: 20px;
                background: var(--gray-800);
                color: var(--white);
                padding: 1rem 1.5rem;
                border-radius: 8px;
                display: flex;
                align-items: center;
                gap: 0.75rem;
                box-shadow: 0 4px 20px rgba(0, 0, 0, 0.16);
                z-index: 1200;
                animation: slideInRight 0.3s ease;
                max-width: 400px;
                font-size: 0.875rem;
            `;

            document.body.appendChild(toast);

            setTimeout(() => {
                toast.style.animation = 'slideOutRight 0.3s ease';
                setTimeout(() => toast.remove(), 300);
            }, 4000);
        }

        document.addEventListener('DOMContentLoaded', function() {
            const image = document.querySelector('.plant-image') || document.querySelector('.image-placeholder');
            if (image) {
                image.style.opacity = '0';
                image.style.transform = 'scale(1.1)';

                setTimeout(() => {
                    image.style.transition = 'opacity 0.8s ease, transform 0.8s ease';
                    image.style.opacity = '1';
                    image.style.transform = 'scale(1)';
                }, 300);
            }

            const formWrapper = document.querySelector('.form-wrapper');
            if (formWrapper) {
                formWrapper.style.opacity = '0';
                formWrapper.style.transform = 'translateY(20px)';

                setTimeout(() => {
                    formWrapper.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
                    formWrapper.style.opacity = '1';
                    formWrapper.style.transform = 'translateY(0)';
                }, 600);
            }

            document.getElementById('email').focus();
        });
    </script>
@endsection
