<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Order extends Model
{
    /** @use HasFactory<\Database\Factories\OrderFactory> */
    use HasFactory, HasUuids;

 public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['user_id', 'total_price', 'status', 'payment_method'];

    // Order.php
public function shippingAddress()
{
    return $this->hasOne(ShippingAddress::class);
}

public function orderItems()
{
    return $this->hasMany(OrderItem::class);
}

public function user()
{
    return $this->belongsTo(User::class);
}

}
