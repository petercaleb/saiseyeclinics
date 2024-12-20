@extends('admin.layouts.temp')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{ $patient->first_name }} {{ $patient->last_name }} Profile</h1>
                    <small>Added By: {{ $patient->user->first_name }} {{ $patient->user->last_name }}</small><br>
                    <small>Clinic: {{ $clinic->clinic }}</small>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.dashboard.index', $clinic->id) }}">Home</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.patients.index', $clinic->id) }}">Patients</a>
                        </li>
                        <li class="breadcrumb-item active">
                            Docotor Schedules
                        </li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                @include('admin.includes.patients.sidebar')
                <div class="col-md-9">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card card-info  card-outline">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Doctor</th>
                                                    <th>Schedule Day</th>
                                                    <th>Date</th>
                                                    <th>Time</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse ($schedules as $schedule)
                                                    <tr>
                                                        <td>
                                                            {{ $schedule->user->first_name }}
                                                            {{ $schedule->user->last_name }}
                                                        </td>
                                                        <td>
                                                            {{ $schedule->day }}
                                                        </td>
                                                        <td>
                                                            {{ date('d-M-Y', strtotime($schedule->date)) }}
                                                        </td>
                                                        <td>
                                                            {{ date('h:i A', strtotime($schedule->time)) }}
                                                        </td>
                                                        <td>
                                                            <a href="javascript:void(0)" data-id="{{ $schedule->id }}"
                                                                class="btn btn-success viewScheduleBtn">
                                                                <i class="fa fa-eye"></i> View
                                                            </a>
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="5">
                                                            <p class="text-center">
                                                                No Schedules
                                                            </p>
                                                        </td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <!--/.card-body -->
                            </div>
                            <!--/.card -->
                        </div>
                        <!--/.col -->
                    </div>
                    <!--/.row -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $(document).on('click', '.viewScheduleBtn', function(e){
                e.preventDefault();
                let scheduleId = parseInt($(this).attr("data-id"));
                let path = '{{ route('admin.doctor.schedules.show', ':schedule_id') }}';
                path = path.replace(':schedule_id', scheduleId);
                $.ajax({
                    type: "GET",
                    url: path,
                    dataType: "json",
                    success: function (data) {
                        if(data['status']){
                            let viewPath = '{{ route('admin.doctor.schedules.view', [':id', ':schedule_id']) }}';
                            viewPath = viewPath.replace(':id', {{ $clinic->id }});
                            viewPath = viewPath.replace(':schedule_id', data['data']['id']);
                            setTimeout(() => {
                                window.location.href = viewPath;
                            }, 500);
                        }
                    }
                });

            });
        });
    </script>
@endpush

@push('patients_script')
    <script>
        $(document).ready(function() {
            $(document).on('click', '.deactivatePatientBtn', function(e) {
                e.preventDefault();
                let patient_id = $(this).data('id');
                let path = '{{ route('admin.patients.deactivate', ':id') }}';
                path = path.replace(':id', patient_id);
                let token = '{{ csrf_token() }}';
                Swal.fire({
                    title: "Are you sure?",
                    text: "You are going to deactivate current patient",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                }).then((result) => {
                    /* Read more about isConfirmed, isDenied below */
                    if (result.isConfirmed) {
                        $.ajax({
                            url: path,
                            type: "POST",
                            data: {
                                patient_id: patient_id,
                                _token: token,
                            },
                            dataType: "json",
                            success: function(data) {
                                if (data['status']) {
                                    Swal.fire(data['message'], '', 'success')
                                    setTimeout(() => {
                                        location.reload();
                                    }, 500);
                                }
                            }
                        });
                    } else if (result.isDenied) {
                        Swal.fire('Changes are not saved', '', 'info');
                    }
                });
            });

            $(document).on('click', '.activatePatientBtn', function(e) {
                e.preventDefault();
                let patient_id = $(this).data('id');
                let path = '{{ route('admin.patients.activate', ':id') }}';
                path = path.replace(':id', patient_id);
                let token = '{{ csrf_token() }}';
                Swal.fire({
                    title: "Are you sure?",
                    text: "You are going to activate current patient",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                }).then((result) => {
                    /* Read more about isConfirmed, isDenied below */
                    if (result.isConfirmed) {
                        $.ajax({
                            url: path,
                            type: "POST",
                            data: {
                                patient_id: patient_id,
                                _token: token,
                            },
                            dataType: "json",
                            success: function(data) {
                                if (data['status']) {
                                    Swal.fire(data['message'], '', 'success')
                                    setTimeout(() => {
                                        location.reload();
                                    }, 500);
                                }
                            }
                        });
                    } else if (result.isDenied) {
                        Swal.fire('Changes are not saved', '', 'info');
                    }
                });
            });
        });
    </script>
@endpush

