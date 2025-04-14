<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Lens\LensController;
use App\Http\Controllers\Admin\Cases\CaseStocksController;
use App\Http\Controllers\Admin\HQ\Lens\HQLensesController;
use App\Http\Controllers\Admin\Lens\LensRequestController;
use App\Http\Controllers\Admin\Lens\LensReceivesController;
use App\Http\Controllers\Admin\Cases\CaseReceivedController;
use App\Http\Controllers\Admin\Cases\CaseRequestsController;
use App\Http\Controllers\Admin\Frames\FramesStocksController;
use App\Http\Controllers\Admin\Frames\FrameReceivedController;
use App\Http\Controllers\Admin\Frames\FrameRequestsController;
use App\Http\Controllers\Admin\HQ\Cases\HqCaseStocksController;
use App\Http\Controllers\Admin\HQ\Frames\HQFrameStocksController;
use App\Http\Controllers\Admin\HQ\Lens\HQLensPurchasesController;
use App\Http\Controllers\Admin\HQ\Lens\HQLensTransfersController;
use App\Http\Controllers\Admin\Cases\WorkshopCaseStocksController;
use App\Http\Controllers\Admin\HQ\Cases\HQCasePurchasesController;
use App\Http\Controllers\Admin\HQ\Cases\HQCaseTransfersController;
use App\Http\Controllers\Admin\Cases\WorkshopCaseReceivedController;
use App\Http\Controllers\Admin\Cases\WorkshopCaseRequestsController;
use App\Http\Controllers\Admin\HQ\Frames\HQFramePurchasesController;
use App\Http\Controllers\Admin\HQ\Frames\HQFrameTransfersController;

