 <!-- /send bill to remittance -->
 <div class="modal fade" id="closeBillModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">
                    CLose This Bill
                </h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="closeBillForm" autocomplete="off">
                <div class="modal-body">
                    @csrf
                    <div class="form-group">
                        <input type="hidden" id="closeBillId" name="bill_id" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="closeBillInvoiceNumber">
                            Invoice Number
                        </label>
                        <input type="text" name="invoice_number" class="form-control"
                            id="closeBillInvoiceNumber" placeholder="Enter Bill Invoice Number">
                    </div>

                    <div class="form-group">
                        <label for="closeBillKRANumber">
                            KRA ETIMS/ VAT Number
                        </label>
                        <input type="text" name="kra_number" class="form-control" id="closeBillKRANumber"
                            placeholder="Enter KRA ETIMS/ VAT Number">
                    </div>

                    <div class="form-group">
                        <label for="closeBillCloseDate">
                            Close Date
                        </label>
                        <input type="text" name="close_date" class="form-control datepicker"
                            id="closeBillCloseDate" placeholder="Remittance Date">
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" id="closeBillSubmitBtn" class="btn btn-primary">
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