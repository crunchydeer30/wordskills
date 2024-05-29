<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\StationController;
use App\Http\Controllers\Api\TripController;
use Illuminate\Support\Facades\Route;

Route::controller(AuthController::class)->group(function () {
    Route::post('login', 'login');
    Route::post('register', 'register');
});

Route::prefix('station')->controller(StationController::class)->group(function () {
    Route::get('', 'index');
});

Route::prefix('trip')->controller(TripController::class)->group(function () {
    Route::get('', 'index');
});
