<?php

use App\Http\Controllers\Api\v1\AppSettingController;
use Illuminate\Support\Facades\Route;

Route::group([
    'middleware' => 'jwt.verify',
    'prefix' => 'setting'
], function () {
    Route::get('/all', [AppSettingController::class, 'getSetting']);
    Route::post('/store', [AppSettingController::class, 'storeSetting']);
});
Route::group([
    // 'middleware' => 'jwt.verify',
    'prefix' => 'public'
], function () {
    Route::get('/info', [AppSettingController::class, 'getSetting']);
    // Route::post('/store', [AppSettingController::class, 'storeSetting']);
});
