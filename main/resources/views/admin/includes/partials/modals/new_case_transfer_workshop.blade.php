<!-- Transfer Stock -->
<div class="modal fade" id="newHqCaseTransferWorkshopModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">
                    Transfer Cases To Workshop
                </h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="newHqCaseTransferWorkshopForm">
                <div class="modal-body">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="newHqCaseTransferWorkshopStockId">case Code</label>
                                <select name="stock_id" id="newHqCaseTransferWorkshopStockId" class="form-control select2">
                                    <option disabled selected>Select stock</option>
                                    @forelse ($organization->hq_case_stock()->latest()->get() as $transfer_stock)
                                        <option value="{{ $transfer_stock->id }}">
                                            {{ $transfer_stock->frame_case->code }} -
                                            {{ $transfer_stock->frame_case->case_color->title }} - 
                                            {{ $transfer_stock->frame_case->case_shape->title }} -
                                            {{ $transfer_stock->frame_case->case_size->title }}
                                        </option>
                                    @empty
                                    @endforelse
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="newHqCaseTransferWorkshopToWorkshopId">Transfer To </label>
                                <select name="to_workshop_id" id="newHqCaseTransferWorkshopToWorkshopId"
                                    class="form-control select2" style="width: 100%;">
                                    <option disabled='disabled' selected="selected">
                                        Select workshop to transfer to
                                    </option>
                                    @forelse ($organization->workshop()->latest()->get() as $transfer_workshop)
                                        <option value="{{ $transfer_workshop->id }}">
                                            {{ $transfer_workshop->name }}
                                        </option>
                                    @empty
                                        <option disabled="disabled">No Workshops available at the moment</option>
                                    @endforelse
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="newHqCaseTransferWorkshopTransferDate">
                                    Transfer Date
                                </label>
                                <input type="text" id="newHqCaseTransferWorkshopTransferDate" name="transfer_date"
                                    class="form-control datepicker" placeholder="Transfer Date" />
                            </div>
                            <!-- /.form-group -->
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="newHqCaseTransferWorkshopQuantity">
                                    Quantity
                                </label>
                                <input type="text" id="newHqCaseTransferWorkshopQuantity" name="quantity"
                                    class="form-control" placeholder="Quantity Transfered" />
                            </div>
                            <!-- /.form-group -->
                        </div>
                    </div>
                    <!--.row -->

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="newHqCaseTransferWorkshopStatus">
                                    Transfer Status
                                </label>
                                <select name="transfer_status" id="newHqCaseTransferWorkshopStatus"
                                    class="form-control select2">
                                    <option disabled='disabled' selected="selected">Transfer Status</option>
                                    <option value="1">Transfered</option>
                                    <option value="0">Not Transfered</option>
                                </select>
                            </div>
                            <!-- /.form-group -->
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="newHqCaseTransferWorkshopCondition">
                                    Stock Condition
                                </label>
                                <select name="condition" id="newHqCaseTransferWorkshopCondition"
                                    class="form-control select2">
                                    <option disabled='disabled' selected="selected">Transfered Stock Condition
                                    </option>
                                    <option value="Broken">Broken</option>
                                    <option value="Irrepairable">Irrepairable</option>
                                    <option value="Working">Working</option>
                                </select>
                            </div>
                            <!-- /.form-group -->
                        </div>
                    </div>
                    <!--.row -->

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="newHqCaseTransferWorkshopRemarks">
                                    Remarks
                                </label>
                                <textarea name="remarks" id="newHqCaseTransferWorkshopRemarks" class="form-control" placeholder="Remarks"></textarea>
                            </div>
                            <!-- /.form-group -->
                        </div>
                    </div>
                    <!--.row -->
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">
                        Close
                    </button>
                    <button type="submit" class="btn btn-primary">
                        Transfer
                    </button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!--.modal -->
