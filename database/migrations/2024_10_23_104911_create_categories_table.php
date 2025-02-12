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
        Schema::create('categories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 255);
            $table->unsignedBigInteger('parent_id')->nullable();  // Danh mục cha, có thể để trống
            $table->string('slug', 255);
            $table->string('img_thumb', 255)->nullable();  // Hình đại diện của danh mục
            $table->longText('description')->nullable();    // Mô tả danh mục
            $table->tinyInteger('hot')->default(0);     // Danh mục nổi bật (0: không, 1: có)
            $table->tinyInteger('status')->default(1);  // Trạng thái (1: hiển thị, 0: ẩn)
            $table->unsignedBigInteger('user_id');      // Người dùng tạo danh mục
            $table->timestamps();
            $table->softDeletes();

            // Foreign key constraint
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
