<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Users\Payments\BillingController;
use App\Http\Controllers\Users\Payments\CloseBillsController;
use App\Http\Controllers\Users\Payments\RemittanceController;
use App\Http\Controllers\Users\Payments\PaymentsBillController;
use App\Http\Controllers\Users\Payments\PaymentDetailsController;
use App\Http\Controllers\Users\Payments\PaymentsAttachmentController;

Route::middleware(['auth:web', 'preventBackHistory', 'AccountStatus'])->group(function () {

    Route::prefix('payments')->name('payments.')->group(function () {

        Route::prefix('details')->name('details.')->group(function () {

            Route::post('/store', [PaymentDetailsController::class, 'store'])->name('store');
        });

        Route::prefix('bills')->name('bills.')->group(function () {

            Route::get('/index', [PaymentsBillController::class, 'index'])->name('index');

            Route::get('/scheduled/payments', [PaymentsBillController::class, 'get_scheduled'])->name('scheduled.payments');

            Route::get('/{id}/create', [PaymentsBillController::class, 'create'])->name('create');

            Route::post('/store', [PaymentsBillController::class, 'store'])->name('store');

            Route::get('/{paymentBill}/show', [PaymentsBillController::class, 'show'])->name('show');

            Route::get('/{paymentBill}/view', [PaymentsBillController::class, 'view'])->name('view');

            Route::get('/{paymentBill}/edit', [PaymentsBillController::class, 'edit'])->name('edit');

            Route::post('/{paymentBill}/update/agreed/amount', [PaymentsBillController::class, 'update_agreed'])->name('update.agreed.amount');

            Route::post('/update/consultation', [PaymentsBillController::class, 'update_consultation'])->name('update.consultation');

            Route::get('/{paymentBill}/print', [PaymentsBillController::class, 'print'])->name('print');
        });

        Route::prefix('close/bills')->name('close.bills.')->group(function () {

            Route::get('/index', [CloseBillsController::class, 'index'])->name('index');

            Route::get('/scheduled', [CloseBillsController::class, 'scheduled_bills'])->name('scheduled');

            Route::post('/{paymentBill}/store', [CloseBillsController::class, 'store'])->name('store');

            Route::get('/{paymentBill}/show', [CloseBillsController::class, 'show'])->name('show');

            Route::get('/{paymentBill}/view', [CloseBillsController::class, 'view'])->name('view');

            Route::post('/{paymentBill}/update/lpo', [CloseBillsController::class, 'update_lpo'])->name('update.lpo');

            Route::post('/{paymentBill}/send/to/hq', [CloseBillsController::class, 'sendPhysicalDocToHQ'])->name('send.to.hq');

            Route::post('/send-multiple-docs/to/hq', [CloseBillsController::class, 'sendMultipleDocsToHQ'])->name('send.multiple.hq');

            Route::get('/{paymentBill}/print', [CloseBillsController::class, 'print'])->name('print');
        });

        Route::prefix('attachments')->name('attachments.')->group(function () {

            Route::post('/{paymentBill}/store', [PaymentsAttachmentController::class, 'store'])->name('store');

            Route::get('/{paymentAttachment}/show', [PaymentsAttachmentController::class, 'show'])->name('show');

            Route::get('/{paymentAttachment}/open/file', [PaymentsAttachmentController::class, 'readFile'])->name('open.file');

            Route::post('/{paymentAttachment}/update', [PaymentsAttachmentController::class, 'update'])->name('update');

            Route::delete('/{paymentAttachment}/delete', [PaymentsAttachmentController::class, 'destroy'])->name('delete');
        });

        Route::prefix('billing')->name('billing.')->group(function () {

            Route::post('/{paymentBill}/store', [BillingController::class, 'store'])->name('store');

            Route::post('/{paymentBill}/update/paid', [BillingController::class, 'update_payment_bill'])->name('update.paid');
        });
    });

});