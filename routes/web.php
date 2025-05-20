<?php

use App\Http\Controllers\AdminController\BrandController;
use App\Http\Controllers\AdminController\CategoryController;
use App\Http\Controllers\AdminController\ProductController;
use App\Http\Controllers\AdminController\ProductImageController;
use App\Http\Controllers\AdminController\SliderController;
use App\Http\Controllers\ClientController\HomeController;
use App\Http\Controllers\ClientController\CartController;
use App\Http\Controllers\ClientController\OrderController;
use App\Http\Controllers\AdminController\ShopController;
use App\Http\Controllers\ClientController\ReviewController;
use App\Http\Controllers\ClientController\WhishListController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

 

Route::get('/', [HomeController::class, 'index'])->name('home');


// Route::get('/product_details', function () {
//     return Inertia::render('client_pages/ProductDetails');
// })->name('product_details');

Route::get('/product_details/{slug}', [HomeController::class, 'show'])->name('product_details.show');
Route::get('/product_carts', [HomeController::class, 'cart'])->name('product_carts.cart');
Route::get('/product_orders', [HomeController::class, 'order'])->name('product_orders.order');
Route::get('/product_payments', [HomeController::class, 'payment'])->name('product_payments.payment');

Route::middleware(['auth'])->group(function () {
    Route::resource('carts', CartController::class);
    Route::resource('whishlists', WhishListController::class);
    Route::resource('orders', OrderController::class);
    Route::resource('reviews', ReviewController::class);
});

Route::get('/checkout/cod', function () {
    return Inertia::render('client_pages/checkout/CODConfirmation');
})->name('cod.confirmation');

Route::get('/checkout/card', function () {
    return Inertia::render('client_pages/checkout/CardPayment');
})->name('card.checkout');

Route::get('/checkout/bkash', function () {
    return Inertia::render('client_pages/checkout/BkashPayment');
})->name('bkash.payment');


Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::resource('sliders', SliderController::class);
Route::resource('categories', CategoryController::class);
Route::resource('brands', BrandController::class);
Route::resource('products', ProductController::class);
Route::resource('shops', ShopController::class);
Route::resource('product_images', ProductImageController::class);

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
