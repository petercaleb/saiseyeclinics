<table>
    <thead>
        <tr>
            <th style="background-color: #FFFF00; font-size:14px; padding:10px;">
                SN
            </th>

            <th style="background-color: #FFFF00; font-size:14px; padding:10px;">
                Date Received
            </th>

            <th style="background-color: #FFFF00; font-size:14px; padding:10px;">
                Transaction Code
            </th>

            <th style="background-color: #FFFF00; font-size:14px; padding:10px;">
                Transaction Mode
            </th>

            <th style="background-color: #FFFF00; font-size:14px; padding:10px;">
                Insurance
            </th>

            <th style="background-color: #FFFF00; font-size:14px; padding:10px;">
                Total Amount
            </th>

            <th style="background-color: #FFFF00; font-size:14px; padding:10px;">
                Total Paid
            </th>

            <th style="background-color: #FFFF00; font-size:14px; padding:10px;">
                Total Balance
            </th>

            <th style="background-color: #FFFF00; font-size:14px; padding:10px;">
                Change To Return
            </th>

            <th style="background-color: #FFFF00; font-size:14px; padding:10px;">
                Reason
            </th>
        </tr>
    </thead>
    <tbody>

        @forelse ($data as $report)
            <tr>
                <td>
                    {{ $loop->iteration }}
                </td>

                <td>
                    {{ $report->date_received }}
                </td>

                <td>
                    {{ $report->transaction_code }}
                </td>

                <td>
                    {{ \TransactionModes::getName($report->transaction_mode) }}
                </td>

                <td>
                    {{ $report->insurance->title }}
                </td>

                <td>
                    {{ $report->amount }}
                </td>

                <td>
                    {{ $report->paid }}
                </td>

                <td>
                    {{ $report->balance }}
                </td>

                <td>
                    {{ $report->change }}
                </td>

                <td>
                    {{ $report->notes }}
                </td>
            </tr>
        @empty
        @endforelse

    </tbody>
</table>
