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
                            <a href="#">Home</a>
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
                    <div class="small-box bg-secondary">
                        <div class="inner">
                            <h3>{{ $organization->hq_frame_transfer()->sum('quantity') }}</h3>

                            <p>Transfered Stocks</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-document-text"></i>
                        </div>
                        <a href="#" class="small-box-footer newHqFrameTransferBtn">
                            Transfer Stock <i class="fa fa-plus"></i>
                        </a>
                    </div>
                </div>
            </div>
            <!--/.row -->

            <div class="row">
                <div class="col-12">
                    <div class="card card-primary card-outline">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="frameTransferData" class="table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>Transfered Date</th>
                                            <th>Frame Code</th>
                                            <th>To Clinic</th>
                                            <th>Quantity</th>
                                            <th>Status</th>
                                            <th>Condition</th>
                                            <th>Remarks</th>
                                            <th>Received</th>
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
            </div>
            <!-- /.row -->
        </div>
        <!--/.container-fluid -->
    </section>
    <!--/.content -->
@endsection

@push('modals')
    @include('admin.includes.partials.modals.new_hq_frame_transfer')
@endpush

@push('scripts')
    <script>
        $(document).ready(function() {

            find_all_transfers();

            function find_all_transfers() {
                let path = '{{ route('admin.hq.frame.transfers.index') }}';
                $('#frameTransferData').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: path,
                    'responsive': true,
                    'autoWidth': false,
                    columns: [{
                            data: 'transfer_date',
                            name: 'transfer_date'
                        },

                        {
                            data: 'frame_code',
                            name: 'frame_code'
                        },
                        {
                            data: 'to_clinic',
                            name: 'to_clinic'
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
                            data: 'received',
                            name: 'received'
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

            // Transfer Frames
            $(document).on('click', '.newHqFrameTransferBtn', function(e) {
                e.preventDefault();
                $('#newHqFrameTransferModal').modal('show');
                $('#newHqFrameTransferForm').trigger('reset');
            });

            $('#newHqFrameTransferForm').submit(function(e) {
                e.preventDefault();
                let form = $(this);
                let formData = new FormData(form[0]);
                let path = '{{ route('admin.hq.frame.transfers.store') }}';
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
                            $('#newHqFrameTransferForm')[0].reset();
                            $('#newHqFrameTransferModal').modal('hide');
                            $('#frameTransferData').DataTable().ajax.reload();
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

            $(document).on('click', '.deleteFrameTransferBtn', function(e){
                e.preventDefault();
                let transfer_id = $(this).data('id');
                let token = "{{ csrf_token() }}";
                let path = "{{ route('admin.hq.frame.transfers.delete', ':hqFrameTransfer') }}";
                path  = path.replace(':hqFrameTransfer', transfer_id);
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
                                    Swal.fire(data['message'], '', 'success')
                                    $('#frameTransferData').DataTable().ajax.reload();
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
