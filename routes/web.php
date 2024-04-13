<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\UserController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect('/login');
});
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login')->middleware('redirectIfAuthenticated');
Route::post('/login',[AuthController::class, 'login']);
Route::get('/register', [AuthController::class,'showRegisterForm'])->name('register')->middleware('redirectIfAuthenticated');
Route::post('/register',[AuthController::class, 'register']);
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
Route::middleware('auth')->group(function () {
    Route::get('/home', function () {
        return view('home');
    }); //DEBUG purpose only
    Route::get('/brand', [BrandController::class, 'index'])->name('brand');
    Route::get('/categories', [CategoryController::class, 'index'])->name('categories');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/orders', [OrderController::class, 'index'])->name('order');
    Route::get('/product', [ProductController::class, 'index'])->name('product');
    Route::get('/report', [ReportController::class, 'index'])->name('report');
    Route::get('/setting', [SettingController::class, 'index'])->name('setting');
    Route::get('/user', [UserController::class, 'index'])->name('user');
});






