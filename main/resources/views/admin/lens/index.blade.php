@extends('admin.layouts.workshop')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{ $workshop->name }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.dashboard.workshop.index', $workshop->id) }}">Home</a>
                        </li>
                        <li class="breadcrumb-item active">
                            Lenses
                        </li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">

            @include('admin.lens.stats')

            <div class="row">
                <div class="col-12">
                    <!-- Custom Tabs -->
                    <div class="card">
                        <div class="card-header d-flex p-0">
                            <ul class="nav nav-pills ml-auto p-2">
                                <li class="nav-item">
                                    <a class="nav-link active" href="#tab_1" data-toggle="tab">
                                        @lang('labels.admins.tabs.inventory.lenses.stocks')
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#tab_2" data-toggle="tab">
                                        @lang('labels.admins.tabs.inventory.lenses.received.title')
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#tab_3" data-toggle="tab">
                                        @lang('labels.admins.tabs.inventory.lenses.requested')
                                    </a>
                                </li>
                            </ul>
                        </div><!-- /.card-header -->
                        <div class="card-body">
                            <div class="tab-content">
                                <div class="tab-pane active" id="tab_1">
                                    @include('admin.lens.stocks')
                                </div>
                                <!-- /.tab-pane -->
                                <div class="tab-pane" id="tab_2">
                                    @include('admin.lens.received')
                                </div>
                                <!-- /.tab-pane -->
                                <div class="tab-pane" id="tab_3">
                                    @include('admin.lens.requested')
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
        <!--.container-fluid -->
    </section>
    <!-- /.content -->
@endsection

@push('modals')
    @include('admin.includes.partials.modals.add_lens_stock')
    @include('admin.includes.partials.modals.update_lens_stock')
@endpush

