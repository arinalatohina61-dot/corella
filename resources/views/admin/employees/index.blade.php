@extends('users.layout')

@section('title', 'Сотрудники')

@section('content')
    <style>
        /* ===== СТИЛИ АДМИНСКОЙ ЧАСТИ СОТРУДНИКОВ ===== */

        /* 1. БАЗОВЫЕ СТИЛИ */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            background: #f8f9fa;
            color: #212529;
            line-height: 1.6;
        }

        .container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 30px;
        }

        /* 2. ЗАГОЛОВОК И КНОПКИ */
        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 40px;
            padding-bottom: 20px;
            border-bottom: 2px solid #e9ecef;
        }

        .page-header h1 {
            font-size: 32px;
            font-weight: 700;
            color: #212529;
            letter-spacing: -0.5px;
        }

        /* 3. КНОПКА ДОБАВЛЕНИЯ */
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 14px 28px;
            background: #212529;
            color: white;
            text-decoration: none;
            border: none;
            border-radius: 8px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.25s ease;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .btn:hover {
            background: #343a40;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .btn:active {
            transform: translateY(0);
        }

        /* 4. ТАБЛИЦА СОТРУДНИКОВ */
        .employees-table {
            width: 100%;
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            border: 1px solid #e9ecef;
            margin-top: 30px;
        }

        .table-header {
            display: grid;
            grid-template-columns: 80px minmax(200px, 1fr) minmax(250px, 1fr) 180px 150px;
            background: #f8f9fa;
            padding: 18px 24px;
            border-bottom: 2px solid #e9ecef;
            font-weight: 600;
            color: #495057;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .table-row {
            display: grid;
            grid-template-columns: 80px minmax(200px, 1fr) minmax(250px, 1fr) 180px 150px;
            padding: 20px 24px;
            border-bottom: 1px solid #e9ecef;
            align-items: center;
            transition: all 0.2s ease;
            position: relative;
        }

        .table-row:hover {
            background: #f8f9fa;
            transform: scale(1.005);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        .table-row:last-child {
            border-bottom: none;
        }

        /* 5. ЯЧЕЙКИ ТАБЛИЦЫ */
        .cell {
            padding: 8px 4px;
            font-size: 15px;
            color: #212529;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .cell-id {
            font-weight: 600;
            color: #6c757d;
            font-family: 'Courier New', monospace;
        }

        .cell-name {
            font-weight: 500;
            color: #212529;
        }

        .cell-email {
            color: #495057;
            direction: ltr;
            unicode-bidi: embed;
        }

        .cell-date {
            color: #6c757d;
            font-size: 14px;
        }

        /* 6. ДЕЙСТВИЯ */
        .actions-cell {
            display: flex;
            gap: 12px;
            align-items: center;
        }

        .action-btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 16px;
            border-radius: 6px;
            text-decoration: none;
            font-size: 13px;
            font-weight: 500;
            transition: all 0.2s ease;
            cursor: pointer;
        }

        .action-delete {
            background: #f8f9fa;
            color: #dc3545;
            border: 1px solid #dc3545;
        }

        .action-delete:hover {
            background: #dc3545;
            color: white;
            transform: translateY(-1px);
            box-shadow: 0 2px 6px rgba(220, 53, 69, 0.2);
        }

        .action-edit {
            background: #f8f9fa;
            color: #495057;
            border: 1px solid #dee2e6;
        }

        .action-edit:hover {
            background: #e9ecef;
            border-color: #adb5bd;
            transform: translateY(-1px);
        }

        .action-edit::before {
            content: "✏️";
            font-size: 12px;
        }

        /* 7. СТАТУС БАДЖИ */
        .status-badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }

        .status-active {
            background: rgba(40, 167, 69, 0.1);
            color: #28a745;
            border: 1px solid rgba(40, 167, 69, 0.2);
        }

        .status-inactive {
            background: rgba(108, 117, 125, 0.1);
            color: #6c757d;
            border: 1px solid rgba(108, 117, 125, 0.2);
        }

        /* 8. ПОИСК И ФИЛЬТРЫ */
        .filters-container {
            background: white;
            padding: 24px;
            border-radius: 12px;
            margin-bottom: 30px;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.05);
            border: 1px solid #e9ecef;
        }

        .search-box {
            position: relative;
            max-width: 400px;
        }

        .search-input {
            width: 100%;
            padding: 14px 20px 14px 48px;
            border: 2px solid #e9ecef;
            border-radius: 8px;
            font-size: 15px;
            transition: all 0.25s ease;
            background: white;
            color: #212529;
        }

        .search-input:focus {
            outline: none;
            border-color: #212529;
            box-shadow: 0 0 0 3px rgba(33, 37, 41, 0.1);
        }

        .search-icon {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: #6c757d;
            font-size: 16px;
        }

        /* 9. ПАГИНАЦИЯ */
        .pagination {
            display: flex;
            justify-content: center;
            gap: 8px;
            margin-top: 40px;
            padding: 24px;
            background: white;
            border-radius: 12px;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.05);
            border: 1px solid #e9ecef;
            flex-wrap: wrap;
        }

        .page-link {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            border: 1px solid #e9ecef;
            border-radius: 6px;
            color: #495057;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.2s ease;
            background: white;
        }

        .page-link:hover {
            background: #f8f9fa;
            border-color: #adb5bd;
            transform: translateY(-1px);
        }

        .page-link.active {
            background: #212529;
            color: white;
            border-color: #212529;
        }

        .page-link.disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        .page-link.disabled:hover {
            transform: none;
            background: white;
        }

        /* 10. ПУСТОЙ СОСТОЯНИЕ */
        .empty-state {
            text-align: center;
            padding: 80px 20px;
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            border: 1px solid #e9ecef;
            margin-top: 30px;
        }

        .empty-state-icon {
            font-size: 64px;
            margin-bottom: 24px;
            opacity: 0.3;
        }

        .empty-state h3 {
            font-size: 24px;
            color: #212529;
            margin-bottom: 12px;
            font-weight: 600;
        }

        .empty-state p {
            color: #6c757d;
            margin-bottom: 30px;
            max-width: 400px;
            margin-left: auto;
            margin-right: auto;
        }

        /* 11. СТАТИСТИКА */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: white;
            padding: 24px;
            border-radius: 12px;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.05);
            border: 1px solid #e9ecef;
            transition: all 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        }

        .stat-value {
            font-size: 32px;
            font-weight: 700;
            color: #212529;
            margin-bottom: 8px;
        }

        .stat-label {
            color: #6c757d;
            font-size: 14px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-weight: 600;
        }

        .stat-icon {
            font-size: 24px;
            margin-bottom: 16px;
            opacity: 0.5;
        }

        /* 12. МОДАЛЬНОЕ ОКНО ПОДТВЕРЖДЕНИЯ */
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 1000;
            animation: fadeIn 0.3s ease;
            padding: 20px;
        }

        .modal {
            background: white;
            border-radius: 12px;
            padding: 40px;
            max-width: 400px;
            width: 90%;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            animation: slideIn 0.3s ease;
        }

        .modal h3 {
            font-size: 20px;
            margin-bottom: 16px;
            color: #212529;
        }

        .modal p {
            color: #6c757d;
            margin-bottom: 32px;
            line-height: 1.6;
        }

        .modal-actions {
            display: flex;
            gap: 12px;
            justify-content: flex-end;
        }

        .modal-btn {
            padding: 12px 24px;
            border: none;
            border-radius: 6px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .modal-btn.cancel {
            background: #f8f9fa;
            color: #495057;
            border: 1px solid #e9ecef;
        }

        .modal-btn.cancel:hover {
            background: #e9ecef;
        }

        .modal-btn.confirm {
            background: #dc3545;
            color: white;
            border: 1px solid #dc3545;
        }

        .modal-btn.confirm:hover {
            background: #c82333;
            transform: translateY(-1px);
        }

        /* 13. АНИМАЦИИ */
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .table-row {
            animation: slideUp 0.3s ease;
            animation-fill-mode: both;
        }

        .table-row:nth-child(1) { animation-delay: 0.05s; }
        .table-row:nth-child(2) { animation-delay: 0.1s; }
        .table-row:nth-child(3) { animation-delay: 0.15s; }
        .table-row:nth-child(4) { animation-delay: 0.2s; }
        .table-row:nth-child(5) { animation-delay: 0.25s; }
        .table-row:nth-child(6) { animation-delay: 0.3s; }

        /* 14. АДАПТИВНОСТЬ — ПЛАНШЕТЫ */
        @media (max-width: 1200px) {
            .container {
                padding: 24px 20px;
            }

            .page-header h1 {
                font-size: 28px;
            }

            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .table-header,
            .table-row {
                grid-template-columns: 70px 1fr 1fr 160px 140px;
                padding: 16px 20px;
            }
        }

        /* 14. АДАПТИВНОСТЬ — МАЛЕНЬКИЕ ПЛАНШЕТЫ */
        @media (max-width: 992px) {
            .page-header {
                flex-direction: column;
                align-items: stretch;
                gap: 16px;
            }

            .page-header h1 {
                font-size: 26px;
            }

            .btn {
                justify-content: center;
                width: 100%;
            }

            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 16px;
            }

            .stat-card {
                padding: 20px;
            }

            .stat-value {
                font-size: 28px;
            }

            .table-header,
            .table-row {
                grid-template-columns: 60px 1fr 1fr 140px 130px;
                padding: 14px 16px;
                gap: 8px;
            }

            .cell {
                font-size: 14px;
            }

            .action-btn {
                padding: 6px 12px;
                font-size: 12px;
            }
        }

        /* 15. АДАПТИВНОСТЬ — МОБИЛЬНЫЕ (КАРТОЧНЫЙ ВИД) */
        @media (max-width: 768px) {
            .container {
                padding: 16px 12px;
            }

            .page-header {
                margin-bottom: 24px;
                padding-bottom: 16px;
            }

            .page-header h1 {
                font-size: 24px;
            }

            /* Статистика в одну колонку */
            .stats-grid {
                grid-template-columns: 1fr;
                gap: 12px;
            }

            /* Таблица превращается в карточки */
            .employees-table {
                margin-top: 20px;
                border-radius: 10px;
            }

            .table-header {
                display: none;
            }

            .table-row {
                display: flex;
                flex-direction: column;
                grid-template-columns: none;
                padding: 20px;
                gap: 12px;
                border-bottom: 1px solid #e9ecef;
                align-items: stretch;
            }

            .table-row:hover {
                transform: none;
                box-shadow: none;
            }

            .table-row:last-child {
                border-bottom: none;
            }

            .cell {
                display: flex;
                justify-content: space-between;
                align-items: center;
                padding: 8px 0;
                white-space: normal;
                border-bottom: 1px solid #f1f3f5;
            }

            .cell:last-child {
                border-bottom: none;
            }

            .cell::before {
                content: attr(data-label);
                font-weight: 600;
                color: #6c757d;
                font-size: 12px;
                text-transform: uppercase;
                letter-spacing: 0.5px;
                margin-right: 12px;
                flex-shrink: 0;
            }

            .cell-id {
                font-size: 14px;
            }

            .cell-name {
                font-size: 15px;
                font-weight: 600;
            }

            .cell-email {
                font-size: 14px;
                word-break: break-all;
            }

            .cell-date {
                font-size: 13px;
            }

            .actions-cell {
                flex-direction: row;
                gap: 10px;
                padding-top: 8px;
                border-top: 1px solid #e9ecef;
                margin-top: 4px;
            }

            .action-btn {
                flex: 1;
                justify-content: center;
                padding: 10px 16px;
                font-size: 13px;
            }

            /* Поиск */
            .filters-container {
                padding: 16px;
                margin-bottom: 20px;
            }

            .search-box {
                max-width: 100%;
            }

            .search-input {
                padding: 12px 16px 12px 42px;
                font-size: 14px;
            }

            /* Пагинация */
            .pagination {
                margin-top: 24px;
                padding: 16px;
                gap: 6px;
            }

            .page-link {
                width: 36px;
                height: 36px;
                font-size: 14px;
            }

            /* Пустое состояние */
            .empty-state {
                padding: 50px 20px;
                margin-top: 20px;
            }

            .empty-state-icon {
                font-size: 48px;
                margin-bottom: 16px;
            }

            .empty-state h3 {
                font-size: 20px;
            }

            .empty-state p {
                font-size: 14px;
                margin-bottom: 24px;
            }

            .empty-state .btn {
                width: 100%;
                justify-content: center;
            }

            /* Модальное окно */
            .modal {
                width: 95%;
                padding: 28px 24px;
            }

            .modal h3 {
                font-size: 18px;
            }

            .modal p {
                font-size: 14px;
                margin-bottom: 24px;
            }

            .modal-actions {
                flex-direction: column-reverse;
                gap: 10px;
            }

            .modal-btn {
                width: 100%;
                padding: 14px;
                font-size: 15px;
            }
        }

        /* 16. АДАПТИВНОСТЬ — МАЛЕНЬКИЕ ЭКРАНЫ */
        @media (max-width: 480px) {
            .container {
                padding: 12px 10px;
            }

            .page-header {
                margin-bottom: 20px;
                padding-bottom: 12px;
            }

            .page-header h1 {
                font-size: 22px;
            }

            .btn {
                padding: 12px 20px;
                font-size: 14px;
            }

            /* Статистика */
            .stat-card {
                padding: 16px;
            }

            .stat-value {
                font-size: 24px;
            }

            .stat-label {
                font-size: 12px;
            }

            .stat-icon {
                font-size: 20px;
                margin-bottom: 12px;
            }

            /* Карточки сотрудников */
            .employees-table {
                border-radius: 8px;
            }

            .table-row {
                padding: 16px;
                gap: 8px;
            }

            .cell {
                padding: 6px 0;
            }

            .cell::before {
                font-size: 11px;
            }

            .cell-id {
                font-size: 13px;
            }

            .cell-name {
                font-size: 14px;
            }

            .cell-email {
                font-size: 13px;
            }

            .cell-date {
                font-size: 12px;
            }

            .actions-cell {
                gap: 8px;
                padding-top: 6px;
            }

            .action-btn {
                padding: 9px 12px;
                font-size: 12px;
            }

            /* Поиск */
            .filters-container {
                padding: 12px;
                border-radius: 8px;
            }

            .search-input {
                padding: 11px 14px 11px 38px;
                font-size: 13px;
                border-radius: 6px;
            }

            .search-icon {
                left: 12px;
                font-size: 14px;
            }

            /* Пагинация */
            .pagination {
                margin-top: 16px;
                padding: 12px;
                gap: 4px;
                border-radius: 8px;
            }

            .page-link {
                width: 32px;
                height: 32px;
                font-size: 13px;
                border-radius: 4px;
            }

            /* Пустое состояние */
            .empty-state {
                padding: 40px 16px;
                border-radius: 8px;
            }

            .empty-state-icon {
                font-size: 40px;
            }

            .empty-state h3 {
                font-size: 18px;
            }

            .empty-state p {
                font-size: 13px;
            }

            /* Модальное окно */
            .modal-overlay {
                padding: 12px;
                align-items: flex-end;
            }

            .modal {
                width: 100%;
                max-width: 100%;
                padding: 24px 20px;
                border-radius: 12px 12px 0 0;
                margin-bottom: 0;
            }

            .modal h3 {
                font-size: 17px;
            }

            .modal p {
                font-size: 13px;
                margin-bottom: 20px;
            }

            .modal-btn {
                padding: 13px;
                font-size: 14px;
            }

            /* Подсветка NEW */
            .highlight-new::before {
                top: 6px;
                right: 6px;
                padding: 2px 6px;
                font-size: 9px;
            }
        }

        /* 17. ПОЛЬЗОВАТЕЛЬСКИЕ ЭФФЕКТЫ */
        .highlight-new {
            position: relative;
            overflow: hidden;
        }

        .highlight-new::before {
            content: "NEW";
            position: absolute;
            top: 8px;
            right: 8px;
            background: #212529;
            color: white;
            padding: 2px 8px;
            border-radius: 4px;
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            z-index: 1;
        }

        .copy-email {
            cursor: pointer;
            position: relative;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .copy-email::after {
            content: "📋";
            font-size: 12px;
            opacity: 0.5;
            transition: opacity 0.2s ease;
        }

        .copy-email:hover::after {
            opacity: 1;
        }

        .copy-tooltip {
            position: absolute;
            background: #212529;
            color: white;
            padding: 6px 12px;
            border-radius: 4px;
            font-size: 12px;
            top: -30px;
            left: 50%;
            transform: translateX(-50%);
            white-space: nowrap;
            opacity: 0;
            transition: opacity 0.2s ease;
            pointer-events: none;
        }

        .copy-email:hover .copy-tooltip {
            opacity: 1;
        }

        /* 18. СОРТИРОВКА */
        .sortable {
            cursor: pointer;
            position: relative;
            padding-right: 20px;
            user-select: none;
        }

        .sortable::after {
            content: "↕";
            position: absolute;
            right: 0;
            opacity: 0.3;
            transition: opacity 0.2s ease;
        }

        .sortable:hover::after {
            opacity: 0.6;
        }

        .sortable.asc::after {
            content: "↑";
            opacity: 0.8;
        }

        .sortable.desc::after {
            content: "↓";
            opacity: 0.8;
        }
    </style>

    <div class="container">
        <div class="page-header">
            <h1>Сотрудники</h1>
            <a href="{{ route('admin.employees.create') }}" class="btn">Добавить сотрудника</a>
        </div>

        <!-- Таблица сотрудников -->
        @if($employees->count() > 0)
            <div class="employees-table">
                <div class="table-header">
                    <div class="cell">ID</div>
                    <div class="cell">Имя</div>
                    <div class="cell">Email</div>
                    <div class="cell">Дата создания</div>
                    <div class="cell">Действия</div>
                </div>

                @foreach($employees as $employee)
                    <div class="table-row">
                        <div class="cell cell-id" data-label="ID">
                            #{{ $employee->id }}
                        </div>
                        <div class="cell cell-name" data-label="Имя">
                            {{ $employee->name }}
                        </div>
                        <div class="cell cell-email" data-label="Email">
                            {{ $employee->email }}
                        </div>
                        <div class="cell cell-date" data-label="Дата создания">
                            {{ $employee->created_at->format('d.m.Y H:i') }}
                        </div>
                        <div class="cell cell-actions" data-label="Действия">
                            <div class="actions-cell">
                                <a href="{{ route('admin.employees.delete', $employee->id) }}"
                                   class="action-btn action-delete">
                                    Удалить
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="empty-state">
                <div class="empty-state-icon">👥</div>
                <h3>Сотрудники не найдены</h3>
                <p>Добавьте первого сотрудника, чтобы начать работу с системой</p>
                <a href="{{ route('admin.employees.create') }}" class="btn">Добавить сотрудника</a>
            </div>
        @endif
    </div>

    <!-- Модальное окно подтверждения удаления -->
    <div class="modal-overlay" id="deleteModal">
        <div class="modal">
            <h3>Подтверждение удаления</h3>
            <p id="deleteMessage">Вы уверены, что хотите удалить сотрудника?</p>
            <div class="modal-actions">
                <button class="modal-btn cancel" onclick="closeModal()">Отмена</button>
                <button class="modal-btn confirm" id="confirmDeleteBtn">Удалить</button>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // 1. Функция для фильтрации таблицы
            const searchInput = document.getElementById('searchInput');
            if (searchInput) {
                searchInput.addEventListener('input', function(e) {
                    const searchTerm = e.target.value.toLowerCase();
                    const rows = document.querySelectorAll('.table-row');

                    rows.forEach(row => {
                        const name = row.querySelector('.cell-name').textContent.toLowerCase();
                        const email = row.querySelector('.cell-email').textContent.toLowerCase();
                        const id = row.querySelector('.cell-id').textContent.toLowerCase();

                        const matches = name.includes(searchTerm) ||
                            email.includes(searchTerm) ||
                            id.includes(searchTerm);

                        row.style.display = matches ? '' : 'none';
                    });
                });
            }

            // 2. Копирование email
            document.querySelectorAll('.copy-email').forEach(element => {
                element.addEventListener('click', function() {
                    const email = this.getAttribute('data-email');
                    navigator.clipboard.writeText(email).then(() => {
                        const originalHTML = this.innerHTML;
                        this.innerHTML = `
                            <span style="color: #28a745;">✓ Скопировано</span>
                            <span class="copy-tooltip">Email скопирован</span>
                        `;

                        setTimeout(() => {
                            this.innerHTML = originalHTML;
                        }, 2000);
                    });
                });
            });

            // 3. Подсветка новых сотрудников (добавленных менее 24 часов)
            document.querySelectorAll('.table-row').forEach(row => {
                const dateCell = row.querySelector('.cell-date');
                if (dateCell) {
                    const dateText = dateCell.textContent;
                    const rowDate = new Date(dateText.split(' ').join('T'));
                    const now = new Date();
                    const diffHours = (now - rowDate) / (1000 * 60 * 60);

                    if (diffHours < 24) {
                        row.classList.add('highlight-new');
                    }
                }
            });

            // 4. Плавное появление строк
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.opacity = '1';
                        entry.target.style.transform = 'translateY(0)';
                        observer.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.1 });

            document.querySelectorAll('.table-row').forEach(row => {
                row.style.opacity = '0';
                row.style.transform = 'translateY(20px)';
                row.style.transition = 'opacity 0.3s ease, transform 0.3s ease';
                observer.observe(row);
            });

            // 5. Горячие клавиши
            document.addEventListener('keydown', function(e) {
                if ((e.ctrlKey || e.metaKey) && e.key === 'f') {
                    e.preventDefault();
                    if (searchInput) {
                        searchInput.focus();
                        searchInput.select();
                    }
                }

                if (e.key === '/' && document.activeElement !== searchInput) {
                    e.preventDefault();
                    if (searchInput) {
                        searchInput.focus();
                    }
                }

                if (e.key === 'Escape' && document.activeElement === searchInput) {
                    searchInput.value = '';
                    searchInput.dispatchEvent(new Event('input'));
                }
            });

            // 6. Сохранение состояния поиска
            if (searchInput) {
                const savedSearch = localStorage.getItem('employees_search');
                if (savedSearch) {
                    searchInput.value = savedSearch;
                    searchInput.dispatchEvent(new Event('input'));
                }

                searchInput.addEventListener('input', function() {
                    localStorage.setItem('employees_search', this.value);
                });
            }
        });

        // 7. Улучшенное подтверждение удаления
        let deleteUrl = '';

        function confirmDelete(event, employeeId, employeeName) {
            event.preventDefault();
            deleteUrl = event.target.getAttribute('href');

            const modal = document.getElementById('deleteModal');
            const message = document.getElementById('deleteMessage');

            message.textContent = `Вы уверены, что хотите удалить сотрудника "${employeeName}" (ID: ${employeeId})? Это действие нельзя отменить.`;

            modal.style.display = 'flex';

            return false;
        }

        function closeModal() {
            document.getElementById('deleteModal').style.display = 'none';
        }

        document.getElementById('confirmDeleteBtn').addEventListener('click', function() {
            if (deleteUrl) {
                const employeeId = deleteUrl.split('/').pop();
                const row = document.querySelector(`[data-employee-id="${employeeId}"]`);

                if (row) {
                    row.style.opacity = '0.5';
                    row.style.transform = 'scale(0.95)';
                    row.style.transition = 'all 0.3s ease';

                    setTimeout(() => {
                        window.location.href = deleteUrl;
                    }, 300);
                } else {
                    window.location.href = deleteUrl;
                }
            }
        });

        document.getElementById('deleteModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeModal();
            }
        });
    </script>
@endsection
