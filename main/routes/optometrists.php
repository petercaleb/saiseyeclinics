<?php
// Admin Auth Group
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Users\UsersController;

Route::middleware(['auth:admin', 'preventBackHistory'])->group(function () {

    Route::prefix('admin')->name('admin.')->group(function () {
        // users
        Route::prefix('users')->name('users.')->group(function () {
            Route::get('/{clinic}', [UsersController::class, 'clinic'])->name('index');
            Route::post('/store', [UsersController::class, 'store'])->name('store');
            Route::get('/{user_id}/show', [UsersController::class, 'show'])->name('show');
            Route::post('/{user_id}/update/status', [UsersController::class, 'update_status'])->name('update.status');
            Route::delete('/delete', [UsersController::class, 'destroy'])->name('delete');
        });

        Route::prefix('organization/users')->name('organization.users.')->group(function(){

            Route::get('/', [UsersController::class, 'index'])->name('index');

        });
    });
});
