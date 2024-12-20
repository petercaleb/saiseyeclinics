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
                            <a href="{{ route('users.payments.close.bills.index') }}">
                                @lang('users.page.payments.sub_page.closed')
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
                                    <small class="float-right">Closed Date:
                                        {{ date('d-m-Y', strtotime($payment_bill->close_date)) }}</small>
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
                                    Card Number: {{ $payment_bill->patient->card_number }}<br>
                                    Phone: {{ $payment_bill->patient->phone }}<br>
                                    Email: {{ $payment_bill->patient->email }} <br>
                                    @if ($payment_bill->payment_detail->client_type->type == 'Insurance')
                                        Insurance : {{ $payment_bill->payment_detail->insurance->title }}<br>
                                        Scheme: {{ $payment_bill->payment_detail->scheme }}
                                    @endif

                                    @if (isset($payment_bill->appontment->lens_power->frame_prescription->receipt_number))
                                        Prescription Invoice Number:
                                        {{ $payment_bill->appontment->lens_power->frame_prescription->receipt_number }}
                                    @endif

                                </address>
                            </div>
                            <!-- /.col -->


                            <div class="col-sm-4 invoice-col">
                                @if ($payment_bill->invoice_number)
                                    <b>Invoice #{{ $payment_bill->invoice_number }}</b><br>
                                    <br>
                                    @if ($payment_bill->lpo_number)
                                        <b>LPO #:</b> {{ $payment_bill->lpo_number }}<br>
                                    @endif
                                    <b>Open Date:</b> {{ date('d-M-Y', strtotime($payment_bill->open_date)) }}<br>
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
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($payment_bill->billing as $billing)
                                            <tr>
                                                <td>{{ $billing->item }}</td>
                                                <td>{{ $billing->receipt_number }}</td>
                                                <td>{{ number_format($billing->amount, 2, '.', ',') }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="3">
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
                                <p class="lead">Remittance</p>
                                <div class="table-responsive">
                                    <table class="table">
                                        <tr>
                                            <th style="width:50%">
                                                Remittance Amount
                                            </th>
                                            <td>
                                                {{ number_format($payment_bill->remittance_amount, 2, '.', ',') }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>
                                                Remittance Balance
                                            </th>
                                            <td>
                                                {{ number_format($payment_bill->remittance_balance, 2, '.', ',') }}
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <!-- /.col -->

                            <div class="col-12 col-md-6">
                                @if ($payment_bill->close_date)
                                    <p class="lead">
                                        Closed Date: {{ date('d-M-Y', strtotime($payment_bill->close_date)) }}
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
                                @if (!$payment_bill->lpo_number)
                                    <a href="#" data-id='{{ $payment_bill->id }}'
                                        class="btn btn-default updateLPONumberBtn">
                                        <i class="fa fa-industry"></i> Add LPO Number
                                    </a>
                                @endif


                                <a href="#" data-id='{{ $payment_bill->id }}'
                                    class="btn btn-success createRemittanceBtn">
                                    <i class="fa fa-money"></i> Claim Remittance
                                </a>

                                <button type="button" data-id="{{ $payment_bill->id }}"
                                    class="btn btn-warning float-right printPaymentsBtn" style="margin-right: 5px;">
                                    <i class="fa fa-print"></i> Print
                                </button>

                                <button type="button" data-id="{{ $payment_bill->id }}"
                                    class="btn btn-primary float-right attachmentsBtn" style="margin-right: 5px;">
                                    <i class="fas fa-file-pdf"></i> Attachments
                                </button>

                                <button type="button" data-id="{{ $payment_bill->id }}"
                                    class="btn btn-secondary float-right addAttachmentsBtn" style="margin-right: 5px;">
                                    <i class="fas fa-folder-plus"></i> Add Attachments
                                </button>
                            </div>
                        </div>
                        <!-- /.row -->
                    </div>
                    <!-- /.invoice -->
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->

        <!-- /send bill to remittance -->
        <div class="modal fade" id="updateLPONumberModal">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">
                            Update LPO Number
                        </h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="updateLPONumberForm">
                        <div class="modal-body">
                            @csrf
                            <div class="form-group">
                                <input type="hidden" id="updateLPONumberBillId" name="bill_id" class="form-control">
                            </div>

                            <div class="form-group">
                                <label for="updateLPONumber">
                                    LPO Number
                                </label>
                                <input type="text" name="lpo_number" class="form-control" id="updateLPONumber"
                                    placeholder="Enter LPO Number">
                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" id="updateLPONumberSubmitBtn" class="btn btn-primary">
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

        <!-- /send bill to remittance -->
        <div class="modal fade" id="createRemittanceModal">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">
                            Claim Remittance
                        </h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="createRemittanceForm">
                        <div class="modal-body">
                            @csrf
                            <div class="form-group">
                                <input type="hidden" id="createRemittanceBillId" name="bill_id" class="form-control">
                            </div>

                            <div class="form-group">
                                <label for="createRemittanceItem">
                                    Item
                                </label>
                                <input type="text" name="item" class="form-control" id="createRemittanceItem"
                                    placeholder="Can be consultation fee, balance, deposit">
                            </div>

                            <div class="form-group">
                                <label for="createRemittanceAmount">
                                    Remittance Amount
                                </label>
                                <input type="number" name="remittance_amount" class="form-control"
                                    id="createRemittanceAmount" placeholder="Remittance Amount">
                            </div>

                            <div class="form-group">
                                <label for="createRemittanceDate">
                                    Remittance Date
                                </label>
                                <input type="text" name="remittance_date" class="form-control datepicker"
                                    id="createRemittanceDate" placeholder="Remittance Date">
                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" id="createRemittanceSubmitBtn" class="btn btn-primary">
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

        <div class="modal fade" id="addAttachmentModal">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Add Attachments</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="addAttachmentForm">
                        @csrf
                        <div class="modal-body">
                            <div class="form-group">
                                <input type="hidden" class="form-control" id="addAttachmentPaymentId" />
                            </div>

                            <div class="form-group">
                                <label for="addAttachmentPaymentTitle">Title</label>
                                <input type="text" class="form-control" name="title" id="addAttachmentPaymentTitle"
                                    placeholder="Enter Title">
                            </div>


                            <div class="form-group">
                                <label for="addAttachmentFile">File Name</label>
                                <div class="input-group">
                                    <div class="custom-file">
                                        <input type="file" name="file" class="custom-file-input"
                                            id="addAttachmentFile">
                                        <label class="custom-file-label" for="addAttachmentFile">Choose file</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">
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

        <div class="modal fade" id="attachmentsModal">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">View Payment Attachments</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Title</th>
                                        <th>File</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($payment_attachments as $attachment)
                                        <tr>
                                            <td>
                                                {{ $attachment->title }}
                                            </td>
                                            <td>
                                                <a href="{{ route('users.payments.attachments.open.file', $attachment->id) }}"
                                                    target="_blank">
                                                    {{ $attachment->file }}
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                    @endforelse

                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
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

            $(document).on('click', '.updateLPONumberBtn', function(e) {
                e.preventDefault();
                let bill_id = $(this).data('id');
                let path = '{{ route('users.payments.close.bills.show', ':paymentBill') }}';
                path = path.replace(':paymentBill', bill_id);
                $.ajax({
                    url: path,
                    type: 'GET',
                    success: function(data) {
                        if (data['status']) {
                            $('#updateLPONumberBillId').val(data['data']['id']);
                            $('#updateLPONumberModal').modal('show');
                        }
                    },
                });
            });

            $('#updateLPONumberForm').submit(function(e) {
                e.preventDefault();
                let form = $(this);
                let formData = new FormData(form[0]);
                let path = '{{ route('users.payments.close.bills.update.lpo', $payment_bill->id) }}';
                $.ajax({
                    url: path,
                    type: 'POST',
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    beforeSend: function() {
                        $('#updateLPONumberSubmitBtn').html(
                            '<i class="fa fa-spinner fa-spin"></i>'
                        );
                        $('#updateLPONumberSubmitBtn').attr('disabled', true);
                    },
                    complete: function() {
                        $('#updateLPONumberSubmitBtn').html(
                            'Update'
                        );
                        $('#updateLPONumberSubmitBtn').attr('disabled', false);
                    },
                    success: function(data) {
                        if (data['status']) {
                            $('#updateLPONumberModal').modal('hide');
                            toastr.success(data['message']);
                            setTimeout(function() {
                                window.location.reload();
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

            $(document).on('click', '.printPaymentsBtn', function(e) {
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
                            let url =
                                '{{ route('users.payments.close.bills.print', ':paymentBill') }}';
                            url = url.replace(':paymentBill', data['data']['id']);
                            setTimeout(() => {
                                window.open(url, "mywindow",
                                    "status=1,toolbar=1");
                            }, 500);
                        }
                    }
                });
            });

            $(document).on('click', '.createRemittanceBtn', function(e) {
                e.preventDefault();
                let bill_id = $(this).data('id');
                let path = '{{ route('users.payments.close.bills.show', ':paymentBill') }}';
                path = path.replace(':paymentBill', bill_id);
                $.ajax({
                    url: path,
                    type: 'GET',
                    success: function(data) {
                        if (data['status']) {
                            $('#createRemittanceBillId').val(data['data']['id']);
                            $('#createRemittanceModal').modal('show');
                        }
                    },

                });
            });

            $('#createRemittanceForm').submit(function(e) {
                e.preventDefault();
                var form = $(this);
                var formData = new FormData(form[0]);
                var path = '{{ route('users.payments.remittance.store') }}';
                $.ajax({
                    url: path,
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    beforeSend: function() {
                        $('#createRemittanceSubmitBtn').html(
                            '<i class="fa fa-spinner fa-spin"></i>');
                        $('#createRemittanceSubmitBtn').attr('disabled', true);
                    },
                    complete: function() {
                        $('#createRemittanceSubmitBtn').html('Save');
                        $('#createRemittanceSubmitBtn').attr('disabled', false);
                    },
                    success: function(data) {
                        if (data['status']) {
                            toastr.success(data['message']);
                            $('#createRemittanceForm')[0].reset();
                            $('#createRemittanceModal').modal('hide');
                            update_remittance();
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

            function update_remittance() {
                var bill_id = '{{ $payment_bill->id }}';
                var token = '{{ csrf_token() }}';
                var path = '{{ route('users.payments.remittance.update.bill') }}';
                $.ajax({
                    url: path,
                    type: 'POST',
                    data: {
                        bill_id: bill_id,
                        _token: token
                    },
                    dataType: 'json',
                    success: function(data) {
                        if (data['status']) {
                            let url = '{{ route('users.payments.remittance.index') }}';
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
            }

            $(document).on('click', '.addAttachmentsBtn', function(e) {
                e.preventDefault();
                // $('#fileUpload').trigger('click');
                let paymentBill = $(this).data('id');
                let path = '{{ route('users.payments.close.bills.show', ':paymentBill') }}';
                path = path.replace(':paymentBill', paymentBill);
                $.ajax({
                    type: "GET",
                    url: path,
                    dataType: "json",
                    success: function(data) {
                        if (data['status']) {
                            $('#addAttachmentModal').modal('show');
                            $('#addAttachmentPaymentId').val(data['data']['id']);
                        }
                    }
                });
            });

            $('#addAttachmentForm').submit(function(e) {
                e.preventDefault();
                let form = $(this);
                let formData = new FormData(form[0]);
                let paymentBill = $('#addAttachmentPaymentId').val();
                let path = '{{ route('users.payments.attachments.store', ':paymentBill') }}';
                path = path.replace(':paymentBill', paymentBill);
                $.ajax({
                    type: "POST",
                    url: path,
                    data: formData,
                    dataType: "json",
                    contentType: false,
                    processData: false,
                    beforeSend: function() {
                        form.find('button[type=submit]').html(
                            '<i class="fa fa-spinner fa-spin"></i>');
                        form.find('button[type=submit]').attr('disabled', true);
                    },
                    complete: function() {
                        form.find('button[type=submit]').html(
                            'Save');
                        form.find('button[type=submit]').attr('disabled', false);
                    },
                    success: function(data) {
                        if (data['status']) {
                            toastr.success(data['message']);
                            $('#addAttachmentModal').modal('hide');
                            $('#addAttachmentForm')[0].reset();
                            setTimeout(() => {
                                location.reload();
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

            $('.attachmentsBtn').click(function(e) {
                e.preventDefault();
                $('#attachmentsModal').modal('show');
            });
        });
    </script>
@endpush
