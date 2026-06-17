<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Order_detail;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function create()
    {
        $client = Auth::guard('client')->user();

        if (!$client) {
            return redirect()->route('login')
                ->with('error', 'Пожалуйста, войдите в систему');
        }

        $cart = session('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')
                ->with('error', 'Ваша корзина пуста');
        }

        $total = 0;
        $products = [];

        foreach ($cart as $id => $item) {
            $total += $item['price'] * $item['quantity'];
            $products[] = (object)[
                'id' => $id,
                'name' => $item['name'],
                'price' => $item['price'],
                'width' => $item['width'] ?? null,
                'height' => $item['height'] ?? null,
                'light_requirement' => $item['light_requirement'] ?? null,
                'quantity' => $item['quantity'],
                'image' => $item['image'] ?? null,
            ];
        }

        return view('order.checkout', compact('products', 'total')); // ← ВОТ ЗДЕСЬ!
    }

    public function store(Request $request)
    {
        $request->validate([
            'payment_method' => 'required|in:card,cash',
        ]);

        $client = Auth::guard('client')->user();

        if (!$client) {
            return redirect()->route('login')
                ->with('error', 'Пожалуйста, войдите в систему');
        }

        // Получаем корзину из сессии
        $cart = session('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')
                ->with('error', 'Корзина пуста');
        }

        // Считаем общую сумму
        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        // Создаем заказ
        $order = Order::create([
            'client_id' => $client->id,
            'user_id' => null,
            'total_amount' => $total,
            'payment_method' => $request->payment_method,
            'status' => 'новый',
            'code' => 'ORD-' . strtoupper(uniqid()),
        ]);

        // Создаем позиции заказа из сессии
        foreach ($cart as $id => $item) {
            Order_detail::create([
                'order_id' => $order->id,
                'product_id' => $id,
                'quantity' => $item['quantity'],
                'price_at_order' => $item['price'],
            ]);
        }

        // Очищаем корзину в сессии
        session()->forget('cart');

        // Если оплата наличными - перенаправляем на оформление доставки
        if ($request->payment_method === 'cash') {
            return redirect()->route('delivery.create', $order->id)
                ->with('success', 'Заказ создан! Теперь укажите адрес доставки.');
        }

        // Если оплата картой - показываем страницу успеха
        return redirect()->route('order.success', $order->id);
    }

    public function success($id)
    {
        $order = Order::findOrFail($id);
        return view('order.success', compact('order'));  // ✅ ПРАВИЛЬНО
    }

    public function index()
    {
        $orders = Order::with(['client', 'orderDetails.product'])->latest()->paginate(10);
        return view('admin.orders.index', compact('orders'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:новый,в процессе,завершенный,отмененный',
        ]);

        $order->update([
            'status' => $request->status,
        ]);

        return back()->with('success', 'Статус заказа обновлен');
    }

    public function updateStatusStaff(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:новый,в процессе,завершенный,отмененный',
        ]);

        $order->update([
            'status' => $request->status,
        ]);

        return back()->with('success', 'Статус заказа обновлен');
    }

    public function print($id)
    {
        $order = Order::with(['client', 'orderDetails.product', 'delivery'])->findOrFail($id);
        return view('order-print', compact('order'));
    }

    public function download($id)
    {
        $order = Order::with(['client', 'orderDetails.product', 'delivery'])->findOrFail($id);
        return view('order-print', compact('order'));
    }
}
