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
        Schema::create('ratings', function (Blueprint $table) {
            $table->bigIncrements('id'); // Khóa chính
            $table->smallInteger('star'); // Số sao (1-5)
            $table->timestamps(); // Cột created_at và updated_at
            $table->softDeletes(); // Cột delete_at để hỗ trợ xóa mềm

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ratings');
    }
};
