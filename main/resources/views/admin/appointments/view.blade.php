@extends('admin.layouts.temp')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>View Appointment</h1>
                    <small>{{ $clinic->clinic }}</small>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.dashboard.index', $clinic->id) }}">Home</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.appointments.index', $clinic->id) }}">Appointments</a>
                        </li>
                        <li class="breadcrumb-item active">View Appointment</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3">

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                Appointment Details
                            </h3>

                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                        class="fa fa-minus"></i>
                                </button>
                            </div>
                        </div>

                        <div class="card-body p-0">
                            <ul class="nav nav-pills flex-column">
                                <li class="nav-item active">
                                    <a href="#" class="nav-link">
                                        <i class="fa fa-calendar"></i> {{ $appointment->date }}
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#" class="nav-link">
                                        <i class="fa fa-clock-o"></i> {{ $appointment->appointment_time }}
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                Patient Details
                            </h3>

                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                        class="fa fa-minus"></i>
                                </button>
                            </div>
                        </div>

                        <div class="card-body p-0">
                            <ul class="nav nav-pills flex-column">
                                <li class="nav-item active">
                                    <a href="#" class="nav-link">
                                        <i class="fa fa-user"></i> {{ $patient->first_name }} {{ $patient->last_name }}
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#" class="nav-link">
                                        <i class="fa fa-phone"></i> {{ $patient->phone }}
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#" class="nav-link">
                                        <i class="fa fa-envelope"></i> {{ $patient->email }}
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#" class="nav-link">
                                        <i class="fa fa-calendar"></i> {{ $patient->dob }}
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#" class="nav-link">
                                        <i class="fa fa-male"></i> {{ $patient->gender }}
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="#" class="nav-link">
                                        <i class="fa fa-map-signs"></i> {{ $patient->address }}
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->

                </div>
                <!-- /.col -->
                <div class="col-md-6">

                    <div class="card card-outline card-primary">
                        <div class="card-header p-2">
                            <ul class="nav nav-pills">
                                <li class="nav-item">
                                    <a class="nav-link active" href="#scheduleTab" data-toggle="tab">
                                        Doctor Schedule
                                    </a>
                                </li>
                            </ul>
                        </div><!-- /.card-header -->
                        <div class="card-body">
                            <div class="tab-content">
                                <div class="active tab-pane" id="scheduleTab">
                                    @if ($doctor_schedule)
                                        <strong>
                                            <i class="fa fa-fighter-jet mr-1"></i> Scheduled Day
                                        </strong>

                                        <p class="text-muted">
                                            {{ $doctor_schedule->day }}
                                        </p>

                                        <hr>

                                        <strong>
                                            <i class="fa fa-calendar mr-1"></i> Scheduled Date
                                        </strong>

                                        <p class="text-muted">
                                            {{ $doctor_schedule->date }}
                                        </p>

                                        <hr>

                                        <strong>
                                            <i class="fa fa-clock-o mr-1"></i> Scheduled Time
                                        </strong>

                                        <p class="text-muted">
                                            {{ $doctor_schedule->time }}
                                        </p>

                                        <hr>

                                        <strong>
                                            <i class="fa fa-user mr-1"></i> Doctor/ Optimetrist
                                        </strong>

                                        <p class="text-muted">
                                            {{ $doctor_schedule->user->first_name }}
                                            {{ $doctor_schedule->user->last_name }}
                                        </p>

                                        <hr>
                                        <a href="#" id="{{ $doctor_schedule->id }}"
                                            class="btn btn-default btn-block  viewScheduleBtn">
                                            View Schedule
                                        </a>
                                    @else
                                        <strong>
                                            <i class="fa fa-info-circle"></i> Alert
                                        </strong>

                                        <p class="text-muted">
                                            No schedule found for this appointment.
                                        </p>
                                    @endif
                                </div>
                                <!-- /.tab-pane -->
                            </div>
                            <!-- /.tab-content -->
                        </div><!-- /.card-body -->
                    </div>
                    <!-- /.nav-tabs-custom -->
                </div>
                <!-- /.col -->
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                Payment Details
                            </h3>

                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                        class="fa fa-minus"></i>
                                </button>
                            </div>
                        </div>

                        <div class="card-body">
                            <strong><i class="fa fa-hourglass mr-1"></i> Client Type</strong>

                            <p class="text-muted">
                                {{ $payment_details->client_type->type }}
                            </p>

                            <hr>
                            @if ($payment_details->insurance)
                                <strong><i class="fa fa-building mr-1"></i> Insurance Company</strong>

                                <p class="text-muted">
                                    {{ $payment_details->insurance->title }}
                                </p>

                                <hr>

                                <strong><i class="fa fa-building mr-1"></i> Scheme</strong>

                                <p class="text-muted">
                                    {{ $payment_details->insurance->title }}
                                </p>

                                <hr>

                                <strong><i class="fa fa-user mr-1"></i> Principal Member</strong>

                                <p class="text-muted">
                                    {{ $payment_details->principal }}
                                </p>

                                <hr>
                                <strong><i class="fa fa-phone mr-1"></i> Principal Telephone Number</strong>

                                <p class="text-muted">
                                    {{ $payment_details->phone }}
                                </p>

                                <hr>
                                <strong><i class="fa fa-map-pin mr-1"></i> Principal Workplace</strong>

                                <p class="text-muted">
                                    {{ $payment_details->workplace }}
                                </p>

                                <hr>
                                <strong><i class="fa fa-credit-card mr-1"></i> Insurance Card Number</strong>

                                <p class="text-muted">
                                    {{ $payment_details->card_number }}
                                </p>

                                <hr>
                            @endif

                            <strong><i class="fa fa-map-pin mr-1"></i> Patient Workplace</strong>

                            <p class="text-muted">
                                {{ $payment_details->workplace }}
                            </p>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->

                </div>
                <!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {

            $(document).on('click', '.viewScheduleBtn', function(e) {
                e.preventDefault();
                let schedule_id = $(this).attr('id');
                let path = '{{ route('admin.doctor.schedules.show', ':schedule_id') }}';
                path = path.replace(':schedule_id', schedule_id);
                $.ajax({
                    url: path,
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        if(data['status']){
                            let url = '{{ route('admin.doctor.schedules.view', [':id', ':schedule_id']) }}';
                            url = url.replace(':id', {{ $clinic->id }});
                            url = url.replace(':schedule_id', data['data']['id']);
                            setTimeout(() => {
                                window.location.href = url;
                            }, 1000);
                        }
                    }
                });
            });

        });
    </script>
@endsection
