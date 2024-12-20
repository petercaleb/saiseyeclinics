@extends('users.layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>View Remittance Bill</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ route('users.dashboard.index') }}">Home</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('users.payments.remittance.index') }}">
                                Payment Remittance
                            </a>
                        </li>
                        <li class="breadcrumb-item active">
                            View Remittance Bill
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
                <div class="col-md-3">
                    <!-- About Me Box -->
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title">Patient Details</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <strong><i class="fa fa-user mr-1"></i> Full Names</strong>

                            <p class="text-muted">
                                {{ $payment_bill->patient->first_name }} {{ $payment_bill->patient->last_name }}
                            </p>

                            <hr>

                            <strong><i class="fa fa-phone mr-1"></i> Phone Number</strong>

                            <p class="text-muted">
                                {{ $payment_bill->patient->phone }}
                            </p>

                            <hr>

                            <strong><i class="fa fa-envelope mr-1"></i> Email Address</strong>

                            <p class="text-muted">
                                {{ $payment_bill->patient->email }}
                            </p>

                            <hr>

                            <strong><i class="fa fa-map-pin mr-1"></i> Address</strong>

                            <p class="text-muted">{{ $payment_bill->patient->address }}</p>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->

                </div>
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-12">
                            <!-- Main content -->
                            <div class="invoice p-3 mb-3">

                                <!-- title row -->
                                <div class="row">
                                    <div class="col-12">
                                        <h4>
                                            Remittance Bill
                                            <small class="float-right">Claimed Date:
                                                {{ date('d-M-Y', strtotime($remittance->remittance_date)) }}</small>
                                        </h4>
                                    </div>
                                    <!-- /.col -->
                                </div>
                                <!-- info row -->
                                <br>

                                <div class="row invoice-info">
                                    <div class="col-sm-6 invoice-col">
                                        To
                                        <address>
                                            <strong>{{ $remittance->clinic->clinic }}</strong><br>
                                            <br>
                                            Phone: {{ $remittance->clinic->phone }}<br>
                                            Email: {{ $remittance->clinic->email }}
                                        </address>
                                    </div>
                                    <!-- /.col -->

                                    <div class="col-sm-6 invoice-col">
                                        To
                                        <address>
                                            <strong>{{ $remittance->clinic->organization->organization }}</strong><br>
                                            <br>
                                            Phone: {{ $remittance->clinic->organization->phone }}<br>
                                            Email: {{ $remittance->clinic->organization->email }}
                                        </address>
                                    </div>
                                    <!-- /.col -->
                                </div>
                                <!-- Table row -->
                                <br>
                                {{-- <div class="row">
                                    <h5>Payments By Clinic</h5>
                                    <div class="col-12 table-responsive">
                                        <table class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th>Receipt #</th>
                                                    <th>Item</th>
                                                    <th>Amount</th>
                                                    <th>Paid Date</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                    <!-- /.col -->
                                </div>
                                <!-- /.row --> --}}
                                <br>
                                <div class="row">
                                    <!-- accepted payments column -->
                                    <div class="col-12 col-md-6">
                                        <p class="lead">Remittance Status:</p>
                                        @if ($remittance->status == 'OPENED')
                                            <span class="badge badge-primary">{{ $remittance->status }}</span>
                                        @else
                                            <span class="badge badge-success">{{ $remittance->status }}</span>
                                        @endif
                                        <br><br>
                                        <p class="lead">Claimed Item:</p>
                                        {{ $remittance->item }}
                                    </div>
                                    <!-- /.col -->
                                    <div class="col-12 col-md-6">
                                        <p class="lead">
                                            @if ($remittance->closed_date)
                                                Closed Date: {{ date('d-m-Y', strtotime($payment_bill->close_date)) }}
                                            @endif
                                        </p>
                                        <div class="table-responsive">
                                            <table class="table">
                                                <tr>
                                                    <th style="width:50%">
                                                        Claimed Amount
                                                    </th>
                                                    <td>
                                                        {{ number_format($remittance->amount, 2, '.', ',') }}
                                                    </td>
                                                </tr>
                                            </table>

                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                </div>
                <div class="col-md-3">
                    <!-- About Me Box -->
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <h3 class="card-title">Bill Details</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <strong><i class="fa fa-database mr-1"></i> Invoice Number</strong>

                            <p class="text-muted">
                                {{ $payment_bill->invoice_number }}
                            </p>

                            <hr>

                            <strong><i class="fa fa-industry mr-1"></i> LPO Number</strong>

                            <p class="text-muted">
                                {{ $payment_bill->lpo_number }}
                            </p>

                            <hr>

                            <strong><i class="fa fa-calendar mr-1"></i> Open Date</strong>

                            <p class="text-muted">
                                {{ date('d-M-Y', strtotime($payment_bill->open_date)) }}
                            </p>

                            <hr>

                            <strong><i class="fa fa-cc mr-1"></i> Consultation Fee</strong>

                            <p class="text-muted">
                                {{ $payment_bill->consultation_fee }}
                            </p>

                            <hr>

                            <strong><i class="fa fa-money mr-1"></i> Agreed Amount</strong>

                            <p class="text-muted">
                                {{ $payment_bill->agreed_amount }}
                            </p>

                            <hr>

                            <strong><i class="fa fa-money mr-1"></i> Total Amount</strong>

                            <p class="text-muted">
                                {{ $payment_bill->consultation_fee }}
                            </p>

                            <hr>

                            <strong><i class="fa fa-money mr-1"></i> Paid Amounr</strong>

                            <p class="text-muted">
                                {{ $payment_bill->paid_amount }}
                            </p>

                            <hr>
                            <strong><i class="fa fa-calendar mr-1"></i> Closing Date</strong>

                            <p class="text-muted">
                                {{ date('d-M-Y', strtotime($payment_bill->close_date)) }}
                            </p>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->

                </div>
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {

        });
    </script>
@endsection
