@extends('admin.layouts.temp')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Remittance</h1>
                    <small>{{ $clinic->clinic }}</small>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.dashboard.index', $clinic->id) }}">Home</a>
                        </li>
                        <li class="breadcrumb-item active">Remittance</li>
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
                                        <th>View Remittance</th>
                                        <th>Close Remittance</th>
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

        <!--.Close Remittance Modal -->
        <div class="modal fade" id="closeRemittanceModal">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <form id="closeRemittanceForm">
                        <div class="modal-header">
                            <h4 class="modal-title">Close Remittance</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            @csrf
                            <div class="form-group">
                                <input type="hidden" name="remittance_id" class="form-control" id="closeRemittanceId">
                            </div>
                            <div class="form-group">
                                <label for="closeRemittanceClaimedAmount">Claimed Amount</label>
                                <input type="text" name="type" class="form-control" id="closeRemittanceClaimedAmount" name="claimed_amount" disabled>
                            </div>
                            <div class="form-group">
                                <label for="closeRemittancePaidAmount">Paid Amount</label>
                                <input type="text" name="type" name="paid_amount" class="form-control" id="closeRemittancePaidAmount"
                                    placeholder="Enter Paid Amount">
                            </div>

                            <div class="form-group">
                                <label for="closeRemittanceClosedDate">Closed Date</label>
                                <input type="text" name="closed_date" class="form-control datepicker" id="closeRemittanceClosedDate" placeholder="Select Closed Date">
                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" id="closeRemittanceSubmitBtn" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->

    </section><!-- /.content -->
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {

            find_remittance();

            function find_remittance() {
                var path = '{{ route('admin.payments.remittance.index', $clinic->id) }}';
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
                        {
                            data: 'close',
                            name: 'close',
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
                var path = '{{ route('admin.payments.remittance.show') }}';
                $.ajax({
                    url: path,
                    type: 'POST',
                    data: {
                        remittance_id: remittance_id,
                        _token: token
                    },
                    success: function(data) {
                        if (data['status']) {
                            let url =
                                '{{ route('admin.payments.remittance.view', $clinic->id) }}';
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

            $(document).on('click', '.closeRemittanceBtn', function(e){
                e.preventDefault();
                var remittance_id = $(this).data('id');
                var token = '{{ csrf_token() }}';
                var path = '{{ route('admin.payments.remittance.show') }}';
                $.ajax({
                    url: path,
                    type: 'POST',
                    data: {
                        remittance_id: remittance_id,
                        _token: token
                    },
                    success: function(data) {
                        if (data['status']) {
                            $('#closeRemittanceModal').modal('show');
                            $('#closeRemittanceId').val(data['data']['id']);
                            $('#closeRemittanceClaimedAmount').val(data['data']['amount']);
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

            $('#closeRemittanceForm').submit(function(e){
                e.preventDefault();
                var form = $(this);
                var formData = new FormData(form[0]);
                var path = '{{ route('admin.payments.remittance.close') }}';
                $.ajax({
                    url: path,
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    beforeSend: function() {
                        $('#closeRemittanceSubmitBtn').html(
                            '<i class="fa fa-spinner fa-spin"></i>');
                        $('#closeRemittanceSubmitBtn').attr('disabled', true);
                    },
                    complete: function() {
                        $('#closeRemittanceSubmitBtn').html('Save');
                        $('#closeRemittanceSubmitBtn').attr('disabled', false);
                    },
                    success: function(data) {
                        if (data['status']) {
                            toastr.success(data['message']);
                            $('#closeRemittanceForm')[0].reset();
                            $('#closeRemittanceModal').modal('hide');
                            $('#paymentsRemittanceData').DataTable().ajax.reload();
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
