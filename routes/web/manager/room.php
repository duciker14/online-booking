<?php

use App\Http\Controllers\manager\RoomController;

Route::group(['prefix' => 'manager', 'as' => 'manager.', 'middleware' => 'admin.auth'], function () {
    Route::resource('room', RoomController::class);
});

?>
