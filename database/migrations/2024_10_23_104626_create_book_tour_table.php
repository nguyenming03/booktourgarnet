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
        Schema::create('book_tour', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('tour_id');
            $table->string('name', 255);
            $table->string('email', 255);
            $table->string('phone', 255);
            $table->string('address', 255)->nullable();
            $table->dateTime('date_booking');
            $table->dateTime('start_date');
            $table->text('note')->nullable();
            $table->integer('number_old')->default(0);
            $table->integer('number_children')->default(0);
            $table->decimal('total_money', 10, 2);
            $table->tinyInteger('status')->default(1);
            $table->integer('sale')->default(0);
            $table->timestamps();
            $table->softDeletes();

            // Foreign key constraints
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('tour_id')->references('id')->on('tours')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('book_tour');
    }
};
