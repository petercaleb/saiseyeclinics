<!-- Edit Lens Prescription -->
<div class="modal fade" id="editPrescriptionModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">
                    Edit Lens Prescription
                </h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <!--.modal-header -->
            <form id="editPrescriptionForm">
                <div class="modal-body">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <input type="hidden" name="prescription_id" id="editPrescriptionId" class="form-control" />
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="editPrescriptionType">Lens Type</label>
                                <select id="editPrescriptionType" name="type_id"
                                    class="form-control select2 select2-purple" style="width: 100%;"
                                    data-dropdown-css-class="select2-purple">
                                    @forelse ($types as $type)
                                        <option value="{{ $type->id }}"
                                            @if ($type->id == $lens_prescription->type_id) selected="selected" @endif>
                                            {{ $type->type }}
                                        </option>
                                    @empty
                                        <option disabled="disabled">
                                            No Lens Type Found
                                        </option>
                                    @endforelse
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="editPrescriptionMaterial">Lens Material</label>
                                <select id="editPrescriptionMaterial" name="material_id"
                                    class="form-control select2 select2-danger" style="width: 100%;"
                                    data-dropdown-css-class="select2-danger">
                                    @forelse ($materials as $material)
                                        <option value="{{ $material->id }}"
                                            @if ($material->id == $lens_prescription->material_id) selected="selected" @endif>
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
                                <label for="editPrescriptionIndex">Lens
                                    Index/Thickness</label>
                                <input type="text" name="index" class="form-control" id="editPrescriptionIndex"
                                    placeholder="Lens Index/Thickness">
                            </div>
                            <!-- /.form-group -->
                        </div>

                    </div>

                    <div class="row">

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="editPrescriptionTint">Tint</label>
                                <input type="text" name="tint" class="form-control" id="editPrescriptionTint"
                                    placeholder="Lens Tint">
                            </div>
                            <!-- /.form-group -->
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="editPrescriptionPupil">Pupil
                                    Diameter(mm)</label>
                                <input type="text" name="pupil" class="form-control" id="editPrescriptionPupil"
                                    placeholder="Pupil Diameter">
                            </div>
                            <!-- /.form-group -->
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="editPrescriptionFocalHeight">Focal
                                    Height
                                </label>
                                <input type="text" name="focal_height" class="form-control"
                                    id="editPrescriptionFocalHeight" placeholder="Focal Height">
                            </div>
                            <!-- /.form-group -->
                        </div>
                    </div>
                </div>
                <!--.modal-body -->
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" id="editPrescriptionSubmitBtn" class="btn btn-primary">
                        Update Prescription
                    </button>
                </div>
                <!--.modal-footer .justify-content-between -->
            </form>
            <!--#editLensPowerForm -->
        </div>
        <!--.modal-content -->
    </div>
    <!--.modal-dialog -->
</div>
<!-- /.modal -->
