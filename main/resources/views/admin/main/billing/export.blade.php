<table>
    <thead>
        <tr>
            <th style="background-color: #FFFF00; font-size:14px; padding:10px;">
                Clinic
            </th>

            <th style="background-color: #FFFF00; font-size:14px; padding:10px;">
                Receipt Number
            </th>

            <th style="background-color: #FFFF00; font-size:14px; padding:10px;">
                Patient Names
            </th>

            <th style="background-color: #FFFF00; font-size:14px; padding:10px;">
                Insurance
            </th>

            <th style="background-color: #FFFF00; font-size:14px; padding:10px;">
                Scheme
            </th>

            <th style="background-color: #FFFF00; font-size:14px; padding:10px;">
                Insurance Card Number
            </th>

            <th style="background-color: #FFFF00; font-size:14px; padding:10px;">
                Invoice Number
            </th>

            <th style="background-color: #FFFF00; font-size:14px; padding:10px;">
                ETIMS/ VAT Number
            </th>

            <th style="background-color: #FFFF00; font-size:14px; padding:10px;">
                Billed Amount
            </th>
        </tr>
    </thead>
    <tbody>
        @forelse ($data as $report)
            <tr>
                <td>
                    {{ $report->clinic->clinic }}
                </td>

                <td>
                    @if ($report->appontment)
                        {{ $report->appontment->lens_power->frame_prescription->receipt_number }}
                    @endif
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
                    {{ $report->invoice_number }}
                </td>

                <td>
                    {{ $report->kra_number }}
                </td>
                <td>
                    {{ $report->paid_amount }}
                </td>
            </tr>
        @empty
        @endforelse
    </tbody>
</table>
