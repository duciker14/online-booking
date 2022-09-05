<?php

use App\Http\Controllers\admin\DashBoardController;

    Route::group(['prefix' => 'admin/dashboards', 'as' => 'admin.dashboards.', 'middleware' => 'admin.auth'], function () {
        Route::get('/', [DashBoardController::class, 'index'])->name('index');
        Route::post('/exportBooking', [DashBoardController::class, 'export_csvBooking'])->name('export-booking');
        Route::post('/exportMonth', [DashBoardController::class, 'export_csvMonth'])->name('export-month');
        Route::post('/exportYear', [DashBoardController::class, 'export_csvYear'])->name('export-year');
    });

?>
