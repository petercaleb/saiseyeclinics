<div class="modal fade" id="requestFrameModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Request Frame</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="requestFrameForm" role="form">
                <div class="modal-body">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <label for="requestFrameHQStockID">Frame Code</label>
                            <select id="requestFrameHQStockID" name="hq_stock_id" class="select2" data-placeholder="Select frame"
                                style="width: 100%;">
                                <option selected="selected" disabled="disabled">
                                    Select frame 
                                </option>
                                @forelse ($organization->hq_frame_stock()->latest()->get() as $frame_stock)
                                    <option value="{{ $frame_stock->id }}">
                                        Frame Code: {{ $frame_stock->code }} -
                                        Frame Brand: {{ $frame_stock->frame->frame_brand->title }}
                                    </option>
                                @empty
                                    <option disabled="disabled">
                                        No Frames Found
                                    </option>
                                @endforelse
                            </select>
                        </div>
                        <!-- /.col-md-6 -->

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="requestFrameDate">
                                    Requested Date
                                </label>
                                <input type="text" id="requestFrameDate" name="request_date"
                                    class="form-control datepicker" placeholder="Request date" />
                            </div>
                            <!-- /.form-group -->
                        </div>
                        <!-- /.col-md-6 -->
                    </div>
                    <!-- /.row -->

                    <div class="row">
                        <div class="col-md-12">
                            <label for="requestFrameQuantity">Quantity</label>
                            <input type="number" id="requestFrameQuantity" name="quantity" class="form-control"
                                placeholder="Quantity" />
                        </div>
                        <!-- /.col-md-6 -->
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="requestFrameRemarks">Remarks</label>
                                <textarea id="requestFrameRemarks" name="remarks" class="form-control" rows="3" placeholder="Enter your remarks ..."></textarea>
                            </div>
                        </div>
                    </div>
                    <!--/.row -->
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Request</button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
