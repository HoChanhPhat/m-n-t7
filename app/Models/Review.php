<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    // Cho phép fill dữ liệu vào các cột này
    protected $fillable = ['user_id', 'product_id', 'rating', 'comment'];

    // Quan hệ: đánh giá thuộc về 1 user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Quan hệ: đánh giá thuộc về 1 sản phẩm
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
