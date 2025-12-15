<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\SuperAdmin; // <- THÊM DÒNG NÀY

class AdminMiddlewareServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        // Đăng ký middleware admin & superadmin
        Route::aliasMiddleware('admin', AdminMiddleware::class);
        Route::aliasMiddleware('superadmin', SuperAdmin::class); // <- THÊM DÒNG NÀY
    }
}
