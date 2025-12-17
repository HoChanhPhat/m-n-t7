<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\AdminBrandController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\AdminOrderController;
use App\Http\Controllers\Admin\AdminManageController;
use App\Http\Controllers\Admin\CouponController; 

// LOGIN
Route::get('/login', [AdminAuthController::class, 'showLogin'])->name('admin.login');
Route::post('/login', [AdminAuthController::class, 'login'])->name('admin.login.submit');
Route::post('/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

// PROTECTED
Route::middleware(['admin'])->group(function () {

    Route::get('/', [DashboardController::class, 'index'])
        ->name('admin.dashboard');

    // PRODUCTS
    Route::resource('products', ProductController::class)
        ->names('admin.products');

    // CATEGORIES
    Route::resource('categories', CategoryController::class)
        ->names('admin.categories');

    // BRANDS
    Route::resource('brands', AdminBrandController::class)
        ->names('admin.brands');

    // COUPONS
    Route::resource('coupons', CouponController::class)
        ->names('admin.coupons');

    Route::post('coupons/{coupon}/toggle', [CouponController::class, 'toggle'])
        ->name('admin.coupons.toggle');

    Route::get('/brands/by-category/{categoryId}',
        [AdminBrandController::class, 'getByCategory']
    )->name('admin.brands.byCategory');

    // ORDERS
    Route::get('/orders', [AdminOrderController::class, 'index'])
        ->name('admin.orders.index');
    Route::get('/orders/{id}', [AdminOrderController::class, 'show'])
        ->name('admin.orders.show');
    Route::post('/orders/{id}/status', [AdminOrderController::class, 'updateStatus'])
        ->name('admin.orders.updateStatus');

    // USERS
    Route::get('/users', [AdminUserController::class, 'index'])
        ->name('admin.users');
    Route::post('/users/{id}/toggle', [AdminUserController::class, 'toggleStatus'])
        ->name('admin.users.toggle');

    // SUPERADMIN
    Route::middleware('superadmin')->group(function () {
        Route::get('/admin-users', [AdminManageController::class, 'index'])
            ->name('admin.manage.index');
        Route::get('/admin-users/create', [AdminManageController::class, 'create'])
            ->name('admin.manage.create');
        Route::post('/admin-users/store', [AdminManageController::class, 'store'])
            ->name('admin.manage.store');
    });

});



use App\Http\Controllers\Admin\AdminPasswordController;

Route::get('/change-password', [AdminPasswordController::class, 'show'])
    ->name('admin.password.show');

Route::post('/change-password', [AdminPasswordController::class, 'update'])
    ->name('admin.password.update');
