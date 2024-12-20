 <!-- Frame Stocks Modal -->
 <div class="modal fade" id="addLensStockModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Add Lens Stock</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="addLensStockForm">
                <div class="modal-body">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="addLensStockHqLensId">Case Code</label>
                                <select name="hq_lens_id" id="addLensStockHqLensId" class="form-control select2"
                                    style="width: 100%;">
                                    <option disabled='disabled' selected="selected">
                                        Select Lens Code
                                    </option>
                                    @forelse ($organization->hq_lens()->latest()->get() as $lens_stock)
                                        <option value="{{ $lens_stock->id }}">
                                            Lens Code: {{ $lens_stock->code }} -
                                            Lens Type: {{ $lens_stock->lens_type->type }} -
                                            Lens Material: {{ $lens_stock->lens_material->title }}
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
                                <label for="addCaseStockOpening">
                                    Opening Stock
                                </label>
                                <input type="number" id="addCaseStockOpening" name="opening"
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
