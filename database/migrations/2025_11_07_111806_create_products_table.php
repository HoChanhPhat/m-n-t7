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
        Schema::create('products', function (Blueprint $table) {
            $table->id();

            $table->string('name');                          // tên sản phẩm
            $table->text('description')->nullable();         // mô tả sản phẩm
            $table->decimal('price', 10, 2);                 // giá
            $table->integer('quantity')->default(0);         // số lượng tồn
            $table->string('image')->nullable();             // ảnh chính

            $table->json('specs')->nullable();               // THÔNG SỐ KỸ THUẬT (JSON)

            $table->foreignId('category_id')                 // liên kết tới bảng categories
                  ->constrained('categories')
                  ->onDelete('cascade');

            $table->foreignId('brand_id')                    // liên kết tới bảng brands
                  ->constrained('brands')
                  ->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
