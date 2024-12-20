<!-- Transfer Stock -->
<div class="modal fade" id="newLensTransferModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">
                    Transfer Lens
                </h4>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="newLensTransferForm">
                <div class="modal-body">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="newLensTransferLensCode">Lens Code</label>
                                <select name="lens_id" id="newLensTransferLensCode" class="form-control select2">
                                    <option disabled selected>Choose Lens</option>
                                    @forelse ($organization->hq_lens()->latest()->get() as $lens)
                                        <option value="{{ $lens->id }}">
                                            {{ $lens->code }} -
                                            {{ $lens->power }} -
                                            {{ $lens->eye }} 
                                        </option>
                                    @empty
                                    @endforelse
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="newLensTransferWorkshopId">Transfer To</label>
                                <select name="to_workshop_id" id="newLensTransferWorkshopId"
                                    class="form-control select2" style="width: 100%;">
                                    <option disabled='disabled' selected="selected">
                                        Choose workshop to transfer to
                                    </option>
                                    @forelse ($organization->workshop()->latest()->get() as $transfer_workshop)
                                        <option value="{{ $transfer_workshop->id }}">
                                            {{ $transfer_workshop->name }}
                                        </option>
                                    @empty
                                        <option disabled="disabled">No Workshop available at the moment</option>
                                    @endforelse
                                </select>
                            </div>
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="newLensTransferDate">
                                    Transfer Date
                                </label>
                                <input type="text" id="newLensTransferDate" name="transfered_date"
                                    class="form-control datepicker" placeholder="Transfer Date" />
                            </div>
                            <!-- /.form-group -->
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="newLensTransferQuantity">
                                    Quantity
                                </label>
                                <input type="text" id="newLensTransferQuantity" name="quantity"
                                    class="form-control" placeholder="Quantity Transfered" />
                            </div>
                            <!-- /.form-group -->
                        </div>
                    </div>
                    <!--.row -->

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="newLensTransferStatus">
                                    Transfer Status
                                </label>
                                <select name="transfer_status" id="newLensTransferStatus"
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
                                <label for="newLensTransferCondition">
                                    Stock Condition
                                </label>
                                <select name="condition" id="newLensTransferCondition"
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
