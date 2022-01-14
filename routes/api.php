<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group([
    'prefix' => 'auth'
], function () {
    Route::post('login', [App\Http\Controllers\AuthController::class, 'login']);
    Route::post('registration', [App\Http\Controllers\AuthController::class, 'registration']);
    Route::post('me', [App\Http\Controllers\AuthController::class, 'me']);
});


Route::prefix('cbrf')->group(function () {
    Route::post('rate', [App\Http\Controllers\CbrfController::class, 'rate']);
});
