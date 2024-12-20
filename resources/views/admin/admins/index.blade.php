@extends('admin.layouts.app')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Admins</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.organization.index') }}">Home</a>
                        </li>
                        <li class="breadcrumb-item active">Admins</li>
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
                        <div class="card-header">
                            <div class="card-tools">
                                <a href="{{ route('admin.admins.create') }}" class="btn btn-sm btn-info">New Admin</a>
                            </div>
                        </div>
                        <div class="card-body table-responsive">
                            <table id="adminsData" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Full Names</th>
                                        <th>Profile</th>
                                        <th>Phone</th>
                                        <th>Email</th>
                                        <th>Gender</th>
                                        <th>DOB</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                        <!--/.card-body -->
                    </div>
                    <!--/.card -->
                </div>
                <!--/.col -->
            </div>
            <!--/.row -->
        </div>
        <!--/.container-fluid -->
    </section>
    <!--/.content -->
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {

            find_admins();

            function find_admins() {
                let path = '{{ route('admin.admins.index') }}';
                $('#adminsData').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: path,
                    },
                    columns: [{
                            data: 'full_names',
                            name: 'full_names'
                        },
                        {
                            data: 'profile',
                            name: 'profile',
                        },
                        {
                            data: 'phone',
                            name: 'phone'
                        },
                        {
                            data: 'email',
                            name: 'email'
                        },
                        {
                            data: 'gender',
                            name: 'gender'
                        },
                        {
                            data: 'dob',
                            name: 'dob',
                        },
                        // {
                        //     data: 'actions',
                        //     name: 'actions',
                        //     orderable: false,
                        //     searchable: false,
                        // },
                    ],
                    "autoWidth": false,
                    "responsive": true,
                });
            }

        });
    </script>
@endpush
