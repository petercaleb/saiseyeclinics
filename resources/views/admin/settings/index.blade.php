@extends('admin.layouts.app')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Settings</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.organization.index') }}">Home</a>
                        </li>
                        <li class="breadcrumb-item active">Settings</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">

            <div class="row">

                <div class="col-md-3 col-sm-6 col-12">
                    <a href="{{ route('admin.client.type.index') }}">
                        <div class="info-box">
                            <span class="info-box-icon bg-info">
                                <i class="fa fa-hand-spock-o"></i>
                            </span>

                            <div class="info-box-content">
                                <span class="info-box-text">
                                    Client Type
                                </span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </a>

                </div>
                <!-- /.col -->

                <div class="col-md-3 col-sm-6 col-12">
                    <a href="{{ route('admin.insurance.index') }}">
                        <div class="info-box">
                            <span class="info-box-icon bg-warning">
                                <i class="fa fa-building"></i>
                            </span>

                            <div class="info-box-content">
                                <span class="info-box-text">
                                    Insurance
                                </span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </a>

                </div>
                <!-- /.col -->

                <div class="col-md-3 col-sm-6 col-12">
                    <a href="{{ route('admin.settings.workshops.vendors.index') }}">
                        <div class="info-box">
                            <span class="info-box-icon bg-secondary">
                                <i class="fa fa-briefcase"></i>
                            </span>

                            <div class="info-box-content">
                                <span class="info-box-text">
                                    Vendors
                                </span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </a>

                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->

            <h5 class="mb-2">
                Lens Settings
            </h5>

            <div class="row">
                <div class="col-md-3 col-sm-6 col-12">
                    <a href="{{ route('admin.settings.workshops.lens.type.index') }}">
                        <div class="info-box">
                            <span class="info-box-icon bg-info">
                                <i class="fa fa-cubes"></i>
                            </span>

                            <div class="info-box-content">
                                <span class="info-box-text">
                                    Lens Type
                                </span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </a>

                </div>
                <!-- /.col -->

                <div class="col-md-3 col-sm-6 col-12">
                    <a href="{{ route('admin.settings.workshops.lens.material.index') }}">
                        <div class="info-box">
                            <span class="info-box-icon bg-warning">
                                <i class="fa fa-diamond"></i>
                            </span>

                            <div class="info-box-content">
                                <span class="info-box-text">
                                    Lens Material
                                </span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </a>

                </div>
                <!-- /.col -->

                <div class="col-md-3 col-sm-6 col-12">
                    <a href="{{ route('admin.settings.workshops.coating.index') }}">
                        <div class="info-box">
                            <span class="info-box-icon bg-danger">
                                <i class="fa fa-hand-lizard-o"></i>
                            </span>

                            <div class="info-box-content">
                                <span class="info-box-text">
                                    Lens Coating
                                </span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </a>
                </div>
                <!-- /.col -->

                <div class="col-md-3 col-sm-6 col-12">
                    <a href="{{ route('admin.settings.workshops.lens.index.index') }}">
                        <div class="info-box">
                            <span class="info-box-icon bg-primary">
                                <i class="fa fa-hourglass-end"></i>
                            </span>

                            <div class="info-box-content">
                                <span class="info-box-text">
                                    Lens Index
                                </span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </a>
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->

            <h5 class="mb-2">
                Assets Settings
            </h5>

            <div class="row">
                <div class="col-md-3 col-sm-6 col-12">
                    <a href="{{ route('admin.settings.clinics.assets.type.index') }}">
                        <div class="info-box">
                            <span class="info-box-icon bg-default">
                                <i class="fa fa-database"></i>
                            </span>

                            <div class="info-box-content">
                                <span class="info-box-text">
                                    Assets Type
                                </span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </a>

                </div>
                <!-- /.col -->
                <div class="col-md-3 col-sm-6 col-12">
                    <a href="{{ route('admin.settings.clinics.assets.conditions.index') }}">
                        <div class="info-box">
                            <span class="info-box-icon bg-info">
                                <i class="fa fa-diamond"></i>
                            </span>

                            <div class="info-box-content">
                                <span class="info-box-text">
                                    Assets Condition
                                </span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </a>

                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->

            <h5 class="mb-2">Frames</h5>
            
            <div class="row">
                <div class="col-md-3 col-sm-6 col-12">
                    <a href="{{ route('admin.settings.clinics.frames.type.index') }}">
                        <div class="info-box">
                            <span class="info-box-icon bg-danger">
                                <i class="fa fa-hourglass-end"></i>
                            </span>

                            <div class="info-box-content">
                                <span class="info-box-text">
                                    Frame Type
                                </span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </a>
                </div>
                <!-- /.col -->
                <div class="col-md-3 col-sm-6 col-12">
                    <a href="{{ route('admin.settings.clinics.frames.materials.index') }}">
                        <div class="info-box">
                            <span class="info-box-icon bg-secondary">
                                <i class="fa fa-clone"></i>
                            </span>

                            <div class="info-box-content">
                                <span class="info-box-text">
                                    Frame Materials
                                </span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </a>

                </div>
                <!-- /.col -->

                <div class="col-md-3 col-sm-6 col-12">
                    <a href="{{ route('admin.settings.clinics.frames.brands.index') }}">
                        <div class="info-box">
                            <span class="info-box-icon bg-warning">
                                <i class="fa fa-registered"></i>
                            </span>

                            <div class="info-box-content">
                                <span class="info-box-text">
                                    Frame Brands
                                </span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </a>
                </div>
                <!-- /.col -->

                <div class="col-md-3 col-sm-6 col-12">
                    <a href="{{ route('admin.settings.clinics.frames.sizes.index') }}">
                        <div class="info-box">
                            <span class="info-box-icon bg-primary">
                                <i class="fa fa-anchor"></i>
                            </span>

                            <div class="info-box-content">
                                <span class="info-box-text">
                                    Frame Sizes
                                </span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </a>
                </div>
                <!-- /.col -->

                <div class="col-md-3 col-sm-6 col-12">
                    <a href="{{ route('admin.settings.clinics.frames.colors.index') }}">
                        <div class="info-box">
                            <span class="info-box-icon bg-success">
                                <i class="fa fa-pie-chart"></i>
                            </span>

                            <div class="info-box-content">
                                <span class="info-box-text">
                                    Frame Colors
                                </span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </a>
                </div>
                <!-- /.col -->

                <div class="col-md-3 col-sm-6 col-12">
                    <a href="{{ route('admin.settings.clinics.frames.shapes.index') }}">
                        <div class="info-box">
                            <span class="info-box-icon bg-info">
                                <i class="fa fa-square"></i>
                            </span>

                            <div class="info-box-content">
                                <span class="info-box-text">
                                    Frame Shapes
                                </span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </a>
                </div>
                <!-- /.col -->

                <div class="col-md-3 col-sm-6 col-12">
                    <a href="{{ route('admin.settings.clinics.frames.all.index') }}">
                        <div class="info-box">
                            <span class="info-box-icon bg-primary">
                                <i class="fa  fa-file-text"></i>
                            </span>

                            <div class="info-box-content">
                                <span class="info-box-text">
                                    Frames
                                </span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </a>
                </div>
                <!-- /.col -->

            </div>
            <!-- /.row -->

            <h5 class="mb-2">Sun Glasses</h5>

            <div class="row">
                <div class="col-md-3 col-sm-6 col-12">
                    <a href="{{ route('admin.settings.clinics.glasses.colors.index') }}">
                        <div class="info-box">
                            <span class="info-box-icon bg-info">
                                <i class="fa fa-pie-chart"></i>
                            </span>

                            <div class="info-box-content">
                                <span class="info-box-text">
                                    Colors
                                </span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </a>
                </div>
                <!-- /.col -->

                {{-- <div class="col-md-3 col-sm-6 col-12">
                    <a href="#">
                        <div class="info-box">
                            <span class="info-box-icon bg-warning">
                                <i class="fa fa-registered"></i>
                            </span>

                            <div class="info-box-content">
                                <span class="info-box-text">
                                    Brands
                                </span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </a>
                </div> --}}
                <!-- /.col -->

                <div class="col-md-3 col-sm-6 col-12">
                    <a href="{{ route('admin.settings.clinics.glasses.sizes.index') }}">
                        <div class="info-box">
                            <span class="info-box-icon bg-primary">
                                <i class="fa fa-anchor"></i>
                            </span>

                            <div class="info-box-content">
                                <span class="info-box-text">
                                    Sizes
                                </span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </a>
                </div>
                <!-- /.col -->

                <div class="col-md-3 col-sm-6 col-12">
                    <a href="{{ route('admin.settings.clinics.glasses.shapes.index') }}">
                        <div class="info-box">
                            <span class="info-box-icon bg-danger">
                                <i class="fa fa-circle-thin"></i>
                            </span>

                            <div class="info-box-content">
                                <span class="info-box-text">
                                    Shapes
                                </span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </a>
                </div>
                <!-- /.col -->

            </div>

            <h5 class="mb-2">Cases</h5>

            <div class="row">
                <div class="col-md-3 col-sm-6 col-12">
                    <a href="{{ route('admin.settings.workshops.cases.color.index') }}">
                        <div class="info-box">
                            <span class="info-box-icon bg-info">
                                <i class="fa fa-pie-chart"></i>
                            </span>

                            <div class="info-box-content">
                                <span class="info-box-text">
                                    @lang('pages.settings.cases.colors')
                                </span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </a>
                </div>
                <!-- /.col -->

                <div class="col-md-3 col-sm-6 col-12">
                    <a href="{{ route('admin.settings.workshops.cases.sizes.index') }}">
                        <div class="info-box">
                            <span class="info-box-icon bg-primary">
                                <i class="fa fa-anchor"></i>
                            </span>

                            <div class="info-box-content">
                                <span class="info-box-text">
                                    @lang('pages.settings.cases.size')
                                </span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </a>
                </div>
                <!-- /.col -->

                <div class="col-md-3 col-sm-6 col-12">
                    <a href="{{ route('admin.settings.workshops.cases.shapes.index') }}">
                        <div class="info-box">
                            <span class="info-box-icon bg-danger">
                                <i class="fa fa-circle-thin"></i>
                            </span>

                            <div class="info-box-content">
                                <span class="info-box-text">
                                    @lang('pages.settings.cases.shapes')
                                </span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </a>
                </div>
                <!-- /.col -->

                <div class="col-md-3 col-sm-6 col-12">
                    <a href="{{ route('admin.settings.workshops.cases.frame.cases.index') }}">
                        <div class="info-box">
                            <span class="info-box-icon bg-secondary">
                                <i class="fa fa-circle-thin"></i>
                            </span>

                            <div class="info-box-content">
                                <span class="info-box-text">
                                    Cases
                                </span>
                            </div>
                            <!-- /.info-box-content -->
                        </div>
                        <!-- /.info-box -->
                    </a>
                </div>
                <!-- /.col -->
                
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection

@section('scripts')
@endsection
