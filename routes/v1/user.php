<?php

use App\Http\Controllers\Api\v1\UserController;
use Illuminate\Support\Facades\Route;


Route::group([
    'middleware' => 'jwt.verify',
    'prefix' => 'user'
], function () {
    Route::get('/all', [UserController::class, 'index']);
    Route::post('/store', [UserController::class, 'store']);
    Route::post('/upload', [UserController::class, 'uploadImage']);
});
