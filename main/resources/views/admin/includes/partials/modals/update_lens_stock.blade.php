 <!-- Frame Stocks Modal -->
 <div class="modal fade" id="updateLensStockModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Update Lens Stock</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="updateLensStockForm">
                <div class="modal-body">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <input type="hidden" id="updateLensStockId" name="lens_id"
                                    class="form-control" />
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="updateLensStockHqLensId">Lens Code</label>
                                <select name="hq_lens_id" id="updateLensStockHqLensId" class="form-control select2"
                                    style="width: 100%;">
                                    <option disabled='disabled' selected="selected">
                                        Select Lens Code
                                    </option>
                                    @forelse ($organization->hq_lens()->latest()->get() as $lens_stock)
                                        <option value="{{ $lens_stock->id }}">
                                            Lens Code: {{ $lens_stock->code }} -
                                            Power: {{ $lens_stock->power }} -
                                            Lens Type: {{ $lens_stock->lens_type->type }} -
                                            Lens Material: {{ $lens_stock->lens_material->title }} -
                                            Eye: {{  $lens_stock->eye  }}
                                        </option>
                                    @empty
                                        <option disabled="disabled">No Lens Code Found..</option>
                                    @endforelse
                                </select>
                            </div>
                        </div>
                    </div>
                    <!-- /.row -->

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="updateLensStockOpening">
                                    Opening Stock
                                </label>
                                <input type="number" id="updateLensStockOpening" name="opening"
                                    class="form-control" placeholder="Enter Opening Stock" />
                            </div>
                            <!-- /.form-group -->
                        </div>
                        <!-- /.col-md-6 -->
                    </div>
                    <!-- /.row -->
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">
                        Close
                    </button>
                    <button type="submit" class="btn btn-primary">
                        Save
                    </button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
