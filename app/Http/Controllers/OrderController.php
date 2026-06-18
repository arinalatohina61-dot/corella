<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Order_detail;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

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
            // Загружаем товар из БД чтобы получить ВСЕ поля
            $product = Product::find($id);

            if ($product) {
                $total += $product->price * $item['quantity'];
                $products[] = (object)[
                    'id' => $id,
                    'name' => $product->name,
                    'price' => $product->price,
                    'width' => $product->width,
                    'height' => $product->height,
                    'light_requirement' => $product->light_requirement,
                    'quantity' => $item['quantity'],
                    'image' => $product->image,
                ];
            }
        }

        return view('order.checkout', compact('products', 'total'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'payment_method' => 'required|in:card,cash',
        ]);

        $client = Auth::guard('client')->user();

        if (!$client) {
            return redirect()->route('login')->with('error', 'Пожалуйста, войдите в систему');
        }

        $cart = session('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Корзина пуста');
        }

        $total = 0;
        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        $initialStatus = $request->payment_method === 'card' ? 'ожидает оплаты' : 'новый';

        $order = Order::query()->create([
            'client_id' => $client->id,
            'user_id' => null,
            'total_amount' => $total,
            'payment_method' => $request->payment_method,
            'status' => $initialStatus,
            'code' => 'ORD-' . strtoupper(uniqid()),
        ]);

        foreach ($cart as $id => $item) {
            Order_detail::query()->create([
                'order_id' => $order->id,
                'product_id' => $id,
                'quantity' => $item['quantity'],
                'price_at_order' => $item['price'],
            ]);
        }

        // Очищаем корзину
        session()->forget('cart');

        // 3. Логика оплаты картой через стороннее API
        if ($request->payment_method === 'card') {
            try {
                $response = Http::withHeaders([
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                ])->post('http://api-webhook/api/payments', [
                    'price' => $order->total_amount,
                    'webhook_url' => route('api.webhook') // Ссылка на наш вебхук
                ]);

                if ($response->successful()) {
                    $paymentData = $response->json();

                    // Сохраняем внешние ID и URL в нашу базу данных
                    $order->update([
                        'pay_url' => $paymentData['pay_url'],
                        'external_order_id' => $paymentData['order_id']
                    ]);

                    // Перенаправляем клиента на внешнюю страницу оплаты (ввод карты)
                    return redirect()->away($order->pay_url);
                } else {
                    $order->update(['status' => 'отмененный', 'cancel' => 'Ошибка платежного шлюза']);
                    return redirect()->route('cart.index')->with('error', 'Не удалось инициализировать оплату. Попробуйте позже.');
                }

            } catch (\Throwable $th) {
                $order->update(['status' => 'отмененный', 'cancel' => 'Техническая ошибка при оплате']);
                return redirect()->route('cart.index')->with('error', 'Ошибка соединения с банком: ' . $th->getMessage());
            }
        }

        // Если оплата наличными - отправляем на доставку
        return redirect()->route('delivery.create', $order->id)
            ->with('success', 'Заказ создан! Теперь укажите адрес доставки.');
    }

    public function success($id)
    {
        $order = Order::findOrFail($id);
        return view('order.success', compact('order'));  // ✅ ПРАВИЛЬНО
    }

    public function index()
    {
        $orders = Order::with(['client', 'orderDetails.product'])->latest()->paginate(10);
        return view('order.index', compact('orders'));
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
