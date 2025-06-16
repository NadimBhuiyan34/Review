<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Shop extends Model
{
    /** @use HasFactory<\Database\Factories\ShopFactory> */
   use HasFactory, HasUuids, HasSlug;
    
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['name','status', 'slug', 'logo'];

    protected $casts = [
        'status' => 'boolean'
    ];


       public function getRouteKeyName(): string
    {
        return 'slug';
    }
    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name') // Field used to generate the slug
            ->saveSlugsTo('slug') // Column where the slug will be saved
            ->doNotGenerateSlugsOnUpdate(); // Prevent slug update unless name changes;
    }
    
}
