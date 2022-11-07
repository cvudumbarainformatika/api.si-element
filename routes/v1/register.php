<?php

use App\Http\Controllers\Api\v1\RegisterController;
use Illuminate\Support\Facades\Route;

Route::group([
    'middleware' => 'jwt.verify',
], function () {
    Route::post('/registeredit/{id}', [RegisterController::class, 'update']);
    Route::post('/updatefull/{id}', [RegisterController::class, 'updateFull']);
    Route::post('/dataregister', [RegisterController::class, 'index']);
});
Route::group([
    // 'middleware' => 'jwt.verify',
    'prefix' => 'public'
], function () {
    Route::post('/registeruser', [RegisterController::class, 'registeruser']);
    Route::get('/registerme/{id}', [RegisterController::class, 'show']);
});
