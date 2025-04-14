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
                                @if ($payment_bill->user_id !== null && Auth::user()->id == $payment_bill->user_id)
                                    @if ($payment_bill->frame_amount > 0 && $payment_bill->lens_amount > 0 && $payment_bill->agreed_amount <= 0)
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
        @include('users.billing.modals.editModals')
    </section>
    <!-- /.content -->
@endsection

@push('scripts')
    @include('users.billing.scripts.editScripts')
@endpush
