<?php

use App\Http\Controllers\AuthController;
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
    //users_list
    Route::get('index/{id?}', [UserController::class, 'index'])->name('index');
    //users_edit
    Route::put('edit/{id}', [UserController::class, 'edit'])->name('edit');
    //users_delete
    Route::delete('delete/{id}', [UserController::class, 'delete'])->name('delete');
});
