@extends('admin.layouts.temp')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{ $patient->first_name }} {{ $patient->last_name }} Payments</h1>
                    <small>Added By: {{ $patient->user->first_name }} {{ $patient->user->last_name }}</small><br>
                    <small>Clinic: {{ $clinic->clinic }}</small>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.dashboard.index', $clinic->id) }}">Home</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.patients.index', $clinic->id) }}">Patients</a>
                        </li>
                        <li class="breadcrumb-item active">
                            Payments
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
                @include('admin.includes.patients.sidebar')
                <div class="col-md-9">
                    <div class="row">
                        <div class="col-md-12 col-12 ">
                            <div class="card card-info card-outline">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table id="paymentsData" class="table table-striped">
                                            <thead>
                                                <tr>
                                                    <th></th>
                                                    <th>Open Date</th>
                                                    <th>Consultation Fee</th>
                                                    <th>Consultation Receipt</th>
                                                    <th>Bill Status</th>
                                                    <th>Claimed Amount</th>
                                                    <th>Agreed Amount</th>
                                                    <th>Total</th>
                                                    <th>Paid</th>
                                                    <th>Balance</th>
                                                    <th>View</th>
                                                </tr>
                                            </thead>
                                        </table>
                                    </div>
                                    <!--/.table-responsive -->
                                </div>
                                <!--/.card-body-->
                            </div>
                        </div>
                        <!--/.col -->
                    </div>
                    <!--/.col -->
                </div>
                <!--/.col -->
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {

            find_payments();
            function find_payments() {
                let path = '{{ route('admin.patients.payments', [$clinic->id, $patient->id]) }}';
                $('#paymentsData').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: path,
                    columns: [{
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex'
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

            $(document).on('click', '.viewPaymentBtn', function(e){
                e.preventDefault();
                let payment_id = $(this).data('id');
                let path = '{{ route('admin.payments.bills.show', ':payment_id') }}';
                path = path.replace(':payment_id', payment_id);
                $.ajax({
                    type: "GET",
                    url: path,
                    dataType: "json",
                    success: function (data) {
                        if(data['status'])
                        {
                            let viewPath = '{{ route('admin.payments.bills.view', [":id", ":payment_id"]) }}';
                            viewPath = viewPath.replace(':id', {{ $clinic->id }});
                            viewPath = viewPath.replace(':payment_id', data['data']['id']);
                            setTimeout(() => {
                                window.location.href = viewPath;
                            }, 500);
                        }
                    }
                });
            });

        });
    </script>
@endpush

@push('patients_script')
    <script>
        $(document).ready(function() {
            $(document).on('click', '.deactivatePatientBtn', function(e) {
                e.preventDefault();
                let patient_id = $(this).data('id');
                let path = '{{ route('admin.patients.deactivate', ':id') }}';
                path = path.replace(':id', patient_id);
                let token = '{{ csrf_token() }}';
                Swal.fire({
                    title: "Are you sure?",
                    text: "You are going to deactivate current patient",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                }).then((result) => {
                    /* Read more about isConfirmed, isDenied below */
                    if (result.isConfirmed) {
                        $.ajax({
                            url: path,
                            type: "POST",
                            data: {
                                patient_id: patient_id,
                                _token: token,
                            },
                            dataType: "json",
                            success: function(data) {
                                if (data['status']) {
                                    Swal.fire(data['message'], '', 'success')
                                    setTimeout(() => {
                                        location.reload();
                                    }, 500);
                                }
                            }
                        });
                    } else if (result.isDenied) {
                        Swal.fire('Changes are not saved', '', 'info');
                    }
                });
            });

            $(document).on('click', '.activatePatientBtn', function(e) {
                e.preventDefault();
                let patient_id = $(this).data('id');
                let path = '{{ route('admin.patients.activate', ':id') }}';
                path = path.replace(':id', patient_id);
                let token = '{{ csrf_token() }}';
                Swal.fire({
                    title: "Are you sure?",
                    text: "You are going to activate current patient",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                }).then((result) => {
                    /* Read more about isConfirmed, isDenied below */
                    if (result.isConfirmed) {
                        $.ajax({
                            url: path,
                            type: "POST",
                            data: {
                                patient_id: patient_id,
                                _token: token,
                            },
                            dataType: "json",
                            success: function(data) {
                                if (data['status']) {
                                    Swal.fire(data['message'], '', 'success')
                                    setTimeout(() => {
                                        location.reload();
                                    }, 500);
                                }
                            }
                        });
                    } else if (result.isDenied) {
                        Swal.fire('Changes are not saved', '', 'info');
                    }
                });
            });
        });
    </script>
@endpush

