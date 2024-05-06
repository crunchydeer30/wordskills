<?php

use App\Http\Controllers\Api\AirportsController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\FlightsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::controller(AuthController::class)->group(function () {
    Route::post('login', 'login');
    Route::post('register', 'register');
});

Route::resource('airport', AirportsController::class)->only(['index']);

Route::resource('flight', FlightsController::class)->only(['index']);
