<?php

use App\Http\Controllers\Api\v1\KirimEmailController;
use Illuminate\Support\Facades\Route;


Route::group([
    // 'middleware' => 'jwt.verify',
    'prefix' => 'public'
], function () {
    Route::get('/notif', [KirimEmailController::class, 'notifEmail']);
});
