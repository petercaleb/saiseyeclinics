<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{ config('app.name') }} | {{ $page_title }}</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap 4 -->

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="{{ asset('fonts/font-awesome/css/font-awesome.min.css') }}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('css/adminlte.min.css') }}">

    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>

<body>
    <div class="wrapper">
        <!-- Main content -->
        <section class="invoice">
            <!-- title row -->
            <div class="row">
                <div class="col-12">
                    <h2 class="page-header">
                        <i class="fa fa-globe"></i> {{ $payment_bill->clinic->clinic }}
                        <small class="float-right">
                            Open Date: {{ date('d-m-Y', strtotime($payment_bill->open_date)) }}
                        </small>
                    </h2>
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
                        Email: {{ $payment_bill->patient->email }} <br>
                        @if ($payment_bill->payment_detail->client_type->type == 'Insurance')
                            Insurance Name: {{ $payment_bill->payment_detail->insurance->title }}<br>
                            Scheme Name: {{ $payment_bill->payment_detail->scheme }}<br>
                        @endif
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
                                <th>
                                    Agreed Amount
                                </th>
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
        </section>
        <!-- /.content -->
    </div>
    <!-- ./wrapper -->

    <script type="text/javascript">
        window.addEventListener("load", window.print());
    </script>
</body>

</html>
