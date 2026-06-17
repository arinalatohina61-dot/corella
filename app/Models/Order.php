<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'client_id',
        'total_amount',
        'payment_method',
        'status',
        'code'
    ];

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function client()
    {
        return $this->hasOne(Client::class, 'id', 'client_id');
    }

    public function items()
    {
        return $this->hasMany(Order_detail::class);
    }

    public function orderDetails()
    {
        return $this->hasMany(Order_detail::class, 'order_id');
    }

    public function delivery(): HasOne
    {
        return $this->hasOne(Delivery::class);
    }
}
