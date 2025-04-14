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
                                {{ \RemmittanceStatus::getName(RemmittanceStatus::PENDING) }}
                            </span>
                            <span class="info-box-number text-center text-muted mb-0">
                                {{ count($pending) }}
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-4">
                    <div class="info-box bg-light">
                        <div class="info-box-content">
                            <span class="info-box-text text-center text-muted">
                                {{ \RemmittanceStatus::getName(RemmittanceStatus::SUBMITTED) }}
                            </span>
                            <span class="info-box-number text-center text-muted mb-0">
                                {{ count($submitted) }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <!--/.row -->

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <form action="">
                                @csrf
                                <div class="row">
                                    <div class="col-12 col-md-4">
                                        <div class="form-group">
                                            <select name="clinic_id" class="form-control select2" style="width: 100%;">
                                                <option selected="selected" disabled="disabled">Select Clinic
                                                </option>
                                                @foreach ($clinics as $selectClinic)
                                                    <option value="{{ $selectClinic->id }}" @if (!empty($filtered_data) && !empty($filtered_data['clinic_id']) && $filtered_data['clinic_id'] == $selectClinic->id) selected = "selected" @endif)>
                                                        {{ $selectClinic->clinic }}
                                                    </option>
                                                @endforeach

                                            </select>
                                        </div>
                                        <!-- /.form-group -->
                                    </div>
                                    <div class="col-12 col-md-4">
                                        <div class="form-group">
                                            <select name="insurance_id" class="form-control select2" style="width: 100%;">
                                                <option selected="selected" disabled="disabled">Select Insurance
                                                </option>
                                                @forelse ($insurances as $selectedInsurances)
                                                    <option value="{{ $selectedInsurances->id }}" @if (!empty($filtered_data) && !empty($filtered_data['insurance_id']) && $filtered_data['insurance_id'] == $selectedInsurances->id)
                                                        selected = "selected"
                                                    @endif>
                                                        {{ $selectedInsurances->title }}
                                                    </option>
                                                @empty
                                                @endforelse
                                            </select>
                                        </div>
                                        <!-- /.form-group -->
                                    </div>
                                    <div class="col-12 col-md-2">
                                        <button type="submit" class="btn btn-block btn-outline-primary">
                                            <i class="fas fa-search"></i> filter
                                        </button>
                                    </div>

                                    <div class="col-12 col-md-2">
                                        <button type="button" class="btn btn-outline-primary">
                                            <a href="{{ route('admin.remmittance.index') }}">
                                                <i class="fas fa-refresh"></i>
                                            </a>
                                        </button>

                                        <button type="button" class="btn btn-outline-primary">
                                            <a href="{{ route('admin.remmittance.export') }}">
                                                Export
                                            </a>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12 col-md-12">
                    <div class="card">
                        <div class="card-header d-flex p-0">
                            <h3 class="card-title p-3">Tabs</h3>
                            <ul class="nav nav-pills ml-auto p-2">
                                <li class="nav-item">
                                    <a class="nav-link active" href="#tab_1" data-toggle="tab">
                                        {{ \RemmittanceStatus::getName(\RemmittanceStatus::PENDING) }}
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#tab_2" data-toggle="tab">
                                        {{ \RemmittanceStatus::getName(\RemmittanceStatus::SUBMITTED) }}
                                    </a>
                                </li>
                            </ul>
                        </div><!-- /.card-header -->
                        <div class="card-body">
                            <div class="tab-content">
                                <div class="tab-pane active" id="tab_1">
                                    <div class="row">
                                        <div class="col-12">
                                            <a href="{{ route('admin.remmittance.export.pending.submission') }}"
                                                class="btn btn-outline-primary btn-sm float-right">
                                                Export
                                            </a>
                                        </div>
                                    </div>
                                    <br>
                                    <form id="submitRemmittanceForm">
                                        <div class="row">
                                            <div class="col-12">
                                                <span class="submitRemmittanceSpan">
                                                    <button type="submit"
                                                        class="btn btn-block btn-sm btn-outline-primary float-right submitCreatedRemmittanceBtn">
                                                        Submit Remmittance
                                                    </button>
                                                </span>

                                            </div>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="table-responsive">
                                                    <table id="pendingData"
                                                        class="table table-bordered table-striped table-sm">
                                                        <thead>
                                                            <tr>
                                                                <th></th>
                                                                <th></th>
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
                                                            @foreach ($pending as $pendingRemmittance)
                                                                <tr>
                                                                    <td>
                                                                        <input type="checkbox" name="remmittance_id[]"
                                                                            value="{{ $pendingRemmittance->id }}"
                                                                            class="submitRemmittanceCheckBox">
                                                                    </td>

                                                                    <td>{{ $loop->iteration }}</td>

                                                                    <td>
                                                                        {{ $pendingRemmittance->paymentBill->clinic->clinic }}
                                                                    </td>

                                                                    <td>
                                                                        {{ $pendingRemmittance->paymentBill->appontment->lens_power->frame_prescription->receipt_number }}
                                                                    </td>

                                                                    <td>
                                                                        {{ $pendingRemmittance->paymentBill->patient->first_name }}
                                                                        {{ $pendingRemmittance->paymentBill->patient->last_name }}
                                                                    </td>

                                                                    <td>
                                                                        {{ $pendingRemmittance->paymentBill->invoice_number }}
                                                                    </td>

                                                                    <td>
                                                                        {{ $pendingRemmittance->paymentBill->payment_detail->insurance->title }}
                                                                    </td>

                                                                    <td>{{ $pendingRemmittance->paymentBill->payment_detail->scheme }}
                                                                    </td>
                                                                    <td>{{ $pendingRemmittance->paymentBill->patient->card_number }}
                                                                    </td>
                                                                    <td>{{ $pendingRemmittance->paymentBill->close_date }}
                                                                    </td>
                                                                    <td>
                                                                        {{ $pendingRemmittance->paymentBill->paid_amount }}
                                                                    </td>
                                                                    <td>
                                                                        {{ $pendingRemmittance->paymentBill->kra_number }}
                                                                    </td>
                                                                    <td>
                                                                        {{ \RemmittanceStatus::getName($pendingRemmittance->status) }}
                                                                    </td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class="col-12 submitRemmittanceCol">
                                                <span class="submitRemmittanceSpan">
                                                    <button type="submit"
                                                        class="btn btn-block btn-sm btn-outline-primary float-right submitCreatedRemmittanceBtn">
                                                        Submit Remmittance
                                                    </button>
                                                </span>

                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <!-- /.tab-pane -->
                                <div class="tab-pane" id="tab_2">
                                    <div class="row">
                                        <div class="col-12">
                                            <a href="{{ route('admin.remmittance.export.submitted.submission') }}"
                                                class="btn btn-outline-primary btn-sm float-right">
                                                Export
                                            </a>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="table-responsive">
                                                <table id="submittedData"
                                                    class="table table-bordered table-striped table-sm">
                                                    <thead>
                                                        <tr>
                                                            <th></th>
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
                                                                <td>{{ $loop->iteration }}</td>
                                                                <td>{{ $submittedRemmittance->paymentBill->clinic->clinic }}
                                                                </td>
                                                                <td>
                                                                    {{ $submittedRemmittance->paymentBill->appontment->lens_power->frame_prescription->receipt_number }}
                                                                </td>
                                                                <td>{{ $submittedRemmittance->paymentBill->patient->first_name }}
                                                                    {{ $submittedRemmittance->paymentBill->patient->last_name }}
                                                                </td>
                                                                <td>{{ $submittedRemmittance->paymentBill->invoice_number }}
                                                                </td>
                                                                <td>{{ $submittedRemmittance->paymentBill->payment_detail->insurance->title }}
                                                                </td>
                                                                <td>{{ $submittedRemmittance->paymentBill->payment_detail->scheme }}
                                                                </td>
                                                                <td>{{ $submittedRemmittance->paymentBill->patient->card_number }}
                                                                </td>
                                                                <td>{{ $submittedRemmittance->paymentBill->close_date }}
                                                                </td>
                                                                <td>{{ $submittedRemmittance->paymentBill->paid_amount }}
                                                                </td>
                                                                <td>{{ $submittedRemmittance->paymentBill->kra_number }}
                                                                </td>
                                                                <td>{{ \RemmittanceStatus::getName($submittedRemmittance->status) }}
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
        </div>
        <!--/.container-fluid -->
    </section>
    <!--/.content -->
@endsection

@push('scripts')
    @include('admin.main.remmittance.scripts.scripts')
@endpush
