<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TodoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/login', [AuthController::class, 'login']);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::prefix('todo')->group(function () {
        Route::get('/list', [TodoController::class, 'list']);
        Route::post('/store', [TodoController::class, 'store']);
        Route::put('/update/{id}', [TodoController::class, 'update']);
        Route::delete('/delete/{id}', [TodoController::class, 'delete']);
    });
});