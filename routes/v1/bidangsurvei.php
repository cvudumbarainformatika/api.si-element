<?php

use App\Http\Controllers\Api\v1\BidangSurveiController;
use Illuminate\Support\Facades\Route;

Route::group([
    'middleware' => 'jwt.verify',
    'prefix' => 'bidangsurvei'
], function () {
    Route::get('/all', [BidangSurveiController::class, 'index']);
    Route::get('/data', [BidangSurveiController::class, 'master']);
    Route::post('/store', [BidangSurveiController::class, 'store']);
    Route::post('/destroy', [BidangSurveiController::class, 'destroy']);
});
