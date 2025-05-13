<?php

namespace App\Http\Controllers\AdminController;

use App\Models\Slider;
use App\Http\Controllers\Controller;
use App\Http\Requests\AdminRequest\Slider\StoreSliderRequest as SliderStoreSliderRequest;
use App\Http\Requests\AdminRequest\Slider\UpdateSliderRequest as SliderUpdateSliderRequest;
use App\Http\Requests\StoreSliderRequest;
use App\Http\Requests\UpdateSliderRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use Inertia\Inertia;

class SliderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
       $sliders = Slider::query()
        ->when($request->search, fn($q) =>
            $q->where('name', 'like', '%' . $request->search . '%')
        )
        ->latest()
        ->get();

    return Inertia::render('admin_pages/slider/Index', [
        'sliders' => $sliders,
        'filters' => $request->only('search'),
    ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
           return Inertia::render('admin_pages/slider/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SliderStoreSliderRequest $request)
    {
         Slider::create($request->validated());

         return redirect()->route('sliders.index')->with('success', 'Slider created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Slider $slider)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
   public function edit(Slider $slider)
{
    
    return inertia('admin_pages/slider/Edit', [
        'slider' => $slider
    ]);
}


    /**
     * Update the specified resource in storage.
     */
  public function update(SliderUpdateSliderRequest $request, Slider $slider)
{
     
    $slider->update($request->validated());

    return redirect()->route('sliders.index')->with('success', 'Slider updated successfully.');
}

    /**
     * Remove the specified resource from storage.
     */
   public function destroy(Slider $slider)
{
    $slider->delete();

    return redirect()->route('sliders.index')->with('success', 'Slider deleted successfully.');
}
}
