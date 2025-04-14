<table>
    <thead>
        <tr>
            <th>Full Names</th>
            <th>Appointment Date</th>
            <th>Time</th>
            <th>Client Type</th>
            <th>Insurance</th>
            <th>Scheme Name</th>
            <th>Insurance No.</th>
            <th>Workplace</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($appointments as $appointment)
            <tr>
                <td>{{ $appointment->patient->first_name }} {{ $appointment->patient->last_name }}</td>
                <td>{{ $appointment->date }}</td>
                <td>{{ $appointment->appointment_time }}</td>
                <td>{{ $appointment->payment_detail->client_type->type }}</td>
                <td>
                    @if ($appointment->payment_detail->insurance)
                        {{ $appointment->payment_detail->insurance->title }}
                    @endif
                </td>
                <td>{{ $appointment->payment_detail->scheme }}</td>
                <td>{{ $appointment->card_number }}</td>
                <td>{{ $appointment->payment_detail->principal_workplace }}</td>
                <td>{{ $appointment->status }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="9">
                    No Appointment data found..
                </td>
            </tr>
        @endforelse
    </tbody>
</table>
