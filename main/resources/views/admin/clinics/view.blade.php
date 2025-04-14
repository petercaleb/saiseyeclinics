@extends('admin.layouts.temp')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{ $clinic->clinic }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.dashboard.index', $clinic->id) }}">Home</a>
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
                                <img class="profile-user-img img-fluid img-circle"
                                    src="{{ asset('storage/clinics/' . $clinic->logo) }}" alt="User profile picture">
                            </div>

                            <h3 class="profile-username text-center">
                                {{ $clinic->clinic }}
                            </h3>

                            <p class="text-muted text-center">
                                {{ $clinic->initials }}
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
                                {{ $clinic->email }}
                            </p>

                            <hr>

                            <strong><i class="fa fa-phone mr-1"></i> Phone Number</strong>

                            <p class="text-muted">
                                {{ $clinic->phone }}
                            </p>

                            <hr>

                            <strong><i class="fa fa-map-signs mr-1"></i> Address</strong>

                            <p class="text-muted">
                                {{ $clinic->address }}
                            </p>

                            <hr>

                            <strong><i class="fa fa-map mr-1"></i> Location</strong>

                            <p class="text-muted">
                                {{ $clinic->location }}
                            </p>

                            <hr>

                            <strong><i class="fas fa-file-alt mr-1"></i> ETIMS Number</strong>

                            <p class="text-muted">
                                {{ $clinic->etims_number }}
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
                                    <a class="nav-link active" href="#updateClinicTab" data-toggle="tab">
                                        Update Clinic
                                    </a>
                                </li>
                            </ul>
                        </div><!-- /.card-header -->
                        <div class="card-body">
                            <div class="tab-content">
                                <div class="active tab-pane" id="updateClinicTab">
                                    <form id="updateClinicForm" role="form">
                                        @csrf
                                        <input type="hidden" value="{{ $clinic->id }}" name="clinic_id" />
                                        <div class="form-group">
                                            <label for="updateClinicName">Clinic Name</label>
                                            <input type="text" class="form-control" value="{{ $clinic->clinic }}"
                                                id="updateClinicName" name="clinic" placeholder="Clinic Name">
                                        </div>

                                        <div class="form-group">
                                            <label for="updateClinicLogo">Logo</label>
                                            <div class="input-group">
                                                <div class="custom-file">
                                                    <input type="file" name="logo" class="custom-file-input"
                                                        id="updateClinicLogo">
                                                    <label class="custom-file-label" for="updateClinicLogo">
                                                        Choose file
                                                    </label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="updateClinicInitials">Clinic Initials</label>
                                            <input type="text" class="form-control" value="{{ $clinic->initials }}"
                                                id="updateClinicInitials" name="initials" placeholder="Clinic Initials">
                                        </div>

                                        <div class="form-group">
                                            <label for="updateClinicPhone">Phone Number</label>
                                            <input type="text" class="form-control" value="{{ $clinic->phone }}"
                                                id="updateClinicPhone" name="phone" placeholder="Phone Number">
                                        </div>

                                        <div class="form-group">
                                            <label for="updateClinicEmail">Email Address</label>
                                            <input type="email" value="{{ $clinic->email }}" name="email"
                                                class="form-control" id="updateClinicEmail">
                                        </div>



                                        <div class="form-group">
                                            <label for="updateClinicAddress">Address</label>
                                            <input type="text" name="address" id="updateClinicAddress" value="{{ $clinic->address }}" class="form-control" placeholder="Enter Clinic's Address">
                                        </div>

                                        <div class="form-group">
                                            <label for="updateClinicLocation">Location</label>
                                            <input type="text" value="{{ $clinic->location }}" name="location"
                                                class="form-control" id="updateClinicLocation">
                                        </div>


                                        <div class="form-group">
                                            <label for="updateClinicETIMSNumber">ETIMS Number</label>
                                            <input type="text" value="{{ $clinic->etims_number }}" name="etims_number"
                                                class="form-control" id="updateClinicETIMSNumber" placeholder="Enter ETIMS Number">
                                        </div>

                                        <div class="form-group">
                                            <button type="submit" id="updateClinicSubmitBtn"
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

            $('#updateClinicForm').submit(function(e) {
                e.preventDefault();
                $('#updateClinicSubmitBtn').html('<i class="fa fa-spinner fa-spin"></i>');
                $('#updateClinicSubmitBtn').attr('disabled', true);
                var path = '{{ route('admin.clinics.update') }}';
                var formData = new FormData(this);
                $.ajax({
                    url: path,
                    method: 'POST',
                    data: formData,
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function(data) {
                        $('#updateClinicSubmitBtn').html('UPDATE');
                        $('#updateClinicSubmitBtn').attr('disabled', false);
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
