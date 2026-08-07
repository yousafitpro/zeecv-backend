<?php

use App\Http\Controllers\paysight\PaysightController;
use App\Http\Controllers\PMM\Order\PMMOrderController;
use App\Http\Controllers\Stripe\StripeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;


Route::group([
    'prefix' => 'cron'
], function ($router) {
 Route::any('send-comebacks',[PMMOrderController::class,'sendComebacks']);
});
Route::get('queue-work', function (Request $request) {

    $queue='default';
    if($request->has('queue'))
    {
        $queue=$request->queue;
    }
    Artisan::call('queue:work --queue='.$queue.' --stop-when-empty', []);
    return response()->json(['message'=>'success']);
});
Route::group([

    'middleware' => 'api',
    'namespace' => 'App\Http\Controllers',
    'prefix' => 'auth'

], function ($router) {

    Route::any('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('register', 'AuthController@register');
    Route::post('refresh', 'AuthController@refresh');
    Route::get('me', 'AuthController@me');

});
Route::group([
    'prefix' => 'telegram'
], function ($router) {
 Route::any('webhook',[App\Http\Controllers\PMM\Connect\CONTelegramController::class,'webhook']);
});
Route::group([
    'prefix' => 'payments/stripe'
], function ($router) {
 Route::any('webhook',[StripeController::class,'webhook']);

 Route::any('webhook2',[StripeController::class,'webhook']);
});
Route::group([
    'prefix' => 'payments/paysight'
], function ($router) {
 Route::any('webhook',[PaysightController::class,'webhook']);
});
