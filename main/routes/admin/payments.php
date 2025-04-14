<?php

use App\Http\Controllers\Admin\Payments\BankingController;
use App\Http\Controllers\Admin\Payments\BillingController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Payments\PaymentsController;
use App\Http\Controllers\Admin\Payments\ClosedBillsController;
use App\Http\Controllers\Admin\Payments\PaymentDetailsController;
use App\Http\Controllers\Admin\Payments\ReceivedPaymentController;
use App\Http\Controllers\Admin\Payments\RemmittanceController;

Route::prefix('payments')->name('payments.')->group(function () {

    Route::prefix('bills')->name('bills.')->group(function () {
        Route::get('/{id}', [PaymentsController::class, 'index'])->name('index');
        Route::get('/{payment_id}/show', [PaymentsController::class, 'show'])->name('show');
        Route::get('/{id}/{payment_id}/view', [PaymentsController::class, 'view'])->name('view');
        Route::get('/{id}/{payment_id}/print', [PaymentsController::class, 'print'])->name('print');
    });

    Route::prefix('closed/bills')->name('closed.bills.')->group(function () {
        Route::get('/{id}', [ClosedBillsController::class, 'index'])->name('index');
        Route::get('/{paymentBill}/show', [ClosedBillsController::class, 'show'])->name('show');
        Route::get('/{id}/view', [ClosedBillsController::class, 'view'])->name('view');
        Route::get('/{id}/print', [ClosedBillsController::class, 'print'])->name('print');
    });
});


Route::prefix('payments/details')->name('payments.details.')->group(function () {

    Route::post('/store', [PaymentDetailsController::class, 'store'])->name('store');
});


Route::prefix('billing')->name('billing.')->group(function () {
    Route::get('/', [BillingController::class, 'index'])->name('index');
    Route::get('/export', [BillingController::class, 'export'])->name('export');
    Route::post('/{paymentBill}/receive', [BillingController::class, 'receiveDocument'])->name('receive');
    Route::post('/receive/multiple/docs', [BillingController::class, 'receiveMultipleDocuments'])->name('receive.multiple.docs');
    Route::post('/store/remmittance', [BillingController::class, 'store'])->name('store.remmittance');
});

Route::prefix('remmittance')->name('remmittance.')->group(function () {
    Route::get('/', [RemmittanceController::class, 'index'])->name('index');
    Route::get('/export', [RemmittanceController::class, 'export'])->name('export');
    Route::get('/export/pending/submission', [RemmittanceController::class, 'exportPendingSubmission'])->name('export.pending.submission');
    Route::get('/export/submitted/submission', [RemmittanceController::class, 'exportSubmittedSubmission'])->name('export.submitted.submission');
    Route::post('/submit/remmittance', [RemmittanceController::class, 'update'])->name('submit.remmittance');
});

Route::prefix('banking')->name('banking.')->group(function () {
    Route::get('/index', [BankingController::class, 'index'])->name('index');
    Route::get('/{id}/get/remmittance', [BankingController::class, 'getRemmittanceForInsurance'])->name('get.remmittance');
    Route::post('/store', [BankingController::class, 'store'])->name('store');
    Route::get('/{id}/show', [BankingController::class, 'show'])->name('show');
    Route::get('/{id}/view', [BankingController::class, 'view'])->name('view');
    Route::get('/export', [BankingController::class, 'export'])->name('export');
    Route::get('/{id}/export/individual', [BankingController::class, 'exportIndividual'])->name('export.individual');
});

Route::prefix('received/payments')->name('received.payments.')->group(function () {
    Route::post('/{receivedPayment}/update', [ReceivedPaymentController::class, 'update'])->name('update');
    Route::get('/export', [ReceivedPaymentController::class, 'export'])->name('export');
});
