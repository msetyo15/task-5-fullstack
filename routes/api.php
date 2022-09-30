<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ArticleController;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::group(['prefix' => 'v1'], function(){
    //login route
    Route::post('/login', [AuthController::class, 'login']);

    // categories route
    Route::controller(CategoryController::class)->group(function() {
        Route::post('/category', 'index')->middleware('auth:api');
        Route::post('/category/create', 'create')->middleware('auth:api');
        Route::post('/category/detail', 'detail')->middleware('auth:api');
        Route::post('/category/update', 'update')->middleware('auth:api');
        Route::post('/category/delete', 'delete')->middleware('auth:api');

    });

    // article route
    Route::controller(ArticleController::class)->group(function() {
        Route::post('/article', 'index')->middleware('auth:api');
        Route::post('/article/create', 'create')->middleware('auth:api');
        Route::post('/article/detail', 'detail')->middleware('auth:api');
        Route::post('/article/update', 'update')->middleware('auth:api');
        Route::post('/article/delete', 'delete')->middleware('auth:api');

    });
});
