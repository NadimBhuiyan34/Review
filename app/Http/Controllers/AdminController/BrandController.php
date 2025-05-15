<?php

namespace App\Http\Controllers\AdminController;

use App\Models\Brand;
use App\Http\Controllers\Controller;
use App\Http\Requests\AdminRequest\Brand\StoreBrandRequest as BrandStoreBrandRequest;
use App\Http\Requests\AdminRequest\Brand\UpdateBrandRequest as BrandUpdateBrandRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use Inertia\Inertia;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $brands = Brand::query()
        ->when($request->search, fn ($q) =>
            $q->where('name', 'like', "%{$request->search}%")
        )
        ->latest()
        ->paginate(10);
    

    return Inertia::render('admin_pages/brand/Index', [
        'brands' => $brands,
        'filters' => $request->only('search'),
    ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('admin_pages/brand/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BrandStoreBrandRequest $request)
    {
        Brand::create($request->validated());

         return redirect()->route('brands.index')
         ->with('success', 'Brand created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Brand $brand)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Brand $brand)
    {
        return Inertia::render('admin_pages/brand/Edit',[
            'brand' => $brand
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BrandUpdateBrandRequest $request, Brand $brand)
    {
        $brand->update($request->validated());
        return redirect()->route('brands.index')
        ->with('success','Brand Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Brand $brand)
    {
        $brand->delete();
        return redirect()->route('brands.index')
        ->with('success','Brand Deleted Successfully');
    }
}
