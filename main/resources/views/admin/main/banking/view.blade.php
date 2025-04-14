@extends('admin.layouts.app')

@section('content')
    @include('admin.includes.partials.main.breadcrumbs')

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
                                    <i class="fas fa-file-alt"></i> Payments
                                    <small class="float-right">
                                        Date Received: {{ \Carbon::parse($data->date_received)->format('d M, Y') }}
                                    </small>
                                </h4>
                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- info row -->
                        <div class="row invoice-info">
                            <div class="col-sm-4 invoice-col">
                                &nbsp;
                            </div>
                            <!-- /.col -->
                            <div class="col-sm-4 invoice-col">&nbsp;</div>
                            <!-- /.col -->
                            <div class="col-sm-4 invoice-col">
                                <b>Transaction Code: {{ $data->transaction_code }}</b><br>
                                <br>
                                <b>Transaction Mode:</b> {{ \TransactionModes::getName($data->transaction_mode) }}<br>
                                <b>Insurance:</b> {{ $data->insurance->title }}
                                <br>
                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- /.row -->

                        <!-- Table row -->
                        <div class="row">
                            <div class="col-12 table-responsive">
                                <table id="receivePaymentsData" class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>SN</th>
                                            <th>Clinic</th>
                                            <th>Receipt #</th>
                                            <th>Patient Names</th>
                                            <th>Card Number</th>
                                            <th>ETIMS Number</th>
                                            <th>Agreed Amount</th>
                                            <th>Paid Amount</th>
                                            <th>Balance</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data->receivedPayment as $receivedPayments)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $receivedPayments->paymentBill->clinic->clinic }}</td>
                                                <td>
                                                    {{ $receivedPayments->paymentBill->appontment->lens_power->frame_prescription->receipt_number }}
                                                </td>
                                                <td>
                                                    {{ $receivedPayments->paymentBill->patient->first_name }}
                                                    {{ $receivedPayments->paymentBill->patient->last_name }}
                                                </td>
                                                <td>
                                                    {{ $receivedPayments->paymentBill->patient->card_number }}
                                                </td>
                                                <td>
                                                    {{ $receivedPayments->paymentBill->kra_number }}
                                                </td>
                                                <td>
                                                    {{ $receivedPayments->amount }}
                                                </td>
                                                <td contenteditable="true" data-id="{{ $receivedPayments->id }}">
                                                    {{ $receivedPayments->paid }}
                                                </td>
                                                <td>
                                                    {{ $receivedPayments->balance }}
                                                </td>
                                            </tr>
                                        @endforeach

                                    </tbody>
                                </table>
                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- /.row -->

                        <div class="row">
                            <!-- accepted payments column -->
                            <div class="col-6">
                                <p class="lead">Comments:</p>
                                <p class="text-muted well well-sm shadow-none" style="margin-top: 10px;">
                                    {{ $data->notes }}
                                </p>
                            </div>
                            <!-- /.col -->
                            <div class="col-6">
                                <p class="lead">Received Date
                                    {{ \Carbon::parse($data->date_received)->format('d M, Y') }}</p>

                                <div class="table-responsive">
                                    <table class="table">
                                        <tr>
                                            <th style="width:50%">Total Amount:</th>
                                            <td>{{ $data->amount }}</td>
                                        </tr>
                                        <tr>
                                            <th>Total Paid:</th>
                                            <td>{{ $data->paid }}</td>
                                        </tr>
                                        <tr>
                                            <th>Total Balance:</th>
                                            <td>{{ $data->balance }}</td>
                                        </tr>
                                        <tr>
                                            <th>Change To Return:</th>
                                            <td>{{ $data->change }}</td>
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
                                {{-- <a href="invoice-print.html" rel="noopener" target="_blank" class="btn btn-default"><i
                                        class="fas fa-print"></i> Print</a>
                                <button type="button" class="btn btn-success float-right"><i
                                        class="far fa-credit-card"></i> Submit
                                    Payment
                                </button> --}}
                                <a href="{{ route('admin.banking.export.individual', $data->id) }}" class="btn btn-primary float-right" style="margin-right: 5px;">
                                    <i class="fas fa-download"></i> Export
                                </a>
                            </div>
                        </div>
                    </div>
                    <!-- /.invoice -->
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->

    </section>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#receivePaymentsData').on('blur', '[contenteditable=true]', function(e) {
                e.preventDefault();
                let received_payments_id = $(this).data('id');
                let paid = $(this).text();
                let token = '{{ csrf_token() }}';
                let path = '{{ route('admin.received.payments.update', ':receivedPayment') }}';
                path = path.replace(':receivedPayment', received_payments_id);
                $.ajax({
                    type: "POST",
                    url: path,
                    data: {
                        paid: paid,
                        _token: token
                    },
                    dataType: "json",
                    success: function(data) {
                        if (data['status'])
                        {
                            toastr.success(data['message']);
                            location.reload();
                        }
                    }
                });
            });
        });
    </script>
@endpush
