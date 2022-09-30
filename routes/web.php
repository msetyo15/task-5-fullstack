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

// Route::get('/', function () {
//     return view('welcome');
// });


Auth::routes();

Route::controller(App\Http\Controllers\HomeWebController::class)->group(function() {
    Route::get('/', 'index');
    Route::get('/home', 'index');
});

Route::controller(App\Http\Controllers\CategoryWebController::class)->group(function() {
    Route::get('/category', 'index')->middleware('auth:web');
    Route::post('/category/create', 'create')->middleware('auth:web');
    Route::get('/category/detail/{id}', 'detail')->middleware('auth:web');
    Route::post('/category/update', 'update')->middleware('auth:web');
    Route::get('/category/delete/{id}', 'delete')->middleware('auth:web');
});

Route::controller(App\Http\Controllers\ArticleWebController::class)->group(function() {
    Route::get('/article', 'index')->middleware('auth:web');
    Route::post('/article/create', 'create')->middleware('auth:web');
    Route::get('/article/detail/{id}', 'detail')->middleware('auth:web');
    Route::post('/article/update', 'update')->middleware('auth:web');
    Route::get('/article/delete/{id}', 'delete')->middleware('auth:web');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
