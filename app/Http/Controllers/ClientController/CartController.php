<?php

 namespace App\Http\Controllers\ClientController;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use App\Http\Requests\ClientRequest\Cart\UpdateCartRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class CartController extends Controller
{
     use AuthorizesRequests;
    public function index()
    {
        $userId = Auth::id();

        $cartItems = Cart::with([
            'product:id,name,price,discount_price',
            'product.images' => fn($query) => $query->where('is_featured', true),
        ])
        ->where('user_id', $userId)
        ->get()
        ->map(function ($cart) {
            return [
                'id' => $cart->id,
                'product_id' => $cart->product_id,
                'name' => $cart->product->name,
                'price' => $cart->product->price,
                'discount_price' => $cart->product->discount_price,
                'quantity' => $cart->quantity,
                'image' => optional($cart->product->images->first())->image_path ?? '/placeholder.jpg',
            ];
        });

        $totalPrice = $cartItems->sum(fn($item) => $item['price']-$item['discount_price'] * $item['quantity']);

        return Inertia::render('client_pages/Cart', [
            'cartItems' => $cartItems,
            'totalPrice' => $totalPrice,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|uuid|exists:products,id',
            'quantity' => 'nullable|integer|min:1',
        ]);

        $user = $request->user();

        $cartItem = Cart::updateOrCreate(
            [
                'user_id' => $user->id,
                'product_id' => $validated['product_id'],
            ],
            [
                'quantity' => $validated['quantity'] ?? 1,
            ]
        );

        return back()->with('success', 'Product added to cart.');
    }

    public function update(UpdateCartRequest $request, Cart $cart)
    {
       
        // Ensure the user owns the cart
        $this->authorize('update', $cart); // Optional: Add policy

        $cart->update([
            'quantity' => $request->validated()['quantity'],
        ]);

        return redirect()->back()->with('success', 'Cart updated successfully.');
    }

    public function destroy(Cart $cart)
    {
        // Ensure the user owns the cart
        $this->authorize('delete', $cart); // Optional: Add policy

        $cart->delete();

        return redirect()->route('carts.index')->with('success', 'Item removed from cart.');
    }
}

