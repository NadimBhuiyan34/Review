<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    /** @use HasFactory<\Database\Factories\SliderFactory> */
    use HasFactory;

      protected $fillable = [
        'name',
        'description',
        'image',
        'status',
    ];

     protected $casts = [
        'status' => 'boolean',
    ];
}
