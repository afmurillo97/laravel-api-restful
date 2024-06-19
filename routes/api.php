<?php

use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\v1\PostController as PostV1;
use App\Http\Controllers\Api\v2\PostController as PostV2;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

Route::post('login', [
    LoginController::class, 
    'login'
]);

Route::prefix('v1')->group(function () {
    // Posts Routes
    Route::prefix('posts')->group(function () {
        // Public Routes V1
        Route::get('/', [PostV1::class, 'index']);
        Route::get('/{post}', [PostV1::class, 'show']);

        // Protected Routes V1
        Route::middleware('auth:sanctum')->group(function () {
            Route::post('/', [PostV1::class, 'store']);
            Route::put('/{post}', [PostV1::class, 'update']);
            Route::delete('/{post}', [PostV1::class, 'destroy']);
        });
    });
});

Route::prefix('v2')->group(function () {
    // Posts Routes
    Route::prefix('posts')->group(function () {
        // Public Routes V2
        Route::get('/', [PostV2::class, 'index']);
        Route::get('/{post}', [PostV2::class, 'show']);

        // Protected Routes V2
        Route::middleware('auth:sanctum')->group(function () {
            Route::post('/', [PostV2::class, 'store']);
            Route::put('/{post}', [PostV2::class, 'update']);
            Route::delete('/{post}', [PostV2::class, 'destroy']);
        });
    });
});