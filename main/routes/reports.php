<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Reports\Main\ReportsController;
use App\Http\Controllers\Admin\Reports\ClinicReportsController;
use App\Http\Controllers\Admin\Reports\Orders\OrdersReportsController;
use App\Http\Controllers\Admin\Reports\TAT\ClinicsTATReportsController;
use App\Http\Controllers\Admin\Reports\Payments\PaymentsReportController;
use App\Http\Controllers\Admin\Reports\Claims\PendingClaimsReportController;
use App\Http\Controllers\Admin\Reports\Frames\FramesReportController;
use App\Http\Controllers\Admin\Reports\Frames\HqFramesReportController;
use App\Http\Controllers\Admin\Reports\Schemes\SchemeDetailsReportController;

Route::middleware(['auth:admin', 'preventBackHistory'])->group(function () {


    // Main Report
    Route::prefix('main/reports')->name('main.reports.')->group(function () {

        Route::get('/index', [ReportsController::class, 'index'])->name('index');

        Route::get('/get/reports', [ReportsController::class, 'get_reports'])->name('get.reports');

        Route::get('/export', [ReportsController::class, 'export'])->name('export');

    });

    Route::prefix('hq')->name('hq.')->group(function(){

        Route::prefix("frames/report")->name("frames.report.")->group(function(){
            Route::get('/', [HqFramesReportController::class, 'index'])->name("index");
            Route::get('/get/frames/report', [HqFramesReportController::class, 'getFramesReport'])->name("get.frames.report");
            Route::get('/export', [HqFramesReportController::class, 'export'])->name('export');
        });
    });

    // Payments Reports
    Route::prefix('payments/reports')->name('payments.reports.')->group(function () {

        Route::get('/{id}', [PaymentsReportController::class, 'index'])->name('index');

        Route::get('/{id}/export', [PaymentsReportController::class, 'export'])->name('export');
    });


    // Orders Reports
    Route::prefix('orders/report')->name('order.reports.')->group(function () {

        Route::get('/{id}', [OrdersReportsController::class, 'index'])->name('index');

        Route::get('/{id}/export', [OrdersReportsController::class, 'export'])->name('export');
    });

    // TAT Reports
    Route::prefix('tat/reports')->name('tat.reports.')->group(function () {

        Route::get('/{clinic}', [ClinicsTATReportsController::class, 'index'])->name('index');

        Route::get('/{clinic}/export/tat/one', [ClinicsTATReportsController::class, 'export_tat_one'])->name('export.tat.one');

        Route::get('/{clinic}/tat/two', [ClinicsTATReportsController::class, 'get_tat_two'])->name('tat.two');

        Route::get('/{clinic}/export/tat/two', [ClinicsTATReportsController::class, 'export_tat_two'])->name('export.tat.two');
    });


    // Scheme Details Report
    Route::prefix('scheme/details/reports')->name('scheme.details.reports.')->group(function () {

        Route::get('/{clinic}', [SchemeDetailsReportController::class, 'index'])->name('index');

        Route::get('/{clinic}/export', [SchemeDetailsReportController::class, 'export'])->name('export');
    });

    // Pending Claims Reports
    Route::prefix('pending/claims/reports')->name('pending.claims.reports.')->group(function () {

        Route::get('/{clinic}', [PendingClaimsReportController::class, 'index'])->name('index');

        Route::get('/{clinic}/export', [PendingClaimsReportController::class, 'export'])->name('export');
    });

    // Frames Reports
    Route::prefix('frames/report')->name('frames.report.')->group(function(){

        Route::get('/{clinic}', [FramesReportController::class, 'index'])->name('index');


    });
});
