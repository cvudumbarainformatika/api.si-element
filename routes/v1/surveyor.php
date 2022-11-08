<?php

use App\Http\Controllers\Api\v1\SurveyorController;
use Illuminate\Support\Facades\Route;

Route::group([
    'middleware' => 'jwt.verify',
], function () {
    Route::post('/surveyoredit/{id}', [SurveyorController::class, 'update']);
    Route::post('/updatefull/{id}', [SurveyorController::class, 'updateFull']);
    Route::post('/datasurveyor', [SurveyorController::class, 'index']);
});
Route::group([
    // 'middleware' => 'jwt.verify',
    'prefix' => 'public'
], function () {
    Route::post('/surveyoruser', [SurveyorController::class, 'Surveyoruser']);
    Route::get('/surveyorme/{id}', [SurveyorController::class, 'show']);
});
