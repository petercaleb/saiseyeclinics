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
                            <h3>{{ count($transfers) }}</h3>

                            <p>Lens Transfers</p>
                        </div>
                        <div class="icon">
                            <i class="fas fa-eye"></i>
                        </div>
                        <a href="javascript:void(0)" class="small-box-footer newLensTransferBtn">
                            New Lens Transfer <i class="fa fa-plus"></i>
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
                                <table id="lensTransfersData" class="table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>Transfer Date</th>
                                            <th>Lens Code</th>
                                            <th>Lens Power</th>
                                            <th>Eye</th>
                                            <th>To Workshop</th>
                                            <th>Quantity</th>
                                            <th>Status</th>
                                            <th>Condtion</th>
                                            <th>Remarks</th>
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
    @include('admin.includes.partials.modals.new_lens_transfer')
@endpush

@push('scripts')
    <script>
        $(document).ready(function() {

            find_lens_transfer();
            function find_lens_transfer()
            {
                let path = '{{ route('admin.hq.lenses.transfers.index') }}';
                $('#lensTransfersData').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: path,
                    'responsive': true,
                    'autoWidth': false,
                    columns: [{
                            data: 'transfered_date',
                            name: 'transfered_date'
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
                            data: 'eye',
                            name: 'eye'
                        },
                        {
                            data: 'to_workshop',
                            name: 'to_workshop'
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
                            data: 'condition',
                            name: 'condition'
                        },
                        {
                            data: 'remarks',
                            name: 'remarks'
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

            $(document).on('click', '.newLensTransferBtn', function(e){
                e.preventDefault();
                $('#newLensTransferModal').modal('show');
                $("#newLensTransferForm").trigger("reset");
            });

            $("#newLensTransferForm").submit(function (e) { 
                e.preventDefault();
                let form = $(this);
                let formData = new FormData(form[0]);
                let path = '{{ route('admin.hq.lenses.transfers.store') }}';
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
                        form.find('button[type=submit]').html('Transfer');
                        form.find('button[type=submit]').attr('disabled', false);
                    },
                    success: function(data) {
                        if (data['status']) {
                            toastr.success(data['message']);
                            $('#newLensTransferForm')[0].reset();
                            $('#newLensTransferModal').modal('hide');
                            $('#lensTransfersData').DataTable().ajax.reload();
                            setTimeout(() => {
                                location.reload();
                            }, 500);
                        }
                    },
                    error: function(error) {

                        $.each(error.responseJSON.errors, function(i, error) {
                            toastr.error(error);
                        });

                    }
                });
            });

            $(document).on('click', '.deleteLensTransferBtn', function(e){
                e.preventDefault();
                let transfer_id = $(this).data('id');
                let token = "{{ csrf_token() }}";
                let path = "{{ route('admin.hq.lenses.transfers.delete', ':hqLensTransfer') }}";
                path  = path.replace(':hqLensTransfer', transfer_id);
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
                                    toastr.success(data['message'])
                                    $('#lensTransfersData').DataTable().ajax.reload();
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
            })

        });
    </script>
@endpush
