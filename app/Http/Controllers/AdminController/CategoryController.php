<?php

namespace App\Http\Controllers\AdminController;

use App\Models\Category;
use App\Http\Controllers\Controller;
use App\Http\Requests\AdminRequest\Category\StoreCategoryRequest as CategoryStoreCategoryRequest;
use App\Http\Requests\AdminRequest\Category\UpdateCategoryRequest as CategoryUpdateCategoryRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use Inertia\Inertia;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $categories = Category::query()
            ->with(['categoryParent:id,name']) // Load only 'id' and 'name' fields from parent
            ->when(
                $request->search,
                fn($q) =>
                $q->where('name', 'like', "%{$request->search}%")
            )
            ->latest()
            ->paginate(5);


        
        return Inertia::render('admin_pages/category/Index', [
            'categories' => $categories,
            'filters' => $request->only('search'),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::whereNull('parent_id')->get();
        return Inertia::render('admin_pages/category/Create', ['categories' => $categories]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryStoreCategoryRequest $request)
    {

        Category::create($request->validated());

        return redirect()->route('categories.index')
            ->with('success', 'Category created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        return Inertia::render('admin_pages/category/Edit', [
            'category' => $category
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryUpdateCategoryRequest $request, Category $category)
    {
        $category->update($request->validated());

        return redirect()->route('categories.index')->with('success', 'Category updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        $category->delete();

        return redirect()->route('categories.index')->with('success', 'Category deleted successfully.');
    }
}
