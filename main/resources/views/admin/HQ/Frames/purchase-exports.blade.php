<table>
    <thead>
        <tr>
            <th style="background-color: #FFFF00; font-size:14px; padding:10px;">
                Purchased Date
            </th>

            <th style="background-color: #FFFF00; font-size:14px; padding:10px;">
                Receipt #
            </th>

            <th style="background-color: #FFFF00; font-size:14px; padding:10px;">
                Frame Code
            </th>

            <th style="background-color: #FFFF00; font-size:14px; padding:10px;">
                Gender
            </th>

            <th style="background-color: #FFFF00; font-size:14px; padding:10px;">
                Color
            </th>

            <th style="background-color: #FFFF00; font-size:14px; padding:10px;">
                Shape
            </th>

            <th style="background-color: #FFFF00; font-size:14px; padding:10px;">
                Units
            </th>

            <th style="background-color: #FFFF00; font-size:14px; padding:10px;">
                Price per unit
            </th>

            <th style="background-color: #FFFF00; font-size:14px; padding:10px;">
                Total price
            </th>

            <th style="background-color: #FFFF00; font-size:14px; padding:10px;">
                Supplier
            </th>

        </tr>
    </thead>
    <tbody>
        @foreach ($data as $report)
            <tr>
                <td>
                    {{ $report->purchase_date }}
                </td>
                <td>
                    {{ $report->receipt_number }}
                </td>
                <td>
                    {{ $report->code }}
                </td>
                <td>
                    {{ $report->gender }}
                </td>
                <td>
                    {{ $report->frame_color->color }}
                </td>
                <td>
                    {{ $report->frame_shape->shape }}
                </td>
                <td>
                    {{ $report->quantity }}
                </td>
                <td>
                    {{ $report->price }}
                </td>
                <td>
                    {{ $report->total }}
                </td>
                <td>
                    {{ $report->vendor->first_name }} {{ $report->vendor->last_name }}
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
