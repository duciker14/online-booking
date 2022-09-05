<?php

use App\Http\Controllers\manager\HotelController;

Route::group(['prefix' => 'manager', 'as' => 'manager.', 'middleware' => 'admin.auth'], function () {
    Route::resource('hotel', HotelController::class);
});

?>
