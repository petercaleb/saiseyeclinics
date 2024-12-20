@extends('admin.layouts.workshop')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Orders</h1>
                    <small>{{ $workshop->name }}</small>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.dashboard.workshop.index', $workshop->id) }}">Home</a>
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
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body table-responsive">
                            <table id="ordersData" class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Patient</th>
                                        <th>Clinic</th>
                                        <th>Status</th>
                                        <th>Workshop</th>
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

            find_orders();

            function find_orders() {
                let path = '{{ route('admin.workshop.orders.index', $workshop->id) }}';
                $('#ordersData').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: path,
                    columns: [{
                            data: 'order_date',
                            name: 'order_date'
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

            $(document).on('click', '.viewOrderBtn', function(e) {
                e.preventDefault();
                var order_id = $(this).data('id');
                var token = "{{ csrf_token() }}";
                var path = '{{ route('admin.workshop.orders.show') }}';
                $.ajax({
                    type: "POST",
                    url: path,
                    data: {
                        order_id: order_id,
                        _token: token
                    },
                    dataType: "json",
                    success: function(data) {
                        if (data['status']) {
                            let order_path =
                                '{{ route('admin.workshop.orders.view', $workshop->id) }}';
                            setTimeout(() => {
                                window.location.href = order_path;
                            }, 1000);
                        }
                    }
                });
            })

        });
    </script>
@endsection
