<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Category;
use App\Services\Contracts\CartServiceInterface;
use App\Services\CartService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(CartServiceInterface::class, CartService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
{
    View::composer(
        ['website.master', 'website.home.index'], // ✅ array
        function ($view) {
            $view->with('categories', Category::with('subCategories')->get());
        }
    );
}
}
