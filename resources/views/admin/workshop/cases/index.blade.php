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

            @include('admin.workshop.cases.stats')

            <div class="row">
                <div class="col-12">
                    <!-- Custom Tabs -->
                    <div class="card">
                        <div class="card-header d-flex p-0">
                            <ul class="nav nav-pills ml-auto p-2">
                                <li class="nav-item">
                                    <a class="nav-link active" href="#tab_1" data-toggle="tab">
                                        @lang('labels.admins.tabs.inventory.cases.stocks')
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#tab_2" data-toggle="tab">
                                        @lang('labels.admins.tabs.inventory.cases.received.title')
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#tab_3" data-toggle="tab">
                                        @lang('labels.admins.tabs.inventory.cases.requested')
                                    </a>
                                </li>
                            </ul>
                        </div><!-- /.card-header -->
                        <div class="card-body">
                            <div class="tab-content">
                                <div class="tab-pane active" id="tab_1">
                                    @include('admin.workshop.cases.stocks')
                                </div>
                                <!-- /.tab-pane -->
                                <div class="tab-pane" id="tab_2">
                                    @include('admin.workshop.cases.received')
                                </div>
                                <!-- /.tab-pane -->
                                <div class="tab-pane" id="tab_3">
                                    @include('admin.workshop.cases.requests')
                                </div>
                                <!-- /.tab-pane -->
                            </div>
                            <!-- /.tab-content -->
                        </div><!-- /.card-body -->
                    </div>
                    <!-- ./card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->

        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection


@push('modals')
    @include('admin.includes.partials.modals.add_workshop_case_stock')
@endpush

@push('scripts')
    <script>
        $(document).ready(function() {

            find_case_stocks();

            function find_case_stocks() {
                let path = "{{ route('admin.workshop.inventory.cases.stock.index', $workshop->id) }}";
                $('#workshopCaseStocksData').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: path,
                    columns: [{
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex'
                        },
                        {
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
                            data: 'price',
                            name: 'price'
                        },
                        {
                            data: 'remarks',
                            name: 'remarks'
                        },
                        {
                            data: 'actions',
                            name: 'actions'
                        }
                    ],
                    order: [
                        [0, 'desc']
                    ],
                    dom: 'Bfrtip',
                    buttons: [
                        'copy', 'csv', 'excel', 'pdf', 'print'
                    ],
                    language: {
                        search: "_INPUT_",
                        searchPlaceholder: "Search..."
                    },
                    'autoWidth': false,
                    'responsive': true
                });
            }

            $(document).on('click', '.addWorkshopCaseStockBtn', function(e) {
                e.preventDefault();
                $('#addWorkshopCaseStockModal').modal('show');
                $('#addWorkshopCaseStockForm').trigger('reset');
            });

            $('#addWorkshopCaseStockForm').submit(function(e) {
                e.preventDefault();
                let form = $(this);
                let formData = new FormData(form[0]);
                let path = '{{ route('admin.workshop.inventory.cases.stock.store', ':workshop') }}';
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
                            $('#addWorkshopCaseStockForm')[0].reset();
                            $('#addWorkshopCaseStockModal').modal('hide');
                            $('#workshopCaseStocksData').DataTable().ajax.reload();
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

            $(document).on('click', '.deleteCaseStock', function(e) {
                e.preventDefault();
                let stock_id = $(this).data('id');
                let path =
                    '{{ route('admin.workshop.inventory.cases.stock.delete', ':workshopCaseStock') }}';
                path = path.replace(':workshopCaseStock', stock_id);
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You want to delete this case stock?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: path,
                            type: 'DELETE',
                            data: {
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(data) {
                                if (data['status']) {
                                    toastr.success(data['message']);
                                    $('#workshopCaseStocksData').DataTable().ajax
                                        .reload();
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
                    }
                });
            });

            find_case_hq_received();

            function find_case_hq_received() {
                let path = '{{ route('admin.workshop.inventory.cases.received.index', $workshop->id) }}';
                $('#caseReceivedFromHQStocksData').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: path,
                    'responsive': true,
                    'autoWidth': false,
                    columns: [{
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex'
                        },
                        {
                            data: 'receive_date',
                            name: 'receive_date'
                        },
                        {
                            data: 'case_code',
                            name: 'case_code'
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
                            data: 'status',
                            name: 'status'
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

            find_case_clinic_received();

            function find_case_clinic_received() {
                let path = '{{ route('admin.workshop.inventory.cases.received.from.workshop', $workshop->id) }}';
                $('#caseReceivedFromClinicsStocksData').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: path,
                    'responsive': true,
                    'autoWidth': false,
                    columns: [{
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex'
                        },
                        {
                            data: 'received_date',
                            name: 'received_date'
                        },
                        {
                            data: 'code',
                            name: 'code'
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
                            data: 'status',
                            name: 'status'
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


            find_case_requests();

            function find_case_requests() {
                let path = '{{ route('admin.workshop.inventory.cases.requests.index', $workshop->id) }}';
                $('#casesRequestedData').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: path,
                    'responsive': true,
                    'autoWidth': false,
                    columns: [{
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex'
                        },
                        {
                            data: 'request_date',
                            name: 'request_date'
                        },
                        {
                            data: 'workshop',
                            name: 'workshop'
                        },
                        {
                            data: 'case_code',
                            name: 'case_code'
                        },

                        {
                            data: 'quantity',
                            name: 'quantity'
                        },
                        {
                            data: 'status',
                            name: 'status'
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
