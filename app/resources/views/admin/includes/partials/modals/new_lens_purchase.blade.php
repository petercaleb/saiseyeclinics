<div class="modal fade" id="newLensPurchasesModal">
    <div class="modal-dialog modal-lg" role="dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">
                    New Lens Purchase
                </h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="newLensPurchasesForm" role="form">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="newLensPurchasesLens">Lens</label>
                                <select id="newLensPurchasesLens" name="lens_id"
                                    class="form-control select2 select2-primary"
                                    data-dropdown-css-class="select2-primary" style="width: 100%;">
                                    <option disabled="disabled" selected="selected">Choose Lens</option>
                                    @forelse ($organization->hq_lens()->latest()->get() as $lens)
                                        <option value="{{ $lens->id }}">
                                            {{ $lens->code }} : {{ $lens->power }} :
                                            {{ $lens->lens_type->type }} : {{ $lens->lens_material->title }} :
                                            {{ $lens->eye }}
                                        </option>
                                    @empty
                                        <option disabled>No Lens Found</option>
                                    @endforelse

                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="newLensPurchasesVendor">
                                    Vendor
                                </label>
                                <select id="newLensPurchasesVendor" name="vendor_id"
                                    class="form-control select2 select2-primary"
                                    data-dropdown-css-class="select2-primary" style="width: 100%;">
                                    <option disabled="disabled" selected="selected">Choose Vendor</option>
                                    @forelse ($organization->vendor()->latest()->get() as $vendor)
                                        <option value="{{ $vendor->id }}">
                                            {{ $vendor->first_name }} {{ $vendor->last_name }} -
                                            {{ $vendor->company }}
                                        </option>
                                    @empty
                                        <option disabled>No Vendors Found</option>
                                    @endforelse

                                </select>
                            </div>
                            <!-- /.form-group -->
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="newLensPurchasesReceiptNumber">
                                    Receipt Number
                                </label>
                                <input type="text" id="newLensPurchasesReceiptNumber" name="receipt_number"
                                    placeholder="Enter Receipt Number" class="form-control">
                            </div>
                            <!-- /.form-group -->
                        </div>
                        <div class="col-md-6">
                            <label for="newLensPurchasesReceipt">Receipt</label>
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" name="attachment" class="custom-file-input"
                                        id="newLensPurchasesReceipt">
                                    <label class="custom-file-label" for="newLensPurchasesReceipt">Attach
                                        Receipt</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="newLensPurchasesDate">
                                    Purchased Date
                                </label>
                                <input type="text" id="newLensPurchasesDate" name="purchase_date"
                                    placeholder="Enter Date Purchased" class="form-control datepicker">
                            </div>
                            <!-- /.form-group -->
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="newLensPurchasesQuantity">Units</label>
                                <input type="text" class="form-control" name="quantity" id="newLensPurchasesQuantity"
                                    placeholder="Enter Units">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="newLensPurchasesPrice">Price</label>
                                <input type="text" class="form-control" name="price" id="newLensPurchasesPrice"
                                    placeholder="Enter Stock Price">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" id="newLensPurchasesSubmitBtn" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
