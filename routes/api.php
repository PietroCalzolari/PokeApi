<?php

use App\Http\Controllers\MoveController;
use App\Http\Controllers\PokemonController;
use App\Http\Controllers\StatisticController;
use App\Http\Controllers\TypeController;
use Illuminate\Support\Facades\Route;

Route::prefix('pokemon')->group(function () {
    Route::get('/', [PokemonController::class, 'index']);
    Route::get('{id}', [PokemonController::class, 'show']);
});

Route::prefix('move')->group(function () {
    Route::get('/', [MoveController::class, 'index']);
    Route::get('{id}', [MoveController::class, 'show']);
});

Route::prefix('stat')->group(function () {
    Route::get('/', [StatisticController::class, 'index']);
    Route::get('{id}', [StatisticController::class, 'show']);
});

Route::prefix('type')->group(function () {
    Route::get('/', [TypeController::class, 'index']);
    Route::get('{id}', [TypeController::class, 'show']);
});
