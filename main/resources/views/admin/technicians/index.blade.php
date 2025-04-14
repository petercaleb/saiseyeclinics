@extends('admin.layouts.workshop')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{ $workshop->name }} Technicians</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.dashboard.workshop.index', $workshop->id) }}">Home</a>
                        </li>
                        <li class="breadcrumb-item active">
                            Technicians
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
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-tools">
                                <a href="#" id="newTechnicianBtn" class="btn btn-primary btn-sm">
                                    <i class="fa fa-plus-circle"></i> New Technician
                                </a>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body table-responsive">
                            <table id="techniciansData" class="table table-bordered table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>Full Names</th>
                                        <th>Phone</th>
                                        <th>Email</th>
                                        <th>Status</th>
                                        <th>Username</th>
                                        <th>Action</th>
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

        <div class="modal fade" id="newTechnicianModal">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">
                            New Technician
                        </h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="newTechnicianForm">
                        @csrf
                        <div class="modal-body">
                            <input type="hidden" value="{{ $workshop->id }}" name="workshop_id"
                                id="newTechnicianWorkshopId" class="form-control" />

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="newUserFirstName">First Name</label>
                                        <input type="text" class="form-control" name="first_name"
                                            id="newTechnicianFirstName" placeholder="Enter First Name">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="newUserLastName">Last Name</label>
                                        <input type="text" class="form-control" name="last_name"
                                            id="newTechnicianLastName" placeholder="Enter Last Name">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="newUserPhone">Telephone</label>
                                        <input type="text" class="form-control" name="phone" id="newTechnicianPhone"
                                            placeholder="Enter Telephone Number">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="newUserEmail">Email Address</label>
                                        <input type="email" class="form-control" name="email" id="newTechnicianEmail"
                                            placeholder="Enter Email Address">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="newTechnicianStatus">Status</label>
                                        <select id="newUserStatus" name="status"
                                            class="form-control select2 select2-danger"
                                            data-dropdown-css-class="select2-danger" style="width: 100%;">
                                            <option disabled="disabled" selected="selected">Choose Status</option>
                                            <option value="1">Active</option>
                                            <option value="0">Inactive</option>
                                        </select>
                                    </div>
                                    <!-- /.form-group -->
                                </div>
                            </div>

                            {{-- <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="newTechnicianRole">Role</label>
                                        <select id="newUserRole" name="role_id" class="form-control select2 select2-primary"
                                            data-dropdown-css-class="select2-primary" style="width: 100%;">
                                            <option disabled="disabled" selected="selected">Choose Role</option>
                                            <option value="doctor">Doctor</option>
                                        </select>
                                    </div>
                                    <!-- /.form-group -->
                                </div>
                            </div> --}}
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" id="newTechnicianSubmitBtn" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->

    </section><!-- /.content -->
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {

            find_technicians();

            function find_technicians() {
                var path = '{{ route('admin.workshop.technicians.index', $workshop->id) }}';
                $('#techniciansData').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: path,
                    columns: [{
                            data: 'full_names',
                            name: 'full_names'
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
                            data: 'status',
                            name: 'status'
                        },
                        {
                            data: 'username',
                            name: 'username'
                        },
                        {
                            data: 'action',
                            name: 'action',
                            orderable: false,
                            searchable: false
                        }
                    ],
                    'autoWidth': false,
                    'responsive': true,
                });
            }

            $(document).on('click', '#newTechnicianBtn', function(e) {
                e.preventDefault();
                $('#newTechnicianModal').modal('show');
            });

            $('#newTechnicianForm').submit(function(e) {
                e.preventDefault();
                var form = $(this);
                var formData = new FormData(form[0]);
                var path = '{{ route('admin.workshop.technicians.store') }}';
                $.ajax({
                    url: path,
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    beforeSend: function() {
                        $('#newTechnicianSubmitBtn').html(
                            '<i class="fa fa-spinner fa-spin"></i>');
                        $('#newTechnicianSubmitBtn').attr('disabled', true);
                    },
                    complete: function() {
                        $('#newTechnicianSubmitBtn').html('Save');
                        $('#newTechnicianSubmitBtn').attr('disabled', false);
                    },
                    success: function(data) {
                        if (data['status']) {
                            $('#newTechnicianModal').modal('hide');
                            $('#newTechnicianForm')[0].reset();
                            $('#techniciansData').DataTable().ajax.reload();
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

            $(document).on('click', '.deleteTechnicianBtn', function(e) {

                e.preventDefault();
                var technician_id = $(this).data('id');
                var path = "{{ route('admin.workshop.technicians.delete', ':id') }}";
                path = path.replace(':id', technician_id);
                var token = '{{ csrf_token() }}';
                Swal.fire({
                    title: "Are you sure?",
                    text: "Once deleted, you will not be able to recover this Technician!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                }).then((result) => {
                    /* Read more about isConfirmed, isDenied below */
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
                                    $('#techniciansData').DataTable().ajax.reload();
                                }
                            }
                        });
                    } else if (result.isDenied) {
                        Swal.fire('Changes are not saved', '', 'info');
                    }
                });

            });

            $(document).on('click', '.deactivateTechnicianBtn', function(e) {
                e.preventDefault();
                Swal.fire({
                    title: "Are you sure?",
                    text: "You are going to deactivate Technician account!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                }).then((result) => {
                    /* Read more about isConfirmed, isDenied below */
                    if (result.isConfirmed) {
                        let technician_id = $(this).data('id');
                        let path = "{{ route('admin.workshop.technicians.update.status', ':id') }}";
                        path = path.replace(':id', technician_id);
                        let status = $(this).data('status');
                        let token = '{{ csrf_token() }}';
                        $.ajax({
                            url: path,
                            type: "POST",
                            data: {
                                status: status,
                                _token: token,
                            },
                            dataType: "json",
                            success: function(data) {
                                if (data['status']) {
                                    Swal.fire(data['message'], '', 'success')
                                    $('#techniciansData').DataTable().ajax.reload();
                                }
                            },
                            error: function(data) {
                                var errors = data.responseJSON;
                                var errorsHtml = '<ul>';
                                $.each(errors['errors'], function(key, value) {
                                    errorsHtml += '<li>' + value + '</li>';
                                });
                                errorsHtml += '</ul>';
                                toastr.error(errorsHtml);
                            }
                        });
                    } else if (result.isDenied) {
                        Swal.fire('Changes are not saved', '', 'info');
                    }
                });
            });

            $(document).on('click', '.activateTechnicianBtn', function(e) {
                e.preventDefault();
                Swal.fire({
                    title: "Are you sure?",
                    text: "You are going to activate Technician account!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                }).then((result) => {
                    /* Read more about isConfirmed, isDenied below */
                    if (result.isConfirmed) {
                        let technician_id = $(this).data('id');
                        let path = "{{ route('admin.workshop.technicians.update.status', ':id') }}";
                        path = path.replace(':id', technician_id);
                        let status = $(this).data('status');
                        let token = '{{ csrf_token() }}';
                        $.ajax({
                            url: path,
                            type: "POST",
                            data: {
                                status: status,
                                _token: token,
                            },
                            dataType: "json",
                            success: function(data) {
                                if (data['status']) {
                                    Swal.fire(data['message'], '', 'success')
                                    $('#techniciansData').DataTable().ajax.reload();
                                }
                            },
                            error: function(data) {
                                var errors = data.responseJSON;
                                var errorsHtml = '<ul>';
                                $.each(errors['errors'], function(key, value) {
                                    errorsHtml += '<li>' + value + '</li>';
                                });
                                errorsHtml += '</ul>';
                                toastr.error(errorsHtml);
                            }
                        });
                    } else if (result.isDenied) {
                        Swal.fire('Changes are not saved', '', 'info');
                    }
                });
            });

        });
    </script>
@endsection
