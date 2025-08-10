<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\DrinkController;
use App\Http\Controllers\Api\OrderController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::get('/drinks', [DrinkController::class, 'list']);
Route::get('/drinks/{drink}', [DrinkController::class, 'show']);

Route::middleware('auth:sanctum')->group(function (){

    Route::prefix('orders')->group(function () {

        Route::post('/add-order', [OrderController::class, 'createOrder']);
        Route::get('/list-order', [OrderController::class, 'listOrder']);

        Route::get('/sales/drink-type', [OrderController::class, 'salesByDrinkType']);
        Route::get('/sales/size', [OrderController::class, 'salesBySize']);

    });

    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/profile', [AuthController::class, 'me']);
});

