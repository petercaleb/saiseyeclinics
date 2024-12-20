<div>
    <strong><i class="fa fa-calendar mr-1"></i> Date</strong>

    <p class="text-muted">
        {{ date('d, F, Y', strtotime($order->order_date)) }}
    </p>

    <hr>

    <strong><i class="fa fa-sticky-note mr-1"></i> Order Receipt</strong>

    <p class="text-muted">
        {{ $order->receipt_number }}
    </p>

    <hr>

    <strong><i class="fa fa-cog mr-1"></i> Status</strong>

    <p class="text-muted">
        {{ $order->status }}
    </p>

    <hr>

    <strong><i class="fas fa-calendar mr-1"></i> TAT One (Time Difference Frame Sent to
        Workshop and order received from workshop)</strong>

    <p class="text-muted">
        {{ $order->tat_one }}
    </p>

    <hr>

    <strong><i class="fas fa-calendar mr-1"></i> TAT Two (Time Difference Order Received
        from Workshop and Patient collection)</strong>

    <p class="text-muted">
        {{ $order->tat_two }}
    </p>
</div>