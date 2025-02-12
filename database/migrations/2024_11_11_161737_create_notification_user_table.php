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
        Schema::create('notification_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('notification_id')->constrained()->onDelete('cascade'); // Liên kết với thông báo
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Liên kết với người dùng
            $table->boolean('is_read')->default(0); // Đã đọc hay chưa
            $table->timestamps(); // created_at, updated_at

            $table->index(['notification_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notification_user');
    }
};
