<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ReportController;

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

//product
Route::post('/create-product', [ProductController::class, 'store']);
Route::get('/get-product/{id}', [ProductController::class, 'show']);
Route::post('/update-product-image/{id}', [ProductController::class, 'updateProductImage']);
Route::post('/update-product/{id}', [ProductController::class, 'update']);
Route::post('/delete-product/{id}', [ProductController::class, 'destroy']);

//manage order
Route::get('/get-order/{id}', [OrderController::class, 'show']);
Route::post('/update-order/{id}', [OrderController::class, 'update']);
Route::post('/delete-order/{id}', [OrderController::class, 'destroy']);

//report
Route::post('/report', [ReportController::class, 'generateReport']);
Route::post('/generate-report', [ReportController::class, 'generateReport']);










