<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('view_web', function (Blueprint $table) {
        $table->id();
        $table->string('ip_address', 45);
        $table->text('user_agent')->nullable();
        $table->timestamp('visited_at')->default(\DB::raw('CURRENT_TIMESTAMP'));
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visitors');
    }
};
