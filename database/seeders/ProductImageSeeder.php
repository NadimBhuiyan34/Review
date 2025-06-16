<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use App\Models\Product;
use App\Models\ProductImage;

class ProductImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         $products = Product::all();

        foreach ($products as $product) {
            for ($i = 1; $i <= 3; $i++) {
                ProductImage::create([
                    'id' => Str::uuid(),
                    'product_id' => $product->id,
                    'image_path' => "https://via.placeholder.com/600x600.png?text=Product+{$i}",
                    'is_featured' => $i === 1, // only the first image is featured
                ]);
            }
        }
    }
}
