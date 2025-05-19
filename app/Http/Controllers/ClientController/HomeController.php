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
        $product = Product::with(['images', 'category', 'brand']) 
                          ->where('slug', $slug)
                          ->firstOrFail();

        return Inertia::render('client_pages/ProductDetails', [
            'product' => $product
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
}
