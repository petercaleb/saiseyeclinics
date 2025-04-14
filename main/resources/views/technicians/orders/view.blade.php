@extends('technicians.layouts.app')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{ $workshop->name }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ route('technicians.dashboard.index') }}">Home</a>
                        </li>
                        <li class="breadcrumb-item active">
                            <a href="{{ route('technicians.orders.index') }}">Orders</a>
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

            @include('technicians.orders.partials.lens_power_and_clinic')

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

                            {{-- <li class="nav-item">
                                <a class="nav-link" href="#casePrescriptionTab" data-toggle="tab">
                                    Case Prescription
                                </a>
                            </li> --}}

                            <li class="nav-item">
                                <a class="nav-link" href="#orderSalesTab" data-toggle="tab">
                                    Sales & Lenses
                                </a>
                            </li>
                        </ul>
                        <!-- .nav .nav-pills -->
                    </div>
                    <!-- /.card-header -->

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
                            <!-- / .active .tab-pane -->

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
                                <!--.table-responsive -->
                            </div>
                            <!--.tab-pane -->

                            <div class="tab-pane p-0" id="framePrescriptionTab">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <tbody>
                                            <tr>
                                                <th>Frame Code</th>
                                                <td>
                                                    {{ $order->frame_prescription->frame_code }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Frame Brand</th>
                                                <td>
                                                    {{ $order->frame_prescription->frame_stock->frame->frame_brand->title }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Frame Type</th>
                                                <td>
                                                    {{ $order->frame_prescription->frame_stock->frame->frame_type->title }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Frame Size</th>
                                                <td>
                                                    {{ $order->frame_prescription->frame_stock->frame->frame_size->size }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Frame Material</th>
                                                <td>
                                                    {{ $order->frame_prescription->frame_stock->frame->frame_brand->title }}
                                                </td>
                                            </tr>

                                            <tr>
                                                <th>Remarks</th>
                                                <td>
                                                    {{ $order->frame_prescription->remarks }}
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <!--.table-responsive -->
                            </div>
                            <!--.tab-pane -->

                            {{-- <div class="tab-pane p-0" id="casePrescriptionTab">
                            </div>
                            <!--.tab-pane --> --}}


                            <div class="tab-pane" id="orderSalesTab">
                                @include('technicians.orders.sales')
                            </div>
                            <!-- /.tab-pane -->
                        </div>
                        <!--.tab-content -->
                    </div>
                    <!--.card-body -->
                    <div class="card-footer">

                        @include('technicians.orders.partials.buttons')

                    </div>
                    <!--.card-footer -->
                </div>
                <!--.card card-outline card-primary -->
            </div>
            <!--.col-md-6 -->

            @include('technicians.orders.partials.patient_and_doctor')

        </div>
        <!-- /.row -->
    </section>
    <!-- /.content -->
@endsection


@push('modals')
    @include('technicians.includes.modals.track_orders')
    @include('technicians.includes.modals.right_eye_glazing')
    @include('technicians.includes.modals.left_eye_glazing')
    @include('technicians.includes.modals.payments')
@endpush

@push('scripts')
    <script>
        $(document).ready(function() {

            $(document).on('click', '.requestLensBtn', function(e) {
                e.preventDefault();
                $('#requestLensModal').modal('show');
            });

            $('#requestLensForm').submit(function(e) {
                e.preventDefault();
                let form = $(this);
                let formData = new FormData(form[0]);
                let path = '{{ route('technicians.lens.request.store') }}';
                $.ajax({
                    type: "POST",
                    url: path,
                    data: formData,
                    dataType: "json",
                    contentType: false,
                    processData: false,
                    beforeSend: function() {
                        form.find('button[type=submit]').html(
                            '<i class="fa fa-spinner fa-spin"></i>');
                        form.find('button[type=submit]').attr('disabled', true);
                    },
                    complete: function() {
                        form.find('button[type=submit]').html('Send Request');
                        form.find('button[type=submit]').attr('disabled', false);
                    },
                    success: function(data) {
                        if (data['status']) {
                            toastr.success(data['message']);
                            setTimeout(() => {
                                location.reload();
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


            $(document).on('click', '#trackOrderBtn', function(e) {
                e.preventDefault();
                $('#trackOrderModal').modal('show');
            });

            $(document).on('click', '.orderRceceivedBtn', function(e) {
                e.preventDefault();
                var order_id = $(this).data('id');
                var token = '{{ csrf_token() }}';
                var status = $(this).data('value');
                var path = '{{ route('technicians.orders.update', ':id') }}';
                path = path.replace(':id', order_id);
                Swal.fire({
                    title: "Are you sure?",
                    text: "Order has been received from clinic!",
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
                                $('#orderRceceivedBtn').html(
                                    '<i class="fa fa-spinner fa-spin"></i>'
                                );
                                $('#orderRceceivedBtn').attr('disabled', true);
                            },
                            complete: function() {
                                $('#orderRceceivedBtn').html(
                                    'ORDER RECEIVED'
                                );
                                $('#orderRceceivedBtn').attr('disabled', false);
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

            $(document).on('click', '.frameRceceivedBtn', function(e) {
                e.preventDefault();
                var order_id = $(this).data('id');
                var token = '{{ csrf_token() }}';
                var status = $(this).data('value');
                var path = '{{ route('technicians.orders.update', ':id') }}';
                path = path.replace(':id', order_id);
                Swal.fire({
                    title: "Are you sure?",
                    text: "Frame has been received from clinic!",
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
                                $('#frameRceceivedBtn').html(
                                    '<i class="fa fa-spinner fa-spin"></i>'
                                );
                                $('#frameRceceivedBtn').attr('disabled', true);
                            },
                            complete: function() {
                                $('#frameRceceivedBtn').html(
                                    'FRAME RECEIVED'
                                );
                                $('#frameRceceivedBtn').attr('disabled', false);
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


            $(document).on('click', '.glazingBtn', function(e) {
                e.preventDefault();
                var order_id = $(this).data('id');
                var token = '{{ csrf_token() }}';
                var status = $(this).data('value');
                var path = '{{ route('technicians.orders.update', ':id') }}';
                path = path.replace(':id', order_id);
                Swal.fire({
                    title: "Are you sure?",
                    text: "Job has started glazing!",
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
                                $('#glazingBtn').html(
                                    '<i class="fa fa-spinner fa-spin"></i>'
                                );
                                $('#glazingBtn').attr('disabled', true);
                            },
                            complete: function() {
                                $('#glazingBtn').html(
                                    'GLAZING'
                                );
                                $('#glazingBtn').attr('disabled', false);
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

            $(document).on('click', '.rightLensGlazingBtn', function(e) {
                e.preventDefault();
                let order_id = $(this).data('id');
                let token = '{{ csrf_token() }}';
                let path = '{{ route('technicians.orders.show', ':id') }}';
                path = path.replace(':id', order_id);
                $.ajax({
                    type: "POST",
                    url: path,
                    data: {
                        _token: token
                    },
                    dataType: "json",
                    success: function(data) {
                        if (data['status']) {
                            $('#rightLensGlazingModal').modal('show');
                            $('#rightLensGlazingOrderId').val(data['data']['id']);
                        }
                    }
                });

            });

            $('#rightLensGlazingForm').submit(function(e) {
                e.preventDefault();
                let form = $(this);
                var formData = new FormData(form[0]);
                var path = '{{ route('technicians.sales.store') }}';
                $.ajax({
                    url: path,
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    dataType: "json",
                    beforeSend: function() {
                        $('#rightLensGlazingSubmitBtn').html(
                            '<i class="fa fa-spinner fa-spin"></i>'
                        );
                        $('#rightLensGlazingSubmitBtn').attr('disabled', true);
                    },
                    complete: function() {
                        $('#rightLensGlazingSubmitBtn').html('Save');
                        $('#rightLensGlazingSubmitBtn').attr('disabled', false);
                    },
                    success: function(data) {
                        if (data['status']) {
                            toastr.success(data['message']);
                            $('#rightLensGlazingForm')[0].reset();
                            $('#rightLensGlazingModal').modal('hide');
                            setTimeout(() => {
                                location.reload();
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

            $(document).on('click', '.leftLensGlazingBtn', function(e) {
                e.preventDefault();
                let order_id = $(this).data('id');
                let token = '{{ csrf_token() }}';
                let path = '{{ route('technicians.orders.show', ':id') }}';
                path = path.replace(':id', order_id);
                $.ajax({
                    type: "POST",
                    url: path,
                    data: {
                        _token: token
                    },
                    dataType: "json",
                    success: function(data) {
                        if (data['status']) {
                            $('#leftLensGlazingModal').modal('show');
                            $('#leftLensGlazingOrderId').val(data['data']['id']);
                        }
                    }
                });

            });

            $('#leftLensGlazingForm').submit(function(e) {
                e.preventDefault();
                let form = $(this);
                var formData = new FormData(form[0]);
                var path = '{{ route('technicians.sales.store') }}';
                $.ajax({
                    url: path,
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    dataType: "json",
                    beforeSend: function() {
                        $('#leftLensGlazingSubmitBtn').html(
                            '<i class="fa fa-spinner fa-spin"></i>'
                        );
                        $('#leftLensGlazingSubmitBtn').attr('disabled', true);
                    },
                    complete: function() {
                        $('#leftLensGlazingSubmitBtn').html('Save');
                        $('#leftLensGlazingSubmitBtn').attr('disabled', false);
                    },
                    success: function(data) {
                        if (data['status']) {
                            toastr.success(data['message']);
                            $('#leftLensGlazingForm')[0].reset();
                            $('#leftLensGlazingModal').modal('hide');
                            setTimeout(() => {
                                location.reload();
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


            $(document).on('click', '.sendToClinicBtn', function(e) {
                e.preventDefault();
                var order_id = $(this).data('id');
                var token = '{{ csrf_token() }}';
                var status = $(this).data('value');
                var path = '{{ route('technicians.orders.update', ':id') }}';
                path = path.replace(':id', order_id);
                Swal.fire({
                    title: "Are you sure?",
                    text: "Job To be Send Back to Clinic!",
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
                                $('#sendToClinicBtn').html(
                                    '<i class="fa fa-spinner fa-spin"></i>'
                                );
                                $('#sendToClinicBtn').attr('disabled', true);
                            },
                            complete: function() {
                                $('#sendToClinicBtn').html(
                                    'SEND TO CLINIC'
                                );
                                $('#sendToClinicBtn').attr('disabled', false);
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

            $(document).on('click', '#paymentsBillBtn', function(e) {
                e.preventDefault();
                $('#paymentsBillModal').modal('show');
            });

            $(document).on('click', '.addEyeBtn', function(e){
                e.preventDefault();
                let workshop_sale_id = $(this).data('id');
                let path = '{{ route('technicians.sales.update', ':workshopSale') }}';
                path = path.replace(':workshopSale', workshop_sale_id);
                let token = '{{ csrf_token() }}';
                $.ajax({
                    type: "POST",
                    url: path,
                    data:{
                        _token:token
                    },
                    dataType: "json",
                    success: function (data) {
                        if(data['status'])
                        {
                            toastr.success(data['message']);
                            setTimeout(() => {
                                location.reload();
                            }, 1000);
                        }
                    }
                });
            });
        });
    </script>
@endpush
