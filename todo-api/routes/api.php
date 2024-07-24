<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\TodoContoller;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::apiResource('users', UserController::class)->only('show', 'store');

Route::post('login', LoginController::class)->name('login');

Route::group(['middleware' => 'auth:sanctum'], function () {

    Route::apiResource('todos', TodoContoller::class);

    Route::post('logout', LogoutController::class)->name('logout');

});
