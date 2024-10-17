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
        Schema::create('pokemon_moves', function (Blueprint $table) {
            $table->unsignedBigInteger('pokemon_id');

            $table->unsignedBigInteger('move_id');
            $table->timestamps();


            // Add foreign keys
            $table->foreign('pokemon_id')->references('id')->on('pokemons')->onDelete('cascade');
            $table->foreign('move_id')->references('id')->on('moves')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pokemon_moves');
    }
};
