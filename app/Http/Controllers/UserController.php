<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\UserRequest;
use App\Models\Client;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function signup(UserRequest $request)
    {
        if (User::create($request->all())) {
            return redirect()->route('login');
        }

        return redirect()
            ->back()
            ->withInput($request->validated())
            ->withErrors([
                'status' => 'error',
            ]);
    }

    public function login1()
    {
        return view('users.login');
    }

    public function signup1()
    {
        return view('layout.signup');
    }

    public function index()
    {
        return view('users.index');
    }

    public function login(LoginRequest $request)
    {
        $credentials = $request->validated();

        if (auth()->attempt($credentials)) {
            $user = auth()->user();

            // Перенаправляем в зависимости от роли
            if (strtolower($user->role->name) === 'admin') {
                return redirect()->route('admin.panel'); // маршрут для admin
            } elseif (strtolower($user->role->name) === 'manager') {
                return redirect()->route('staff.panel'); // маршрут для manager
            }

            // Можно добавить дефолтное перенаправление для других ролей
            return redirect()->route('home');
        }

        return back()
            ->withInput($credentials)
            ->withErrors(['status' => 'Неверные данные для входа']);
    }


    public function logout()
    {
        auth()->logout();
        return redirect()->route('staff.login');
    }
}
