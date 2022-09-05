<?php

use App\Http\Controllers\auth\ChangePasswordController;
use App\Http\Controllers\home\tourist\ProfileController;

Route::get('/profile', [ProfileController::class, 'index'])->middleware('UserAuthenticate')->name('tourist.profile');
Route::post('/profile', [ChangePasswordController::class, 'submitChangePassword'])->name('tourist-change-password');
Route::post('/update-profile/{id}', [ProfileController::class, 'updateProfile'])->name('tourist-update-profile');
