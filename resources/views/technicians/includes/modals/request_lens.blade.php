<div class="modal fade" id="requestLensModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Request Lens</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="requestLensForm" role="form">
                <div class="modal-body">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <label for="requestLensHQLensID">Lens Code</label>
                            <select id="requestLensHQLensID" name="hq_lens_id" class="select2" data-placeholder="Select frame"
                                style="width: 100%;">
                                <option selected="selected" disabled="disabled">
                                    Select Lens 
                                </option>
                                @forelse ($organization->hq_lens()->latest()->get() as $lens_stock)
                                    <option value="{{ $lens_stock->id }}">
                                        Lens Code: {{ $lens_stock->code }} -
                                        Lens Power: {{ $lens_stock->power }} -
                                        Lens Index: {{ $lens_stock->lens_index }} -
                                        Eye: {{ $lens_stock->eye }} 
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
                                <label for="requestLensDate">
                                    Requested Date
                                </label>
                                <input type="text" id="requestLensDate" name="request_date"
                                    class="form-control datepicker" placeholder="Request date" />
                            </div>
                            <!-- /.form-group -->
                        </div>
                        <!-- /.col-md-6 -->
                    </div>
                    <!-- /.row -->

                    <div class="row">
                        <div class="col-md-12">
                            <label for="requestLensQuantity">Quantity</label>
                            <input type="number" id="requestLensQuantity" name="quantity" class="form-control"
                                placeholder="Quantity" />
                        </div>
                        <!-- /.col-md-6 -->
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="requestLensRemarks">Remarks</label>
                                <textarea id="requestLensRemarks" name="remarks" class="form-control" rows="3" placeholder="Enter your remarks ..."></textarea>
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
