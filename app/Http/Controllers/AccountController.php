<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AccountController extends Controller
{
    public function index() {
        $user = auth()->user();
        return view('account.index', compact('user'));
    }

    public function update(Request $request) {
        $user = auth()->user();

        $request->validate([
            'name'             => 'required|string|max:255',
            'phone'            => 'nullable|string|max:20',
            'shipping_address' => 'nullable|string|max:255',
        ]);

        $user->update([
            'name'             => $request->name,
            'phone'            => $request->phone,
            'shipping_address' => $request->shipping_address,
        ]);

        return back()->with('success', 'Cập nhật thông tin thành công!');
    }

    // =========================
    // ĐỔI MẬT KHẨU
    // =========================
    public function changePassword(Request $request)
    {
       $request->validate(
    [
        'current_password' => 'required',
        'new_password' => 'required|min:6|confirmed',
    ],
    [
        'current_password.required' => 'Vui lòng nhập :attribute.',
        'new_password.required' => 'Vui lòng nhập :attribute.',
        'new_password.min' => ':attribute phải có ít nhất :min ký tự.',
        'new_password.confirmed' => ':attribute nhập lại không khớp.',
    ],
    [
        'current_password' => 'mật khẩu hiện tại',
        'new_password' => 'mật khẩu mới',
        'new_password_confirmation' => 'nhập lại mật khẩu mới',
    ]
);


        $user = auth()->user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->with('error', 'Mật khẩu hiện tại không đúng!');
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return back()->with('success', 'Đổi mật khẩu thành công!');
    }
}
