<?php

use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\ProyectoController;
use App\Http\Controllers\TareaController;

Route::post('/register', [UsuarioController::class, 'register']);
Route::post('/login', [UsuarioController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('proyectos', ProyectoController::class);
    Route::apiResource('tareas', TareaController::class);
    Route::get('/usuarios', [UsuarioController::class, 'index']); // <-- aquí protegido
});