@extends('users.layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Create Appointment</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ route('users.dashboard.index') }}">Home</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('users.appointments.index') }}">Appointments</a>
                        </li>
                        <li class="breadcrumb-item active">Create Appointment</li>
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
                        <form id="patientPaymentDetailsForm" role="form">
                            @csrf
                            <div class="card-body">
                                <div class="form-group">
                                    <input type="hidden" name="clinic_id" id="patientPaymentDetailsClinicId"
                                        value="{{ $clinic->id }}" class="form-control" />
                                </div>

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="patientPaymentDetailsPatients">Patients</label>
                                            <select id="patientPaymentDetailsPatients" name="patient_id"
                                                class="form-control select2 select2-danger"
                                                data-dropdown-css-class="select2-danger" style="width: 100%;">
                                                <option selected="selected" disabled="disabled">
                                                    Choose Patient
                                                </option>
                                                @forelse($patients as $patient)
                                                    <option value="{{ $patient->id }}">
                                                        {{ $patient->first_name }} {{ $patient->last_name }} -
                                                        {{ $patient->id_number }}
                                                    </option>
                                                @empty
                                                    <option disabled="disabled">
                                                        No Patients Found
                                                    </option>
                                                @endforelse
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
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
                                                    <option selected="selected" disabled="disabled">Choose Insurance Company
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
            $('#patientPaymentDetailsPatient').select2({
                theme: 'bootstrap4'
            });
            $('#patientPaymentDetailsClientType').select2({
                theme: 'bootstrap4'
            });
            $('#patientPaymentDetailsInsurance').select2({
                theme: 'bootstrap4'
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
                            let appointmentsPath =
                                '{{ route('users.appointments.view', ':id') }}';
                            appointmentsPath = appointmentsPath.replace(':id', data[
                                'appointment_id']);
                            setTimeout(function() {
                                window.location.href = appointmentsPath;
                            }, 2000);
                        } else {
                            console.log(data);
                        }
                    }
                });
            });
        });
    </script>
@endpush
