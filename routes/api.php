<?php

use App\Http\Controllers\Api\WishlistController;
use App\Http\Controllers\Api\CategoryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\WishlistProductController;
use App\Http\Controllers\Api\ReviewController;


Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

// Products

Route::get('/products', [ProductController::class, 'index']);

Route::post('/products', [ProductController::class, 'store']);

Route::get('/products/{id}', [ProductController::class, 'show']);

Route::patch('/products/{id}', [ProductController::class, 'update']);

Route::delete('/products/{id}', [ProductController::class, 'destroy']);

// Categories

Route::get('/categories', [CategoryController::class, 'index']);

Route::post('/categories', [CategoryController::class, 'store']);

Route::get('/categories/{id}', [CategoryController::class, 'show']);

Route::put('/categories/{id}', [CategoryController::class, 'update']);

Route::delete('/categories/{id}', [CategoryController::class, 'destroy']);

// Wishlists

Route::post('/wishlists', [WishlistController::class, 'store']);

Route::get('/wishlists/{id}', [WishlistController::class, 'show']);

Route::delete('/wishlists/{id}', [WishlistController::class, 'destroy']);

// WishlistProducts

Route::post('/wishlistproducts', [WishlistProductController::class, 'store']);

Route::get('/wishlistproducts/{id}', [WishlistProductController::class, 'show']);

Route::delete('/wishlistproducts/{id}', [WishlistProductController::class, 'destroy']);

// Reviews

Route::get('/reviews', [ReviewController::class, 'index']);

Route::post('/reviews', [ReviewController::class, 'store']);

Route::get('/reviews/{id}', [ReviewController::class, 'show']);

Route::patch('/reviews/{id}', [ReviewController::class, 'update']);

Route::delete('/reviews/{id}', [ReviewController::class, 'destroy']);