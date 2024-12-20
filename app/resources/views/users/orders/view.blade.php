@extends('users.layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{ $clinic->clinic }}</h1>
                    <small>
                        Order Date: {{ date('d-m-Y', strtotime($order->order_date)) }}
                    </small>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ route('users.dashboard.index') }}">Home</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('users.orders.index') }}">
                                @lang('users.page.orders.title')
                            </a>
                        </li>
                        <li class="breadcrumb-item active">
                            View Order
                        </li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">

            @include('users.orders.partials.lens_and_workshop')

            <div class="col-md-6">
                <div class="card card-outline card-primary">
                    <div class="card-header p-2">
                        <ul class="nav nav-pills">

                            <li class="nav-item">
                                <a class="nav-link active" href="#orderDetailsTab" data-toggle="tab">
                                    Order Details
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" href="#lensPrescriptionTab" data-toggle="tab">
                                    Lens Prescription
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" href="#framePrescriptionTab" data-toggle="tab">
                                    Frame Prescription
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link" href="#casePrescriptionTab" data-toggle="tab">
                                    Case Prescription
                                </a>
                            </li>
                        </ul>
                    </div><!-- /.card-header -->
                    <div class="card-body">
                        <div class="tab-content">

                            <div class="active tab-pane" id="orderDetailsTab">
                                <strong><i class="fa fa-calendar mr-1"></i> Date</strong>

                                <p class="text-muted">
                                    {{ date('d-m-Y', strtotime($order->order_date)) }}
                                </p>

                                <hr>

                                <strong><i class="fa fa-sticky-note mr-1"></i> Order Receipt</strong>

                                <p class="text-muted">
                                    {{ $order->receipt_number }}
                                </p>

                                <hr>

                                <strong><i class="fa fa-cog mr-1"></i> Status</strong>

                                <p class="text-muted">
                                    {{ $order->status }}
                                </p>

                            </div>
                            <!-- /.tab-pane -->

                            <div class="tab-pane" id="lensPrescriptionTab">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <tbody>
                                            <tr>
                                                <th>Lens Type</th>
                                                <td>
                                                    {{ $order->lens_prescription->lens_type->type }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Lens Material</th>
                                                <td>
                                                    {{ $order->lens_prescription->lens_material->title }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Lens Index/Thickness</th>
                                                <td>
                                                    {{ $order->lens_prescription->index }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Tint</th>
                                                <td>
                                                    {{ $order->lens_prescription->tint }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Diameter</th>
                                                <td>
                                                    {{ $order->lens_prescription->diameter }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Focal Height</th>
                                                <td>
                                                    {{ $order->lens_prescription->focal_height }}
                                                </td>
                                            </tr>

                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="tab-pane" id="framePrescriptionTab">
                                <strong><i class="fa fa-archive mr-1"></i> Frame Code</strong>

                                <p class="text-muted">
                                    {{ $order->frame_prescription->frame_code }}
                                </p>

                                <hr>

                                <strong><i class="fa fa-user mr-1"></i> Gender</strong>

                                <p class="text-muted">{{ $order->frame_prescription->frame_stock->hq_stock->gender }}</p>

                                <hr>

                                <strong><i class="fab fa-creative-commons-share mr-1"></i> Shape</strong>

                                <p class="text-muted">
                                    {{ $order->frame_prescription->frame_stock->hq_stock->frame_shape->shape }}</p>

                                <hr>

                                <strong><i class="fas fa-ankh mr-1"></i> Color</strong>

                                <p class="text-muted">
                                    {{ $order->frame_prescription->frame_stock->hq_stock->frame_color->color }}</p>

                            </div>
                            <!-- /.tab-pane -->


                            <div class="tab-pane" id="casePrescriptionTab">
                                <strong><i class="fa fa-archive mr-1"></i> Case Code</strong>

                                <p class="text-muted">
                                    {{ $order->frame_prescription->case_code }}
                                </p>

                                <hr>

                                <strong><i class="fas fa-ankh mr-1"></i> Case Color</strong>

                                <p class="text-muted">
                                    {{ $order->frame_prescription->case_stock->hqStock->frame_case->case_color->title }}
                                </p>

                                <hr>

                                <strong><i class="fab fa-creative-commons-share mr-1"></i> Case Shape</strong>

                                <p class="text-muted">
                                    {{ $order->frame_prescription->case_stock->hqStock->frame_case->case_shape->title }}
                                </p>

                                <hr>

                                <strong><i class="fas fa-arrows-alt mr-1"></i> Case Size</strong>

                                <p class="text-muted">
                                    {{ $order->frame_prescription->case_stock->hqStock->frame_case->case_size->title }}</p>

                            </div>
                            <!-- /.tab-pane -->

                        </div>
                        <!-- /.tab-content -->
                    </div><!-- /.card-body -->
                    <div class="card-footer">
                        @include('users.orders.partials.buttons')
                    </div>
                </div>
                <!-- /.nav-tabs-custom -->
            </div>
            <!-- /.col -->

            @include('users.orders.partials.patient_and_doctor')
        </div>
        <!-- /.row -->
    </section>
    <!-- /.content -->
@endsection


@push('modals')
    @include('users.includes.modals.track_orders')
@endpush

@push('scripts')
    <script>
        $(document).ready(function() {

            $(document).on('click', '.orderSentToWorkshopBtn', function(e) {
                e.preventDefault();
                var order_id = $(this).data('id');
                var token = '{{ csrf_token() }}';
                var status = $(this).data('value');
                var path = '{{ route('users.orders.update', $order->id) }}';

                Swal.fire({
                    title: "Are you sure?",
                    text: "You are about to sent order to workshop!",
                    icon: "success",
                    buttons: true,
                    dangerMode: true,
                }).then((result) => {
                    /* Read more about isConfirmed, isDenied below */
                    if (result.isConfirmed) {
                        $.ajax({
                            url: path,
                            type: 'POST',
                            data: {
                                order_id: order_id,
                                status: status,
                                _token: token
                            },
                            dataType: "json",
                            beforeSend: function() {
                                $('#sendOrderToWorkshopBtn').html(
                                    '<i class="fa fa-spinner fa-spin"></i>'
                                );
                                $('#sendOrderToWorkshopBtn').attr('disabled', true);
                            },
                            complete: function() {
                                $('#sendOrderToWorkshopBtn').html(
                                    'ORDER SENT TO WORKSHOP'
                                );
                                $('#sendOrderToWorkshopBtn').attr('disabled', false);
                            },
                            success: function(data) {
                                if (data['status']) {
                                    toastr.success(data['message']);
                                    setTimeout(() => {
                                        window.location.reload();
                                    }, 1000);
                                }
                            },

                        });
                    } else if (result.isDenied) {
                        Swal.fire('Changes are not saved', '', 'info');
                    }
                });
            });

            $(document).on('click', '.orderfRAMESentToWorkshopBtn', function(e) {
                e.preventDefault();
                var order_id = $(this).data('id');
                var token = '{{ csrf_token() }}';
                var status = $(this).data('value');
                var path = '{{ route('users.orders.update', $order->id) }}';

                Swal.fire({
                    title: "Are you sure?",
                    text: "You are about to sent frame to workshop!",
                    icon: "success",
                    buttons: true,
                    dangerMode: true,
                }).then((result) => {
                    /* Read more about isConfirmed, isDenied below */
                    if (result.isConfirmed) {
                        $.ajax({
                            url: path,
                            type: 'POST',
                            data: {
                                order_id: order_id,
                                status: status,
                                _token: token
                            },
                            dataType: "json",
                            beforeSend: function() {
                                $('#sendFrameSentToWorkshopBtn').html(
                                    '<i class="fa fa-spinner fa-spin"></i>'
                                );
                                $('#sendFrameSentToWorkshopBtn').attr('disabled', true);
                            },
                            complete: function() {
                                $('#sendFrameSentToWorkshopBtn').html(
                                    'FRAME SENT TO WORKSHOP'
                                );
                                $('#sendFrameSentToWorkshopBtn').attr('disabled',
                                    false);
                            },
                            success: function(data) {
                                if (data['status']) {
                                    toastr.success(data['message']);
                                    setTimeout(() => {
                                        window.location.reload();
                                    }, 1000);
                                }
                            },

                        });
                    } else if (result.isDenied) {
                        Swal.fire('Changes are not saved', '', 'info');
                    }
                });
            });

            $(document).on('click', '.receivedFromWorkshopBtn', function(e) {
                e.preventDefault();
                var order_id = $(this).data('id');
                var token = '{{ csrf_token() }}';
                var status = $(this).data('value');
                var path = '{{ route('users.orders.update', $order->id) }}';

                Swal.fire({
                    title: "Are you sure?",
                    text: "You have received the order and frame from workshop!",
                    icon: "success",
                    buttons: true,
                    dangerMode: true,
                }).then((result) => {
                    /* Read more about isConfirmed, isDenied below */
                    if (result.isConfirmed) {
                        $.ajax({
                            url: path,
                            type: 'POST',
                            data: {
                                order_id: order_id,
                                status: status,
                                _token: token
                            },
                            dataType: "json",
                            beforeSend: function() {
                                $('#receivedFromWorkshopBtn').html(
                                    '<i class="fa fa-spinner fa-spin"></i>'
                                );
                                $('#receivedFromWorkshopBtn').attr('disabled', true);
                            },
                            complete: function() {
                                $('#receivedFromWorkshopBtn').html(
                                    'RECEIVED FROM WORKSHOP'
                                );
                                $('#receivedFromWorkshopBtn').attr('disabled',
                                    false);
                            },
                            success: function(data) {
                                if (data['status']) {
                                    toastr.success(data['message']);
                                    setTimeout(() => {
                                        window.location.reload();
                                    }, 1000);
                                }
                            },

                        });
                    } else if (result.isDenied) {
                        Swal.fire('Changes are not saved', '', 'info');
                    }
                });
            });

            $(document).on('click', '.callForCollectionBtn', function(e) {
                e.preventDefault();
                var order_id = $(this).data('id');
                var token = '{{ csrf_token() }}';
                var status = $(this).data('value');
                var path = '{{ route('users.orders.update', $order->id) }}';

                Swal.fire({
                    title: "Are you sure?",
                    text: "You want to call the patient to collect the order!",
                    icon: "success",
                    buttons: true,
                    dangerMode: true,
                }).then((result) => {
                    /* Read more about isConfirmed, isDenied below */
                    if (result.isConfirmed) {
                        $.ajax({
                            url: path,
                            type: 'POST',
                            data: {
                                order_id: order_id,
                                status: status,
                                _token: token
                            },
                            dataType: "json",
                            beforeSend: function() {
                                $('#callForCollectionBtn').html(
                                    '<i class="fa fa-spinner fa-spin"></i>'
                                );
                                $('#callForCollectionBtn').attr('disabled', true);
                            },
                            complete: function() {
                                $('#callForCollectionBtn').html(
                                    'CALL FOR COLLECTION'
                                );
                                $('#callForCollectionBtn').attr('disabled',
                                    false);
                            },
                            success: function(data) {
                                if (data['status']) {
                                    toastr.success(data['message']);
                                    setTimeout(() => {
                                        window.location.reload();
                                    }, 1000);
                                }
                            },

                        });
                    } else if (result.isDenied) {
                        Swal.fire('Changes are not saved', '', 'info');
                    }
                });
            });

            $(document).on('click', '.frameCollectedBtn', function(e) {
                e.preventDefault();
                var order_id = $(this).data('id');
                var token = '{{ csrf_token() }}';
                var status = $(this).data('value');
                var path = '{{ route('users.orders.update', $order->id) }}';

                Swal.fire({
                    title: "Are you sure?",
                    text: "Frame has already been collected!",
                    icon: "success",
                    buttons: true,
                    dangerMode: true,
                }).then((result) => {
                    /* Read more about isConfirmed, isDenied below */
                    if (result.isConfirmed) {
                        $.ajax({
                            url: path,
                            type: 'POST',
                            data: {
                                order_id: order_id,
                                status: status,
                                _token: token
                            },
                            dataType: "json",
                            beforeSend: function() {
                                $('#frameCollectedBtn').html(
                                    '<i class="fa fa-spinner fa-spin"></i>'
                                );
                                $('#frameCollectedBtn').attr('disabled', true);
                            },
                            complete: function() {
                                $('#frameCollectedBtn').html(
                                    'CALL FOR COLLECTION'
                                );
                                $('#frameCollectedBtn').attr('disabled',
                                    false);
                            },
                            success: function(data) {
                                if (data['status']) {
                                    toastr.success(data['message']);
                                    setTimeout(() => {
                                        window.location.reload();
                                    }, 1000);
                                }
                            },

                        });
                    } else if (result.isDenied) {
                        Swal.fire('Changes are not saved', '', 'info');
                    }
                });
            });

            $(document).on('click', '.closedBtn', function(e) {
                e.preventDefault();
                var order_id = $(this).data('id');
                var token = '{{ csrf_token() }}';
                var status = $(this).data('value');
                var path = '{{ route('users.orders.update', $order->id) }}';

                Swal.fire({
                    title: "Are you sure?",
                    text: "You want to close this order",
                    icon: "success",
                    buttons: true,
                    dangerMode: true,
                }).then((result) => {
                    /* Read more about isConfirmed, isDenied below */
                    if (result.isConfirmed) {
                        $.ajax({
                            url: path,
                            type: 'POST',
                            data: {
                                order_id: order_id,
                                status: status,
                                _token: token
                            },
                            dataType: "json",
                            beforeSend: function() {
                                $('#closedBtn').html(
                                    '<i class="fa fa-spinner fa-spin"></i>'
                                );
                                $('#closedBtn').attr('disabled', true);
                            },
                            complete: function() {
                                $('#closedBtn').html(
                                    'CLOSED'
                                );
                                $('#closedBtn').attr('disabled',
                                    false);
                            },
                            success: function(data) {
                                if (data['status']) {
                                    toastr.success(data['message']);
                                    setTimeout(() => {
                                        window.location.reload();
                                    }, 1000);
                                }
                            },

                        });
                    } else if (result.isDenied) {
                        Swal.fire('Changes are not saved', '', 'info');
                    }
                });
            });

            $(document).on('click', '#trackOrderBtn', function(e) {
                e.preventDefault();
                $('#trackOrderModal').modal('show');
            });
        });
    </script>
@endpush
