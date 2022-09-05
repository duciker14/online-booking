<?php

use App\Http\Controllers\manager\BookingController;
use App\Models\Booking;

Route::group(['prefix' => 'manager/bookings', 'as'=>'manager.bookings.', 'middleware' => 'admin.auth'], function () {
    Route::get('/add', [BookingController::class, 'create'])->name('create');
    Route::post('/add-booking', [BookingController::class, 'store'])->name('add.booking');
    Route::get('/', [BookingController::class, 'index'])->name('index');
    Route::get('/{id}/edit', [BookingController::class, 'edit'])->name('edit');
    Route::get('/{id}/delete', [BookingController::class, 'destroy'])->name('destroy');

    Route::post('/add', [BookingController::class, 'ajaxPriceRoom'])->name('ajax.price.room');

    Route::get('/cancel', [BookingController::class, 'cancel'])->name('cancel');
    Route::post('/reject-booking/{id}', [BookingController::class, 'reject'])->name('reject');

    Route::post('/confirm-payment', [BookingController::class, 'confirmPaid'])->name('confirm.payment');
    Route::post('/refund/{id}', [BookingController::class, 'refundMoneyBooking'])->name('refund');

});
?>
