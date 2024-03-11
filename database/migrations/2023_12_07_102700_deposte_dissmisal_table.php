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
        Schema::create('deposet__dissmisals', function (Blueprint $table) {
            $table->id();
            $table->float('ammount');
            $table->string('info');
            $table->boolean('type');
            $table->string('file')->nullable();
            $table->foreignId('users_id')->constrained('users');
            $table->foreignId('repo_id')->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deposets_dissmisals');
    }
};
