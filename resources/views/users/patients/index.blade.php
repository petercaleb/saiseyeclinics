@extends('users.layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{ $clinic->clinic }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ route('users.dashboard.index') }}">Home</a>
                        </li>
                        <li class="breadcrumb-item active">Patients</li>
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
                                        <button type="button" name="filter" id="filter" class="btn btn-primary">
                                            Filter
                                        </button>
                                        <button type="button" name="refresh" id="refresh" class="btn btn-default">
                                            Refresh
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
                        <div class="card-header">
                            <div class="card-tools">
                                <a href="{{ route('users.patients.create') }}" class="btn btn-primary btn-sm newPatientBtn">
                                    <i class="fa fa-plus-circle"></i> New Patient
                                </a>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body table-responsive">
                            <table id="patientsData" class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>Date Registered</th>
                                        <th>Full Names</th>
                                        <th>ID Number</th>
                                        <th>Telephone</th>
                                        <th>Email</th>
                                        <th>Date of Birth</th>
                                        <th>Gender</th>
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
    </section>
    <!-- /.content -->
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {

            find_patients();

            function find_patients(from_date, to_date) {
                var path = '{{ route('users.patients.index') }}';
                $('#patientsData').DataTable({
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
                            data: 'date_in',
                            name: 'date_in'
                        },
                        {
                            data: 'full_names',
                            name: 'full_names'
                        },
                        {
                            data: 'id_number',
                            name: 'id_number',
                        },
                        {
                            data: 'phone',
                            name: 'phone',
                        },
                        {
                            data: 'email',
                            name: 'email'
                        },
                        {
                            data: 'dob',
                            name: 'dob'
                        },
                        {
                            data: 'gender',
                            name: 'gender'
                        },
                        {
                            data: 'action',
                            name: 'action',
                            orderable: false,
                            searchable: false
                        },
                    ],
                    "autoWidth": false,
                    "responsive": true,
                });
            }

            // Filter Date
            $(document).on('click', '#filter', function(e) {
                e.preventDefault();
                var from_date = $('#fromDate').val();
                var to_date = $('#toDate').val();
                if (from_date != '' && to_date != '') {
                    $('#patientsData').DataTable().destroy();
                    find_patients(from_date, to_date);
                } else {
                    toastr.error('Both Date is required');
                }
            });

            // refresh afrter filter
            $(document).on('click', '#refresh', function(e) {
                e.preventDefault();
                $('#fromDate').val('');
                $('#toDate').val('')
                $('#patientsData').DataTable().destroy();
                find_patients();
            });

            $(document).on('click', '.viewBtn', function(e) {
                e.preventDefault();
                let patient_id = $(this).attr('id');
                let path = '{{ route('users.patients.show', ':patient') }}';
                path = path.replace(":patient", patient_id);
                $.ajax({
                    url: path,
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        if (data['status']) {
                            let url = '{{ route('users.patients.view', ':patient') }}';
                            url = url.replace(':patient', data['data']['id']);
                            setTimeout(() => {
                                window.location.href = url;
                            }, 1000);
                        }
                    }
                });
            });

            $(document).on('click', '.editBtn', function(e) {
                e.preventDefault();
                let patient_id = $(this).attr('id');
                let path = '{{ route('users.patients.show', ':patient') }}';
                path = path.replace(':patient', patient_id);
                $.ajax({
                    url: path,
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        if (data['status']) {
                            let url = '{{ route('users.patients.edit', ':patient') }}';
                            url = url.replace(':patient', data['data']['id']);
                            setTimeout(() => {
                                window.location.href = url;
                            }, 1000);
                        }
                    },
                });
            });
        });
    </script>
@endpush
