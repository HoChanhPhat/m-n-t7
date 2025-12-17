<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    // ✅ Cho phép create() lưu đủ các field bạn đang dùng trong CheckoutController
    protected $fillable = [
        'user_id',
        'customer_name',
        'customer_phone',
        'customer_email',
        'customer_address',

        'total',
        'voucher_code',
        'discount_amount',

        'payment_method',
        'payment_status',
        'status',
    ];

    // (Tuỳ chọn) Ép kiểu để an toàn khi dùng number_format / tính toán
    protected $casts = [
        'total' => 'integer',
        'discount_amount' => 'integer',
    ];

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}
