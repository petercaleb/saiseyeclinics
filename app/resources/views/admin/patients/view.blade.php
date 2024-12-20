@extends('admin.layouts.temp')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{ $patient->first_name }} {{ $patient->last_name }} Profile</h1>
                    <small>Added By: {{ $patient->user->first_name }} {{ $patient->user->last_name }}</small><br>
                    <small>Clinic: {{ $clinic->clinic }}</small>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.dashboard.index', $clinic->id) }}">Home</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.patients.index', $clinic->id) }}">Patients</a>
                        </li>
                        <li class="breadcrumb-item active">Patient Profile</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                @include('admin.includes.patients.sidebar')
                <div class="col-md-9">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="callout callout-info">
                                <h5>
                                    Full Names
                                </h5>

                                <p>
                                    {{ $patient->first_name }} {{ $patient->last_name }}
                                </p>
                            </div>
                        </div>
                        <!--/.col -->
                        <div class="col-md-6">
                            <div class="callout callout-info">
                                <h5>
                                    ID/Passport Number
                                </h5>

                                <p>
                                    {{ $patient->id_number }}
                                </p>
                            </div>
                        </div>
                        <!--/.col -->
                    </div>
                    <!--/.row -->

                    <div class="row">
                        <div class="col-md-6">
                            <div class="callout callout-info">
                                <h5>
                                    Phone Number
                                </h5>

                                <p>
                                    {{ $patient->phone }}
                                </p>
                            </div>
                        </div>
                        <!--/.col -->
                        <div class="col-md-6">
                            <div class="callout callout-info">
                                <h5>
                                    Email Address
                                </h5>

                                <p>
                                    {{ $patient->email }}
                                </p>
                            </div>
                        </div>
                        <!--/.col -->
                    </div>
                    <!--/.row -->

                    <div class="row">
                        <div class="col-md-6">
                            <div class="callout callout-info">
                                <h5>
                                    Date of birth
                                </h5>

                                <p>
                                    {{ date('d, F, Y', strtotime($patient->dob)) }}
                                </p>
                            </div>
                        </div>
                        <!--/.col -->
                        <div class="col-md-6">
                            <div class="callout callout-info">
                                <h5>
                                    Gender
                                </h5>

                                <p>
                                    {{ $patient->gender }}
                                </p>
                            </div>
                        </div>
                        <!--/.col -->
                    </div>
                    <!--/.row -->

                    <div class="row">
                        <div class="col-md-6">
                            <div class="callout callout-info">
                                <h5>
                                    Next of kin
                                </h5>

                                <p>
                                    {{ $patient->next_of_kin }}
                                </p>
                            </div>
                        </div>
                        <!--/.col -->
                        <div class="col-md-6">
                            <div class="callout callout-info">
                                <h5>
                                    Next of kin contacts
                                </h5>

                                <p>
                                    {{ $patient->next_of_kin_contact }}
                                </p>
                            </div>
                        </div>
                        <!--/.col -->
                    </div>
                    <!--/.row -->

                    <div class="row">
                        <div class="col-md-6">
                            <div class="callout callout-info">
                                <h5>
                                    Address
                                </h5>

                                <p>
                                    {{ $patient->address }}
                                </p>
                            </div>
                        </div>
                        <!--/.col -->
                        <div class="col-md-6">
                            <div class="callout callout-info">
                                <h5>
                                    Added By (Doctor/Optometrist)
                                </h5>

                                <p>
                                    {{ $patient->user->first_name }} {{ $patient->user->last_name }}
                                </p>
                            </div>
                        </div>
                        <!--/.col -->
                    </div>
                    <!--/.row -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="callout callout-info">
                                <h5>
                                    Date Added
                                </h5>

                                <p>
                                    {{ date('d, F, Y', strtotime($patient->date_in)) }}
                                </p>
                            </div>
                        </div>
                        <!--/.col -->

                        <div class="col-md-6">
                            <div class="callout callout-info">
                                <h5>
                                    Card Number
                                </h5>

                                <p>
                                    {{ $patient->card_number }}
                                </p>
                            </div>
                        </div>
                        <!--/.col -->
                    </div>
                    <!--/.row -->

                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {});
    </script>
@endpush

@push('patients_script')
    <script>
        $(document).ready(function() {
            $(document).on('click', '.deactivatePatientBtn', function(e) {
                e.preventDefault();
                let patient_id = $(this).data('id');
                let path = '{{ route('admin.patients.deactivate', ':id') }}';
                path = path.replace(':id', patient_id);
                let token = '{{ csrf_token() }}';
                Swal.fire({
                    title: "Are you sure?",
                    text: "You are going to deactivate current patient",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                }).then((result) => {
                    /* Read more about isConfirmed, isDenied below */
                    if (result.isConfirmed) {
                        $.ajax({
                            url: path,
                            type: "POST",
                            data: {
                                patient_id: patient_id,
                                _token: token,
                            },
                            dataType: "json",
                            success: function(data) {
                                if (data['status']) {
                                    Swal.fire(data['message'], '', 'success')
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
            });

            $(document).on('click', '.activatePatientBtn', function(e) {
                e.preventDefault();
                let patient_id = $(this).data('id');
                let path = '{{ route('admin.patients.activate', ':id') }}';
                path = path.replace(':id', patient_id);
                let token = '{{ csrf_token() }}';
                Swal.fire({
                    title: "Are you sure?",
                    text: "You are going to activate current patient",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                }).then((result) => {
                    /* Read more about isConfirmed, isDenied below */
                    if (result.isConfirmed) {
                        $.ajax({
                            url: path,
                            type: "POST",
                            data: {
                                patient_id: patient_id,
                                _token: token,
                            },
                            dataType: "json",
                            success: function(data) {
                                if (data['status']) {
                                    Swal.fire(data['message'], '', 'success')
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
            });
        });
    </script>
@endpush
