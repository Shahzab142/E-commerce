<?php

namespace App\Providers;

use App\Models\AdminCategory;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

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
        if (! $this->app->runningInConsole() && ($this->app->environment('production') || (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https'))) {
            URL::forceScheme('https');
        }

        set_time_limit(0); // Permanent fix for 30s timeout

        /*
        |--------------------------------------------------------------------------
        | Storefront Header Data
        |--------------------------------------------------------------------------
        |
        | Share cart count, wishlist count and published categories with the
        | storefront header on every request.
        |
        */

        View::composer('layouts.header', function ($view): void {
            $request = request();

            $cart = $request->session()->get('cart', []);
            if ($cart === [] && $request->user()?->isUser()) {
                $cart = $request->user()->cartItems()->pluck('quantity', 'product_id')->all();
            }

            $view->with('cartCount', (int) array_sum($cart));
            $wishlistCount = 0;
            if ($request->user()) {
                try {
                    $wishlistCount = $request->user()->wishlistItems()->count();
                } catch (\Exception $e) {
                    $wishlistCount = 0;
                }
            }
            $view->with('wishlistCount', $wishlistCount);
            $view->with('categories', AdminCategory::query()->where('status', 'published')->orderBy('name')->get());
        });

        /*
        |----------------------------------------------------------------------
        | Bootstrap pagination markup
        |----------------------------------------------------------------------
        |
        | The storefront uses Bootstrap 5, so paginators render Bootstrap
        | compatible markup instead of the default Tailwind views.
        |
        */

        Paginator::useBootstrapFive();
    }
}
