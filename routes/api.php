<?php

use App\Http\Controllers\MoveController;
use App\Http\Controllers\PokemonController;
use App\Http\Controllers\StatisticController;
use App\Http\Controllers\TypeController;
use Illuminate\Support\Facades\Route;

Route::prefix('pokemon')->group(function () {
    Route::get('/', [PokemonController::class, 'index'])->name('pokemon.index');
    Route::get('{id}', [PokemonController::class, 'show'])->name('pokemon.show');
    Route::get('/greaterthan/{value}', [PokemonController::class, 'greaterThan'])->name('pokemon.greaterthan');
    Route::get('/lessthan/{value}', [PokemonController::class, 'lessThan'])->name('pokemon.lessthan');
    Route::get('/movesgreaterthan/{value}', [PokemonController::class, 'movesGreaterThan'])->name('pokemon.moves.greaterthan');
    Route::get('/moveslessthan/{value}', [PokemonController::class, 'movesLessThan'])->name('pokemon.moves.lessthan');
});

Route::prefix('move')->group(function () {
    Route::get('/', [MoveController::class, 'index'])->name('move.index');
    Route::get('{id}', [MoveController::class, 'show'])->name('move.show');
});

Route::prefix('stat')->group(function () {
    Route::get('/', [StatisticController::class, 'index'])->name('stat.index');
    Route::get('{id}', [StatisticController::class, 'show'])->name('stat.show');
});

Route::prefix('type')->group(function () {
    Route::get('/', [TypeController::class, 'index'])->name('type.index');
    Route::get('{id}', [TypeController::class, 'show'])->name('type.show');
});
