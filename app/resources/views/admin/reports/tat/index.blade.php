@extends('admin.layouts.temp')

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
                            <a href="{{ route('admin.dashboard.index', $clinic->id) }}">Home</a>
                        </li>
                        <li class="breadcrumb-item active">{{ $page_title }}</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

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
                                        @lang('labels.admins.tabs.reports.tat.tat_one')
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#tab_2" data-toggle="tab">
                                        @lang('labels.admins.tabs.reports.tat.tat_two')
                                    </a>
                                </li>
                            </ul>
                        </div><!-- /.card-header -->
                        <div class="card-body">
                            <div class="tab-content">
                                <div class="tab-pane active" id="tab_1">
                                    @include('admin.reports.tat.tat_one')
                                </div>
                                <!-- /.tab-pane -->
                                <div class="tab-pane" id="tab_2">
                                    @include('admin.reports.tat.tat_two')
                                </div>
                                <!-- /.tab-pane -->
                            </div>
                            <!-- /.tab-content -->
                        </div><!-- /.card-body -->
                    </div>
                    <!-- ./card -->
                </div>
                <!--/.col -->
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {

            find_tat_one();

            function find_tat_one(from_date = '', to_date = '', status = '') {
                let path = '{{ route('admin.tat.reports.index', $clinic->id) }}';
                $('#tatOneOrderData').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: path,
                        data: {
                            from_date: from_date,
                            to_date: to_date,
                            status: status
                        }
                    },
                    columns: [{
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex'
                        },
                        {
                            data: 'order_date',
                            name: 'order_date'
                        },
                        {
                            data: 'receipt_number',
                            name: 'receipt_number',
                        },
                        {
                            data: 'clinic',
                            name: 'clinic',
                        },
                        {
                            data: 'full_names',
                            name: 'full_names',
                        },
                        {
                            data: 'status',
                            name: 'status'
                        },
                        {
                            data: 'workshop',
                            name: 'workshop'
                        },
                        {
                            data: 'tat_one',
                            name: 'tat_one'
                        },
                    ],
                    "autoWidth": false,
                    "responsive": true,
                });
            }

            $('.TATOneReportsByDateRow').fadeOut(500);
            $('.TATOneReportsByStatusRow').fadeOut(500);
            $(document).on('click', '#filterTATOneByDateBtn', function(e) {
                e.preventDefault();
                $('.TATOneReportsByDateRow').fadeToggle("slow");
                $('.TATOneReportsByStatusRow').fadeOut(500);
            });

            $(document).on('click', '#filter', function(e) {
                e.preventDefault();
                var from_date = $('#fromDate').val();
                var to_date = $('#toDate').val();
                if (from_date != '' && to_date != '') {
                    $('#tatOneOrderData').DataTable().destroy();
                    find_tat_one(from_date, to_date);
                } else {
                    toastr.error('Both Date is required');
                }
            });

            $(document).on('click', '#filterTATOneByStatus', function(e) {
                $('.TATOneReportsByDateRow').fadeOut(500);
                $('.TATOneReportsByStatusRow').fadeToggle("slow");
            });

            $(document).on('click', '#filterStatusBtn', function(e) {
                e.preventDefault();
                let status = $('#orderStatusSelect').val();
                if (status != null) {
                    $('#tatOneOrderData').DataTable().destroy();
                    find_tat_one(from_date = '', to_date = '', status);
                } else {
                    toastr.error('Please select order status');
                }
            });

            $(document).on('click', '#refreshReportsAllReports', function(e) {
                e.preventDefault();
                $('#fromDate').val('');
                $('#toDate').val('');
                $('#orderStatusSelect').val('').change();
                $('#tatOneOrderData').DataTable().destroy();
                find_tat_one();
                $('.TATOneReportsByDateRow').fadeOut(500);
                $('.TATOneReportsByStatusRow').fadeOut(500);
            });

            find_tat_two();

            function find_tat_two(from_date = '', to_date = '', status = '') {
                let path = '{{ route('admin.tat.reports.tat.two', $clinic->id) }}';
                $('#tatTwoOrderData').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: path,
                        data: {
                            from_date: from_date,
                            to_date: to_date,
                            status: status
                        }
                    },
                    columns: [{
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex'
                        },
                        {
                            data: 'order_date',
                            name: 'order_date'
                        },
                        {
                            data: 'receipt_number',
                            name: 'receipt_number',
                        },
                        {
                            data: 'clinic',
                            name: 'clinic',
                        },
                        {
                            data: 'full_names',
                            name: 'full_names',
                        },
                        {
                            data: 'status',
                            name: 'status'
                        },
                        {
                            data: 'workshop',
                            name: 'workshop'
                        },
                        {
                            data: 'tat_two',
                            name: 'tat_two'
                        },
                    ],
                    "autoWidth": false,
                    "responsive": true,
                });
            }

            $('.TATTwoReportsByDateRow').fadeOut(500);
            $('.TATTwoReportsByStatusRow').fadeOut(500);
            $(document).on('click', '#filterTATTwoByDateBtn', function(e) {
                e.preventDefault();
                $('.TATTwoReportsByDateRow').fadeToggle("slow");
                $('.TATTwoReportsByStatusRow').fadeOut(500);
            });

            $(document).on('click', '#filterTATTwoBtn', function(e) {
                e.preventDefault();
                var from_date = $('#fromTATTwoDate').val();
                var to_date = $('#toTATTwoDate').val();
                if (from_date != '' && to_date != '') {
                    $('#tatTwoOrderData').DataTable().destroy();
                    find_tat_two(from_date, to_date);
                } else {
                    toastr.error('Both Date is required');
                }
            });

            $(document).on('click', '#filterTATTwoByStatus', function(e) {
                $('.TATTwoReportsByDateRow').fadeOut(500);
                $('.TATTwoReportsByStatusRow').fadeToggle("slow");
            });

            $(document).on('click', '#filterTATTwoStatusBtn', function(e) {
                e.preventDefault();
                let status = $('#tatTwoStatusSelectVal').val();
                if (status != null) {
                    $('#tatTwoOrderData').DataTable().destroy();
                    find_tat_two(from_date = '', to_date = '', status);
                } else {
                    toastr.error('Please select status');
                }
            });

            $(document).on('click', '#refreshReportsTATTwoReports', function(e) {
                e.preventDefault();
                $('#fromTATTwoDate').val('');
                $('#toTATTwoDate').val('');
                $('#tatTwoStatusSelectVal').val('').change();
                $('#tatTwoOrderData').DataTable().destroy();
                find_tat_two();
                $('.TATTwoReportsByDateRow').fadeOut(500);
                $('.TATTwoReportsByStatusRow').fadeOut(500);
            });

            

        });
    </script>
@endpush
