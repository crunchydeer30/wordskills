<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\FilesController;

Route::controller(AuthController::class)->group(function () {
    Route::post('login', 'login');
    Route::post('register', 'register');
    Route::post('logout', 'logout')->middleware('auth:sanctum');
});

Route::apiResource('files', FilesController::class)->middleware('auth:sanctum');

Route::prefix('files')->controller(FilesController::class)->middleware('auth:sanctum')->group(function () {
    Route::post('{file}/access', 'grantAccess');
    Route::delete('{file}/access', 'revokeAccess');
});
