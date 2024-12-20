@extends('users.layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Create Patient</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ route('users.dashboard.index') }}">Home</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('users.patients.index') }}">Patients</a>
                        </li>
                        <li class="breadcrumb-item active">Create Patient</li>
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
                    <div id="newPatientCard" class="card card-primary card-outline">
                        <!-- form start -->
                        <form id="newPatientForm" role="form">
                            @csrf
                            <input type="hidden" value="{{ $clinic->id }}" name="clinic_id" id="newPatientId"
                                class="form-control" />
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="newPatientFirstName">First Name</label>
                                            <input type="text" class="form-control" name="first_name"
                                                id="newPatientFirstName" placeholder="Enter First Name">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="newPatientLastName">Last Name</label>
                                            <input type="text" class="form-control" name="last_name"
                                                id="newPatientLastName" placeholder="Enter Last Name">
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="newPatientIDNumber">ID Number</label>
                                            <input type="text" class="form-control" name="id_number"
                                                id="newPatientIDNumber" placeholder="Enter ID Number">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="newPatientPhone">Telephone</label>
                                            <input type="text" class="form-control" name="phone" id="newPatientPhone"
                                                placeholder="Enter Telephone Number">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="newPatientEmail">Email Address</label>
                                            <input type="email" class="form-control" name="email" id="newPatientEmail"
                                                placeholder="Enter Email Address">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="newPatientDOB">Date of Birth</label>
                                            <input type="text" class="form-control" name="dob" id="newPatientDOB"
                                                placeholder="YYY-MM-DD">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="newPatientGender">Gender</label>
                                            <select id="newPatientGender" name="gender"
                                                class="form-control select2 select2-danger"
                                                data-dropdown-css-class="select2-danger" style="width: 100%;">
                                                <option disabled="disabled" selected="selected">Choose Gender</option>
                                                <option value="Male">Male</option>
                                                <option value="Female">Female</option>
                                            </select>
                                        </div>
                                        <!-- /.form-group -->
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="newPatientAddress">Residential Address</label>
                                            <input type="text" name="address" id="newPatientAddress" placeholder="Enter Residential Address" class="form-control">
                                        </div>
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="newPatientNextOfKin">Next of Kin</label>
                                            <input type="text" class="form-control" name="next_of_kin"
                                                id="newPatientNextOfKin" placeholder="Enter Next of Kin">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="newPatientNextOfKinContacts">Next of Kin Contacts</label>
                                            <input type="text" class="form-control" name="next_of_kin_contact"
                                                id="newPatientNextOfKinContacts" placeholder="Enter Next of Kin Contacts">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="newPatientCardNumber">Card Number</label>
                                            <input type="text" class="form-control" name="card_number"
                                                id="newPatientCardNumber" placeholder="Enter card number">
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button type="submit" id="newPatientSubmitBtn"
                                    class="btn btn-primary btn-block">Next</button>
                            </div>
                        </form>
                    </div>
                    <!-- /.card -->

                    <!-- general form elements -->
                    <div id="patientPaymentDetailsCard" class="card card-primary card-outline">
                        <!-- form start -->
                        <form id="patientPaymentDetailsForm" role="form">
                            @csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <input type="hidden" name="clinic_id" id="patientPaymentDetailsClinicId"
                                        value="{{ $clinic->id }}" class="form-control" />
                                </div>

                                <div class="form-group">
                                    <input type="hidden" name="patient_id" id="patientPaymentDetailsPatientId"
                                        class="form-control" />
                                </div>

                                {{-- <div class="form-group">
                                    <input type="hidden" name="appointment_id" id="patientPaymentDetailsAppointmntId"
                                        class="form-control" />
                                </div>

                                <div class="form-group">
                                    <input type="hidden" name="report_id" id="patientPaymentDetailsReportId"
                                        class="form-control" />
                                </div> --}}

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="patientPaymentDetailsClientType">Client Type</label>
                                            <select id="patientPaymentDetailsClientType" name="client_type_id"
                                                class="form-control select2 select2-danger"
                                                data-dropdown-css-class="select2-danger" style="width: 100%;">
                                                <option selected="selected" disabled="disabled">Choose Client Type
                                                </option>
                                                @forelse($client_types as $type)
                                                    <option value="{{ $type->id }}">
                                                        {{ $type->type }}
                                                    </option>
                                                @empty
                                                    <option disabled="disabled">
                                                        No Client Type Found
                                                    </option>
                                                @endforelse
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <span id="insuranceSpan">

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="patientPaymentDetailsInsurance">Insurance Company</label>
                                                <select id="patientPaymentDetailsInsurance" name="insurance_id"
                                                    class="form-control select2 select2-danger"
                                                    data-dropdown-css-class="select2-danger" style="width: 100%;">
                                                    <option selected="selected" disabled="disabled">Choose Insurance
                                                        Company
                                                    </option>
                                                    @forelse($insurances as $insurance)
                                                        <option value="{{ $insurance->id }}">
                                                            {{ $insurance->title }}
                                                        </option>
                                                    @empty
                                                        <option disabled="disabled">
                                                            No Insurance company Found
                                                        </option>
                                                    @endforelse
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="patientPaymentDetailsSchemeName">Scheme Name</label>
                                                <input type="text" class="form-control" name="scheme"
                                                    id="patientPaymentDetailsSchemeName" placeholder="Enter Scheme Name">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="patientPaymentDetailsPricinpalMemberName">
                                                    Principal Member Name
                                                </label>
                                                <input type="text" class="form-control" name="principal"
                                                    id="patientPaymentDetailsPricinpalMemberName"
                                                    placeholder="Enter Principal Member Name">
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="patientPaymentDetailsPricinpalMemberPhone">
                                                    Principal Member Phone
                                                </label>
                                                <input type="text" class="form-control" name="phone"
                                                    id="patientPaymentDetailsPricinpalMemberPhone"
                                                    placeholder="Enter Principal Member Phone Number">
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="patientPaymentDetailsPricinpalMemberWorkplace">
                                                    Principal Member Workplace
                                                </label>
                                                <input type="text" class="form-control" name="workplace"
                                                    id="patientPaymentDetailsPricinpalMemberWorkplace"
                                                    placeholder="Enter Principal Member Workplace">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="patientPaymentDetailsInsuranceCard">
                                                    Insurance Card Number
                                                </label>
                                                <input type="text" class="form-control" name="card_number"
                                                    id="patientPaymentDetailsInsuranceCard"
                                                    placeholder="Enter Insurance Card Number">
                                            </div>
                                        </div>
                                    </div>

                                </span>

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group townOrWorkplace">
                                            <label for="patientPaymentDetailsTownOrWorkPlace">
                                                Town/Workplace
                                            </label>
                                            <input type="text" class="form-control" name="principal_workplace"
                                                id="patientPaymentDetailsTownOrWorkPlace"
                                                placeholder="Enter Town/ Workplace">
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer">
                                <button type="submit" id="patientPaymentDetailsSubmitBtn"
                                    class="btn btn-primary btn-block">Create</button>
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

            var date = new Date();
            var today = new Date(date.getFullYear(), date.getMonth(), date.getDate());
            $('#newPatientDOB').datepicker({
                format: 'yyyy-mm-dd',
                autoclose: true,
                endDate: date,
            })

            $('#newPatientCard').fadeIn();
            $('#patientPaymentDetailsCard').fadeOut();
            $('#newPatientForm').submit(function(e) {
                e.preventDefault();
                var form = $(this);
                var formData = new FormData(form[0]);
                var path = '{{ route('users.patients.create') }}';
                $.ajax({
                    url: path,
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    beforeSend: function() {
                        $('#newPatientSubmitBtn').html('<i class="fa fa-spinner fa-spin"></i>');
                        $('#newPatientSubmitBtn').attr('disabled', true);
                    },
                    complete: function() {
                        $('#newPatientSubmitBtn').html('Next');
                        $('#newPatientSubmitBtn').attr('disabled', false);
                    },
                    success: function(data) {
                        if (data['status']) {
                            $('#patientPaymentDetailsPatientId').val(data['patient_id']);
                            // $('#patientPaymentDetailsAppointmntId').val(data['appointment_id']);
                            // $('#patientPaymentDetailsReportId').val(data['report_id']);
                            $('#newPatientForm')[0].reset();
                            setTimeout(function() {
                                $('#newPatientCard').fadeOut();
                                $('#patientPaymentDetailsCard').fadeIn();
                            }, 1000);
                        }
                    },
                    error: function(data) {
                        if (data.status == 422) {
                            let errors = data.responseJSON.errors;
                            for (var key in errors) {
                                toastr.error(errors[key][0]);
                            }
                        }
                    }
                });
            });


            $('#insuranceSpan').fadeOut();

            $(document).on('change', '#patientPaymentDetailsClientType', function(e) {
                e.preventDefault();
                var type_id = $(this).val();
                var path = '{{ route('users.client.type.show') }}';
                var token = '{{ csrf_token() }}';
                $.ajax({
                    url: path,
                    type: "POST",
                    data: {
                        type_id: type_id,
                        _token: token
                    },
                    dataType: "json",
                    success: function(data) {
                        if (data['status']) {
                            if (data['data']['type'] == "Insurance") {
                                $('#insuranceSpan').fadeIn();
                            }
                            if (data['data']['type'] == "Cash and Insurance") {
                                $('#insuranceSpan').fadeIn();
                            }
                            if (data['data']['type'] == "Cash") {
                                $('#insuranceSpan').fadeOut();
                            }
                        }
                    }
                });
            });

            $('#patientPaymentDetailsForm').submit(function(e) {
                e.preventDefault();
                var form = $(this);
                var formData = new FormData(form[0]);
                var path = '{{ route('users.appointments.store') }}';
                $.ajax({
                    url: path,
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    beforeSend: function() {
                        $('#patientPaymentDetailsSubmitBtn').html(
                            '<i class="fa fa-spinner fa-spin"></i>');
                        $('#patientPaymentDetailsSubmitBtn').attr('disabled', true);
                    },
                    complete: function() {
                        $('#patientPaymentDetailsSubmitBtn').html('Create');
                        $('#patientPaymentDetailsSubmitBtn').attr('disabled', false);
                    },
                    success: function(data) {
                        if (data['status']) {
                            toastr.success(data['message']);
                            $('#patientPaymentDetailsForm')[0].reset();
                            var profile = '{{ url('users/patients/') }}/' + data[
                                'patient_id'] + '/view';
                            setTimeout(function() {
                                $('#newPatientCard').fadeOut();
                                $('#patientPaymentDetailsCard').fadeOut();
                                window.location.href = profile;
                            }, 2000);
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
