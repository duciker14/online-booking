<?php

use App\Http\Controllers\admin\CategoryController;

Route::group(['prefix' => 'admin/categories', 'as'=>'admin.categories.', 'middleware' => 'admin.auth'], function () {
    Route::get('/', [CategoryController::class, 'index'])->name('index');
    Route::get('/{id}/edit', [CategoryController::class, 'edit'])->name('edit');
    Route::get('/{id}', [CategoryController::class, 'destroy'])->name('destroy');
    Route::post('/status', [CategoryController::class, 'status'])->name('status');
});

?>