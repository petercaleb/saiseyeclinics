<div class="modal fade" id="openBillModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">
                    Open Bill
                </h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="openBillForm">
                <div class="modal-body">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <input type="hidden" class="form-control" id="openBillScheduleId" name="schedule_id" />
                            </div>
                        </div>
                        <!--.col-md-12-->
                    </div>
                    <!--.row-->

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="openBillConsultationReceipt">
                                    Consultation Receipt
                                </label>
                                <input type="text" class="form-control" name="consultation_receipt"
                                    id="openBillConsultationReceipt" placeholder="Consultation Receipt">
                            </div>
                        </div>
                        <!--.col-md-6-->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="openBillConsultationFee">
                                    Consultation Fee
                                </label>
                                <input type="text" class="form-control" name="consultation_fee"
                                    id="openBillConsultationFee" placeholder="Consultation Fee">
                            </div>
                        </div>
                        <!--.col-md-6-->
                    </div>
                    <!--.row-->
                    @if ($treatment)
                        @if ($treatment->payments == 'consultation')
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <input type="hidden" value="0" class="form-control" name="claimed_amount"
                                            placeholder="Claimed Amount">
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="openBillClaimedAmount">
                                            Claimed Amount
                                        </label>
                                        <input type="text" class="form-control" name="claimed_amount"
                                            id="openBillClaimedAmount" placeholder="Claimed Amount">
                                    </div>
                                </div>
                            </div>
                            <!--.row-->
                        @endif
                    @endif

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="openBillRemarks">
                                    Remarks
                                </label>
                                <textarea name="remarks" id="openBillRemarks" class="form-control" placeholder="Enter Remarks"></textarea>
                            </div>
                        </div>
                    </div>
                    <!--.row-->

                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" id="openBillSubmitBtn" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
