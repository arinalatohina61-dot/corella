<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="icon" href="{{ asset('image/logo.jpg') }}">
    <style>
        /* Общие стили */
        .edit-row {
            display: flex;
            flex-wrap: wrap;
            gap: 2rem;
            max-width: 900px;
            margin: 2rem auto;
            font-family: Arial, sans-serif;
        }

        /* Колонки */
        .edit-image-column,
        .edit-form-column {
            flex: 1 1 300px;
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        /* Заголовки */
        h2, h3 {
            margin: 0 0 1rem 0;
            color: #333;
        }

        /* Поля формы */
        .form-group {
            display: flex;
            flex-direction: column;
            gap: 0.3rem;
        }

        label {
            font-weight: bold;
        }

        input[type="text"],
        input[type="number"],
        input[type="file"],
        select,
        textarea {
            padding: 0.5rem;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 1rem;
            width: 100%;
        }

        /* Ошибки */
        .alert {
            padding: 0.5rem 1rem;
            border-radius: 4px;
            font-size: 0.9rem;
            margin-bottom: 1rem;
        }

        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        /* Подсказки под полями */
        .form-group p {
            font-size: 12px;
            color: #666;
        }

        /* Кнопки */
        .form-buttons {
            display: flex;
            gap: 1rem;
            margin-top: 1rem;
        }

        .btn-save,
        .btn-cancel {
            padding: 0.5rem 1rem;
            border: none;
            border-radius: 4px;
            font-size: 1rem;
            cursor: pointer;
            text-decoration: none;
        }

        .btn-save {
            background-color: #28a745;
            color: #fff;
        }

        .btn-cancel {
            background-color: #ccc;
            color: #333;
        }

        .btn-save:hover {
            background-color: #218838;
        }

        .btn-cancel:hover {
            background-color: #b3b3b3;
        }

        /* Заголовки */
        h2, h3 {
            margin-bottom: 1rem;
            color: #333;
        }

        /* Форма */
        .edit-form-column {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        /* Поля формы */
        .form-group {
            display: flex;
            flex-direction: column;
        }

        label {
            margin-bottom: 0.3rem;
            font-weight: bold;
        }

        input[type="text"],
        textarea {
            padding: 0.5rem;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 1rem;
            width: 100%;
        }

        /* Ошибки формы */
        .form-error {
            color: red;
            font-size: 0.875rem;
            margin-top: 0.2rem;
        }

        /* Кнопки */
        .form-buttons {
            display: flex;
            gap: 1rem;
            margin-top: 1rem;
        }

        .btn-save,
        .btn-cancel {
            padding: 0.5rem 1rem;
            border: none;
            border-radius: 4px;
            text-decoration: none;
            font-size: 1rem;
            cursor: pointer;
        }

        .btn-save {
            background-color: #28a745;
            color: white;
        }

        .btn-cancel {
            background-color: #ccc;
            color: #333;
        }

        .btn-save:hover {
            background-color: #218838;
        }

        .btn-cancel:hover {
            background-color: #b3b3b3;
        }

        /* Alert */
        .alert {
            padding: 0.5rem 1rem;
            border: 1px solid red;
            border-radius: 4px;
            background-color: #ffe6e6;
            color: red;
        }
        /* Заголовки */
        h3 {
            margin: 0;
            color: #333;
        }

        /* Кнопки */
        .btn {
            padding: 0.4rem 0.8rem;
            border-radius: 4px;
            text-decoration: none;
            font-size: 0.9rem;
            cursor: pointer;
            border: none;
        }

        .btn-primary {
            background-color: #007bff;
            color: #fff;
        }

        .btn-edit {
            background-color: #ffc107;
            color: #333;
        }

        .btn-delete {
            background-color: #dc3545;
            color: #fff;
        }

        .btn:hover {
            opacity: 0.9;
        }

        /* Alerts */
        .alert {
            margin: 1rem 0;
            padding: 0.5rem 1rem;
            border-radius: 4px;
            font-size: 0.9rem;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        /* Сетка категорий */
        .products-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 1rem;
            margin-top: 1.5rem;
        }

        /* Карточка категории */
        .category-card {
            border: 1px solid #ccc;
            border-radius: 6px;
            padding: 1rem;
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
            background-color: #fafafa;
        }

        /* Заголовки карточек */
        .category-card .title {
            font-weight: bold;
            margin: 0;
        }

        /* Описание */
        .category-card .description {
            font-size: 0.9rem;
            color: #555;
            margin: 0.2rem 0 0.5rem 0;
        }

        /* Действия */
        .actions {
            display: flex;
            gap: 0.5rem;
            margin-top: auto;
        }


    </style>
</head>
<body>
<header class="header">
    <div class="container header-container">
        @php
            $user = auth()->user();
        @endphp

        {{-- Левая навигация --}}
        <nav class="nav-left nav-links">
            @if($user && strtolower($user->role->name) === 'admin')
                <a href="/products-panel">товары</a>
                <a href="/categories">категории</a>
            @endif
        </nav>

        <a href="/" class="logo">корелла</a>

        {{-- Правая навигация --}}
        <nav class="nav-right nav-links">
            @if($user)
                @if(strtolower($user->role->name) === 'admin')
                    <a href="/admin/employees">сотрудники</a>
                    <a href="/admin/orders">заказы</a>
                    <a href="/admin/logout">выход</a>
                @elseif(strtolower($user->role->name) === 'manager')
                    <a href="/orders">заказы</a>
                    <a href="/staff/logout">выход</a>
                @endif
            @else
                <a href="{{ route('staff.login') }}">Вход</a>
            @endif
        </nav>
    </div>
</header>


<div class="content">
    @yield('content')
</div>
</body>
</html>
