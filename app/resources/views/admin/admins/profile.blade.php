@extends('admin.layouts.app')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Profile</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.organization.index') }}">Home</a>
                        </li>
                        <li class="breadcrumb-item active">Admin Profile</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3">
                    <!-- Profile Image -->
                    <div class="card card-primary card-outline">
                        <div class="card-body box-profile">
                            <div class="text-center">
                                <img class="profile-user-img img-fluid img-circle"
                                    src="{{ asset('storage/admin/' . $admin->profile) }}" alt="{{ $admin->username }}">
                            </div>

                            <h3 class="profile-username text-center">{{ $admin->first_name }} {{ $admin->last_name }}
                            </h3>

                            <p class="text-muted text-center">{{ $admin->username }}</p>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->

                    <!-- About Me Box -->
                    <div class="card card-primary">
                        <div class="card-body">
                            <strong><i class="fa fa-phone mr-1"></i> Phone Number</strong>

                            <p class="text-muted">
                                {{ $admin->phone }}
                            </p>

                            <hr>

                            <strong><i class="fa fa-envelope mr-1"></i> Email Address</strong>

                            <p class="text-muted">{{ $admin->email }}</p>

                            <hr>

                            <strong><i class="fa fa-user-secret mr-1"></i> Gender</strong>

                            <p class="text-muted">
                                {{ $admin->gender }}
                            </p>

                            <hr>

                            <strong><i class="fa fa-calendar mr-1"></i> Date of Birth</strong>

                            <p class="text-muted">
                                <span class="tag tag-danger">{{ $admin->dob }}</span>
                            </p>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->

                <div class="col-md-9">
                    <div class="card card-primary card-outline">
                        <div class="card-header p-2">
                            <ul class="nav nav-pills">
                                <li class="nav-item">
                                    <a class="nav-link active" href="#updateProfileTab" data-toggle="tab">
                                        Update Profile
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#changePasswordTab" data-toggle="tab">
                                        Change Password
                                    </a>
                                </li>
                            </ul>
                        </div><!-- /.card-header -->
                        <div class="card-body">
                            <div class="tab-content">
                                <div class="active tab-pane" id="updateProfileTab">
                                    <form id="updateProfileForm" role="form">
                                        @csrf
                                        <div class="form-group">
                                            <label for="updateProfileFirstName">First Name</label>
                                            <input type="text" class="form-control" value="{{ $admin->first_name }}"
                                                name="first_name" id="updateProfileFirstName">
                                        </div>

                                        <div class="form-group">
                                            <label for="updateProfileLastName">Last Name</label>
                                            <input type="text" class="form-control" value="{{ $admin->last_name }}"
                                                name="last_name" id="updateProfileLastName">
                                        </div>

                                        <div class="form-group">
                                            <label for="updateProfileLastName">Profile</label>
                                            <div class="input-group">
                                                <div class="custom-file">
                                                    <input type="file" name="profile" class="custom-file-input"
                                                        id="updateProfileLastName">
                                                    <label class="custom-file-label" for="updateProfileLastName">
                                                        Choose file
                                                    </label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="updateProfilePhone">Phone Number</label>
                                            <input type="text" value="{{ $admin->phone }}" name="phone"
                                                class="form-control" id="updateProfilePhone">
                                        </div>

                                        <div class="form-group">
                                            <label for="updateProfileEmail">Email Address</label>
                                            <input type="email" value="{{ $admin->email }}" name="email"
                                                class="form-control" id="updateProfileEmail">
                                        </div>

                                        <div class="form-group">
                                            <label for="updateProfileGender">Gender</label>
                                            <select id="updateProfileGender" name="gender" class="form-control select2"
                                                style="width: 100%;">
                                                <option disabled="disabled" selected="selected">Choose Gender</option>
                                                <option @if ($admin->gender == 'Male') selected="selected" @endif
                                                    value="Male">Male</option>
                                                <option @if ($admin->gender == 'Female') selected="selected" @endif
                                                    value="Female">Female</option>
                                            </select>

                                        </div>

                                        <div class="form-group">
                                            <label for="updateProfileDOB">Date of Birth</label>
                                            <input type="text" value="{{ $admin->dob }}" name="dob"
                                                class="form-control datepicker" id="updateProfileDOB"
                                                placeholder="Enter Date of Birth">
                                        </div>

                                        <div class="form-group">
                                            <label for="updateProfileUsername">Username</label>
                                            <input type="text" value="{{ $admin->username }}" name="username"
                                                class="form-control" id="updateProfileUsername">
                                        </div>

                                        <div class="form-group">
                                            <button type="submit" id="updateProfileSubmitBtn"
                                                class="btn btn-primary btn-block">UPDATE</button>
                                        </div>
                                    </form>
                                </div>
                                <!-- /.tab-pane -->

                                <div class="tab-pane" id="changePasswordTab">
                                    <!-- The timeline -->
                                    <form id="changePasswordForm" role="form">
                                        @csrf
                                        <div class="form-group">
                                            <label for="changePasswordCurrentPassword">Current Password</label>
                                            <input type="password" class="form-control" name="current_password"
                                                placeholder="Enter Current Password" id="changePasswordCurrentPassword">
                                        </div>

                                        <div class="form-group">
                                            <label for="changePasswordNewPassword">New Password</label>
                                            <input type="password" class="form-control" placeholder="Enter new password"
                                                name="new_password" id="changePasswordNewPassword">
                                        </div>

                                        <div class="form-group">
                                            <label for="changePasswordConfirmPassword">Confirm Password</label>
                                            <input type="password" placeholder="Retype Password" name="confirm_password"
                                                class="form-control" id="changePasswordConfirmPassword">
                                        </div>
                                        <div class="form-group">
                                            <button type="submit" id="changePasswordSubmitPassword"
                                                class="btn btn-primary btn-block">
                                                UPDATE PASSWORD
                                            </button>
                                        </div>
                                    </form>
                                </div>
                                <!-- /.tab-pane -->
                            </div>
                            <!-- /.tab-content -->
                        </div><!-- /.card-body -->
                    </div>
                    <!-- /.nav-tabs-custom -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {

            // update profile
            $('#updateProfileForm').submit(function(e) {
                e.preventDefault();
                var formData = new FormData(this);
                var path = "{{ route('admin.personal.update') }}";
                $.ajax({
                    url: path,
                    type: "POST",
                    data: formData,
                    dataType: "json",
                    contentType: false,
                    processData: false,
                    beforeSend: function() {
                        $('#updateProfileSubmitBtn').html(
                            '<i class="fa fa-spin fa-spinner"></i>');
                    },
                    complete: function() {
                        $('#updateProfileSubmitBtn').html('UPDATE');
                    },
                    success: function(data) {
                        if (data['status']) {
                            toastr.success(data['message']);
                            location.reload();
                        } else {
                            console.log(data);
                        }
                    }
                });
            });

            // change password
            $('#changePasswordForm').submit(function(e){
                e.preventDefault();
                var formData = new FormData(this);
                var path = "{{ route('admin.personal.update.password') }}";
                $.ajax({
                    url: path,
                    type: "POST",
                    data: formData,
                    dataType: "json",
                    contentType: false,
                    processData: false,
                    beforeSend: function() {
                        $('#changePasswordSubmitPassword').html(
                            '<i class="fa fa-spin fa-spinner"></i>');
                    },
                    complete: function() {
                        $('#changePasswordSubmitPassword').html('UPDATE');
                    },
                    success: function(data) {
                        if (data['status']) {
                            toastr.success(data['message']);
                            location.reload();
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
