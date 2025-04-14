<table>
    <tbody>
        <tr>
            <th>Date Received</th>
            <td>{{ \Carbon::parse($data->date_received)->format('d M, Y') }}</td>
        </tr>
        <tr>
            <th>Transaction Code</th>
            <td>{{ $data->transaction_code }}</td>
        </tr>
        <tr>
            <th>Transaction Mode</th>
            <td>{{ \TransactionModes::getName($data->transaction_mode) }}</td>
        </tr>
        <tr>
            <th>Insurance</th>
            <td>{{ $data->insurance->title }}</td>
        </tr>
        <tr>
            <th>Comments</th>
            <td>{{ $data->notes }}</td>
        </tr>
    </tbody>
</table>

<table>
    <thead>
        <tr>
            <th>SN</th>
            <th>Clinic</th>
            <th>Receipt #</th>
            <th>Patient Names</th>
            <th>Card Number</th>
            <th>ETIMS Number</th>
            <th>Agreed Amount</th>
            <th>Paid Amount</th>
            <th>Balance</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data->receivedPayment as $receivedPayments)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $receivedPayments->paymentBill->clinic->clinic }}</td>
                <td>{{ $receivedPayments->paymentBill->appontment->lens_power->frame_prescription->receipt_number }}</td>
                <td>
                    {{ $receivedPayments->paymentBill->patient->first_name }}
                    {{ $receivedPayments->paymentBill->patient->last_name }}
                </td>
                <td>
                    {{ $receivedPayments->paymentBill->patient->card_number }}
                </td>
                <td>
                    {{ $receivedPayments->paymentBill->kra_number }}
                </td>
                <td>
                    {{ $receivedPayments->amount }}
                </td>
                <td>
                    {{ $receivedPayments->paid }}
                </td>
                <td>
                    {{ $receivedPayments->balance }}
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

<table>
    <tbody>
        <tr>
            <th>Total Amount</th>
            <td>{{ $data->amount  }}</td>
        </tr>
        <tr>
            <th>Total Paid</th>
            <td>{{ $data->paid  }}</td>
        </tr>
        <tr>
            <th>Total Balance</th>
            <td>{{ $data->balance  }}</td>
        </tr>
        <tr>
            <th>Change To Return</th>
            <td>{{ $data->change  }}</td>
        </tr>
    </tbody>
</table>
