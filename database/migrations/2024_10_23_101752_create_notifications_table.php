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
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // Tiêu đề thông báo
            $table->text('content')->nullable(); // Nội dung thông báo
            $table->boolean('all_user')->default(0); // Gửi đến tất cả người dùng
            $table->string('type')->nullable(); // Loại thông báo (system, promo, alert, ...)
            $table->boolean('is_active')->default(1); // Trạng thái hoạt động của thông báo
            $table->timestamps(); // created_at, updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
