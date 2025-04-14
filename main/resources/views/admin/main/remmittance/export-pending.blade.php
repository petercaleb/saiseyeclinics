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
            <th style="background-color: #FFFF00; font-size:14px; padding:10px;">
                Remmittance Status
            </th>
        </tr>
    </thead>
    <tbody>
        @forelse ($data as $report)
            <tr>
                <td>
                    {{ $report->paymentBill->clinic->clinic }}
                </td>
                <td>
                    @if ($report->paymentBill->appontment)
                        {{ $report->paymentBill->appontment->lens_power->frame_prescription->receipt_number }}
                    @endif
                </td>
                <td>
                    {{ $report->paymentBill->patient->first_name }}
                    {{ $report->paymentBill->patient->last_name }}
                </td>
                <td>
                    @if ($report->paymentBill->payment_detail->insurance)
                        {{ $report->paymentBill->payment_detail->insurance->title }}
                    @endif
                </td>
                <td>
                    @if ($report->paymentBill->payment_detail->client_type->type == 'Insurance')
                        {{ $report->paymentBill->payment_detail->scheme }}
                    @endif
                </td>
                <td>
                    @if ($report->paymentBill->payment_detail->client_type->type == 'Insurance')
                        {{ $report->paymentBill->payment_detail->card_number }}
                    @endif
                </td>
                <td>
                    {{ $report->paymentBill->invoice_number }}
                </td>
                <td>
                    {{ $report->paymentBill->kra_number }}
                </td>
                <td>
                    {{ $report->paymentBill->paid_amount }}
                </td>
                <td>
                    {{ \RemmittanceStatus::getName($report->status) }}
                </td>
            </tr>
        @empty
        @endforelse
    </tbody>
</table>
