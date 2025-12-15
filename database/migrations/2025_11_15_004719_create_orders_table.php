<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();

            // Người dùng (có thể null)
            $table->unsignedBigInteger('user_id')->nullable();

            // Thông tin khách hàng
            $table->string('customer_name');
            $table->string('customer_phone');
            $table->string('customer_email')->nullable();
            $table->text('customer_address');

            // Tổng tiền hàng
            $table->integer('total')->default(0);

            // 💵 Phí vận chuyển
            $table->integer('shipping_fee')->default(0);

            // 🎟 Mã voucher áp dụng
            $table->string('voucher_code')->nullable();

            // 💰 Số tiền giảm sau voucher
            $table->integer('discount_amount')->default(0);

            // 💳 Phương thức thanh toán: COD / BANK
            $table->string('payment_method')->default('COD');

            // ✔ Trạng thái thanh toán: unpaid / paid
            $table->string('payment_status')->default('unpaid');

            // 📦 Trạng thái đơn hàng
            $table->string('status')->default('Chờ xử lý');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
