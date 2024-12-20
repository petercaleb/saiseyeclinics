@extends('users.layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{ $clinic->clinic }}</h1>
                    <small>
                        {{ $schedule->day }} || {{ $schedule->date }} || {{ $schedule->time }}
                    </small>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ route('users.dashboard.index') }}">Home</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('users.doctor.schedules.index') }}">
                                Doctor Schedules
                            </a>
                        </li>
                        <li class="breadcrumb-item active">{{ $page_title }}</li>
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
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                Patient Details
                            </h3>
                        </div>
                        <!--.card-header -->
                        <div class="card-body p-0">
                            <ul class="nav nav-pills flex-column">
                                <li class="nav-item active">
                                    <a href="#" class="nav-link">
                                        <i class="fa fa-user"></i> {{ $patient->first_name }} {{ $patient->last_name }}
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#" class="nav-link">
                                        <i class="fa fa-phone"></i> {{ $patient->phone }}
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#" class="nav-link">
                                        <i class="fa fa-envelope"></i> {{ $patient->email }}
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#" class="nav-link">
                                        <i class="fa fa-calendar"></i> {{ $patient->dob }}
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#" class="nav-link">
                                        <i class="fa fa-male"></i> {{ $patient->gender }}
                                    </a>
                                </li>

                                <li class="nav-item">
                                    <a href="#" class="nav-link">
                                        <i class="fa fa-map-signs"></i> {{ $patient->address }}
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <!--.card-body .p-0 -->
                    </div>

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Doctor/ Optometrist</h3>
                        </div>

                        <div class="card-body p-0">
                            <ul class="nav nav-pills flex-column">
                                <li class="nav-item">
                                    <a href="#" class="nav-link">
                                        <i class="fa fa-user text-danger"></i>
                                        {{ $doctor->first_name }} {{ $doctor->last_name }}
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#" class="nav-link">
                                        <i class="fa fa-phone text-warning"></i> {{ $doctor->phone }}
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="#" class="nav-link">
                                        <i class="fa fa-envelope text-primary"></i>
                                        {{ $doctor->email }}
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <!-- /.card-body -->

                    </div>
                    <!--.card -->
                </div>
                <!--/.col -->


                <div class="col-md-6">
                    <div class="card card-outline card-primary">
                        <div class="card-header p-2">
                            <ul id="myTab" class="nav nav-pills">
                                <li class="nav-item">
                                    <a class="nav-link active" href="#diagnosisTab" data-toggle="tab">
                                        Diagnosis
                                    </a>
                                </li>
                                @if ($diagnosis)
                                    <li class="nav-item">
                                        <a class="nav-link" href="#treatmentTab" data-toggle="tab">
                                            Treatment
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#medicineTab" data-toggle="tab">
                                            Medicine
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#procedureTab" data-toggle="tab">
                                            Procedure
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="tab-content">
                                <div class="active tab-pane" id="diagnosisTab">
                                    <!-- The timeline -->
                                    <div class="timeline timeline-inverse">
                                        <!-- timeline time label -->
                                        <div class="time-label">
                                            <span class="bg-primary">
                                                Patient Diagnosis
                                            </span>
                                        </div>
                                        <!--.time-label -->
                                        <!-- /.timeline-label -->
                                        @if ($diagnosis)
                                            <!-- timeline item -->
                                            <div>
                                                <i class="fa fa-warning bg-primary"></i>

                                                <div class="timeline-item">
                                                    <h3 class="timeline-header">
                                                        <a href="#">Patient's</a> Stated Signs
                                                    </h3>

                                                    <div class="timeline-body">
                                                        {!! $diagnosis->signs !!}
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- END timeline item -->

                                            <!-- timeline item -->
                                            <div>
                                                <i class="fa fa-sellsy bg-warning"></i>

                                                <div class="timeline-item">

                                                    <h3 class="timeline-header">
                                                        <a href="#">Patient's</a> Symptoms
                                                    </h3>

                                                    <div class="timeline-body">
                                                        {!! $diagnosis->symptoms !!}
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- END timeline item -->

                                            <!-- timeline item -->
                                            <div>
                                                <i class="fa fa-comments bg-purple"></i>

                                                <div class="timeline-item">
                                                    <h3 class="timeline-header">
                                                        <a href="#">Doctor's</a> Diagnosis
                                                    </h3>

                                                    <div class="timeline-body">
                                                        {!! $diagnosis->diagnosis !!}
                                                    </div>
                                                    @if (Auth::user()->id == $schedule->user_id)
                                                        <div class="timeline-footer">
                                                            @if ($treatment->status != 'ordered')
                                                                <a href="#" data-id="{{ $diagnosis->id }}"
                                                                    class="btn btn-secondary btn-block btn-sm editDiagnosisBtn">
                                                                    <i class="fa fa-edit"></i> Edit Diagnosis
                                                                </a>
                                                            @endif
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                            <!-- END timeline item -->
                                        @else
                                            <!-- timeline item -->
                                            <div>
                                                <i class="fa  fa-plus-square bg-danger"></i>

                                                <div class="timeline-item">
                                                    <h3 class="timeline-header">
                                                        <a href="#">Patient's</a> Diagnosis
                                                    </h3>

                                                    <div class="timeline-body">
                                                        No diagnosis performed on the patient.
                                                    </div>
                                                    @if (Auth::user()->id == $schedule->user_id)
                                                        <div class="timeline-footer">
                                                            <a href="#" id="{{ $schedule->id }}"
                                                                class="btn btn-primary btn-block btn-sm addDiagnosisBtn">
                                                                <i class="fa fa-plus"></i> Perform Diagnosis
                                                            </a>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                            <!-- END timeline item -->
                                        @endif

                                        <div>
                                            <i class="fa fa-clock-o bg-gray"></i>
                                        </div>

                                    </div>
                                    <!--.timeline .timeline-inverse -->
                                </div>
                                <!-- /.tab-pane -->

                                <div class="tab-pane" id="treatmentTab">
                                    @include('users.schedules.partials.lens_power')
                                    @include('users.schedules.partials.lens_prescription')
                                    @include('users.schedules.partials.frame_code')
                                </div>
                                <!-- /.tab-pane -->

                                <div class="tab-pane" id="medicineTab">
                                    <div class="table-responsive">
                                        @if (Auth::user()->id == $schedule->user_id)
                                            <button id="addMedicineBtn" class="btn btn-block btn-success">
                                                <i class="fa fa-plus-circle"></i> Add Medicine
                                            </button>
                                            <hr>
                                        @endif
                                        <table id="medicineData" class="table table-striped table-bordered table-hover">
                                            <thead>
                                                <tr>
                                                    <th>Medicine</th>
                                                    <th>Dose</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                    <!-- /.table-responsive -->
                                </div>
                                <!-- /.tab-pane -->

                                <div class="tab-pane" id="procedureTab">
                                    @if ($procedure)
                                        <div class="callout callout-info">
                                            {!! $procedure->procedure !!}
                                        </div>
                                    @else
                                        @if (Auth::user()->id == $schedule->user_id)
                                            <form id="procedureForm">
                                                @csrf
                                                @if ($diagnosis)
                                                    <div class="form-group">
                                                        <input type="hidden" name="diagnosis_id"
                                                            value="{{ $diagnosis->id }}" class="form-control" />
                                                    </div>
                                                @endif
                                                <div class="form-group">
                                                    <label for="procudereText">Procedure</label>
                                                    <textarea name="procedure" id="procudereText" class="form-control textarea"></textarea>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <button type="submit" id="procudereSubmitBtn"
                                                            class="btn btn-primary btn-block">Save</button>
                                                    </div>
                                                </div>

                                            </form>
                                        @else
                                            <span>No procedure added yet</span>
                                        @endif
                                    @endif
                                    <hr>
                                    @if ($treatment)
                                        @if ($payment_bill)
                                            <a href="#" data-id="{{ $payment_bill->id }}"
                                                class="btn btn-block btn-primary viewPaymentBillBtn">
                                                View Payment Bill
                                            </a>
                                        @else
                                            @if (Auth::user()->id == $schedule->user_id)
                                                @if ($diagnosis)
                                                    <a href="#" id="{{ $diagnosis->schedule_id }}"
                                                        class="btn btn-block btn-success openBillBtn"
                                                        rel="noopener noreferrer">
                                                        @if ($treatment->payments == 'consultation')
                                                            Pay Consultation Fee
                                                        @else
                                                            Open Bill
                                                        @endif
                                                    </a>
                                                @endif
                                            @endif
                                        @endif
                                    @endif
                                </div>
                                <!-- /.tab-pane -->
                            </div>
                            <!--/.tab-content -->
                        </div>
                        <!--/.card-body -->
                    </div>
                    <!--/.card -->
                </div>
                <!--/.col -->

                <div class="col-md-3">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                Payment Details
                            </h3>
                        </div>

                        <div class="card-body">
                            <strong><i class="fa fa-hourglass mr-1"></i> Client Type</strong>

                            <p class="text-muted">
                                {{ $payment_details->client_type->type }}
                            </p>

                            <hr>
                            @if ($payment_details->insurance)
                                <strong><i class="fa fa-building mr-1"></i> Insurance Company</strong>

                                <p class="text-muted">
                                    {{ $payment_details->insurance->title }}
                                </p>

                                <hr>

                                <strong><i class="fa fa-building mr-1"></i> Scheme</strong>

                                <p class="text-muted">
                                    {{ $payment_details->scheme }}
                                </p>

                                <hr>

                                <strong><i class="fa fa-user mr-1"></i> Principal Member</strong>

                                <p class="text-muted">
                                    {{ $payment_details->principal }}
                                </p>

                                <hr>
                                <strong><i class="fa fa-phone mr-1"></i> Principal Telephone Number</strong>

                                <p class="text-muted">
                                    {{ $payment_details->phone }}
                                </p>

                                <hr>
                                <strong><i class="fa fa-map-pin mr-1"></i> Principal Workplace</strong>

                                <p class="text-muted">
                                    {{ $payment_details->workplace }}
                                </p>

                                <hr>
                                <strong><i class="fa fa-credit-card mr-1"></i> Insurance Card Number</strong>

                                <p class="text-muted">
                                    {{ $payment_details->card_number }}
                                </p>

                                <hr>
                            @endif

                            <strong><i class="fa fa-map-pin mr-1"></i> Patient Workplace</strong>

                            <p class="text-muted">
                                {{ $payment_details->principal_workplace }}
                            </p>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col-md-3 -->

            </div>
            <!--/.row -->
        </div>
    </section>
    <!-- /.content -->
