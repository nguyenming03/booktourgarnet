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
            $table->bigIncrements('id'); // Khóa chính
            $table->unsignedBigInteger('tour_id'); // ID của tour liên kết
            $table->string('name', 255); // Tên của coupon
            $table->string('code', 255); // Mã coupon
            $table->dateTime('start_date'); // Ngày bắt đầu
            $table->dateTime('end_date'); // Ngày kết thúc
            $table->integer('percentage_price'); // Tỷ lệ giảm giá
            $table->string('type'); // loại (tiền hay %)
            $table->tinyInteger('status')->default(1); // Trạng thái (1: hoạt động, 0: không hoạt động)
            $table->timestamps(); // Cột created_at và updated_at
            $table->softDeletes(); // Cột delete_at để hỗ trợ xóa mềm

            // Ràng buộc khóa ngoại
            // $table->foreign('tour_id')->references('id')->on('tours')->onDelete('cascade');
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
