<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class OrderItem extends Model
{
    /** @use HasFactory<\Database\Factories\OrderItemFactory> */
     use HasFactory, HasUuids;

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['order_id', 'product_id', 'quantity', 'price'];


    public function order()
{
    return $this->belongsTo(Order::class);
}

public function product()
{
    return $this->belongsTo(Product::class);
}
}
