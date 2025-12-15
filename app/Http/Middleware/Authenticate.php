<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    protected function redirectTo($request)
    {
        // Nếu request vào khu vực admin => chuyển về admin login
        if ($request->is('admin') || $request->is('admin/*')) {
            return route('admin.login');
        }

        // Còn lại là khu vực khách => chuyển về login của khách
        return route('login');
    }
}
