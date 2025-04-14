<table>
    <thead>
        <tr>
            <th style="background-color: #FFFF00; font-size:14px; padding:10px;">
                Transfer Date
            </th>

            <th style="background-color: #FFFF00; font-size:14px; padding:10px;">
                Lens Code
            </th>

            <th style="background-color: #FFFF00; font-size:14px; padding:10px;">
                Lens Power
            </th>

            <th style="background-color: #FFFF00; font-size:14px; padding:10px;">
                Eye
            </th>

            <th style="background-color: #FFFF00; font-size:14px; padding:10px;">
                To Workshop
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
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $report)
            <tr>
                <td>
                    {{ $report->transfered_date }}
                </td>
                <td>
                    {{ $report->hq_lens->code }}
                </td>
                <td>
                    {{ $report->hq_lens->power }}
                </td>
                <td>
                    {{ $report->hq_lens->eye }}
                </td>
                <td>
                    {{ $report->to_workshop->name }}
                </td>
                <td>
                    {{ $report->quantity }}
                </td>
                <td>
                    {{ $report->status }}
                </td>
                <td>
                    {{ $report->condition }}
                </td>
                <td>
                    {{ $report->remarks }}
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
