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
                                Closed Bills
                            </span>
                            <span class="info-box-number text-center text-muted mb-0">
                                {{ count($closedBills) }}
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-4">
                    <div class="info-box bg-light">
                        <div class="info-box-content">
                            <span class="info-box-text text-center text-muted">
                                Documents Sent To HQ
                            </span>
                            <span class="info-box-number text-center text-muted mb-0">
                                {{ count($sentToHQ) }}
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-4">
                    <div class="info-box bg-light">
                        <div class="info-box-content">
                            <span class="info-box-text text-center text-muted">
                                Documents Received From Clinic
                            </span>
                            <span class="info-box-number text-center text-muted mb-0">
                                {{ count($receivedDOC) }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <!--/.row -->

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <form>
                                @csrf
                                <div class="row">
                                    <div class="col-12 col-md-3">
                                        <div class="form-group">
                                            <label>Date</label>
                                            <input type="text" name="close_date" id="closedDate"
                                                placeholder="Select Date" class="form-control datepicker">
                                        </div>
                                    </div>

                                    <div class="col-12 col-md-3">
                                        <div class="form-group">
                                            <label>Clinics</label>
                                            <select name="clinic_id" class="form-control select2" style="width: 100%;">
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

                                    <div class="col-12 col-md-3">
                                        <div class="form-group">
                                            <label>Insurances</label>
                                            <select name="insurance_id" class="form-control select2" style="width: 100%;">
                                                <option disabled="disabled" selected="selected">
                                                    Select an insurance
                                                </option>
                                                @foreach ($insuranceData as $ins)
                                                    <option value="{{ $ins->id }}"
                                                        @if (!empty($filtered_data) && !empty($filtered_data['insurance_id']) && $filtered_data['insurance_id'] == $ins->id) selected = "selected" @endif>
                                                        {{ $ins->title }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <!-- /.form-group -->
                                    </div>

                                    <div class="col-12 col-md-2">
                                        <label>&nbsp;</label>
                                        <button type="submit" class="btn btn-block btn-outline-primary">
                                            <i class="fas fa-search "></i> filter
                                        </button>
                                    </div>
                                    {{-- <div class="col-12 col-md-2">
                                        <label>&nbsp;</label>
                                        <a href="{{ route('admin.billing.index') }}" class="btn btn-block btn-outline-primary">
                                            <i class="fas fa-sync"></i> refresh
                                        </a>
                                    </div> --}}
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12 col-md-12">
                    <!-- Custom Tabs -->
                    <div class="card">
                        <div class="card-header d-flex p-0">
                            <h3 class="card-title p-3">Tabs</h3>
                            <ul class="nav nav-pills ml-auto p-2">
                                <li class="nav-item">
                                    <a class="nav-link active" href="#tab_1" data-toggle="tab">
                                        {{ \DocumentStatus::getName(\DocumentStatus::PHYSICAL_DOCUMENT) }}
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#tab_3" data-toggle="tab">
                                        {{ \DocumentStatus::getName(\DocumentStatus::RECEIVED_DOCUMENT) }}
                                    </a>
                                </li>
                            </ul>
                        </div><!-- /.card-header -->
                        <div class="card-body">
                            <div class="tab-content">
                                <div class="tab-pane active" id="tab_1">
                                    <form id="receiveDocumentsForm">
                                        <div class="table-responsive">
                                            <span class="receiveDocumentSpan">
                                                <button type="submit" class="btn btn-outline-primary btn-block">
                                                    Receive Document
                                                </button>
                                            </span>
                                            <br>
                                            <table id="sentToHqData" class="table table-bordered table-striped table-sm">
                                                <thead>
                                                    <tr>
                                                        <th></th>
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
                                                        <th>Date Doc Was Send</th>
                                                        <th>Document Status</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($sentToHQ as $bill)
                                                        <tr>
                                                            <td>
                                                                <input type="checkbox" name="payment_bill_id[]"
                                                                    value="{{ $bill->id }}"
                                                                    class="receivedDocumentsCheckBox">
                                                            </td>
                                                            <td>
                                                                {{ $loop->iteration }}
                                                            </td>
                                                            <td>{{ $bill->clinic->clinic }}</td>
                                                            <td>{{ $bill->appontment->lens_power->frame_prescription->receipt_number }}
                                                            </td>
                                                            <td>{{ $bill->patient->first_name }}
                                                                {{ $bill->patient->last_name }}</td>
                                                            <td>{{ $bill->invoice_number }}</td>
                                                            <td>
                                                                @isset($bill->payment_detail->insurance)
                                                                    {{ $bill->payment_detail->insurance->title }}
                                                                @endisset
                                                            </td>
                                                            <td>{{ $bill->payment_detail->scheme }}</td>
                                                            <td>{{ $bill->patient->card_number }}</td>
                                                            <td>{{ $bill->close_date }}</td>
                                                            <td>{{ $bill->paid_amount }}</td>
                                                            <td>{{ $bill->send_date }}</td>
                                                            <td>
                                                                {{ \DocumentStatus::getName($bill->document_status) }}
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                            <br>
                                            <span class="receiveDocumentSpan">
                                                <button type="submit" class="btn btn-outline-primary btn-block">
                                                    Receive Document
                                                </button>
                                            </span>
                                        </div>
                                    </form>

                                </div>
                                <!-- /.tab-pane -->
                                <div class="tab-pane" id="tab_3">
                                    <form id="createRemmittanceForm">
                                        <span class="submitRemmittanceSpan">
                                            <button type="submit" class="btn btn-block btn-sm btn-outline-primary">
                                                Create Remmittance
                                            </button>
                                        </span>
                                        <br>
                                        <div class="table-responsive">
                                            <table id="receivedData" class="table table-bordered table-striped table-sm">
                                                <thead>
                                                    <tr>
                                                        <th></th>
                                                        <th>SN</th>
                                                        <th>Clinic</th>
                                                        <th>Receipt Number</th>
                                                        <th>Patient Names</th>
                                                        <th>Invoice Number</th>
                                                        <th>Phone Number</th>
                                                        <th>Insurance</th>
                                                        <th>Scheme Name</th>
                                                        <th>Card Number</th>
                                                        <th>Closed Date</th>
                                                        <th>Amount Billed</th>
                                                        <th>Document Status</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($receivedDOC as $bill)
                                                        <tr>
                                                            <td>
                                                                <input type="checkbox" name="payment_bill_id[]"
                                                                    value="{{ $bill->id }}"
                                                                    class="createRemmittanceCheckBox">
                                                            </td>
                                                            <td>{{ $loop->iteration }}</td>
                                                            <td>{{ $bill->clinic->clinic }}</td>
                                                            <td>{{ $bill->appontment->lens_power->frame_prescription->receipt_number }}
                                                            </td>
                                                            <td>{{ $bill->patient->first_name }}
                                                                {{ $bill->patient->last_name }}</td>
                                                            <td>{{ $bill->invoice_number }}</td>
                                                            <td>{{ $bill->patient->phone }}</td>
                                                            <td>
                                                                @isset($bill->payment_detail->insurance)
                                                                    {{ $bill->payment_detail->insurance->title }}
                                                                @endisset
                                                            </td>
                                                            <td>{{ $bill->payment_detail->scheme }}</td>
                                                            <td>{{ $bill->patient->card_number }}</td>
                                                            <td>{{ $bill->close_date }}</td>
                                                            <td>{{ $bill->paid_amount }}</td>
                                                            <td>{{ \DocumentStatus::getName($bill->document_status) }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                        <br>
                                        <span class="submitRemmittanceSpan">
                                            <button type="submit" class="btn btn-block btn-sm btn-outline-primary">
                                                Create Remmittance
                                            </button>
                                        </span>
                                    </form>
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
@endsection

@push('scripts')
    @include('admin.main.billing.scripts.scripts')
@endpush
