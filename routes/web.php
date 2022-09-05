<?php

use App\Http\Controllers\admin\BookingController;
use App\Http\Controllers\admin\DashBoardController;
use App\Http\Controllers\admin\RatingController;
use App\Http\Controllers\admin\RequestPaymentController;
use App\Http\Controllers\auth\ChangePasswordController;
use App\Http\Controllers\auth\RegisterUserController;
use App\Http\Controllers\auth\ResetPasswordController;
use App\Http\Controllers\home\tourist\HomePageController;
use App\Http\Controllers\manager\RatingController as ManagerRatingController;
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

// Route::get('/manager', [DashBoardController::class, 'index']);
Route::get('/', [HomePageController::class, 'index']);
Route::get('/search', [HomePageController::class, 'search_hotel'])->name('search_hotel');
Route::get('/about', [HomePageController::class, 'about'])->name('about');
Route::get('/contact', [HomePageController::class, 'contact'])->name('contact');
Route::post('/contact', [HomePageController::class, 'sendContact'])->name('send.contact');
Route::get('/list-hotel', [HomePageController::class, 'list_hotel'])->name('list-hotel');
Route::get('/detail-hotel/{id}', [HomePageController::class, 'detail_hotel'])->name('detail-hotel');
Route::get('/hotel/{id_hotel}/room/{id_room}', [HomePageController::class, 'detail_room'])->name('detail-room');
Route::get('/', [HomePageController::class, 'index']);

Route::get('register', [RegisterUserController::class, 'index'])->name('register');
Route::post('register', [RegisterUserController::class, 'add'])->name('add.user');
// Route::get('/active/{user}/{token}', [RegisterUserController::class, 'actived'])->name('actived');
Route::get('/active/{token}', [RegisterUserController::class, 'actived'])->name('actived');

Route::get('/forgot-password', [ResetPasswordController::class, 'index'])->name('forgot.password');
Route::post('/forgot-password', [ResetPasswordController::class, 'sendResetLink']);
Route::get('/reset-password/{email}/{token}', [ResetPasswordController::class, 'showResetPasswordForm'])->name('reset.password');
Route::post('/reset-password', [ResetPasswordController::class, 'submitResetPasswordForm'])->name('reset.password.post');

// change password
Route::get('/change-password', [ChangePasswordController::class, 'index'])->middleware('auth')->name('change.password');
Route::post('/change-password', [ChangePasswordController::class, 'submitChangePassword'])->middleware('auth');

Route::middleware('admin.auth')->prefix('admin')->group(function () {

    // manage bookings
    Route::get('/list-booking', [BookingController::class, 'index'])->name('list.booking');
    Route::get('/booking-detail/{id}', [BookingController::class, 'edit'])->name('detail.booking');
    Route::post('/booking-detail/{id}', [BookingController::class, 'update']);
    Route::get('/delete-booking/{id}', [BookingController::class, 'destroy'])->name('delete.booking');

    // manage payment request
    Route::get('/list-payment-request', [RequestPaymentController::class, 'index'])->name('list.payment.request');
    Route::get('/payment-request-detail/{id}', [RequestPaymentController::class, 'edit'])->name('detail.payment.request');
    Route::post('/payment-request-detail/{id}', [RequestPaymentController::class, 'update']);
    Route::get('/delete-payment-request/{id}', [RequestPaymentController::class, 'destroy'])->name('delete.payment.request');
    Route::get('/payment-request-approval/{id}', [RequestPaymentController::class, 'approval'])->name('approval.payment.request');
    Route::post('/payment-request-reject', [RequestPaymentController::class, 'reject'])->name('reject.payment.request');

    // manage reviews
    Route::get('/list-reviews', [RatingController::class, 'index'])->name('list.reviews');
    Route::get('/delete-reviews/{id}', [RatingController::class, 'destroy'])->name('delete.reviews');
});

//reviews_tourist
Route::post('/insert-rating', [RatingController::class, 'insert_rating'])->name('insert-rating');
Route::post('/update-content', [RatingController::class, 'update_content'])->name('update-content');
Route::post('/destroy-reviews/{id}', [RatingController::class, 'dlt_rv'])->name('destroy-reviews');

//admin
require __DIR__ . '/web/admin/booking.php';
require __DIR__ . '/web/admin/category.php';
require __DIR__ . '/web/admin/dashboard.php';
require __DIR__ . '/web/admin/hotel.php';
require __DIR__ . '/web/admin/rating.php';
require __DIR__ . '/web/admin/request_payment.php';
require __DIR__ . '/web/admin/revenue.php';
require __DIR__ . '/web/admin/room.php';
require __DIR__ . '/web/admin/user.php';

//auth
require __DIR__ . '/web/auth/login_admin.php';
require __DIR__ . '/web/auth/login_manager.php';
require __DIR__ . '/web/auth/login_user.php';
require __DIR__ . '/web/auth/register_user.php';

//home affiliator
require __DIR__ . '/web/home/affiliator/profile.php';
require __DIR__ . '/web/home/affiliator/request_payment.php';
require __DIR__ . '/web/home/affiliator/revenue.php';

//home tourist
require __DIR__ . '/web/home/tourist/booking.php';
require __DIR__ . '/web/home/tourist/homepage.php';
require __DIR__ . '/web/home/tourist/profile.php';
require __DIR__ . '/web/home/tourist/rating.php';

//manager
require __DIR__ . '/web/manager/dashboard.php';
require __DIR__ . '/web/manager/booking.php';
require __DIR__ . '/web/manager/profile.php';
require __DIR__ . '/web/manager/hotel.php';
require __DIR__ . '/web/manager/rating.php';
require __DIR__ . '/web/manager/revenue.php';
require __DIR__ . '/web/manager/room.php';
