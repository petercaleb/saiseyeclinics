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
                        <td>Rigth Eye</td>
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
    <!-- /.card -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                Workshop
            </h3>

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
                        <i class="fa fa-industry"></i>
                        {{ $order->workshop->name }}
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="fa fa-phone text-warning"></i> {{ $order->workshop->phone }}
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="fa fa-envelope text-primary"></i>
                        {{ $order->workshop->email }}
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
<!-- /.col -->