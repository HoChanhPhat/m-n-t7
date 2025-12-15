<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle($request, Closure $next)
    {
        // Dùng guard admin, CHỨ KHÔNG ĐƯỢC dùng Auth::check()
        if (!Auth::guard('admin')->check()) {
            return redirect()->route('admin.login');
        }

        // Nếu admin nhưng không có quyền admin
        if (Auth::guard('admin')->user()->role !== 'admin'
            && Auth::guard('admin')->user()->role !== 'superadmin') {

            abort(403, 'Bạn không có quyền truy cập');
        }

        return $next($request);
    }
}
