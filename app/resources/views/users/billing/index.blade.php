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
                                        My Schedules Payment Bills
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="custom-tabs-four-profile-tab" data-toggle="pill"
                                        href="#custom-tabs-four-profile" role="tab"
                                        aria-controls="custom-tabs-four-profile" aria-selected="false">
                                        All Payment Bills
                                    </a>
                                </li>

                            </ul>
                        </div>
                        <div class="card-body">
                            <div class="tab-content" id="custom-tabs-four-tabContent">

                                <div class="tab-pane fade show active" id="custom-tabs-four-home" role="tabpanel"
                                    aria-labelledby="custom-tabs-four-home-tab">
                                    <div class="table-responsive">
                                        <table id="scheduledPaymentsBillsData"
                                            class="table table-bordered table-striped table-hover">
                                            <thead>
                                                <tr>
                                                    <th></th>
                                                    <th>Open Date</th>
                                                    <th>Patient Names</th>
                                                    <th>Bill Status</th>
                                                    <th>DOctor/ Optimetrist</th>
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
                                    <table id="paymentsBillsData" class="table table-bordered table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th>Open Date</th>
                                                <th>Patient Names</th>
                                                <th>Bill Status</th>
                                                <th>DOctor/ Optimetrist</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
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

            find_payment_bills();

            function find_payment_bills() {
                var path = '{{ route('users.payments.bills.index') }}';
                $('#paymentsBillsData').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: path,
                    columns: [{
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex'
                        },
                        {
                            data: 'open_date',
                            name: 'open_date',
                        },
                        {
                            data: 'full_names',
                            name: 'full_names'
                        },
                        {
                            data: 'bill_status',
                            name: 'bill_status'
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
                        },
                    ],
                    "autoWidth": false,
                    "responsive": true,
                });
            }

            find_scheduled_payment_bills();
            function find_scheduled_payment_bills() {
                var path = '{{ route('users.payments.bills.scheduled.payments') }}';
                $('#scheduledPaymentsBillsData').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: path,
                    columns: [{
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex'
                        },
                        {
                            data: 'open_date',
                            name: 'open_date',
                        },
                        {
                            data: 'full_names',
                            name: 'full_names'
                        },
                        {
                            data: 'bill_status',
                            name: 'bill_status'
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
                        },
                    ],
                    "autoWidth": false,
                    "responsive": true,
                });
            }

            $(document).on('click', '.viewPaymentBill', function(e) {
                e.preventDefault();
                let bill_id = $(this).attr('data-id');
                let path = '{{ route('users.payments.bills.show', ':paymentBill') }}';
                path = path.replace(':paymentBill', bill_id);
                $.ajax({
                    url: path,
                    type: 'GET',
                    dataType: "json",
                    success: function(data) {
                        if (data['status']) {
                            let view_url =
                                '{{ route('users.payments.bills.view', ':paymentBill') }}';
                            view_url = view_url.replace(':paymentBill', data['data']['id']);
                            setTimeout(() => {
                                window.location.href = view_url;
                            }, 500);
                        }
                    },
                    error: function(data) {
                        var errors = data.responseJSON;
                        var errorsHtml = '<ul>';
                        $.each(errors['errors'], function(key, value) {
                            errorsHtml += '<li>' + value + '</li>';
                        });
                        errorsHtml += '</ul>';
                        toastr.error(errorsHtml);
                    },
                });
            });

            $(document).on('click', '.editPaymentBill', function(e) {
                e.preventDefault();
                let bill_id = $(this).attr('data-id');
                let path = '{{ route('users.payments.bills.show', ':paymentBill') }}';
                path  = path.replace(':paymentBill', bill_id);
                $.ajax({
                    url: path,
                    type: 'GET',
                    dataType: "json",
                    success: function(data) {
                        if (data['status']) {
                            let edit_path = '{{ route('users.payments.bills.edit', ':paymentBill') }}';
                            edit_path = edit_path.replace(':paymentBill', data['data']['id']);
                            setTimeout(() => {
                                window.location.href = edit_path;
                            }, 1000);
                        }
                    },
                    error: function(data) {
                        var errors = data.responseJSON;
                        var errorsHtml = '<ul>';
                        $.each(errors['errors'], function(key, value) {
                            errorsHtml += '<li>' + value + '</li>';
                        });
                        errorsHtml += '</ul>';
                        toastr.error(errorsHtml);
                    },
                });
            });

        });
    </script>
@endpush
