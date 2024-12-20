<div class="col-md-3">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                Order Details
            </h3>
        </div>

        <div class="card-body">

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

        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                Workshop and Technician
            </h3>
        </div>

        <div class="card-body table-responsive">

            <strong><i class="fas fa-building mr-1"></i> Workshop</strong>

            <p class="text-muted">
                {{ $order->workshop->name }} - {{ $order->workshop->phone }}
            </p>
            <hr>
            <strong><i class="fas fa-user-cog mr-1"></i> Technician</strong>

            <p class="text-muted">
                @if ($order->technician)
                    {{ $order->technician->first_name }}  {{ $order->technician->last_name }}
                    <br>
                    {{ $order->technician->phone }}
                @endif
            </p>
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->
</div><!-- /.col -->
