<?php

use App\Http\Controllers\api\v1\SurveyorController;
use Illuminate\Support\Facades\Route;



Route::middleware('auth:api')
->group(function () {
    Route::get('/surveyors', [SurveyorController::class, 'index']);
    Route::post('/surveyor/store', [SurveyorController::class, 'index']);
});


