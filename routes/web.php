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
    return view('banners.index');
})->name('dashboard');

Route::resource('/contacts', \App\Http\Controllers\ContactController::class)->middleware('auth:sanctum');
Route::resource('/teams', \App\Http\Controllers\TeamController::class)->middleware('auth:sanctum');
Route::resource('/members', \App\Http\Controllers\MemberController::class)->middleware('auth:sanctum');
Route::resource('/clients', \App\Http\Controllers\ClientController::class)->middleware('auth:sanctum');
Route::resource('/businesses', \App\Http\Controllers\BusinessController::class)->middleware('auth:sanctum');
Route::resource('/works', \App\Http\Controllers\WorkController::class)->middleware('auth:sanctum');
Route::resource('/updates', \App\Http\Controllers\UpdateController::class)->middleware('auth:sanctum');
Route::resource('/users', \App\Http\Controllers\UserController::class)->middleware('auth:sanctum');
Route::resource('/specialties', \App\Http\Controllers\SpecialtyController::class)->middleware('auth:sanctum');
