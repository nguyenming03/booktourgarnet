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
        Schema::create('favorites', function (Blueprint $table) {
            $table->bigIncrements('id'); // Khóa chính
            $table->unsignedBigInteger('user_id'); // ID của người dùng
            $table->unsignedBigInteger('tour_id'); // ID của tour
            $table->timestamps(); // Cột created_at và updated_at
            $table->softDeletes(); // Cột delete_at để hỗ trợ xóa mềm
        
            // Ràng buộc khóa ngoại
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('tour_id')->references('id')->on('tours')->onDelete('cascade');
        
            // Ràng buộc duy nhất
            $table->unique(['user_id', 'tour_id'], 'unique_user_tour');
        
            // Chỉ mục
            $table->index('user_id');
            $table->index('tour_id');
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('favorites');
    }
};
