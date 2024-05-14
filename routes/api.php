<?php

use App\Http\Controllers\Api\V1\Auth\AuthController;
use App\Http\Controllers\Api\V1\Craft\CraftController;
use App\Http\Controllers\Api\V1\Craftman\CraftmanController;
use App\Http\Controllers\Api\V1\User\UserController;
use App\Http\Controllers\ordersController ;
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

    // orders routing
    Route::post('newOrder' , [ordersController::class , "store"])->name("newOrder");

   //crafts routing
//    Route::get("index" , [CraftController::class , 'index']);
Route::prefix('crafts')->group(function(){
    Route::get("index" , [CraftController::class , 'index'])->name("craftIndex");
    Route::post("store" , [CraftController::class , 'store'])->name("craftStore");
    Route::post("update/{id}" , [CraftController::class , 'update'])->name("craftUpdate");
    Route::delete("destroy/{id}" , [CraftController::class , 'destroy'])->name("deletedCraft");
});

// craft man routings
Route::prefix("craftmen")->group(function(){
    Route::get("index" , [CraftmanController::class , 'index'])->name("getCraftMan");
    Route::post("store" , [CraftmanController::class, 'store'])->name("storeCraftMan");
    Route::post("update/{id}" , [CraftmanController::class, 'update'])->name("updateCraftMan");
    Route::delete("destroy/{id}" , [CraftmanController::class , 'destroy'])->name("deleteCraftman");
});
});
