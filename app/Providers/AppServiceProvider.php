<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Session;

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
        // Chia sẻ số lượng giỏ hàng tới mọi view
        View::composer('*', function ($view) {
            $cart = Session::get('cart', []);
            $cart_count = array_sum(array_column($cart, 'quantity'));
            $view->with('cart_count', $cart_count);
        });
    }
}
