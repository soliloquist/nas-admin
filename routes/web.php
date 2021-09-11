<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Route::get('/', function () {
//    return view('welcome');
//});

Route::middleware(['auth:sanctum', 'verified'])->get('/', function () {
    return view('dashboard');
})->name('dashboard');

Route::resource('/contacts', \App\Http\Controllers\ContactController::class);
Route::resource('/visions', \App\Http\Controllers\VisionController::class);
Route::resource('/teams', \App\Http\Controllers\TeamController::class);
Route::resource('/members', \App\Http\Controllers\MemberController::class);
Route::resource('/clients', \App\Http\Controllers\ClientController::class);
Route::resource('/businesses', \App\Http\Controllers\BusinessController::class);
Route::resource('/works', \App\Http\Controllers\WorkController::class);
Route::resource('/updates', \App\Http\Controllers\UpdateController::class);
Route::resource('/users', \App\Http\Controllers\UserController::class);
