@extends('admin.layouts.workshop')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Sales and Lenses</h1>
                    <small>{{ $workshop->name }}</small>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.dashboard.workshop.index', $workshop->id) }}">Home</a>
                        </li>
                        <li class="breadcrumb-item active">Sales</li>
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
                            <table id="salesData" class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>Lens Power</th>
                                        <th>Lens Code</th>
                                        <th>Lens Type</th>
                                        <th>Lens Material</th>
                                        <th>Lens Index</th>
                                        <th>Eye</th>
                                        <th>Sold Quantity</th>
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

            find_all_sales();
            function find_all_sales()
            {
                let path = '{{ route('admin.workshop.sales.index', $workshop->id) }}';
                $('#salesData').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: path,
                    columns: [{
                            data: 'lens_power',
                            name: 'lens_power'
                        },
                        {
                            data: 'lens_code',
                            name: 'lens_code',
                        },
                        {
                            data: 'lens_type',
                            name: 'lens_type'
                        },
                        {
                            data: 'lens_material',
                            name: 'lens_material'
                        },
                        {
                            data: 'lens_index',
                            name: 'lens_index'
                        },
                        {
                            data: 'eye',
                            name: 'eye'
                        },
                        {
                            data: 'quantity',
                            name: 'quantity'
                        }
                    ],
                    "autoWidth": false,
                    "responsive": true,
                });
            }

        });
    </script>
@endsection
