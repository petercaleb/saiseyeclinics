@extends('admin.layouts.workshop')

@section('content')
    <!-- Content Header (Page header) -->
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
                            Settings
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
                <div class="col-md-3">

                    <!-- Profile Image -->
                    <div class="card card-primary card-outline">
                        <div class="card-body box-profile">
                            <div class="text-center">
                                <img class="profile-user-img img-fluid img-circle" src="{{ asset('storage/workshops/'.$workshop->logo) }}"
                                    alt="User profile picture">
                            </div>

                            <h3 class="profile-username text-center">
                                {{ $workshop->name }}
                            </h3>

                            <p class="text-muted text-center">
                                {{ $workshop->initials }}
                            </p>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->

                    <!-- About Me Box -->
                    <div class="card card-primary">
                        <div class="card-body">
                            <strong><i class="fa fa-envelope mr-1"></i> Email Address</strong>

                            <p class="text-muted">
                                {{ $workshop->email }}
                            </p>

                            <hr>

                            <strong><i class="fa fa-phone mr-1"></i> Phone Number</strong>

                            <p class="text-muted">
                                {{ $workshop->phone }}
                            </p>

                            <hr>

                            <strong><i class="fa fa-map-signs mr-1"></i> Address</strong>

                            <p class="text-muted">
                                {{ $workshop->address }}
                            </p>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->

                <div class="col-md-9">
                    <div class="card">
                        <div class="card-header p-2">
                            <ul class="nav nav-pills">
                                <li class="nav-item">
                                    <a class="nav-link active" href="#updateOrganizationTab" data-toggle="tab">
                                        Update Organization
                                    </a>
                                </li>
                            </ul>
                        </div><!-- /.card-header -->
                        <div class="card-body">
                            <div class="tab-content">
                                <div class="active tab-pane" id="updateOrganizationTab">
                                    <form id="updateOrganizationForm" role="form">
                                        @csrf
                                        <input type="hidden" value="{{ $workshop->id }}" name="workshop_id" />
                                        <div class="form-group">
                                            <label for="updateOrganizationName">Workshop Name</label>
                                            <input type="text" class="form-control" value="{{ $workshop->name }}" id="updateOrganizationName" name="name" placeholder="Workshop Name">
                                        </div>

                                        <div class="form-group">
                                            <label for="updateOrganizationLogo">Logo</label>
                                            <div class="input-group">
                                                <div class="custom-file">
                                                    <input type="file" name="logo" class="custom-file-input"
                                                        id="updateOrganizationLogo">
                                                    <label class="custom-file-label" for="updateOrganizationLogo">
                                                        Choose file
                                                    </label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="updateOrganizationInitials">Workshop Initials</label>
                                            <input type="text" class="form-control" value="{{ $workshop->initials }}" id="updateOrganizationInitials" name="initials" placeholder="Clinic Initials">
                                        </div>

                                        <div class="form-group">
                                            <label for="updateOrganizationPhone">Phone Number</label>
                                            <input type="text" class="form-control" value="{{ $workshop->phone }}" id="updateOrganizationPhone" name="phone" placeholder="Phone Number">
                                        </div>

                                        <div class="form-group">
                                            <label for="updateOrganizationEmail">Email Address</label>
                                            <input type="email" value="{{ $workshop->email }}" name="email" class="form-control" id="updateOrganizationEmail">
                                        </div>

                                        <div class="form-group">
                                            <label for="updateOrganizationAddress">Address</label>
                                            <textarea name="address" id="updateOrganizationAddress" class="form-control" placeholder="Enter Workshop Address">{{ $workshop->address }}</textarea>
                                        </div>

                                        <div class="form-group">
                                            <button type="submit" id="updateOrganizationSubmitBtn"
                                                class="btn btn-primary btn-block">UPDATE</button>
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

            $('#updateOrganizationForm').submit(function(e) {
                e.preventDefault();
                $('#updateOrganizationSubmitBtn').html('<i class="fa fa-spinner fa-spin"></i>');
                $('#updateOrganizationSubmitBtn').attr('disabled', true);
                var path = '{{ route('admin.workshop.update') }}';
                var formData = new FormData(this);
                $.ajax({
                    url: path,
                    method: 'POST',
                    data: formData,
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function(data) {
                        $('#updateOrganizationSubmitBtn').html('UPDATE');
                        $('#updateOrganizationSubmitBtn').attr('disabled', false);
                        if (data['status']) {
                            toastr.success(data.message);
                            setTimeout(function() {
                                window.location.reload();
                            }, 2000);
                        } else {
                            console.log(data);
                        }
                    }
                });
            });


        });
    </script>
@endsection
