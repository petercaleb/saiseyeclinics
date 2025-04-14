@extends('admin.layouts.app')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Settings</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.organization.index') }}">Home</a>
                        </li>
                        <li class="breadcrumb-item active">
                            {{ $organization->organization }} Settings
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
                                <img class="profile-user-img img-fluid img-circle"
                                    src="{{ asset('storage/organization/' . $organization->logo) }}"
                                    alt="User profile picture">
                            </div>

                            <h3 class="profile-username text-center">
                                {{ $organization->organization }}
                            </h3>

                            <p class="text-muted text-center">
                                {{ $organization->tagline }}
                            </p>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->

                    <!-- About Me Box -->
                    <div class="card card-primary">
                        <div class="card-body">
                            <strong><i class="fa fa-phone mr-1"></i> Phone Number</strong>

                            <p class="text-muted">
                                {{ $organization->phone }}
                            </p>

                            <hr>

                            <strong><i class="fa fa-envelop mr-1"></i> Email Address</strong>

                            <p class="text-muted">
                                {{ $organization->email }}
                            </p>

                            <hr>

                            <strong><i class="fa fa-map-signs mr-1"></i> Address</strong>

                            <p class="text-muted">
                                {{ $organization->address }}
                            </p>

                            <hr>

                            <strong><i class="fa fa-map mr-1"></i> Location</strong>

                            <p class="text-muted">
                                {{ $organization->location }}
                            </p>

                            <hr>

                            <strong><i class="fa fa-folder-open mr-1"></i> Profile</strong>

                            <p class="text-muted">
                                {{ $organization->profile }}
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
                                        <div class="form-group">
                                            <input type="hidden" class="form-control" value="{{ $organization->id }}"
                                                name="organization_id" id="updateOrganizationId">
                                        </div>
                                        <div class="form-group">
                                            <label for="updateOrganizationOrganization">Organization Name</label>
                                            <input type="text" class="form-control"
                                                value="{{ $organization->organization }}" name="organization"
                                                id="updateOrganizationOrganization">
                                        </div>

                                        <div class="form-group">
                                            <label for="updateOrganizationTagline">Tagline</label>
                                            <input type="text" class="form-control"
                                                value="{{ $organization->tagline }}" name="tagline"
                                                id="updateOrganizationTagline">
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
                                            <label for="updateOrganizationPhone">Phone Number</label>
                                            <input type="text" value="{{ $organization->phone }}" name="phone"
                                                class="form-control" id="updateOrganizationPhone">
                                        </div>

                                        <div class="form-group">
                                            <label for="updateOrganizationEmail">Email Address</label>
                                            <input type="email" value="{{ $organization->email }}" name="email"
                                                class="form-control" id="updateOrganizationEmail">
                                        </div>

                                        <div class="form-group">
                                            <label for="updateOrganizationAddress">Address</label>
                                            <textarea name="address" class="form-control" id="updateOrganizationAddress" placeholder="Enter Address">{{ $organization->address }}</textarea>
                                        </div>

                                        <div class="form-group">
                                            <label for="updateOrganizationLocation">Location</label>
                                            <input type="text" value="{{ $organization->location }}" name="location"
                                                class="form-control" id="updateOrganizationLocation"
                                                placeholder="Enter Organization's Location">
                                        </div>

                                        <div class="form-group">
                                            <label for="updateOrganizationWebsite">Website</label>
                                            <input type="text" value="{{ $organization->website }}" name="website"
                                                class="form-control" placeholder="Enter Organizational Website"
                                                id="updateOrganizationWebsite">
                                        </div>

                                        <div class="form-group">
                                            <label for="updateOrganizationProfile">Profile</label>
                                            <textarea name="profile" class="form-control" id="updateOrganizationProfile"
                                                placeholder="Enter Organizational Profile">{{ $organization->profile }}</textarea>
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
                var form = $(this);
                var formData = new FormData(form[0]);
                var path = '{{ route('admin.organization.update') }}';
                $.ajax({
                    url: path,
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    beforeSend:function(){
                        $('#updateOrganizationSubmitBtn').html('<i class="fa fa-spinner fa-spin"></i>');
                        $('#updateOrganizationSubmitBtn').attr('disabled', true);
                    },
                    complete:function(){
                        $('#updateOrganizationSubmitBtn').html('UPDATE');
                        $('#updateOrganizationSubmitBtn').attr('disabled', false);
                    },
                    success: function(data) {
                        if (data['status']) {
                            toastr.success(data.message);
                            setTimeout(function() {
                                window.location.reload();
                            }, 1000);
                        } else {
                            console.log(data);
                        }
                    }
                });
            });
        });
    </script>
@endsection
