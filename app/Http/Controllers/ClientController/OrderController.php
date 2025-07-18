<?php

namespace App\Http\Controllers\ClientController;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\ShippingAddress;
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

            // Use discount_price if > 0, else use original price
            $unitPrice = ($product->discount_price > 0) ? $product->discount_price : $product->price;

            return $unitPrice * $item->quantity;
        });

        return Inertia::render('client_pages/Order', [
            'cartItems'   => $cartItems,
            'totalPrice'  => $totalPrice,
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
        
        // dd($request->all());
        $order = Order::create([
        'user_id' => $user->id,
        'status' => 'Pending',
        'total_price' => $request->total,
        'payment_method' => $request->payment_method,
        'payment_status' => 'Unpaid',
        ]);


         // Prepare order items data
        $orderItemsData = collect($request->cart)->map(function ($item) {
            return [
                'product_id' => $item['product']['id'],
                'quantity' => $item['quantity'],
                'price' => $item['product']['price'] - ($item['product']['discount_price'] ?? 0),
            ];
        })->toArray();

    // Create related order items using Eloquent relationship
        $order->orderItems()->createMany($orderItemsData);

        $order->shippingAddress()->create([
            'user_id' => $user->id,
            'name' => $request->name,
            'city' => $request->city,
            'address' => $request->address,
            'postal_code' => $request->postal_code,
            'phone' => $request->phone,
        ]);

          $user->cartItems()->delete();

          if($request->payment_method === 'bkash' || $request->payment_method === 'cod')
          {
             return Inertia::render('client_pages/checkout/BkashPayment');
          }
          elseif($request->payment_method === 'card')
          {
            return Inertia::render('client_pages/checkout/CardPayment');
          }
         
       

    }


    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
         $order->load([
                'orderItems.product.images' => function ($query) {
                    $query->where('is_featured', true)->limit(1);
                },
                'shippingAddress',
                'payment',
                'user' => function ($query) {
                    $query->select('id', 'name', 'email'); // You must include 'id' if it's a foreign key
                },
            ]);


        return Inertia::render('client_pages/OrderDetails', [
            'order' => $order,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        
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
         $order->delete();

        return redirect()->route('orders.index')->with('success', 'Order deleted successfully.');
    }
}
