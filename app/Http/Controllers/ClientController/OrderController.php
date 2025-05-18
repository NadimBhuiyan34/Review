<?php

namespace App\Http\Controllers\ClientController;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Http\Requests\ClientRequest\Order\StoreOrderRequest;
use App\Http\Requests\ClientRequest\Order\UpdateOrderRequest;
use Inertia\Inertia;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         $user = auth()->user();
         $cartItems = $user->cartItems()->with('product.images')->get();

        $totalPrice = $cartItems->sum(function ($item) {
            $product = $item->product;

            // Use discount_price if available, otherwise use price
            $unitPrice = $product->discount_price ?? $product->price;

            return $unitPrice * $item->quantity;
        });
        return Inertia::render('client_pages/Order', [
            'cartItems' => $cartItems,
            'totalPrice' => $totalPrice,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOrderRequest $request)
    {
        $user = $request->user(); // better than auth()->user()
         
        dd($request->address);
       

    }


    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOrderRequest $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        
    }
}
