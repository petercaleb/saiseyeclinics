<div class="modal fade" id="receiveFromHQModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">
                    Receive From HQ
                </h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="receiveFromHQForm">
                <div class="modal-body">
                    @csrf
                    <input type="hidden" value="1" name="is_hq"/>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="receiveFromHQTransferedStock">Transfered Stock</label>
                                <select id="receiveFromHQTransferedStock" name="hq_case_transfer_id" class="select2"
                                    data-placeholder="Select transfered stock you've received" style="width: 100%;">
                                    <option selected="selected" disabled="disabled">
                                        Select transfered stock you've received
                                    </option>
                                    @forelse ($clinic->to_hq_case_transfer()->where('received_status', 0)->latest()->get() as $transfered_stock)
                                        <option value="{{ $transfered_stock->id  }}">
                                            Frame code: {{ $transfered_stock->frame_case->code }} - 
                                            Quantity: {{ $transfered_stock->quantity }}
                                        </option>
                                    @empty
                                        <option disabled="disabled">
                                            No Stock transfered yet
                                        </option>
                                    @endforelse
                                </select>
                            </div>
                            <!-- /.form-group -->
                        </div>
                        <!--/.col -->

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="receiveFromHQReceivedDate">
                                    Received Date
                                </label>
                                <input type="text" id="receiveFromHQReceivedDate" name="receive_date"
                                    class="form-control datepicker" placeholder="Received date" />
                            </div>
                            <!-- /.form-group -->
                        </div>
                    </div>
                    <!-- /.row -->

                    <div class="row">

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="receiveFromHQReceivedStatus">Receive Status</label>
                                <select id="receiveFromHQReceivedStatus" name="received_status" class="select2" data-placeholder="Select a State" style="width: 100%;">
                                    <option value="1">Received</option>
                                    <option value="0">Not Received</option>
                                </select>
                            </div>
                            <!-- /.form-group -->
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="receiveFromHQCondition">Condition</label>
                                <select id="receiveFromHQCondition" name="condition" class="select2" data-placeholder="Select a State" style="width: 100%;">
                                    <option disabled="disabled" selected="selected">Select Frame Stock  Condition...</option>
                                    <option>Broken</option>
                                    <option>Irrepairable</option>
                                    <option>Working</option>
                                </select>
                            </div>
                            <!-- /.form-group -->
                        </div>
                        <!--/.col -->

                    </div>
                    <!--/ .row -->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="receiveFromHQRemarks">Remarks</label>
                                <textarea id="receiveFromHQRemarks" name="remarks" class="form-control" rows="3" placeholder="Enter ..."></textarea>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Receive</button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
