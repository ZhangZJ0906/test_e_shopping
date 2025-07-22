<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ChangeStatusController;
use App\Http\Controllers\ProFileController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\FrontendController;


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

    Route::get('/', [AuthController::class, 'showWelcome'])->name('home'); // 首頁
    Route::get('/products/{id}', [FrontendController::class, 'showFrontendProduct'])->name('frontendProducts.show'); // 秀出單一產品


Route::middleware(['guest'])->group(function () {// 未登入

    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login'); // 登入表單
    Route::post('/login', [AuthController::class, 'login'])->name('login.submit'); // 登入API

    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register'); // 註冊表單
    Route::post('/register', [AuthController::class, 'register'])->name('register.submit'); // 註冊API

    Route::get('/forgot-password', [ForgotPasswordController::class, 'showForgotPasswordForm'])->name('forgot-password'); // 忘記密碼表單



});
Route::middleware(['auth'])->group(function () { //已登入
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout'); // 登出

    Route::get('/profile', [ProFileController::class, 'showProfile'])->name('profile'); // 個人資料
    Route::post('/profile/{id}', [ProFileController::class, 'updateProfile'])->name('profile.update'); // 更新個人資料
    Route::put('/profile/password/{id}', [ProFileController::class, 'editPassWordProfile'])->name('profile.editPassWord'); // 更新個人資料

    // 後台路由用 prefix 群組
    Route::middleware(['role:admin,boss,engineer'])->prefix('admin')->name('admin.')->group(function () { //登入且是admin,boss,engineer才能用
        Route::get('/', [AuthController::class, 'showBackend'])->name('dashboard'); //後台

        Route::get('/products', [ProductController::class, 'showProduct'])->name('products'); //全部產品 頁面
        Route::get('/products/create', [ProductController::class, 'create'])->name('products.create'); //新增產品 頁面
        Route::post('/products', [ProductController::class, 'store'])->name('products.store'); //新增產品
        Route::put('/products/{id}', [ProductController::class, 'updateProduct'])->name('products.update'); // 更新產品
        Route::delete('/products/{id}', [ProductController::class, 'destroy'])->name('products.destroy'); // 刪除產品

        Route::get('/changeStatus', [ChangeStatusController::class, 'showChangeStatus'])->name('changeStatus'); // 權限頁面
        Route::put('/changeStatus/{id}', [ChangeStatusController::class, 'updateChangeStatus'])->name('changeStatus.update'); // 更新權限

    });
});
