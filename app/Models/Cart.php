<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Cart extends Model
{
    /** @use HasFactory<\Database\Factories\CartFactory> */
   use HasFactory, HasUuids;

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['user_id', 'product_id', 'quantity'];



    public function product() {
        
    return $this->belongsTo(Product::class);
}

}
