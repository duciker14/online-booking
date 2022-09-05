<?php

use App\Http\Controllers\auth\LoginAdminController;

Route::group(['prefix' => 'auth', 'as'=>'auth.'], function () {
    Route::get('login', [LoginAdminController::class, 'index'])->name('login')->middleware('checkLogged');
    Route::post('login', [LoginAdminController::class, 'subLogin'])->name('sublogin');
    
    Route::get('verify-admin', [LoginAdminController::class, 'viewVerifyAdmin'])->name('verify-admin')->middleware('checkVerified');
    Route::post('verify-admin', [LoginAdminController::class, 'verify_admin'])->name('sub-verify-admin');
    
    Route::get('logout', [LoginAdminController::class, 'logout'])->name('logout');
});

?>