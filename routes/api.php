<?php


use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

use App\Http\Controllers\UserController;  
use App\Http\Controllers\PropertyController;  

Route::prefix('v1')->group(function () {

    Route::post('register', [UserController::class, 'register']);  
    Route::post('login', [UserController::class, 'login']); 
    Route::get('properties', [PropertyController::class, 'index']);
    Route::get('properties/{id}', [PropertyController::class, 'show']);  
});

Route::prefix('v1')->middleware('auth:sanctum')->group(function () {
    Route::post('logout', [UserController::class, 'logout']);
    Route::get('users', [UserController::class, 'index']);  
    Route::post('properties', [PropertyController::class, 'store']);  
});
 


require __DIR__ .'/admin.php';