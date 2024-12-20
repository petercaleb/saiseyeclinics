@extends('users.layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1> {{ $clinic->clinic }} </h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ route('users.dashboard.index') }}">Home</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('users.patients.index') }}">Patients</a>
                        </li>
                        <li class="breadcrumb-item active">{{ $patient->first_name }} {{ $patient->last_name }} Profile</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <!-- left column -->
                <div class="col-md-12">

                    <!-- general form elements -->
                    <div class="card card-primary card-outline">
                        <!-- form start -->
                        <form id="updatePatientForm" role="form">
                            @csrf
                            <input type="hidden" value="{{ $clinic->id }}" name="clinic_id" id="updatePatientId"
                                class="form-control" />
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="updatePatientFirstName">First Name</label>
                                            <input type="text" class="form-control" name="first_name"
                                                id="updatePatientFirstName" value="{{ $patient->first_name }}"
                                                placeholder="Enter First Name">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="updatePatientLastName">Last Name</label>
                                            <input type="text" class="form-control" name="last_name"
                                                id="updatePatientLastName" value="{{ $patient->last_name }}"
                                                placeholder="Enter Last Name">
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="updatePatientIDNumber">ID Number</label>
                                            <input type="text" class="form-control" name="id_number"
                                                id="updatePatientIDNumber" value = "{{ $patient->id_number }}"
                                                placeholder="Enter ID Number">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="updatePatientPhone">Telephone</label>
                                            <input type="text" value="{{ $patient->phone }}" class="form-control"
                                                name="phone" id="updatePatientPhone" placeholder="Enter Telephone Number">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="updatePatientEmail">Email Address</label>
                                            <input type="email" value="{{ $patient->email }}" class="form-control"
                                                name="email" id="updatePatientEmail" placeholder="Enter Email Address">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="updatePatientDOB">Date of Birth</label>
                                            <input type="text" value="{{ $patient->dob }}"
                                                class="form-control datepicker" name="dob" id="updatePatientDOB"
                                                placeholder="Enter Date of Birth">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="updatePatientGender">Gender</label>
                                            <select id="updatePatientGender" name="gender"
                                                class="form-control select2 select2-danger"
                                                data-dropdown-css-class="select2-danger" style="width: 100%;">
                                                <option disabled="disabled" selected="selected">Choose Gender</option>
                                                <option @if ($patient->gender == 'Male') selected="selected" @endif
                                                    value="Male">Male</option>
                                                <option @if ($patient->gender == 'Female') selected="selected" @endif
                                                    value="Female">Female</option>
                                            </select>
                                        </div>
                                        <!-- /.form-group -->
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="updatePatientAddress">Residential Address</label>
                                            <input type="text" name="address" id="updatePatientAddress" class="form-control" placeholder="Enter Residential Address" value="{{ $patient->address }}">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="updatePatientNextOfKin">Next of Kin</label>
                                            <input type="text" class="form-control" name="next_of_kin"
                                                value="{{ $patient->next_of_kin }}" id="updatePatientNextOfKin"
                                                placeholder="Enter Next of Kin">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="updatePatientNextOfKinContacts">Next of Kin Contacts</label>
                                            <input type="text" class="form-control" name="next_of_kin_contact"
                                                value="{{ $patient->next_of_kin_contact }}"
                                                id="updatePatientNextOfKinContacts"
                                                placeholder="Enter Next of Kin Contacts">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="updatePatientCardNumber">Card Number</label>
                                            <input type="text" class="form-control" name="card_number"
                                                id="updatePatientCardNumber" value="{{ $patient->card_number }}"
                                                placeholder="Enter card number">
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button type="submit" id="updatePatientSubmitBtn"
                                    class="btn btn-primary btn-block">Update</button>
                            </div>
                        </form>
                    </div>
                    <!-- /.card -->
                </div>
                <!--/.col (left) -->

            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {

            $('#updatePatientForm').submit(function(e) {
                e.preventDefault();
                let form = $(this);
                let formData = new FormData(form[0]);
                let path = '{{ route('users.patients.edit', $patient->id) }}';
                $.ajax({
                    url: path,
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    beforeSend: function() {
                        $('#updatePatientSubmitBtn').html(
                            '<i class="fa fa-spinner fa-spin"></i>');
                        $('#updatePatientSubmitBtn').attr('disabled', true);
                    },
                    complete: function() {
                        $('#updatePatientSubmitBtn').html('Next');
                        $('#updatePatientSubmitBtn').attr('disabled', false);
                    },
                    success: function(data) {
                        if (data['status']) {
                            toastr.success(data['message']);
                            $('#updatePatientForm')[0].reset();
                            setTimeout(function() {
                                let viewURL =
                                    '{{ route('users.patients.view', $patient->id) }}';
                                window.location.href = viewURL;
                            }, 1000);
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
@endpush
