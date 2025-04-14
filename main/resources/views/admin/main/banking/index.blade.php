@extends('admin.layouts.app')

@section('content')
    @include('admin.includes.partials.main.breadcrumbs')

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 col-sm-4">
                    <div class="info-box bg-light">
                        <div class="info-box-content">
                            <span class="info-box-text text-center text-muted">
                                Total Amount Submitted
                            </span>
                            <span class="info-box-number text-center text-muted mb-0">
                                {{ $totalSubmittedAmount }}
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-4">
                    <div class="info-box bg-light">
                        <div class="info-box-content">
                            <span class="info-box-text text-center text-muted">
                                Total Amount Received
                            </span>
                            <span class="info-box-number text-center text-muted mb-0">
                                {{ $totalPaid }}
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-4">
                    <div class="info-box bg-light">
                        <div class="info-box-content">
                            <span class="info-box-text text-center text-muted">
                                Total Balances
                            </span>
                            <span class="info-box-number text-center text-muted mb-0">
                                {{ $totalBalance }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <!--/.row -->

            <div class="row">
                <div class="col-12 col-md-12">
                    <!-- Custom Tabs -->
                    <div class="card">
                        <div class="card-header d-flex p-0">
                            <h3 class="card-title p-3">
                                &nbsp;
                            </h3>
                            <ul class="nav nav-pills ml-auto p-2">
                                <li class="nav-item">
                                    <a class="nav-link active" href="#tab_1" data-toggle="tab">
                                        {{ \RemmittanceStatus::getName(\RemmittanceStatus::SUBMITTED) }}
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#tab_2" data-toggle="tab">
                                        Payments
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#tab_3" data-toggle="tab">
                                        {{ \RemmittanceStatus::getName(\RemmittanceStatus::RECEIVED) }}
                                    </a>
                                </li>
                            </ul>
                        </div><!-- /.card-header -->
                        <div class="card-body">
                            <div class="tab-content">
                                <div class="tab-pane active" id="tab_1">
                                    <div class="row receivePaymentsBtnRow">
                                        <div class="col-12">
                                            <button type="button"
                                                class="btn btn-outline-primary btn-block receivePaymentsBtn">
                                                Receive Payments
                                            </button>
                                        </div>
                                    </div>
                                    <br>
                                    <form>
                                        @csrf
                                        <div class="row">
                                            <div class="col-12 col-md-4">
                                                <div class="form-group">
                                                    <label>Clinics</label>
                                                    <select name="clinic_id" class="form-control select2"
                                                        style="width: 100%;">
                                                        <option disabled="disabled" selected="selected">
                                                            Select a clinic
                                                        </option>
                                                        @foreach ($clinics as $clinic)
                                                            <option value="{{ $clinic->id }}"
                                                                @if (!empty($filtered_data) && !empty($filtered_data['clinic_id']) && $filtered_data['clinic_id'] == $clinic->id) selected = "selected" @endif>
                                                                {{ $clinic->clinic }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <!-- /.form-group -->
                                            </div>

                                            <div class="col-12 col-md-4">
                                                <div class="form-group">
                                                    <label>Insurances</label>
                                                    <select name="insurance_id" class="form-control select2"
                                                        style="width: 100%;">
                                                        <option disabled="disabled" selected="selected">
                                                            Select an insurance
                                                        </option>
                                                        @foreach ($insuranceData as $ins)
                                                            <option value="{{ $ins->id }}"
                                                                @if (!empty($filtered_data) && !empty($filtered_data['insurance_id']) && $filtered_data['insurance_id'] == $ins->id) selected = "selected" @endif>
                                                                {{ $ins->title }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <!-- /.form-group -->
                                            </div>

                                            <div class="col-12 col-md-2">
                                                <label>&nbsp;</label>
                                                <button type="submit" class="btn btn-block btn-outline-primary">
                                                    <i class="fas fa-search"></i> filter
                                                </button>
                                            </div>
                                            <div class="col-12 col-md-2">
                                                <label>&nbsp;</label>
                                                <a href="{{ route('admin.banking.index') }}"
                                                    class="btn btn-block btn-outline-primary">
                                                    <i class="fas fa-sync"></i> refresh
                                                </a>
                                            </div>
                                        </div>
                                    </form>
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="table-responsive">
                                                <table id="submittedData"
                                                    class="table table-bordered table-striped table-sm">
                                                    <thead>
                                                        <tr>
                                                            <th>
                                                                <input type="checkbox" id="selectAllCheckbox">
                                                            </th>
                                                            <th>SN</th>
                                                            <th>Clinic</th>
                                                            <th>Receipt Number</th>
                                                            <th>Patient Names</th>
                                                            <th>Invoice Number</th>
                                                            <th>Insurance</th>
                                                            <th>Scheme Name</th>
                                                            <th>Card Number</th>
                                                            <th>Closed Date</th>
                                                            <th>Amount Billed</th>
                                                            <th>ETIMS Number</th>
                                                            <th>Document Status</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($submitted as $submittedRemmittance)
                                                            <tr>
                                                                <td>
                                                                    <input type="checkbox" name="remmittance_id[]"
                                                                        value="{{ $submittedRemmittance->id }}"
                                                                        class="submitRemmittanceCheckBox" data-amount="{{ $submittedRemmittance->paymentBill->paid_amount }}">
                                                                </td>
                                                                <td>{{ $loop->iteration }}</td>
                                                                <td>{{ $submittedRemmittance->paymentBill->clinic->clinic }}
                                                                </td>
                                                                <td>
                                                                    {{ $submittedRemmittance->paymentBill->appontment->lens_power->frame_prescription->receipt_number }}
                                                                </td>
                                                                <td>
                                                                    {{ $submittedRemmittance->paymentBill->patient->first_name }}
                                                                    {{ $submittedRemmittance->paymentBill->patient->last_name }}
                                                                </td>
                                                                <td>
                                                                    {{ $submittedRemmittance->paymentBill->invoice_number }}
                                                                </td>
                                                                <td>
                                                                    {{ $submittedRemmittance->paymentBill->payment_detail->insurance->title }}
                                                                </td>
                                                                <td>
                                                                    {{ $submittedRemmittance->paymentBill->payment_detail->scheme }}
                                                                </td>
                                                                <td>
                                                                    {{ $submittedRemmittance->paymentBill->patient->card_number }}
                                                                </td>
                                                                <td>
                                                                    {{ $submittedRemmittance->paymentBill->close_date }}
                                                                </td>
                                                                <td>
                                                                    {{ $submittedRemmittance->paymentBill->paid_amount }}
                                                                </td>
                                                                <td>
                                                                    {{ $submittedRemmittance->paymentBill->kra_number }}
                                                                </td>
                                                                <td>
                                                                    {{ \RemmittanceStatus::getName($submittedRemmittance->status) }}
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row receivePaymentsBtnRow">
                                        <div class="col-12">
                                            <button type="button"
                                                class="btn btn-outline-primary btn-block receivePaymentsBtn">
                                                Receive Payments
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.tab-pane -->

                                <div class="tab-pane" id="tab_2">
                                    <div class="row">
                                        <div class="col-12 col-md-12">
                                            <a href="{{ route('admin.banking.export') }}"
                                                class="btn btn-outline-primary btn-block">
                                                Export
                                            </a>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="table-responsive">
                                                <table id="paymentsData" class="table table-bordered table-striped">
                                                    <thead>
                                                        <tr>
                                                            <th>SN</th>
                                                            <th>Date received</th>
                                                            <th>Transaction code</th>
                                                            <th>Transaction mode</th>
                                                            <th>Insurance</th>
                                                            <th>Total amount</th>
                                                            <th>Total paid</th>
                                                            <th>Total balance</th>
                                                            <th>Actions</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($data as $banking)
                                                            <tr>
                                                                <td>{{ $loop->iteration }}</td>
                                                                <td>{{ $banking->date_received }}</td>
                                                                <td>{{ $banking->transaction_code }}</td>
                                                                <td>
                                                                    {{ \TransactionModes::getName($banking->transaction_mode) }}
                                                                </td>
                                                                <td>{{ $banking->insurance->title }}</td>
                                                                <td>{{ $banking->amount }}</td>
                                                                <td>{{ $banking->paid }}</td>
                                                                <td>{{ $banking->balance }}</td>
                                                                <td class="text-center">
                                                                    <a href="{{ route('admin.banking.view', $banking->id) }}"
                                                                        class="btn btn-primary btn-sm">
                                                                        <i class="fas fa-eye fa-sm"></i>
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <!-- /.tab-pane -->

                                <div class="tab-pane" id="tab_3">
                                    <div class="row">
                                        <div class="col-12 col-md-6"></div>
                                        <div class="col-12 col-md-6">
                                            <a href="{{ route('admin.received.payments.export') }}"
                                                class="btn btn-block btn-outline-primary">
                                                Export
                                            </a>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col-12 col-md-12">
                                            <div class="table-responsive">
                                                <table id="receivedData" class="table table-bordered table-striped">
                                                    <thead>
                                                        <tr>
                                                            <th>SN</th>
                                                            <th>Clinic</th>
                                                            <th>Receipt #</th>
                                                            <th>Patient</th>
                                                            <th>Card #</th>
                                                            <th>Insurance</th>
                                                            <th>Scheme Name</th>
                                                            <th>Closed Date</th>
                                                            <th>Date Received</th>
                                                            <th>Transaction Code</th>
                                                            <th>Transaction Mode</th>
                                                            <th>Amount Billed</th>
                                                            <th>Paid Amount</th>
                                                            <th>ETIMS Number</th>
                                                            <th>Document Status</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($rceivedRemmittanceData as $remmittanceData)
                                                            <tr>
                                                                <td>
                                                                    {{ $loop->iteration }}
                                                                </td>
                                                                <td>
                                                                    {{ $remmittanceData->paymentBill->clinic->clinic }}
                                                                </td>
                                                                <td>
                                                                    {{ $remmittanceData->paymentBill->appontment->lens_power->frame_prescription->receipt_number }}
                                                                </td>
                                                                <td>
                                                                    {{ $remmittanceData->paymentBill->patient->first_name }}
                                                                    {{ $remmittanceData->paymentBill->patient->last_name }}
                                                                </td>
                                                                <td>
                                                                    {{ $remmittanceData->paymentBill->patient->card_number }}
                                                                </td>
                                                                <td>
                                                                    {{ $remmittanceData->paymentBill->payment_detail->insurance->title }}
                                                                </td>
                                                                <td>
                                                                    {{ $remmittanceData->paymentBill->payment_detail->scheme }}
                                                                </td>
                                                                <td>
                                                                    {{ $remmittanceData->paymentBill->close_date }}
                                                                </td>
                                                                <td>
                                                                    {{ $remmittanceData->receivedPayment->banking->date_received }}
                                                                </td>
                                                                <td>
                                                                    {{ $remmittanceData->receivedPayment->banking->transaction_code }}
                                                                </td>
                                                                <td>
                                                                    {{ \TransactionModes::getName($remmittanceData->receivedPayment->banking->transaction_mode) }}
                                                                </td>
                                                                <td>
                                                                    {{ $remmittanceData->receivedPayment->amount }}
                                                                </td>
                                                                <td>
                                                                    {{ $remmittanceData->receivedPayment->paid }}
                                                                </td>
                                                                <td>{{ $remmittanceData->paymentBill->kra_number }}</td>
                                                                <td>
                                                                    {{ \RemmittanceStatus::getName($remmittanceData->status) }}
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <!-- /.tab-pane -->
                            </div>
                            <!-- /.tab-content -->
                        </div><!-- /.card-body -->
                    </div>
                    <!-- ./card -->
                </div>
                <!--/.col -->
            </div>
            <!--/.row -->
        </div>
        <!--/.container-fluid -->
    </section>
    <!--/.content -->
    @include('admin.main.banking.modals')
@endsection

@push('scripts')
    @include('admin.main.banking.scripts')
@endpush
