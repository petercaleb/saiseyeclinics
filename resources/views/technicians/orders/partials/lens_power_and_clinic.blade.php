<div class="col-md-3">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                Lens Power
            </h3>

            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                        class="fa fa-minus"></i>
                </button>
            </div>
        </div>
        <div class="card-body table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <td></td>
                        <td>Right Eye</td>
                        <td>Left Eye</td>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Sphere</td>
                        <td>{{ $order->lens_power->right_sphere }}</td>
                        <td>{{ $order->lens_power->left_sphere }}</td>
                    </tr>
                    <tr>
                        <td>Cylinder</td>
                        <td>{{ $order->lens_power->right_cylinder }}</td>
                        <td>{{ $order->lens_power->left_cylinder }}</td>
                    </tr>
                    <tr>
                        <td>Axis</td>
                        <td>{{ $order->lens_power->right_axis }}</td>
                        <td>{{ $order->lens_power->left_axis }}</td>
                    </tr>
                    <tr>
                        <td>Additional</td>
                        <td>{{ $order->lens_power->right_add }}</td>
                        <td>{{ $order->lens_power->left_add }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <!-- /.card-body -->
    </div>
    <!--.card -->

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                From Clinic
            </h3>

            <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                        class="fa fa-minus"></i>
                </button>
            </div>
        </div>

        <div class="card-body table-responsive">
            <strong><i class="fa fa-industry mr-1"></i> Clinic Name</strong>

            <p class="text-muted">
                {{ $order->clinic->clinic }}
            </p>

            <hr>

            <strong><i class="fa fa-mobile-phone mr-1"></i> Phone Number</strong>

            <p class="text-muted">
                {{ $order->clinic->phone }}
            </p>

            <hr>

            <strong><i class="fa fa-envelope mr-1"></i> Email Address</strong>

            <p class="text-muted">
                {{ $order->clinic->email }}
            </p>

        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->
</div>
<!--.col-md-3 -->