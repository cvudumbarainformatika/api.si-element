<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::group([
    // 'middleware' => 'api',
    // 'middleware' => 'jwt.verify',
    'prefix' => 'auth'
], function () {
    // Route::get('/profile', [AuthController::class, 'userProfile']);
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/register', [AuthController::class, 'register']);
    // Route::post('/logout', [AuthController::class, 'logout']);
    // Route::post('/refresh', [AuthController::class, 'refresh']);
});

Route::group([
    // 'middleware' => 'api',
    'middleware' => 'jwt.verify',
    'prefix' => 'auth'
], function () {
    Route::get('/profile', [AuthController::class, 'userProfile']);
    // Route::post('/login', [AuthController::class, 'login'])->name('login');
    // Route::post('/register', [AuthController::class, 'register']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
});
