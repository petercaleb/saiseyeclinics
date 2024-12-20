@extends('admin.layouts.app')

@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Dashboard</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.organization.index') }}">Home</a>
                        </li>
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
        <div class="container-fluid">

            <!-- Small boxes (Stat box) -->
            <div class="row">
                <div class="col-lg-4 col-6">
                    <!-- small box -->
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>{{ count($clinics) }}</h3>

                            <p>Clinics</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-database"></i>
                        </div>
                        <a href="{{ route('admin.clinics.index') }}" class="small-box-footer">
                            More info <i class="fa fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-4 col-6">
                    <!-- small box -->
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>{{ count($workshops) }}</h3>

                            <p>Workshops</p>
                        </div>
                        <div class="icon">
                            <i class="fa fa-area-chart"></i>
                        </div>
                        <a href="{{ route('admin.workshop.index') }}" class="small-box-footer">
                            More info <i class="fa fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
                <!-- ./col -->
            </div>
            <!-- /.row -->


            <div class="row">
                <div class="col-lg-12">
                    <div class="card card-primary card-outline card-outline-tabs">

                        <div class="card-header p-0 border-bottom-0">
                            <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="custom-tabs-four-home-tab" data-toggle="pill"
                                        href="#custom-tabs-four-home" role="tab" aria-controls="custom-tabs-four-home"
                                        aria-selected="true">
                                        Clinics
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="custom-tabs-four-profile-tab" data-toggle="pill"
                                        href="#custom-tabs-four-profile" role="tab"
                                        aria-controls="custom-tabs-four-profile" aria-selected="false">
                                        Workshops
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <!---.card-header p-0 border-bottom-0-->
                        <div class="card-body">
                            <div class="tab-content" id="custom-tabs-four-tabContent">
                                <div class="tab-pane fade show active" id="custom-tabs-four-home" role="tabpanel"
                                    aria-labelledby="custom-tabs-four-home-tab">

                                    <div class="table-responsive">
                                        <table id="clinicData"
                                            class="table table-striped table-bordered table-valign-middle">
                                            <thead>
                                                <tr>
                                                    <th></th>
                                                    <th>Name</th>
                                                    <th>Initials</th>
                                                    <th>Logo</th>
                                                    <th>Email</th>
                                                    <th>Phone</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>

                                </div>

                                <div class="tab-pane fade" id="custom-tabs-four-profile" role="tabpanel"
                                    aria-labelledby="custom-tabs-four-profile-tab">

                                    <div class="table-responsive">
                                        <table id="workshopsData" class="table table-striped table-bordered table-hover">
                                            <thead>
                                                <tr>
                                                    <th></th>
                                                    <th>Name</th>
                                                    <th>Initials</th>
                                                    <th>Logo</th>
                                                    <th>Phone</th>
                                                    <th>Email</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody></tbody>
                                        </table>
                                    </div>

                                </div>

                            </div>
                            <!--.tab-content-->
                        </div>
                        <!-- /.card-body -->

                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col-md-6 -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </div>
    <!-- /.content -->
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {

            find_clinics();

            function find_clinics() {
                var path = '{{ route('admin.organization.clinics') }}';
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
                    "searching": false,
                    "lengthChange": false,
                    "ordering": true,
                    "info": true,
                    "paging": true,
                });
            }

            $(document).on('click', '.selectBtn', function(e) {
                e.preventDefault();
                let clinic_id = $(this).attr('id');
                let path = '{{ route('admin.clinics.show', ':clinic') }}';
                path = path.replace(':clinic', clinic_id)
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

            find_workshops();

            function find_workshops() {
                var path = '{{ route('admin.workshop.index') }}';
                $('#workshopsData').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: path,
                    columns: [{
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex'
                        }, {
                            data: 'name',
                            name: 'name'
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
                            data: 'phone',
                            name: 'phone'
                        },
                        {
                            data: 'email',
                            name: 'email'
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
                    "searching": false,
                    "lengthChange": false,
                    "ordering": true,
                    "info": true,
                    "paging": true,
                });
            }

            $(document).on('click', '.selectWorkshopBtn', function(e) {
                e.preventDefault();
                var workshop_id = $(this).attr('data-id');
                var path = '{{ route('admin.workshop.show') }}';
                var token = '{{ csrf_token() }}';
                $.ajax({
                    url: path,
                    type: 'POST',
                    data: {
                        _token: token,
                        workshop_id: workshop_id
                    },
                    success: function(data) {
                        if (data['status']) {
                            let workshop_url =
                                '{{ route('admin.dashboard.workshop.index', ':id') }}'.replace(
                                    ':id', data.data.id);
                            window.location.href = workshop_url;
                        } else {
                            console.log(data);
                        }
                    }
                });
            });

        });
    </script>
@endsection
