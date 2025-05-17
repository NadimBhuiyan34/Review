<?php

namespace App\Http\Controllers\AdminController;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Http\Requests\AdminRequest\Product\StoreProductRequest;
use App\Http\Requests\AdminRequest\Product\UpdateProductRequest;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Shop;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $products = Product::query()
            ->select('id', 'name', 'slug', 'stock', 'status')
            ->when($request->search, function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%');
            })
            ->latest()
            ->paginate(5);

        return Inertia::render('admin_pages/product/Index', [
            'products' => $products,
            'filters' => $request->only('search'),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::select('id', 'slug', 'name')->where('status', 1)->get();
        $brands = Brand::select('id', 'slug', 'name')->where('status', 1)->get();
        $shops = Shop::select('id', 'slug', 'name')->where('status', 1)->get();
        return Inertia::render('admin_pages/product/Create', ['categories' => $categories, 'brands' => $brands, 'shops' => $shops]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        Product::create($request->validated());

        return redirect()->route('products.index')
            ->with('success', 'Product created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {

        $product = Product::select('id', 'slug', 'name')
            ->with('images') 
            ->findOrFail($product->id); 

        return Inertia::render('admin_pages/product/ImageUpload', [
            'product' => $product,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $categories = Category::select('id', 'slug', 'name')->where('status', 1)->get();
        $brands = Brand::select('id', 'slug', 'name')->where('status', 1)->get();
        $shops = Shop::select('id', 'slug', 'name')->where('status', 1)->get();
        return Inertia::render('admin_pages/product/Edit', [
            'product' => $product,
            'categories' => $categories,
            'brands' => $brands,
            'shops' => $shops
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {

        $product->update($request->validated());

        return redirect()->route('products.index')->with('success', 'Product updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('products.index')->with('success', 'Product deleted successfully.');
    }
}
