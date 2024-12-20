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

                    <h3 class="timeline-header"><a href="#">Lens </a> Material
                    </h3>

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

                    <h3 class="timeline-header"><a href="#">Lens </a> Focal
                        Height
                    </h3>

                    <div class="timeline-body">
                        {{ $lens_prescription->focal_height }}
                    </div>

                    @if ($frame_prescription)
                        <div class="timeline-footer">
                            <div class="row">
                                <div class="col-md-4">
                                    <a href="#" data-id="{{ $frame_prescription->id }}"
                                        class="btn btn-block btn-primary btn-flat btn-sm frameCodeBtn">
                                        Frame Code
                                    </a>
                                </div>
                                <div class="col-md-8">
                                    @if (Auth::user()->id == $schedule->user_id)
                                        @if (isset($treatment) && $treatment->status !== null && $treatment->status != 'ordered')
                                            <a href="#" data-id="{{ $lens_prescription->id }}"
                                                class="btn btn-block btn-sm btn-secondary editPrescriptionBtn">
                                                Edit Prescription
                                            </a>
                                        @endif
                                    @endif
                                </div>
                            </div>

                        </div>
                    @else
                        <div class="timeline-footer">
                            <div class="row">
                                @if (Auth::user()->id == $schedule->user_id)
                                    <div class="col-md-4">
                                        <a href="#" data-id="{{ $lens_prescription->id }}"
                                            class="btn btn-block btn-warning btn-flat btn-sm newFrameCodeBtn">
                                            Add Frame Code
                                        </a>
                                    </div>
                                    <div class="col-md-8">

                                        @if (isset($treatment) && $treatment->status !== null && $treatment->status != 'ordered')
                                            <a href="#" id="{{ $lens_prescription->id }}"
                                                class="btn btn-block btn-sm btn-secondary">
                                                Edit Prescription
                                            </a>
                                        @endif
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif

                </div>
            </div>
            <!-- END timeline item -->

            <div>
                <i class="fa fa-stop bg-gray"></i>
            </div>
        </div>
        <!--.timeline .timeline-inverse -->
    @else
        @if (Auth::user()->id == $schedule->user_id)

            <form id="lensPrescriptionForm">
                @csrf
                <input type="hidden" name="power_id" id="lensPrescriptionPowerId" class="form-control" />
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Lens Prescription</h5>
                        <br><br>
                        <div class="form-group">
                            <label for="lensPrescriptionType">Lens Type</label>
                            <select id="lensPrescriptionType" name="type_id" class="form-control select2 select2-purple"
                                style="width: 100%;" data-dropdown-css-class="select2-purple">
                                <option selected="selected" disabled="disabled">Choose
                                    Lens
                                    Type
                                </option>
                                @forelse ($types as $type)
                                    <option value="{{ $type->id }}">
                                        {{ $type->type }}
                                    </option>
                                @empty
                                    <option disabled="disabled">No Lens Type Found
                                    </option>
                                @endforelse
                            </select>
                        </div>
                        <!-- /.form-group -->

                        <div class="row">

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="lensPrescriptionMaterial">Lens
                                        Material</label>
                                    <select id="lensPrescriptionMaterial" name="material_id"
                                        class="form-control select2 select2-danger" style="width: 100%;"
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
                                    <input type="text" name="index" class="form-control" id="lensPrescriptionIndex"
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
                                        id="lensPrescriptionPupil" placeholder="Pupil Diameter">
                                </div>
                                <!-- /.form-group -->
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="lensPrescriptionFocalHeight">Focal
                                        Height</label>
                                    <input type="text" name="focal_height" class="form-control"
                                        id="lensPrescriptionFocalHeight" placeholder="Focal Height">
                                </div>
                                <!-- /.form-group -->
                            </div>

                        </div>
                        <!--.row -->

                        <button type="submit" id="lensPrescriptionSubmitBtn" class="btn btn-block btn-primary">
                            Next
                        </button>

                    </div>
                    <!--.card-body -->
                </div>
                <!--.card -->
            </form>
            <!--#lensPrescriptionForm -->
        @else
            <span>
                No Lens Prescription prescribed yet
            </span>
        @endif
    @endif

</div>
<!--/ lensPrescriptionDiv -->
