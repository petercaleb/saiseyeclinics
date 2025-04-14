@extends('admin.layouts.app')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Workshops</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.organization.index') }}">Home</a>
                        </li>
                        <li class="breadcrumb-item active">Insurance Companies</li>
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
                        <div class="card-header">
                            <div class="card-tools">
                                <a href="#" id="newWorkShopBtn" class="btn btn-primary btn-sm">
                                    <i class="fa fa-plus-circle"></i> New Workshop
                                </a>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body table-responsive">
                            <table id="workshopsData" class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>Name</th>
                                        <th>Initials</th>
                                        <th>Logo</th>
                                        <th>Phone</th>
                                        <th>Email</th>
                                        <th></th>
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

        <div class="modal fade" id="newWorkShopModal">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <form id="newWorkShopForm">
                        @csrf
                        <input type="hidden" value="{{ $organization->id }}" name="organization_id" />
                        <div class="modal-header">
                            <h4 class="modal-title">New Workshop</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="newWorkShopTitle">Name</label>
                                        <input type="text" name="name" class="form-control" id="newWorkShopTitle"
                                            placeholder="Enter Workshop Name">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="newWorkShopTitle">Initials</label>
                                        <input type="text" name="initials" class="form-control" id="newWorkShopInitials"
                                            placeholder="Enter Workshop Initials">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="newWorkShopLogo">Logo</label>
                                        <div class="input-group">
                                            <div class="custom-file">
                                                <input type="file" name="logo" class="custom-file-input"
                                                    id="newWorkShopLogo">
                                                <label class="custom-file-label" for="newWorkShopLogo">Choose file</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="newWorkShopPhone">Phone Number</label>
                                        <input type="text" name="phone" class="form-control" id="newWorkShopPhone"
                                            placeholder="Enter Phone Number">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="newWorkShopEmail">Email Address</label>
                                        <input type="email" name="email" class="form-control" id="newWorkShopEmail"
                                            placeholder="Enter Email Address">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="newWorkShopAddress">Address</label>
                                        <input type="text" name="address" class="form-control" id="newWorkShopAddress"
                                            placeholder="Enter Address">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" id="newWorkShopSubmitBtn" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->

        <div class="modal fade" id="updateWorkShopModal">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <form id="updateWorkShopForm">
                        <div class="modal-header">
                            <h4 class="modal-title">Update Workshop</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            @csrf
                            <input type="hidden" name="workshop_id" id="updateWorkShopId" class="form-control">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="updateWorkShopTitle">Name</label>
                                        <input type="text" name="name" class="form-control"
                                            id="updateWorkShopTitle" placeholder="Enter Workshop Name">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="updateWorkShopLogo">Logo</label>
                                        <div class="input-group">
                                            <div class="custom-file">
                                                <input type="file" name="logo" class="custom-file-input"
                                                    id="updateWorkShopLogo">
                                                <label class="custom-file-label" for="updateWorkShopLogo">Choose
                                                    file</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="updateWorkShopPhone">Phone Number</label>
                                        <input type="text" name="phone" class="form-control"
                                            id="updateWorkShopPhone" placeholder="Enter Phone Number">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="updateWorkShopEmail">Email Address</label>
                                        <input type="email" name="email" class="form-control"
                                            id="updateWorkShopEmail" placeholder="Enter Email Address">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="updateWorkShopAddress">Address</label>
                                        <input type="text" name="address" class="form-control"
                                            id="updateWorkShopAddress" placeholder="Enter Address">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" id="updateWorkShopSubmitBtn" class="btn btn-primary">Update</button>
                        </div>
                    </form>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->
        <!-- /.modal -->

    </section><!-- /.content -->
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {

            find_workshops();

            function find_workshops() {
                var path = '{{ route('admin.workshop.index') }}';
                $('#workshopsData').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: path,
                    columns: [{
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex'
                        }, 
                        {
                            data: 'name',
                            name: 'name'
                        },
                        {
                            data: 'initials',
                            name: 'initials'
                        },
                        {
                            data: 'logo',
                            name: 'logo',
                            orderable: false,
                            searchable: false
                        },
                        {
                            data: 'phone',
                            name: 'phone'
                        },
                        {
                            data: 'email',
                            name: 'email'
                        },
                        {
                            data: 'action',
                            name: 'action',
                            orderable: false,
                            searchable: false
                        },
                    ],
                    "autoWidth": false,
                    "responsive": true,
                });
            }

            $('#newWorkShopBtn').click(function(e) {
                e.preventDefault();
                $('#newWorkShopModal').modal('show');
                $('#newWorkShopForm')[0].reset();
            });

            $('#newWorkShopForm').submit(function(e) {
                e.preventDefault();
                var form = $(this);
                var formData = new FormData(form[0]);
                var path = '{{ route('admin.workshop.store') }}';
                $.ajax({
                    url: path,
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    beforeSend: function() {
                        $('#newWorkShopSubmitBtn').html(
                            '<i class="fa fa-spinner fa-spin"></i>');
                        $('#newWorkShopSubmitBtn').attr('disabled', true);
                    },
                    complete: function() {
                        $('#newWorkShopSubmitBtn').html('Save');
                        $('#newWorkShopSubmitBtn').attr('disabled', false);
                    },
                    success: function(data) {
                        if (data['status']) {
                            toastr.success(data['message']);
                            $('#newWorkShopModal').modal('hide');
                            $('#newWorkShopForm')[0].reset();
                            $('#workshopsData').DataTable().ajax.reload();
                        } else {
                            console.log(data);
                        }
                    }
                });
            });

            $(document).on('click', '.editWorkshopBtn', function(e) {
                e.preventDefault();
                var workshop_id = $(this).attr('data-id');
                var path = '{{ route('admin.workshop.show') }}';
                var token = '{{ csrf_token() }}';
                $.ajax({
                    url: path,
                    type: 'POST',
                    data: {
                        _token: token,
                        workshop_id: workshop_id
                    },
                    success: function(data) {
                        if (data['status']) {
                            $('#updateWorkShopModal').modal('show');
                            $('#updateWorkShopId').val(data['data']['id']);
                            $('#updateWorkShopTitle').val(data['data']['name']);
                            $('#updateWorkShopPhone').val(data['data']['phone']);
                            $('#updateWorkShopEmail').val(data['data']['email']);
                            $('#updateWorkShopAddress').val(data['data']['address']);
                        } else {
                            console.log(data);
                        }
                    }
                });
            });

            $('#updateWorkShopForm').submit(function(e) {
                e.preventDefault();
                var form = $(this);
                var formData = new FormData(form[0]);
                var path = '{{ route('admin.workshop.update') }}';
                $.ajax({
                    url: path,
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    beforeSend: function() {
                        $('#updateWorkShopSubmitBtn').html(
                            '<i class="fa fa-spinner fa-spin"></i>');
                        $('#updateWorkShopSubmitBtn').attr('disabled', true);
                    },
                    complete: function() {
                        $('#updateWorkShopSubmitBtn').html('Update');
                        $('#updateWorkShopSubmitBtn').attr('disabled', false);
                    },
                    success: function(data) {
                        if (data['status']) {
                            toastr.success(data['message']);
                            $('#updateWorkShopModal').modal('hide');
                            $('#updateWorkShopForm')[0].reset();
                            $('#workshopsData').DataTable().ajax.reload();
                        } else {
                            console.log(data);
                        }
                    }
                });
            });

            $(document).on('click', '.deleteWorkshopBtn', function(e) {
                e.preventDefault();
                var path = '{{ route('admin.workshop.delete') }}';
                var workshop_id = $(this).attr('data-id');
                var token = '{{ csrf_token() }}';
                Swal.fire({
                    title: "Are you sure?",
                    text: "Once deleted, you will not be able to recover this workshop!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: path,
                            type: "POST",
                            data: {
                                workshop_id: workshop_id,
                                _token: token,
                            },
                            dataType: "json",
                            success: function(data) {
                                if (data['status']) {
                                    Swal.fire(data['message'], '', 'success')
                                    $('#workshopsData').DataTable().ajax.reload();
                                }
                            }
                        });
                    } else if (result.isDenied) {
                        Swal.fire('Changes are not saved', '', 'info');
                    }
                });
            });

            $(document).on('click', '.selectWorkshopBtn', function(e){
                e.preventDefault();
                var workshop_id = $(this).attr('data-id');
                var path = '{{ route('admin.workshop.show') }}';
                var token = '{{ csrf_token() }}';
                $.ajax({
                    url: path,
                    type: 'POST',
                    data: {
                        _token: token,
                        workshop_id: workshop_id
                    },
                    success: function(data) {
                        if (data['status']) {
                            let workshop_url = '{{ route('admin.dashboard.workshop.index', ':id') }}'.replace(':id', data.data.id);
                            window.location.href = workshop_url;
                        } else {
                            console.log(data);
                        }
                    }
                });
            });

        });
    </script>
@endsection
