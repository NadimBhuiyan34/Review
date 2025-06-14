<?php

namespace App\Http\Controllers\ClientController;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Slider;
use Inertia\Inertia;

class HomeController extends Controller
{
     public function index()
    {
       $sliders= Slider::where('status',1)->get();
       $products= Product::where('status',1)->with('images')->get();
        

       return Inertia::render('Home', ['sliders'=> $sliders, 'products' => $products]);

    }

    public function show($slug)
    {
        $product = Product::with(['images', 'category', 'brand', 'review.user']) 
                          ->where('slug', $slug)
                          ->firstOrFail();
         $reviews = $product->review;
        return Inertia::render('client_pages/ProductDetails', [
            'product' => $product, 'reviews' => $reviews
        ]);
    }
    public function cart()
    {
        // $product = Product::with(['images', 'category', 'brand']) 
        //                   ->where('slug', $slug)
        //                   ->firstOrFail();
          

          
        return Inertia::render('client_pages/Cart');
    }
    public function order()
    {
        // $product = Product::with(['images', 'category', 'brand']) 
        //                   ->where('slug', $slug)
        //                   ->firstOrFail();
          

          
        return Inertia::render('client_pages/Shipping');
    }
    public function payment()
    {
        // $product = Product::with(['images', 'category', 'brand']) 
        //                   ->where('slug', $slug)
        //                   ->firstOrFail();
          

          
        return Inertia::render('client_pages/Payment');
    }


   public function allproduct(Request $request)
    {
        $query = Product::with(['category', 'images', 'brand', 'shop']);

        if ($search = $request->input('search')) {
            $query->where('name', 'like', "%{$search}%");
        }

        if ($category = $request->input('category')) {
            $query->where('category_id', $category);
        }

        if ($brand = $request->input('brand')) {
            $query->where('brand_id', $brand);
        }

        if ($shop = $request->input('shop')) {
            $query->where('shop_id', $shop);
        }

        if ($request->filled('minPrice')) {
            $query->where('price', '>=', $request->input('minPrice'));
        }

        if ($request->filled('maxPrice')) {
            $query->where('price', '<=', $request->input('maxPrice'));
        }

        $products = $query->latest()->paginate(12)->withQueryString();

        return Inertia::render('client_pages/AllProduct', [
            'products'   => $products->items(),
            'pagination' => [
                'currentPage' => $products->currentPage(),
                'hasMorePages' => $products->hasMorePages(),
            ],
            'filters'    => $request->only('search', 'category', 'brand', 'shop', 'minPrice', 'maxPrice'),
            'categories' => \App\Models\Category::select('id', 'name')->get(),
            'brands'     => \App\Models\Brand::select('id', 'name')->get(),
            'shops'      => \App\Models\Shop::select('id', 'name')->get(),
        ]);
    }

}
