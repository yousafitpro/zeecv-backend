<?php

use App\Http\Controllers\App\MobileAppController;
use App\Http\Controllers\AuthController;

Route::group([

    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {

    Route::post('login', [AuthController::class,'login']);
    Route::post('logout', [AuthController::class,'logout']);
    Route::post('register', [AuthController::class,'register']);
    Route::post('refresh', [AuthController::class,'refresh']);
    Route::post('me', [AuthController::class,'me']);

});
Route::group([
    'middleware' => 'auth:api',
    'prefix' => 'app'
], function ($router) {

    Route::post('generate-login-token', [MobileAppController::class,'generateLoginToken']);

});