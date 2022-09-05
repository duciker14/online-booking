<?php

Route::prefix('admin')->middleware('admin.auth')->group(function () {
    Route::resource('/users', App\Http\Controllers\admin\UserController::class);
    Route::get('/admin/users/create',[App\Http\Controllers\admin\UserController::class,'create'])->name('create-user');
    Route::get('/admin/users/tourist',[App\Http\Controllers\admin\UserController::class, 'listTourist'])->name('listTourist');
    Route::get('/admin/users/change/{id}',[App\Http\Controllers\admin\UserController::class,'change_active'])->name('users-change_active');
});

?>
