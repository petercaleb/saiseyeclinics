<div class="modal fade" id="addPaymentsModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Payment Bills</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="addPaymentsForm" role="form">
                <div class="modal-body">
                    @csrf
                    <div class="form-group">
                        <input type="hidden" class="form-control" id="addPaymentsBillId" name="bill_id" />
                    </div>
                    <div class="form-group">
                        <label for="addPaymentsItem">Item</label>
                        <select name="item" id="addPaymentsItem" class="form-control select2">
                            <option disabled selected>Enter the item name</option>
                            <option value="SERVICE FEE">SERVICE FEE</option>
                            <option value="DEPOSIT ONE">DEPOSIT ONE</option>
                            <option value="DEPOSIT TWO">DEPOSIT TWO</option>
                            <option value="BALANCE">BALANCE</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="addPaymentsAmount">Payment Amount</label>
                        <input type="text" class="form-control" id="addPaymentsAmount" name="amount"
                            placeholder="Enter the amount paid" />
                    </div>
                    <div class="form-group">
                        <label for="addPaymentsReceipt">Receipt Number</label>
                        <input type="text" class="form-control" id="addPaymentsReceipt" name="receipt"
                            placeholder="Enter the receipt number" />
                    </div>

                    <div class="form-group">
                        <label for="addPaymentsDate">Paid Date</label>
                        <input type="text" class="form-control datepicker" id="addPaymentsDate" name="date"
                            placeholder="Enter the paid date" />
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">
                        Close
                    </button>
                    <button type="submit" id="addPaymentsSubmitBtn" class="btn btn-primary">
                        Add Payment
                    </button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<div class="modal fade" id="enterAgreedAmountModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Payment Bills</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="enterAgreedAmountForm" role="form">
                <div class="modal-body">
                    @csrf
                    <div class="form-group">
                        <input type="hidden" class="form-control" id="enterAgreedAmountBillId" name="bill_id" />
                    </div>
                    <div class="form-group">
                        <label for="enterAgreedAmount">Agreed/Rejected Amount</label>
                        <input type="text" class="form-control" id="enterAgreedAmount" name="amount"
                            placeholder="Enter the agreed amount" value="{{ $payment_bill->claimed_amount }}" />
                    </div>
                    @if ($payment_bill->payment_detail->insurance)
                        <div class="form-group">
                            <label for="enterAgreedApprovalStatus">Approval Status</label>
                            <select id="enterAgreedApprovalStatus" name="approval_status" class="form-control select2"
                                style="width: 100%;">
                                <option selected="selected" disabled="disabled">Choose the approval status
                                </option>
                                <option value="APPROVED">APPROVED</option>
                                <option value="REJECTED">REJECTED</option>
                            </select>
                        </div>

                        <div class="form-group approvalCard">
                            <label for="enterAgreedApprovalCode">Approval Number</label>
                            <input type="text" class="form-control" id="enterAgreedApprovalCode"
                                name="approval_number" placeholder="Enter the approval number">
                        </div>
                    @endif

                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">
                        Close
                    </button>
                    <button type="submit" id="enterAgreedAmountSubmitBtn" class="btn btn-primary">
                        Enter
                    </button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<div class="modal fade" id="rejectedInsuranceModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Enter Consultation Fee</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="rejectedInsuranceForm" role="form">
                <div class="modal-body">
                    @csrf
                    <div class="form-group">
                        <input type="hidden" class="form-control" id="rejectedInsuranceBillId" name="bill_id" />
                    </div>
                    <div class="form-group">
                        <label for="rejectedInsuranceConsultationFee">Consultation Fee</label>
                        <input type="text" class="form-control" id="rejectedInsuranceConsultationFee"
                            name="consultation_fee" placeholder="Enter the consultation">
                    </div>

                    <div class="form-group">
                        <label for="rejectedInsuranceConsultationReceipt">Consultation Receipt Number</label>
                        <input type="text" class="form-control" id="rejectedInsuranceConsultationReceipt"
                            name="consultation_receipt" placeholder="Enter the consultation">
                    </div>

                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">
                        Close
                    </button>
                    <button type="submit" id="rejectedInsuranceSubmitBtn" class="btn btn-primary">
                        Update
                    </button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
