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
        if (!auth()->check()) {
            return response()->json(['message' => 'Bạn cần đăng nhập để nhận voucher.']);
        }

        $user = auth()->user();

        if (!$user->is_new_user) {
            return response()->json(['message' => 'Voucher này chỉ dành cho người mới.']);
        }

        $voucher = Coupon::where('id', $id)
            ->where('target_user', 'new_user')
            ->first();

        if (!$voucher) {
            return response()->json(['message' => 'Voucher không hợp lệ.']);
        }

        $exists = UserVoucher::where('user_id', $user->id)
            ->where('coupon_id', $id)
            ->exists();

        if ($exists) {
            return response()->json(['message' => 'Bạn đã nhận voucher này rồi.']);
        }

        UserVoucher::create([
            'user_id' => $user->id,
            'coupon_id' => $id,
            'is_used' => false
        ]);

        return response()->json(['message' => 'Đã thêm voucher vào tài khoản của bạn!']);
    }
}
