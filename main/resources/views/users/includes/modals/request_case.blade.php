<div class="modal fade" id="requestCaseModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Request Case</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="requestCaseForm" role="form">
                <div class="modal-body">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <label for="requestCaseHQStockID">Case Code</label>
                            <select id="requestCaseHQStockID" name="hq_case_stock_id" class="select2" data-placeholder="Select frame"
                                style="width: 100%;">
                                <option selected="selected" disabled="disabled">
                                    Select case 
                                </option>
                                @forelse ($organization->hq_case_stock()->latest()->get() as $case_stock)
                                    <option value="{{ $case_stock->id }}">
                                        Case Code: {{ $case_stock->frame_case->code }} -
                                        Case Color: {{ $case_stock->frame_case->case_color->title }} -
                                        Case Shape: {{ $case_stock->frame_case->case_shape->title }} -
                                        Case Size: {{ $case_stock->frame_case->case_size->title }} 
                                    </option>
                                @empty
                                    <option disabled="disabled">
                                        No Cases Found
                                    </option>
                                @endforelse
                            </select>
                        </div>
                        <!-- /.col-md-6 -->

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="requestCaseDate">
                                    Requested Date
                                </label>
                                <input type="text" id="requestCaseDate" name="request_date"
                                    class="form-control datepicker" placeholder="Request date" />
                            </div>
                            <!-- /.form-group -->
                        </div>
                        <!-- /.col-md-6 -->
                    </div>
                    <!-- /.row -->

                    <div class="row">
                        <div class="col-md-12">
                            <label for="requestCaseQuantity">Quantity</label>
                            <input type="number" id="requestCaseQuantity" name="quantity" class="form-control"
                                placeholder="Quantity" />
                        </div>
                        <!-- /.col-md-6 -->
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="requestCaseRemarks">Remarks</label>
                                <textarea id="requestCaseRemarks" name="remarks" class="form-control" rows="3" placeholder="Enter your remarks ..."></textarea>
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
