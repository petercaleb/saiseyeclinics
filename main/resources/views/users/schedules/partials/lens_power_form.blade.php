@if (Auth::user()->id == $schedule->user_id)
    <form class="d-none" id="lensPowerForm">
        @csrf
        @if ($diagnosis)
            <input type="hidden" value="{{ $diagnosis->id }}" name="diagnosis_id">
            <input type="hidden" value="{{ $treatment->id }}" name="treatment_id">
            <input type="hidden" value="Treatment 1" name="form_type">
        @endif
        <p>Right Eye</p>
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="lensPowerRightSphere">Sphere</label>
                            <input type="text" name="right_sphere" class="form-control" id="lensPowerRightSphere"
                                placeholder="Sphere">
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="lensPowerRightCylinder">Cylinder</label>
                            <input type="text" name="right_cylinder" class="form-control" id="lensPowerRightCylinder"
                                placeholder="Cylinder">
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
                            <input type="text" name="right_add" class="form-control" id="lensPowerRightAdditional"
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
                            <input type="text" name="left_sphere" class="form-control" id="lensPowerLeftSphere"
                                placeholder="Sphere">
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="lensPowerLeftCylinder">Cylinder</label>
                            <input type="text" name="left_cylinder" class="form-control" id="lensPowerLeftCylinder"
                                placeholder="Cylinder">
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="lensPowerLeftAxis">Axis</label>
                            <input type="text" name="left_axis" class="form-control" id="lensPowerLeftAxis"
                                placeholder="Axis">
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="lensPowerLeftAdditional">Additional</label>
                            <input type="text" name="left_add" class="form-control" id="lensPowerLeftAdditional"
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


        <button type="submit" id="lensPowerSubmitBtn" class="btn btn-block btn-primary">
            Add Power
        </button>

    </form>
@else
    <span>
        No Lens Powers Available For This Prescription!
    </span>
@endif
