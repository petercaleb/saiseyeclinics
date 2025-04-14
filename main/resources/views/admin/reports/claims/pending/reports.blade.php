<table>
    <thead>
        <tr>
            <th style="background-color: #FFFF00; font-size:14px; padding:10px;">
                Date
            </th>

            <th style="background-color: #FFFF00; font-size:14px; padding:10px;">
                Clinic Name
            </th>

            <th style="background-color: #FFFF00; font-size:14px; padding:10px;">
                Patient Names
            </th>

            <th style="background-color: #FFFF00; font-size:14px; padding:10px;">
                Insurance Name
            </th>

            <th style="background-color: #FFFF00; font-size:14px; padding:10px;">
                Scheme Name
            </th>

            <th style="background-color: #FFFF00; font-size:14px; padding:10px;">
                Insurance Card Number
            </th>

            <th style="background-color: #FFFF00; font-size:14px; padding:10px;">
                Claimed Amount
            </th>

            <th style="background-color: #FFFF00; font-size:14px; padding:10px;">
                Claimed Date
            </th>

            <th style="background-color: #FFFF00; font-size:14px; padding:10px;">
                Aging
            </th>
        </tr>
    </thead>
    <tbody>
        @forelse ($reports as $report)
            <tr>

                <td>
                    {{ date('d F Y', strtotime($report->open_date)) }}
                </td>

                <td>
                    {{ $report->clinic->clinic }}
                </td>

                <td>
                    {{ $report->patient->first_name }} {{ $report->patient->last_name }}
                </td>

                <td>
                    @if ($report->payment_detail->insurance)
                        {{ $report->payment_detail->insurance->title }}
                    @endif
                </td>

                <td>
                    @if ($report->payment_detail->client_type->type == 'Insurance')
                        {{ $report->payment_detail->scheme }}
                    @endif
                </td>

                <td>
                    @if ($report->payment_detail->client_type->type == 'Insurance')
                        {{ $report->payment_detail->card_number }}
                    @endif
                </td>

                <td>
                    {{ $report->claimed_amount }}
                </td>

                <td>
                    {{ date('d F Y', strtotime($report->open_date)) }}
                </td>

                <td>
                    @php
                        $now = \Carbon\Carbon::now();
                        $claimed_date = \Carbon\Carbon::parse($report->open_date);
                        echo $claimed_date->diffInDays($now);
                    @endphp
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="20">
                    No payments made to be reported
                </td>
            </tr>
        @endforelse
    </tbody>
</table>
