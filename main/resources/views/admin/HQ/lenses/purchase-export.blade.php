<table>
    <thead>
        <tr>
            <th style="background-color: #FFFF00; font-size:14px; padding:10px;">
                Purchased Date
            </th>

            <th style="background-color: #FFFF00; font-size:14px; padding:10px;">
                Receipt Number
            </th>

            <th style="background-color: #FFFF00; font-size:14px; padding:10px;">
                Lens Code
            </th>

            <th style="background-color: #FFFF00; font-size:14px; padding:10px;">
                Lens Power
            </th>

            <th style="background-color: #FFFF00; font-size:14px; padding:10px;">
                Vendor
            </th>

            <th style="background-color: #FFFF00; font-size:14px; padding:10px;">
                Units
            </th>

            <th style="background-color: #FFFF00; font-size:14px; padding:10px;">
                Price
            </th>

            <th style="background-color: #FFFF00; font-size:14px; padding:10px;">
                Total Price
            </th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $report)
            <tr>
                <td>
                    {{ $report->purchased_date }}
                </td>
                <td>
                    {{ $report->receipt_number }}
                </td>
                <td>
                    {{ $report->hq_lens->code }}
                </td>
                <td>
                    {{ $report->hq_lens->power }}
                </td>
                <td>
                    {{ $report->vendor->first_name }} {{ $report->vendor->last_name }}
                </td>
                <td>
                    {{ $report->quantity }}
                </td>
                <td>
                    {{ $report->price }}
                </td>
                <td>
                    {{ $report->total_price }}
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
