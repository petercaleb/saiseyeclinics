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
                    <!--.timeline-body .table-responsive -->
                </div>
                <!--.timeline-item -->
            </div>

            <!-- timeline item -->
            <div>
                <i class="fa fa-eye bg-warning"></i>
                <div class="timeline-item">
                    <h3 class="timeline-header">
                        <a href="#">Left </a> Eye
                    </h3>
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
                    <!--.timeline-body .table-responsive -->
                </div>
                <!--.timeline-item -->
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
                        @if (Auth::user()->id == $schedule->user_id)
                            <div class="timeline-footer">
                                <div class="row">
                                    <div class="col-md-4">
                                        <a href="#" data-id="{{ $lens_power->id }}"
                                            class="btn btn-block btn-warning btn-flat btn-sm newLensPrescriptionBtn">
                                            Add Lens Prescription
                                        </a>
                                    </div>
                                    <div class="col-md-8">
                                        @if (Auth::user()->id && $schedule->user_id)
                                            @if (isset($treatment) && $treatment->status !== null && $treatment->status != 'ordered')
                                                <a href="#" data-id="{{ $lens_power->id }}"
                                                    class="btn btn-block btn-sm btn-secondary editLensPowerBtn">
                                                    Edit Lens Power
                                                </a>
                                            @endif
                                        @endif
                                    </div>
                                </div>

                            </div>
                        @endif
                    @else
                        <div class="timeline-footer">
                            <div class="row">
                                <div class="col-md-4">
                                    <a href="#" data-id="{{ $lens_prescription->id }}"
                                        class="btn btn-block btn-primary btn-flat btn-sm viewLensPrescription">
                                        Lens Prescription
                                    </a>
                                </div>
                                <div class="col-md-8">
                                    @if (Auth::user()->id && $schedule->user_id)
                                        @if (isset($treatment) && $treatment->status !== null && $treatment->status != 'ordered')
                                            <a href="#" data-id="{{ $lens_power->id }}"
                                                class="btn btn-block btn-sm btn-secondary editLensPowerBtn">
                                                Edit Lens Power
                                            </a>
                                        @endif
                                    @endif

                                </div>
                            </div>

                        </div>
                    @endif
                </div>
                <!--.timeline-item -->
            </div>
            <!-- END timeline item -->

            <div>
                <i class="fa fa-stop bg-gray"></i>
            </div>

        </div>
        <!--.timeline .timeline-inverse -->
    @else
        @if (Auth::user()->id == $schedule->user_id)
            <form id="lensPowerForm">
                @csrf
                @if ($diagnosis)
                    <input type="hidden" value="{{ $diagnosis->id }}" name="diagnosis_id">
                    <input type="hidden" value="{{ $treatment->id }}" name="treatment_id">
                @endif
                <p>Right Eye</p>
                <div class="card">
                    <div class="card-body">
                        <div class="row">

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="lensPowerRightSphere">Sphere</label>
                                    <input type="text" name="right_sphere" class="form-control"
                                        id="lensPowerRightSphere" placeholder="Sphere">
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="lensPowerRightCylinder">Cylinder</label>
                                    <input type="text" name="right_cylinder" class="form-control"
                                        id="lensPowerRightCylinder" placeholder="Cylinder">
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="lensPowerRightAxis">Axis</label>
                                    <input type="text" name="right_axis" class="form-control" id="lensPowerRightAxis"
                                        placeholder="Axis">
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="lensPowerRightAdditional">Additional</label>
                                    <input type="text" name="right_add" class="form-control"
                                        id="lensPowerRightAdditional" placeholder="Additional">
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
                                    <input type="text" name="left_sphere" class="form-control"
                                        id="lensPowerLeftSphere" placeholder="Sphere">
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="lensPowerLeftCylinder">Cylinder</label>
                                    <input type="text" name="left_cylinder" class="form-control"
                                        id="lensPowerLeftCylinder" placeholder="Cylinder">
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="lensPowerLeftAxis">Axis</label>
                                    <input type="text" name="left_axis" class="form-control"
                                        id="lensPowerLeftAxis" placeholder="Axis">
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="lensPowerLeftAdditional">Additional</label>
                                    <input type="text" name="left_add" class="form-control"
                                        id="lensPowerLeftAdditional" placeholder="Additional">
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


                <button type="submit" id="lensPowerSubmitBtn" class="btn btn-block btn-primary">
                    Add Power
                </button>

            </form>
        @else
            <span>
                No Lens Powers Available For This Prescription!
            </span>
        @endif

    @endif
</div>
<!--#lensPowerDiv -->