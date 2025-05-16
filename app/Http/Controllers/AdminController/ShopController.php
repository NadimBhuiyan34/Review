<?php

namespace App\Http\Controllers\AdminController;

use App\Models\Shop;
use App\Http\Controllers\Controller;
use App\Http\Requests\AdminRequest\Shop\StoreShopRequest as ShopStoreShopRequest;
use App\Http\Requests\AdminRequest\Shop\UpdateShopRequest as ShopUpdateShopRequest;

use App\Http\Requests\StoreShopRequest;
use App\Http\Requests\UpdateShopRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use Inertia\Inertia;

class ShopController extends Controller
{
    /**
     * Display a listing of the resource. 
     */
    public function index(Request $request)
    {
            $shops = Shop::query()
        ->when($request->search, fn ($q) => $q->where('name', 'like', '%' . $request->search . '%'))
        ->paginate(10)
        ->withQueryString();

    return Inertia::render('admin_pages/shop/Index', [
        'shops' => $shops,
        'filters' => $request->only('search'),
    ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('admin_pages/shop/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ShopStoreShopRequest $request)
    {
        Shop::create($request->validated());

        return redirect()->route('shops.index')
        ->with('success','Shop Create Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Shop $shop)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Shop $shop)
    {
        return Inertia::render('admin_pages/shop/Edit',[
            'shop' => $shop
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ShopUpdateShopRequest $request, Shop $shop)
    {
        $shop->update($request->validated());

        return redirect()->route('shops.index')
        ->with('success','Shop Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Shop $shop)
    {
        $shop->delete();

        return redirect()->route('shops.index')
        ->with('success','Shop Deleted Successfully');
    }
}
