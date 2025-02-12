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
        Schema::create('images', function (Blueprint $table) {
            $table->bigIncrements('id'); // Khóa chính
            $table->string('image', 255); // Tên của hình ảnh

            $table->unsignedBigInteger('tour_id')->nullable(); // ID của tour (có thể null)
            
            $table->timestamps(); // Cột created_at và updated_at
            $table->softDeletes(); // Cột delete_at để hỗ trợ xóa mềm

            // Ràng buộc khóa ngoại
            $table->foreign('tour_id')->references('id')->on('tours')->onDelete('cascade');
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('images');
    }
};
