@extends('admin.layouts.temp')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Payments Bill</h1>
                    <small>{{ $clinic->clinic }}</small>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.dashboard.index', $clinic->id) }}">Home</a>
                        </li>
                        <li class="breadcrumb-item active">Payments Bill</li>
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
                    <div class="card">
                        <div class="card-body table-responsive">
                            <table id="paymentsBillsData" class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>Patient Names</th>
                                        <th>Open Date</th>
                                        <th>Consultation Fee</th>
                                        <th>Consultation Receipt</th>
                                        <th>Bill Status</th>
                                        <th>Claimed Amount</th>
                                        <th>Agreed Amount</th>
                                        <th>Total Amount</th>
                                        <th>Paid Amount</th>
                                        <th>Balance</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div><!-- /.card-body -->
                    </div><!-- /.card -->

                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </section><!-- /.content -->
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {

            find_payments_bill();

            function find_payments_bill() {
                var path = '{{ route('admin.payments.bills.index', $clinic->id) }}';
                $('#paymentsBillsData').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: path,
                    columns: [{
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex'
                        },
                        {
                            data: 'full_names',
                            name: 'full_names'
                        },
                        {
                            data: 'open_date',
                            name: 'open_date',
                        },
                        {
                            data: 'consultation_fee',
                            name: 'consultation_fee'
                        },
                        {
                            data: 'consultation_receipt_number',
                            name: 'consultation_receipt_number'
                        },
                        {
                            data: 'bill_status',
                            name: 'bill_status'
                        },
                        {
                            data: 'claimed_amount',
                            name: 'claimed_amount'
                        },
                        {
                            data: 'agreed_amount',
                            name: 'agreed_amount'
                        },
                        {
                            data: 'total_amount',
                            name: 'total_amount'
                        },
                        {
                            data: 'paid_amount',
                            name: 'paid_amount'
                        },
                        {
                            data: 'balance',
                            name: 'balance'
                        },
                        {
                            data: 'action',
                            name: 'action',
                            orderable: false,
                            searchable: false
                        },
                    ],
                    "autoWidth": false,
                    "responsive": true,
                });
            }

            $(document).on('click', '.viewPaymentBill', function(e) {
                e.preventDefault();
                var bill_id = $(this).data('id');
                var path = '{{ route('admin.payments.bills.show', ':payment_id') }}';
                path = path.replace(':payment_id', bill_id);
                $.ajax({
                    url: path,
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        if (data['status']) {
                            let billPath =
                                '{{ route('admin.payments.bills.view', [':id', ':payment_id']) }}';
                            billPath = billPath.replace(':id', {{ $clinic->id }});
                            billPath = billPath.replace(':payment_id', data['data']['id']);
                            setTimeout(() => {
                                window.location.href = billPath;
                            }, 500);
                        }
                    }
                });
            });

        });
    </script>
@endsection
