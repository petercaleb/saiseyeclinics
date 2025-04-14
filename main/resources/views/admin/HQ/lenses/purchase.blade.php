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
                            <h3>{{ count($purchases) }}</h3>

                            <p>Lens Purchases</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-eye"></i>
                        </div>
                        <a href="javascript:void(0)" class="small-box-footer newLensPurchasesBtn">
                            New Lens Stock <i class="fa fa-plus"></i>
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
                                <a href="{{ route('admin.hq.lenses.purchases.export') }}" class="btn btn-outline-primary">
                                    Export
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="lensPurchasesData" class="table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>Purchased Date</th>
                                            <th>Receipt Number</th>
                                            <th>Lens Code</th>
                                            <th>Lens Power</th>
                                            <th>Vendor</th>
                                            <th>Units</th>
                                            <th>Price</th>
                                            <th>Total Price</th>
                                            <th>Receipt</th>
                                            <th>Action</th>
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
    @include('admin.includes.partials.modals.new_lens_purchase')
@endpush

@push('scripts')
    <script>
        $(document).ready(function() {

            find_lens_purchases();

            function find_lens_purchases() {
                let path = '{{ route('admin.hq.lenses.purchases.index') }}';
                $('#lensPurchasesData').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: path,
                    "responsive": true,
                    "autoWidth": false,
                    columns: [{
                            data: 'purchased_date',
                            name: 'purchased_date'
                        },
                        {
                            data: 'receipt_number',
                            name: 'receipt_number'
                        },
                        {
                            data: 'lens_code',
                            name: 'lens_code'
                        },
                        {
                            data: 'power',
                            name: 'power'
                        },
                        {
                            data: 'vendor',
                            name: 'vendor'
                        },
                        {
                            data: 'quantity',
                            name: 'quantity'
                        },
                        {
                            data: 'price',
                            name: 'price'
                        },
                        {
                            data: 'total_price',
                            name: 'total_price'
                        },
                        {
                            data: 'receipt',
                            name: 'receipt',
                            orderable: false,
                            searchable: false
                        },
                        {
                            data: 'actions',
                            name: 'actions',
                            orderable: false,
                            searchable: false
                        },
                    ]

                });
            }

            $(document).on('click', '.newLensPurchasesBtn', function(e) {
                e.preventDefault();
                $('#newLensPurchasesModal').modal('show');
                $('#newLensPurchasesForm').trigger('reset');
            });

            $('#newLensPurchasesForm').submit(function(e) {
                e.preventDefault();
                let form = $(this);
                let formData = new FormData(form[0]);
                let path = '{{ route('admin.hq.lenses.purchases.store') }}';
                $.ajax({
                    url: path,
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    beforeSend: function() {
                        form.find('button[type=submit]').html(
                            '<i class="fa fa-spinner fa-spin"></i>');
                        form.find('button[type=submit]').attr('disabled', true);
                    },
                    complete: function() {
                        form.find('button[type=submit]').html('Save');
                        form.find('button[type=submit]').attr('disabled', false);
                    },
                    success: function(data) {
                        if (data['status']) {
                            toastr.success(data['message']);
                            $('#newLensPurchasesModal').modal('hide');
                            $('#newLensPurchasesForm')[0].reset();
                            $('#lensPurchasesData').DataTable().ajax.reload();
                            setTimeout(() => {
                                location.reload();
                            }, 500);

                        }
                    },
                    error: function(data) {
                        console.log(data.responseJSON.errors);
                        var errors = data.responseJSON.errors;
                        if (errors) {
                            $.each(errors, function(key, value) {
                                toastr.error(value);
                            });
                        }
                    },
                });
            });

            $(document).on('click', '.deleteLensPurchaseBtn', function(e) {
                e.preventDefault();
                let lens_purchase_id = $(this).data('id');
                let path = '{{ route('admin.hq.lenses.purchases.delete', ':hqLensPurchase') }}';
                path = path.replace(':hqLensPurchase', lens_purchase_id);
                let token = '{{ csrf_token() }}';
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
                            type: 'DELETE',
                            data: {
                                _token: token
                            },
                            dataType: 'json',
                            success: function(data) {
                                if (data['status']) {
                                    Swal.fire(data['message'], '', 'success')
                                    $('#lensData').DataTable().ajax.reload();
                                    $('#lensPurchasesData').DataTable().ajax.reload();
                                    location.reload();
                                }
                            },
                            error: function(data) {
                                var errors = data.responseJSON;
                                var errorsHtml = '<ul>';
                                $.each(errors['errors'], function(key, value) {
                                    errorsHtml += '<li>' + value + '</li>';
                                });
                                errorsHtml += '</ul>';
                                Swal.fire(errorsHtml, '', 'info');
                            }
                        });
                    } else if (result.isDenied) {
                        Swal.fire('Changes are not saved', '', 'info');
                    }
                });


            });


        });
    </script>
@endpush
