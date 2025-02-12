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
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('phone', 15)->nullable();
            $table->string('address')->nullable();
            $table->string('avatar')->nullable();
            $table->date('birth')->nullable();
            $table->enum('gender', ['nam', 'nu'])->nullable();
            $table->string('password');
            $table->tinyInteger('status')->default(1);
            $table->string('remember_token', 100)->nullable();
            $table->unsignedBigInteger('role_id')->nullable();
            $table->timestamps();
            
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
