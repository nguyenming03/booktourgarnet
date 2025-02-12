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
            Schema::create('category_tour', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('category_tour', 255);
                $table->longText('description')->nullable();
                $table->tinyInteger('status')->default(1);
                $table->integer('responsibility')->nullable();
                $table->timestamps();
                $table->softDeletes();
            });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('category_tour');
    }
};
