<!-- /send bill to remittance -->
<div class="modal fade" id="updateKRANumberModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">
                    Update KRA Number
                </h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="updateKRANumberForm">
                <div class="modal-body">
                    @csrf
                    <div class="form-group">
                        <input type="hidden" id="updateKRANumberBillId" name="bill_id" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="updateLPONumber">
                            KRA ETIMS/ VAT Number
                        </label>
                        <input type="text" name="kra_number" class="form-control" id="updateKRANumber"
                            placeholder="Enter KRA Number">
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">
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

<!-- /send bill to remittance -->
<div class="modal fade" id="createRemittanceModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">
                    Claim Remittance
                </h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="createRemittanceForm">
                <div class="modal-body">
                    @csrf
                    <div class="form-group">
                        <input type="hidden" id="createRemittanceBillId" name="bill_id" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="createRemittanceItem">
                            Item
                        </label>
                        <input type="text" name="item" class="form-control" id="createRemittanceItem"
                            placeholder="Can be consultation fee, balance, deposit">
                    </div>

                    <div class="form-group">
                        <label for="createRemittanceAmount">
                            Remittance Amount
                        </label>
                        <input type="number" name="remittance_amount" class="form-control"
                            id="createRemittanceAmount" placeholder="Remittance Amount">
                    </div>

                    <div class="form-group">
                        <label for="createRemittanceDate">
                            Remittance Date
                        </label>
                        <input type="text" name="remittance_date" class="form-control datepicker"
                            id="createRemittanceDate" placeholder="Remittance Date">
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" id="createRemittanceSubmitBtn" class="btn btn-primary">
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

<div class="modal fade" id="addAttachmentModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Add Attachments</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="addAttachmentForm">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <input type="hidden" class="form-control" id="addAttachmentPaymentId" />
                    </div>

                    <div class="form-group">
                        <label for="addAttachmentPaymentTitle">Title</label>
                        <input type="text" class="form-control" name="title" id="addAttachmentPaymentTitle"
                            placeholder="Enter Title">
                    </div>


                    <div class="form-group">
                        <label for="addAttachmentFile">File Name</label>
                        <div class="input-group">
                            <div class="custom-file">
                                <input type="file" name="file" class="custom-file-input"
                                    id="addAttachmentFile">
                                <label class="custom-file-label" for="addAttachmentFile">Choose file</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">
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

<div class="modal fade" id="attachmentsModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">View Payment Attachments</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>File</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($payment_attachments as $attachment)
                                <tr>
                                    <td>
                                        {{ $attachment->title }}
                                    </td>
                                    <td>
                                        <a href="{{ route('users.payments.attachments.open.file', $attachment->id) }}"
                                            target="_blank">
                                            {{ $attachment->file }}
                                        </a>
                                    </td>
                                </tr>
                            @empty
                            @endforelse

                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->