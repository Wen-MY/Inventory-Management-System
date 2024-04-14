<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\DashboardController;

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

Route::post('/changeUsername', [SettingController::class, 'changeUsername'])->name('changeUsername');
Route::post('/changePassword', [SettingController::class, 'changePassword'])->name('changePassword');


Route::post('/createUser', [UserController::class, 'store'])->name('createUser');
Route::get('/get-user/{id}', [UserController::class, 'show']);
Route::post('/update-user/{id}', [UserController::class, 'update']);
Route::post('/delete-user/{id}', [UserController::class, 'destroy']);
Route::get('/get-product', [ProductController::class, 'showAll']);
Route::post('/create-order', [OrderController::class, 'store']);

Route::post('/create-categories', [CategoryController::class, 'store']);
Route::get('/get-categories/{id}', [CategoryController::class, 'show']);
Route::post('/edit-categories/{id}', [CategoryController::class, 'update']);
Route::delete('/delete-categories/{id}', [CategoryController::class, 'destroy']);

Route::post('/create-brands', [BrandController::class, 'store']);
Route::get('/get-brands/{id}', [BrandController::class, 'show']);
Route::post('/edit-brand/{id}', [BrandController::class, 'update']);
Route::delete('/delete-brands/{id}', [BrandController::class, 'destroy']);
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


//dashboard
Route::get('/dashboard', [DashboardController::class, 'dashboardData']);