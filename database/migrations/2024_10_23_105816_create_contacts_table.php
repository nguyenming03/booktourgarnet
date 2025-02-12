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
        Schema::create('contacts', function (Blueprint $table) {
            $table->bigIncrements('id'); // Khóa chính
            $table->unsignedBigInteger('user_id')->nullable(); // ID của người dùng (có thể null)
            $table->string('name', 255); // Tên người gửi
            $table->string('email', 255); // Địa chỉ email
            $table->string('subject', 255)->nullable(); // Tiêu đề của liên hệ
            $table->text('message'); // Nội dung tin nhắn
            $table->timestamps(); // Cột created_at và updated_at
            $table->softDeletes(); // Cột delete_at để hỗ trợ xóa mềm

            // Ràng buộc khóa ngoại
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contacts');
    }
};
