<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class SuperAdmin
{
    public function handle($request, Closure $next)
    {
        // Kiểm tra đăng nhập bằng guard 'admin'
        if (!Auth::guard('admin')->check()) {
            return redirect()->route('admin.login');
        }

        // Kiểm tra role = superadmin
        if (Auth::guard('admin')->user()->role !== 'superadmin') {
            abort(403, 'Bạn không có quyền truy cập trang này.');
        }

        return $next($request);
    }
}
