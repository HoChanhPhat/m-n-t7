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
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();

            $table->string('code')->unique(); // Mã giảm giá, ví dụ: TECH10
            $table->enum('type', ['percent', 'fixed']); // percent: %, fixed: số tiền
            $table->unsignedInteger('value'); // nếu percent: 10 = 10%, nếu fixed: 50000 = 50k

            $table->dateTime('start_date')->nullable(); // ngày bắt đầu
            $table->dateTime('end_date')->nullable();   // ngày kết thúc

            $table->boolean('is_active')->default(true); // đang kích hoạt hay không

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coupons');
    }
};
