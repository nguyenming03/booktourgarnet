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
        Schema::create('tours', function (Blueprint $table) {

            $table->bigIncrements('id');
            $table->string('name');
            $table->string('journeys');
            $table->string('schedule');
            $table->string('move_method');
            $table->string('starting_gate');
            $table->dateTime('start_date');
            $table->dateTime('end_date');
            $table->integer('number_guests');
            $table->integer('price_old');
            $table->integer('price_children')->nullable();
            $table->integer('sale')->nullable();
            $table->integer('view')->nullable();
            $table->longText('description')->nullable();
            $table->longText('content')->nullable();
            $table->string('image')->nullable();
            $table->unsignedBigInteger('location_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('category_tour_id');
            $table->integer('number_registered');
            $table->unsignedBigInteger('star')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('category_tour_id')->references('id')->on('category_tour');
            $table->foreign('location_id')->references('id')->on('locations');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tours');
    }
};
