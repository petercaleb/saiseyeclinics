<!-- Transfer Stock -->
<div class="modal fade" id="newHqFrameTransferModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">
                    Transfer Stock
                </h4>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="newHqFrameTransferForm">
                <div class="modal-body">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="transferStockFrameCode">Frame Code</label>
                                <select name="stock_id" id="transferStockFrameCode" class="form-control select2">
                                    <option disabled selected>Choose Stock</option>
                                    @forelse ($organization->hq_frame_stock()->latest()->get() as $transfer_stock)
                                        <option value="{{ $transfer_stock->id }}">
                                            {{ $transfer_stock->frame->code }} -
                                            {{ $transfer_stock->gender }} -
                                            {{ $transfer_stock->frame_color->color }} -
                                            {{ $transfer_stock->frame_shape->shape }}
                                        </option>
                                    @empty
                                    @endforelse
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="transferStockClinicId">Transfer To</label>
                                <select name="to_clinic_id" id="transferStockClinicId"
                                    class="form-control select2" style="width: 100%;">
                                    <option disabled='disabled' selected="selected">
                                        Choose clinic to transfer to
                                    </option>
                                    @forelse ($organization->clinic()->latest()->get() as $transfer_clinic)
                                        <option value="{{ $transfer_clinic->id }}">
                                            {{ $transfer_clinic->clinic }}
                                        </option>
                                    @empty
                                        <option disabled="disabled">No Clinics available at the moment</option>
                                    @endforelse
                                </select>
                            </div>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="transferStockDate">
                                    Transfer Date
                                </label>
                                <input type="text" id="transferStockDate" name="transfer_date"
                                    class="form-control datepicker" placeholder="Transfer Date" />
                            </div>
                            <!-- /.form-group -->
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="transferStockQuantity">
                                    Quantity
                                </label>
                                <input type="text" id="transferStockQuantity" name="quantity"
                                    class="form-control" placeholder="Quantity Transfered" />
                            </div>
                            <!-- /.form-group -->
                        </div>
                    </div>
                    <!--.row -->

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="transferStockStatus">
                                    Transfer Status
                                </label>
                                <select name="transfer_status" id="transferStockStatus"
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
                                <label for="transferStockCondition">
                                    Stock Condition
                                </label>
                                <select name="condition" id="transferStockCondition"
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
                                <label for="transferStockRemarks">
                                    Remarks
                                </label>
                                <textarea name="remarks" id="transferStockRemarks" class="form-control" placeholder="Remarks"></textarea>
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
