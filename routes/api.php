<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\BrandController;

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

// Route::post('/login', [LoginController::class,'login'])->middleware('auth');;
// Route::post('/register', [RegisterController::class,'register']);
//Route::post('/login', [AuthController::class, 'login']);
//Route::post('/register', [AuthController::class, 'register']);

Route::group([
    'middleware' => 'api',
], function ($router) {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::get('/user-profile', [AuthController::class, 'userProfile']);
});

Route::post('/create-categories', [CategoryController::class, 'store']);
Route::get('/get-categories/{id}', [CategoryController::class, 'show']);
Route::post('/edit-categories/{id}', [CategoryController::class, 'update']);
Route::delete('/delete-categories/{id}', [CategoryController::class, 'destroy']);

Route::post('/create-brands', [BrandController::class, 'store']);
Route::get('/get-brands/{id}', [BrandController::class, 'show']);
Route::post('/edit-brand/{id}', [BrandController::class, 'update']);
Route::delete('/delete-brands/{id}', [BrandController::class, 'destroy']);



