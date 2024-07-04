<?php

use App\Http\Controllers\LogRController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
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
    Route::post('register', [LogRController::class, 'register'])->name('register');
    //login(normal)
    Route::post('login', [LogRController::class, 'logiN'])->name('login');
    //login(code_request)

    //login(code_confirm)
    
});

//users
Route::prefix('users')->middleware('auth:sanctum')->group(function () {
    //users_list
    Route::get('index', [UserController::class, 'index'])->name('index');
    //users_edit
    Route::put('edit', [UserController::class, 'edit'])->name('edit');
    //users_delete
    Route::delete('delete', [UserController::class, 'delete'])->name('delete');
});
