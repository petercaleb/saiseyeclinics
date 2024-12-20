<!-- Purchase Stock -->
<div class="modal fade" id="newCasePurchaseModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">
                    Purchase Stock
                </h4>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="newCasePurchaseForm">
                <div class="modal-body">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="purchasedStockId">Case Stock Code</label>
                                <select name="stock_id" id="purchasedStockId" class="form-control select2"
                                    style="width: 100%;">
                                    <option disabled='disabled' selected="selected">
                                        Choose from available stocks Stock
                                    </option>
                                    @forelse ($organization->hq_case_stock()->latest()->get() as $case_stock)
                                        <option value="{{ $case_stock->id }}">
                                            {{ $case_stock->frame_case->code }} -
                                            {{ $case_stock->frame_case->case_color->title }} - {{ $case_stock->frame_case->case_shape->title }} -
                                            {{ $case_stock->frame_case->case_size->title }}
                                        </option>
                                    @empty
                                        <option disabled="disabled">No Stocks Available</option>
                                        <option>
                                            <a href="#" class="btn btn-link">
                                                <i class="fa fa-plus"></i> Add Stock
                                            </a>
                                        </option>
                                    @endforelse
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="purchasedStockDate">
                                    Purchase Date
                                </label>
                                <input type="text" id="purchasedStockDate" name="purchase_date"
                                    class="form-control datepicker" placeholder="Purchased Date" />
                            </div>
                            <!-- /.form-group -->
                        </div>
                    </div>
                    <!-- /.row -->

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="purchasedStockReceiptNumber">
                                    Receipt Number
                                </label>
                                <input type="text" id="purchasedStockReceiptNumber" name="receipt_number"
                                    class="form-control" placeholder="Receipt Number" />
                            </div>
                            <!-- /.form-group -->
                        </div>
                        <div class="col-md-6">
                            <label for="purchasedStockReceipt">Receipt</label>
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" name="attachment" class="custom-file-input"
                                        id="purchasedStockReceipt">
                                    <label class="custom-file-label" for="purchasedStockReceipt">Attach
                                        Receipt</label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--.row -->

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="purchasedStockUnits">
                                    Units
                                </label>
                                <input type="number" id="purchasedStockUnits" name="quantity"
                                    class="form-control" placeholder="Number of units purchased" />
                            </div>
                            <!-- /.form-group -->
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="purchasedStockPrice">
                                    Price
                                </label>
                                <input type="number" id="purchasedStockPrice" name="price"
                                    class="form-control" placeholder="Price per unit" />
                            </div>
                            <!-- /.form-group -->
                        </div>

                        <div class="col-md-4">

                            <div class="form-group">
                                <label for="purchasedStockVendorId">Supplier</label>
                                <select name="vendor_id" id="purchasedStockVendorId" class="form-control select2"
                                    style="width: 100%;">
                                    <option disabled='disabled' selected="selected">
                                        Select supplier
                                    </option>
                                    @forelse ($organization->vendor()->latest()->get() as $vendor)
                                        <option value="{{ $vendor->id }}">
                                            {{ $vendor->first_name }} {{ $vendor->last_name }}
                                        </option>
                                    @empty
                                        <option disabled="disabled">No Vendor Available</option>
                                        <option>
                                            <a href="#" class="btn btn-link">
                                                <i class="fa fa-plus"></i> Add Stock
                                            </a>
                                        </option>
                                    @endforelse
                                </select>
                            </div>
                        </div>
                    </div>
                    <!--.row -->
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">
                        Close
                    </button>
                    <button type="submit" id="purchasedStockSubmitBtn" class="btn btn-primary">
                        Save
                    </button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!--.modal -->