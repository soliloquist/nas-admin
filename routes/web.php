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

Route::middleware(['auth:sanctum', 'verified'])->get('/', [\App\Http\Controllers\HomeController::class, 'index'])->name('dashboard');

Route::get('/home', [\App\Http\Controllers\HomeController::class, 'index'])->name('home')->middleware('auth:sanctum');
Route::get('/home/banner-md', [\App\Http\Controllers\HomeController::class, 'bannerMd'])->name('home.edit.banner-md')->middleware('auth:sanctum');
Route::get('/home/banner-xs', [\App\Http\Controllers\HomeController::class, 'bannerXs'])->name('home.edit.banner-xs')->middleware('auth:sanctum');
Route::get('/home/banner-video', [\App\Http\Controllers\HomeController::class, 'bannerVideo'])->name('home.edit.banner-video')->middleware('auth:sanctum');
Route::get('/home/banner-video-cover', [\App\Http\Controllers\HomeController::class, 'bannerVideoCover'])->name('home.edit.banner-video-cover')->middleware('auth:sanctum');
Route::get('/home/doc-download', [\App\Http\Controllers\HomeController::class, 'docDownload'])->name('home.edit.doc-download')->middleware('auth:sanctum');
Route::get('/vision', [\App\Http\Controllers\VisionController::class, 'index'])->name('vision.index')->middleware('auth:sanctum');
Route::get('/vision/intro-en', [\App\Http\Controllers\VisionController::class, 'introEn'])->name('vision.intro-en')->middleware('auth:sanctum');
Route::get('/vision/intro-cn', [\App\Http\Controllers\VisionController::class, 'introCn'])->name('vision.intro-cn')->middleware('auth:sanctum');
Route::get('/vision/intro-jp', [\App\Http\Controllers\VisionController::class, 'introJp'])->name('vision.intro-jp')->middleware('auth:sanctum');
Route::get('/vision/video', [\App\Http\Controllers\VisionController::class, 'video'])->name('vision.video')->middleware('auth:sanctum');
Route::get('/vision/video-cover', [\App\Http\Controllers\VisionController::class, 'videoCover'])->name('vision.video-cover')->middleware('auth:sanctum');
Route::resource('/contacts', \App\Http\Controllers\ContactController::class)->middleware('auth:sanctum');
Route::resource('/contact-types', \App\Http\Controllers\ContactTypeController::class)->middleware('auth:sanctum');
Route::resource('/teams', \App\Http\Controllers\TeamController::class)->middleware('auth:sanctum');
Route::resource('/members', \App\Http\Controllers\MemberController::class)->middleware('auth:sanctum');
Route::resource('/clients', \App\Http\Controllers\ClientController::class)->middleware('auth:sanctum');
Route::resource('/businesses', \App\Http\Controllers\BusinessController::class)->middleware('auth:sanctum');
Route::resource('/works', \App\Http\Controllers\WorkController::class)->middleware('auth:sanctum');
Route::resource('/updates', \App\Http\Controllers\UpdateController::class)->middleware('auth:sanctum');
Route::resource('/users', \App\Http\Controllers\UserController::class)->middleware('auth:sanctum');
Route::resource('/specialties', \App\Http\Controllers\SpecialtyController::class)->middleware('auth:sanctum');
