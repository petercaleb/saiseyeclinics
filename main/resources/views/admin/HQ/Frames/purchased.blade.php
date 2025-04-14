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
                    <div class="small-box bg-primary">
                        <div class="inner">
                            <h3>{{ $organization->hq_frame_purchase()->sum('quantity') }}</h3>

                            <p>Stock Purchases</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-address-card"></i>
                        </div>
                        <a href="javascript:void(0)" class="small-box-footer newFramePurchaseBtn">
                            New Frame Purchase <i class="fa fa-plus"></i>
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
                                <a href="{{ route('admin.hq.frame.purchases.export') }}" class="btn btn-outline-primary">
                                    Export
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="framesPurchasedData" class="table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>Purchased Date</th>
                                            <th>Receipt #</th>
                                            <th>Frame Code</th>
                                            <th>Gender</th>
                                            <th>Color</th>
                                            <th>Shape</th>
                                            <th>Units</th>
                                            <th>Price per unit</th>
                                            <th>Total Price</th>
                                            <th>Supplier</th>
                                            <th>Receipt</th>
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
    @include('admin.includes.partials.modals.new_frame_purchase')
@endpush

@push('scripts')
    <script>
        $(document).ready(function() {

            find_all_purchases();

            function find_all_purchases() {
                let path = '{{ route('admin.hq.frame.purchases.index') }}';
                $('#framesPurchasedData').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: path,
                    'responsive': true,
                    'autoWidth': false,
                    columns: [{
                            data: 'purchase_date',
                            name: 'purchase_date'
                        },
                        {
                            data: 'receipt_number',
                            name: 'receipt_number'
                        },
                        {
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
                            data: 'quantity',
                            name: 'quantity'
                        },
                        {
                            data: 'price',
                            name: 'price'
                        },
                        {
                            data: 'total',
                            name: 'total'
                        },
                        {
                            data: 'supplier',
                            name: 'supplier'
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

            $(document).on('click', '.newFramePurchaseBtn', function(e) {
                e.preventDefault();
                $('#newFramePurchaseModal').modal('show');
                $('#newFramePurchaseForm').trigger("reset");
            });

            $('#newFramePurchaseForm').submit(function(e) {
                e.preventDefault();
                var form = $(this);
                var formData = new FormData(form[0]);
                var path = '{{ route('admin.hq.frame.purchases.store') }}';
                $.ajax({
                    url: path,
                    type: "POST",
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
                            $('#newFramePurchaseForm')[0].reset();
                            $('#newFramePurchaseModal').modal('hide');
                            $('#framesPurchasedData').DataTable().ajax.reload();
                            setTimeout(() => {
                                location.reload();
                            }, 500);
                        }
                    },
                    error: function(error) {
                        if (error.status == 422) {
                            $.each(error.responseJSON.errors, function(i, error) {
                                toastr.error(error);
                            });
                        } else {
                            toastr.error(error.responseJSON.message);
                        }
                    }
                });

            });

            $(document).on('click', '.deleteFramePurchaseBtn', function(e){
                e.preventDefault();
                let purchase_id = $(this).data('id');
                let token = "{{ csrf_token() }}";
                let path = "{{ route('admin.hq.frame.purchases.delete', ':hqFramePurchase') }}";
                path  = path.replace(':hqFramePurchase', purchase_id);
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
                                    $('#framesPurchasedData').DataTable().ajax.reload();
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
        });
    </script>
@endpush
