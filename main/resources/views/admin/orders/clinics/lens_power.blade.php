<div class="table-responsive">
    <table class="table table-bordered">
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
