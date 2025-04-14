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
                    <div class="small-box bg-primary">
                        <div class="inner">
                            <h3>
                                {{ $organization->hq_case_transfer()->where('to_clinic_id', '!=', null)->sum('quantity') }}
                            </h3>

                            <p>Cases Transfered to Clinics</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-document-text"></i>
                        </div>
                        <a href="#" class="small-box-footer newHqCaseTransferClinicBtn">
                            Transfer to Clinic <i class="fa fa-plus"></i>
                        </a>
                    </div>
                </div>

                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>
                                {{ $organization->hq_case_transfer()->where('to_workshop_id', '!=', null)->sum('quantity') }}
                            </h3>

                            <p>Transfered to Workshops</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-document-text"></i>
                        </div>
                        <a href="#" class="small-box-footer newHqCaseTransferWorkshopBtn">
                            Transfer to Workshop <i class="fa fa-plus"></i>
                        </a>
                    </div>
                </div>
            </div>
            <!--/.row -->

            <div class="row">
                <div class="col-12">

                    <!-- Custom Tabs -->
                    <div class="card">
                        <div class="card-header d-flex p-0">
                            <ul class="nav nav-pills ml-auto p-2">
                                <li class="nav-item">
                                    <a class="nav-link active" href="#tab_1" data-toggle="tab">
                                        Transfers to Clinics
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#tab_2" data-toggle="tab">
                                        Transfers to Workshops
                                    </a>
                                </li>
                            </ul>
                        </div><!-- /.card-header -->
                        <div class="card-body">
                            <div class="tab-content">
                                <div class="tab-pane active" id="tab_1">
                                    <div class="table-responsive">
                                        <table id="caseTransferToClinicsData" class="table table-striped table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Transfered Date</th>
                                                    <th>Case Code</th>
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
                                </div>
                                <!-- /.tab-pane -->
                                <div class="tab-pane" id="tab_2">
                                    <div class="table-responsive">
                                        <table id="caseTransferToWorkshopsData" class="table table-striped table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Transfered Date</th>
                                                    <th>Case Code</th>
                                                    <th>To Workshop</th>
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
        <!--/.container-fluid -->
    </section>
    <!--/.content -->
@endsection

@push('modals')
    @include('admin.includes.partials.modals.new_case_transfer_clinic')
    @include('admin.includes.partials.modals.new_case_transfer_workshop')
@endpush

@push('scripts')
    <script>
        $(document).ready(function() {


            find_transfers_for_clinics();

            function find_transfers_for_clinics() {
                let path = '{{ route('admin.hq.cases.transfers.index') }}';
                $('#caseTransferToClinicsData').DataTable({
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
                            data: 'case_code',
                            name: 'case_code'
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

            find_transfers_for_workshops();

            function find_transfers_for_workshops() {
                let path = '{{ route('admin.hq.cases.transfers.workshop') }}';
                $('#caseTransferToWorkshopsData').DataTable({
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
                            data: 'case_code',
                            name: 'case_code'
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

            $(document).on('click', '.newHqCaseTransferClinicBtn', function(e) {
                e.preventDefault();
                $('#newHqCaseTransferClinicModal').modal('show');
                $('#newHqCaseTransferClinicForm').trigger('reset');
            });

            $('#newHqCaseTransferClinicForm').submit(function(e) {
                e.preventDefault();
                let form = $(this);
                let formData = new FormData(form[0]);
                let path = '{{ route('admin.hq.cases.transfers.store') }}';
                $.ajax({
                    type: "POST",
                    url: path,
                    data: formData,
                    processData: false,
                    contentType: false,
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
                    success: function(response) {
                        if (response['status']) {
                            $('#newHqCaseTransferClinicModal').modal('hide');
                            $('#newHqCaseTransferClinicForm').trigger('reset');
                            $('#caseTransferToClinicsData').DataTable().ajax.reload();
                            toastr.success(response.message);
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


            $(document).on('click', '.newHqCaseTransferWorkshopBtn', function(e) {
                e.preventDefault();
                $('#newHqCaseTransferWorkshopModal').modal('show');
                $('#newHqCaseTransferWorkshopForm').trigger('reset');
            });


            $('#newHqCaseTransferWorkshopForm').submit(function(e) {
                e.preventDefault();
                let form = $(this);
                let formData = new FormData(form[0]);
                let path = '{{ route('admin.hq.cases.transfers.store') }}';
                $.ajax({
                    type: "POST",
                    url: path,
                    data: formData,
                    processData: false,
                    contentType: false,
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
                    success: function(response) {
                        if (response['status']) {
                            $('#newHqCaseTransferWorkshopModal').modal('hide');
                            $('#newHqCaseTransferWorkshopForm').trigger('reset');
                            $('#caseTransferToWorkshopsData').DataTable().ajax.reload();
                            toastr.success(response.message);
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

            $(document).on('click', '.deleteCaseTransferBtn', function(e){
                e.preventDefault();
                let transfer_id = $(this).data('id');
                let token = "{{ csrf_token() }}";
                let path = "{{ route('admin.hq.cases.transfers.delete', ':hqCaseTransfer') }}";
                path  = path.replace(':hqCaseTransfer', transfer_id);
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
                                    $('#caseTransferToClinicsData').DataTable().ajax.reload();
                                    $('#caseTransferToWorkshopsData').DataTable().ajax.reload();
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
