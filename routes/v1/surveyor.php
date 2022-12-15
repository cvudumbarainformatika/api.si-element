<?php

use App\Http\Controllers\Api\v1\SurveyorController;
use Illuminate\Support\Facades\Route;

Route::group([
    'middleware' => 'jwt.verify',
    'prefix' => 'surveyor'
], function () {
    Route::get('/all', [SurveyorController::class, 'index']);
    Route::post('/surveyoredit/{id}', [SurveyorController::class, 'update']);
    Route::post('/updatefull/{id}', [SurveyorController::class, 'updateFull']);
    Route::get('/surveyorme/{id}', [SurveyorController::class, 'show']);
    Route::post('/destroy', [SurveyorController::class, 'destroy']);
    Route::post('/store', [SurveyorController::class, 'store']);
});
Route::group([
    // 'middleware' => 'jwt.verify',
    'prefix' => 'public'
], function () {
    Route::post('/surveyoruser', [SurveyorController::class, 'Surveyoruser']);
});
