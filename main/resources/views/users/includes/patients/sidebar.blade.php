<div class="col-md-3">
    <div class="card card-primary card-outline">
        <div class="card-body">
            <a href="{{ route('users.patients.view', $patient->id) }}"
                class="text-dark @if (isset($patient_sidebar) && $patient_sidebar == trans('patient.profile')) active @endif">
                <i class="fa fa-user mr-1"></i> @lang('users.page.patients.sub_page.view')
            </a>

            <hr>

            <a href="{{ route('users.patients.appointments', $patient->id) }}"
                class="text-dark @if (isset($patient_sidebar) && $patient_sidebar == trans('patient.appointment')) active @endif">
                <i class="fa fa-check-square mr-1"></i> @lang('users.page.patients.sub_page.appointment')
            </a>

            <hr>

            <a href="{{ route('users.patients.schedules', $patient->id) }}"
                class="text-dark @if (isset($patient_sidebar) && $patient_sidebar == trans('patient.schedule')) active @endif">
                <i class="fa fa-calendar mr-1"></i> @lang('users.page.patients.sub_page.schedule')
            </a>

            {{-- <hr>

            <a href="{{ route('users.patients.schedules', $patient->id) }}"
                class="text-dark @if (isset($patient_sidebar) && $patient_sidebar == trans('patient.schedule')) active @endif">
                <i class="fas fa-table mr-1"></i> @lang('users.page.patients.sub_page.orders')
            </a> --}}

            <hr>

            <a href="{{ route('users.patients.edit', $patient->id) }}"
                class="btn btn-primary btn-block">
                <i class="fas fa-pencil-alt mr-1"></i> @lang('users.page.patients.sub_page.edit')
            </a>
        </div>
        <!--/.card-body -->
    </div>
    <!--/.card -->
</div>
<!-- /.col -->