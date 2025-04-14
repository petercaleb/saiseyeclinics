<div class="row">
    <div class="col-md-4">
        <button type="button" id="trackOrderBtn" class="btn btn-sm btn-secondary btn-block">
            Track Order
        </button>
    </div>

    <div class="col-md-4">
        @if ($order->status == 'FRAME SENT TO WORKSHOP')
            <button type="button" id="orderRceceivedBtn" data-id="{{ $order->id }}" data-value="ORDER RECEIVED"
                class="btn btn-sm btn-block btn-success orderRceceivedBtn">
                ORDER RECEIVED
            </button>
        @elseif ($order->status == 'ORDER RECEIVED')
            @if (Auth::guard('technician')->user()->id == $order->technician_id)
                <button type="button" id="frameRceceivedBtn" data-id="{{ $order->id }}" data-value="FRAME RECEIVED"
                    class="btn btn-sm btn-block btn-success frameRceceivedBtn">
                    FRAME RECEIVED
                </button>
            @endif
        @elseif ($order->status == 'FRAME RECEIVED')
            @if (Auth::guard('technician')->user()->id == $order->technician_id)
                <button type="button" id="glazingBtn" data-id="{{ $order->id }}" data-value="GLAZING"
                    class="btn btn-block btn-sm btn-success glazingBtn">
                    GLAZING
                </button>
            @endif
        @elseif ($order->status == 'GLAZING')
            @if (Auth::guard('technician')->user()->id == $order->technician_id)
                <button type="button" id="rightLensGlazingBtn" data-id="{{ $order->id }}"
                    data-value="RIGHT LENS GLAZING" class="btn btn-block btn-success btn-sm rightLensGlazingBtn">
                    RIGHT LENS GLAZING
                </button>
            @endif
        @elseif ($order->status == 'RIGHT LENS GLAZED')
            @if (Auth::guard('technician')->user()->id == $order->technician_id)
                <button type="button" id="leftLensGlazingBtn" data-id="{{ $order->id }}"
                    data-value="LEFT LENS GLAZING" class="btn btn-block btn-sm btn-success leftLensGlazingBtn">
                    LEFT LENS GLAZING
                </button>
            @endif
        @elseif ($order->status == 'GLAZED')
            @if (Auth::guard('technician')->user()->id == $order->technician_id)
                <button type="button" id="sendToClinicBtn" data-id="{{ $order->id }}" data-value="SEND TO CLINIC"
                    class="btn btn-block btn-success btn-sm sendToClinicBtn">
                    SEND TO CLINIC
                </button>
            @endif
        @endif
    </div>

    <div class="col-md-4">
        <button type="button" id="paymentsBillBtn" class="btn btn-warning btn-sm btn-block">
            Payments Agreed
        </button>
    </div>
</div>
