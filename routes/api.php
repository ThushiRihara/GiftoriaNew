<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\Api\AuthApiController;
use App\Http\Controllers\API\AddOnController;
use App\Http\Controllers\API\GiftController;
use App\Http\Controllers\API\CategoryController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// customer token login
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

// admin token login
Route::post('/admin/login', [AdminAuthController::class, 'login']);
Route::post('/admin/logout', [AdminAuthController::class, 'logout'])->middleware('auth:sanctum');


// Protected routes
Route::middleware('auth:sanctum')->group(function() {
    Route::get('/addons', [AddOnController::class, 'index']);
    Route::post('/addons', [AddOnController::class, 'store']);
    Route::put('/addons/{id}', [AddOnController::class, 'update']);
    Route::delete('/addons/{id}', [AddOnController::class, 'destroy']);
});

// Gifts CRUD (protected)
Route::middleware('auth:sanctum')->group(function() {
    Route::get('/gifts', [GiftController::class, 'index']);
    Route::post('/gifts', [GiftController::class, 'store']);
    Route::put('/gifts/{id}', [GiftController::class, 'update']); // if you prefer PUT: you can use ->put
    Route::delete('/gifts/{id}', [GiftController::class, 'destroy']);
    Route::middleware('auth:sanctum')->get('/gifts/form-data', [GiftController::class,'categoriesAndAddOns']);
});

Route::middleware('auth:sanctum')->prefix('admin')->group(function () {
    Route::get('/customers', [App\Http\Controllers\Admin\CustomerController::class, 'getCustomers']);
});
