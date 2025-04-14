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
                        <li class="breadcrumb-item active">
                            @lang('users.page.inventory.sub_page.frames')
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
                <div class="col-md-3 col-sm-6 col-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-info">
                            <i class="fas fa-chart-area"></i>
                        </span>

                        <div class="info-box-content">
                            <span class="info-box-text">Frame Stocks</span>
                            <span class="info-box-number">
                                {{ $clinic->frame_stock()->count() }}
                            </span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->

                <div class="col-md-3 col-sm-6 col-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-info">
                            <i class="fas fa-chart-area"></i>
                        </span>

                        <div class="info-box-content">
                            <span class="info-box-text">
                                Frame Stocks <br>
                                Received From HQ
                            </span>
                            <span class="info-box-number">
                                {{ $clinic->frame_received()->where('is_hq', 1)->count() }}
                            </span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->

                <div class="col-md-3 col-sm-6 col-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-info">
                            <i class="fas fa-chart-area"></i>
                        </span>

                        <div class="info-box-content">
                            <span class="info-box-text">
                                Frame Stocks <br>
                                Received From Clinics
                            </span>
                            <span class="info-box-number">
                                {{ $clinic->frame_received()->where('is_hq', 0)->count() }}
                            </span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->
            </div><!-- /.row -->

            <div class="row">
                <div class="col-12">
                    <!-- Custom Tabs -->
                    <div class="card">
                        <div class="card-header d-flex p-0">
                            <ul class="nav nav-pills ml-auto p-2">
                                <li class="nav-item">
                                    <a class="nav-link active" href="#tab_1" data-toggle="tab">
                                        @lang('labels.users.tabs.inventory.frames.stocks')
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#tab_2" data-toggle="tab">
                                        @lang('labels.users.tabs.inventory.frames.received.title')
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#tab_3" data-toggle="tab">
                                        @lang('labels.users.tabs.inventory.frames.requested')
                                    </a>
                                </li>
                            </ul>
                        </div><!-- /.card-header -->
                        <div class="card-body">
                            <div class="tab-content">
                                <div class="tab-pane active" id="tab_1">
                                    @include('users.frames.stocks')
                                </div>
                                <!-- /.tab-pane -->

                                <div class="tab-pane" id="tab_2">
                                    @include('users.frames.received')
                                </div>
                                <!-- /.tab-pane -->

                                <div class="tab-pane" id="tab_3">
                                    @include('users.frames.requested')
                                </div>
                                <!-- /.tab-pane -->
                            </div>
                            <!-- /.tab-content -->
                        </div><!-- /.card-body -->
                    </div>
                    <!-- ./card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section><!-- /.content -->
@endsection

@push('modals')
    @include('users.includes.modals.receive_from_hq')
    @include('users.includes.modals.request_frame')
@endpush

