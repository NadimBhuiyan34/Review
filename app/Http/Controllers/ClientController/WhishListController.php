<?php

namespace App\Http\Controllers\ClientController;

use App\Http\Controllers\Controller;
use App\Models\WhishList;
use App\Http\Requests\ClientRequest\WishList\StoreWhishListRequest;
use App\Http\Requests\ClientRequest\WishList\UpdateWhishListRequest;
use Inertia\Inertia;
class WhishListController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

            $user = auth()->user();

        $wishlist = $user->wishlist()->with([
            'product' => function ($query) {
                $query->with(['images' => function ($q) {
                    $q->where('is_featured', true);
                }]);
            }
        ])->get();

            return Inertia::render('client_pages/WhishList', [
                'wishlist' => $wishlist,
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
    public function store(StoreWhishListRequest $request)
    {
$validated = $request->validated(); // Better than calling validate() again

    $user = $request->user();

    $user->wishlist()->updateOrCreate(
        ['product_id' => $validated['product_id']],
        [] // You can add other fields here if needed
    );

    return back()->with('success', 'Product added to wishlist.');
    }

    /**
     * Display the specified resource.
     */
    public function show(WhishList $whishList)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(WhishList $whishList)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateWhishListRequest $request, WhishList $whishList)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(WhishList $whishlist)
    {
           
            $whishlist->delete();

           return back()->with('success', 'Item removed from wishlist');
    }
}
