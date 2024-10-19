<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\WishlistController;
use App\Http\Controllers\Api\WishlistProductController;
use App\Http\Controllers\Api\ReviewController;
use App\Http\Controllers\Auth\TokenController;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\CartProductController;

// Token issuance route for mobile app
Route::post('/register', [TokenController::class, 'register']);
Route::post('/login', [TokenController::class, 'login']);

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    // Get the authenticated user
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    
    // Logout route for mobile app
    Route::post('/logout', [TokenController::class, 'logout']);

    // Profile
    Route::patch('/profile', [ProfileController::class, 'update']);
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

// Cart
Route::post('/carts', [CartController::class, 'store']);
Route::get('/carts/{id}', [CartController::class, 'show']);

// Cart Product
Route::post('/cartproducts', [CartProductController::class, 'store']);
Route::get('/cartproducts/{id}', [CartProductController::class, 'show']);
Route::patch('/cartproducts/{id}', [CartProductController::class, 'update']);
Route::delete('/cartproducts/{id}', [CartProductController::class, 'destroy']);
