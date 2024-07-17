<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\OrdersController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SetingeController;
use App\Http\Controllers\UserController;
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

//auth
Route::prefix('auth')->group(function () {
    //register
    Route::post('register', [AuthController::class, 'register'])->name('register');
    //login
    Route::post('login', [AuthController::class, 'login'])->name('login');
});

//users
Route::prefix('users')->group(function () {
    //users_list
    Route::get('index/{id?}', [UserController::class, 'index'])->name('index');
    //users_edit
    Route::put('edit/{id}', [UserController::class, 'edit'])->name('edit');
    //users_delete
    Route::delete('delete/{id}', [UserController::class, 'delete'])->name('delete');
});

//products
Route::prefix('products')->group(function () {
    //products_list
    Route::get('index/{id?}', [ProductController::class, 'index'])->name('index');
    //products_store
    Route::post('store',[ProductController::class, 'store'])->name('store');
    //products_edit
    Route::put('edit/{id}', [ProductController::class, 'edit'])->name('edit');
    //products_delete
    Route::delete('delete/{id}', [ProductController::class, 'delete'])->name('delete');
});

//setinges
Route::prefix('setinges')->group(function () {
    //setinges_list
    Route::get('index/{id?}', [SetingeController::class, 'index'])->name('index');
    //setinges_store
    Route::post('store',[SetingeController::class, 'store'])->name('store');
    //setinges_edit
    Route::put('edit/{id}', [SetingeController::class, 'edit'])->name('edit');
    //setinges_delete
    Route::delete('delete/{id}', [SetingeController::class, 'delete'])->name('delete');
});

//orders
Route::prefix('orders')->group(function () {
    //orders_list
    Route::get('index/{id?}', [OrdersController::class, 'index'])->name('index');
    //orders_store
    Route::post('store',[OrdersController::class, 'store'])->name('store');
    //orders_edit
    Route::put('edit/{id}', [OrdersController::class, 'edit'])->name('edit');
    //orders_delete
    Route::delete('delete/{id}', [OrdersController::class, 'delete'])->name('delete');
});