@extends('users.layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>
                        {{ $clinic->clinic }}
                    </h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ route('users.dashboard.index') }}">Home</a>
                        </li>
                        <li class="breadcrumb-item active">Appointments</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <form method="GET">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <input type="text" name="from_date" id="fromDate"
                                                placeholder="Enter From Date" class="form-control datepicker">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <input type="text" name="to_date" id="toDate"
                                                placeholder="Enter Date Date" class="form-control datepicker">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <button type="button" name="filter" id="filter"
                                            class="btn btn-primary">Filter</button>
                                        <button type="button" name="refresh" id="refresh"
                                            class="btn btn-default">Refresh</button>
                                    </div>

                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-tools">
                                <a href="{{ route('users.appointments.create') }}"
                                    class="btn btn-primary btn-sm newAppointmentBtn">
                                    <i class="fa fa-plus-circle"></i> New Appointment
                                </a>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body table-responsive">
                            <table id="appointmentsData" class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>Full Names</th>
                                        <th>Date</th>
                                        <th>Time</th>
                                        <th>Client Type</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div><!-- /.card-body -->
                    </div><!-- /.card -->

                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
        <div class="modal fade" id="scheduleAppointmentModal">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Schedule Appointment</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="scheduleAppointmentForm">
                        <div class="modal-body">
                            @csrf
                            <div class="form-group">
                                <input type="hidden" id="scheduleAppointmentClinicId" name="clinic_id"
                                    class="form-control" />
                            </div>
                            <div class="form-group">
                                <input type="hidden" id="scheduleAppointmentPatientId" name="patient_id"
                                    class="form-control" />
                            </div>
                            <div class="form-group">
                                <input type="hidden" id="scheduleAppointmentAppointmentId" name="appointment_id"
                                    class="form-control" />
                            </div>
                            <div class="form-group">
                                <label for="scheduleAppointmentUserId">
                                    Doctor / Optometrist
                                </label>
                                <select id="scheduleAppointmentUserId" name="user_id" class="form-control select2"
                                    style="width: 100%;">
                                    <option selected="selected" disabled="disabled">Choose a Doctor / Optometrist</option>
                                    @forelse ($doctors as $doctor)
                                        <option value="{{ $doctor->id }}">
                                            {{ $doctor->first_name }} {{ $doctor->last_name }}
                                        </option>
                                    @empty
                                        <option selected="selected" disabled="disabled">
                                            No Doctors / Optometrists
                                        </option>
                                    @endforelse
                                </select>
                            </div>
                            <!-- /.form-group -->
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" id="scheduleAppointmentSubmitBtn" class="btn btn-primary">
                                Schedule
                            </button>
                        </div>
                    </form>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->
    </section><!-- /.content -->
@endsection


@push('scripts')
    <script>
        $(document).ready(function() {

            find_appointments();

            function find_appointments(from_date, to_date) {
                var path = '{{ route('users.appointments.index') }}';
                $('#appointmentsData').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: path,
                        data: {
                            from_date: from_date,
                            to_date: to_date,
                        }
                    },
                    columns: [{
                            data: 'full_names',
                            name: 'full_names'
                        },
                        {
                            data: 'date',
                            name: 'date',
                        },
                        {
                            data: 'appointment_time',
                            name: 'appointment_time'
                        },
                        {
                            data: 'type',
                            name: 'type'
                        },
                        {
                            data: 'appointment_status',
                            name: 'appointment_status',
                            orderable: false,
                            searchable: false,
                        },
                        {
                            data: 'action',
                            name: 'action',
                            orderable: false,
                            searchable: false,
                        },
                    ],
                    "autoWidth": false,
                    "responsive": true,
                });
            }

            // filter
            $(document).on('click', '#filter', function(e) {
                e.preventDefault();
                var from_date = $('#fromDate').val();
                var to_date = $('#toDate').val();
                if (from_date != '' && to_date != '') {
                    $('#appointmentsData').DataTable().destroy();
                    find_appointments(from_date, to_date);
                } else {
                    toastr.error('Both Date is required');
                }
            });

            // refresh afrter filter
            $(document).on('click', '#refresh', function(e) {
                e.preventDefault();
                $('#fromDate').val('');
                $('#toDate').val('')
                $('#appointmentsData').DataTable().destroy();
                find_appointments();
            });

            $(document).on('click', '.scheduleAppointment', function(e) {
                e.preventDefault();
                $('#scheduleAppointmentClinicId').val($(this).data('clinic'));
                $('#scheduleAppointmentPatientId').val($(this).data('patient'));
                $('#scheduleAppointmentAppointmentId').val($(this).attr('id'));
                $('#scheduleAppointmentModal').modal('show');
            });

            $('#scheduleAppointmentForm').submit(function(e) {
                e.preventDefault();
                let form = $(this);
                let form_data = new FormData(form[0]);
                $(selector).scrollLeft(value); path = '{{ route('users.doctor.schedules.store') }}';
                $.ajax({
                    url: path,
                    type: 'POST',
                    data: form_data,
                    contentType: false,
                    processData: false,
                    beforeSend: function() {
                        $('#scheduleAppointmentSubmitBtn').html(
                            '<i class="fa fa-spinner fa-spin"></i>');
                        $('#scheduleAppointmentSubmitBtn').attr('disabled', true);
                    },
                    complete: function() {
                        $('#scheduleAppointmentSubmitBtn').html('Schedule');
                        $('#scheduleAppointmentSubmitBtn').attr('disabled', false);
                    },
                    success: function(data) {
                        if (data['status']) {
                            toastr.success(data.message);
                            $('#scheduleAppointmentModal').modal('hide');
                            $('#scheduleAppointmentForm')[0].reset();
                            setTimeout(() => {
                                location.reload();
                            }, 1000);
                        } else {
                            toastr.error(data.message);
                        }
                    },
                    error: function(data) {
                        var errors = data.responseJSON;
                        var errorsHtml = '<ul>';
                        $.each(errors['errors'], function(key, value) {
                            errorsHtml += '<li>' + value + '</li>';
                        });
                        errorsHtml += '</ul>';
                        toastr.error(errorsHtml);
                    }
                });
            });

            $(document).on('click', '.viewBtn', function(e) {
                e.preventDefault();
                let appointment_id = $(this).attr('id');
                let path = '{{ route('users.appointments.show', ':appointment') }}';
                path = path.replace(':appointment', appointment_id);
                $.ajax({
                    url: path,
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        if (data['status']) {
                            let url = '{{ route('users.appointments.view', ':appointment') }}';
                            url = url.replace(':appointment', data['data']['id']);
                            setTimeout(() => {
                                window.location.href = url;
                            }, 500);
                        }
                    },
                });
            });

        });
    </script>
@endpush
