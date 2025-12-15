<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAuthController extends Controller
{
    public function showLogin()
    {
        return view('admin.auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::guard('admin')->attempt($credentials)) {

            $request->session()->regenerate();

            // ĐÚNG ROUTE NAME
            return redirect()->route('dashboard');
        }

        return back()->withErrors(['error' => 'Sai email hoặc mật khẩu']);
    }

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // TRẢ VỀ TRANG LOGIN ADMIN
     return redirect()->route('admin.login');

    }
}
