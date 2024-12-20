<div class="modal fade" id="newLensModal">
    <div class="modal-dialog modal-lg" role="dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">
                    New Lens
                </h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="newLensForm" role="form">
                <div class="modal-body">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="newLensPower">Lens Power</label>
                                <input type="text" class="form-control" name="power" id="newLensPower"
                                    placeholder="Enter Lens Power">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="newLensType">
                                    Lens Type
                                </label>
                                <select id="newLensType" name="lens_type_id"
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
                                <label for="newLensMaterial">
                                    Lens Material
                                </label>
                                <select id="newLensMaterial" name="lens_material_id"
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
                                <label for="newLensIndex">Lens Index</label>
                                <input type="text" class="form-control" name="lens_index" id="newLensIndex"
                                    placeholder="Enter Lens Index">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="newLensEye">Eye</label>
                                <select id="newLensEye" name="eye"
                                    class="form-control select2 select2-danger"
                                    data-dropdown-css-class="select2-danger" style="width: 100%;">
                                    <option disabled="disabled" selected="selected">Choose Eye</option>
                                    <option value="RIGHT">RIGHT</option>
                                    <option value="LEFT">LEFT</option>
                                </select>
                            </div>
                            <!-- /.form-group -->
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="newLensOpeningStocks">Opening Stocks</label>
                                <input type="text" class="form-control" name="opening"
                                    id="newLensOpeningStocks" placeholder="Enter Opening Stocks">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->