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
            $table->id();
            $table->boolean('default')->default(false);
            $table->string('name', 150);
            $table->string('username', 150)->unique();
            $table->string('phone', 100)->unique();
            $table->string('photo')->nullable();
            $table->tinyInteger('role');
            $table->string('password', 250);
            $table->float('balance')->default(0);
            $table->float('store_balance')->default(0);
            $table->float('portal_balance')->default(0);
            $table->rememberToken();
            $table->timestamps();
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
