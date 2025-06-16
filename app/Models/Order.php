<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Support\Str;

class Order extends Model
{
    /** @use HasFactory<\Database\Factories\OrderFactory> */
use HasFactory, HasUuids;

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'user_id',
        'total_price',
        'status',
        'payment_method',   
        'payment_status',   
        'order_number', // Add this to fillable
    ];

    protected static function booted()
    {
        static::creating(function ($order) {
            do {
                $orderNumber = 'ORD-' . now()->format('Ymd') . '-' . strtoupper(Str::random(6));
            } while (self::where('order_number', $orderNumber)->exists());

            $order->order_number = $orderNumber;
        });
    }

    // Order.php
public function shippingAddress()
{
    return $this->hasOne(ShippingAddress::class);
}
public function payment()
{
    return $this->hasOne(Payment::class);
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
