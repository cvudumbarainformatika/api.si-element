<?php

use App\Http\Controllers\api\v1\AuthController;
use Illuminate\Support\Facades\Route;



Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:api')
->group(function () {
    Route::get('/me', [AuthController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);
});


