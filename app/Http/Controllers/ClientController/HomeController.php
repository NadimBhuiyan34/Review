<?php

namespace App\Http\Controllers\ClientController;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Product;
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
}
