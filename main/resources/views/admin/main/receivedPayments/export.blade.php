<table>
    <thead>
        <tr>
            <th style="background-color: #FFFF00; font-size:14px; padding:10px;">
                SN
            </th>

            <th style="background-color: #FFFF00; font-size:14px; padding:10px;">
                Clinic
            </th>

            <th style="background-color: #FFFF00; font-size:14px; padding:10px;">
                Receipt #
            </th>

            <th style="background-color: #FFFF00; font-size:14px; padding:10px;">
                Patient Names
            </th>

            <th style="background-color: #FFFF00; font-size:14px; padding:10px;">
                Card #
            </th>

            <th style="background-color: #FFFF00; font-size:14px; padding:10px;">
                Insurance
            </th>

            <th style="background-color: #FFFF00; font-size:14px; padding:10px;">
                Insurance Card Number
            </th>

            <th style="background-color: #FFFF00; font-size:14px; padding:10px;">
                Scheme Name
            </th>

            <th style="background-color: #FFFF00; font-size:14px; padding:10px;">
                Closed Date
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
                Amount Billed
            </th>

            <th style="background-color: #FFFF00; font-size:14px; padding:10px;">
                Paid Amount
            </th>

            <th style="background-color: #FFFF00; font-size:14px; padding:10px;">
                ETIMS/ VAT Number
            </th>

            <th style="background-color: #FFFF00; font-size:14px; padding:10px;">
                Document Status
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
                    {{ $report->paymentBill->clinic->clinic }}
                </td>

                <td>
                    {{ $report->paymentBill->appontment->lens_power->frame_prescription->receipt_number }}
                </td>

                <td>
                    {{ $report->paymentBill->patient->first_name }}
                    {{ $report->paymentBill->patient->last_name }}
                </td>

                <td>
                    {{ $report->paymentBill->patient->card_number }}
                </td>

                <td>
                    {{ $report->paymentBill->payment_detail->insurance->title }}
                </td>

                <td>
                    {{ $report->paymentBill->payment_detail->card_number }}
                </td>

                <td>
                    {{ $report->paymentBill->payment_detail->scheme }}
                </td>
                <td>
                    {{ $report->paymentBill->close_date }}
                </td>

                <td>
                    {{ $report->receivedPayment->banking->date_received }}
                </td>

                <td>
                    {{ $report->receivedPayment->banking->transaction_code }}
                </td>

                <td>
                    {{ \TransactionModes::getName($report->receivedPayment->banking->transaction_mode) }}
                </td>

                <td>
                    {{ $report->receivedPayment->amount }}
                </td>
                
                <td>
                    {{ $report->receivedPayment->paid }}
                </td>

                <td>
                    {{ $report->paymentBill->kra_number }}
                </td>

                <td>
                    {{ \RemmittanceStatus::getName($report->status) }}
                </td>
            </tr>
        @empty
            
        @endforelse
    </tbody>
</table>
