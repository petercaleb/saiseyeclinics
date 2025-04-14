@extends('admin.layouts.temp')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>View Schedule</h1>
                    <small>
                        {{ $schedule->day }} || {{ $schedule->date }} || {{ $schedule->time }}
                    </small>
                    <br>
                    <small>{{ $clinic->clinic }}</small>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.dashboard.index', $clinic->id) }}">Home</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a
                                href="{{ route('admin.patients.schedules', [$clinic->id, $patient->id]) }}">Patient
                                Profile</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.doctor.schedules.index', $clinic->id) }}">
                                Doctors Schedules
                            </a>
                        </li>
                        <li class="breadcrumb-item active">View Schedule</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-3">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            Patient Details
                        </h3>

                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                    class="fa fa-minus"></i>
                            </button>
                        </div>
                    </div>

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
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Doctor/ Optometist</h3>

                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                    class="fa fa-minus"></i>
                            </button>
                        </div>
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
                <!-- /.card -->
            </div>
            <!-- /.col -->
            <div class="col-md-6">
                <div class="card card-outline card-primary">
                    <div class="card-header p-2">
                        <ul class="nav nav-pills">
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
                    </div><!-- /.card-header -->
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
                                                    No diagnosis have been performed for this patient yet.
                                                </div>
                                            </div>
                                        </div>
                                        <!-- END timeline item -->
                                    @endif
                                    <div>
                                        <i class="fa fa-clock-o bg-gray"></i>
                                    </div>
                                </div><!-- /.timeline -->

                            </div><!-- /.tab-pane -->

                            <div class="tab-pane" id="treatmentTab">

                                <div class="lensPowerDiv">
                                    <!-- The timeline -->
                                    <div class="timeline timeline-inverse">
                                        @if ($lens_power)
                                            <!-- timeline time label -->
                                            <div class="time-label">
                                                <span class="bg-primary">
                                                    Lens Power
                                                </span>
                                            </div>
                                            <!-- /.timeline-label -->

                                            <div>
                                                <i class="fa fa-eye bg-danger"></i>

                                                <div class="timeline-item">
                                                    <h3 class="timeline-header">
                                                        <a href="#">Right</a> eye
                                                    </h3>

                                                    <div class="timeline-body table-responsive">
                                                        <table class="table table-bordered">
                                                            <tbody>
                                                                <tr>
                                                                    <th>Sphere</th>
                                                                    <td>
                                                                        {{ $lens_power->right_sphere }}
                                                                    </td>
                                                                </tr>

                                                                <tr>
                                                                    <th>Cylinder</th>
                                                                    <td>
                                                                        {{ $lens_power->right_cylinder }}
                                                                    </td>
                                                                </tr>

                                                                <tr>
                                                                    <th>Axis</th>
                                                                    <td>
                                                                        {{ $lens_power->right_axis }}
                                                                    </td>
                                                                </tr>

                                                                <tr>
                                                                    <th>Additional</th>
                                                                    <td>
                                                                        {{ $lens_power->right_add }}
                                                                    </td>
                                                                </tr>
                                                            </tbody>

                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- END timeline item -->

                                            <!-- timeline item -->
                                            <div>
                                                <i class="fa fa-eye bg-warning"></i>

                                                <div class="timeline-item">

                                                    <h3 class="timeline-header"><a href="#">Left </a> Eye</h3>

                                                    <div class="timeline-body table-responsive">
                                                        <table class="table table-bordered">
                                                            <tbody>
                                                                <tr>
                                                                    <th>Sphere</th>
                                                                    <td>
                                                                        {{ $lens_power->left_sphere }}
                                                                    </td>
                                                                </tr>

                                                                <tr>
                                                                    <th>Cylinder</th>
                                                                    <td>
                                                                        {{ $lens_power->left_cylinder }}
                                                                    </td>
                                                                </tr>

                                                                <tr>
                                                                    <th>Axis</th>
                                                                    <td>
                                                                        {{ $lens_power->left_axis }}
                                                                    </td>
                                                                </tr>

                                                                <tr>
                                                                    <th>Additional</th>
                                                                    <td>
                                                                        {{ $lens_power->left_add }}
                                                                    </td>
                                                                </tr>
                                                            </tbody>

                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- END timeline item -->

                                            <!-- timeline time label -->
                                            <div class="time-label">
                                                <span class="bg-success">
                                                    Additional Information
                                                </span>
                                            </div>
                                            <!-- /.timeline-label -->

                                            <!-- timeline item -->
                                            <div>
                                                <i class="fa fa-info-circle bg-purple"></i>

                                                <div class="timeline-item">

                                                    <div class="timeline-body">
                                                        {{ $lens_power->notes }}
                                                    </div>
                                                    @if ($lens_prescription)
                                                        <div class="timeline-footer">
                                                            <a href="#" data-id="{{ $lens_prescription->id }}"
                                                                class="btn btn-block btn-primary btn-flat btn-sm viewLensPrescription">
                                                                Lens Prescription
                                                            </a>
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
                                                        <a href="#">Lens</a> Power
                                                    </h3>

                                                    <div class="timeline-body">
                                                        No lens power has been recommended yet by the doctor.
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- END timeline item -->
                                        @endif
                                        <div>
                                            <i class="fa fa-stop bg-gray"></i>
                                        </div>

                                    </div><!-- /.timeline -->
                                </div><!-- /.lensPowerDiv -->

                                <div class="lensPrescriptionDiv">
                                    <!-- The timeline -->
                                    <div class="timeline timeline-inverse">
                                        @if ($lens_prescription)
                                            <!-- timeline time label -->
                                            <div class="time-label">
                                                <span class="bg-primary">
                                                    Lens Prescription
                                                </span>
                                            </div>
                                            <!-- /.timeline-label -->

                                            <!-- timeline item -->
                                            <div>
                                                <i class="fa fa-tripadvisor bg-danger"></i>

                                                <div class="timeline-item">
                                                    <h3 class="timeline-header">
                                                        <a href="#">Lens</a> Type
                                                    </h3>

                                                    <div class="timeline-body table-responsive">
                                                        <p>
                                                            {{ $lens_prescription->lens_type->type }}
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- END timeline item -->

                                            <!-- timeline item -->
                                            <div>
                                                <i class="fa fa-cubes bg-warning"></i>

                                                <div class="timeline-item">

                                                    <h3 class="timeline-header"><a href="#">Lens </a> Material</h3>

                                                    <div class="timeline-body table-responsive">
                                                        {{ $lens_prescription->lens_material->title }}
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- END timeline item -->

                                            <!-- timeline item -->
                                            <div>
                                                <i class="fa fa-th bg-purple"></i>

                                                <div class="timeline-item">

                                                    <h3 class="timeline-header"><a href="#">Lens </a>
                                                        Index/Thickness</h3>

                                                    <div class="timeline-body">
                                                        {{ $lens_prescription->index }}
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- END timeline item -->

                                            <!-- timeline item -->
                                            <div>
                                                <i class="fa fa-tint bg-info"></i>

                                                <div class="timeline-item">

                                                    <h3 class="timeline-header"><a href="#">Lens </a> Tint</h3>

                                                    <div class="timeline-body">
                                                        {{ $lens_prescription->tint }}
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- END timeline item -->

                                            <!-- timeline item -->
                                            <div>
                                                <i class="fa fa-th bg-info"></i>

                                                <div class="timeline-item">

                                                    <h3 class="timeline-header"><a href="#">Lens </a> Diameter /
                                                        Pupil</h3>

                                                    <div class="timeline-body">
                                                        {{ $lens_prescription->diameter }}
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- END timeline item -->

                                            <!-- timeline item -->
                                            <div>
                                                <i class="fa fa-text-height bg-danger"></i>

                                                <div class="timeline-item">

                                                    <h3 class="timeline-header"><a href="#">Lens </a> Focal Height
                                                    </h3>

                                                    <div class="timeline-body">
                                                        {{ $lens_prescription->focal_height }}
                                                    </div>

                                                    @if ($frame_prescription)
                                                        <div class="timeline-footer">
                                                            <a href="#" data-id="{{ $frame_prescription->id }}"
                                                                class="btn btn-block btn-primary btn-flat btn-sm frameCodeBtn">
                                                                Frame Code
                                                            </a>
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
                                                        <a href="#">Lens</a> Prescription
                                                    </h3>

                                                    <div class="timeline-body">
                                                        No lens prescription has been recommended yet by the doctor.
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- END timeline item -->
                                        @endif
                                        <div>
                                            <i class="fa fa-stop bg-gray"></i>
                                        </div>
                                    </div>
                                    <!--./timeline -->
                                </div><!-- /.lensPrescriptionDiv -->

                                <div class="frameCodesDiv">
                                    <!-- The timeline -->
                                    <div class="timeline timeline-inverse">

                                        @if ($frame_prescription)
                                            <!-- timeline time label -->
                                            <div class="time-label">
                                                <span class="bg-primary">
                                                    Frame Code
                                                </span>
                                            </div>
                                            <!-- /.timeline-label -->

                                            <!-- timeline item -->
                                            <div>
                                                <i class="fa fa-list bg-primary"></i>

                                                <div class="timeline-item">
                                                    <h3 class="timeline-header">
                                                        <a href="#">Frame</a> Code
                                                    </h3>

                                                    <div class="timeline-body table-responsive">
                                                        <p>
                                                            {{ $frame_prescription->frame_code }}
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- END timeline item -->

                                            <!-- timeline item -->
                                            <div>
                                                <i class="fa fa-file bg-warning"></i>

                                                <div class="timeline-item">

                                                    <h3 class="timeline-header"><a href="#">Receipt </a> Number</h3>

                                                    <div class="timeline-body table-responsive">
                                                        {{ $frame_prescription->receipt_number }}
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- END timeline item -->

                                            <!-- timeline item -->
                                            <div>
                                                <i class="fa fa-industry bg-purple"></i>

                                                <div class="timeline-item">

                                                    <h3 class="timeline-header"><a href="#">Workshop </a> </h3>

                                                    <div class="timeline-body">
                                                        {{ $frame_prescription->workshop->name }}
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- END timeline item -->

                                            <!-- timeline item -->
                                            <div>
                                                <i class="fa fa-info bg-info"></i>

                                                <div class="timeline-item">

                                                    <h3 class="timeline-header"><a href="#">Remarks </a></h3>

                                                    <div class="timeline-body">
                                                        {{ $frame_prescription->remarks }}
                                                    </div>

                                                    <div class="timeline-footer">
                                                        <a href="#" data-id="{{ $lens_power->id }}"
                                                            class="btn btn-block btn-primary btn-flat btn-sm viewLensPowerBtn">
                                                            Back to Lens Power
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- END timeline item -->
                                        @endif
                                        <div>
                                            <i class="fa fa-stop bg-gray"></i>
                                        </div>
                                    </div><!-- /.timeline -->
                                </div><!-- /.frameCodesDiv -->

                            </div><!-- /.tab-pane -->

                            <div class="tab-pane" id="medicineTab">
                                <div class="table-responsive">
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
                            </div><!-- /.tab-pane -->

                            <div class="tab-pane" id="procedureTab">

                                @if ($procedure)
                                    <div class="callout callout-info">
                                        {!! $procedure->procedure !!}
                                    </div>
                                @else
                                    <div class="callout callout-info">
                                        No procedure has been recommended yet by the doctor.
                                    </div>
                                @endif

                                <hr>
                                @if ($payment_bill)
                                    <a href="#" data-id="{{ $payment_bill->id }}"
                                        class="btn btn-block btn-primary viewPaymentBillBtn">
                                        View Opened Payment Bill
                                    </a>
                                @else
                                    <div class="callout callout-info">
                                        No bill opened yet.
                                    </div>
                                @endif

                            </div>
                            <!--.tab-pane-->

                        </div><!-- /.tab-content -->
                    </div><!-- /.card-body -->
                </div><!-- /.card -->
            </div>
            <!-- /.col -->
            <div class="col-md-3">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            Payment Details
                        </h3>

                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                    class="fa fa-minus"></i>
                            </button>
                        </div>
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
                                {{ $payment_details->insurance->title }}
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
                            {{ $payment_details->workplace }}
                        </p>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>
    <!-- /.content -->
