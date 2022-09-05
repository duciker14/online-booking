<?php

use App\Http\Controllers\home\affiliator\BankAccountAffiliatorController;
use App\Http\Controllers\home\affiliator\RevenueController;

    Route::group(['prefix' => 'affiliator', 'as' => 'affiliator.'], function () {
        Route::get('bank-account', [BankAccountAffiliatorController::class, 'index'])->name('bank.account');
        Route::post('update-bank-account', [BankAccountAffiliatorController::class, 'update'])->name('bank.update');
        Route::get('revenue', [RevenueController::class, 'index'])->name('revenue');
    });

?>