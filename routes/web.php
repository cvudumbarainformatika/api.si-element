<?php

use App\Http\Controllers\Api\v1\KirimEmailController;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('/coba', function () {
    $data = User::find(163);
    // return new JsonResponse($data);
    $kirimEmail = ([
        'email' => $data->email,
        'id' =>  $data->id,
        'password' => '1231'
    ]);
    // $user = User::query()->where('id', '160')->get();

    $data = KirimEmailController::notifEmail($kirimEmail);
    return new JsonResponse($data);
});
