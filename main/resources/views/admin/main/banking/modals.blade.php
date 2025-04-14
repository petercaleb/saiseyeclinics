<div class="modal fade" id="newBankingModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">
                    New Received Payments
                </h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="newBankingForm">
                <div class="modal-body">
                    @csrf
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="newBankingTransactionCode">
                                    Transaction code
                                </label>
                                <input type="text" name="transaction_code" class="form-control"
                                    id="newBankingTransactionCode" placeholder="Transaction Code">
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="newBankingTransactionMode">Transaction Mode</label>
                                <select name="transaction_mode" class="form-control select2" style="width: 100%;">
                                    <option disabled="disabled" selected="selected">Select Transaction Mode</option>
                                    @foreach (\TransactionModes::toArray() as $key => $value)
                                        <option value="{{ $key }}">
                                            {{ $value }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <!-- /.form-group -->
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label for="newBankingInsurance">
                                    Insurance
                                </label>
                                <select name="insurance_id" id="newBankingInsurance" class="form-control select2"
                                    style="width: 100%;">
                                    <option disabled="disabled" selected="selected">
                                        Select Insurance
                                    </option>
                                    @forelse ($insuranceData as $insurance)
                                        <option value="{{ $insurance->id }}">
                                            {{ $insurance->title }}
                                        </option>
                                    @empty
                                    @endforelse
                                </select>
                            </div>
                            <!-- /.form-group -->
                        </div>

                        <div class="col-12 col-md-6">
                            <div class="form-group">
                                <label>Date Received:</label>
                                <input type="text" name="date_received" id="date_received" placeholder="Enter Date Date" class="form-control datepicker">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-md-4">
                            <div class="form-group">
                                <label for="newBankingAgreedAmount">Amount</label>
                                <input type="text" name="paid" class="form-control" id="newBankingAgreedAmount"
                                    placeholder="Amount" disabled>
                            </div>
                        </div>
                        <div class="col-12 col-md-4">
                            <div class="form-group">
                                <label for="newBankingPaid">Paid Amount</label>
                                <input type="text" name="paid" class="form-control" id="newBankingPaid"
                                    placeholder="Paid Amount">
                            </div>
                        </div>
                        <div class="col-md-4 col-12">
                            <div class="form-group">
                                <label for="newBankingStatus">Payment Status</label>
                                <select id="newBankingStatus" name="status" class="form-control select2"
                                    style="width: 100%;">
                                    <option disabled="disabled" selected="selected">Select Payment Status</option>
                                    @foreach (\BankingStatus::toArray() as $key => $value)
                                        <option value="{{ $key }}">
                                            {{ $value }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <!-- /.form-group -->
                        </div>
                    </div>
                    <!--/.row -->
                    <div class="row">
                        <div class="col-12">
                            <!-- textarea -->
                            <div class="form-group">
                                <label for="newBankingNotes">Notes</label>
                                <textarea id="newBankingNotes" name="notes" class="form-control" rows="3" placeholder="Enter Notes"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
