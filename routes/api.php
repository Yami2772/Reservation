<?php

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
Route::group(['prefix'=> 'user','as'=>'user.'] ,function(){
    Route::get('index/{id?}',[UserController::class,'index'])->name('index');
    Route::put('edit/{id}',[UserController::class,'edit'])->name('edit');
    Route::delete('delete/{id}',[UserController::class, 'delete'])->name('delete');
});