// Admin Dashboard Group
Route::middleware(['auth:admin', 'preventBackHistory'])->group(function () {

    // HQ Inventories
    Route::prefix('hq')->name('hq.')->group(function () {

        Route::prefix('frame')->name('frame.')->group(function () {

            Route::prefix('stocks')->name('stocks.')->group(function () {

                Route::get('/index', [HQFrameStocksController::class, 'index'])->name('index');

                Route::get('/export', [HQFrameStocksController::class, 'export'])->name('export');

                Route::post('/store', [HQFrameStocksController::class, 'store'])->name('store');

                Route::get('/{hqFrameStock}/show', [HQFrameStocksController::class, 'show'])->name('show');

                Route::post('/{hqFrameStock}/update', [HQFrameStocksController::class, 'update'])->name('update');

                Route::delete('/{hqFrameStock}/delete', [HQFrameStocksController::class, 'destroy'])->name('delete');
            });

            Route::prefix('tranfers')->name('transfers.')->group(function () {

                Route::get('/index', [HQFrameTransfersController::class, 'index'])->name('index');

                Route::get('/export', [HQFrameTransfersController::class, 'export'])->name('export');

                Route::post('/store', [HQFrameTransfersController::class, 'store'])->name('store');

                Route::get('/{hqFrameTransfer}/show', [HQFrameTransfersController::class, 'show'])->name('show');

                Route::delete('/{hqFrameTransfer}/delete', [HQFrameTransfersController::class, 'destroy'])->name('delete');
            });

            Route::prefix('purchases')->name('purchases.')->group(function () {

                Route::get('/index', [HQFramePurchasesController::class, 'index'])->name('index');

                Route::get('/export', [HQFramePurchasesController::class, 'export'])->name('export');

                Route::post('/store', [HQFramePurchasesController::class, 'store'])->name('store');

                Route::get('/{hqFramePurchase}/show', [HQFramePurchasesController::class, 'show'])->name('show');

                Route::get('/{hqFramePurchase}/attachment', [HQFramePurchasesController::class, 'attachment'])->name('attachment');

                Route::delete('/{hqFramePurchase}/delete', [HQFramePurchasesController::class, 'destroy'])->name('delete');
            });
        });

        Route::prefix('lenses')->name('lenses.')->group(function () {

            Route::prefix('stocks')->name('stocks.')->group(function () {

                Route::get('/index', [HQLensesController::class, 'index'])->name('index');

                Route::get('/export', [HQLensesController::class, 'export'])->name('export');

                Route::post('/store', [HQLensesController::class, 'store'])->name('store');

                Route::get('/{hqLens}/show', [HQLensesController::class, 'show'])->name('show');

                Route::post('/{hqLens}/update', [HQLensesController::class, 'update'])->name('update');

                Route::delete('/{hqLens}/delete', [HQLensesController::class, 'destroy'])->name('delete');
            });

            Route::prefix('purchases')->name('purchases.')->group(function () {

                Route::get('/index', [HQLensPurchasesController::class, 'index'])->name('index');

                Route::get('/export', [HQLensPurchasesController::class, 'export'])->name('export');

                Route::post('/store', [HQLensPurchasesController::class, 'store'])->name('store');

                Route::get('/{hqLensPurchase}/show', [HQLensPurchasesController::class, 'show'])->name('show');

                Route::get('/{hqLensPurchase}/attachment', [HQLensPurchasesController::class, 'attachment'])->name('attachment');

                Route::delete('/{hqLensPurchase}/delete', [HQLensPurchasesController::class, 'destroy'])->name('delete');
            });

            Route::prefix('tranfers')->name('transfers.')->group(function () {

                Route::get('/index', [HQLensTransfersController::class, 'index'])->name('index');

                Route::get('/export', [HQLensTransfersController::class, 'export'])->name('export');

                Route::post('/store', [HQLensTransfersController::class, 'store'])->name('store');

                Route::get('/{hqLensTransfer}/show', [HQLensTransfersController::class, 'show'])->name('show');

                Route::delete('/{hqLensTransfer}/delete', [HQLensTransfersController::class, 'destroy'])->name('delete');
            });
        });

        Route::prefix('cases')->name('cases.')->group(function () {

            Route::prefix('stocks')->name('stocks.')->group(function () {

                Route::get('/index', [HqCaseStocksController::class, 'index'])->name('index');

                Route::get('/export', [HqCaseStocksController::class, 'export'])->name('export');

                Route::post('/store', [HqCaseStocksController::class, 'store'])->name('store');

                Route::get('/{hqCaseStock}/show', [HqCaseStocksController::class, 'show'])->name('show');

                Route::post('/{hqCaseStock}/update', [HqCaseStocksController::class, 'update'])->name('update');

                Route::delete('/{hqCaseStock}/delete', [HqCaseStocksController::class, 'destroy'])->name('delete');
            });

            Route::prefix('tranfers')->name('transfers.')->group(function () {

                Route::get('/index', [HQCaseTransfersController::class, 'index'])->name('index');

                Route::get('/export', [HQCaseTransfersController::class, 'export'])->name('export');

                Route::get('/workshop', [HQCaseTransfersController::class, 'get_for_workshops'])->name('workshop');

                Route::post('/store', [HQCaseTransfersController::class, 'store'])->name('store');

                Route::get('/{hqCaseTransfer}/show', [HQCaseTransfersController::class, 'show'])->name('show');

                Route::delete('/{hqCaseTransfer}/delete', [HQCaseTransfersController::class, 'destroy'])->name('delete');
            });

            Route::prefix('purchases')->name('purchases.')->group(function () {

                Route::get('/index', [HQCasePurchasesController::class, 'index'])->name('index');

                Route::get('/export', [HQCasePurchasesController::class, 'export'])->name('export');

                Route::post('/store', [HQCasePurchasesController::class, 'store'])->name('store');

                Route::get('/{hqCasePurchase}/show', [HQCasePurchasesController::class, 'show'])->name('show');

                Route::get('/{hqCasePurchase}/attachment', [HQCasePurchasesController::class, 'attachment'])->name('attachment');

                Route::delete('/{hqCasePurchase}/delete', [HQCasePurchasesController::class, 'destroy'])->name('delete');
            });
        });
    });

    // Clinics inventory
    Route::prefix('clinic/inventory')->name('clinic.inventory.')->group(function () {

        // frame stocks
        Route::prefix('frames')->name('frames.')->group(function () {

            Route::prefix('stocks')->name('stocks.')->group(function () {

                Route::get('/{clinic}', [FramesStocksController::class, 'index'])->name('index');

                Route::post('/{clinic}/store', [FramesStocksController::class, 'store'])->name('store');

                Route::get('/{frameStock}/show', [FramesStocksController::class, 'show'])->name('show');

                Route::post('/{frameStock}/update', [FramesStocksController::class, 'update'])->name('update');

                Route::delete('/{frameStock}/delete', [FramesStocksController::class, 'destroy'])->name('delete');
            });

            Route::prefix('received')->name('received.')->group(function () {

                Route::get('/{clinic}', [FrameReceivedController::class, 'index'])->name('index');

                Route::get('/{clinic}/from/clinic', [FrameReceivedController::class, 'get_received_from_clinic'])->name('from.clinic');

                Route::post('/{clinic}/store', [FrameReceivedController::class, 'store'])->name('store');

                Route::get('/{frameStock}/show', [FrameReceivedController::class, 'show'])->name('show');

                Route::post('/update', [FrameReceivedController::class, 'update'])->name('update');

                Route::delete('/{frameStock}/delete', [FrameReceivedController::class, 'destroy'])->name('delete');
            });


            Route::prefix('requests')->name('requests.')->group(function () {

                Route::get('/{clinic}', [FrameRequestsController::class, 'index'])->name('index');
            });
        });

        // Cases Stocks
        Route::prefix('cases')->name('cases.')->group(function () {

            Route::prefix('stock')->name('stock.')->group(function () {

                Route::get('/{clinic}', [CaseStocksController::class, 'index'])->name('index');

                Route::post('/{clinic}/store', [CaseStocksController::class, 'store'])->name('store');

                Route::get('/{caseStock}/show', [CaseStocksController::class, 'show'])->name('show');

                Route::post('/update', [CaseStocksController::class, 'update'])->name('update');

                Route::delete('/{caseStock}/delete', [CaseStocksController::class, 'destroy'])->name('delete');
            });

            Route::prefix('received')->name('received.')->group(function () {

                Route::get('/{clinic}', [CaseReceivedController::class, 'index'])->name('index');

                Route::get('/{clinic}/from/clinic', [CaseReceivedController::class, 'get_received_from_clinic'])->name('from.clinic');

                Route::get('/{frameStock}/show', [FrameReceivedController::class, 'show'])->name('show');

                Route::post('/update', [FrameReceivedController::class, 'update'])->name('update');

                Route::delete('/{frameStock}/delete', [FrameReceivedController::class, 'destroy'])->name('delete');
            });

            Route::prefix('requests')->name('requests.')->group(function () {

                Route::get('/{clinic}', [CaseRequestsController::class, 'index'])->name('index');
            });
        });
    });

    Route::prefix('workshop/inventory')->name('workshop.inventory.')->group(function () {

        Route::prefix('lens')->name('lens.')->group(function () {

            Route::prefix('stocks')->name('stocks.')->group(function () {

                Route::get('/{workshop}', [LensController::class, 'index'])->name('index');

                Route::post('/{workshop}/store', [LensController::class, 'store'])->name('store');

                Route::get('/{lens}/show', [LensController::class, 'show'])->name('show');

                Route::post('/{lens}/update', [LensController::class, 'update'])->name('update');

                Route::delete('/{lens}/delete', [LensController::class, 'destroy'])->name('delete');
            });

            Route::prefix('received')->name('received.')->group(function () {

                Route::get('/{workshop}', [LensReceivesController::class, 'index'])->name('index');

                Route::get('/{workshop}/from/workshop', [LensReceivesController::class, 'get_lens_received_from_workshops'])->name('from.workshop');

            });

            Route::prefix('request')->name('request.')->group(function () {

                Route::get('/{workshop}', [LensRequestController::class, 'index'])->name('index');

            });


        });

        Route::prefix('cases')->name('cases.')->group(function () {

            Route::prefix('stock')->name('stock.')->group(function () {

                Route::get('/{workshop}', [WorkshopCaseStocksController::class, 'index'])->name('index');

                Route::post('/{workshop}/store', [WorkshopCaseStocksController::class, 'store'])->name('store');

                Route::get('/{workshopCaseStock}/show', [WorkshopCaseStocksController::class, 'show'])->name('show');

                Route::post('/update', [WorkshopCaseStocksController::class, 'update'])->name('update');

                Route::delete('/{workshopCaseStock}/delete', [WorkshopCaseStocksController::class, 'destroy'])->name('delete');
            });

            Route::prefix('received')->name('received.')->group(function () {

                Route::get('/{workshop}', [WorkshopCaseReceivedController::class, 'index'])->name('index');

                Route::get('/{workshop}/from/workshop', [WorkshopCaseReceivedController::class, 'get_received_from_workshop'])->name('from.workshop');

            });

            Route::prefix('requests')->name('requests.')->group(function () {

                Route::get('/{workshop}', [WorkshopCaseRequestsController::class, 'index'])->name('index');
            });

        });
    });
});
