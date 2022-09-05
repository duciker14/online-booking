<?php

use App\Http\Controllers\manager\RatingController;

    Route::group(['prefix' => 'manager', 'as' => 'manager.', 'middleware' => 'admin.auth'], function () {
        Route::get('/list-reviews', [RatingController::class, 'index'])->name('list.reviews');
        Route::get('/delete-reviews/{id}', [RatingController::class, 'destroy'])->name('delete.reviews');
    });

?>