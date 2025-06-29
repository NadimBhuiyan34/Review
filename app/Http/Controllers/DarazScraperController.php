<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Shop;


class DarazScraperController extends Controller
{
    public function scrape(Request $request)
    {
        // Get search query or default
        $searchQuery = $request->input('q', 'iphone');

        // Get category/brand/shop names from request or use default strings
        $categoryName = $request->input('category');
        $brandName = $request->input('brand');
        $shopName = $request->input('shop');

        // Find or create category, brand, shop
        $category = Category::firstOrCreate(['name' => $categoryName], ['slug' => Str::slug($categoryName)]);
        $brand = Brand::firstOrCreate(['name' => $brandName], ['slug' => Str::slug($brandName)]);
        $shop = Shop::firstOrCreate(['name' => $shopName], ['slug' => Str::slug($shopName)]);

        // Scrape data from Daraz
        $response = Http::withHeaders([
            'User-Agent' => 'Mozilla/5.0',
        ])->get('https://www.daraz.com.bd/catalog/', [
            'ajax' => 'true',
            'q' => $searchQuery,
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

            if (Product::where('slug', 'LIKE', $slug . '%')->exists()) {
                $skipped++;
                continue;
            }

            $rawPrice = $item['priceShow'] ?? '0';
            $cleanPrice = preg_replace('/[^\d\.]/', '', $rawPrice);
            $price = $cleanPrice !== '' ? (float)$cleanPrice : 0.0;

            $product = Product::create([
                'name' => $title,
                'description' => null,
                'price' => $price,
                'stock' => 100,
                'is_featured' => true,
                'is_active' => true,
                'category_id' => $category->id,
                'brand_id' => $brand->id,
                'shop_id' => $shop->id,
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
