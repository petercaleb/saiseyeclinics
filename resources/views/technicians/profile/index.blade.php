@extends('technicians.layouts.app')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{ $technician->first_name }} {{ $technician->last_name }} Profile</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ route('users.dashboard.index') }}">Home</a>
                        </li>
                        <li class="breadcrumb-item active">Technician Profile</li>
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
                                    src="{{ asset('storage/technicians/' . $technician->profile) }}"
                                    alt="{{ $technician->username }}">
                            </div>

                            <h3 class="profile-username text-center">{{ $technician->first_name }}
                                {{ $technician->last_name }}
                            </h3>

                            <p class="text-muted text-center">{{ $technician->username }}</p>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->

                    <!-- About Me Box -->
                    <div class="card card-primary">
                        <div class="card-body">
                            <strong><i class="fa fa-phone mr-1"></i> Phone Number</strong>

                            <p class="text-muted">
                                {{ $technician->phone }}
                            </p>

                            <hr>

                            <strong><i class="fa fa-envelope mr-1"></i> Email Address</strong>

                            <p class="text-muted">{{ $technician->email }}</p>
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
                                            <input type="text" class="form-control"
                                                value="{{ $technician->first_name }}" name="first_name"
                                                id="updateProfileFirstName">
                                        </div>

                                        <div class="form-group">
                                            <label for="updateProfileLastName">Last Name</label>
                                            <input type="text" class="form-control" value="{{ $technician->last_name }}"
                                                name="last_name" id="updateProfileLastName">
                                        </div>

                                        <div class="form-group">
                                            <label for="updateProfileImage">Profile Pic</label>
                                            <div class="input-group">
                                                <div class="custom-file">
                                                    <input type="file" name="profile" class="custom-file-input" id="updateProfileImage">
                                                    <label class="custom-file-label" for="updateProfileImage">
                                                        Choose file
                                                    </label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="updateProfilePhone">Phone Number</label>
                                            <input type="text" value="{{ $technician->phone }}" name="phone"
                                                class="form-control" id="updateProfilePhone">
                                        </div>

                                        <div class="form-group">
                                            <label for="updateProfileEmail">Email Address</label>
                                            <input type="email" value="{{ $technician->email }}" name="email"
                                                class="form-control" id="updateProfileEmail">
                                        </div>

                                        <div class="form-group">
                                            <label for="updateProfileUsername">Username</label>
                                            <input type="text" value="{{ $technician->username }}" name="username"
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

            $('#updateProfileForm').submit(function(e){
                e.preventDefault();
                let form = $(this);
                var formData = new FormData(form[0]);
                var path = '{{ route('technicians.technicians.update') }}';
                $.ajax({
                    url:path,
                    type:'POST',
                    data:formData,
                    contentType:false,
                    processData:false,
                    dataType:"json",
                    beforeSend:function(){
                        $('#updateProfileSubmitBtn').html('<i class="fa fa-spinner fa-spin"></i>');
                        $('#updateProfileSubmitBtn').attr('disabled',true);
                    },
                    complete:function(){
                        $('#updateProfileSubmitBtn').html('UPDATE');
                        $('#updateProfileSubmitBtn').attr('disabled',false);
                    },
                    success:function(data){
                        if(data['status']){
                            toastr.success(data['message']);
                            setTimeout(() => {
                                location.reload();
                            }, 1000);
                        }else{
                            console.log(data);
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
            });

            $('#changePasswordForm').submit(function(e){
                e.preventDefault();
                let form = $(this);
                let formData = new FormData(form[0]);
                let path = '{{ route('technicians.technicians.update.password') }}';
                $.ajax({
                    url:path,
                    type:'POST',
                    data:formData,
                    contentType:false,
                    processData:false,
                    dataType:"json",
                    beforeSend:function(){
                        $('#changePasswordSubmitPassword').html('<i class="fa fa-spinner fa-spin"></i>');
                        $('#changePasswordSubmitPassword').attr('disabled',true);
                    },
                    complete:function(){
                        $('#changePasswordSubmitPassword').html('UPDATE PASSWORD');
                        $('#changePasswordSubmitPassword').attr('disabled',false);
                    },
                    success:function(data){
                        if(data['status']){
                            toastr.success(data['message']);
                            setTimeout(() => {
                                location.reload();
                            }, 1000);
                        }else{
                            console.log(data);
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
            });

        });
    </script>
@endsection
