<?php

use App\Http\Controllers\Api\v1\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware('jwt.verify')->group(function () {
    Route::get('/user', [UserController::class, 'index']);
    Route::post('/user/{id}', [UserController::class, 'update']);
});
