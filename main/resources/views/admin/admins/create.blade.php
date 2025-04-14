@extends('admin.layouts.app')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Create Admin</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.organization.index') }}">Home</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.admins.index') }}">Admins</a>
                        </li>
                        <li class="breadcrumb-item active">Create Admin</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <!-- general form elements -->
                    <div class="card card-primary">
                        <form id="newAdminForm">
                            <div class="card-body">
                                @csrf
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="newAdminFirstName">First Name</label>
                                            <input type="text" name="first_name" class="form-control"
                                                id="newAdminFirstName" placeholder="Enter First Name" required>
                                        </div>
                                        <!--/.form-group -->
                                    </div>
                                    <!--/.col -->

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="newAdminLastName">Last Name</label>
                                            <input type="text" name="last_name" class="form-control"
                                                id="newAdminFirstName" placeholder="Enter Last Name" required>
                                        </div>
                                        <!--/.form-group -->
                                    </div>
                                    <!--/.col -->
                                </div>
                                <!--/.row -->

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="newAdminPhone">Phone Number</label>
                                            <input type="text" class="form-control" name="phone" id="newAdminPhone"
                                                placeholder="Phone Number">
                                        </div>
                                    </div>
                                    <!--/.col -->

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="newAdminEmail">Email Address</label>
                                            <input type="email" class="form-control" name="email" id="newAdminEmail"
                                                placeholder="Email Address">
                                        </div>
                                    </div>
                                    <!--/.col -->
                                </div>
                                <!--/.row -->

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="newAdminGender">Gender</label>
                                            <select id="newAdminGender" name="gender" class="form-control select2"
                                                style="width: 100%;">
                                                <option selected="selected" disabled="disabled">Choose Gender</option>
                                                <option value="Male">Male</option>
                                                <option value="Female">Female</option>
                                            </select>
                                        </div>
                                        <!-- /.form-group -->
                                    </div>
                                    <!--/.col -->
                                    <div class="col-md-6">

                                        <div class="form-group">
                                            <label for="newAdminDOB">Date of Birth</label>
                                            <input type="text" name="dob" class="form-control datepicker"
                                                id="newAdminDOB" placeholder="Enter Date of Birth">
                                        </div>

                                    </div>
                                    <!--/.col -->
                                </div>
                                <!--/.row -->

                                <div class="row">

                                    <div class="col-md-12">

                                        <div class="form-group">
                                            <label for="newAdminImage">Profile</label>
                                            <div class="input-group">
                                                <div class="custom-file">
                                                    <input type="file" name="profile" class="custom-file-input"
                                                        id="newAdminImage">
                                                    <label class="custom-file-label" for="newAdminImage">Choose file</label>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <!--/.col -->

                                </div>
                                <!--/.row -->

                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="newAdminGender">Roles</label>
                                            <select id="newAdminGender" name="role_id" class="form-control select2"
                                                style="width: 100%;">
                                                <option selected="selected" disabled="disabled">Choose Role</option>
                                                @foreach ($roles as $role)
                                                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <!-- /.form-group -->
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button type="submit" class="btn btn-primary">Save</button>
                                <a href="{{ route('admin.admins.index') }}" class="float-right btn btn-danger">Cancel</a>
                            </div>
                            <!--/.card-footer -->
                        </form>
                    </div>
                    <!--/.card -->
                </div>
            </div>
            <!--/.row -->
        </div>
        <!--/.container-fluid -->
    </section>
    <!--/.content -->
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            $('#newAdminForm').submit(function(e) {
                e.preventDefault();
                let form = $(this);
                let formData = new FormData(form[0]);
                let path = '{{ route('admin.admins.create') }}';
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
                    success: function(data) {
                        if (data['status']) {
                            toastr.success(data['message']);
                            setTimeout(() => {
                                window.location.href =
                                    '{{ route('admin.admins.index') }}';
                            }, 1000);
                        }
                    },
                    error: function(error) {
                        $.each(error.responseJSON.errors, function(i, error) {
                            toastr.error(error);
                        });
                    }
                });
            });
        });
    </script>
@endsection
