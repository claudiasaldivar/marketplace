<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CartController;

// Rutas públicas
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Rutas protegidas
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    // Productos
    Route::apiResource('products', ProductController::class);
    Route::get('/sellers', [ProductController::class, 'getSellers']);

    // Búsqueda
    Route::get('/search', function (Request $request) {
        $query = \App\Models\Product::query();

        if ($request->has('name')) {
            $query->where('name', 'like', '%'.$request->name.'%');
        }

        if ($request->has('sku')) {
            $query->where('sku', $request->sku);
        }

        if ($request->has('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }

        if ($request->has('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        return $query->get();
    });

    // Carrito
    Route::prefix('cart')->group(function () {
        Route::get('/', [CartController::class, 'show']);
        Route::post('/items', [CartController::class, 'addItem']);
        Route::put('/items/{item}', [CartController::class, 'updateItem']);
        Route::delete('/items/{item}', [CartController::class, 'removeItem']);
    });

    // Admin
    Route::prefix('admin')->group(function () {
        Route::get('/products', [AdminController::class, 'index']);
    });
});

// Ruta dashboard que estaba causando el 404
Route::middleware('auth:sanctum')->get('/login', function () {
    return response()->json(['message' => 'Dashboard data']);
});