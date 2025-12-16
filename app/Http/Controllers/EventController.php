<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use App\Models\UserVoucher;

class EventController extends Controller
{
    public function getNewUserVouchers()
{
    $now = now();

    $vouchers = Coupon::where('target_user', 'new_user')
        ->where('is_active', 1)
        ->where(function ($q) use ($now) {
            // start_date NULL hoặc start_date <= hiện tại
            $q->whereNull('start_date')
              ->orWhere('start_date', '<=', $now);
        })
        ->where(function ($q) use ($now) {
            // end_date NULL hoặc end_date >= hiện tại
            $q->whereNull('end_date')
              ->orWhere('end_date', '>=', $now);
        })
        ->get();

    return response()->json($vouchers);
}


  public function saveVoucher($id)
{
    // 1) Chưa đăng nhập
    if (!auth()->check()) {
        return response()->json([
            'status' => 'login_required',
            'message' => 'Bạn cần đăng nhập để nhận voucher.'
        ], 401);
    }

    $user = auth()->user();

    // 2) Không phải người mới
    if (!$user->is_new_user) {
        return response()->json([
            'success' => false,
            'message' => 'Voucher này chỉ dành cho người mới.'
        ], 403);
    }

    // 3) Voucher không hợp lệ / không active
    $voucher = Coupon::where('id', $id)
        ->where('target_user', 'new_user')
        ->where('is_active', 1)
        ->first();

    if (!$voucher) {
        return response()->json([
            'success' => false,
            'message' => 'Voucher không hợp lệ hoặc đã hết hạn.'
        ], 404);
    }

    // 4) Đã nhận rồi
    $exists = UserVoucher::where('user_id', $user->id)
        ->where('coupon_id', $id)
        ->exists();

    if ($exists) {
        return response()->json([
            'success' => false,
            'message' => 'Bạn đã nhận voucher này rồi.'
        ], 409);
    }

    // 5) Lưu voucher
    UserVoucher::create([
        'user_id' => $user->id,
        'coupon_id' => $id,
        'is_used' => false
    ]);

    // 6) Trả kết quả CHUẨN (để JS hiểu đúng)
    return response()->json([
        'success' => true,
        'message' => 'Đã thêm voucher vào tài khoản của bạn!'
    ]);
}
}