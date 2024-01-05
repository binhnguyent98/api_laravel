<?php

use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\Post\PostController;
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

Route::group(['prefix' => '/posts', 'middleware' => 'auth:api'], function () {
    Route::get('/', [PostController::class, 'fetch']);
    Route::post('/create', [PostController::class, 'create']);
    Route::delete('/delete/{id}', [PostController::class, 'delete']);
});

Route::group(['prefix' => '/auth'], function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/verify', [AuthController::class, 'verify']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/renewToken/{refreshToken}', [AuthController::class, 'renewToken']);
    Route::post('/test', [AuthController::class, 'test']);
});
