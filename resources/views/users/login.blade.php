@extends('users.layout')

@section('title', 'Вход для сотрудников')

@section('content')
    <style>
        body, html {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            height: 100%;
            background: #f5f5f5;
        }

        .login-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .login-box {
            background: #fff;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 400px;
        }

        .login-box h1 {
            text-align: center;
            margin-bottom: 1.5rem;
            font-size: 1.75rem;
            color: #333;
        }

        .form-group {
            margin-bottom: 1rem;
        }

        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
            color: #555;
        }

        .form-group input {
            width: 100%;
            padding: 0.75rem 1rem;
            border-radius: 5px;
            border: 1px solid #ccc;
            font-size: 1rem;
            outline: none;
            transition: 0.3s;
        }

        .form-group input:focus {
            border-color: #333;
        }

        .btn-submit {
            width: 100%;
            padding: 0.75rem;
            background: #333;
            color: #fff;
            font-size: 1rem;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: 0.3s;
        }

        .btn-submit:hover {
            background: #555;
        }

        .error-message {
            background: #ffe5e5;
            border: 1px solid #ffcccc;
            padding: 0.75rem 1rem;
            border-radius: 5px;
            margin-bottom: 1rem;
            color: #cc0000;
            font-size: 0.875rem;
        }

        .form-footer {
            text-align: center;
            margin-top: 1rem;
            font-size: 0.875rem;
            color: #555;
        }

        .form-footer a {
            color: #333;
            text-decoration: none;
            font-weight: 500;
        }

        .form-footer a:hover {
            text-decoration: underline;
        }
    </style>

    <div class="login-container">
        <div class="login-box">
            <h1>Вход для сотрудников</h1>

            @if($errors->has('status'))
                <div class="error-message">Неверный email или пароль</div>
            @endif

            <form method="POST" action="{{ route('staff.login.submit') }}">
                @csrf

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus>
                </div>

                <div class="form-group">
                    <label for="password">Пароль</label>
                    <input type="password" id="password" name="password" required>
                </div>

                <button type="submit" class="btn-submit">Войти</button>
            </form>
        </div>
    </div>
@endsection
