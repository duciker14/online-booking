<?php

use App\Http\Controllers\home\affiliator\RequestPaymentController;

Route::group(['prefix' => 'request-payment', 'as'=>'user.'], function () {
    Route::get('/', [RequestPaymentController::class, 'index'])->name('request-payment')->middleware('checkIsAffiliator');
    Route::post('/', [RequestPaymentController::class, 'store'])->name('subRequestPayment');

    Route::get('request-history', [RequestPaymentController::class, 'requestHistory'])->name('request-history');
    Route::get('show-request/{id}', [RequestPaymentController::class, 'show'])->name('show-request');
    Route::delete('delete-request/{id}', [RequestPaymentController::class, 'destroy'])->name('delete-request');
    Route::get('edit-request/{id}', [RequestPaymentController::class, 'edit'])->name('edit-request');
    Route::post('update-request/{id}', [RequestPaymentController::class, 'update'])->name('update-request');
});

?>
