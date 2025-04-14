@extends('users.layouts.app')

@section('content')
    @include('users.includes.partials.breadcrumbs')

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
                                {{-- <p class="lead">Remittance</p>
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
                                </div> --}}
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
                                                Frame Amount
                                            </th>
                                            <td>
                                                {{ number_format($payment_bill->frame_amount, 2, '.', ',') }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th style="width:50%">
                                                Lens Amount
                                            </th>
                                            <td>
                                                {{ number_format($payment_bill->lens_amount, 2, '.', ',') }}
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
                                @if (!$payment_bill->kra_number)
                                    <a href="#" data-id='{{ $payment_bill->id }}'
                                        class="btn btn-default updateKRANumberBtn">
                                        <i class="fa fa-industry"></i> Add KRA Number
                                    </a>
                                @endif

                                @if ($payment_bill->document_status != \DocumentStatus::PHYSICAL_DOCUMENT
                                && $payment_bill->document_status != \DocumentStatus::RECEIVED_DOCUMENT
                                )
                                    <a href="javascript:void(0)" data-id='{{ $payment_bill->id }}'
                                        class="btn btn-success sendDocToHQBtn">
                                        <i class="fas fa-cogs"></i> Send Doc To HQ
                                    </a>
                                @endif


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
        @include('users.closed.modals.modals')
    </section>
    <!-- /.content -->
@endsection

@push('scripts')
    @include('users.closed.scripts.scripts')
@endpush
