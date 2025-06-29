<?php

namespace App\Http\Controllers\AdminController;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Order;
use Inertia\Inertia;

class AdminOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
   public function index(Request $request)
{
    
   $query = Order::with(['user.profile']); // Eager load user & profile

    // Apply search filter
    if ($request->has('search') && $request->search !== null) {
        $query->where('order_number', 'like', '%' . $request->search . '%');
    }

    // Apply latest ordering and paginate
    $orders = $query->latest()->paginate(10)->appends($request->only('search'));

    // Return Inertia response
    return Inertia::render('admin_pages/order/Index', [
        'orders' => $orders,
        'filters' => $request->only('search'),
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
         // Find the order first
            $order = Order::with([
                'orderItems.product.images' => function ($query) {
                    $query->where('is_featured', true)->limit(1);
                },
                'shippingAddress',
                'payment',
                'user' => function ($query) {
                    $query->select('id', 'name', 'email'); // Include 'id' for foreign key resolution
                },
            ])->findOrFail($id);

            return Inertia::render('admin_pages/order/Show', [
                'order' => $order,
            ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
