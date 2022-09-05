<?php

use App\Http\Controllers\auth\LoginUserController;

Route::group(['as'=>'user.'], function () {
    Route::get('login', [LoginUserController::class, 'index'])->name('login')->middleware('checkUserLogin');
    Route::post('login', [LoginUserController::class, 'subLogin'])->name('sublogin');
    
    Route::get('logout', [LoginUserController::class, 'logout'])->name('logout');
});

Route::prefix('google')->name('google.')->group( function(){
    Route::get('login', [LoginUserController::class, 'loginUsingGoogle'])->name('login')->middleware('checkUserLogin');
    Route::get('callback', [LoginUserController::class, 'callbackFromGoogle'])->name('callback');
});

?>