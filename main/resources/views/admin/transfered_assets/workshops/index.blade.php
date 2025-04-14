@extends('admin.layouts.workshop')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>
                        Transfered Assets
                    </h1>
                    <small>{{ $workshop->name }}</small>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.dashboard.workshop.index', $workshop->id) }}">Home</a>
                        </li>
                        <li class="breadcrumb-item active">
                            Transfered Assets
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
                <div class="col-12">
                    <div class="card">
                        <div class="card-body table-responsive">
                            <table id="transferedAssetsData" class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>Asset</th>
                                        <th>Transfered To</th>
                                        <th>Transfered Date</th>
                                        <th>Type</th>
                                        <th>Condition</th>
                                        <th>Quantity</th>
                                        <th>Remarks</th>
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

            find_transfered_assets();
            function find_transfered_assets() 
            {
                var path = '{{ route('admin.workshop.assets.transfer.index', $workshop->id) }}';
                $('#transferedAssetsData').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: path,
                    columns: [{
                            data: 'asset',
                            name: 'asset'
                        },
                        {
                            data: 'transfer_to',
                            name: 'transfer_to'
                        },
                        {
                            data: 'transfer_date',
                            name: 'transfer_date'
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
                            data: 'quantity',
                            name: 'quantity'
                        },
                        {
                            data: 'remarks',
                            name: 'remarks'
                        },
                    ],
                    'autoWidth': false,
                    'responsive': true,
                });
            }

        });
    </script>
@endsection
