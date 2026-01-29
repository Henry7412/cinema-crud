<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PeliculaController;
use App\Http\Controllers\Api\TurnoController;
use App\Http\Controllers\Api\PeliculaTurnoController;

Route::post('/auth/register', [AuthController::class, 'register']);
Route::post('/auth/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/auth/logout', [AuthController::class, 'logout']);
    Route::get('/auth/me', [AuthController::class, 'me']);

    Route::apiResource('peliculas', PeliculaController::class);
    Route::apiResource('turnos', TurnoController::class);

    Route::post('peliculas/{pelicula}/turnos', [PeliculaTurnoController::class, 'assign']);
});
