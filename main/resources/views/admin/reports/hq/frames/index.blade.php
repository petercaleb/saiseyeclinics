@extends('admin.layouts.app')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Clinic Reports</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.organization.index') }}">Home</a>
                        </li>
                        <li class="breadcrumb-item active">Clinic Reports</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 col-sm-4">
                    <div class="info-box bg-light">
                        <div class="info-box-content">
                            <span class="info-box-text text-center text-muted">
                                Total Frames
                            </span>
                            <span class="info-box-number text-center text-muted mb-0">
                                {{ $total }}
                            </span>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-sm-4">
                    <div class="info-box bg-light">
                        <div class="info-box-content">
                            <span class="info-box-text text-center text-muted">
                                Total Purchased
                            </span>
                            <span class="info-box-number text-center text-muted mb-0">
                                {{ $purchased }}
                            </span>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-sm-4">
                    <div class="info-box bg-light">
                        <div class="info-box-content">
                            <span class="info-box-text text-center text-muted">
                                Total Transfered
                            </span>
                            <span class="info-box-number text-center text-muted mb-0">
                                {{ $transfered }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.row -->

            <div class="row">
                <div class="col-12">
                    <!-- Custom Tabs -->
                    <div class="card">
                        <div class="card-header d-flex p-0">
                            <ul class="nav nav-pills ml-auto p-2">
                                <li class="nav-item">
                                    <a class="nav-link active" href="#tab_1" data-toggle="tab">
                                        Frames Consumption
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#tab_2" data-toggle="tab">
                                        Frames Transfered
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#tab_3" data-toggle="tab">
                                        Frames Purchased
                                    </a>
                                </li>
                            </ul>
                        </div><!-- /.card-header -->
                        <div class="card-body">
                            <div class="tab-content">
                                <div class="tab-pane active" id="tab_1">
                                    <div class="row">
                                        <div class="col-12">
                                            <a href="{{ route('admin.hq.frames.report.export') }}">
                                                <button type="button" class="btn btn-outline-primary fcleloat-right">
                                                    <i class="fas fa-file-excel"></i> Export Excel
                                                </button>
                                            </a>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-12 table-responsive">
                                            <table id="reportsData" class="table table-sm table-bordered table-striped table-hover">
                                                <thead>
                                                    <tr>
                                                        <th></th>
                                                        <th>Frame Code</th>
                                                        <th>Gender</th>
                                                        <th>Color</th>
                                                        <th>Shape</th>
                                                        <th>Opening</th>
                                                        <th>Transfered</th>
                                                        <th>Total</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                            </table>
                                        </div>
                                        <!--/.col -->
                                    </div>
                                    <!--/.row -->
                                </div>
                                <!-- /.tab-pane -->
                                <div class="tab-pane" id="tab_2">
                                    <div class="row">
                                        <div class="col-12">

                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col-12 table-responsive">
                                            <table class="table">

                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.tab-pane -->
                                <div class="tab-pane" id="tab_3">
                                    <div class="row">
                                        <div class="col-12">

                                        </div>
                                    </div>
                                    <br>
                                    <div class="row">
                                        <div class="col-12 table-responsive">
                                            <table class="table">

                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.tab-pane -->
                            </div>
                            <!-- /.tab-content -->
                        </div><!-- /.card-body -->
                    </div>
                    <!-- ./card -->
                </div><!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
    </section>
@endsection

@push('scripts')
    @include('admin.reports.hq.scripts.frames')
@endpush
