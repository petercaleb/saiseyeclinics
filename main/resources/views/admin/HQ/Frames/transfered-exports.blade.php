<table>
    <thead>
        <tr>
            <th style="background-color: #FFFF00; font-size:14px; padding:10px;">
                Transfered Date
            </th>

            <th style="background-color: #FFFF00; font-size:14px; padding:10px;">
                Frame Code
            </th>

            <th style="background-color: #FFFF00; font-size:14px; padding:10px;">
                To Clinic
            </th>

            <th style="background-color: #FFFF00; font-size:14px; padding:10px;">
                Quantity
            </th>

            <th style="background-color: #FFFF00; font-size:14px; padding:10px;">
                Status
            </th>

            <th style="background-color: #FFFF00; font-size:14px; padding:10px;">
                Condition
            </th>

            <th style="background-color: #FFFF00; font-size:14px; padding:10px;">
                Remarks
            </th>

            <th style="background-color: #FFFF00; font-size:14px; padding:10px;">
                Received status
            </th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $report)
            <tr>
                <td>
                    {{ $report->transfer_date }}
                </td>
                <td>
                    {{ $report->frame_code }}
                </td>
                <td>
                    {{ $report->to_clinic->clinic }}
                </td>
                <td>
                    {{ $report->quantity }}
                </td>
                <td>
                    {{ $report->transfer_status }}
                </td>
                <td>
                    {{ $report->condition }}
                </td>
                <td>
                    {{ $report->remarks }}
                </td>
                <td>
                    {{ $report->received }}
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
