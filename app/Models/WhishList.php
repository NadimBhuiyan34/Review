<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class WhishList extends Model
{
    /** @use HasFactory<\Database\Factories\WhishListFactory> */
     use HasFactory, HasUuids;

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['user_id', 'product_id'];


    public function product() {
        
    return $this->belongsTo(Product::class);
     }
    public function user() {
        
    return $this->belongsTo(User::class);
     }

}
