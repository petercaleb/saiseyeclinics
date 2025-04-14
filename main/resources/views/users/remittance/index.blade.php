@extends('users.layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Payment Remittance</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ route('users.dashboard.index') }}">Home</a>
                        </li>
                        <li class="breadcrumb-item active">
                            Payment Remittance
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
                <div class="col-12">
                    <div class="card">
                        <div class="card-body table-responsive">
                            <table id="paymentsRemittanceData" class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>Patient Names</th>
                                        <th>Invoice Number</th>
                                        <th>Remittance Amount</th>
                                        <th>Remittance Date</th>
                                        <th>Remittance Status</th>
                                        <th>View</th>
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
            find_remittance();

            function find_remittance() {
                var path = '{{ route('users.payments.remittance.index') }}';
                $('#paymentsRemittanceData').DataTable({
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
                            data: 'bill_invoice',
                            name: 'bill_invoice',
                        },
                        {
                            data: 'amount',
                            name: 'amount'
                        },
                        {
                            data: 'remittance_date',
                            name: 'remittance_date'
                        },
                        {
                            data: 'remittance_status',
                            name: 'remittance_status'
                        },
                        {
                            data: 'view',
                            name: 'view',
                            orderable: false,
                            searchable: false
                        },
                    ],
                    "autoWidth": false,
                    "responsive": true,
                });
            }

            $(document).on('click', '.viewRemittanceBtn', function(e) {
                e.preventDefault();
                var remittance_id = $(this).data('id');
                var token = '{{ csrf_token() }}';
                var path = '{{ route('users.payments.remittance.show') }}';
                $.ajax({
                    url: path,
                    type: 'POST',
                    data: {
                        remittance_id: remittance_id,
                        _token: token
                    },
                    success: function(data) {
                        if (data['status']) {
                            let url = '{{ route('users.payments.remittance.view', ':id') }}';
                            url = url.replace(':id', data['data']['id']);
                            setTimeout(() => {
                                window.location.href = url;
                            }, 1000);
                        }
                    },
                    error: function(data) {
                        var errors = data.responseJSON;
                        var errorsHtml = '<ul>';
                        $.each(errors['errors'], function(key, value) {
                            errorsHtml += '<li>' + value + '</li>';
                        });
                        errorsHtml += '</ul>';
                        toastr.error(errorsHtml);
                    }
                });
            });
        });
    </script>
@endsection