@push('scripts')
    <script>
        $(document).ready(function() {

            find_frame_stocks();

            function find_frame_stocks() {
                let path = '{{ route('users.frame.stocks.index') }}';
                $('#frameStocksData').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: path,
                    columns: [{
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex'
                        },
                        {
                            data: 'frame_code',
                            name: 'frame_code'
                        },
                        {
                            data: 'gender',
                            name: 'gender'
                        },
                        {
                            data: 'color',
                            name: 'color'
                        },
                        {
                            data: 'shape',
                            name: 'shape'
                        },
                        {
                            data: 'received',
                            name: 'received'
                        },
                        {
                            data: 'total',
                            name: 'total'
                        },
                        {
                            data: 'sold',
                            name: 'sold'
                        },
                        {
                            data: 'closing',
                            name: 'closing'
                        }
                    ],
                    "autoWidth": false,
                    "responsive": true,
                });
            }

            find_received_frames_hq();

            function find_received_frames_hq() {
                let path = '{{ route('users.frame.received.index') }}';
                $('#framesReceivedFromHQData').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: path,
                    columns: [{
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex'
                        },
                        {
                            data: 'received_date',
                            name: 'received_date'
                        },
                        {
                            data: 'frame_code',
                            name: 'frame_code'
                        },
                        {
                            data: 'quantity',
                            name: 'quantity'
                        },
                        {
                            data: 'condition',
                            name: 'condition'
                        },
                        {
                            data: 'status',
                            name: 'status'
                        },
                        {
                            data: 'remarks',
                            name: 'remarks'
                        },
                        {
                            data: 'received_by',
                            name: 'received_by'
                        }
                    ],
                    "autoWidth": false,
                    "responsive": true,
                });
            }

            find_received_frames_clinics();

            function find_received_frames_clinics() {
                let path = '{{ route('users.frame.received.from.clinics') }}';
                $('#framesReceivedFromClinicsData').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: path,
                    columns: [{
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex'
                        },
                        {
                            data: 'received_date',
                            name: 'received_date'
                        },
                        {
                            data: 'frame_code',
                            name: 'frame_code'
                        },
                        {
                            data: 'from_clinic',
                            name: 'from_clinic'
                        },
                        {
                            data: 'quantity',
                            name: 'quantity'
                        },
                        {
                            data: 'condition',
                            name: 'condition'
                        },
                        {
                            data: 'status',
                            name: 'status'
                        },
                        {
                            data: 'remarks',
                            name: 'remarks'
                        },
                        {
                            data: 'received_by',
                            name: 'received_by'
                        }
                    ],
                    "autoWidth": false,
                    "responsive": true,
                });
            }

            $(document).on('click', '.receiveFromHQBtn', function(e) {
                e.preventDefault();
                $('#receiveFromHQModal').modal('show');
                $('#receiveFromHQForm').trigger("reset");
            });

            $("#receiveFromHQForm").submit(function(e) {
                e.preventDefault();
                let form = $(this);
                let formData = new FormData(form[0]);
                let path = '{{ route('users.frame.received.store', ':clinic') }}';
                path = path.replace(':clinic', '{{ $clinic->id }}');
                $.ajax({
                    type: "POST",
                    url: path,
                    data: formData,
                    processData: false,
                    contentType: false,
                    beforeSend: function() {
                        form.find('button[type=submit]').html(
                            '<i class="fa fa-spinner fa-spin"></i>'
                        );
                        form.find('button[type=submit]').attr('disabled', true);
                    },
                    complete: function() {
                        form.find('button[type=submit]').html('Receive');
                        form.find('button[type=submit]').attr('disabled', false);
                    },
                    success: function(data) {
                        if (data['status']) {
                            toastr.success(data['message']);
                            $('#receiveFromHQModal').modal('hide');
                            $('#receiveFromHQForm').trigger("reset");
                            $('#framesReceivedFromHQData').DataTable().ajax.reload();
                            $('#frameStocksData').DataTable().ajax.reload();
                            $('#frameRequestedData').DataTable().ajax.reload();
                            setTimeout(() => {
                                location.reload();
                            }, 1000);
                        }
                    },
                    error: function(data) {
                        if (data.status == 422) {
                            let errors = data.responseJSON.errors;
                            for (var key in errors) {
                                toastr.error(errors[key][0]);
                            }
                        }
                    }
                });
            });

            find_frame_requested();

            function find_frame_requested() {
                let path = '{{ route('users.frame.requests.index') }}';
                $('#frameRequestedData').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: path,
                    columns: [{
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex'
                        },
                        {
                            data: 'request_date',
                            name: 'request_date'
                        },
                        {
                            data: 'frame_code',
                            name: 'frame_code'
                        },
                        {
                            data: 'quantity',
                            name: 'quantity'
                        },
                        {
                            data: 'status',
                            name: 'status'
                        },
                        {
                            data: 'transfer_status',
                            name: 'transfer_status'
                        },
                        {
                            data: 'remarks',
                            name: 'remarks'
                        },
                        {
                            data: 'requested_by',
                            name: 'requested_by'
                        }
                    ],
                    "autoWidth": false,
                    "responsive": true,
                });
            }

            $(document).on('click', '.requestFrameBtn', function(e) {
                e.preventDefault();
                $('#requestFrameModal').modal('show');
                $('#requestFrameForm').trigger("reset");
            });

            $('#requestFrameForm').submit(function (e) { 
                e.preventDefault();
                let form = $(this);
                let formData = new FormData(form[0]);
                let path = '{{ route('users.frame.requests.store') }}';
                $.ajax({
                    type: "POST",
                    url: path,
                    data: formData,
                    processData: false,
                    contentType: false,
                    beforeSend: function() {
                        form.find('button[type=submit]').html(
                            '<i class="fa fa-spinner fa-spin"></i>'
                        );
                        form.find('button[type=submit]').attr('disabled', true);
                    },
                    complete: function() {
                        form.find('button[type=submit]').html('Request');
                        form.find('button[type=submit]').attr('disabled', false);
                    },
                    success: function(data) {
                        if (data['status']) {
                            toastr.success(data['message']);
                            $('#requestFrameModal').modal('hide');
                            $('#requestFrameForm').trigger("reset");
                            $('#frameRequestedData').DataTable().ajax.reload();
                            $('#framesReceivedFromHQData').DataTable().ajax.reload();
                            $('#frameStocksData').DataTable().ajax.reload();
                            setTimeout(() => {
                                location.reload();
                            }, 1000);
                        }
                    },
                    error: function(data) {
                        if (data.status == 422) {
                            let errors = data.responseJSON.errors;
                            for (var key in errors) {
                                toastr.error(errors[key][0]);
                            }
                        }
                    }
                });
            });
        });
    </script>
@endpush
