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
                        <div class="col-md-12">
                            <div class="card card-info card-outline">
                                <div class="card-body">
                                    <form action="">
                                        {{ csrf_field() }}
                                        <div class="row">
                                            <div class="col-4">
                                                <div class="form-group">
                                                    <select id="orderNumberSelect" class="form-control select2"
                                                        style="width: 100%;">
                                                        <option selected="selected" disabled="disabled">
                                                            Select order
                                                        </option>
                                                        @forelse ($orders as $order)
                                                            <option value="{{ $order->id }}">
                                                                #{{ $order->id }} - Receipt #
                                                                {{ $order->receipt_number }}
                                                            </option>
                                                        @empty
                                                        @endforelse
                                                    </select>
                                                </div>
                                                <!-- /.form-group -->
                                            </div>
                                            <!--/.col -->

                                            <div class="col-4">
                                                <div class="form-group">
                                                    <select id="orderStatusSelect" class="form-control select2"
                                                        style="width: 100%;">
                                                        <option selected="selected" disabled="disabled">
                                                            Select status
                                                        </option>
                                                        <option value="APPROVED">APPROVED</option>
                                                        <option value="SENT TO WORKSHOP">SENT TO WORKSHOP</option>
                                                        <option value="FRAME SENT TO WORKSHOP">FRAME SENT TO WORKSHOP
                                                        </option>
                                                        <option value="ORDER RECEIVED">ORDER RECEIVED</option>
                                                        <option value="FRAME RECEIVED">FRAME RECEIVED</option>
                                                        <option value="GLAZING">GLAZING</option>
                                                        <option value="RIGHT LENS GLAZED">RIGHT LENS GLAZED</option>
                                                        <option value="GLAZED">GLAZED</option>
                                                        <option value="SEND TO CLINIC">SEND TO CLINIC</option>
                                                        <option value="RECEIVED FROM WORKSHOP">RECEIVED FROM WORKSHOP
                                                        </option>
                                                        <option value="CALL FOR COLLECTION">CALL FOR COLLECTION</option>
                                                        <option value="FRAME COLLECTED">FRAME COLLECTED</option>
                                                        <option value="CLOSED">CLOSED</option>
                                                    </select>
                                                </div>
                                                <!-- /.form-group -->
                                            </div>
                                            <!--/.col -->

                                            <div class="col-2">
                                                <button type="button" id="searchOrderBtn"
                                                    class="btn btn-block btn-outline-success">
                                                    <i class="fa fa-search"></i>
                                                </button>
                                            </div>
                                            <!--/.col -->

                                            <div class="col-2">
                                                <button type="button" id="orderRefreshBtn"
                                                    class="btn btn-block btn-outline-primary">
                                                    <i class="fa fa-refresh"></i>
                                                </button>
                                            </div>
                                            <!--/.col -->
                                        </div>
                                        <!--/.row -->
                                    </form>
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="table-responsive">
                                                <table id="ordersData" class="table table-striped">
                                                    <thead>
                                                        <tr>
                                                            <th></th>
                                                            <th>Order #</th>
                                                            <th>Date</th>
                                                            <th>Receipt #</th>
                                                            <th>Clinic</th>
                                                            <th>Status</th>
                                                            <th>Workshop</th>
                                                            <th>View</th>
                                                        </tr>
                                                    </thead>
                                                </table>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>

                        </div>
                    </div>
                    <!--/.row -->
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

            find_orders();

            function find_orders(status, order_id) {
                let path = '{{ route('admin.patients.orders', [$clinic->id, $patient->id]) }}';
                $('#ordersData').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: path,
                        data: {
                            status: status,
                            order_id: order_id
                        }
                    },
                    columns: [{
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex'
                        },
                        {
                            data: 'order_number',
                            name: 'order_number',
                        },
                        {
                            data: 'date',
                            name: 'date',
                        },
                        {
                            data: 'receipt_number',
                            name: 'receipt_number',
                        },
                        {
                            data: 'clinic',
                            name: 'clinic'
                        },
                        {
                            data: 'status',
                            name: 'status'
                        },
                        {
                            data: 'workshop',
                            name: 'workshop'
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

            $(document).on('click', '.viewOrderBtn', function(e) {
                e.preventDefault();
                let order_id = $(this).data('id');
                let path = '{{ route('admin.orders.show', [':order_id']) }}';
                path = path.replace(':order_id', order_id);
                $.ajax({
                    type: "GET",
                    url: path,
                    dataType: "json",
                    success: function(data) {
                        if (data['status']) {
                            let viewPath =
                                '{{ route('admin.orders.view', [':id', ':order_id']) }}';
                            viewPath = viewPath.replace(':id', {{ $clinic->id }});
                            viewPath = viewPath.replace(':order_id', data['data']['id']);
                            setTimeout(() => {
                                window.location.href = viewPath;
                            }, 500);
                        }
                    }
                });
            });

            $(document).on('click', '#searchOrderBtn', function(e) {
                e.preventDefault();
                let order_id = $('#orderNumberSelect').val();
                let status = $('#orderStatusSelect').val();
                if (order_id != null && status != null) {
                    $('#ordersData').DataTable().destroy();
                    find_orders(status, order_id)
                }

                if (order_id == null && status != null) {
                    $('#ordersData').DataTable().destroy();
                    find_orders(status, order_id)
                }

                if (order_id != null && status == null) {
                    $('#ordersData').DataTable().destroy();
                    find_orders(status, order_id)
                }

                if (order_id == null && status == null) {
                    toastr.error('Please select one')
                }
            });
            $(document).on('click', '#orderRefreshBtn', function(e) {
                $('#orderStatusSelect').val('');
                $('#ordersData').DataTable().destroy();
                find_orders();
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

