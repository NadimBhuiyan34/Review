<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Category;

class DarazScraperController extends Controller
{
    public function scrape()
    {
        // Get an existing category UUID
        $category = Category::first();
        if (!$category) {
            return response()->json(['error' => 'No categories found. Please add a category first.'], 500);
        }
        $categoryId = $category->id;

        $response = Http::withHeaders([
            'User-Agent' => 'Mozilla/5.0', // Mimic browser
        ])->get('https://www.daraz.com.bd/catalog/', [
            'ajax' => 'true',
            'q' => 'iphone',
            'page' => 1,
        ]);

        if (!$response->successful()) {
            return response()->json(['error' => 'Failed to fetch data'], 500);
        }

        $items = $response->json()['mods']['listItems'] ?? [];

        $inserted = 0;
        $skipped = 0;

        foreach (collect($items)->take(10) as $item) {
            $title = $item['name'] ?? 'Unnamed Product';
            $slug = Str::slug($title);

            // Skip if product with similar slug exists
            $exists = Product::where('slug', 'LIKE', $slug . '%')->exists();
            if ($exists) {
                $skipped++;
                continue;
            }

            $product = Product::create([
                'name' => $title,
                'description' => null,
                'price' => (float) str_replace(',', '', $item['priceShow'] ?? 0),
                'discount_price' => (float) str_replace(',', '', $item['priceShow'] ?? 0),
                'stock' => 100,
                'is_featured' => true,
                'is_active' => true,
                'category_id' => $categoryId,
                'brand_id' => null,
                'shop_id' => null,
                'tags' => ['daraz'],
                'specifications' => ['source' => 'Daraz'],
                'status' => true,
            ]);

            if (!empty($item['image'])) {
                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => $item['image'],
                    'is_featured' => true,
                ]);
            }

            $inserted++;
        }

        return response()->json([
            'message' => 'Scraping completed',
            'inserted' => $inserted,
            'skipped_duplicates' => $skipped,
        ]);
    }
}
