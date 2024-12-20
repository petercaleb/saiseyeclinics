@extends('admin.layouts.temp')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Orders</h1>
                    <small>{{ $clinic->clinic }}</small>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.dashboard.index', $clinic->id) }}">Home</a>
                        </li>
                        <li class="breadcrumb-item active">Orders</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <form>
                <div class="row">
                    {{-- <div class="col-4">
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
                    <!--/.col --> --}}
                    <div class="col-8">
                        <div class="form-group">
                            <select id="orderStatusSelect" class="form-control select2" style="width: 100%;">
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
                        <button type="button" id="searchOrderBtn" class="btn btn-block btn-outline-success">
                            <i class="fa fa-search"></i>
                        </button>
                    </div>
                    <!--/.col -->

                    <div class="col-2">
                        <button type="button" id="orderRefreshBtn" class="btn btn-block btn-outline-primary">
                            <i class="fa fa-refresh"></i>
                        </button>
                    </div>
                    <!--/.col -->
                </div>
                <!--/.row -->
            </form>


            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="    card-body table-responsive">
                            <table id="ordersData" class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Receipt #</th>
                                        <th>Patient</th>
                                        <th>Clinic</th>
                                        <th>Status</th>
                                        <th>Workshop</th>
                                        <th>TAT One</th>
                                        <th>TAT Two</th>
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
            find_orders();

            function find_orders(order_id, status) {
                var path = '{{ route('admin.orders.index', $clinic->id) }}';
                $('#ordersData').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: path,
                        data:{
                            order_id : order_id,
                            status:status
                        }
                    },
                    columns: [{
                            data: 'order_date',
                            name: 'order_date'
                        },
                        {
                            data: 'receipt_number',
                            name: 'receipt_number',
                        },
                        {
                            data: 'full_names',
                            name: 'full_names',
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
                            data: 'tat_one',
                            name: 'tat_one'
                        },
                        {
                            data: 'tat_two',
                            name: 'tat_two'
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

            $(document).on('click', '#searchOrderBtn', function(e){
                e.preventDefault();
                let order_id = $('#orderNumberSelect').val();   
                let status = $('#orderStatusSelect').val();
                if (order_id != null && status != null) {
                    $('#ordersData').DataTable().destroy();
                    find_orders(order_id, status)
                }

                if (order_id == null && status != null) {
                    $('#ordersData').DataTable().destroy();
                    find_orders(order_id, status)
                }

                if (order_id != null && status == null) {
                    $('#ordersData').DataTable().destroy();
                    find_orders(order_id, status)
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

            $(document).on('click', '.viewOrderBtn', function(e) {
                e.preventDefault();
                let order_id = $(this).data('id');
                let path = '{{ route('admin.orders.show', ':id') }}';
                path = path.replace(':id', order_id);
                $.ajax({
                    url: path,
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        if (data['status']) {
                            let url = '{{ route('admin.orders.view', [':id', ':order_id']) }}';
                            url = url.replace(':id', {{ $clinic->id }});
                            url = url.replace(':order_id', data['data']['id']);
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
