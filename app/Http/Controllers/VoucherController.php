<?php

namespace App\Http\Controllers;

use App\Models\UserVoucher;

class VoucherController extends Controller
{
    public function mine()
    {
        $vouchers = UserVoucher::with('coupon')
            ->where('user_id', auth()->id()) // ✅ BỎ dấu cách
            ->latest()
            ->get();

        return view('vouchers.mine', compact('vouchers'));
    }
}
