<?php

use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'v1'], function () {

    Route::group(['prefix' => 'auth'], function () {

        Route::post('register', [UserController::class, 'register']);

        Route::post('login', [UserController::class, 'login']);
    });

    Route::group(['prefix' => 'users'], function () {

        Route::get('/', [UserController::class, 'list']);
    });

    Route::group(['prefix' => 'products'], function () {

        Route::post('/', [ProductController::class, 'addProduct']);

        Route::get('/', [ProductController::class, 'list']);

        Route::delete('/{id}', [ProductController::class, 'delete']);

        Route::get('/{id}', [ProductController::class, 'getProduct']);

        Route::put('/{id}', [ProductController::class, 'updateProduct']);

        Route::get('search/{query}', [ProductController::class, 'search']);
    });
});
