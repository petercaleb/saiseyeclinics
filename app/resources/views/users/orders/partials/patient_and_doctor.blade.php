<div class="col-md-3">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                Order For Patient
            </h3>

            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                        class="fa fa-minus"></i>
                </button>
            </div>
        </div>

        <div class="card-body p-0">
            <ul class="nav nav-pills flex-column">
                <li class="nav-item active">
                    <a href="#" class="nav-link">
                        <i class="fa fa-user"></i> {{ $order->patient->first_name }}
                        {{ $order->patient->last_name }}
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="fa fa-phone"></i> {{ $order->patient->phone }}
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="fa fa-envelope"></i> {{ $order->patient->email }}
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="fa fa-calendar"></i> {{ $order->patient->dob }}
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="fa fa-male"></i> {{ $order->patient->gender }}
                    </a>
                </li>

                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="fa fa-map-signs"></i> {{ $order->patient->address }}
                    </a>
                </li>
            </ul>
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Doctor/ Optimetrist</h3>

            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                        class="fa fa-minus"></i>
                </button>
            </div>
        </div>
        <div class="card-body p-0">
            <ul class="nav nav-pills flex-column">
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="fa fa-user text-danger"></i>
                        {{ $order->user->first_name }}
                        {{ $order->user->last_name }}
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="fa fa-phone text-warning"></i> {{ $order->user->phone }}
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="fa fa-envelope text-primary"></i>
                        {{ $order->user->email }}
                    </a>
                </li>
            </ul>
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->

</div>
<!-- /.col -->