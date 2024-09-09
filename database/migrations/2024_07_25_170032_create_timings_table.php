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
        Schema::create('timings', function (Blueprint $table) {
            $table->id();
            $table->time('start_time')->unique();
            $table->time('end_time')->unique();
            $table->enum('status', ['open', 'closed']);
            $table->enum('sex', ['male', 'female']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('timing');
    }
};
