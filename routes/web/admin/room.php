<?php

use App\Http\Controllers\admin\RoomController;

Route::group(['prefix' => 'admin/rooms', 'as'=>'admin.rooms.', 'middleware' => 'admin.auth'], function () {
    Route::get('/', [RoomController::class, 'index'])->name('index');
    Route::get('/{id}/edit', [RoomController::class, 'edit'])->name('edit');
    Route::get('/{id}', [RoomController::class, 'destroy'])->name('destroy');
});

?>