<?php

use App\Http\Controllers\auth\ChangePasswordController;
use App\Http\Controllers\manager\BankAccountController;
use App\Http\Controllers\manager\ProfileController;

    Route::group(['prefix' => 'manager', 'as' => 'manager.', 'middleware' => 'admin.auth'], function () {
        Route::get('bank-account', [BankAccountController::class, 'index'])->name('bank.account');
        Route::post('update-bank-account', [BankAccountController::class, 'update'])->name('bank.update');

    });

    Route::get('/dashboard-profile', [ProfileController::class, 'index'])->middleware('admin.auth')->name('profile');
    Route::post('/dashboard-profile', [ChangePasswordController::class, 'submitChangePassword'])->name('change-password');
?>
