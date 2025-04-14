@extends('admin.layouts.temp')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{ $clinic->clinic }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.dashboard.index', $clinic->id) }}">Home</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.patients.orders', [$clinic->id, $order->patient->id]) }}">
                                Patient Profile
                            </a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.orders.index', $clinic->id) }}">Orders</a>
                        </li>
                        <li class="breadcrumb-item active">View Order</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">

            @include('admin.orders.clinics.order_workshop')

            <div class="col-md-6">
                <div class="card card-outline card-primary">
                    <div class="card-header p-2">
                        <ul class="nav nav-pills">

                            <li class="nav-item">
                                <a class="nav-link active" href="#lensPowerTab" data-toggle="tab">
                                    Lens Power
                                </a>
                            </li>


                            {{-- <li class="nav-item">
                                <a class="nav-link" href="#orderDetailsTab" data-toggle="tab">
                                    Order Details
                                </a>
                            </li> --}}

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
                        </ul>
                    </div><!-- /.card-header -->
                    <div class="card-body">
                        <div class="tab-content">

                            <div class="active tab-pane" id="lensPowerTab">
                                @include('admin.orders.clinics.lens_power')
                            </div>
                            <!-- /.tab-pane -->

                            {{-- <div class="tab-pane" id="orderDetailsTab">
                                @include('admin.orders.clinics.order_details')
                            </div>
                            <!-- /.tab-pane --> --}}

                            <div class="tab-pane" id="lensPrescriptionTab">
                                @include('admin.orders.clinics.lens_prescription')
                            </div>

                            <div class="tab-pane" id="framePrescriptionTab">
                                @include('admin.orders.clinics.frame_prescription')
                            </div>
                            <!-- /.tab-pane -->
                        </div>
                        <!-- /.tab-content -->
                    </div><!-- /.card-body -->
                    <div class="card-footer">
                        @include('admin.orders.clinics.buttons')
                    </div>
                </div>
                <!-- /.nav-tabs-custom -->
            </div><!-- /.col -->

            @include('admin.orders.clinics.patient_doctor')
        </div>
        <!-- /.row -->


    </section>
    <!-- /.content -->
@endsection

@push('modals')
    @include('admin.includes.partials.modals.track_orders')
@endpush

@push('scripts')
    <script>
        $(document).ready(function() {
            $(document).on('click', '#trackOrderBtn', function(e) {
                e.preventDefault();
                $('#trackOrderModal').modal('show');
            });
        });
    </script>
@endpush
