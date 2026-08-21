<?php

use App\Http\Controllers\App\MobileAppController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\GoogleAuthController;
use App\Http\Controllers\Job\JobsController;
use App\Http\Controllers\WebAuthController;

Route::group([
    'middleware' => 'mobile.app',
], function ($router) {
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

    Route::post("forgot-password",[WebAuthController::class,'reset_email_send']);
    Route::post("google/register",[GoogleAuthController::class,'appSignup']);
  


Route::group([
        'middleware' => 'auth:api',

    ], function ($router) {
  Route::post("jobs",[JobsController::class,'indexAjax']);
    });
});
