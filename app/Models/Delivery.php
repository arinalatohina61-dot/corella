<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Delivery extends Model
{
    protected $fillable = [
        'order_id',
        'recipient_name',
        'phone',
        'city',
        'address',
        'postal_code',
        'delivery_notes',
        'delivery_method',
        'delivery_cost',
        'delivery_date',
        'delivery_status',
        'tracking_number',
    ];

    protected $casts = [
        'delivery_date' => 'datetime',
        'delivery_cost' => 'decimal:2',
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function getDeliveryMethodLabel(): string
    {
        return [
            'courier' => 'Курьером',
            'pickup' => 'Самовывоз',
            'post' => 'Почтой',
        ][$this->delivery_method] ?? $this->delivery_method;
    }

    public function getDeliveryStatusLabel(): string
    {
        return [
            'новый' => 'Новый',
            'в процессе' => 'В процессе',
            'завершенный' => 'Завершен',
            'отмененный' => 'Отменен',
        ][$this->delivery_status] ?? ucfirst($this->delivery_status);
    }

    public function getDeliveryStatusClass(): string
    {
        return [
            'новый' => 'new',
            'в процессе' => 'processing',
            'завершенный' => 'delivered',
            'отмененный' => 'cancelled',
        ][$this->delivery_status] ?? 'pending';
    }
}
