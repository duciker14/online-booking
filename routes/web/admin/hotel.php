<?php

use App\Http\Controllers\admin\HotelController;
use App\Http\Controllers\admin\RoomTypeController;

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => 'admin.auth'], function () {
    Route::resource('hotel', HotelController::class);

    Route::get('hotels/{id}', [HotelController::class, 'destroy'])->name('hotel.delete');

    // room type
    Route::get('/room-type', [RoomTypeController::class, 'index'])->name('room.type');
    Route::post('/room-type', [RoomTypeController::class, 'create']);
    Route::post('/room-type-update/{id}', [RoomTypeController::class, 'update'])->name('room.type.update');
    Route::get('/room-type-delete/{id}', [RoomTypeController::class, 'destroy'])->name('room.type.delete');
    Route::get('/room-type/{id}', [RoomTypeController::class, 'status'])->name('room.type.status');
});

?>
