<?php

use App\Http\Controllers\Admin\Roles\RolesController;
use Illuminate\Support\Facades\Route;

Route::prefix('roles')->name('roles.')->group(function(){

    Route::get('/', [RolesController::class, 'index'])->name('index');
    Route::get('/create', [RolesController::class, 'create'])->name('create');
    Route::post('/store', [RolesController::class, 'store'])->name('store');
    Route::get('/{id}/show', [RolesController::class, 'show'])->name('show');
    Route::get('/{id}/edit', [RolesController::class, 'edit'])->name('edit');
    Route::put('/{id}/update', [RolesController::class, 'update'])->name('update');
    Route::delete('/{id}/delete', [RolesController::class, 'delete'])->name('delete');

});