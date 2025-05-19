<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Review extends Model
{
    /** @use HasFactory<\Database\Factories\ReviewFactory> */
    use HasFactory, HasUuids;


    
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['product_id', 'user_id', 'rating', 'comment', 'sentiment_type'];

     public function user()
    {
        return $this->belongsTo(User::class);
    }
     public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
