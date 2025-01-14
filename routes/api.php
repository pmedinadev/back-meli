<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\FavoriteController;
use App\Http\Controllers\Api\FavoriteProductController;
use App\Http\Controllers\Api\ReviewController;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\CartProductController;
use App\Http\Controllers\Api\ProductPhotoController;
use App\Http\Controllers\Api\UserAddressController;
use App\Http\Controllers\Auth\TokenController;

// Emisión de tokens para la aplicación móvil
Route::post('/register', [TokenController::class, 'register']);
Route::post('/login', [TokenController::class, 'login']);

// Rutas protegidas
Route::middleware('auth:sanctum')->group(function () {
    // Obtener usuario autenticado
    Route::get('/user', function (Request $request) {
        return $request->user()->makeHidden('cart');
    });

    // Ruta de cierre de sesión para la aplicación móvil
    Route::post('/logout', [TokenController::class, 'logout']);

    // Ruta para actualizar el perfil del usuario
    Route::patch('/profile', [ProfileController::class, 'update']);

    // Rutas protegidas para productos
    Route::post('/products', [ProductController::class, 'store']);
    Route::patch('/products/{id}', [ProductController::class, 'update']);
    Route::delete('/products/{id}', [ProductController::class, 'destroy']);

    // Rutas protegidas para fotos de productos
    Route::post('/productphotos', [ProductPhotoController::class, 'store']);
    Route::delete('/productphotos/{id}', [ProductPhotoController::class, 'destroy']);

    // Rutas protegidas para direcciones de usuarios
    Route::apiResource('addresses', UserAddressController::class);
});

// Rutas públicas para productos
Route::get('/products/search', [ProductController::class, 'search']);
Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/{id}', [ProductController::class, 'show']);

// Categorías
Route::get('/categories', [CategoryController::class, 'index']);
Route::post('/categories', [CategoryController::class, 'store']);
Route::get('/categories/{id}', [CategoryController::class, 'show']);
Route::get('/categories/slug/{slug}', [CategoryController::class, 'showBySlug']);
Route::put('/categories/{id}', [CategoryController::class, 'update']);
Route::delete('/categories/{id}', [CategoryController::class, 'destroy']);

// Listas de favoritos
Route::post('/favorites', [FavoriteController::class, 'create']);
Route::post('/favorites', [FavoriteController::class, 'store']);
Route::get('/favorites/{id}', [FavoriteController::class, 'show']);
Route::delete('/favorites/{id}', [FavoriteController::class, 'destroy']);

// Relación entre listas de favoritos y productos
Route::post('/favoriteproducts', [FavoriteProductController::class, 'store']);
Route::get('/favoriteproducts/{id}', [FavoriteProductController::class, 'show']);
Route::delete('/favoriteproducts/{id}', [FavoriteProductController::class, 'destroy']);

// Opiniones
Route::get('/reviews', [ReviewController::class, 'index']);
Route::post('/reviews', [ReviewController::class, 'store']);
Route::get('/reviews/{id}', [ReviewController::class, 'show']);
Route::patch('/reviews/{id}', [ReviewController::class, 'update']);
Route::delete('/reviews/{id}', [ReviewController::class, 'destroy']);

// Carrito de compras
Route::post('/carts', [CartController::class, 'store']);
Route::get('/carts/{id}', [CartController::class, 'show']);

// Relación entre carritos de compras y productos
Route::post('/cartproducts', [CartProductController::class, 'store']);
Route::get('/cartproducts/{id}', [CartProductController::class, 'show']);
Route::patch('/cartproducts/{id}', [CartProductController::class, 'update']);
Route::delete('/cartproducts/{id}', [CartProductController::class, 'destroy']);
