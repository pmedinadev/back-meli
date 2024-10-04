<?php

use App\Http\Controllers\Api\CategoryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/categories', [CategoryController::class, 'index']);

Route::post('/categories', [CategoryController::class, 'store']);

Route::get('/categories/{id}', [CategoryController::class, 'show']);

Route::put('/categories/{id}', [CategoryController::class, 'update']);

Route::delete('/categories/{id}', [CategoryController::class, 'destroy']);
