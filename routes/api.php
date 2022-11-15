<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\StatisticController;
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
Route::prefix('auth/')->group(function(){
    Route::post('register', [RegisterController::class,'register']);
    Route::post('login', [LoginController::class,'login']);
});

Route::middleware('auth:sanctum')->group(function (){
    Route::prefix('statistics')->controller(StatisticController::class)->group(function (){
        Route::get('country/{country_code}','country');
        Route::get('countries','displayList');
    });
});


