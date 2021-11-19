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
Route::any('/sendContact', \App\Http\Controllers\API\ContactController::class);
Route::get('/getOurVision', \App\Http\Controllers\API\GetOurVisionController::class);
Route::any('/getBusiness', [\App\Http\Controllers\API\OurBusinessController::class, 'index']);
Route::get('/getBusiness/{slug}', [\App\Http\Controllers\API\OurBusinessController::class, 'show']);
Route::any('/getWork', [\App\Http\Controllers\API\OurWorkController::class, 'index']);
Route::get('/getWork/{slug}', [\App\Http\Controllers\API\OurWorkController::class, 'show']);
Route::any('/getUpdate', [\App\Http\Controllers\API\UpdateController::class, 'index']);
Route::get('/getUpdate/{slug}', [\App\Http\Controllers\API\UpdateController::class, 'show']);

Route::any('/getOurBusiness', [\App\Http\Controllers\API\OurBusinessController::class, 'index2']);
