<?php

use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\v1\PostController as PostV1;
use App\Http\Controllers\Api\v2\PostController as PostV2;
use Illuminate\Http\Request;
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


// Route::apiResource('v1/posts', PostV1::class)
//     ->only(['index', 'show', 'destroy'])
//     ->middleware('auth:sanctum');

// Public Routes V1
Route::get('v1/posts', [PostV1::class, 'index']);
Route::get('v1/posts/{post}', [PostV1::class, 'show']);

// Protected Routes V1
Route::middleware('auth:sanctum')->group(function () {
    Route::post('v1/posts', [PostV1::class, 'store']);
    Route::put('v1/posts/{post}', [PostV1::class, 'update']);
    Route::delete('v1/posts/{post}', [PostV1::class, 'destroy']);
});

Route::apiResource('v2/posts', PostV2::class)
    ->only(['index', 'show'])
    ->middleware('auth:sanctum');

Route::post('login', [
    LoginController::class, 
    'login'
]);