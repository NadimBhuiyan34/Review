<?php

use App\Http\Controllers\AdminController\BrandController;
use App\Http\Controllers\AdminController\CategoryController;
use App\Http\Controllers\AdminController\SliderController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Home');
})->name('home');

Route::get('/product_details', function () {
    return Inertia::render('client_pages/ProductDetails');
})->name('product_details');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::resource('sliders', SliderController::class);
Route::resource('categories', CategoryController::class);
Route::resource('brands', BrandController::class);

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
