<?php

use App\Http\Controllers\Api\V1\Auth\AuthController;
use App\Http\Controllers\Api\V1\User\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


Route::group([
    'middleware' => 'api',
    'prefix' => 'v1'
] , function($router){
    Route::post('register' , [AuthController::class , 'register']);
    Route::post('login' , [AuthController::class , 'login']);
});
Route::group([
    'middleware' => ['api' ,'JWTMiddleware'],
    'prefix' => 'v1'
], function ($router) {
    Route::post('logout' , [AuthController::class , 'logout']);
    Route::post('refresh' , [AuthController::class , 'refresh']);
    Route::post('me' , [AuthController::class , 'me']);

    Route::apiResource('user' , UserController::class);
});
