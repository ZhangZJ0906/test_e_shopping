<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ChangeStatusController;
use App\Http\Controllers\ProFileController;


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

Route::get('/', [AuthController::class, 'showWelcome'])->name('home');

// 方案三：使用路由群組加中間件
Route::middleware(['guest'])->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.submit');
});
Route::middleware(['auth'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/profile', [ProFileController::class, 'showProfile'])->name('profile');
    // 後台路由用 prefix 群組
    Route::middleware(['role:admin,boss,engineer'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/', [AuthController::class, 'showBackend'])->name('dashboard');
        Route::get('/products', [ProductController::class, 'showProduct'])->name('products');
        Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
        Route::post('/products', [ProductController::class, 'store'])->name('products.store');
        Route::put('/products/{id}', [ProductController::class, 'updateProduct'])->name('products.update');
        Route::delete('/products/{id}', [ProductController::class, 'destroy'])->name('products.destroy');
        Route::get('/changeStatus', [ChangeStatusController::class, 'showChangeStatus'])->name('changeStatus');
        Route::put('/changeStatus/{id}', [ChangeStatusController::class, 'updateChangeStatus'])->name('changeStatus.update');

    });
});


