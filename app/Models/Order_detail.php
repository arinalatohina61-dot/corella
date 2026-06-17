<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order_detail extends Model
{
    protected $fillable = [
        'order_id',
        'product_id',
        'quantity',
        'price_at_order',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
