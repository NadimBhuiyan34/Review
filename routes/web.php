<?php

use App\Http\Controllers\AdminController\CategoryController;
use App\Http\Controllers\AdminController\SliderController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Home');
})->name('home');

Route::get('dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::resource('sliders', SliderController::class);
Route::resource('categories', CategoryController::class); 

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
