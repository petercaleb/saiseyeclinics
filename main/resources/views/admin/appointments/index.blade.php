@extends('admin.layouts.temp')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Appointments</h1>
                    <small>{{ $clinic->clinic }}</small>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.dashboard.index', $clinic->id) }}">Home</a>
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
                            <form action="{{ route('admin.appointments.export', $clinic->id) }}" method="GET">
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

                                        <button type="submit" class="btn btn-primary">
                                            Get PDF
                                        </button>
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
    </section><!-- /.content -->
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {

            find_appointments();
            function find_appointments(from_date, to_date) {
                var path = '{{ route('admin.appointments.index', $clinic->id) }}';
                $('#appointmentsData').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url:path,
                        data:{
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
            $(document).on('click', '#filter', function(e){
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

            $(document).on('click', '.viewAdminAppointmentBtn', function(e){
                e.preventDefault();
                let appointment_id = $(this).data('id');
                let path = '{{ route('admin.appointments.show', ':appointment_id') }}';
                path = path.replace(':appointment_id', appointment_id);
                $.ajax({
                    url: path,
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        if(data['status']){
                            let url = '{{ route('admin.appointments.view', [':id', ':appointment_id']) }}';
                            url = url.replace(':id', {{ $clinic->id }})
                            url = url.replace(':appointment_id', data['data']['id']);
                            setTimeout(() => {
                                window.location.href = url;
                            }, 1000);
                        }
                    },
                });
            });

        });
    </script>
@endsection
