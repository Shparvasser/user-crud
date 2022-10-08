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
Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::apiResource('users',\App\Http\Controllers\UserController::class);
    Route::get('logout', [\App\Http\Controllers\auth\AuthController::class, 'logout'])->name('logout');
});

Route::post('sign-in', [\App\Http\Controllers\auth\AuthController::class, 'login'])->name('sign-in');
Route::post('sign-up', [\App\Http\Controllers\auth\AuthController::class, 'register'])->name('sign-up');

