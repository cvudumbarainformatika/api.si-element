<?php

use App\Http\Controllers\Api\v1\StatusKPController;
use Illuminate\Support\Facades\Route;

Route::group([
    'middleware' => 'jwt.verify',
    'prefix' => 'statusKp'
], function () {
    Route::get('/all', [StatusKPController::class, 'index']);
    Route::post('/store', [StatusKPController::class, 'store']);
    Route::post('/destroy', [StatusKPController::class, 'destroy']);
});
