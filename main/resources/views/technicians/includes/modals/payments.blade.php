<div class="modal fade" id="paymentsBillModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">
                    Payments Made On The Order
                </h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body table-responsive">
                <div class="row">
                    <div class="col-md-12">
                        <strong>
                            <i class="fa fa-bar-chart mr-1"></i> Invoice Number
                        </strong>

                        <p class="text-muted">
                            {{ $order->payment_bill->invoice_number }}
                        </p>

                        <hr>

                        <strong><i class="fa fa-cogs mr-1"></i> Bill Status</strong>

                        <p class="text-muted">{{ $order->payment_bill->bill_status }}</p>

                        <hr>

                        <strong><i class="fa fa-money mr-1"></i> Consultation Fee</strong>

                        <p class="text-muted">
                            <span class="tag tag-success">
                                {{ number_format($order->payment_bill->consultation_fee, 2, '.', ',') }}
                            </span>
                        </p>

                        <hr>

                        <strong><i class="fa fa-money mr-1"></i> Agreed Amount</strong>

                        <p class="text-muted">
                            <span class="tag tag-success">
                                {{ number_format($order->payment_bill->agreed_amount, 2, '.', ',') }}
                            </span>
                        </p>

                        <hr>

                        <strong><i class="fa fa-money mr-1"></i> Total Amount </strong>

                        <p class="text-muted">
                            <span class="tag tag-success">
                                {{ number_format($order->payment_bill->total_amount, 2, '.', ',') }}
                            </span>
                        </p>

                        <hr>

                        <strong><i class="fa fa-money mr-1"></i> Paid Amount </strong>

                        <p class="text-muted">
                            <span class="tag tag-success">
                                {{ number_format($order->payment_bill->paid_amount, 2, '.', ',') }}
                            </span>
                        </p>

                        <hr>

                        <strong><i class="fa fa-money mr-1"></i> Balance </strong>

                        <p class="text-muted">
                            <span class="tag tag-success">
                                {{ number_format($order->payment_bill->balance, 2, '.', ',') }}
                            </span>
                        </p>
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">
                    Close
                </button>
            </div>

        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->