@endsection

@push('modals')
    @include('users.includes.modals.add_diagnosis')
    @if ($diagnosis)
        @include('users.includes.modals.edit_diagnosis')
    @endif
    @if ($lens_power)
        @include('users.includes.modals.edit_lens_power')
    @endif
    @if ($lens_prescription)
        @include('users.includes.modals.edit_lens_prescription')
    @endif
    @if ($frame_prescription)
        @include('users.includes.modals.edit_frame_prescription')
    @endif


    @include('users.includes.modals.add_medicine')
    @include('users.includes.modals.open_bill')
@endpush

@push('scripts')

    <script>
        $(document).ready(function() {

            $('.addDiagnosisBtn').click(function(e) {
                e.preventDefault();
                var path = '{{ route('users.doctor.schedules.show') }}';
                var schedule_id = $(this).attr('id');
                var token = '{{ csrf_token() }}';
                $.ajax({
                    url: path,
                    type: 'POST',
                    data: {
                        schedule_id: schedule_id,
                        _token: token
                    },
                    dataType: 'json',
                    success: function(data) {
                        if (data['status']) {
                            $('#addDiagnosisClinicId').val(data.data.clinic_id);
                            $('#addDiagnosisPatientId').val(data.data.patient_id);
                            $('#addDiagnosisAppointmentId').val(data.data.appointment_id);
                            $('#addDiagnosisUserId').val(data.data.user_id);
                            $('#addDiagnosisScheduleId').val(data.data.id);
                            $('#addDiagnosisModal').modal('show');
                        } else {
                            console.log(data);
                        }
                    }
                });
            });

            $('#addDiagnosisForm').submit(function(e) {
                e.preventDefault();
                var form = $(this);
                var formData = new FormData(form[0]);
                var path = '{{ route('users.diagnosis.store') }}';
                $.ajax({
                    url: path,
                    type: 'POST',
                    data: formData,
                    dataType: 'json',
                    contentType: false,
                    processData: false,
                    beforeSend: function() {
                        $('#addDiagnosisSubmitBtn').html(
                            '<i class="fa fa-spinner fa-spin"></i>');
                        $('#addDiagnosisSubmitBtn').attr('disabled', true);
                    },
                    complete: function() {
                        $('#addDiagnosisSubmitBtn').html('Save');
                        $('#addDiagnosisSubmitBtn').attr('disabled', false);
                    },
                    success: function(data) {
                        if (data['status']) {
                            $('#addDiagnosisModal').modal('hide');
                            toastr.success(data['message']);
                            setTimeout(function() {
                                window.location.reload();
                            }, 1000);
                        } else {
                            console.log(data);
                        }
                    }
                });
            });

            $('.editDiagnosisBtn').on('click', function(e) {
                e.preventDefault();
                var diagnosis_id = $(this).data('id');
                var token = '{{ csrf_token() }}';
                var path = '{{ route('users.diagnosis.show') }}';
                $.ajax({
                    url: path,
                    type: "POST",
                    data: {
                        diagnosis_id: diagnosis_id,
                        _token: token
                    },
                    dataType: "json",
                    success: function(data) {
                        if (data['status']) {
                            $('#editDiagnosisModal').modal('show');
                            $('#editDiagnosisClinicId').val(data['data']['clinic_id']);
                            $('#editDiagnosisId').val(data['data']['id']);
                            $('#editDiagnosisPatientId').val(data['data']['patient_id']);
                            $('#editDiagnosisAppointmentId').val(data['data'][
                                'appointment_id'
                            ]);
                            $('#editDiagnosisUserId').val(data['data']['user_id']);
                            $('#editDiagnosisScheduleId').val(data['data']['schedule_id']);
                            $('#editDiagnosisSigns').val(data['data']['signs']);
                            $('#editDiagnosisSymptoms').val(data['data']['symptoms']);
                            $('#editDiagnosisDiagnosis').val(data['data']['diagnosis']);
                        }
                    }
                });
            });

            $('#editDiagnosisForm').submit(function(e) {
                e.preventDefault();
                var form = $(this);
                var formData = new FormData(form[0]);
                var path = '{{ route('users.diagnosis.update') }}';
                $.ajax({
                    url: path,
                    type: 'POST',
                    data: formData,
                    dataType: 'json',
                    contentType: false,
                    processData: false,
                    beforeSend: function() {
                        $('#editDiagnosisSubmitBtn').html(
                            '<i class="fa fa-spinner fa-spin"></i>');
                        $('#editDiagnosisSubmitBtn').attr('disabled', true);
                    },
                    complete: function() {
                        $('#editDiagnosisSubmitBtn').html('Save');
                        $('#editDiagnosisSubmitBtn').attr('disabled', false);
                    },
                    success: function(data) {
                        if (data['status']) {
                            $('#editDiagnosisModal').modal('hide');
                            toastr.success(data['message']);
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

    @if ($diagnosis)
        <script>
            $(document).ready(function() {
                // Treatment
                $('.lensPowerDiv').fadeIn();
                $('.lensPrescriptionDiv').fadeOut();
                $('.frameCodesDiv').fadeOut();

                // Lens Power
                $('#lensPowerForm').submit(function(e) {
                    e.preventDefault();
                    var form = $(this);
                    var formData = new FormData(form[0]);
                    var path = '{{ route('users.lens.power.store') }}';
                    $.ajax({
                        url: path,
                        type: 'POST',
                        data: formData,
                        contentType: false,
                        processData: false,
                        beforeSend: function() {
                            $('#lensPowerSubmitBtn').html(
                                '<i class="fa fa-spinner fa-spin"></i>');
                            $('#lensPowerSubmitBtn').attr('disabled', true);
                        },
                        complete: function() {
                            $('#lensPowerSubmitBtn').html('Add Power');
                            $('#lensPowerSubmitBtn').attr('disabled', false);
                        },
                        success: function(data) {
                            if (data['status']) {
                                toastr.success(data['message']);
                                $('#lensPowerForm')[0].reset();
                                $('.lensPowerDiv').fadeOut();
                                $('#lensPrescriptionPowerId').val(data['power_id']);
                                $('.lensPrescriptionDiv').fadeIn();
                                $('.frameCodesDiv').fadeOut();
                            } else {
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

                // Edit Lens Power
                $(document).on('click', '.editLensPowerBtn', function(e) {
                    e.preventDefault();
                    var power_id = $(this).data('id');
                    var path = '{{ route('users.lens.power.show') }}';
                    var token = '{{ csrf_token() }}';
                    $.ajax({
                        url: path,
                        type: "POST",
                        data: {
                            power_id: power_id,
                            _token: token
                        },
                        dataType: "JSON",
                        success: function(data) {
                            if (data['status']) {
                                $('#editLensPowerModal').modal('show');
                                $('#editLensPowerId').val(data['data']['id']);
                                $('#editLensPowerRightSphere').val(data['data']['right_sphere']);
                                $('#editLensPowerRightCylinder').val(data['data'][
                                    'right_cylinder'
                                ]);
                                $('#editLensPowerRightAxis').val(data['data']['right_axis']);
                                $('#editLensPowerRightAdditional').val(data['data']['right_add']);
                                $('#editLensPowerLeftSphere').val(data['data']['left_sphere']);
                                $('#editLensPowerLeftCylinder').val(data['data']['left_cylinder']);
                                $('#editLensPowerLeftAxis').val(data['data']['left_axis']);
                                $('#editLensLeftAdditional').val(data['data']['left_add']);
                                $('#editLensPowerAdditionalInfo').val(data['data']['notes'])
                            }
                        }
                    });
                });

                // update lens power
                $('#editLensPowerForm').submit(function(e) {
                    e.preventDefault();
                    var form = $(this);
                    var formData = new FormData(form[0]);
                    var path = '{{ route('users.lens.power.update') }}';
                    $.ajax({
                        url: path,
                        type: "POST",
                        data: formData,
                        contentType: false,
                        processData: false,
                        beforeSend: function() {
                            $('#editLensPowerSubmitBtn').html(
                                '<i class="fa fa-spinner fa-spin"></i>');
                            $('#editLensPowerSubmitBtn').attr('disabled', true);
                        },
                        complete: function() {
                            $('#editLensPowerSubmitBtn').html('Update Power');
                            $('#editLensPowerSubmitBtn').attr('disabled', false);
                        },
                        success: function(data) {
                            if (data['status']) {
                                toastr.success(data['message']);
                                $('#editLensPowerModal').modal('hide');
                                $('#editLensPowerForm')[0].reset();
                                $('#myTab a[href="#treatmentTab"]').tab('show');
                                location.reload();
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
                        },
                    });
                });

                // Lens Prescription
                $(document).on('click', '.newLensPrescriptionBtn', function(e) {
                    e.preventDefault();
                    $('.lensPowerDiv').fadeOut();
                    $('#lensPrescriptionPowerId').val($(this).data('id'));
                    $('.lensPrescriptionDiv').fadeIn();
                    $('.frameCodesDiv').fadeOut();
                });

                // new prescription
                $('#lensPrescriptionForm').submit(function(e) {
                    e.preventDefault();
                    let form = $(this);
                    let formData = new FormData(form[0]);
                    let path = '{{ route('users.lens.prescription.store') }}';
                    $.ajax({
                        url: path,
                        type: 'POST',
                        data: formData,
                        contentType: false,
                        processData: false,
                        beforeSend: function() {
                            $('#lensPrescriptionSubmitBtn').html(
                                '<i class="fa fa-spinner fa-spin"></i>');
                            $('#lensPrescriptionSubmitBtn').attr('disabled', true);
                        },
                        complete: function() {
                            $('#lensPrescriptionSubmitBtn').html('Add Prescription');
                            $('#lensPrescriptionSubmitBtn').attr('disabled', false);
                        },
                        success: function(data) {
                            if (data['status']) {
                                toastr.success(data['message']);
                                $('#lensPrescriptionForm')[0].reset();
                                $('.lensPowerDiv').fadeOut();
                                $('.lensPrescriptionDiv').fadeOut();
                                $('#frameCodePowerId').val(data['power_id']);
                                $('#frameCodePrescriptionId').val(data['prescription_id']);
                                $('.frameCodesDiv').fadeIn();
                            } else {
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

                // Edit lens prescription
                $(document).on('click', '.editPrescriptionBtn', function(e) {
                    e.preventDefault();
                    var prescription_id = $(this).data('id');
                    var token = '{{ csrf_token() }}';
                    var path = '{{ route('users.lens.prescription.show') }}';
                    $.ajax({
                        url: path,
                        type: "POST",
                        data: {
                            prescription_id: prescription_id,
                            _token: token,
                        },
                        dataType: "json",
                        success: function(data) {
                            if (data['status']) {
                                $('#editPrescriptionModal').modal('show');
                                $('#editPrescriptionId').val(data['data']['id']);
                                $('#editPrescriptionIndex').val(data['data']['index']);
                                $('#editPrescriptionTint').val(data['data']['tint']);
                                $('#editPrescriptionPupil').val(data['data']['diameter']);
                                $('#editPrescriptionFocalHeight').val(data['data']['focal_height']);
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

                // update lens prescription
                $('#editPrescriptionForm').submit(function(e) {
                    e.preventDefault();
                    var form = $(this);
                    var formData = new FormData(form[0]);
                    var path = '{{ route('users.lens.prescription.update') }}';
                    $.ajax({
                        url: path,
                        type: "POST",
                        data: formData,
                        dataType: "json",
                        contentType: false,
                        processData: false,
                        beforeSend: function() {
                            $('#editPrescriptionSubmitBtn').html(
                                '<i class="fa fa-spinner fa-spin"></i>'
                            );
                            $('#editPrescriptionSubmitBtn').attr('disabled', true);
                        },
                        complete: function() {
                            $('#editPrescriptionSubmitBtn').html('Update Prescription');
                            $('#editPrescriptionSubmitBtn').attr('disabled', false);
                        },
                        success: function(data) {
                            if (data['status']) {
                                toastr.success(data['message']);
                                $('#editPrescriptionForm')[0].reset();
                                $('#editPrescriptionModal').modal('hide');
                                location.reload();
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

                // view lens prescription
                $(document).on('click', '.viewLensPrescription', function(e) {
                    e.preventDefault();
                    var prescription_id = $(this).data('id');
                    var token = '{{ csrf_token() }}';
                    var path = '{{ route('users.lens.prescription.show') }}';
                    $.ajax({
                        url: path,
                        type: 'POST',
                        data: {
                            prescription_id: prescription_id,
                            _token: token
                        },
                        dataType: "json",
                        success: function(data) {
                            if (data['status']) {
                                $('.lensPowerDiv').fadeOut();
                                $('.lensPrescriptionDiv').fadeIn();
                                $('.frameCodesDiv').fadeOut();
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
                        },
                    });
                });

                // Frame Codes
                $(document).on('click', '.newFrameCodeBtn', function(e) {
                    e.preventDefault();
                    var prescription_id = $(this).data('id');
                    var token = '{{ csrf_token() }}';
                    var path = '{{ route('users.lens.prescription.show') }}';
                    $.ajax({
                        url: path,
                        type: 'POST',
                        data: {
                            prescription_id: prescription_id,
                            _token: token
                        },
                        dataType: "json",
                        success: function(data) {
                            if (data['status']) {
                                $('.lensPowerDiv').fadeOut();
                                $('.lensPrescriptionDiv').fadeOut();
                                $('#frameCodePowerId').val(data['data']['power_id']);
                                $('#frameCodePrescriptionId').val(data['data']['id']);
                                $('.frameCodesDiv').fadeIn();
                            }
                        },
                    });
                });

                // new frame code
                $('#frameCodeForm').submit(function(e) {
                    e.preventDefault();
                    let form = $(this);
                    let formData = new FormData(form[0]);
                    let path = '{{ route('users.lens.frame.prescription.store') }}';
                    $.ajax({
                        url: path,
                        type: 'POST',
                        data: formData,
                        contentType: false,
                        processData: false,
                        beforeSend: function() {
                            $('#frameCodeSubmitBtn').html(
                                '<i class="fa fa-spinner fa-spin"></i>');
                            $('#frameCodeSubmitBtn').attr('disabled', true);
                        },
                        complete: function() {
                            $('#frameCodeSubmitBtn').html('Add Frame Code');
                            $('#frameCodeSubmitBtn').attr('disabled', false);
                        },
                        success: function(data) {
                            if (data['status']) {
                                toastr.success(data['message']);
                                $('#frameCodeForm')[0].reset();
                                setTimeout(() => {
                                    location.reload();
                                }, 1000);
                            } else {
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
                        },
                    });
                });

                // edit frame code
                $(document).on('click', '.editFramePrescriptionBtn', function(e) {
                    e.preventDefault();
                    var frame_prescription_id = $(this).data('id');
                    var path = '{{ route('users.lens.frame.prescription.show') }}';
                    var token = '{{ csrf_token() }}';
                    $.ajax({
                        url: path,
                        type: "POST",
                        data: {
                            frame_prescription_id: frame_prescription_id,
                            _token: token
                        },
                        dataType: "json",
                        success: function(data) {
                            if (data['status']) {
                                // console.log(data['data']);
                                $('#editFramePrescriptionModal').modal('show');
                                $('#editFramePrescriptionId').val(data['data']['id']);
                                $('#editFramePrescriptionReceiptNumber').val(data['data'][
                                    'receipt_number'
                                ]);
                                $('#editFramePrescriptionRemarks').val(data['data']['remarks']);
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

                $('#editFramePrescriptionForm').submit(function(e) {
                    e.preventDefault();
                    var form = $(this);
                    var formData = new FormData(form[0]);
                    var path = '{{ route('users.lens.frame.prescription.update') }}';
                    $.ajax({
                        url: path,
                        type: 'POST',
                        data: formData,
                        contentType: false,
                        processData: false,
                        beforeSend: function() {
                            $('#editFramePrescriptionSubmitBtn').html(
                                '<i class="fa fa-spinner fa-spin"></i>');
                            $('#editFramePrescriptionSubmitBtn').attr('disabled', true);
                        },
                        complete: function() {
                            $('#editFramePrescriptionSubmitBtn').html('Update Frame Code');
                            $('#editFramePrescriptionSubmitBtn').attr('disabled', false);
                        },
                        success: function(data) {
                            if (data['status']) {
                                toastr.success(data['message']);
                                $('#editFramePrescriptionModal').modal('hide');
                                $('#editFramePrescriptionForm')[0].reset();
                                setTimeout(() => {
                                    location.reload();
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
                        },
                    });
                });

                // view frame code
                $(document).on('click', '.frameCodeBtn', function(e) {
                    e.preventDefault();
                    $('.lensPowerDiv').fadeOut();
                    $('.lensPrescriptionDiv').fadeOut();
                    $('.frameCodesDiv').fadeIn();
                });

                // back to lens power
                $(document).on('click', '.backToLensPowerBtn', function(e) {
                    e.preventDefault();
                    $('.lensPowerDiv').fadeIn();
                    $('.lensPrescriptionDiv').fadeOut();
                    $('.frameCodesDiv').fadeOut();
                });

                // Medical History
                find_medicine();

                function find_medicine() {
                    var path = '{{ route('users.medicine.index', $diagnosis->id) }}';
                    $('#medicineData').DataTable({
                        processing: true,
                        serverSide: true,
                        ajax: path,
                        columns: [{
                                data: 'medicine',
                                name: 'medicine'
                            },
                            {
                                data: 'dose',
                                name: 'dose',
                            },
                            {
                                data: 'action',
                                name: 'action',
                                orderable: false,
                                searchable: false
                            },
                        ],
                        "autoWidth": false,
                        "responsive": true,
                    });
                }
                // medicine form
                $('#addMedicineBtn').click(function(e) {
                    e.preventDefault();
                    $('#addMedicineModal').modal('show');
                });

                $('#addMedicineForm').submit(function(e) {
                    e.preventDefault();
                    var form = $(this);
                    var formData = new FormData(form[0]);
                    var path = '{{ route('users.medicine.store') }}';
                    $.ajax({
                        url: path,
                        type: 'POST',
                        data: formData,
                        contentType: false,
                        processData: false,
                        beforeSend: function() {
                            $('#addMedicineSubmitBtn').html(
                                '<i class="fa fa-spinner fa-spin"></i>');
                            $('#addMedicineSubmitBtn').attr('disabled', true);
                        },
                        complete: function() {
                            $('#addMedicineSubmitBtn').html('Add Medicine');
                            $('#addMedicineSubmitBtn').attr('disabled', false);
                        },
                        success: function(data) {
                            if (data['status']) {
                                toastr.success(data['message']);
                                $('#addMedicineForm')[0].reset();
                                $('#addMedicineModal').modal('hide');
                                $('#medicineData').DataTable().ajax.reload();
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
                        },
                    });
                });

                // delete medicine
                $(document).on('click', '.deleteMedicineBtn', function(e) {
                    e.preventDefault();
                    var path = '{{ route('users.medicine.delete') }}';
                    var medicine_id = $(this).attr('data-id');
                    var token = '{{ csrf_token() }}';
                    Swal.fire({
                        title: "Are you sure?",
                        text: "Once deleted, you will not be able to recommend this mmedicine to this patient!",
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
                                    medicine_id: medicine_id,
                                    _token: token,
                                },
                                dataType: "json",
                                success: function(data) {
                                    if (data['status']) {
                                        Swal.fire(data['message'], '', 'success')
                                        $('#medicineData').DataTable().ajax.reload();
                                    } else {
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
                                    Swal.fire(errorsHtml, '', 'info');
                                },
                            });
                        } else if (result.isDenied) {
                            Swal.fire('Changes are not saved', '', 'info');
                        }
                    });
                });

                // procedure form
                $('#procedureForm').submit(function(e) {
                    e.preventDefault();
                    var form = $(this);
                    var formData = new FormData(form[0]);
                    var path = '{{ route('users.procedure.store') }}';
                    $.ajax({
                        url: path,
                        type: 'POST',
                        data: formData,
                        contentType: false,
                        processData: false,
                        beforeSend: function() {
                            $('#procudereSubmitBtn').html(
                                '<i class="fa fa-spinner fa-spin"></i>');
                            $('#procedureSubmitBtn').attr('disabled', true);
                        },
                        complete: function() {
                            $('#procudereSubmitBtn').html('Add Procedure');
                            $('#procedureSubmitBtn').attr('disabled', false);
                        },
                        success: function(data) {
                            if (data['status']) {
                                toastr.success(data['message']);
                                location.reload();
                            } else {
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
                        },
                    });
                });

                // open Billing
                $(document).on('click', '.openBillBtn', function(e) {
                    e.preventDefault();
                    var schedule_id = $(this).attr('id');
                    var token = '{{ csrf_token() }}';
                    var path = '{{ route('users.doctor.schedules.show') }}';
                    $.ajax({
                        url: path,
                        type: 'POST',
                        data: {
                            schedule_id: schedule_id,
                            _token: token,
                        },
                        dataType: "json",
                        success: function(data) {
                            if (data['status']) {
                                $('#openBillScheduleId').val(data['data']['id']);
                                $('#openBillModal').modal('show');
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
                        },
                    });
                });

                // Open Billing Form
                $('#openBillForm').submit(function(e) {
                    e.preventDefault();
                    var form = $(this);
                    var formData = new FormData(form[0]);
                    var path = '{{ route('users.payments.bills.store') }}';
                    $.ajax({
                        url: path,
                        type: 'POST',
                        data: formData,
                        contentType: false,
                        processData: false,
                        beforeSend: function() {
                            $('#openBillSubmitBtn').html(
                                '<i class="fa fa-spinner fa-spin"></i>');
                            $('#openBillSubmitBtn').attr('disabled', true);
                        },
                        complete: function() {
                            $('#openBillSubmitBtn').html('Open Bill');
                            $('#openBillSubmitBtn').attr('disabled', false);
                        },
                        success: function(data) {
                            if (data['status']) {
                                toastr.success(data['message']);
                                $('#openBillForm')[0].reset();
                                $('#openBillModal').modal('hide');
                                let url = '{{ route('users.payments.bills.index') }}';
                                setTimeout(() => {
                                    window.location.href = url;
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
                        },
                    });
                });

                // view bill
                $(document).on('click', '.viewPaymentBillBtn', function(e) {
                    e.preventDefault();
                    let bill_id = $(this).data('id');
                    let path = '{{ route('users.payments.bills.show', ':paymentBill') }}';
                    path = path.replace(':paymentBill', bill_id);
                    $.ajax({
                        url: path,
                        type: "GET",
                        dataType: "json",
                        success: function(data) {
                            if (data['status']) {
                                // later change it to view
                                let url =
                                    '{{ route('users.payments.bills.view', ':paymentBill') }}';
                                url = url.replace(':paymentBill', data['data']['id']);
                                setTimeout(() => {
                                    window.location.href = url;
                                }, 500);
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
                        },
                    });
                });
            });
        </script>
    @endif

@endpush
