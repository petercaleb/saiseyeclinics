@extends('admin.layouts.temp')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Patients</h1>
                    <small>{{ $clinic->clinic }}</small>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.dashboard.index', $clinic->id) }}">Home</a>
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
                            <form action="{{ route('admin.patients.export', $clinic->id) }}" method="GET">
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
                            <table id="patientsData" class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>Date Registered</th>
                                        <th>Full Names</th>
                                        <th>ID Number</th>
                                        <th>Telephone</th>
                                        <th>Email</th>
                                        <th>Status</th>
                                        <th>Added By</th>
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

@push('scripts')
    <script>
        $(document).ready(function() {

            find_patients();

            function find_patients(from_date, to_date) {
                var path = '{{ route('admin.patients.index', $clinic->id) }}';
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
                            data: 'status',
                            name: 'status'
                        },
                        {
                            data: 'added_by',
                            name: 'added_by'
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

            // filter by date entered
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
                let path = '{{ route('admin.patients.show', ':id') }}';
                path = path.replace(':id', patient_id);
                $.ajax({
                    url: path,
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        if(data['status'])
                        {
                            let profilePath = '{{ route('admin.patients.view', [':id', ':patient_id', ':patient_name'])  }}';
                            profilePath = profilePath.replace(':id', {{$clinic->id}})
                            profilePath = profilePath.replace(':patient_id', data['data']['id']);
                            profilePath = profilePath.replace(':patient_name', data['data']['patient']);
                            setTimeout(() => {
                                window.location.href = profilePath;
                            }, 500);
                        }
                    }
                });
            });

            $(document).on('click', '.deleteBtn', function(e) {
                e.preventDefault();
                let patient_id = $(this).attr('id');
                let path = '{{ route('admin.patients.delete', ':id') }}';
                path = path.replace(':id', patient_id);
                let token = '{{ csrf_token() }}';
                Swal.fire({
                    title: "Are you sure?",
                    text: "Once deleted, you will not be able to recover this patient!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                }).then((result) => {
                    /* Read more about isConfirmed, isDenied below */
                    if (result.isConfirmed) {
                        $.ajax({
                            url: path,
                            type: "DELETE",
                            data: {
                                patient_id: patient_id,
                                _token: token,
                            },
                            dataType: "json",
                            success: function(data) {
                                if (data['status']) {
                                    Swal.fire(data['message'], '', 'success')
                                    $('#patientsData').DataTable().ajax.reload();
                                } else {
                                    console.log(data);
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
