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
Route::get('/home/en-doc-download', [\App\Http\Controllers\HomeController::class, 'enDocDownload'])->name('home.edit.en-doc-download')->middleware('auth:sanctum');
Route::get('/home/cn-doc-download', [\App\Http\Controllers\HomeController::class, 'cnDocDownload'])->name('home.edit.cn-doc-download')->middleware('auth:sanctum');
Route::get('/home/jp-doc-download', [\App\Http\Controllers\HomeController::class, 'jpDocDownload'])->name('home.edit.jp-doc-download')->middleware('auth:sanctum');
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

Route::resource('/users', \App\Http\Controllers\UserController::class)->middleware('auth:sanctum');
Route::resource('/specialties', \App\Http\Controllers\SpecialtyController::class)->middleware('auth:sanctum');
Route::resource('/tags', \App\Http\Controllers\TagController::class)->middleware('auth:sanctum');


Route::get('/works', [\App\Http\Controllers\WorkController::class, 'index'])->name('works.index')->middleware('auth:sanctum');
Route::get('/works/create', [\App\Http\Controllers\WorkController::class, 'create'])->name('works.create')->middleware('auth:sanctum');
Route::get('/works/{groupId}/{languageId}/edit', [\App\Http\Controllers\WorkController::class, 'edit'])->name('works.edit')->middleware('auth:sanctum');
Route::delete('/works/{groupId}/delete', [\App\Http\Controllers\WorkController::class, 'destroy'])->name('works.delete')->middleware('auth:sanctum');

Route::get('/updates', [\App\Http\Controllers\UpdateController::class, 'index'])->name('updates.index')->middleware('auth:sanctum');
Route::get('/updates/create', [\App\Http\Controllers\UpdateController::class, 'create'])->name('updates.create')->middleware('auth:sanctum');
Route::get('/updates/{groupId}/{languageId}/edit', [\App\Http\Controllers\UpdateController::class, 'edit'])->name('updates.edit')->middleware('auth:sanctum');
Route::delete('/updates/{groupId}/delete', [\App\Http\Controllers\UpdateController::class, 'destroy'])->name('updates.delete')->middleware('auth:sanctum');

Route::get('/businesses', [\App\Http\Controllers\BusinessController::class, 'index'])->name('businesses.index')->middleware('auth:sanctum');
Route::get('/businesses/create', [\App\Http\Controllers\BusinessController::class, 'create'])->name('businesses.create')->middleware('auth:sanctum');
Route::get('/businesses/{groupId}/{languageId}/edit', [\App\Http\Controllers\BusinessController::class, 'edit'])->name('businesses.edit')->middleware('auth:sanctum');
Route::delete('/businesses/groupId}/delete', [\App\Http\Controllers\BusinessController::class, 'destroy'])->name('businesses.delete')->middleware('auth:sanctum');

Route::get('/foo', \App\Http\Controllers\Foo::class);
