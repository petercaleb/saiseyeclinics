<div class="modal fade" id="updateLensModal">
    <div class="modal-dialog modal-lg" role="dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">
                    Update Lens
                </h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="updateLensForm" role="form">
                <div class="modal-body">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <input type="hidden" id="updateLensId" class="form-control">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="updateLensPower">Lens Power</label>
                                <input type="text" class="form-control" name="power" id="updateLensPower"
                                    placeholder="Enter Lens Power">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="updateLensType">
                                    Lens Type
                                </label>
                                <select id="updateLensType" name="lens_type_id"
                                    class="form-control select2 select2-primary"
                                    data-dropdown-css-class="select2-primary" style="width: 100%;">
                                    <option disabled="disabled" selected="selected">Choose Lens Type</option>
                                    @forelse ($organization->lens_type()->latest()->get() as $type)
                                        <option value="{{ $type->id }}">
                                            {{ $type->type }}
                                        </option>
                                    @empty
                                        <option disabled>No Lens Type Added</option>
                                    @endforelse

                                </select>
                            </div>
                            <!-- /.form-group -->
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="updateLensMaterial">
                                    Lens Material
                                </label>
                                <select id="updateLensMaterial" name="lens_material_id"
                                    class="form-control select2 select2-primary"
                                    data-dropdown-css-class="select2-primary" style="width: 100%;">
                                    <option disabled="disabled" selected="selected">Choose Lens Material</option>
                                    @forelse ($organization->lens_material()->latest()->get() as $material)
                                        <option value="{{ $material->id }}">
                                            {{ $material->title }}
                                        </option>
                                    @empty
                                        <option disabled>No Lens Material Added</option>
                                    @endforelse

                                </select>
                            </div>
                            <!-- /.form-group -->
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="updateLensIndex">Lens Index</label>
                                <input type="text" class="form-control" name="lens_index" id="updateLensIndex"
                                    placeholder="Enter Lens Index">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="updateLensEye">Eye</label>
                                <select id="updateLensEye" name="eye" class="form-control select2 select2-danger"
                                    data-dropdown-css-class="select2-danger" style="width: 100%;">
                                    <option disabled="disabled" selected="selected">Choose Eye</option>
                                    <option value="RIGHT">RIGHT</option>
                                    <option value="LEFT">LEFT</option>
                                </select>
                            </div>
                            <!-- /.form-group -->
                        </div>
                    </div>

                    {{-- <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="updateLensOpeningStocks">Opening Stocks</label>
                                <input type="text" class="form-control" name="opening" id="updateLensOpeningStocks"
                                    placeholder="Enter Opening Stocks">
                            </div>
                        </div>
                    </div> --}}
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
