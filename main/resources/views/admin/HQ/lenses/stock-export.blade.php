<table>
    <thead>
        <tr>
            <th style="background-color: #FFFF00; font-size:14px; padding:10px;">
                Date Added
            </th>

            <th style="background-color: #FFFF00; font-size:14px; padding:10px;">
                Lens Code
            </th>

            <th style="background-color: #FFFF00; font-size:14px; padding:10px;">
                Lens Power
            </th>

            <th style="background-color: #FFFF00; font-size:14px; padding:10px;">
                Lens Type
            </th>

            <th style="background-color: #FFFF00; font-size:14px; padding:10px;">
                Lens Material
            </th>

            <th style="background-color: #FFFF00; font-size:14px; padding:10px;">
                Lens Index
            </th>

            <th style="background-color: #FFFF00; font-size:14px; padding:10px;">
                Eye
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
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $report)
            <tr>
                <td>
                    {{ $report->date_added }}
                </td>
                <td>
                    {{ $report->power }}
                </td>
                <td>
                    {{ $report->code }}
                </td>
                <td>
                    {{ $report->lens_type->type }}
                </td>
                <td>
                    {{ $report->lens_material->title }}
                </td>
                <td>
                    {{ $report->lens_index }}
                </td>
                <td>
                    {{ $report->eye }}
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
            </tr>
        @endforeach
    </tbody>
</table>
