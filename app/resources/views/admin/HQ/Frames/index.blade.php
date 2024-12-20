@extends('admin.layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{ $organization->organization }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.organization.index') }}">Home</a>
                        </li>
                        <li class="breadcrumb-item active">
                            {{ $page_title }}
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
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>{{ count($stocks) }}</h3>

                            <p>Frame Stocks</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-address-card"></i>
                        </div>
                        <a href="javascript:void(0)" class="small-box-footer newFrameStockBtn">
                            New Frame Stock <i class="fa fa-plus"></i>
                        </a>
                    </div>
                </div>
                <!-- ./col -->
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card card-primary card-outline">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="frameStocksData" class="table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>Frame Code</th>
                                            <th>Gender</th>
                                            <th>Color</th>
                                            <th>Shape</th>
                                            <th>Opening</th>
                                            <th>Purchased</th>
                                            <th>Transfered</th>
                                            <th>Total</th>
                                            <th>Supplier Price</th>
                                            <th>Price</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                            <!--/.table-responsive -->
                        </div>
                        <!--/.card-body -->
                    </div>
                    <!--/.card -->
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div>
        <!--/.container-fluid -->
    </section>
    <!--/.content -->
@endsection

@push('modals')
    @include('admin.includes.partials.modals.new_hq_frame_stocks')
    @include('admin.includes.partials.modals.update_hq_frame_stocks')
@endpush

@push('scripts')
    <script>
        $(document).ready(function() {

            find_stocks();

            function find_stocks() {
                let path = '{{ route('admin.hq.frame.stocks.index') }}';
                $('#frameStocksData').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: path,
                    columns: [{
                            data: 'code',
                            name: 'code'
                        },
                        {
                            data: 'gender',
                            name: 'gender'
                        },
                        {
                            data: 'color',
                            name: 'color'
                        },
                        {
                            data: 'shape',
                            name: 'shape'
                        },
                        {
                            data: 'opening',
                            name: 'opening'
                        },
                        {
                            data: 'purchased',
                            name: 'purchased'
                        },
                        {
                            data: 'transfered',
                            name: 'transfered'
                        },
                        {
                            data: 'total',
                            name: 'total'
                        },
                        {
                            data: 'supplier_price',
                            name: 'supplier_price'
                        },
                        {
                            data: 'price',
                            name: 'price'
                        },
                        {
                            data: 'actions',
                            name: 'actions',
                            orderable: false,
                            searchable: false
                        },
                    ],
                    'responsive': true,
                    'autoWidth': false,
                });

            }

            // New Frame Stock
            $(document).on('click', '.newFrameStockBtn', function(e) {
                e.preventDefault();
                $('#newFrameStockModal').modal('show');
                $('#newFrameStockForm').trigger('reset');
            });

            // New Frame Stock Post
            $('#newFrameStockForm').submit(function(e) {
                e.preventDefault();
                let form = $(this);
                let formData = new FormData(form[0]);
                let path = '{{ route('admin.hq.frame.stocks.store') }}';
                $.ajax({
                    url: path,
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    beforeSend: function() {
                        form.find('button[type=submit]').html(
                            '<i class="fa fa-spinner fa-spin"></i>'
                        );
                        form.find('button[type=submit]').attr('disabled', true);
                    },
                    complete: function() {
                        form.find('button[type=submit]').html('Save');
                        form.find('button[type=submit]').attr('disabled', false);
                    },
                    success: function(data) {
                        if (data['status']) {
                            toastr.success(data['message']);
                            $('#newFrameStockForm')[0].reset();
                            $('#newFrameStockModal').modal('hide');
                            $('#frameStocksData').DataTable().ajax.reload();
                            location.reload();
                        }
                    },
                    error: function(response) {
                        let errors = response.responseJSON.errors;
                        var errorsHtml = '<ul>';
                        $.each(errors, function(field, messages) {
                            errorsHtml +=
                                '<li style="list-style-type:none; padding:0;">' +
                                messages + '</li>';
                        });
                        errorsHtml += '</ul>';
                        toastr.error(errorsHtml);
                    }
                });
            });

            // Delete Frame Stock
            $(document).on('click', '.deleteFrameStock', function(e) {
                e.preventDefault();
                let stock_id = $(this).data('id');
                let token = "{{ csrf_token() }}";
                let path = "{{ route('admin.hq.frame.stocks.delete', ':hqFrameStock') }}";
                path = path.replace(':hqFrameStock', stock_id);
                Swal.fire({
                    title: "Are you sure?",
                    text: "Once deleted, you will not be able to recover this record!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: path,
                            type: "DELETE",
                            data: {
                                _token: token,
                            },
                            dataType: "json",
                            success: function(data) {
                                if (data['status']) {
                                    toastr.success(data['message']);
                                    $('#frameStocksData').DataTable().ajax.reload();
                                    setTimeout(() => {
                                        location.reload();
                                    }, 500);
                                }
                            }
                        });
                    } else if (result.isDenied) {
                        Swal.fire('Changes are not saved', '', 'info');
                    }
                });
            });

            // Edit Frame Stock
            $(document).on('click', '.updateFrameStock', function(e) {
                e.preventDefault();
                let stock_id = $(this).data('id');
                let path = "{{ route('admin.hq.frame.stocks.show', ':hqFrameStock') }}";
                path = path.replace(':hqFrameStock', stock_id);
                $.ajax({
                    url: path,
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        if(data['status'])
                        {
                            $('#updateFrameStockModal').modal('show');
                            $('#updateFrameStockId').val(data['data']['id']);
                            let frame_id = data['data']['frame_id'];
                            $('#updateFrameStockCode').val(frame_id).trigger('change');
                            $('#updateFrameStockGender').val(data['data']['gender']).trigger('change');
                            $('#updateFrameStockColorId').val(data['data']['color_id']).trigger('change');
                            $('#updateFrameStockShapeId').val(data['data']['shape_id']).trigger('change');
                            $('#updateFrameStockOpeningStock').val(data['data']['opening']);
                            $('#updateFrameStockManufacturerPrice').val(data['data']['supplier_price']);
                            $('#updateFrameStockPrice').val(data['data']['price']);
                        }
                    }
                });
            });

            // Post Edit For, 
            $('#updateFrameStockForm').submit(function (e) { 
                e.preventDefault();
                let form = $(this);
                let formData = new FormData(form[0]);
                let stock_id = $('#updateFrameStockId').val();
                let path = '{{ route('admin.hq.frame.stocks.update', ':hqFrameStock') }}';
                path = path.replace(':hqFrameStock', stock_id);
                $.ajax({
                    url: path,
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    beforeSend: function() {
                        form.find('button[type=submit]').html(
                            '<i class="fa fa-spinner fa-spin"></i>'
                        );
                        form.find('button[type=submit]').attr('disabled', true);
                    },
                    complete: function() {
                        form.find('button[type=submit]').html('Save');
                        form.find('button[type=submit]').attr('disabled', false);
                    },
                    success: function(data) {
                        if (data['status']) {
                            toastr.success(data['message']);
                            $('#updateFrameStockForm')[0].reset();
                            $('#updateFrameStockModal').modal('hide');
                            $('#frameStocksData').DataTable().ajax.reload();
                        }
                    },
                    error: function(response) {
                        let errors = response.responseJSON.errors;
                        var errorsHtml = '<ul>';
                        $.each(errors, function(field, messages) {
                            errorsHtml +=
                                '<li style="list-style-type:none; padding:0;">' +
                                messages + '</li>';
                        });
                        errorsHtml += '</ul>';
                        toastr.error(errorsHtml);
                    }
                });
            });
        });
    </script>
@endpush
