<?php

use App\Http\Controllers\admin\RevenueController;

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => 'admin.auth'], function () {
    Route::get('revenue', [RevenueController::class, 'index'])->name('dashboard');
});

?>