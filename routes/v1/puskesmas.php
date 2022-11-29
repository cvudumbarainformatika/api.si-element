<?php

use App\Http\Controllers\Api\v1\PuskesmasController;
use Illuminate\Support\Facades\Route;

Route::group([
    'middleware' => 'jwt.verify',
    'prefix' => 'puskesmas'
], function () {
    Route::get('/all', [PuskesmasController::class, 'index']);
    Route::post('/puskesmasedit/{id}', [PuskesmasController::class, 'update']);
    Route::post('/updatefull/{id}', [PuskesmasController::class, 'updateFull']);
    Route::get('/puskesmasme/{id}', [PuskesmasController::class, 'show']);
    Route::post('/destroy', [PuskesmasController::class, 'destroy']);
});
Route::group([
    // 'middleware' => 'jwt.verify',
    'prefix' => 'public'
], function () {
    Route::post('/puskesmasuser', [PuskesmasController::class, 'puskesmasUser']);
});
