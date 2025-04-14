<!-- Frame Stocks Modal -->
<div class="modal fade" id="updateFrameStockModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Update Frame Stock</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="updateFrameStockForm">
                <div class="modal-body">
                    @csrf
                    <div class="row">
                        <div class="col-12">
                            <input type="hidden" id="updateFrameStockId" name="frame_stock_id"
                                    class="form-control" />
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="updateFrameStockCode">Frame Code</label>
                                <select name="hq_stock_id" id="updateFrameStockCode" class="form-control select2"
                                    style="width: 100%;">
                                    <option disabled='disabled' selected="selected">
                                        Choose Frame Code
                                    </option>
                                    @forelse ($organization->hq_frame_stock()->latest()->get() as $clinic_frame)
                                        <option value="{{ $clinic_frame->id }}">
                                            {{ $clinic_frame->frame->code }} -
                                            {{ $clinic_frame->frame->frame_brand->title }}
                                        </option>
                                    @empty
                                        <option disabled="disabled">No Frame Code Found..</option>
                                    @endforelse
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="updateFrameStockOpeningStock">
                                    Opening Stock
                                </label>
                                <input type="number" id="updateFrameStockOpeningStock" name="opening"
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
                                <label for="updateFrameStockRemarks">
                                    Remarks
                                </label>
                                <textarea id="updateFrameStockRemarks" name="remarks" class="form-control" placeholder="Enter Remarks"></textarea>
                            </div>
                            <!-- /.form-group -->
                        </div>
                        <!-- /.col-md-12 -->
                    </div>
                    <!-- /.row -->
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">
                        Close
                    </button>
                    <button type="submit" id="updateFrameStockSubmitBtn" class="btn btn-primary">
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
