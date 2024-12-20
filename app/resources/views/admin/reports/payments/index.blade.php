@extends('admin.layouts.temp')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Payments Report</h1>
                    <small>{{ $clinic->clinic }}</small>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.dashboard.index', $clinic->id) }}">Home</a>
                        </li>
                        <li class="breadcrumb-item active">Payments Report</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <button id="filterByDatesBtn" class="btn btn-outline-primary"> Filter By Dates </button>
                            <button id="filterByStatusBtn" class="btn btn-outline-primary"> Filter By Status </button>
                            <button id="refreshReportsAllReports" class="btn btn-outline-primary">
                                <i class="fa fa-refresh"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <!--/.row_-->

            <div class="row fliterByDatesRow">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('admin.payments.reports.export', $clinic->id) }}" method="GET">
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
            <!--/.row -->

            <div class="row filterReportsByStatusRow">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('admin.payments.reports.export', $clinic->id) }}" method="GET">
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <select id="paymentStatus" name="bill_status" class="form-control select2"
                                                style="width: 100%;">
                                                <option selected="selected" disabled="disabled">Choose Payments Status
                                                </option>
                                                <option value="OPEN">OPENING</option>
                                                <option value="PENDING">PENDING</option>
                                                <option value="CLOSED">CLOSED</option>
                                            </select>
                                        </div>
                                        <!-- /.form-group -->
                                    </div>
                                    <!--/.col -->
                                    <div class="col-md-4">
                                        <button type="button" name="filter" id="filtePaymentStatusBtn"
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

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body table-responsive">
                            <table id="paymentsReportData" class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>Open Date</th>
                                        <th>Patient Names</th>
                                        <th>Consultation Fee</th>
                                        <th>Bill Status</th>
                                        <th>Claimed Amount</th>
                                        <th>Agreed Amount</th>
                                        <th>Total Amount</th>
                                        <th>Paid Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div><!-- /.card-body -->
                    </div><!-- /.card -->
                </div>
            </div>
        </div>
        <!--/.container-fluid -->
    </section>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {

            find_payments_report();

            function find_payments_report(from_date = '', to_date = '', bill_status='') {
                let path = '{{ route('admin.payments.reports.index', $clinic->id) }}';
                $('#paymentsReportData').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: path,
                        data:{
                            from_date : from_date ,
                            to_date :to_date,
                            bill_status: bill_status
                        }
                    },
                    columns: [{
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex'
                        },
                        {
                            data: 'open_date',
                            name: 'open_date'
                        },
                        {
                            data: 'patient_names',
                            name: 'patient_names'
                        },
                        {
                            data: 'consultation_fee',
                            name: 'consultation_fee',
                        },
                        {
                            data: 'bill_status',
                            name: 'bill_status',
                        },
                        {
                            data: 'claimed_amount',
                            name: 'claimed_amount',
                        },
                        {
                            data: 'agreed_amount',
                            name: 'agreed_amount'
                        },
                        {
                            data: 'total_amount',
                            name: 'total_amount'
                        },
                        {
                            data: 'paid_amount',
                            name: 'paid_amount'
                        },
                    ],
                    "autoWidth": false,
                    "responsive": true,
                });
            }

            $('.fliterByDatesRow').fadeOut(500);
            $('.filterReportsByStatusRow').fadeOut(500);

            $(document).on('click', '#refreshReportsAllReports', function(e) {
                e.preventDefault();
                $('.fliterByDatesRow').fadeOut(500);
                $('.filterReportsByStatusRow').fadeOut(500);
                setTimeout(() => {
                    location.reload();
                }, 1000);
            });

            $(document).on('click', '#refresh', function(e) {
                e.preventDefault();
                $('#fromDate').val('');
                $('#toDate').val('');
                $('#paymentStatus').val('').change();
                $('#paymentsReportData').DataTable().destroy();
                find_payments_report();
            });

            // Reports By Dates
            $(document).on('click', '#filterByDatesBtn', function(e) {
                e.preventDefault();
                $('.fliterByDatesRow').fadeIn(800);
                $('.filterReportsByStatusRow').fadeOut(500);
            });

            $(document).on('click', '#filter', function(e) {
                e.preventDefault();
                var from_date = $('#fromDate').val();
                var to_date = $('#toDate').val();
                if (from_date != '' && to_date != '') {
                    $('#paymentsReportData').DataTable().destroy();
                    find_payments_report(from_date, to_date);
                } else {
                    toastr.error('Both Date is required');
                }
            });

            // Reports By Status
            $(document).on('click', '#filterByStatusBtn', function(e) {
                e.preventDefault();
                $('.fliterByDatesRow').fadeOut(500);
                $('.filterReportsByStatusRow').fadeIn(800);
            });

            $(document).on('click', '#filtePaymentStatusBtn', function(e) {
                e.preventDefault();
                let bill_status = $('#paymentStatus').val();
                if (bill_status != null) {
                    $('#paymentsReportData').DataTable().destroy();
                    find_payments_report(from_date = '', to_date = '', bill_status);
                } else {
                    toastr.error('Please select bill status');
                }
            });


            


        });
    </script>
@endpush
