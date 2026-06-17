<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Чек заказа {{ $order->code }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border-bottom: 1px solid #000; padding: 5px; text-align: left; }
        h2, h4 { text-align: center; }
        hr { border: 1px dashed #000; }
    </style>
</head>
<body>
<h2>Чек заказа</h2>
<p><strong>Номер заказа:</strong> {{ $order->code }}</p>
<p><strong>Дата заказа:</strong> {{ \Carbon\Carbon::parse($order->order_date)->format('d.m.Y H:i') }}</p>
<p><strong>Сумма:</strong> {{ number_format($order->total_amount, 2) }} руб.</p>

<hr>
<h4>Товары:</h4>
<table>
    <thead>
    <tr>
        <th>Название</th>
        <th>Количество</th>
        <th>Цена</th>
    </tr>
    </thead>
    <tbody>
    @foreach($order->items as $item)
        <tr>
            <td>{{ $item->product->name }}</td>
            <td>{{ $item->quantity }}</td>
            <td>{{ number_format($item->price_at_order, 0, ',', ' ') }} руб.</td>
        </tr>
    @endforeach
    </tbody>
</table>
</body>
</html>
