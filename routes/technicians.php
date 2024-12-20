<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Technicians\Lens\LensController;
use App\Http\Controllers\Technicians\Auth\LoginController;
use App\Http\Controllers\Technicians\Sales\SalesController;
use App\Http\Controllers\Technicians\Auth\AccountController;
use App\Http\Controllers\Technicians\Assets\AssetsController;
use App\Http\Controllers\Technicians\Orders\OrdersController;
use App\Http\Controllers\Technicians\Cases\CaseStocksController;
use App\Http\Controllers\Technicians\Lens\LensRequestController;
use App\Http\Controllers\Technicians\Lens\LensPurchaseController;
use App\Http\Controllers\Technicians\Lens\LensReceivedController;
use App\Http\Controllers\Technicians\Cases\CaseReceivedController;
use App\Http\Controllers\Technicians\Lens\LensTransfersController;
use App\Http\Controllers\Technicians\Dashboard\DashboardController;
use App\Http\Controllers\Technicians\Assets\TransferedAssetsController;
use App\Http\Controllers\Technicians\Cases\CaseRequestsController;
use App\Http\Controllers\Technicians\Technicians\TechniciansController;

Route::middleware(['guest:technician', 'preventBackHistory'])->group(function () {

    Route::get('/login', [LoginController::class, 'index'])->name('login');

    Route::post('/login', [LoginController::class, 'store']);
});

Route::middleware(['auth:technician', 'preventBackHistory'])->group(function () {

    Route::get('/inactive/account', [AccountController::class, 'index'])->name('inactive.account');

    Route::prefix('technicians')->name('technicians.')->group(function () {

        Route::post('/logout', [TechniciansController::class, 'logout'])->name('logout');
    });
});

Route::middleware(['auth:technician', 'preventBackHistory', 'TechnicianAccountStatus'])->group(function () {

    // Dashboard Routes...
    Route::prefix('dashboard')->name('dashboard.')->group(function () {

        Route::get('/index', [DashboardController::class, 'index'])->name('index');
    });

    Route::prefix('technicians')->name('technicians.')->group(function () {

        Route::get('/index', [TechniciansController::class, 'index'])->name('index');

        Route::post('/update', [TechniciansController::class, 'update'])->name('update');

        Route::post('/update/password', [TechniciansController::class, 'update_password'])->name('update.password');
    });

    Route::prefix('lens')->name('lens.')->group(function () {

        Route::get('/index', [LensController::class, 'index'])->name('index');

        Route::post('/store', [LensController::class, 'store'])->name('store');

        Route::post('/{id}/show', [LensController::class, 'show'])->name('show');

        Route::post('/{id}/update', [LensController::class, 'update'])->name('update');

        Route::delete('/{id}/delete', [LensController::class, 'destroy'])->name('delete');
    });


    Route::prefix('lens/received')->name('lens.received.')->group(function () {

        Route::get('/index', [LensReceivedController::class, 'index'])->name('index');

        Route::get('/from/workshop', [LensReceivedController::class, 'get_lens_received_from_workshops'])->name('from.workshop');

        Route::post('/store', [LensReceivedController::class, 'store'])->name('store');

        Route::get('/{lensReceive}', [LensReceivedController::class, 'show'])->name('show');

        Route::delete('/{id}/delete', [LensPurchaseController::class, 'destroy'])->name('delete');
    });


    Route::prefix('lens/request')->name('lens.request.')->group(function () {

        Route::get('/', [LensRequestController::class, 'index'])->name('index');

        Route::post('/store', [LensRequestController::class, 'store'])->name('store');
    });

    Route::prefix('lens/purchase')->name('lens.purchase.')->group(function () {

        Route::get('/index', [LensPurchaseController::class, 'index'])->name('index');

        Route::post('/store', [LensPurchaseController::class, 'store'])->name('store');

        Route::delete('/{id}/delete', [LensPurchaseController::class, 'destroy'])->name('delete');
    });

    Route::prefix('lens/transfer')->name('lens.transfer.')->group(function () {

        Route::get('/index', [LensTransfersController::class, 'index'])->name('index');

        Route::get('/to', [LensTransfersController::class, 'transfer_to'])->name('to');

        Route::post('/store', [LensTransfersController::class, 'store'])->name('store');

        Route::get('/{id}/show', [LensTransfersController::class, 'show'])->name('show');

        Route::delete('/{id}/delete', [LensTransfersController::class, 'destroy'])->name('delete');
    });

    Route::prefix('cases')->name('cases.')->group(function(){

        Route::prefix('stocks')->name('stocks.')->group(function(){

            Route::get('/', [CaseStocksController::class, 'index'])->name('index');

        });

        Route::prefix('received')->name('received.')->group(function(){

            Route::get('/', [CaseReceivedController::class, 'index'])->name('index');

            Route::get('/from/workshop', [CaseReceivedController::class, 'get_received_from_workshop'])->name('from.workshop');

            Route::post('/store', [CaseReceivedController::class, 'store'])->name('store');

        });

        
        Route::prefix('request')->name('request.')->group(function(){

            Route::get('/', [CaseRequestsController::class, 'index'])->name('index');

            Route::post('/store', [CaseRequestsController::class, 'store'])->name('store');
            
            Route::get('/{workshopCaseRequest}', [CaseRequestsController::class, 'show'])->name('show');
        });

    });
    
    Route::prefix('assets')->name('assets.')->group(function () {

        Route::get('/index', [AssetsController::class, 'index'])->name('index');
    });

    Route::prefix('assets/transfer')->name('assets.transfer.')->group(function () {

        Route::get('/index', [TransferedAssetsController::class, 'index'])->name('index');

        Route::get('/transfer/from', [TransferedAssetsController::class, 'transfer_from'])->name('transfer.from');
    });

    Route::prefix('orders')->name('orders.')->group(function () {

        Route::get('/index', [OrdersController::class, 'index'])->name('index');

        Route::post('/{id}/show', [OrdersController::class, 'show'])->name('show');

        Route::get('/{id}/view', [OrdersController::class, 'view'])->name('view');

        Route::post('/{id}/update', [OrdersController::class, 'update'])->name('update');
    });

    Route::prefix('sales')->name('sales.')->group(function () {

        Route::get('/index', [SalesController::class, 'index'])->name('index');

        Route::post('/store', [SalesController::class, 'store'])->name('store');

        Route::post('/{workshopSale}/update', [SalesController::class, 'update'])->name('update');
    });
});
