<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClientRequest;
use App\Http\Requests\LoginRequest;
use App\Models\Client;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class ClientController extends Controller
{
    public function signup(ClientRequest $request)
    {
        if (Client::create($request->all())) {
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
        return view('layout.login');
    }

    public function signup1()
    {
        return view('layout.signup');
    }

//    public function profile()
//    {
//        return view('layout.profile');
//    }

    public function login(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::guard('client')->attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->route('products.index');
        }

        return back()
            ->withErrors(['auth_error' => 'Неверный email или пароль'])
            ->withInput();
    }


    public function logout()
    {
        auth()->logout();
        return redirect()->route('login');
    }

    public function profile()
    {
        $user = auth('client')->user();
        return view('layout.profile', compact('user'));
    }

    public function showOrder($id)
    {
        $order = Order::with('orderDetails')->where('client_id', auth()->id())->findOrFail($id);
        return view('layout.order', compact('order'));
    }

    public function orderList()
    {
        $user = auth('client')->user();

        $orders = Order::with('orderDetails.product')
            ->where('client_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('order.list', compact('orders'));
    }
}
