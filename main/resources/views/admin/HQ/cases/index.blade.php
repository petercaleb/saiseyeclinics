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
                            <h3>{{ $organization->hq_case_stock()->sum('total') }}</h3>

                            <p>Case Stocks</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-briefcase-medical"></i>
                        </div>
                        <a href="javascript:void(0)" class="small-box-footer newCaseStockBtn">
                            New Case Stock <i class="fa fa-plus"></i>
                        </a>
                    </div>
                </div>
                <!-- ./col -->
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <div class="card-tools">
                                <a href="{{ route('admin.hq.cases.stocks.export')  }}" class="btn btn-outline-primary">
                                    Export
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="caseStocksData" class="table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>Case Code</th>
                                            <th>Color</th>
                                            <th>Shape</th>
                                            <th>Size</th>
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
    @include('admin.includes.partials.modals.new_hq_case_stock')
    @include('admin.includes.partials.modals.update_hq_case_stock')
@endpush

@push('scripts')
    <script>
        $(document).ready(function() {

            find_stocks();

            function find_stocks() {
                let path = '{{ route('admin.hq.cases.stocks.index') }}';
                $('#caseStocksData').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: path,
                    columns: [{
                            data: 'case_code',
                            name: 'case_code'
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
                            data: 'size',
                            name: 'size'
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

            $(document).on('click', '.newCaseStockBtn', function(e) {
                e.preventDefault();
                $('#newCaseStockModal').modal('show');
                $('#newCaseStockForm').trigger("reset");
            });

            $('#newCaseStockForm').submit(function(e) {
                e.preventDefault();
                let form = $(this);
                let formData = new FormData(form[0]);
                let path = '{{ route('admin.hq.cases.stocks.store') }}';
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
                            $('#newCaseStockForm')[0].reset();
                            $('#newCaseStockModal').modal('hide');
                            $('#caseStocksData').DataTable().ajax.reload();
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
            $(document).on('click', '.deleteCaseStock', function(e) {
                e.preventDefault();
                let stock_id = $(this).data('id');
                let token = "{{ csrf_token() }}";
                let path = "{{ route('admin.hq.cases.stocks.delete', ':hqCaseStock') }}";
                path = path.replace(':hqCaseStock', stock_id);
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
                                    $('#caseStocksData').DataTable().ajax.reload();
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
            $(document).on('click', '.updateCaseStock', function(e) {
                e.preventDefault();
                let stock_id = $(this).data('id');
                let path = "{{ route('admin.hq.cases.stocks.show', ':hqCaseStock') }}";
                path = path.replace(':hqCaseStock', stock_id);
                $.ajax({
                    url: path,
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        if (data['status']) {
                            $('#updateCaseStockModal').modal('show');
                            $('#updateCaseStockId').val(data['data']['id']);
                            let case_id = data['data']['case_id'];
                            $('#updateCaseStockCode').val(case_id).trigger('change');
                            $('#updateCaseStockOpening').val(data['data']['opening']);
                            $('#updateCaseStockSupplierPrice').val(data['data'][
                                'supplier_price'
                            ]);
                            $('#updateCaseStockPrice').val(data['data']['price']);
                        }
                    }
                });
            });

            // Post Edit For,
            $('#updateCaseStockForm').submit(function(e) {
                e.preventDefault();
                let form = $(this);
                let formData = new FormData(form[0]);
                let stock_id = $('#updateCaseStockId').val();
                let path = '{{ route('admin.hq.cases.stocks.update', ':hqCaseStock') }}';
                path = path.replace(':hqCaseStock', stock_id);
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
                            $('#updateCaseStockForm')[0].reset();
                            $('#updateCaseStockModal').modal('hide');
                            $('#caseStocksData').DataTable().ajax.reload();
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
