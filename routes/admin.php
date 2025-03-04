<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\PropertyController;

Route::prefix('admin')->group(function () {

    Route::get("user", [UserController::class,"index"])->name("index");
    Route::get("property", [PropertyController::class,"index"])->name("index");
    
});
