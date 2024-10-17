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
        Schema::create('pokemon_statistics', function (Blueprint $table) {
            $table->unsignedBigInteger('pokemon_id');

            $table->unsignedBigInteger('statistic_id');
            $table->integer('value');
            $table->timestamps();


            // Add foreign keys
            $table->foreign('pokemon_id')->references('id')->on('pokemons')->onDelete('cascade');
            $table->foreign('statistic_id')->references('id')->on('statistics')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pokemon_statistics');
    }
};
