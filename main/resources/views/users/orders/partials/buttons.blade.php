<div class="row">
    @if (Auth::user()->id == $order->user_id)
        <div class="col-md-6">
            @if ($order->status == 'APPROVED')
                <button type="button" id="sendOrderToWorkshopBtn" data-id="{{ $order->id }}"
                    data-value="SENT TO WORKSHOP" class="btn btn-block btn-sm btn-success orderSentToWorkshopBtn">
                    ORDER SENT TO WORKSHOP
                </button>
            @elseif($order->status == 'SENT TO WORKSHOP')
                <button type="button" data-id="{{ $order->id }}" data-value="FRAME SENT TO WORKSHOP"
                    id="sendFrameSentToWorkshopBtn"
                    class="btn btn-block btn-sm btn-primary orderfRAMESentToWorkshopBtn">
                    FRAME SENT TO WORKSHOP
                </button>
            @elseif($order->status == 'SEND TO CLINIC')
                <button type="button" data-id="{{ $order->id }}" data-value="RECEIVED FROM WORKSHOP"
                    id="receivedFromWorkshopBtn" class="btn btn-block btn-sm btn-primary receivedFromWorkshopBtn">
                    RECEIVED FROM WORKSHOP
                </button>
            @elseif($order->status == 'RECEIVED FROM WORKSHOP')
                <button type="button" data-id="{{ $order->id }}" data-value="CALL FOR COLLECTION"
                    id="callForCollectionBtn" class="btn btn-sm btn-block btn-primary callForCollectionBtn">
                    CALL FOR COLLECTION
                </button>
            @elseif($order->status == 'CALL FOR COLLECTION')
                <button type="button" data-id="{{ $order->id }}" data-value="FRAME COLLECTED" id="frameCollectedBtn"
                    class="btn btn-block btn-sm btn-primary frameCollectedBtn">
                    FRAME COLLECTED
                </button>
            @elseif($order->status == 'FRAME COLLECTED')
                <button type="button" data-id="{{ $order->id }}" data-value="CLOSED" id="closedBtn"
                    class="btn btn-block btn-sm btn-success closedBtn">
                    CLOSED
                </button>
            @endif
        </div>
    @endif

    <div class="col-md-6">
        <button id="trackOrderBtn" class="btn btn-sm btn-secondary btn-block">Track Order</button>
    </div>
</div>
