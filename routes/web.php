<?php

use App\Http\Controllers\auth\LoginController;
use App\Http\Controllers\BuyNowController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LogOutController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\auth\RegisterController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

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
Route::get('/',[HomeController::class,'index'])->name('home');
Route::post('/',[HomeController::class,'indexWithCategory'])->name('home.category');
Route::get('/home',[HomeController::class,'index']);
Route::get('/home/detail/{product}',[HomeController::class,'detail'])->name('home.detail');

Route::get('/auth/login',[LoginController::class,'index'])->name('login');
Route::post('/auth/login',[LoginController::class,'check']);
Route::get('/auth/register',[RegisterController::class,'index'])->name('register');
Route::post('/auth/register',[RegisterController::class,'store']);
Route::post('/auth/logout',[LogOutController::class,'index'])->name('logout');

Route::get('/checkout',[CheckoutController::class,'index'])->name('checkout');
Route::prefix('/checkout')->group(function(){
    Route::post('/',[PaymentController::class,'store']);
});

Route::get('/buy/{product}',[BuyNowController::class,'index'])->name('buy');
Route::prefix('/but')->group(function(){
    Route::post('/{id}',[BuyNowController::class,'store']);
});

Route::get('/admin',[DashboardController::class,'index'])->name('dashboard');
Route::get('/admin/report',[ReportController::class,'index'])->name('report');
Route::get('/admin/transaction',[TransactionController::class,'index'])->name('transaction');

Route::get('/admin/category',[CategoryController::class,'index'])->name('category');
Route::prefix('/admin/category')->group(function(){
    Route::post('/',[CategoryController::class,'store']);
    Route::put('/update/{id}',[CategoryController::class,'update'])->name('category.update');
    Route::delete('/{id}',[CategoryController::class,'destroy'])->name('category.destroy');
});

Route::get('/admin/member',[MemberController::class,'index'])->name('member');
Route::prefix('/admin/member')->group(function(){
    Route::post('/{id}',[MemberController::class,'store']);
    Route::put('/{id}',[MemberController::class,'update']);
    Route::delete('/{id}',[MemberController::class,'destroy'])->name('member.destroy');
});

Route::prefix('/admin/product')->group(function(){
    Route::get('/',[ProductController::class,'index'])->name('product');
    Route::post('/',[ProductController::class,'store']);
    Route::delete('/{product}',[ProductController::class,'destroy'])->name('product.destroy');
    Route::put('/update/{product}',[ProductController::class,'update'])->name('product.update');
    Route::get('/detail/{product}',[ProductController::class,'index'])->name('product.detail');
});


Route::get('/user',[UserController::class,'index'])->name('user');
Route::prefix('/user')->group(function(){
    Route::post('/{id}',[UserController::class,'store']);
    Route::put('/{id}',[UserController::class,'update']);
    Route::delete('/{id}',[UserController::class,'destroy']);
});
