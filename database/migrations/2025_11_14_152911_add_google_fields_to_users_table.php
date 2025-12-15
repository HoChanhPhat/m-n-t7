<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
  public function up()
{
    Schema::table('users', function (Blueprint $table) {

        // thêm google_id nếu CHƯA có
        if (!Schema::hasColumn('users', 'google_id')) {
            $table->string('google_id')->nullable()->unique();
        }

        // thêm avatar nếu CHƯA có
        if (!Schema::hasColumn('users', 'avatar')) {
            $table->string('avatar')->nullable();
        }
    });
}


public function down()
{
    Schema::table('users', function (Blueprint $table) {
        $table->dropColumn(['google_id', 'avatar']);
    });
}

};
