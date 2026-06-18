<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class WebhookController extends Controller
{
    public function __invoke(Request $request)
    {
        $externalOrderId = $request->input('order_id');
        $apiStatus = $request->input('status'); // Например: 'success' или 'failed'

        // Ищем заказ по внешнему ID, который находится в статусе ожидания
        $order = Order::where('external_order_id', $externalOrderId)
            ->where('status', 'ожидает оплаты')
            ->first();

        if ($order) {
            if ($apiStatus === 'success') {
                $order->status = 'в процессе'; // или 'новый', переводя на сборку
            } else {
                $order->status = 'отмененный';
                $order->cancel = 'Оплата картой не удалась или была отклонена';
            }
            $order->save();
        }

        return response()->json(['status' => 'ok'], 200);
    }
}
