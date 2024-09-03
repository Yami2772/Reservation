<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\TimingController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use PHPUnit\Runner\ClassCannotBeFoundException;

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
Route::post('getservice', [TimingController::class,'getservice'])->name('getservice');
//auth
Route::prefix('auth')->middleware('auth:sanctum')->group(function () {
    //register
    Route::post('register', [AuthController::class, 'register'])->name('register')
        ->withoutMiddleware('auth:sanctum');
    //login
    Route::post('login', [AuthController::class, 'login'])->name('login')
        ->withoutMiddleware('auth:sanctum');
    //logout
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
    //me
    Route::get('me', [AuthController::class, 'me'])->name('me');
    //logout
    Route::post('logout/{id}',[AuthController::class,'logout'])->name('logout');
});

//users
Route::prefix('users')->middleware('auth:sanctum')->group(function () {
    //user's_list
    Route::get('read/{id?}', [UserController::class, 'read'])->name('read');
    //user's_edit
    Route::put('edit/{id}', [UserController::class, 'edit'])->name('edit');
    //user's_delete
    Route::delete('delete/{id}', [UserController::class, 'delete'])->name('delete');
});

//services
Route::prefix('services')->middleware('auth:sanctum')->group(function () {
    //service's_create
    Route::post('create', [ServiceController::class, 'create'])->name('create');
    //service's_read
    Route::get('index/{id?}', [ServiceController::class, 'read'])->name('read');
    //service's_update
    Route::put('update/{id}', [ServiceController::class, 'update'])->name('update');
    //service's_delete
    Route::delete('delete/{id}', [ServiceController::class, 'delete'])->name('delete');
});

//reservations
Route::prefix('reservations')->middleware('auth:sanctum')->group(function () {
    //reservation's_create
    Route::post('create', [ReservationController::class, 'create'])->name('create');
    //reservation's_read
    Route::get('index/{id?}', [ReservationController::class, 'read'])->name('index');
    //reservation's_update
    Route::put('update/{id}', [ReservationController::class, 'update'])->name('update');
    //reservation's_delete
    Route::delete('delete/{id}', [ReservationController::class, 'delete'])->name('delete');
    //ckeck_reservation
    Route::post('check', [ReservationController::class, 'checkReservations'])->name('check')
        ->withoutMiddleware('auth:sanctum');
});

//timings
Route::prefix('timings')->middleware('auth:sanctum')->group(function () {
    //timing's_create
    Route::post('create', [TimingController::class, 'create'])->name('create_timing');
    //timing's_read
    Route::get('index', [TimingController::class, 'read'])->name('read_timing');
    //reservation's_update
    Route::put('update/{id}', [TimingController::class, 'update'])->name('update_timing');
});
//settings
Route::prefix('settings')->middleware('auth:sanctum')->group(function () {
    //setting's_create
    Route::post('create', [SettingController::class, 'create'])->name('create');
    //setting's_read
    Route::get('index/{id?}', [SettingController::class, 'read'])->name('read');
    //setting's_update
    Route::put('update', [SettingController::class, 'update'])->name('update');
    //setting's_delete
    Route::delete('delete', [SettingController::class, 'delete'])->name('delete');
});

//timing
Route::prefix('timings')->middleware('auth:sanctum')->group(function () {
    //timing's_create
    Route::post('create', [TimingController::class, 'create'])->name('create');
});

//page
Route::prefix('pages')->middleware('auth:sanctum')->group(function(){
    //page's_craete
    Route::post('create',[PagesController::class, 'create'])->name('create');
     //page's_read
     Route::get('index/{id?}', [PagesController::class, 'read'])->name('index');
     //page's_update
     Route::put('update/{id}', [PagesController::class, 'update'])->name('update');
     //page's_delete
     Route::delete('delete/{id}', [PagesController::class, 'delete'])->name('delete');
});