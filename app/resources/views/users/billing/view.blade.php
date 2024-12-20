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
                        <li class="breadcrumb-item">
                            <a href="{{ route('users.payments.bills.index') }}">
                                Payment Bills
                            </a>
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
                    <!-- Main content -->
                    <div class="invoice p-3 mb-3">
                        <!-- title row -->
                        <div class="row">
                            <div class="col-12">
                                <h4>
                                    <i class="fa fa-globe"></i> {{ $payment_bill->clinic->clinic }}
                                    <small class="float-right">Open Date:
                                        {{ date('d-m-Y', strtotime($payment_bill->open_date)) }}</small>
                                </h4>
                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- info row -->

                        <div class="row invoice-info">
                            <div class="col-sm-4 invoice-col">
                                From
                                <address>
                                    <strong>{{ $payment_bill->clinic->clinic }}</strong><br>
                                    {{ $payment_bill->clinic->address }}<br>
                                    Phone: {{ $payment_bill->clinic->phone }}<br>
                                    Email: {{ $payment_bill->clinic->email }}
                                </address>
                            </div>
                            <!--.col-sm-4 invoice-col -->

                            <div class="col-sm-4 invoice-col">
                                To
                                <address>
                                    <strong>{{ $payment_bill->patient->first_name }}
                                        {{ $payment_bill->patient->last_name }}</strong><br>
                                    {{ $payment_bill->patient->address }}<br>
                                    Phone: {{ $payment_bill->patient->phone }}<br>
                                    Email: {{ $payment_bill->patient->email }} <br>
                                    @if ($payment_bill->payment_detail->client_type->type == 'Insurance')
                                        Insurance : {{ $payment_bill->payment_detail->insurance->title }}<br>
                                        Scheme: {{ $payment_bill->payment_detail->scheme }}
                                    @endif
                                    Prescription Invoice Number:
                                    {{ $payment_bill->appontment->lens_power->frame_prescription->receipt_number }}
                                </address>
                            </div>
                            <!-- /.col -->

                            <div class="col-sm-4 invoice-col">
                                @if ($payment_bill->invoice_number)
                                    <b>Invoice #{{ $payment_bill->invoice_number }}</b><br>
                                    <br>
                                    <b>LPO #:</b> {{ $payment_bill->lpo_number }}<br>
                                    <b>Open Date:</b> {{ date('d-m-Y', strtotime($payment_bill->open_date)) }}<br>
                                @endif
                                <b>Bill Status:</b>
                                @if ($payment_bill->bill_status == 'PENDING')
                                    <span class="badge badge-warning">
                                        {{ $payment_bill->bill_status }}
                                    </span>
                                @else
                                    <span class="badge badge-success">
                                        {{ $payment_bill->bill_status }}
                                    </span>
                                @endif
                            </div>
                            <!-- /.col -->

                        </div>
                        <!--.row -->
                        <hr>
                        <div class="row">
                            <div class="col-md-6">
                                <h5>Consultation Fee:</h5>
                                <p class="text-lead">
                                    <strong>
                                        {{ number_format($payment_bill->consultation_fee, 2, '.', ',') }}
                                    </strong>
                                </p>
                            </div>
                            <div class="col-md-6">
                                <h5>Consultation Receipt Number:</h5>
                                <p class="text-lead">
                                    <strong>
                                        {{ $payment_bill->consultation_receipt_number }}
                                    </strong>
                                </p>
                            </div>
                        </div>
                        <!--.row -->

                        <!-- Table row -->
                        <div class="row">
                            <h5>Payments</h5>
                            <div class="col-12 table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Item</th>
                                            <th>Receipt #</th>
                                            <th>Amount</th>
                                            <th>Paid Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($payment_bill->billing as $billing)
                                            <tr>
                                                <td>{{ $billing->item }}</td>
                                                <td>{{ $billing->receipt_number }}</td>
                                                <td>{{ number_format($billing->amount, 2, '.', ',') }}</td>
                                                <td>{{ date('d-M-Y', strtotime($billing->date)) }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4">
                                                    <p class="text-center">No Payments</p>
                                                </td>
                                            </tr>
                                        @endforelse

                                    </tbody>
                                </table>
                            </div>
                            <!-- /.col -->
                        </div>
                        <!--.row -->

                        <br>
                        <div class="row">
                            <!-- accepted payments column -->
                            <div class="col-12 col-md-6">
                                <p class="lead">Client Type:</p>
                                @if ($payment_bill->payment_detail->insurance)
                                    {{ $payment_bill->payment_detail->client_type->type }}:
                                    {{ $payment_bill->payment_detail->insurance->title }} <br>
                                    Approval Number: {{ $payment_bill->approval_number }} <br>
                                    Approval Status: @if ($payment_bill->approval_status == 'APPROVED')
                                        <span class="badge badge-success">{{ $payment_bill->approval_status }}</span>
                                    @elseif ($payment_bill->approval_status == 'PENDING')
                                        <span class="badge badge-warning">{{ $payment_bill->approval_status }}</span>
                                    @else
                                        <span class="badge badge-danger">{{ $payment_bill->approval_status }}</span>
                                    @endif
                                    <br>
                                @else
                                    {{ $payment_bill->payment_detail->client_type->type }}
                                @endif
                                <br><br>
                                <h5>Remarks</h5>
                                <p class="text-muted well well-sm shadow-none" style="margin-top: 10px;">
                                    {{ $payment_bill->remarks }}
                                </p>
                                <br><br>
                                <h5>Doctor/Optometrist</h5>
                                <p class="text-muted well well-sm shadow-none" style="margin-top: 10px;">
                                    {{ $payment_bill->user->first_name }} {{ $payment_bill->user->last_name }}
                                </p>
                            </div>
                            <!--.col-12 col-md-6 -->

                            <div class="col-12 col-md-6">

                                @if ($payment_bill->closing_date)
                                    <p class="lead">
                                        Closing Date: {{ date('d-m-Y', strtotime($payment_bill->close_date)) }}
                                    </p>
                                @endif

                                <div class="table-responsive">

                                    <table class="table">

                                        <tr>
                                            <th style="width:50%">
                                                Claimed Amount
                                            </th>
                                            <td>
                                                {{ number_format($payment_bill->claimed_amount, 2, '.', ',') }}
                                            </td>
                                        </tr>
                                        <tr>
                                            @if ($payment_bill->approval_status == 'REJECTED')
                                                <th>
                                                    Rejected Amount
                                                </th>
                                            @else
                                                <th>
                                                    Agreed Amount
                                                </th>
                                            @endif
                                            <td>
                                                {{ number_format($payment_bill->agreed_amount, 2, '.', ',') }}
                                            </td>
                                        </tr>

                                        <tr>
                                            <th>
                                                Total Amount <br>
                                                <small>Including consultation fee</small>
                                            </th>
                                            <td>
                                                {{ number_format($payment_bill->total_amount, 2, '.', ',') }}
                                            </td>
                                        </tr>

                                        <tr>
                                            <th>
                                                Paid Amount
                                                <br>
                                                <small>Including consultation fee</small>
                                            </th>
                                            <td>
                                                {{ number_format($payment_bill->paid_amount, 2, '.', ',') }}
                                            </td>
                                        </tr>

                                        <tr>
                                            <th>Balance</th>
                                            <td>
                                                {{ number_format($payment_bill->balance, 2, '.', ',') }}
                                            </td>
                                        </tr>

                                    </table>

                                </div>

                            </div>
                            <!--.col-12 col-md-6 -->
                        </div>
                        <!--.row -->

                        @if ($payment_bill->user_id !== null && Auth::user()->id == $payment_bill->user->id)
                            <!-- this row will not appear when printing -->
                            <div class="row no-print">

                                <div class="col-12">

                                    <a href="{{ route('users.payments.bills.edit', $payment_bill->id) }}"
                                        class="btn btn-default">
                                        <i class="fa fa-edit"></i> Edit
                                    </a>

                                    @if ($payment_bill->balance <= 0)
                                        <button type="button" data-id="{{ $payment_bill->id }}"
                                            class="btn btn-danger float-right closeBillBtn" style="margin-right: 5px;">
                                            <i class="fa fa-close "></i> Close Bill
                                        </button>
                                    @endif


                                    @if ($payment_bill->approval_status == 'APPROVED')
                                        @if ($payment_bill->order)
                                            <a href="#" data-id="{{ $payment_bill->order->id }}"
                                                class="btn btn-primary float-right viewOrderBtn" style="margin-right: 5px;">
                                                <i class="fa fa-sticky-note"></i> View Order
                                            </a>
                                        @else
                                            @if ($treatment->lens_power)
                                                <button type="button" data-id="{{ $payment_bill->id }}"
                                                    data-lens_power='{{ $payment_bill->doctor_schedule->lens_power->id }}'
                                                    data-workshop="{{ $payment_bill->doctor_schedule->lens_power->frame_prescription->workshop->id }}"
                                                    class="btn btn-success float-right proceedOrdersBtn"
                                                    style="margin-right: 5px;">
                                                    <i class="fa fa-check"></i> Proceed to Orders
                                                </button>
                                            @endif
                                        @endif
                                    @endif

                                    <button type="button" data-id="{{ $payment_bill->id }}"
                                        class="btn btn-warning float-right printPaymentsBtn " style="margin-right: 5px;">
                                        <i class="fa fa-print"></i> Print
                                    </button>

                                </div>
                                <!--.col-12 -->

                            </div>
                            <!--.row no-print -->
                        @endif

                    </div>
                    <!--.invoice p-3 mb-3  -->
                </div>
            </div>
            <!--.row -->

        </div>
        <!--.container-fluid -->

        <!-- /send bill to remittance -->
        <div class="modal fade" id="closeBillModal">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">
                            CLose This Bill
                        </h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="closeBillForm">
                        <div class="modal-body">
                            @csrf
                            <div class="form-group">
                                <input type="hidden" id="closeBillId" name="bill_id" class="form-control">
                            </div>

                            <div class="form-group">
                                <label for="closeBillInvoiceNumber">
                                    Invoice Number
                                </label>
                                <input type="text" name="invoice_number" class="form-control"
                                    id="closeBillInvoiceNumber" placeholder="Enter Bill Invoice Number">
                            </div>

                            <div class="form-group">
                                <label for="closeBillLPONumber">
                                    LPO Number
                                </label>
                                <input type="text" name="lpo_number" class="form-control" id="closeBillLPONumber"
                                    placeholder="Enter Bill LPO Number">
                            </div>

                            <div class="form-group">
                                <label for="closeBillCloseDate">
                                    Close Date
                                </label>
                                <input type="text" name="close_date" class="form-control datepicker"
                                    id="closeBillCloseDate" placeholder="Remittance Date">
                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" id="closeBillSubmitBtn" class="btn btn-primary">
                                Save
                            </button>
                        </div>
                    </form>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->

    </section>
    <!-- /.content -->
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {

            $(document).on('click', '.proceedOrdersBtn', function(e) {
                e.preventDefault();
                var bill_id = $(this).data('id');
                var workshop_id = $(this).data('workshop');
                var lens_power_id = $(this).data('lens_power');
                var token = '{{ csrf_token() }}';
                var path = '{{ route('users.orders.store') }}';
                $.ajax({
                    url: path,
                    type: 'POST',
                    data: {
                        _token: token,
                        bill_id: bill_id,
                        workshop_id: workshop_id,
                        lens_power_id: lens_power_id
                    },
                    success: function(data) {
                        if (data['status']) {
                            find_order_track(data['order_id']);
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


            function find_order_track(order_id) {

                var path = '{{ route('users.order.track.store') }}';
                var token = '{{ csrf_token() }}';
                $.ajax({
                    url: path,
                    type: 'POST',
                    data: {
                        _token: token,
                        order_id: order_id
                    },
                    success: function(data) {
                        if (data['status']) {
                            toastr.success(data.message);
                            let url = '{{ route('users.orders.view', ':id') }}';
                            url = url.replace(':id', order_id);
                            setTimeout(function() {
                                window.location.href = url;
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
            }

            $(document).on('click', '.editPaymentBill', function(e) {
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
                            let edit_path =
                                '{{ route('users.payments.bills.edit', ':paymentBill') }}';
                            edit_path = edit_path.replace(':paymentBill', data['data']['id']);
                            setTimeout(() => {
                                window.location.href = edit_path;
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

            $(document).on('click', '.printPaymentsBtn', function(e) {
                e.preventDefault();
                let bill_id = $(this).data('id');
                let path = '{{ route('users.payments.bills.show', ':paymentBill') }}';
                path = path.replace(':paymentBill', bill_id);
                $.ajax({
                    url: path,
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        if (data['status']) {
                            let url =
                                '{{ route('users.payments.bills.print', ':paymentBill') }}';
                            url = url.replace(':paymentBill', data['data']['id']);
                            setTimeout(() => {
                                window.open(url, "mywindow",
                                    "status=1,toolbar=1");
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
                    }
                });
            });

            // close date
            $(document).on('click', '.closeBillBtn', function(e) {
                e.preventDefault();
                let bill_id = $(this).data('id');
                let path = '{{ route('users.payments.bills.show', ':paymentBill') }}';
                path = path.replace(':paymentBill', bill_id);
                $.ajax({
                    url: path,
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        if (data['status']) {
                            $('#closeBillId').val(data['data']['id']);
                            $('#closeBillModal').modal('show');
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
                    }
                });
            });

            $('#closeBillForm').submit(function(e) {
                e.preventDefault();
                var form = $(this);
                var formData = new FormData(form[0]);
                var path = '{{ route('users.payments.close.bills.store', $payment_bill->id) }}';
                $.ajax({
                    url: path,
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    beforeSend: function() {
                        $('#closeBillSubmitBtn').html(
                            '<i class="fa fa-spinner fa-spin"></i>');
                        $('#closeBillSubmitBtn').attr('disabled', true);
                    },
                    complete: function() {
                        $('#closeBillSubmitBtn').html('Save');
                        $('#closeBillSubmitBtn').attr('disabled', false);
                    },
                    success: function(data) {
                        if (data['status']) {
                            toastr.success(data['message']);
                            $('#closeBillForm')[0].reset();
                            $('#closeBillModal').modal('hide');
                            let url = '{{ route('users.payments.close.bills.index') }}';
                            setTimeout(function() {
                                window.location.href = url;
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
                    }
                });
            });

            // view order
            $(document).on('click', '.viewOrderBtn', function(e) {
                e.preventDefault();
                let order_id = $(this).data('id');
                let path = '{{ route('users.orders.show', ':order') }}';
                path = path.replace(':order', order_id);
                $.ajax({
                    url: path,
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        if (data['status']) {
                            let url = '{{ route('users.orders.view', ':order') }}';
                            url = url.replace(':order', data['data']['id']);
                            setTimeout(() => {
                                window.location.href = url;
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
                    }
                });
            });

        });
    </script>
@endpush
