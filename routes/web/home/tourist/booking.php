<?php

use App\Http\Controllers\home\tourist\BookingController;
use App\Http\Controllers\home\tourist\ReferralController;

Route::group(['as'=>'user.', 'middleware'=> 'UserAuthenticate'], function () {
    Route::get('/hotel/{id_hotel}/room/{id_room}/booking', [BookingController::class, 'index'])->name('booking');
    Route::post('/booking/{room_id}', [BookingController::class, 'store'])->name('subBooking');

    Route::get('history-booking', [BookingController::class, 'listBooking'])->name('list-booking');
    Route::get('detail-booking/{id}', [BookingController::class, 'edit'])->name('detail-booking');

    Route::get('cancel-booking/{id}', [BookingController::class, 'cancelBooking'])->name('cancel-booking');
    Route::get('refund-booking/{id}', [BookingController::class, 'refundBooking'])->name('refund-booking');

    Route::get('payment-booking/{id}', [BookingController::class, 'paymentBooking'])->name('payment-booking');

    Route::get('referral-bonus', [ReferralController::class, 'index'])->name('referral-bonus');
});

?>
