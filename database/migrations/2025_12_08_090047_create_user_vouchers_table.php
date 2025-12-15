<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up(): void
{
    Schema::create('user_vouchers', function (Blueprint $table) {
        $table->id();

        // user sở hữu voucher
        $table->foreignId('user_id')->constrained()->onDelete('cascade');

        // voucher nào (giả sử bảng của bạn tên là 'coupons')
        $table->foreignId('coupon_id')->constrained('coupons')->onDelete('cascade');

        // đã dùng voucher này chưa
        $table->boolean('is_used')->default(false);

        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_vouchers');
    }
};
