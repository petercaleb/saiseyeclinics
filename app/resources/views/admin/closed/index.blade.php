@extends('admin.layouts.temp')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Closed Bills</h1>
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
                            <table id="closedBillsData" class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>Invoice Number</th>
                                        <th>Patient Names</th>
                                        <th>Open Date</th>
                                        <th>Total Amount</th>
                                        <th>Total Paid</th>
                                        <th>Closed Date</th>
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
            find_closed_bills();
            function find_closed_bills() {
                var path = '{{ route('admin.payments.closed.bills.index', $clinic->id) }}';
                $('#closedBillsData').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: path,
                    columns: [{
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex'
                        },
                        {
                            data: 'invoice_number',
                            name: 'invoice_number'
                        },
                        {
                            data: 'full_names',
                            name: 'full_names'
                        },
                        {
                            data: 'open_date',
                            name: 'open_date'
                        },
                        {
                            data: 'total_amount',
                            name: 'total_amount'
                        },
                        {
                            data: 'total_paid',
                            name: 'total_paid'
                        },
                        {
                            data: 'close_date',
                            name: 'close_date'
                        },
                        {
                            data: 'action',
                            name: 'action',
                            orderable: false,
                            searchable: false
                        }
                    ],
                    "autoWidth": false,
                    "responsive": true,
                });
            }

            $(document).on('click', '.viewBtn', function(e) {
                e.preventDefault();
                var bill_id = $(this).data('id');
                var token = '{{ csrf_token() }}';
                var path = '{{ route('admin.payments.closed.bills.show', ':paymentBill') }}';
                path = path.replace(':paymentBill', bill_id);
                $.ajax({
                    url: path,
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        if (data['status']) {
                            let url = '{{ route('admin.payments.closed.bills.view', $clinic->id) }}';
                            setTimeout(() => {
                                window.location.href = url;
                            }, 1000);
                        }
                    },
                });
            });
        });
    </script>
@endsection
