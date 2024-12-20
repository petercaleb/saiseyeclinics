 <!-- Frame Stocks Modal -->
 <div class="modal fade" id="addCaseStockModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Add Case Stock</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="addCaseStockForm">
                <div class="modal-body">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="addCaseStockHQStockId">Case Code</label>
                                <select name="hq_stock_id" id="addCaseStockHQStockId" class="form-control select2"
                                    style="width: 100%;">
                                    <option disabled='disabled' selected="selected">
                                        Select Case Code
                                    </option>
                                    @forelse ($organization->hq_case_stock()->latest()->get() as $case_stock)
                                        <option value="{{ $case_stock->id }}">
                                            {{ $case_stock->frame_case->code }} -
                                            {{ $case_stock->frame_case->case_color->title }} -
                                            {{ $case_stock->frame_case->case_shape->title }} - 
                                            {{ $case_stock->frame_case->case_size->title }}
                                        </option>
                                    @empty
                                        <option disabled="disabled">No Case Code Found..</option>
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

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="addCaseStockRemarks"> Remarks </label>
                                <textarea name="remarks" id="addCaseStockRemarks" class="form-control"
                                    placeholder="Enter Remarks"></textarea>
                            </div>
                        </div>
                    </div>
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
