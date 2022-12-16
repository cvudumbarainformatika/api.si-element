<?php

use App\Http\Controllers\Api\v1\ProvesiController;
use Illuminate\Support\Facades\Route;

Route::group([
    'middleware' => 'jwt.verify',
    'prefix' => 'provesi'
], function () {
    Route::get('/all', [ProvesiController::class, 'index']);
    Route::get('/data', [ProvesiController::class, 'master']);
    Route::post('/store', [ProvesiController::class, 'store']);
    Route::post('/destroy', [ProvesiController::class, 'destroy']);
});
