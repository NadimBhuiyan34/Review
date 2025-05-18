<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
class ShippingAddress extends Model
{
    /** @use HasFactory<\Database\Factories\ShippingAddressFactory> */
    use HasFactory, HasUuids;

 public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['order_id', 'user_id', 'city', 'postal_code', 'name', 'address', 'phone'];


    public function order()
{
    return $this->belongsTo(Order::class);
}

public function user()
{
    return $this->belongsTo(User::class);
}
}
