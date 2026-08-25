<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CatalogController;
use App\Http\Controllers\Api\OrderController;

// Public
Route::get('/catalog', [CatalogController::class, 'index']);
Route::get('/catalog/categories', [CatalogController::class, 'categories']);
Route::get('/catalog/collections', [CatalogController::class, 'collections']);
Route::get('/catalog/{slug}', [CatalogController::class, 'show']);

Route::post('/orders', [OrderController::class, 'store']);

// Admin (Sanctum) — добавим на следующем шаге
// Route::middleware('auth:sanctum')->prefix('admin')->group(function () { ... });
