<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use App\Models\Category;

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
            return Auth::check() ? Auth::user()->cartItems()->count() : 0;
        },
        'whishCount' => function () {
            return Auth::check() ? Auth::user()->whishlist()->count() : 0;
        },

        'categories' => function () {
            return Category::with('child') // or categoryChild if that's your relation name
                ->whereNull('parent_id')
                ->where('status', true)
                ->get();
        },
    ]);
    }
}
