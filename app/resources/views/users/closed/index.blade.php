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
                            {{ $page_title }}
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
                <div class="col-12">

                    <div class="card card-primary card-outline card-outline-tabs">
                        <div class="card-header p-0 border-bottom-0">
                            <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="custom-tabs-four-home-tab" data-toggle="pill"
                                        href="#custom-tabs-four-home" role="tab" aria-controls="custom-tabs-four-home"
                                        aria-selected="true">
                                        My Scheduled Closed Bills
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="custom-tabs-four-profile-tab" data-toggle="pill"
                                        href="#custom-tabs-four-profile" role="tab"
                                        aria-controls="custom-tabs-four-profile" aria-selected="false">
                                        All Closed Bills
                                    </a>
                                </li>

                            </ul>
                        </div>
                        <div class="card-body">
                            <div class="tab-content" id="custom-tabs-four-tabContent">

                                <div class="tab-pane fade show active" id="custom-tabs-four-home" role="tabpanel"
                                    aria-labelledby="custom-tabs-four-home-tab">
                                    <div class="table-responsive">
                                        <table id="scheduledClosedBillsData" class="table table-bordered table-striped table-hover">
                                            <thead>
                                                <tr>
                                                    <th></th>
                                                    <th>Invoice Number</th>
                                                    <th>Patient Names</th>
                                                    <th>Open Date</th>
                                                    <th>Total Amount</th>
                                                    <th>Total Paid</th>
                                                    <th>Closed Date</th>
                                                    <th>Doctor/ Optimetrist</th>
                                                    <th>Action</th>
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
                                        <table id="closedBillsData" class="table table-bordered table-striped table-hover">
                                            <thead>
                                                <tr>
                                                    <th></th>
                                                    <th>Invoice Number</th>
                                                    <th>Patient Names</th>
                                                    <th>Open Date</th>
                                                    <th>Total Amount</th>
                                                    <th>Total Paid</th>
                                                    <th>Closed Date</th>
                                                    <th>Doctor/Optimetrist</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.card -->
                    </div>
                    <!--/.card -->
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </section><!-- /.content -->
@endsection
@push('scripts')
    <script>
        $(document).ready(function() {

            find_closed_bills();

            function find_closed_bills() {
                var path = '{{ route('users.payments.close.bills.index') }}';
                $('#closedBillsData').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: path,
                    columns: [{
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex'
                        },
                        {
                            data: 'invoice_number',
                            name: 'invoice_number'
                        },
                        {
                            data: 'full_names',
                            name: 'full_names'
                        },
                        {
                            data: 'open_date',
                            name: 'open_date'
                        },
                        {
                            data: 'total_amount',
                            name: 'total_amount'
                        },
                        {
                            data: 'total_paid',
                            name: 'total_paid'
                        },
                        {
                            data: 'close_date',
                            name: 'close_date'
                        },
                        {
                            data: 'doctor',
                            name: 'doctor'
                        },
                        {
                            data: 'action',
                            name: 'action',
                            orderable: false,
                            searchable: false
                        }
                    ],
                    "autoWidth": false,
                    "responsive": true,
                });
            }

            find_scheduled_closed_bills();
            function find_scheduled_closed_bills() {
                var path = '{{ route('users.payments.close.bills.scheduled') }}';
                $('#scheduledClosedBillsData').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: path,
                    columns: [{
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex'
                        },
                        {
                            data: 'invoice_number',
                            name: 'invoice_number'
                        },
                        {
                            data: 'full_names',
                            name: 'full_names'
                        },
                        {
                            data: 'open_date',
                            name: 'open_date'
                        },
                        {
                            data: 'total_amount',
                            name: 'total_amount'
                        },
                        {
                            data: 'total_paid',
                            name: 'total_paid'
                        },
                        {
                            data: 'close_date',
                            name: 'close_date'
                        },
                        {
                            data: 'doctor',
                            name: 'doctor'
                        },
                        {
                            data: 'action',
                            name: 'action',
                            orderable: false,
                            searchable: false
                        }
                    ],
                    "autoWidth": false,
                    "responsive": true,
                });
            }


            $(document).on('click', '.viewBtn', function(e) {
                e.preventDefault();
                let bill_id = $(this).data('id');
                let path = '{{ route('users.payments.close.bills.show', ':paymentBill') }}';
                path = path.replace(':paymentBill', bill_id);
                $.ajax({
                    url: path,
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        if (data['status']) {
                            let url = '{{ route('users.payments.close.bills.view', ':paymentBill') }}';
                            url = url.replace(':paymentBill', data['data']['id']);
                            setTimeout(() => {
                                window.location.href = url;
                            }, 500);
                        }
                    },
                });
            });
        });
    </script>
@endpush
