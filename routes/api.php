<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CatalogController;
use App\Http\Controllers\Api\OrderController;

// Public
Route::get('/categories/{slug}', [CatalogController::class, 'categoryShow']);
Route::get('/catalog', [CatalogController::class, 'index']);
Route::get('/catalog/categories', [CatalogController::class, 'categories']);
Route::get('/catalog/collections', [CatalogController::class, 'collections']);
Route::get('/catalog/{slug}', [CatalogController::class, 'show']);

Route::post('/orders', [OrderController::class, 'store']);

// Admin (Sanctum) — добавим на следующем шаге
// Route::middleware('auth:sanctum')->prefix('admin')->group(function () { ... });

// Маршрут для получения активного главного видео
Route::get("/hero-video", function () {
    return response()->json(\App\Models\HeroVideo::where("is_active", true)->latest()->first());
});