@push('scripts')
    <script>
        $(document).ready(function() {

            find_lenses();

            function find_lenses() {
                let path = '{{ route('admin.workshop.inventory.lens.stocks.index', $workshop->id) }}';
                $('#lensData').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: path,
                    "responsive": true,
                    "autoWidth": false,
                    pageLength: 1000,
                    columns: [{
                            data: 'code',
                            name: 'code'
                        },
                        {
                            data: 'power',
                            name: 'power'
                        },
                        {
                            data: 'type',
                            name: 'type'
                        },
                        {
                            data: 'material',
                            name: 'material'
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
                            data: 'opening',
                            name: 'opening'
                        },
                        {
                            data: 'received',
                            name: 'received'
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
                            data: 'sold',
                            name: 'sold'
                        },
                        {
                            data: 'closing',
                            name: 'closing'
                        },
                        {
                            data: 'action',
                            name: 'action',
                            orderable: false,
                            searchable: false
                        },
                    ]
                });
            }

            $(document).on('click', '.addLensStockBtn', function(e){
                e.preventDefault();
                $('#addLensStockModal').modal('show');
                $('#addLensStockForm').trigger("reset");
            });

            $('#addLensStockForm').submit(function (e) { 
                e.preventDefault();
                let form = $(this);
                let formData = new FormData(form[0]);
                let path = '{{ route('admin.workshop.inventory.lens.stocks.store', ':workshop') }}';
                path = path.replace(':workshop', '{{ $workshop->id }}');
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
                            $('#addLensStockForm')[0].reset();
                            $('#addLensStockModal').modal('hide');
                            $('#lensData').DataTable().ajax.reload();
                            setTimeout(() => {
                                location.reload();
                            }, 1000);
                        } else {
                            toastr.error(data['message']);
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

            $(document).on('click', '.updateLensBtn', function(e){
                e.preventDefault();
                let lens_id = $(this).data('id');
                let path = '{{ route('admin.workshop.inventory.lens.stocks.show', ':lens') }}';
                path = path.replace(':lens', lens_id);
                $.ajax({
                    type: "GET",
                    url: path,
                    dataType: "json",
                    success: function (data) {
                        if(data['status'])
                        {
                            $('#updateLensStockModal').modal('show');
                            $('#updateLensStockId').val(data['data']['id']);
                            $('#updateLensStockHqLensId').val(data['data']['hq_lens_id']).trigger('change');
                            $('#updateLensStockOpening').val(data['data']['opening']);
                        }
                    }
                });
            });

            $('#updateLensStockForm').submit(function (e) { 
                e.preventDefault();
                let lens_id = $('#updateLensStockId').val();
                let form = $(this);
                let formData = new FormData(form[0]);
                let path ='{{ route('admin.workshop.inventory.lens.stocks.update', ':lens') }}';
                path = path.replace(':lens', lens_id);
                $.ajax({
                    type: "POST",
                    url: path,
                    data: formData,
                    dataType: "json",
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
                    success: function (data) {
                        if(data['status'])
                        {
                            toastr.success(data['message']);
                            $('#updateLensStockModal').modal('hide');
                            $('#updateLensStockForm').trigger('reset');
                            $('#lensData').DataTable().ajax.reload();
                            // setTimeout(() => {
                            //     location.reload();
                            // }, 1000);
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

            $(document).on('click', '.deleteLensBtn', function(e) {
                e.preventDefault();
                let lens_id = $(this).data('id');
                let path = '{{ route('admin.workshop.inventory.lens.stocks.delete', ':lens') }}';
                path = path.replace(':lens', lens_id);
                let token = "{{ csrf_token() }}";
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
                                    $('#lensData').DataTable().ajax.reload();
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

            find_hq_receives();

            function find_hq_receives() {
                let path = '{{ route('admin.workshop.inventory.lens.received.index', $workshop->id) }}';
                $('#receivedFromHQData').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: path,
                    "responsive": true,
                    "autoWidth": false,
                    columns: [{
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex'
                        },
                        {
                            data: 'received_date',
                            name: 'received_date'
                        },
                        {
                            data: 'lens_code',
                            name: 'lens_code'
                        },
                        {
                            data: 'quantity',
                            name: 'quantity'
                        },
                        {
                            data: 'condition',
                            name: 'condition'
                        },
                        {
                            data: 'received_status',
                            name: 'received_status'
                        },
                        {
                            data: 'remarks',
                            name: 'remarks'
                        },
                        {
                            data: 'received_by',
                            name: 'received_by'
                        },
                    ]
                });
            }


            find_workshop_receives();

            function find_workshop_receives() {
                let path = '{{ route('admin.workshop.inventory.lens.received.from.workshop', $workshop->id) }}';
                $('#receivedFromWorkshopData').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: path,
                    "responsive": true,
                    "autoWidth": false,
                    columns: [{
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex'
                        },
                        {
                            data: 'received_date',
                            name: 'received_date'
                        },
                        {
                            data: 'lens_code',
                            name: 'lens_code'
                        },
                        {
                            data: 'from_workshop',
                            name: 'from_workshop'
                        },
                        {
                            data: 'quantity',
                            name: 'quantity'
                        },
                        {
                            data: 'condition',
                            name: 'condition'
                        },
                        {
                            data: 'received_status',
                            name: 'received_status'
                        },
                        {
                            data: 'remarks',
                            name: 'remarks'
                        },
                        {
                            data: 'received_by',
                            name: 'received_by'
                        },
                    ]
                });
            }

            find_lens_request();

            function find_lens_request() {
                let path = '{{ route('admin.workshop.inventory.lens.request.index', $workshop->id) }}';
                $('#requestsData').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: path,
                    "responsive": true,
                    "autoWidth": false,
                    columns: [{
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex'
                        },
                        {
                            data: 'requested_date',
                            name: 'requested_date'
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
                        },
                        {
                            data: 'request_status',
                            name: 'request_status'
                        },
                        {
                            data: 'transfer_status',
                            name: 'transfer_status'
                        },
                        {
                            data: 'remarks',
                            name: 'remarks'
                        },
                        {
                            data: 'requested_by',
                            name: 'requested_by'
                        },
                    ]

                });
            }

        });
    </script>
@endpush
