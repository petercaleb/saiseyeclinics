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
                        <li class="breadcrumb-item active">Orders Report</li>
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
                    <div class="card">
                        <div class="card-body">
                            <button id="filterOrdersByDateBtn" class="btn btn-outline-primary">
                                Filter By Dates
                            </button>

                            <button id="filterOrdersByReceiptNumberBtn" class="btn btn-outline-primary">
                                Filter By Receipt Number
                            </button>

                            <button id="filterOrdersByStatus" class="btn btn-outline-primary">
                                Filter By Status
                            </button>

                            <button id="refreshReportsAllReports" class="btn btn-outline-primary">
                                <i class="fa fa-refresh"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <!--/.col -->
            </div>
            <!--/.row -->

            <div class="row ordersReportsByDateRow">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('admin.order.reports.export', $clinic->id) }}" method="GET">
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
                                            Get Excel
                                        </button>
                                    </div>

                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!--/.col -->
            </div>
            <!--/.row -->

            <div class="row ordersReportsByReceiptNumberRow">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('admin.order.reports.export', $clinic->id) }}" method="GET">
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <select name="order_id" id="orderId" class="form-control select2"
                                                style="width: 100%;">
                                                <option selected="selected" disabled="disabled">
                                                    Choose receipt number
                                                </option>
                                                @forelse ($orders as $order)
                                                    <option value="{{ $order->id }}">
                                                        #{{ $order->id }} - {{ $order->receipt_number }}
                                                    </option>
                                                @empty
                                                    <option disabled="disabled">No order receipts found!</option>
                                                @endforelse
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <button type="button" name="filter" id="filterOrderIdBtn"
                                            class="btn btn-primary">Filter</button>
                                        <button type="button" name="refresh" id="refresh"
                                            class="btn btn-default">Refresh</button>

                                        <button type="submit" class="btn btn-primary">
                                            Get Excel
                                        </button>
                                    </div>

                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!--/.col -->
            </div>
            <!--/.row -->

            <div class="row ordersReportsByStatusRow">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('admin.order.reports.export', $clinic->id) }}" method="GET">
                                <div class="row">
                                    <div class="col-8">
                                        <div class="form-group">
                                            <select id="orderStatusSelect" name="order_status" class="form-control select2"
                                                style="width: 100%;">
                                                <option selected="selected" disabled="disabled">
                                                    Select status
                                                </option>
                                                <option value="APPROVED">APPROVED</option>
                                                <option value="SENT TO WORKSHOP">SENT TO WORKSHOP</option>
                                                <option value="FRAME SENT TO WORKSHOP">FRAME SENT TO WORKSHOP
                                                </option>
                                                <option value="ORDER RECEIVED">ORDER RECEIVED</option>
                                                <option value="FRAME RECEIVED">FRAME RECEIVED</option>
                                                <option value="GLAZING">GLAZING</option>
                                                <option value="RIGHT LENS GLAZED">RIGHT LENS GLAZED</option>
                                                <option value="GLAZED">GLAZED</option>
                                                <option value="SEND TO CLINIC">SEND TO CLINIC</option>
                                                <option value="RECEIVED FROM WORKSHOP">RECEIVED FROM WORKSHOP
                                                </option>
                                                <option value="CALL FOR COLLECTION">CALL FOR COLLECTION</option>
                                                <option value="FRAME COLLECTED">FRAME COLLECTED</option>
                                                <option value="CLOSED">CLOSED</option>
                                            </select>
                                        </div>
                                        <!-- /.form-group -->
                                    </div>
                                    <div class="col-md-4">
                                        <button type="button" name="filterStatusBtn" id="filterStatusBtn"
                                            class="btn btn-primary">Filter
                                        </button>

                                        <button type="button" name="refresh" id="refresh"
                                            class="btn btn-default">Refresh</button>

                                        <button type="submit" class="btn btn-primary">
                                            Get Excel
                                        </button>
                                    </div>


                                </div>

                            </form>
                        </div>
                    </div>

                </div>
                <!--/.col -->
            </div>
            <!--/.row -->

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body table-responsive">
                            <table id="ordersReportData" class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>Date</th>
                                        <th>Receipt #</th>
                                        <th>Clinic </th>
                                        <th>Patient</th>
                                        <th>Status</th>
                                        <th>Workshop</th>
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


            find_orders();

            function find_orders(from_date = '', to_date='', order_id = '', status = '') {
                let path = '{{ route('admin.order.reports.index', $clinic->id) }}';
                $('#ordersReportData').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: path,
                        data: {
                            from_date:from_date,
                            to_date:to_date,
                            order_id: order_id,
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
                    ],
                    "autoWidth": false,
                    "responsive": true,
                });
            }

            $('.ordersReportsByDateRow').fadeOut(500);
            $('.ordersReportsByReceiptNumberRow').fadeOut(500);
            $('.ordersReportsByStatusRow').fadeOut(500);

            $(document).on('click', '#refreshReportsAllReports', function(e) {
                e.preventDefault();
                $('.ordersReportsByDateRow').fadeOut(500);
                $('.ordersReportsByReceiptNumberRow').fadeOut(500);
                $('.ordersReportsByStatusRow').fadeOut(500);
                setTimeout(() => {
                    location.reload();
                }, 1000);
            });

            $(document).on('click', '#refresh', function(e) {
                e.preventDefault();
                $('#fromDate').val('');
                $('#toDate').val('');
                $('#orderReceiptNumber').val('').change();
                $('#orderStatusSelect').val('').change();
                $('#ordersReportData').DataTable().destroy();
                find_orders();
            });


            // Reports By Dates
            $(document).on('click', '#filterOrdersByDateBtn', function(e) {
                e.preventDefault();
                $('.ordersReportsByDateRow').fadeIn(800);
                $('.ordersReportsByReceiptNumberRow').fadeOut(500);
                $('.ordersReportsByStatusRow').fadeOut(500);
            });

            $(document).on('click', '#filter', function(e) {
                e.preventDefault();
                var from_date = $('#fromDate').val();
                var to_date = $('#toDate').val();
                if (from_date != '' && to_date != '') {
                    $('#ordersReportData').DataTable().destroy();
                    find_orders(from_date, to_date);
                } else {
                    toastr.error('Both Date is required');
                }
            });


            // Reports By Receipt Number
            $(document).on('click', '#filterOrdersByReceiptNumberBtn', function(e) {
                e.preventDefault();
                $('.ordersReportsByDateRow').fadeOut(500);
                $('.ordersReportsByReceiptNumberRow').fadeIn(800);
                $('.ordersReportsByStatusRow').fadeOut(500);
            });

            $(document).on('click', '#filterOrderIdBtn', function(e) {
                e.preventDefault();
                let order_id = $('#orderId').val();
                if (order_id != null) {
                    $('#ordersReportData').DataTable().destroy();
                    find_orders(from_date = '', to_date = '', order_id);
                } else {
                    toastr.error('Please select receipt number');
                }
            });

            // Reports By Order Status
            $(document).on('click', '#filterOrdersByStatus', function(e) {
                e.preventDefault();
                $('.ordersReportsByDateRow').fadeOut(500);
                $('.ordersReportsByReceiptNumberRow').fadeOut(500);
                $('.ordersReportsByStatusRow').fadeIn(800);
            });
            
            $(document).on('click', '#filterStatusBtn', function(e) {
                e.preventDefault();
                let status = $('#orderStatusSelect').val();
                if (status != null) {
                    $('#ordersReportData').DataTable().destroy();
                    find_orders(from_date = '', to_date = '', order_id = '', status);
                } else {
                    toastr.error('Please select order status');
                }
            });
        });
    </script>
@endpush
