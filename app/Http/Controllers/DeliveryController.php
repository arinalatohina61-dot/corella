<?php

namespace App\Http\Controllers;

use App\Models\Delivery;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DeliveryController extends Controller
{
    public function create(Order $order)
    {
        $client = Auth::guard('client')->user();

        // Проверяем, что заказ принадлежит текущему клиенту
        if ($order->client_id !== $client->id) {
            abort(403);
        }

        return view('delivery.create', compact('order'));
    }

    public function store(Request $request, Order $order)
    {
        $client = Auth::guard('client')->user();

        // Проверяем, что заказ принадлежит текущему клиенту
        if ($order->client_id !== $client->id) {
            abort(403);
        }

        $validated = $request->validate([
            'recipient_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'city' => 'required|string|max:255',
            'address' => 'required|string|max:500',
            'postal_code' => 'nullable|string|max:20',
            'delivery_notes' => 'nullable|string|max:1000',
            'delivery_method' => 'required|in:courier,pickup,post',
            'delivery_date' => 'nullable|date|after:today',
        ]);

        $deliveryCost = $this->calculateDeliveryCost(
            $validated['delivery_method'],
            $order->total_amount
        );

        $deliveryStatus = $validated['delivery_method'] === 'pickup' ? 'завершенный' : 'новый';

        $validated['order_id'] = $order->id;
        $validated['delivery_cost'] = $deliveryCost;
        $validated['delivery_status'] = $deliveryStatus;

        Delivery::create($validated);

        $order->update([
            'total_amount' => $order->total_amount + $deliveryCost
        ]);

        return redirect()->route('profile.order.show', $order->id)
            ->with('success', 'Информация о доставке добавлена');
    }

    public function show(Order $order)
    {
        $client = Auth::guard('client')->user();

        if ($order->client_id !== $client->id) {
            abort(403);
        }

        $delivery = $order->delivery;
        return view('delivery.show', compact('order', 'delivery'));
    }

    public function edit(Order $order)
    {
        $client = Auth::guard('client')->user();

        if ($order->client_id !== $client->id) {
            abort(403);
        }

        $delivery = $order->delivery;
        if (!$delivery) {
            return redirect()->route('delivery.create', $order);
        }

        return view('delivery.edit', compact('order', 'delivery'));
    }

    public function update(Request $request, Order $order)
    {
        $client = Auth::guard('client')->user();

        if ($order->client_id !== $client->id) {
            abort(403);
        }

        $delivery = $order->delivery;
        if (!$delivery) {
            return redirect()->route('delivery.create', $order);
        }

        $validated = $request->validate([
            'recipient_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'city' => 'required|string|max:255',
            'address' => 'required|string|max:500',
            'postal_code' => 'nullable|string|max:20',
            'delivery_notes' => 'nullable|string|max:1000',
            'delivery_method' => 'required|in:courier,pickup,post',
            'delivery_date' => 'nullable|date|after:today',
        ]);

        $delivery->update($validated);

        return redirect()->route('delivery.show', $order->id)
            ->with('success', 'Информация о доставке обновлена');
    }

    // Для администратора и менеджера
    public function updateStatus(Request $request, Delivery $delivery)
    {
        $user = Auth::user();

        // Простая проверка роли через поле role_id
        // Если у тебя есть поле role_id в таблице users
        if (!$user || $user->role_id != 1) { // 1 = admin, 2 = manager (подставь свои значения)
            abort(403);
        }

        $validated = $request->validate([
            'delivery_status' => 'required|in:новый,в процессе,завершенный,отмененный',
            'tracking_number' => 'nullable|string|max:255',
        ]);

        $delivery->update($validated);

        return back()->with('success', 'Статус доставки обновлен');
    }

    private function calculateDeliveryCost(string $method, float $orderAmount): float
    {
        return match($method) {
            'courier' => $orderAmount >= 5000 ? 0 : 500,
            'pickup' => 0,
            'post' => $orderAmount >= 3000 ? 0 : 350,
            default => 0,
        };
    }
}
