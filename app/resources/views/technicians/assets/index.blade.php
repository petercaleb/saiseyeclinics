@extends('technicians.layouts.app')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Assets</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ route('technicians.dashboard.index') }}">Home</a>
                        </li>
                        <li class="breadcrumb-item active">Assets</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-4 col-sm-6 col-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-info">
                            <i class="fa fa-book"></i>
                        </span>

                        <div class="info-box-content">
                            <span class="info-box-text">Assets</span>
                            <span class="info-box-number">{{ $num_assets }}</span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
                <!-- /.col -->
            </div>
            <!--.row -->

            <div class="row">
                <div class="col-12">

                    <div class="card card-primary card-outline card-outline-tabs">
                        <div class="card-header p-0 border-bottom-0">
                            <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="custom-tabs-four-home-tab" data-toggle="pill"
                                        href="#custom-tabs-four-home" role="tab" aria-controls="custom-tabs-four-home"
                                        aria-selected="true">
                                        Assets
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <!---.card-header p-0 border-bottom-0-->
                        <div class="card-body">
                            <div class="tab-content" id="custom-tabs-four-tabContent">
                                <div class="tab-pane fade show active" id="custom-tabs-four-home" role="tabpanel"
                                    aria-labelledby="custom-tabs-four-home-tab">

                                    <div class="table-responsive">
                                        <table id="assetsData" class="table table-striped table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Asset</th>
                                                    <th>Type</th>
                                                    <th>Condition</th>
                                                    <th>Serial Number</th>
                                                    <th>Quantity</th>
                                                    <th>Description</th>
                                                    <th>Purchased Date</th>
                                                    <th>Cost</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                            </tbody>
                                        </table>
                                    </div>

                                </div>

                            </div>
                            <!--.tab-content-->
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!--.card card-primary card-outline card-outline-tabs -->

                </div><!-- /.col -->
            </div><!-- /.row -->

        </div>
        <!--.container-fluid -->
    </section>
    <!-- /.content -->
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {

            find_assets();

            function find_assets(){
                var path = '{{ route('technicians.assets.index') }}';
                $('#assetsData').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: path,
                    "responsive": true,
                    "autoWidth": false,
                    columns: [{
                            data: 'asset',
                            name: 'asset'
                        },
                        {
                            data: 'type',
                            name: 'type'
                        },
                        {
                            data: 'condition',
                            name: 'condition'
                        },
                        {
                            data: 'serial_number',
                            name: 'serial_number'
                        },
                        {
                            data: 'quantity',
                            name: 'quantity'
                        },
                        {
                            data: 'description',
                            name: 'description'
                        },
                        {
                            data: 'purchase_date',
                            name: 'purchase_date'
                        },
                        {
                            data: 'purchase_cost',
                            name: 'purchase_cost'
                        },    
                    ]
                });
            }

        });
    </script>
@endsection
