<?php

use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\v1\PostController as PostV1;
use App\Http\Controllers\Api\v2\PostController as PostV2;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('login', [
    LoginController::class, 
    'login'
]);

// Public Routes V1
Route::get('v1/posts', [PostV1::class, 'index']);
Route::get('v1/posts/{post}', [PostV1::class, 'show']);

// Protected Routes V1
Route::middleware('auth:sanctum')->group(function () {
    Route::post('v1/posts', [PostV1::class, 'store']);
    Route::put('v1/posts/{post}', [PostV1::class, 'update']);
    Route::delete('v1/posts/{post}', [PostV1::class, 'destroy']);
});

// Public Routes V2
Route::get('v2/posts', [PostV2::class, 'index']);
Route::get('v2/posts/{post}', [PostV2::class, 'show']);

// Protected Routes V2
Route::middleware('auth:sanctum')->group(function () {
    Route::post('v2/posts', [PostV2::class, 'store']);
    Route::put('v2/posts/{post}', [PostV2::class, 'update']);
    Route::delete('v2/posts/{post}', [PostV2::class, 'destroy']);
});