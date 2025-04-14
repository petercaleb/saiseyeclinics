<div class="col-md-3">
    <div class="card card-primary card-outline">
        <div class="card-body">
            <a href="{{ route('admin.patients.view', [$clinic->id, $patient->id]) }}"
                class="text-dark @if (isset($patient_sidebar) && $patient_sidebar == 'profile') active @endif">
                <i class="fa fa-user mr-1"></i> Profile
            </a>

            <hr>

            <a href="{{ route('admin.patients.appointments', [$clinic->id, $patient->id]) }}"
                class="text-dark @if (isset($patient_sidebar) && $patient_sidebar == 'appointments') active @endif">
                <i class="fa fa-check-square mr-1"></i> Appointment
            </a>

            <hr>

            <a href="{{ route('admin.patients.schedules', [$clinic->id, $patient->id]) }}"
                class="text-dark @if (isset($patient_sidebar) && $patient_sidebar == 'schedules') active @endif">
                <i class="fa fa-calendar mr-1"></i> Doctor Schedule
            </a>

            <hr>

            <a href="{{ route('admin.patients.payments', [$clinic->id, $patient->id]) }}"
                class="text-dark @if (isset($patient_sidebar) && $patient_sidebar == 'payments') active @endif">
                <i class="fa fa-money mr-1"></i> Payments
            </a>

            <hr>

            <a href="{{ route('admin.patients.orders', [$clinic->id, $patient->id]) }}"
                class="text-dark @if (isset($patient_sidebar) && $patient_sidebar == 'orders') active @endif">
                <i class="fa fa-cubes mr-1"></i> Orders
            </a>

            <hr>
            @if (!$patient->status)
                <button type="button" data-id="{{ $patient->id }}" class="btn btn-block btn-outline-success activatePatientBtn">
                    Activate
                </button>
            @else
                <button type="button" data-id="{{ $patient->id }}"
                    class="btn btn-block btn-outline-danger deactivatePatientBtn">
                    Deactivate
                </button>
            @endif

        </div>
        <!--/.card-body -->
    </div>
    <!--/.card -->
</div>
<!-- /.col -->