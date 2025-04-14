<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Users\Users\UsersController;
use App\Http\Controllers\Users\Auth\AccountController;
use App\Http\Controllers\Users\Orders\OrdersController;
use App\Http\Controllers\Users\Lens\LensPowerController;
use App\Http\Controllers\Users\Doctors\DoctorsController;
use App\Http\Controllers\Users\Cases\CaseStocksController;
use App\Http\Controllers\Users\Medicine\MedicineController;
use App\Http\Controllers\Users\Cases\CaseRequestsController;
use App\Http\Controllers\Users\Frames\FrameStocksController;
use App\Http\Controllers\Users\Orders\OrderTracksController;
use App\Http\Controllers\Users\Cases\CasesReceivedController;
use App\Http\Controllers\Users\Diagnosis\DiagnosisController;
use App\Http\Controllers\Users\Procedure\ProcedureController;
use App\Http\Controllers\Users\Treatment\TreatmentController;
use App\Http\Controllers\Users\Frames\FrameRequestsController;
use App\Http\Controllers\Users\ClientType\ClientTypeController;
use App\Http\Controllers\Users\Frames\FramesReceivedController;
use App\Http\Controllers\Users\Lens\LensPrescriptionController;
use App\Http\Controllers\Users\Lens\FramePrescriptionsController;
use App\Http\Controllers\Users\Schedule\DoctorSchedulesController;
use App\Http\Controllers\Users\Appointments\AppointmentsController;
use App\Http\Controllers\Users\Patients\SelfRegistrationController;
use App\Http\Controllers\Users\Auth\LoginController as AuthLoginController;
use App\Http\Controllers\Users\Patients\PatientsController as PatientsPatientsController;
use App\Http\Controllers\Users\Auth\ResetPasswordController as AuthResetPasswordController;
use App\Http\Controllers\Users\Auth\ForgotPasswordController as AuthForgotPasswordController;
use App\Http\Controllers\Users\Dashboard\DashboardController as DashboardDashboardController;

Route::middleware(['guest:web', 'preventBackHistory'])->group(function () {

    Route::get('/login', [AuthLoginController::class, 'index'])->name('login');

    Route::post('/login', [AuthLoginController::class, 'store']);

    Route::get('/forgot/password', [AuthForgotPasswordController::class, 'index'])->name('forgot.password');

    Route::post('/forgot/password', [AuthForgotPasswordController::class, 'store']);

    Route::get('/reset/password/{token}', [AuthResetPasswordController::class, 'index'])->name('reset.password');

    Route::post('reset/password/store', [AuthResetPasswordController::class, 'store'])->name('reset.password.store');

    // patient self registration link
    Route::get('/{clinic}/self/registration', [SelfRegistrationController::class, 'register'])->name('self.registration');

    Route::post('/{clinic}/self/registration/store', [SelfRegistrationController::class, 'store'])->name('self.registration.store');

    Route::get('/{id}/self/client/type', [SelfRegistrationController::class, 'findClientTypeById'])->name('self.client.type');
});

Route::middleware(['auth:web', 'preventBackHistory'])->group(function () {

    Route::get('/deactivate/account', [AccountController::class, 'index'])->name('deactivate.account');

    Route::prefix('/users')->name('users.')->group(function () {

        Route::post('/logout', [UsersController::class, 'logout'])->name('logout');
    });
});

