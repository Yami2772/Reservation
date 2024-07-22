<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\SettingController;
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
Route::prefix('users')->middleware('auth:sanctum')->group(function () {
    //user's_list
    Route::get('index/{id?}', [UserController::class, 'index'])->name('index');
    //user's_edit
    Route::put('edit/{id}', [UserController::class, 'edit'])->name('edit');
    //user's_delete
    Route::delete('delete/{id}', [UserController::class, 'delete'])->name('delete');
});

//services
Route::prefix('services')->group(function () {
    //service's_create
    Route::post('create', [ServiceController::class, 'create'])->name('create');
    //service's_read
    Route::get('index/{id?}', [ServiceController::class, 'read'])->name('index');
    //service's_update
    Route::put('update/{id}', [ServiceController::class, 'update'])->name('update');
    //service's_delete
    Route::delete('delete/{id}', [ServiceController::class, 'delete'])->name('delete');
});

//reservations
Route::prefix('reservations')->group(function () {
    //reservation's_create
    Route::post('create', [ReservationController::class, 'create'])->name('create');
    //reservation's_read
    Route::get('index/{id?}', [ReservationController::class, 'read'])->name('index');
    //reservation's_update
    Route::put('update/{id}', [ReservationController::class, 'update'])->name('update');
    //reservation's_delete
    Route::delete('delete', [ReservationController::class, 'delete'])->name('delete');
});

//settings
Route::prefix('settings')->group(function () {
    //setting's_create
    Route::post('create', [SettingController::class, 'create'])->name('create');
    //setting's_read
    Route::get('index', [SettingController::class, 'read'])->name('index');
    //setting's_update
    Route::put('update', [SettingController::class, 'update'])->name('update');
    //setting's_delete
    Route::delete('delete', [SettingController::class, 'delete'])->name('delete');
});
