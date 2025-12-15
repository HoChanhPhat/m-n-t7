<?php

use Illuminate\Support\Facades\Route;

// FRONTEND CONTROLLERS
use App\Http\Controllers\PageController;
use App\Http\Controllers\ProductViewController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\GoogleController;
use App\Http\Controllers\UserOrderController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\WishlistController;

// ===============================
// HOME
// ===============================
Route::get('/', [PageController::class, 'home'])->name('home');

// ===============================
// PRODUCT
// ===============================
Route::get('/products', [ProductViewController::class, 'index'])->name('products.all');
Route::get('/products/search', [ProductViewController::class, 'search'])->name('products.search');
Route::get('/products/{id}', [ProductViewController::class, 'show'])->name('web.products.show');
Route::get('/category/{id}', [ProductViewController::class, 'showByCategory'])->name('category.show');

// REVIEW
Route::post('/products/{id}/review', [ProductViewController::class, 'addReview'])
    ->middleware('auth')
    ->name('products.review');

// ===============================
// CART
// ===============================
Route::prefix('cart')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('cart.index');
    Route::post('/add/{id}', [CartController::class, 'add'])->name('cart.add');
    Route::post('/update/{id}', [CartController::class, 'update'])->name('cart.update');
    Route::get('/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
    Route::get('/clear', [CartController::class, 'clear'])->name('cart.clear');
});

// ===============================
// CHECKOUT
// ===============================
Route::prefix('checkout')->middleware('auth')->group(function () {
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');
    Route::post('/checkout', [CheckoutController::class, 'placeOrder'])->name('checkout.store');

    Route::post('/checkout/apply-coupon', [CheckoutController::class, 'applyCoupon'])
        ->name('checkout.applyCoupon');
});

// ===============================
// USER AUTH
// ===============================
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// GOOGLE LOGIN
Route::get('/auth/google', [GoogleController::class, 'redirect'])->name('google.redirect');
Route::get('/auth/google/callback', [GoogleController::class, 'callback'])->name('google.callback');

// ===============================
// ACCOUNT + ORDERS (yêu cầu login)
// ===============================
Route::middleware('auth')->group(function () {

    Route::get('/account', [AccountController::class, 'index'])->name('account.index');
    Route::post('/account/update', [AccountController::class, 'update'])->name('account.update');

    Route::get('/orders', [UserOrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{id}', [UserOrderController::class, 'detail'])->name('user.orders.show');
});

// ===============================
// WISHLIST (phải đặt NGOÀI auth để navbar dùng được)
// ===============================
Route::get('/wishlist', [WishlistController::class, 'index'])
    ->name('wishlist.index');

Route::post('/wishlist/toggle/{id}', [WishlistController::class, 'toggle'])
    ->middleware('auth')
    ->name('wishlist.toggle');


use App\Http\Controllers\EventController;
Route::get('/event/new-user/vouchers', [EventController::class, 'getNewUserVouchers']);
Route::post('/event/new-user/save/{id}', [EventController::class, 'saveVoucher']);