Route::middleware(['auth:web', 'preventBackHistory', 'AccountStatus'])->group(function () {

    Route::prefix('dashboard')->name('dashboard.')->group(function () {

        Route::get('/index', [DashboardDashboardController::class, 'index'])->name('index');

    });

    Route::prefix('appointments')->name('appointments.')->group(function () {

        Route::get('/index', [AppointmentsController::class, 'index'])->name('index');

        Route::get('/create', [AppointmentsController::class, 'create'])->name('create');

        Route::post('/store', [AppointmentsController::class, 'store'])->name('store');

        Route::get('/{appointment}/show', [AppointmentsController::class, 'show'])->name('show');

        Route::get('/{appointment}/view', [AppointmentsController::class, 'view'])->name('view');
    });

    Route::prefix('client/type')->name('client.type.')->group(function () {

        Route::post('/show', [ClientTypeController::class, 'show'])->name('show');
    });

    Route::prefix('/users')->name('users.')->group(function () {

        Route::get('/index', [UsersController::class, 'index'])->name('index');

        Route::post('/update', [UsersController::class, 'update'])->name('update');

        Route::post('/update/password', [UsersController::class, 'update_password'])->name('update.password');
    });

    Route::prefix('patients')->name('patients.')->group(function () {

        Route::get('/index', [PatientsPatientsController::class, 'index'])->name('index');

        Route::get('/create', [PatientsPatientsController::class, 'create'])->name('create');

        Route::post('/create', [PatientsPatientsController::class, 'store']);

        Route::get('/{patient}/show', [PatientsPatientsController::class, 'show'])->name('show');

        Route::get('/{patient}/view', [PatientsPatientsController::class, 'view'])->name('view');

        Route::get('/{id}/appointments', [PatientsPatientsController::class, 'appointments'])->name('appointments');

        Route::get('/{id}/schedules', [PatientsPatientsController::class, 'schedules'])->name('schedules');

        Route::get('/{patient}/edit', [PatientsPatientsController::class, 'edit'])->name('edit');

        Route::post('/{patient}/edit', [PatientsPatientsController::class, 'update']);

        Route::delete('/{patient}/delete', [PatientsPatientsController::class, 'destroy'])->name('delete');

        Route::get('/self/registration/link', [PatientsPatientsController::class, 'selfRegistration'])->name('self.registration.link');

        Route::post('/self/registration/generate', [PatientsPatientsController::class, 'generate'])->name('self.registration.generate');
    });

    Route::prefix('doctor/schedules')->name('doctor.schedules.')->group(function () {

        Route::get('/index', [DoctorSchedulesController::class, 'index'])->name('index');

        Route::get('/personal', [DoctorSchedulesController::class, 'my_schedules'])->name('personal');

        Route::post('/store', [DoctorSchedulesController::class, 'store'])->name('store');

        Route::post('/show', [DoctorSchedulesController::class, 'show'])->name('show');

        Route::get('/{id}/view', [DoctorSchedulesController::class, 'view'])->name('view');
    });

    Route::prefix('diagnosis')->name('diagnosis.')->group(function () {

        Route::post('/store', [DiagnosisController::class, 'store'])->name('store');

        Route::post('/show', [DiagnosisController::class, 'show'])->name('show');

        Route::post('/update', [DiagnosisController::class, 'update'])->name('update');
    });

    Route::prefix('treatment')->name('treatment.')->group(function () {

        Route::get('/{id}/create', [TreatmentController::class, 'create'])->name('create');
    });

    Route::prefix('lens')->name('lens.')->group(function () {

        Route::prefix('power')->name('power.')->group(function () {

            Route::post('/store', [LensPowerController::class, 'store'])->name('store');

            Route::post('/show', [LensPowerController::class, 'show'])->name('show');

            Route::post('/update', [LensPowerController::class, 'update'])->name('update');
        });

        Route::prefix('prescription')->name('prescription.')->group(function () {

            Route::post('/store', [LensPrescriptionController::class, 'store'])->name('store');

            Route::post('/show', [LensPrescriptionController::class, 'show'])->name('show');

            Route::post('/update', [LensPrescriptionController::class, 'update'])->name('update');
        });

        Route::prefix('frame/prescription')->name('frame.prescription.')->group(function () {

            Route::post('/store', [FramePrescriptionsController::class, 'store'])->name('store');

            Route::post('/show', [FramePrescriptionsController::class, 'show'])->name('show');

            Route::post('/update', [FramePrescriptionsController::class, 'update'])->name('update');
        });
    });

    Route::prefix('medicine')->name('medicine.')->group(function () {

        Route::get('/{id}', [MedicineController::class, 'index'])->name('index');

        Route::post('/store', [MedicineController::class, 'store'])->name('store');

        Route::post('/show', [MedicineController::class, 'show'])->name('show');

        Route::post('/delete', [MedicineController::class, 'destroy'])->name('delete');
    });

    Route::prefix('procedure')->name('procedure.')->group(function () {

        Route::post('/store', [ProcedureController::class, 'store'])->name('store');
    });

    Route::prefix('orders')->name('orders.')->group(function () {

        Route::get('/index', [OrdersController::class, 'index'])->name('index');

        Route::post('/store', [OrdersController::class, 'store'])->name('store');

        Route::get('/{order}/show', [OrdersController::class, 'show'])->name('show');

        Route::get('/{order}/view', [OrdersController::class, 'view'])->name('view');

        Route::post('/{order}/update', [OrdersController::class, 'update'])->name('update');

        Route::post('/send/mail', [OrdersController::class, 'send_mail'])->name('send.mail');
    });

    Route::prefix('order/track')->name('order.track.')->group(function () {

        Route::post('/store', [OrderTracksController::class, 'store'])->name('store');
    });

    Route::prefix('frame')->name('frame.')->group(function () {

        Route::prefix('stocks')->name('stocks.')->group(function () {

            Route::get('/index', [FrameStocksController::class, 'index'])->name('index');

        });

        Route::prefix('received')->name('received.')->group(function(){

            Route::get('/index', [FramesReceivedController::class, 'index'])->name('index');

            Route::get('/from/clinics', [FramesReceivedController::class, 'getReceivedFromClinic'])->name('from.clinics');

            Route::post('/{clinic}/store', [FramesReceivedController::class, 'store'])->name('store');

        });

        Route::prefix('requests')->name('requests.')->group(function(){

            Route::get('/index', [FrameRequestsController::class, 'index'])->name('index');

            Route::post('/store', [FrameRequestsController::class, 'store'])->name('store');

            Route::get('{frameRequest}/show', [FrameRequestsController::class, 'show'])->name('show');

        });
    });

    Route::prefix('case')->name('case.')->group(function () {

        Route::prefix('stock')->name('stock.')->group(function () {

            Route::get('/index', [CaseStocksController::class, 'index'])->name('index');

        });

        Route::prefix('received')->name('received.')->group(function(){

            Route::get('/', [CasesReceivedController::class, 'index'])->name('index');

            Route::get('/from/clinics', [CasesReceivedController::class, 'getReceivedFromClinic'])->name('from.clinics');

            Route::post('/store', [CasesReceivedController::class, 'store'])->name('store');

        });

        Route::prefix('requests')->name('requests.')->group(function(){

            Route::get('/index', [CaseRequestsController::class, 'index'])->name('index');

            Route::post('/store', [CaseRequestsController::class, 'store'])->name('store');

            Route::get('{caseRequest}/show', [CaseRequestsController::class, 'show'])->name('show');

        });


    });

    Route::prefix('doctors')->name('doctors.')->group(function () {

        Route::get('/index', [DoctorsController::class, 'index'])->name('index');
    });
});
