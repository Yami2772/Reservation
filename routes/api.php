<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\TimingController;
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
Route::prefix('auth')->middleware(['auth:sanctum', 'check.ban'])->group(function () {
    //register
    Route::post('register', [AuthController::class, 'register'])->name('register')
        ->withoutMiddleware(['auth:sanctum', 'check.ban']);
    //login
    Route::post('login', [AuthController::class, 'login'])->name('login')
        ->withoutMiddleware(['auth:sanctum', 'check.ban']);
    //logout
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
    //me
    Route::get('me', [AuthController::class, 'me'])->name('me');
});

//users
Route::prefix('users')->middleware(['auth:sanctum', 'check.ban'])->group(function () {
    //user's_list
    Route::get('index/{id?}', [UserController::class, 'index'])->name('user_index');
    //user's_edit
    Route::put('edit/{id}', [UserController::class, 'edit'])->name('user_edit');
    //user's_delete
    Route::delete('delete', [UserController::class, 'delete'])->name('user_delete');
    //club_membership
    Route::post('activating_club_membership', [UserController::class, 'activatingClubMembership'])
        ->name('activating_club_membership');
});

//services
Route::prefix('services')->middleware(['auth:sanctum', 'check.ban'])->group(function () {
    //service's_create
    Route::post('create', [ServiceController::class, 'create'])->name('service_create');
    //service's_read
    Route::get('index/{id?}', [ServiceController::class, 'read'])->name('service_read')
        ->withoutMiddleware(['auth:sanctum', 'check.ban']);
    //service's_update
    Route::put('update/{id}', [ServiceController::class, 'update'])->name('service_update');
    //service's_delete
    Route::delete('delete', [ServiceController::class, 'delete'])->name('service_delete');
});

//reservations
Route::prefix('reservations')->middleware(['auth:sanctum', 'check.ban'])->group(function () {
    //reservation's_create
    Route::post('create', [ReservationController::class, 'create'])->name('reservation_create');
    //reservation's_read
    Route::get('index/{id?}', [ReservationController::class, 'read'])->name('reservation_read');
    //reservation's_update
    Route::put('update/{id}', [ReservationController::class, 'update'])->name('reservation_update');
    //reservation's_delete
    Route::delete('delete', [ReservationController::class, 'delete'])->name('reservation_delete');
    //reservation_canceling
    Route::delete('canceling', [ReservationController::class, 'reservationCancel'])->name('canceling_reservation');
    //ckeck_reservation
    Route::post('check_reservations_of_week', [ReservationController::class, 'checkReservationsOfWeek'])
        ->name('check_reservations_of_week')->withoutMiddleware(['auth:sanctum', 'check.ban']);
    Route::post('check_reservations_of_month', [ReservationController::class, 'checkReservationOfMonth'])
        ->name('check_reservations_of_month')->withoutMiddleware(['auth:sanctum', 'check.ban']);
});

//timings
Route::prefix('timings')->middleware(['auth:sanctum', 'check.ban'])->group(function () {
    //timing's_create
    Route::post('create', [TimingController::class, 'create'])->name('timing_create');
    //timing's_read
    Route::get('index', [TimingController::class, 'read'])->name('timing_read');
    //reservation's_update
    Route::put('update/{id}', [TimingController::class, 'update'])->name('timing_timing');
});

//settings
Route::prefix('settings')->middleware(['auth:sanctum', 'check.ban'])->group(function () {
    //setting's_create
    Route::post('create', [SettingController::class, 'create'])->name('setting_create');
    //setting's_read
    Route::get('index/{key?}', [SettingController::class, 'read'])->name('setting_read');
    //setting's_update
    Route::put('update/{key}', [SettingController::class, 'update'])->name('setting_update');
    //setting's_delete
    Route::delete('delete/{key}', [SettingController::class, 'delete'])->name('setting_delete');
});

//comments
Route::prefix('comments')->middleware(['auth:sanctum', 'check.ban'])->group(function () {
    //comment's_create
    Route::post('create', [CommentController::class, 'create'])->name('comment_create');
    //comment's_read
    Route::get('read/{service_id?}', [CommentController::class, 'read'])->name('comment_read')
        ->withoutMiddleware(['auth:sanctum', 'check.ban']);
    //comment's_delete
    Route::delete('delete', [CommentController::class, 'delete'])->name('comment_delete');
    //comment's_approval
    Route::post('approval', [CommentController::class, 'CommentApproval'])->name('comment_approval');
    //comment's_declining
    Route::post('declining', [CommentController::class, 'CommentDeclining'])->name('comment_declining');
});

//pages
Route::prefix('pages')->middleware(['auth:sanctum', 'check.ban'])->group(function () {
    //page's_create
    Route::post('create', [PageController::class, 'create'])->name('page_create');
    //page's_read
    Route::get('index/{id?}', [PageController::class, 'read'])->name('page_read');
    //page's_update
    Route::put('update/{id}', [PageController::class, 'update'])->name('page_update');
    //page's_delete
    Route::delete('delete/{id}', [PageController::class, 'delete'])->name('page_delete');
});

//media
Route::prefix('media')->middleware(['auth:sanctum', 'check.ban'])->group(function () {
    //avatar_upload
    Route::post('avatar_upload', [MediaController::class, 'avatarUpload'])->name('avatar_upload');
    //service_image_upload
    Route::post('service_image_upload', [MediaController::class, 'serviceImageUpload'])->name('service_image_upload');
    //about_us_header_image
    Route::post('about_us_header_image', [MediaController::class, 'aboutUsHeaderImage'])->name('about_us_header_image');
    //about_us_middle_image
    Route::post('about_us_middle_image', [MediaController::class, 'aboutUsMiddleImage'])->name('about_us_middle_image');
    //about_us_footer_image
    Route::post('about_us_footer_image', [MediaController::class, 'aboutUsFooterImage'])->name('about_us_footer_image');
    //logo
    Route::post('logo', [MediaController::class, 'logo'])->name('logo');
});
