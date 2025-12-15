<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    public function boot()
    {
        View::composer('*', function ($view) {

            // CART COUNT
            $cart = session()->get('cart', []);
            $cart_count = array_sum(array_column($cart, 'quantity'));

            // WISHLIST COUNT (session-based)
            $wishlist = session()->get('wishlist', []);
            $wishlist_count = count($wishlist);

            $view->with('cart_count', $cart_count)
                 ->with('wishlist_count', $wishlist_count)
                 ->with('wishlist', $wishlist);
        });
    }
}
