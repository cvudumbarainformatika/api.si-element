<?php

use App\Http\Controllers\Api\v1\BidangSurveiController;
use Illuminate\Support\Facades\Route;

Route::group([
    'middleware' => 'jwt.verify',
    'prefix' => 'master'
], function () {
    Route::get('/all', [BidangSurveiController::class, 'index']);
    Route::post('/update', [BidangSurveiController::class, 'update']);
    Route::post('/destroy', [BidangSurveiController::class, 'destroy']);
});