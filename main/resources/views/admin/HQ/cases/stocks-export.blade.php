<table>
    <thead>
        <tr>
            <th style="background-color: #FFFF00; font-size:14px; padding:10px;">
                Case Code
            </th>

            <th style="background-color: #FFFF00; font-size:14px; padding:10px;">
                Color
            </th>

            <th style="background-color: #FFFF00; font-size:14px; padding:10px;">
                Shape
            </th>

            <th style="background-color: #FFFF00; font-size:14px; padding:10px;">
                Size
            </th>

            <th style="background-color: #FFFF00; font-size:14px; padding:10px;">
                Opening
            </th>

            <th style="background-color: #FFFF00; font-size:14px; padding:10px;">
                Purchased
            </th>

            <th style="background-color: #FFFF00; font-size:14px; padding:10px;">
                Transfered
            </th>

            <th style="background-color: #FFFF00; font-size:14px; padding:10px;">
                Total
            </th>

            <th style="background-color: #FFFF00; font-size:14px; padding:10px;">
                Supplier Price
            </th>

            <th style="background-color: #FFFF00; font-size:14px; padding:10px;">
                Price
            </th>

        </tr>
    </thead>
    <tbody>
        @foreach ($data as $report)
            <tr>
                <td>
                    {{ $report->frame_case->code }}
                </td>
                <td>
                    {{ $report->frame_case->case_color->title }}
                </td>
                <td>
                    {{ $report->frame_case->case_shape->title }}
                </td>
                <td>
                    {{ $report->frame_case->case_size->title }}
                </td>
                <td>
                    {{ $report->opening }}
                </td>
                <td>
                    {{ $report->purchased }}
                </td>
                <td>
                    {{ $report->transfered }}
                </td>
                <td>
                    {{ $report->total }}
                </td>
                <td>
                    {{ $report->supplier_price }}
                </td>
                <td>
                    {{ $report->price }}
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
