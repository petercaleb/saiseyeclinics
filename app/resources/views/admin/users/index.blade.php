@extends('admin.layouts.temp')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Users</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.dashboard.index', $clinic->id) }}">Home</a>
                        </li>
                        <li class="breadcrumb-item active">
                            Users
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
                                <a href="#" class="btn btn-primary btn-sm newUserBtn">
                                    <i class="fa fa-plus-circle"></i> New User
                                </a>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body table-responsive">
                            <table id="usersData" class="table table-bordered table-striped table-hover">
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

        <div class="modal fade" id="newUserModal">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">
                            New User
                        </h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="newUserForm">
                        @csrf
                        <div class="modal-body">
                            <input type="hidden" value="{{ $clinic->id }}" name="clinic_id" id="newUserClinicId"
                                class="form-control" />

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="newUserFirstName">First Name</label>
                                        <input type="text" class="form-control" name="first_name" id="newUserFirstName"
                                            placeholder="Enter First Name">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="newUserLastName">Last Name</label>
                                        <input type="text" class="form-control" name="last_name" id="newUserLastName"
                                            placeholder="Enter Last Name">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="newUserPhone">Telephone</label>
                                        <input type="text" class="form-control" name="phone" id="newUserPhone"
                                            placeholder="Enter Telephone Number">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="newUserEmail">Email Address</label>
                                        <input type="email" class="form-control" name="email" id="newUserEmail"
                                            placeholder="Enter Email Address">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="newUserStatus">Status</label>
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

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="newUserRole">Role</label>
                                        <select id="newUserRole" name="role_id" class="form-control select2 select2-primary"
                                            data-dropdown-css-class="select2-primary" style="width: 100%;">
                                            <option disabled="disabled" selected="selected">Choose Role</option>
                                            <option value="doctor">Doctor</option>
                                        </select>
                                    </div>
                                    <!-- /.form-group -->
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" id="newUserSubmitBtn" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->

        <div class="modal fade" id="viewUserModal">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">
                            New User
                        </h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="newUserForm">
                        @csrf
                        <div class="modal-body">
                            <input type="hidden" value="{{ $clinic->id }}" name="clinic_id" id="newUserClinicId"
                                class="form-control" />

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="newUserFirstName">First Name</label>
                                        <input type="text" class="form-control" name="first_name"
                                            id="newUserFirstName" placeholder="Enter First Name">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="newUserLastName">Last Name</label>
                                        <input type="text" class="form-control" name="last_name" id="newUserLastName"
                                            placeholder="Enter Last Name">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="newUserPhone">Telephone</label>
                                        <input type="text" class="form-control" name="phone" id="newUserPhone"
                                            placeholder="Enter Telephone Number">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="newUserEmail">Email Address</label>
                                        <input type="email" class="form-control" name="email" id="newUserEmail"
                                            placeholder="Enter Email Address">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="newUserStatus">Status</label>
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

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="newUserRole">Role</label>
                                        <select id="newUserRole" name="role_id"
                                            class="form-control select2 select2-primary"
                                            data-dropdown-css-class="select2-primary" style="width: 100%;">
                                            <option disabled="disabled" selected="selected">Choose Role</option>
                                            <option value="doctor">Doctor</option>
                                        </select>
                                    </div>
                                    <!-- /.form-group -->
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" id="newUserSubmitBtn" class="btn btn-primary">Save</button>
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

            find_users();

            function find_users() {
                var path = '{{ route('admin.users.index', $clinic->id) }}';
                $('#usersData').DataTable({
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

            $(document).on('click', '.newUserBtn', function(e) {
                e.preventDefault();
                $('#newUserModal').modal('show');
            });

            $('#newUserForm').submit(function(e) {
                e.preventDefault();
                var form = $(this);
                var formData = new FormData(form[0]);
                var path = '{{ route('admin.users.store') }}';
                $.ajax({
                    url: path,
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    beforeSend: function() {
                        $('#newUserSubmitBtn').html('<i class="fa fa-spinner fa-spin"></i>');
                        $('#newUserSubmitBtn').attr('disabled', true);
                    },
                    complete: function() {
                        $('#newUserSubmitBtn').html('Save');
                        $('#newUserSubmitBtn').attr('disabled', false);
                    },
                    success: function(data) {
                        if (data['status']) {
                            $('#newUserModal').modal('hide');
                            $('#newUserForm')[0].reset();
                            $('#usersData').DataTable().ajax.reload();
                        }
                    },
                    error: function(data) {
                        var errors = data.responseJSON.errors;
                        if (errors) {
                            $.each(errors, function(key, value) {
                                toastr.error(value);
                            });
                        }
                    },
                });
            });

            //delete user
            $(document).on('click', '.deleteUsersBtn', function(e) {
                e.preventDefault();
                var path = '{{ route('admin.users.delete') }}';
                var user_id = $(this).data('id');
                var token = '{{ csrf_token() }}';
                Swal.fire({
                    title: "Are you sure?",
                    text: "Once deleted, you will not be able to recover this Doctor!",
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
                                user_id: user_id,
                                _token: token,
                            },
                            dataType: "json",
                            success: function(data) {
                                if (data['status']) {
                                    Swal.fire(data['message'], '', 'success')
                                    $('#usersData').DataTable().ajax.reload();
                                } else {
                                    console.log(data);
                                }
                            }
                        });
                    } else if (result.isDenied) {
                        Swal.fire('Changes are not saved', '', 'info');
                    }
                });
            });

            // deactivate user
            $(document).on('click', '.deactivateBtn', function(e) {
                e.preventDefault();
                Swal.fire({
                    title: "Are you sure?",
                    text: "You will be deactivating the current account",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                }).then((result) => {
                    /* Read more about isConfirmed, isDenied below */
                    if (result.isConfirmed) {
                        let path = '{{ route('admin.users.update.status', ':id') }}';
                        let user_id = $(this).data('id');
                        path = path.replace(':id', user_id);
                        let token = '{{ csrf_token() }}';
                        let status = $(this).data('status');
                        $.ajax({
                            url: path,
                            type: "POST",
                            data: {
                                status:status,
                                _token: token,
                            },
                            dataType: "json",
                            success: function(data) {
                                if (data['status']) {
                                    Swal.fire(data['message'], '', 'success')
                                    $('#usersData').DataTable().ajax.reload();
                                }
                            },
                            error: function(data) {
                                var errors = data.responseJSON.errors;
                                if (errors) {
                                    $.each(errors, function(key, value) {
                                        toastr.error(value);
                                    });
                                }
                            },
                        });
                    } else if (result.isDenied) {
                        Swal.fire('Changes are not saved', '', 'info');
                    }
                });
            });

             // activate user
             $(document).on('click', '.activateBtn', function(e) {
                e.preventDefault();
                Swal.fire({
                    title: "Are you sure?",
                    text: "You will be activating the current account",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                }).then((result) => {
                    /* Read more about isConfirmed, isDenied below */
                    if (result.isConfirmed) {
                        let path = '{{ route('admin.users.update.status', ':id') }}';
                        let user_id = $(this).data('id');
                        path = path.replace(':id', user_id);
                        let token = '{{ csrf_token() }}';
                        let status = $(this).data('status');
                        $.ajax({
                            url: path,
                            type: "POST",
                            data: {
                                status:status,
                                _token: token,
                            },
                            dataType: "json",
                            success: function(data) {
                                if (data['status']) {
                                    Swal.fire(data['message'], '', 'success')
                                    $('#usersData').DataTable().ajax.reload();
                                }
                            },
                            error: function(data) {
                                var errors = data.responseJSON.errors;
                                if (errors) {
                                    $.each(errors, function(key, value) {
                                        toastr.error(value);
                                    });
                                }
                            },
                        });
                    } else if (result.isDenied) {
                        Swal.fire('Changes are not saved', '', 'info');
                    }
                });
            });
        });
    </script>
@endsection
