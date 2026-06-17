<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        $user = Auth::user();

        if (!$user) {
            // Не авторизован — перенаправляем на страницу входа
            return redirect()->route('login');
        }

        // Если роль пользователя не входит в список разрешённых
        if (!in_array(strtolower($user->role->name), array_map('strtolower', $roles))) {
            abort(403, 'У вас нет доступа к этой странице.');
        }

        return $next($request);
    }
}
