@extends('users.layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Treatment</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">
                            <a href="{{ route('users.dashboard.index') }}">Home</a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('users.doctor.schedules.view', $diagnosis->doctor_schedule) }}">
                                Doctor Schedule
                            </a>
                        </li>
                        <li class="breadcrumb-item active">Patient Treatment</li>
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
                                    <i class="fa fa-user"></i> {{ $diagnosis->patient->first_name }}
                                    {{ $diagnosis->patient->last_name }}
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="fa fa-phone"></i> {{ $diagnosis->patient->phone }}
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="fa fa-envelope"></i> {{ $diagnosis->patient->email }}
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="fa fa-calendar"></i> {{ $diagnosis->patient->dob }}
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="fa fa-male"></i> {{ $diagnosis->patient->gender }}
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="fa fa-map-signs"></i> {{ $diagnosis->patient->address }}
                                </a>
                            </li>
                        </ul>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Doctor/ Optimist</h3>

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
                                    {{ $diagnosis->user->first_name }} {{ $diagnosis->user->last_name }}
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="fa fa-phone text-warning"></i> {{ $diagnosis->user->phone }}
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#" class="nav-link">
                                    <i class="fa fa-envelope text-primary"></i>
                                    {{ $diagnosis->user->email }}
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
                                <a class="nav-link active" href="#treatmentTab" data-toggle="tab">
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
                        </ul><!-- /.nav-pills -->
                    </div><!-- /.card-header -->
                    <div class="card-body">
                        <div class="tab-content">
                            <div class="active tab-pane" id="treatmentTab">
                                <div class="lensPowerDiv">
                                    @if ($lens_power)
                                        <!-- The timeline -->
                                        <div class="timeline timeline-inverse">
                                            <!-- timeline time label -->
                                            <div class="time-label">
                                                <span class="bg-primary">
                                                    Lens Power
                                                </span>
                                            </div>
                                            <!-- /.timeline-label -->

                                            <!-- timeline item -->
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
                                                    @if (!$lens_prescription)
                                                        <div class="timeline-footer">
                                                            <a href="#" data-id="{{ $lens_power->id }}"
                                                                class="btn btn-block btn-warning btn-flat btn-sm newLensPrescriptionBtn">
                                                                Add Lens Prescription
                                                            </a>
                                                        </div>
                                                    @else
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
                                            <div>
                                                <i class="fa fa-stop bg-gray"></i>
                                            </div>
                                        </div>
                                    @else
                                        <form id="lensPowerForm">
                                            @csrf
                                            <input type="hidden" value="{{ $diagnosis->id }}" name="diagnosis_id">
                                            <p>Right Eye</p>
                                            <div class="card">
                                                <div class="card-body">
                                                    <div class="row">

                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label for="lensPowerRightSphere">Sphere</label>
                                                                <input type="text" name="right_sphere"
                                                                    class="form-control" id="lensPowerRightSphere"
                                                                    placeholder="Sphere">
                                                            </div>
                                                        </div>

                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label for="lensPowerRightCylinder">Cylinder</label>
                                                                <input type="text" name="right_cylinder"
                                                                    class="form-control" id="lensPowerRightCylinder"
                                                                    placeholder="Cylinder">
                                                            </div>
                                                        </div>

                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label for="lensPowerRightAxis">Axis</label>
                                                                <input type="text" name="right_axis"
                                                                    class="form-control" id="lensPowerRightAxis"
                                                                    placeholder="Axis">
                                                            </div>
                                                        </div>

                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label for="lensPowerRightAdditional">Additional</label>
                                                                <input type="text" name="right_add"
                                                                    class="form-control" id="lensPowerRightAdditional"
                                                                    placeholder="Additional">
                                                            </div>
                                                        </div>

                                                    </div>
                                                    <!--row -->
                                                </div>
                                                <!-- /.card-body -->
                                            </div>
                                            <!--card-->

                                            <p>Left Eye</p>
                                            <div class="card">
                                                <div class="card-body">
                                                    <div class="row">

                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label for="lensPowerLeftSphere">Sphere</label>
                                                                <input type="text" name="left_sphere"
                                                                    class="form-control" id="lensPowerLeftSphere"
                                                                    placeholder="Sphere">
                                                            </div>
                                                        </div>

                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label for="lensPowerLeftCylinder">Cylinder</label>
                                                                <input type="text" name="left_cylinder"
                                                                    class="form-control" id="lensPowerLeftCylinder"
                                                                    placeholder="Cylinder">
                                                            </div>
                                                        </div>

                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label for="lensPowerLeftAxis">Axis</label>
                                                                <input type="text" name="left_axis"
                                                                    class="form-control" id="lensPowerLeftAxis"
                                                                    placeholder="Axis">
                                                            </div>
                                                        </div>

                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label for="lensPowerLeftAdditional">Additional</label>
                                                                <input type="text" name="left_add"
                                                                    class="form-control" id="lensPowerLeftAdditional"
                                                                    placeholder="Additional">
                                                            </div>
                                                        </div>

                                                    </div>
                                                    <!--row -->
                                                </div>
                                                <!-- /.card-body -->
                                            </div>
                                            <!--card-->

                                            <div class="form-group">
                                                <label for="lensPowerAdditionalInfo">
                                                    Additional Information
                                                </label>
                                                <textarea name="notes" id="lensPowerAdditionalInfo" class="form-control" placeholder="Additional Information"></textarea>
                                            </div>


                                            <button type="submit" id="lensPowerSubmitBtn"
                                                class="btn btn-block btn-primary">
                                                Add Power
                                            </button>

                                        </form>
                                    @endif
                                </div>
                                <!--.lensPowerDiv-->

                                <div class="lensPrescriptionDiv">
                                    @if ($lens_prescription)
                                        <!-- The timeline -->
                                        <div class="timeline timeline-inverse">
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
                                                    @else
                                                        <div class="timeline-footer">
                                                            <a href="#" data-id="{{ $lens_power->id }}"
                                                                class="btn btn-block btn-warning btn-flat btn-sm newFrameCodeBtn">
                                                                Add Frame Code
                                                            </a>
                                                        </div>
                                                    @endif

                                                </div>
                                            </div>
                                            <!-- END timeline item -->
                                            <div>
                                                <i class="fa fa-stop bg-gray"></i>
                                            </div>
                                        </div>
                                    @else
                                        <form id="lensPrescriptionForm">
                                            @csrf
                                            <input type="hidden" name="power_id" id="lensPrescriptionPowerId" />
                                            <div class="card">
                                                <div class="card-body">
                                                    <h5 class="card-title">Lens Prescription</h5>
                                                    <br><br>

                                                    <div class="form-group">
                                                        <label for="lensPrescriptionType">Lens Type</label>
                                                        <select id="lensPrescriptionType" name="type_id"
                                                            class="form-control select2 select2-purple"
                                                            style="width: 100%;" data-dropdown-css-class="select2-purple">
                                                            <option selected="selected" disabled="disabled">Choose Lens
                                                                Type
                                                            </option>
                                                            @forelse ($types as $type)
                                                                <option value="{{ $type->id }}">
                                                                    {{ $type->type }}
                                                                </option>
                                                            @empty
                                                                <option disabled="disabled">No Lens Type Found</option>
                                                            @endforelse
                                                        </select>
                                                    </div>
                                                    <!-- /.form-group -->

                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="lensPrescriptionMaterial">Lens Material</label>
                                                                <select id="lensPrescriptionMaterial" name="material_id"
                                                                    class="form-control select2 select2-danger"
                                                                    style="width: 100%;"
                                                                    data-dropdown-css-class="select2-danger">
                                                                    <option selected="selected" disabled="disabled">
                                                                        Choose Lens Material
                                                                    </option>
                                                                    @forelse ($materials as $material)
                                                                        <option value="{{ $material->id }}">
                                                                            {{ $material->title }}
                                                                        </option>
                                                                    @empty
                                                                        <option disabled="disabled">
                                                                            No Lens Material Found
                                                                        </option>
                                                                    @endforelse
                                                                </select>
                                                            </div>
                                                            <!-- /.form-group -->
                                                        </div>

                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="lensPrescriptionIndex">Lens
                                                                    Index/Thickness</label>
                                                                <input type="text" name="index" class="form-control"
                                                                    id="lensPrescriptionIndex"
                                                                    placeholder="Lens Index/Thickness">
                                                            </div>
                                                            <!-- /.form-group -->
                                                        </div>

                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="lensPrescriptionTint">Tint</label>
                                                                <input type="text" name="tint" class="form-control"
                                                                    id="lensPrescriptionTint" placeholder="Lens Tint">
                                                            </div>
                                                            <!-- /.form-group -->
                                                        </div>

                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="lensPrescriptionPupil">Pupil
                                                                    Diameter(mm)</label>
                                                                <input type="text" name="pupil" class="form-control"
                                                                    id="lensPrescriptionPupil"
                                                                    placeholder="Pupil Diameter">
                                                            </div>
                                                            <!-- /.form-group -->
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label for="lensPrescriptionFocalHeight">Focal
                                                                    Height</label>
                                                                <input type="text" name="focal_height"
                                                                    class="form-control" id="lensPrescriptionFocalHeight"
                                                                    placeholder="Focal Height">
                                                            </div>
                                                            <!-- /.form-group -->
                                                        </div>
                                                    </div>

                                                    <button type="submit" id="lensPrescriptionSubmitBtn"
                                                        class="btn btn-block btn-primary">
                                                        Next
                                                    </button>
                                                </div>
                                                <!-- /.card-body -->

                                            </div>
                                            <!-- /.card -->
                                        </form>
                                    @endif

                                </div>
                                <!--.lensPrescriptionDiv-->

                                <div class="frameCodesDiv">
                                    @if ($frame_prescription)
                                        <!-- The timeline -->
                                        <div class="timeline timeline-inverse">
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
                                                </div>
                                            </div>
                                            <!-- END timeline item -->

                                            <div>
                                                <i class="fa fa-stop bg-gray"></i>
                                            </div>
                                        </div>
                                    @else
                                        <form id="frameCodeForm">
                                            <div class="card">
                                                <div class="card-body">
                                                    <div class="row">
                                                        @csrf
                                                        <input type="hidden" name="power_id"
                                                            value="{{ $lens_power->id }}" class="form-control" />
                                                        <input type="hidden" name="prescription_id"
                                                            value="{{ $lens_prescription->id }}" class="form-control" />
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="frameCode">Frame Code</label>
                                                                <input type="text" name="frame_code" id="frameCode"
                                                                    placeholder="Enter Frame Code" class="form-control"
                                                                    required />
                                                            </div>
                                                            <!-- /.form-group -->
                                                        </div>
                                                        <!-- /.col-md-6 -->

                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label for="frameCodeReceiptNumber">Receipt Number</label>
                                                                <input type="number" name="receipt_number"
                                                                    id="frameCodeReceiptNumber"
                                                                    placeholder="Enter Receipt Number"
                                                                    class="form-control" required />
                                                            </div>
                                                            <!-- /.form-group -->
                                                        </div>
                                                        <!-- /.col-md-6 -->

                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label for="frameCodeWorkShop">
                                                                    Workshop
                                                                </label>
                                                                <select id="frameCodeWorkShop" name="workshop_id"
                                                                    class="form-control select2 select2-info"
                                                                    style="width: 100%;"
                                                                    data-dropdown-css-class="select2-info">
                                                                    <option selected="selected" disabled="disabled">
                                                                        Choose Workshop
                                                                    </option>
                                                                    @forelse ($workshops as $workshop)
                                                                        <option value="{{ $workshop->id }}">
                                                                            {{ $workshop->name }}</option>
                                                                    @empty
                                                                        <option disabled="disabled">No Workshos Added yet!
                                                                        </option>
                                                                    @endforelse
                                                                </select>
                                                            </div>
                                                            <!-- /.form-group -->
                                                        </div>
                                                        <!-- /.col-md-12 -->

                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label for="frameCodeRemarks">
                                                                    Remarks
                                                                </label>
                                                                <textarea name="remarks" id="frameCodeRemarks" class="form-control" placeholder="Remarks"></textarea>
                                                            </div>
                                                            <!-- /.form-group -->
                                                        </div>
                                                        <!-- /.col-md-12 -->
                                                    </div>
                                                    <!-- /.row -->
                                                    <button type="submit" id="frameCodeSubmitBtn"
                                                        class="btn btn-block btn-primary">
                                                        Save
                                                    </button>
                                                </div><!-- /.card-body -->
                                            </div><!-- /.card -->
                                        </form>
                                    @endif
                                </div>
                                <!--.frameCodesDiv-->
                            </div>
                            <!--./tab-pane-->

                            <div class="tab-pane" id="medicineTab">
                                <div class="table-responsive">
                                    <button id="addMedicineBtn" class="btn btn-block btn-success">
                                        <i class="fa fa-plus-circle"></i> Add Medicine
                                    </button>
                                    <hr>
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
                                    <form id="procedureForm">
                                        @csrf
                                        <div class="form-group">
                                            <input type="hidden" name="diagnosis_id" value="{{ $diagnosis->id }}"
                                                class="form-control" />
                                        </div>
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
                                @endif
                                <hr>
                                @if ($payment_bill)
                                    <a href="#" data-id="{{ $payment_bill->id }}"
                                        class="btn btn-block btn-primary viewPaymentBillBtn">
                                        View Payment Bill
                                    </a>
                                @else
                                    <a href="#" id="{{ $diagnosis->schedule_id }}"
                                        class="btn btn-block btn-success openBillBtn" rel="noopener noreferrer">
                                        Open Bill
                                    </a>
                                @endif
                            </div>
                            <!-- /.tab-pane -->

                        </div>
                        <!--.tab-content-->
                    </div><!-- /.card-body -->

                </div><!-- /.card -->

            </div><!-- /.col -->

            <div class="col-md-3">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">
                            Diagnosis
                        </h3>

                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fa fa-minus"></i>
                            </button>
                        </div>
                    </div>

                    <div class="card-body">
                        <strong><i class="fa fa-file mr-1"></i> Signs</strong>

                        <p class="text-muted">
                            {!! $diagnosis->signs !!}
                        </p>

                        <hr>

                        <strong><i class="fa fa-file-text mr-1"></i> Symptoms</strong>

                        <p class="text-muted">
                            {!! $diagnosis->symptoms !!}
                        </p>

                        <hr>

                        <strong><i class="fa fa-comments mr-1"></i> Diagnosis</strong>

                        <p class="text-muted">
                            {!! $diagnosis->diagnosis !!}
                        </p>
                    </div>
                    <!-- /.card-body -->

                </div><!-- /.card -->
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
                </div><!-- /.card -->
            </div><!-- /.col -->
        </div>

        <div class="modal fade" id="addMedicineModal">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">
                            Add Medicine
                        </h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="addMedicineForm">
                        <div class="modal-body">
                            @csrf
                            <div class="form-group">
                                <input type="hidden" value="{{ $diagnosis->id }}" name="diagnosis_id"
                                    class="form-control" id="addMedicineDiagnosisId" />
                            </div>

                            <div class="form-group">
                                <label for="addMedicineName">Medicine</label>
                                <input type="text" name="medicine" class="form-control" id="addMedicineName"
                                    placeholder="Medicine Name">
                            </div>

                            <div class="form-group">
                                <label for="addMedicineDose">Quantity/ Dose</label>
                                <input type="text" class="form-control" id="addMedicineDose" name="dose"
                                    placeholder="Dose/ Quantity">
                            </div>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button id="addMedicineSubmitBtn" type="submit" class="btn btn-primary">
                                Add Medicine
                            </button>
                        </div>
                    </form>

                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->

        <div class="modal fade" id="openBillModal">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">
                            Open Bill
                        </h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="openBillForm">
                        <div class="modal-body">
                            @csrf
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <input type="hidden" class="form-control" id="openBillScheduleId"
                                            name="schedule_id" />
                                    </div>
                                </div>
                                <!--.col-md-12-->
                            </div>
                            <!--.row-->

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="openBillConsultationFee">
                                            Consultation Fee
                                        </label>
                                        <input type="text" class="form-control" name="consultation_fee"
                                            id="openBillConsultationFee" placeholder="Consultation Fee">
                                    </div>
                                </div>
                                <!--.col-md-6-->

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="openBillConsultationReceipt">
                                            Consultation Receipt
                                        </label>
                                        <input type="text" class="form-control" name="consultation_receipt"
                                            id="openBillConsultationReceipt" placeholder="Consultation Receipt">
                                    </div>
                                </div>
                                <!--.col-md-6-->
                            </div>
                            <!--.row-->

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="openBillClaimedAmount">
                                            Claimed Amount
                                        </label>
                                        <input type="text" class="form-control" name="claimed_amount"
                                            id="openBillClaimedAmount" placeholder="Claimed Amount">
                                    </div>
                                </div>
                            </div>
                            <!--.row-->

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="openBillRemarks">
                                            Remarks
                                        </label>
                                        <textarea name="remarks" id="openBillRemarks" class="form-control" placeholder="Enter Remarks"></textarea>
                                    </div>
                                </div>
                            </div>
                            <!--.row-->

                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <button type="submit" id="openBillSubmitBtn" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->
    </section>
    <!-- /.content -->
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {

            $('.lensPowerDiv').fadeIn();
            $('.lensPrescriptionDiv').fadeOut();
            $('.frameCodesDiv').fadeOut();

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
                    },
                });
            });

            $(document).on('click', '.newLensPrescriptionBtn', function(e) {
                e.preventDefault();
                $('.lensPowerDiv').fadeOut();
                $('#lensPrescriptionPowerId').val($(this).data('id'));
                $('.lensPrescriptionDiv').fadeIn();
                $('.frameCodesDiv').fadeOut();
            });

            $('#lensPrescriptionForm').submit(function(e) {
                e.preventDefault();
                var form = $(this);
                var formData = new FormData(form[0]);
                var path = '{{ route('users.lens.prescription.store') }}';
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
                    },
                });
            });

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

            // frame code form
            $(document).on('click', '.newFrameCodeBtn', function(e) {
                e.preventDefault();
                $('.lensPowerDiv').fadeOut();
                $('.lensPrescriptionDiv').fadeOut();
                $('.frameCodesDiv').fadeIn();
            });

            $('#frameCodeForm').submit(function(e) {
                e.preventDefault();
                var form = $(this);
                var formData = new FormData(form[0]);
                var path = '{{ route('users.lens.frame.prescription.store') }}';
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
                            $('.lensPowerDiv').fadeOut();
                            $('.lensPrescriptionDiv').fadeOut();
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
                    },
                });

            });

            $(document).on('click', '.frameCodeBtn', function(e) {
                e.preventDefault();
                $('.lensPowerDiv').fadeOut();
                $('.lensPrescriptionDiv').fadeOut();
                $('.frameCodesDiv').fadeIn();
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
                var bill_id = $(this).data('id');
                var token = '{{ csrf_token() }}';
                var path = '{{ route('users.payments.bills.show') }}';
                $.ajax({
                    url: path,
                    type: "POST",
                    dataType: "json",
                    data: {
                        bill_id: bill_id,
                        _token: token,
                    },
                    success: function(data) {
                        if (data['status']) {
                            // later change it to view
                            let url = '{{ route('users.payments.bills.view', ':id') }}';
                            url = url.replace(':id', data['data']['id']);
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
        });
    </script>
@endsection
