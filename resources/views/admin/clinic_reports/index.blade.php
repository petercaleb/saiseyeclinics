@extends('admin.layouts.app')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Clinic Reports</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.organization.index') }}">Home</a>
                        </li>
                        <li class="breadcrumb-item active">Clinic Reports</li>
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
                            <button id="filterReportsByDate" class="btn btn-info">Filter By Dates</button>
                            <button id="filterReportsByPayments" class="btn btn-info">Filter By Payments</button>
                            <button id="filterReportsByOrders" class="btn btn-info">Filter By Orders</button>
                            <button id="refreshReportsAllReports" class="btn btn-info">
                                <i class="fa fa-refresh"></i>
                            </button>
                        </div>
                    </div>

                </div>
                <!--/.col -->
            </div>
            <!--/.row -->

            <div class="row filterReportsByDatesRow">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('admin.clinics.reports.export') }}" method="GET">
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
            </div>

            <div class="row filterReportsByPaymentsRow">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('admin.clinics.reports.export') }}" method="GET">
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <select id="paymentStatus" name="payment_status" class="form-control select2"
                                                style="width: 100%;">
                                                <option selected="selected" disabled="disabled">Choose Payments Status
                                                </option>
                                                <option value="PENDING">PENDING</option>
                                                <option value="CLOSED">CLOSED</option>
                                            </select>
                                        </div>
                                        <!-- /.form-group -->
                                    </div>
                                    <!--/.col -->
                                    <div class="col-md-4">
                                        <button type="button" name="filter" id="filtePaymentStatus"
                                            class="btn btn-primary">Filter</button>
                                        <button type="button" name="refreshPaymentStatus" id="refresh"
                                            class="btn btn-default">Refresh</button>

                                        <button type="submit" class="btn btn-primary">
                                            Get Excel
                                        </button>
                                    </div>
                                    <!--/.col -->
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!--/.col -->
            </div>
            <!--/.row -->

            <div class="row filterReportsByOrdersRow">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('admin.clinics.reports.export') }}" method="GET">
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <select id="ordersStatus" name="order_status" class="form-control select2"
                                                style="width: 100%;">
                                                <option selected="selected" disabled="disabled">
                                                    Select Order Status
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
                                    <!--/.col -->
                                    <div class="col-md-4">
                                        <button type="button" name="filter" id="filteOrderStatus"
                                            class="btn btn-primary">Filter</button>
                                        <button type="button" name="refreshOrderStatus" id="refresh"
                                            class="btn btn-default">Refresh</button>

                                        <button type="submit" class="btn btn-primary">
                                            Get Excel
                                        </button>
                                    </div>
                                    <!--/.col -->
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
                            <table id="reportsData" class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>Clinic Name</th>
                                        <th>Patient Name</th>
                                        <th>Appointment Date</th>
                                        <th>Client Type</th>
                                        <th>Insurance Name</th>
                                        <th>Scheme Name</th>
                                        <th>Scheduled Date</th>
                                        <th>Doctor / Optometrist</th>
                                        <th>Bill Status</th>
                                        <th>Consultation Fee</th>
                                        <th>Claimed Amount</th>
                                        <th>Agreed Amount</th>
                                        <th>Paid Amount</th>
                                        <th>Order Date</th>
                                        <th>Order Status</th>
                                        <th>Workshop Name</th>
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

            find_reports();

            function find_reports(from_date = '', to_date = '', payment_status = '', order_status = '') {
                var path = '{{ route('admin.clinics.reports.index') }}';
                $('#reportsData').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: path,
                        data: {
                            from_date: from_date,
                            to_date: to_date,
                            payment_status: payment_status,
                            order_status: order_status
                        }
                    },
                    columns: [{
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex'
                        },
                        {
                            data: "clinic",
                            name: "clinic",
                        },
                        {
                            data: 'full_name',
                            name: 'full_name'
                        },
                        {
                            data: 'appointment_date',
                            name: 'appointment_date'
                        },
                        {
                            data: 'type',
                            name: 'type'
                        },
                        {
                            data: 'insurance',
                            name: 'insurance'
                        },
                        {
                            data: 'scheme',
                            name: 'scheme'
                        },
                        {
                            data: 'scheduled_date',
                            name: 'scheduled_date'
                        },
                        {
                            data: 'doctor_full_name',
                            name: 'doctor_full_name'
                        },
                        {
                            data: 'bill_status',
                            name: 'bill_status'
                        },
                        {
                            data: 'consultation_fee',
                            name: 'consultation_fee'
                        },
                        {
                            data: 'claimed_amount',
                            name: 'claimed_amount'
                        },
                        {
                            data: 'agreed_amount',
                            name: 'agreed_amount'
                        },
                        {
                            data: 'paid_amount',
                            name: 'paid_amount'
                        },
                        {
                            data: 'order_date',
                            name: 'order_date'
                        },
                        {
                            data: 'order_status',
                            name: 'order_status'
                        },
                        {
                            data: 'workshop',
                            name: 'workshop'
                        }
                    ],
                    'responsive': true,
                    'autoWidth': false,
                });
            }

            $('.filterReportsByDatesRow').fadeOut(500);
            $('.filterReportsByPaymentsRow').fadeOut(500);
            $('.filterReportsByOrdersRow').fadeOut(500);

            $(document).on('click', '#refresh', function(e) {
                e.preventDefault();
                $('#fromDate').val('');
                $('#toDate').val('')
                $('#reportsData').DataTable().destroy();
                find_reports();
            });

            $(document).on('click', '#refreshReportsAllReports', function(e) {
                e.preventDefault();
                $('.filterReportsByDatesRow').fadeOut(500);
                $('.filterReportsByPaymentsRow').fadeOut(500);
                $('.filterReportsByOrdersRow').fadeOut(500);
                setTimeout(() => {
                    location.reload();
                }, 1000);
            });

            $(document).on('click', '#filterReportsByDate', function(e) {
                e.preventDefault();
                $('.filterReportsByDatesRow').fadeIn(800);
                $('.filterReportsByPaymentsRow').fadeOut(500);
                $('.filterReportsByOrdersRow').fadeOut(500);
            });

            $(document).on('click', '#filter', function(e) {
                e.preventDefault();
                var from_date = $('#fromDate').val();
                var to_date = $('#toDate').val();
                if (from_date != '' && to_date != '') {
                    $('#reportsData').DataTable().destroy();
                    find_reports(from_date, to_date);
                } else {
                    toastr.error('Both Date is required');
                }
            });

            $(document).on('click', '#filterReportsByPayments', function(e) {
                e.preventDefault();
                $('.filterReportsByDatesRow').fadeOut(500);
                $('.filterReportsByPaymentsRow').fadeIn(800);
                $('.filterReportsByOrdersRow').fadeOut(500);
            });

            $(document).on('click', '#filtePaymentStatus', function(e) {
                e.preventDefault();
                let paymentStatus = $('#paymentStatus').val();
                if (paymentStatus != null) {
                    $('#reportsData').DataTable().destroy();
                    find_reports(from_date = '', to_date = '', paymentStatus);
                } else {
                    toastr.warning("Please select a Payment Status");
                }
            });

            $(document).on('click', '#filterReportsByOrders', function(e) {
                e.preventDefault();
                $('.filterReportsByDatesRow').fadeOut(500);
                $('.filterReportsByPaymentsRow').fadeOut(500);
                $('.filterReportsByOrdersRow').fadeIn(800);
            });

            $(document).on('click', '#filteOrderStatus', function(e) {
                e.preventDefault();
                let orderStatus = $('#ordersStatus').val();
                if (orderStatus != null) {
                    $('#reportsData').DataTable().destroy();
                    find_reports(from_date = '', to_date = '', payment_status = '', orderStatus);
                } else {
                    toastr.warning("Please select an Order Status");
                }
            });

        });
    </script>
@endpush
