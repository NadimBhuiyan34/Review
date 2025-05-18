<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Inertia::share([
        'cartCount' => function () {
            if (Auth::check()) {
                // Adjust this to your real cart items counting logic
                return Auth::user()->cartItems()->count();
            }
            return 0;
        },
    ]);
    }
}
