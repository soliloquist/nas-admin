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

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});
Route::get('/getHome', \App\Http\Controllers\API\HomeController::class);
Route::post('/sendContact', \App\Http\Controllers\API\ContactController::class);
Route::get('/getOurVision', \App\Http\Controllers\API\GetOurVisionController::class);
Route::get('/getBusiness', [\App\Http\Controllers\API\OurBusinessController::class, 'index']);
Route::get('/getBusinessDetail', [\App\Http\Controllers\API\OurBusinessController::class, 'show']);
Route::get('/getＷork', [\App\Http\Controllers\API\OurWorkController::class, 'index']);
Route::get('/getＷorkDetail', [\App\Http\Controllers\API\OurWorkController::class, 'show']);
Route::get('/getUpdate', [\App\Http\Controllers\API\UpdateController::class, 'index']);
Route::get('/getUpdateDetail', [\App\Http\Controllers\API\UpdateController::class, 'show']);
