@extends('admin.layouts.app')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>All Clinics</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.organization.index') }}">Home</a>
                        </li>
                        <li class="breadcrumb-item active">Clinics</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">

                    <!-- Custom Tabs -->
                    <div class="card">
                        <div class="card-header d-flex p-0">
                            <h3 class="card-title p-3"></h3>
                            <ul class="nav nav-pills ml-auto p-2">
                                <li class="nav-item">
                                    <a class="nav-link active" href="#tab_1" data-toggle="tab">
                                        All
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#tab_2" data-toggle="tab">
                                        New Clinic
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#tab_3" data-toggle="tab">
                                        Trash
                                    </a>
                                </li>
                            </ul>
                        </div><!-- /.card-header -->
                        <div class="card-body">
                            <div class="tab-content">
                                <div class="tab-pane active" id="tab_1">
                                    @include('admin.clinics.clinics')
                                </div>
                                <!-- /.tab-pane -->
                                <div class="tab-pane" id="tab_2">
                                    @include('admin.clinics.new_clinic')
                                </div>
                                <!-- /.tab-pane -->
                                <div class="tab-pane" id="tab_3">
                                    @include('admin.clinics.trash')
                                </div>
                                <!-- /.tab-pane -->
                            </div>
                            <!-- /.tab-content -->
                        </div><!-- /.card-body -->
                    </div>
                    <!-- ./card -->


                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </section><!-- /.content -->
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {

            find_clinics();

            function find_clinics() {
                var path = '{{ route('admin.clinics.index') }}';
                $('#clinicData').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: path,
                    columns: [{
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex'
                        },
                        {
                            data: 'clinic',
                            name: 'clinic'
                        },
                        {
                            data: 'initials',
                            name: 'initials'
                        },
                        {
                            data: 'logo',
                            name: 'logo',
                            orderable: false,
                            searchable: false
                        },
                        {
                            data: 'email',
                            name: 'email'
                        },
                        {
                            data: 'phone',
                            name: 'phone'
                        },
                        {
                            data: 'actions',
                            name: 'actions',
                            orderable: false,
                            searchable: false
                        },
                    ],
                    "autoWidth": false,
                    "responsive": true,
                });
            }

            find_trashed_clinics();

            function find_trashed_clinics() {
                var path = '{{ route('admin.clinics.trashed') }}';
                $('#clinicTrashedData').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: path,
                    columns: [{
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex'
                        },
                        {
                            data: 'clinic',
                            name: 'clinic'
                        },
                        {
                            data: 'initials',
                            name: 'initials'
                        },
                        {
                            data: 'logo',
                            name: 'logo',
                            orderable: false,
                            searchable: false
                        },
                        {
                            data: 'email',
                            name: 'email'
                        },
                        {
                            data: 'phone',
                            name: 'phone'
                        },
                        {
                            data: 'actions',
                            name: 'actions',
                            orderable: false,
                            searchable: false
                        },
                    ],
                    "autoWidth": false,
                    "responsive": true,
                });
            }

            $('#newClinicForm').submit(function(e) {
                e.preventDefault();
                var form = $(this);
                var formData = new FormData(form[0]);
                var path = '{{ route('admin.clinics.store') }}';
                $.ajax({
                    url: path,
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    beforeSend: function() {
                        $('#newClinicSubmitBtn').html('<i class="fa fa-spinner fa-spin"></i>');
                        $('#newClinicSubmitBtn').attr('disabled', true);
                    },
                    complete: function() {
                        $('#newClinicSubmitBtn').html('Save');
                        $('#newClinicSubmitBtn').attr('disabled', false);
                    },
                    success: function(data) {
                        if (data['status']) {
                            toastr.success(data['message']);
                            $('#newClinicForm').trigger('reset');
                            $('#clinicData').DataTable().ajax.reload();
                            setTimeout(() => {
                                location.reload();
                            }, 1000);
                        } else {
                            toastr.success(data['error']);
                        }
                    }
                });
            });

            $(document).on('click', '.selectBtn', function(e) {
                e.preventDefault();
                let clinic_id = $(this).attr('id');
                let path = '{{ route('admin.clinics.show', ':clinic') }}';
                path = path.replace(':clinic', clinic_id);
                $.ajax({
                    url: path,
                    type: 'GET',
                    success: function(data) {
                        if (data['status']) {
                            setTimeout(() => {
                                window.location.href =
                                    '{{ route('admin.dashboard.index', ':clinic') }}'
                                    .replace(':clinic',
                                        data.data.id);
                            }, 500);
                        }
                    }
                });
            });

            $(document).on('click', '.restoreBtn', function(e) {
                e.preventDefault();
                let clinic_id = $(this).attr('id');
                let token = '{{ csrf_token() }}';
                let path = '{{ route('admin.clinics.restore.clinic', ':clinic') }}';
                path = path.replace(':clinic', clinic_id);
                Swal.fire({
                    title: "Are you sure?",
                    text: "You are gong to restore clinic data",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: path,
                            type: "POST",
                            data: {
                                _token: token,
                            },
                            dataType: "json",
                            success: function(data) {
                                if (data['status']) {
                                    toastr.success(data['message']);
                                    $('#clinicTrashedData').DataTable().ajax.reload();
                                    $('#clinicData').DataTable().ajax.reload();

                                }
                            }
                        });
                    } else if (result.isDenied) {
                        Swal.fire('Changes are not saved', '', 'info');
                    }
                });
            })

            $(document).on('click', '.deleteBtn', function(e) {
                e.preventDefault();
                let clinic_id = $(this).attr('id');
                let token = '{{ csrf_token() }}';
                let path = '{{ route('admin.clinics.delete', ':clinic') }}';
                path = path.replace(':clinic', clinic_id);
                Swal.fire({
                    title: "Are you sure?",
                    text: "Once deleted, you will not be able to recover this record!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: path,
                            type: "DELETE",
                            data: {
                                _token: token,
                            },
                            dataType: "json",
                            success: function(data) {
                                if (data['status']) {
                                    toastr.success(data['message']);
                                    $('#clinicData').DataTable().ajax.reload();
                                    $('#clinicTrashedData').DataTable().ajax.reload();
                                }
                            }
                        });
                    } else if (result.isDenied) {
                        Swal.fire('Changes are not saved', '', 'info');
                    }
                });
            });

            $(document).on('click', '.deleteCompletelyBtn', function(e) {
                e.preventDefault();
                let clinic_id = $(this).attr('id');
                let token = '{{ csrf_token() }}';
                let path = '{{ route('admin.clinics.force.delete', ':clinic') }}';
                path = path.replace(':clinic', clinic_id);
                Swal.fire({
                    title: "Are you sure?",
                    text: "Once deleted, you will not be able to recover this record!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: path,
                            type: "DELETE",
                            data: {
                                _token: token,
                            },
                            dataType: "json",
                            success: function(data) {
                                if (data['status']) {
                                    toastr.success(data['message']);
                                    $('#clinicTrashedData').DataTable().ajax.reload();
                                    $('#clinicData').DataTable().ajax.reload();
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