@endsection

@section('scripts')
    @if ($diagnosis)
        <script>
            $(document).ready(function() {

                // Treatment
                $('.lensPowerDiv').fadeIn();
                $('.lensPrescriptionDiv').fadeOut();
                $('.frameCodesDiv').fadeOut();

                // view lens prescription
                $(document).on('click', '.viewLensPrescription', function(e) {
                    e.preventDefault();
                    var prescription_id = $(this).data('id');
                    var token = '{{ csrf_token() }}';
                    var path = '{{ route('admin.lens.prescription.show') }}';
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

                // view frame code
                $(document).on('click', '.frameCodeBtn', function(e) {
                    e.preventDefault();
                    $('.lensPowerDiv').fadeOut();
                    $('.lensPrescriptionDiv').fadeOut();
                    $('.frameCodesDiv').fadeIn();
                });

                // Back to lens Power
                $(document).on('click', '.viewLensPowerBtn', function(e) {
                    e.preventDefault();
                    $('.lensPowerDiv').fadeIn();
                    $('.lensPrescriptionDiv').fadeOut();
                    $('.frameCodesDiv').fadeOut();
                });

                // Medical History
                find_medicine();

                function find_medicine() {
                    var path = '{{ route('admin.medicine.index', $diagnosis->id) }}';
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


            });
        </script>
    @endif
@endsection
