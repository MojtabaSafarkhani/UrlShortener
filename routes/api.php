<?php

use App\Http\Controllers\Api\LinksController;
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\ProfileController;
use App\Http\Controllers\Api\RegisterController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/register', [RegisterController::class, 'store']);
Route::post('/login', [LoginController::class, 'store']);

Route::middleware('auth:api')->group(function () {

    Route::delete('/logout', [LoginController::class, 'destroy']);
    Route::get('/links',[LinksController::class,'index']);
    Route::post('/links',[LinksController::class,'store']);
    Route::get('/{link}',[LinksController::class,'handle']);
    Route::delete('/links/{link}',[LinksController::class,'destroy']);
    Route::get('/profile/show',[ProfileController::class,'show']);


});


