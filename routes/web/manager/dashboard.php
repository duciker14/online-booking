<?php

use App\Http\Controllers\manager\AjaxController;
use App\Http\Controllers\manager\DashBoardController;

Route::group(['prefix' => 'manager/dashboards', 'as' => 'manager.dashboards.', 'middleware' => 'admin.auth'], function () {
    Route::get('/', [DashBoardController::class, 'index'])->name('index');

    Route::post('/exportBooking', [DashBoardController::class, 'export_csvBooking'])->name('export-booking');
    Route::post('/exportMonth', [DashBoardController::class, 'export_csvMonth'])->name('export-month');
    Route::post('/exportYear', [DashBoardController::class, 'export_csvYear'])->name('export-year');
});

?>
