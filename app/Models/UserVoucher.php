<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserVoucher extends Model
{
    protected $fillable = [
        'user_id',
        'coupon_id',
        'is_used',
    ];

    /**
     * Quan hệ: UserVoucher -> Coupon
     * 1 user_voucher thuộc về 1 coupon
     */
    public function coupon()
    {
        return $this->belongsTo(Coupon::class, 'coupon_id');
    }
}
