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
        Schema::create('change_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable(); // ID người thực hiện thay đổi
            $table->string('action'); // Loại hành động: create, update, delete
            $table->string('model'); // Tên model hoặc bảng bị thay đổi
            $table->unsignedBigInteger('model_id')->nullable(); // ID của đối tượng bị thay đổi
            $table->json('changes')->nullable(); // Thay đổi chi tiết (giá trị cũ và mới)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('change_logs');
    }
};
