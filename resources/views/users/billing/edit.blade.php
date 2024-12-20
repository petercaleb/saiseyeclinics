@extends('users.layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Update Bill</h1>
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
                            Update Bill
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
                            <!-- /.col -->

                            <div class="col-sm-4 invoice-col">
                                To
                                <address>
                                    <strong>{{ $payment_bill->patient->first_name }}
                                        {{ $payment_bill->patient->last_name }}</strong><br>
                                    {{ $payment_bill->patient->address }}<br>
                                    Phone: {{ $payment_bill->patient->phone }}<br>
                                    Email: {{ $payment_bill->patient->email }}
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
                        <!-- /.row -->

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
                        <!-- /.row -->

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
                            </div>
                            <!-- /.col -->

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
                            <!-- /.col -->
                        </div>
                        <!-- /.row -->

                        <!-- this row will not appear when printing -->
                        <div class="row no-print">
                            <div class="col-12">
                                @if ($payment_bill->user_id !== null && Auth::user()->id == $payment_bill->user_id)
                                    @if ($payment_bill->claimed_amount > 0 && $payment_bill->agreed_amount <= 0)
                                        <a href="#" data-id='{{ $payment_bill->id }}'
                                            class="btn btn-default enterAgreedAmountBtn">
                                            <i class="fa fa-money"></i> Enter Agreed Amount
                                        </a>
                                    @endif
                                @endif


                                <!-- Consultation Fee Button  incase amount is rejected-->
                                @if ($payment_bill->user_id !== null && Auth::user()->id == $payment_bill->user_id)
                                    @if ($payment_bill->payment_detail->insurance)
                                        @if ($payment_bill->approval_status == 'REJECTED')
                                            <!--Check if consultation fee was paid -->
                                            @if ($payment_bill->consultation_fee == 0)
                                                <a href="#" data-id='{{ $payment_bill->id }}'
                                                    class="btn btn-warning rejectedInsuranceBtn">
                                                    <i class="fa fa-check"></i> Consultation Fee
                                                </a>
                                            @endif
                                        @endif
                                    @endif

                                    @if ($payment_bill->payment_detail->insurance)
                                        @if ($payment_bill->approval_status != 'REJECTED')
                                            @if ($payment_bill->balance > 0)
                                                <button type="button" id="{{ $payment_bill->id }}"
                                                    class="btn btn-success float-right addPaymentsBtn">
                                                    <i class="fa fa-credit-card"></i> Submit Payment
                                                </button>
                                            @else
                                                <a href="{{ route('users.payments.bills.view', $payment_bill->id) }}"
                                                    class="btn btn-default float-right" style="margin-right: 5px;">
                                                    <i class="fa fa-eye"></i> View Bill
                                                </a>
                                            @endif
                                        @endif
                                    @else
                                        @if ($payment_bill->balance > 0)
                                            <button type="button" id="{{ $payment_bill->id }}"
                                                class="btn btn-success float-right addPaymentsBtn">
                                                <i class="fa fa-credit-card"></i> Submit Payment
                                            </button>
                                        @else
                                            <a href="{{ route('users.payments.bills.view', $payment_bill->id) }}"
                                                class="btn btn-default float-right" style="margin-right: 5px;">
                                                <i class="fa fa-eye"></i> View Bill
                                            </a>
                                        @endif
                                    @endif
                                @endif

                            </div>
                        </div>
                        <!-- /.row -->

                    </div>
                    <!-- /.invoice -->
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->


        <div class="modal fade" id="addPaymentsModal">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Payment Bills</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="addPaymentsForm" role="form">
                        <div class="modal-body">
                            @csrf
                            <div class="form-group">
                                <input type="hidden" class="form-control" id="addPaymentsBillId" name="bill_id" />
                            </div>
                            <div class="form-group">
                                <label for="addPaymentsItem">Item</label>
                                <select name="item" id="addPaymentsItem" class="form-control select2">
                                    <option disabled selected>Enter the item name</option>
                                    <option value="SERVICE FEE">SERVICE FEE</option>
                                    <option value="DEPOSIT ONE">DEPOSIT ONE</option>
                                    <option value="DEPOSIT TWO">DEPOSIT TWO</option>
                                    <option value="BALANCE">BALANCE</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="addPaymentsAmount">Payment Amount</label>
                                <input type="text" class="form-control" id="addPaymentsAmount" name="amount"
                                    placeholder="Enter the amount paid" />
                            </div>
                            <div class="form-group">
                                <label for="addPaymentsReceipt">Receipt Number</label>
                                <input type="text" class="form-control" id="addPaymentsReceipt" name="receipt"
                                    placeholder="Enter the receipt number" />
                            </div>

                            <div class="form-group">
                                <label for="addPaymentsDate">Paid Date</label>
                                <input type="text" class="form-control datepicker" id="addPaymentsDate"
                                    name="date" placeholder="Enter the paid date" />
                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">
                                Close
                            </button>
                            <button type="submit" id="addPaymentsSubmitBtn" class="btn btn-primary">
                                Add Payment
                            </button>
                        </div>
                    </form>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->

        <div class="modal fade" id="enterAgreedAmountModal">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Payment Bills</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="enterAgreedAmountForm" role="form">
                        <div class="modal-body">
                            @csrf
                            <div class="form-group">
                                <input type="hidden" class="form-control" id="enterAgreedAmountBillId"
                                    name="bill_id" />
                            </div>
                            <div class="form-group">
                                <label for="enterAgreedAmount">Agreed/Rejected Amount</label>
                                <input type="text" class="form-control" id="enterAgreedAmount" name="amount"
                                    placeholder="Enter the agreed amount" value="{{ $payment_bill->claimed_amount }}" />
                            </div>
                            @if ($payment_bill->payment_detail->insurance)
                                <div class="form-group">
                                    <label for="enterAgreedApprovalStatus">Approval Status</label>
                                    <select id="enterAgreedApprovalStatus" name="approval_status"
                                        class="form-control select2" style="width: 100%;">
                                        <option selected="selected" disabled="disabled">Choose the approval status
                                        </option>
                                        <option value="APPROVED">APPROVED</option>
                                        <option value="REJECTED">REJECTED</option>
                                    </select>
                                </div>

                                <div class="form-group approvalCard">
                                    <label for="enterAgreedApprovalCode">Approval Number</label>
                                    <input type="text" class="form-control" id="enterAgreedApprovalCode"
                                        name="approval_number" placeholder="Enter the approval number">
                                </div>
                            @endif

                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">
                                Close
                            </button>
                            <button type="submit" id="enterAgreedAmountSubmitBtn" class="btn btn-primary">
                                Enter
                            </button>
                        </div>
                    </form>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->

        <div class="modal fade" id="rejectedInsuranceModal">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Enter Consultation Fee</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="rejectedInsuranceForm" role="form">
                        <div class="modal-body">
                            @csrf
                            <div class="form-group">
                                <input type="hidden" class="form-control" id="rejectedInsuranceBillId"
                                    name="bill_id" />
                            </div>
                            <div class="form-group">
                                <label for="rejectedInsuranceConsultationFee">Consultation Fee</label>
                                <input type="text" class="form-control" id="rejectedInsuranceConsultationFee"
                                    name="consultation_fee" placeholder="Enter the consultation">
                            </div>

                            <div class="form-group">
                                <label for="rejectedInsuranceConsultationReceipt">Consultation Receipt Number</label>
                                <input type="text" class="form-control" id="rejectedInsuranceConsultationReceipt"
                                    name="consultation_receipt" placeholder="Enter the consultation">
                            </div>

                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">
                                Close
                            </button>
                            <button type="submit" id="rejectedInsuranceSubmitBtn" class="btn btn-primary">
                                Update
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

            $(document).on('click', '.enterAgreedAmountBtn', function(e) {
                e.preventDefault();
                let bill_id = $(this).data('id');
                let path = '{{ route('users.payments.bills.show', ':paymentBill') }}';
                path = path.replace(':paymentBill', bill_id);
                $.ajax({
                    url: path,
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        if (data['status']) {
                            $('#enterAgreedAmountBillId').val(data['data']['id']);
                            $('#enterAgreedAmountModal').modal('show');
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


            $('#enterAgreedAmountForm').submit(function(e) {
                e.preventDefault();
                let form = $(this);
                let formData = new FormData(form[0]);
                let path = '{{ route('users.payments.bills.update.agreed.amount', $payment_bill->id) }}';
                $.ajax({
                    url: path,
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    beforeSend: function() {
                        $('#enterAgreedAmountSubmitBtn').html(
                            '<i class="fa fa-spinner fa-spin"></i>');
                        $('#enterAgreedAmountSubmitBtn').attr('disabled', true);
                    },
                    complete: function() {
                        $('#enterAgreedAmountSubmitBtn').html('Enter');
                        $('#enterAgreedAmountSubmitBtn').attr('disabled', false);
                    },
                    success: function(data) {
                        if (data['status']) {
                            toastr.success(data['message']);
                            $('#enterAgreedAmountForm')[0].reset();
                            $('#enterAgreedAmountModal').modal('hide');
                            setTimeout(() => {
                                location.reload();
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

            /// check approval status to updated approved number
            $('.approvalCard').fadeOut();
            $(document).on('change', '#enterAgreedApprovalStatus', function(e) {
                e.preventDefault();
                var approval_status = $(this).val();
                if (approval_status == 'APPROVED') {
                    $('.approvalCard').fadeIn();
                } else {
                    $('.approvalCard').fadeOut();
                }
            });

            $(document).on('click', '.addPaymentsBtn', function(e) {
                e.preventDefault();
                let payment_bill_id = $(this).attr('id');
                let path = '{{ route('users.payments.bills.show', ':paymentBill') }}';
                path = path.replace(':paymentBill', payment_bill_id);
                $.ajax({
                    url: path,
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        if (data['status']) {
                            $('#addPaymentsBillId').val(data['data']['id']);
                            $('#addPaymentsModal').modal('show');
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

            $('#addPaymentsForm').submit(function(e) {
                e.preventDefault();
                var form = $(this);
                var formData = new FormData(form[0]);
                var path = '{{ route('users.payments.billing.store', $payment_bill->id) }}';
                $.ajax({
                    url: path,
                    type: 'POST',
                    data: formData,
                    dataType: 'json',
                    contentType: false,
                    processData: false,
                    beforeSend: function() {
                        $('#addPaymentsSubmitBtn').html(
                            '<i class="fa fa-spinner fa-spin"></i>');
                        $('#addPaymentsSubmitBtn').attr('disabled', true);
                    },
                    complete: function() {
                        $('#addPaymentsSubmitBtn').html('Add Payment');
                        $('#addPaymentsSubmitBtn').attr('disabled', false);
                    },
                    success: function(data) {
                        if (data['status']) {
                            $('#addPaymentsModal').modal('hide');
                            toastr.success(data['message']);
                            find_total_paid();
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

            function find_total_paid() {
                var bill_id = '{{ $payment_bill->id }}';
                var path = '{{ route('users.payments.billing.update.paid', $payment_bill->id) }}';
                var token = '{{ csrf_token() }}';
                $.ajax({
                    url: path,
                    type: 'POST',
                    data: {
                        '_token': token,
                        'bill_id': bill_id
                    },
                    dataType: 'json',
                    success: function(data) {
                        if (data['status']) {
                            location.reload();
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
            }

            $(document).on('click', '.rejectedInsuranceBtn', function(e) {
                e.preventDefault();
                let bill_id = $(this).data('id');
                let path = '{{ route('users.payments.bills.show', ':paymentBill') }}';
                path = path.replace(':paymentBill', bill_id);
                $.ajax({
                    url: path,
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        if (data['status']) {
                            $('#rejectedInsuranceBillId').val(data['data']['id']);
                            $('#rejectedInsuranceModal').modal('show');
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

            $('#rejectedInsuranceForm').submit(function(e) {
                e.preventDefault();
                var form = $(this);
                var formData = new FormData(form[0]);
                var path = '{{ route('users.payments.bills.update.consultation') }}';
                $.ajax({
                    url: path,
                    type: 'POST',
                    data: formData,
                    dataType: 'json',
                    contentType: false,
                    processData: false,
                    beforeSend: function() {
                        $('#rejectedInsuranceSubmitBtn').html(
                            '<i class="fa fa-spinner fa-spin"></i>');
                        $('#rejectedInsuranceSubmitBtn').attr('disabled', true);
                    },
                    complete: function() {
                        $('#rejectedInsuranceSubmitBtn').html('Rejected');
                        $('#rejectedInsuranceSubmitBtn').attr('disabled', false);
                    },
                    success: function(data) {
                        if (data['status']) {
                            $('#rejectedInsuranceModal').modal('hide');
                            toastr.success(data['message']);
                            location.reload();
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
