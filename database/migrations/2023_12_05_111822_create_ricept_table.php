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
        Schema::create('ricepts', function (Blueprint $table) {
            $table->id();
            $table->float('ammount');
            $table->string('info', 255);
            $table->boolean('type');
            $table->foreignId('stores_id')->constrained('stores');
            $table->foreignId('users_id')->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ricept');
    }
};
