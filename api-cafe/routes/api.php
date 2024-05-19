<?php

use App\Http\Controllers\API\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\UserController;
use App\Http\Controllers\API\WorkshiftController;

Route::controller(AuthController::class)->group(function () {
    Route::post('login', 'login');
    Route::get('logout', 'logout')->middleware('auth:sanctum');
});

Route::resource('user', UserController::class)->middleware('auth:sanctum')->only(['index', 'store']);
Route::resource('work-shift', WorkshiftController::class)->middleware('auth:sanctum')->only(['index', 'store']);
