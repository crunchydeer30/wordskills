<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PhotosController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::controller(AuthController::class)->group(function () {
    Route::post('login', 'login');
    Route::post('register', 'register');
    Route::post('logout', 'logout')->middleware('auth:sanctum');
});

Route::resource('photos', PhotosController::class)->middleware('auth:sanctum');
