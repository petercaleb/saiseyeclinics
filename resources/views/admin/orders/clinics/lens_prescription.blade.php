<div class="table-responsive">
    <table class="table table-bordered">
        <tbody>
            <tr>
                <th>Lens Type</th>
                <td>
                    {{ $order->lens_prescription->lens_type->type }}
                </td>
            </tr>
            <tr>
                <th>Lens Material</th>
                <td>
                    {{ $order->lens_prescription->lens_material->title }}
                </td>
            </tr>
            <tr>
                <th>Lens Index/Thickness</th>
                <td>
                    {{ $order->lens_prescription->index }}
                </td>
            </tr>
            <tr>
                <th>Tint</th>
                <td>
                    {{ $order->lens_prescription->tint }}
                </td>
            </tr>
            <tr>
                <th>Diameter</th>
                <td>
                    {{ $order->lens_prescription->diameter }}
                </td>
            </tr>
            <tr>
                <th>Focal Height</th>
                <td>
                    {{ $order->lens_prescription->focal_height }}
                </td>
            </tr>

        </tbody>
    </table>
</div>