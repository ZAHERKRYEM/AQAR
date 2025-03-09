<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\PropertyController;

    Route::prefix('admin')->middleware(['auth:sanctum', 'admin'])->group(function () {

    Route::apiResource('users', UserController::class);
    Route::apiResource('properties', PropertyController::class); 
       
});
