@php
    function removeNonBreakingSpace($inputString)
    {
        // Replace &nbsp; with a regular space
        $outputString = str_replace('&nbsp;', ' ', $inputString);

        return $outputString;
    }
@endphp
<table>
    <thead>
        <tr>
            <th style="background-color: #FFFF00; font-size:14px; padding:10px;">Clinic</th>
            <th style="background-color: #FFFF00; font-size:14px; padding:10px;">Card Number</th>
            <th style="background-color: #FFFF00; font-size:14px; padding:10px;">Patient Names</th>
            <th style="background-color: #FFFF00; font-size:14px; padding:10px;">Phone Number</th>
            <th style="background-color: #FFFF00; font-size:14px; padding:10px;">Email Address</th>
            <th style="background-color: #FFFF00; font-size:14px; padding:10px;">Date of Birth</th>
            <th style="background-color: #FFFF00; font-size:14px; padding:10px;">Gender</th>
            <th style="background-color: #FFFF00; font-size:14px; padding:10px;">Address</th>
            <th style="background-color: #FFFF00; font-size:14px; padding:10px;">Next of Kin</th>
            <th style="background-color: #FFFF00; font-size:14px; padding:10px;">Next of Kin Contacts</th>
            <th style="background-color: #FFFF00; font-size:14px; padding:10px;">Appointment Date</th>
            <th style="background-color: #FFFF00; font-size:14px; padding:10px;">Client Type</th>
            <th style="background-color: #FFFF00; font-size:14px; padding:10px;">Insurance</th>
            <th style="background-color: #FFFF00; font-size:14px; padding:10px;">Insurance Card Number</th>
            <th style="background-color: #FFFF00; font-size:14px; padding:10px;">Scheme Name</th>
            <th style="background-color: #FFFF00; font-size:14px; padding:10px;">Scheduled Date</th>
            <th style="background-color: #FFFF00; font-size:14px; padding:10px;">Doctor</th>
            <th style="background-color: #FFFF00; font-size:14px; padding:10px;">Signs</th>
            <th style="background-color: #FFFF00; font-size:14px; padding:10px;">Symptoms</th>
            <th style="background-color: #FFFF00; font-size:14px; padding:10px;">Diagnosis</th>
            <th style="background-color: #FFFF00; font-size:14px; padding:10px;">Right Sphere</th>
            <th style="background-color: #FFFF00; font-size:14px; padding:10px;">Right Cylinder</th>
            <th style="background-color: #FFFF00; font-size:14px; padding:10px;">Right Axis</th>
            <th style="background-color: #FFFF00; font-size:14px; padding:10px;">Right Add</th>
            <th style="background-color: #FFFF00; font-size:14px; padding:10px;">Left Sphere</th>
            <th style="background-color: #FFFF00; font-size:14px; padding:10px;">Left Cylinder</th>
            <th style="background-color: #FFFF00; font-size:14px; padding:10px;">Left Axis</th>
            <th style="background-color: #FFFF00; font-size:14px; padding:10px;">Left Add</th>
            <th style="background-color: #FFFF00; font-size:14px; padding:10px;">Notes</th>
            <th style="background-color: #FFFF00; font-size:14px; padding:10px;">Index</th>
            <th style="background-color: #FFFF00; font-size:14px; padding:10px;">Tint</th>
            <th style="background-color: #FFFF00; font-size:14px; padding:10px;">Diameter</th>
            <th style="background-color: #FFFF00; font-size:14px; padding:10px;">Focal Height</th>
            <th style="background-color: #FFFF00; font-size:14px; padding:10px;">Receipt Number</th>
            <th style="background-color: #FFFF00; font-size:14px; padding:10px;">Frame Code</th>
            <th style="background-color: #FFFF00; font-size:14px; padding:10px;">Bill Open Date</th>
            <th style="background-color: #FFFF00; font-size:14px; padding:10px;">Consultation Fee</th>
            <th style="background-color: #FFFF00; font-size:14px; padding:10px;">Consultation Receipt Number</th>
            <th style="background-color: #FFFF00; font-size:14px; padding:10px;">Bill Status</th>
            <th style="background-color: #FFFF00; font-size:14px; padding:10px;">Claimed Amount</th>
            <th style="background-color: #FFFF00; font-size:14px; padding:10px;">Agreed Amount</th>
            <th style="background-color: #FFFF00; font-size:14px; padding:10px;">Paid Amount</th>
            <th style="background-color: #FFFF00; font-size:14px; padding:10px;">Balance</th>
            <th style="background-color: #FFFF00; font-size:12px; padding:10px;">Invoice Number</th>
            <th style="background-color: #FFFF00; font-size:12px; padding:10px;">ETIMS/ VAT Number</th>
            <th style="background-color: #FFFF00; font-size:12px; padding:10px;">Approval Number</th>
            <th style="background-color: #FFFF00; font-size:12px; padding:10px;">Approval Status</th>
            <th style="background-color: #FFFF00; font-size:12px; padding:10px;">Closing Date</th>
            <th style="background-color: #FFFF00; font-size:14px; padding:10px;">Order Date</th>
            <th style="background-color: #FFFF00; font-size:14px; padding:10px;">Order Status</th>
            <th style="background-color: #FFFF00; font-size:14px; padding:10px;">Workshop</th>
            <th style="background-color: #FFFF00; font-size:14px; padding:10px;">Right Eye Lens Code</th>
            <th style="background-color: #FFFF00; font-size:14px; padding:10px;">Lest Eye Lens Code</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($reports as $report)
            <tr>
                <td>{{ $report->clinic->clinic }}</td>
                <td>{{ $report->patient->card_number }}</td>
                <td>{{ $report->patient->first_name }} {{ $report->patient->last_name }}</td>
                <td>{{ $report->patient->phone }}</td>
                <td>{{ $report->patient->email }}</td>
                <td>{{ date('d-M-Y', strtotime($report->patient->dob)) }}</td>
                <td>{{ $report->patient->gender }}</td>
                <td>{{ $report->patient->address }}</td>
                <td>{{ $report->patient->next_of_kin }}</td>
                <td>{{ $report->patient->next_of_kin_contact }}</td>
                <td>{{ date('d-M-Y', strtotime($report->appointment_date)) }}</td>
                <td>
                    @if ($report->payment_detail)
                        {{ $report->payment_detail->client_type->type }}
                    @endif
                </td>
                <td>
                    @if ($report->payment_detail->insurance)
                        {{ $report->payment_detail->insurance->title }}
                    @endif
                </td>
                <td>
                    @if ($report->payment_detail->insurance)
                        {{ $report->payment_detail->card_number }}
                    @endif
                </td>
                <td>
                    @if ($report->payment_detail->insurance)
                        {{ $report->payment_detail->scheme }}
                    @endif
                </td>
                <td>
                    @if ($report->doctor_schedule)
                        {{ date('d-M-Y', strtotime($report->doctor_schedule->date)) }}
                    @endif
                </td>
                <td>
                    @if ($report->doctor_schedule)
                        {{ $report->doctor_schedule->user->first_name }}
                        {{ $report->doctor_schedule->user->last_name }}
                    @endif
                </td>
                <td>
                    @if ($report->diagnosis)
                        {{ strip_tags(removeNonBreakingSpace($report->diagnosis->signs)) }}
                    @endif
                </td>
                <td>
                    @if ($report->diagnosis)
                        {{ strip_tags(removeNonBreakingSpace($report->diagnosis->symptoms)) }}
                    @endif
                </td>
                <td>
                    @if ($report->diagnosis)
                        {{ strip_tags(removeNonBreakingSpace($report->diagnosis->diagnosis)) }}
                    @endif
                </td>
                <td>
                    @if ($report->lens_power)
                        {{ $report->lens_power->right_sphere }}
                    @endif
                </td>
                <td>
                    @if ($report->lens_power)
                        {{ $report->lens_power->right_cylinder }}
                    @endif
                </td>
                <td>
                    @if ($report->lens_power)
                        {{ $report->lens_power->right_axis }}
                    @endif
                </td>
                <td>
                    @if ($report->lens_power)
                        {{ $report->lens_power->right_add }}
                    @endif
                </td>
                <td>
                    @if ($report->lens_power)
                        {{ $report->lens_power->left_sphere }}
                    @endif
                </td>
                <td>
                    @if ($report->lens_power)
                        {{ $report->lens_power->left_cylinder }}
                    @endif
                </td>
                <td>
                    @if ($report->lens_power)
                        {{ $report->lens_power->left_axis }}
                    @endif
                </td>
                <td>
                    @if ($report->lens_power)
                        {{ $report->lens_power->left_add }}
                    @endif
                </td>
                <td>
                    @if ($report->lens_power)
                        {{ $report->lens_power->notes }}
                    @endif
                </td>
                <td>
                    @if ($report->lens_prescription)
                        {{ $report->lens_prescription->index }}
                    @endif
                </td>
                <td>
                    @if ($report->lens_prescription)
                        {{ $report->lens_prescription->tint }}
                    @endif
                </td>
                <td>
                    @if ($report->lens_prescription)
                        {{ $report->lens_prescription->diameter }}
                    @endif
                </td>
                <td>
                    @if ($report->lens_prescription)
                        {{ $report->lens_prescription->focal_height }}
                    @endif
                </td>
                <td>
                    @if ($report->frame_prescription)
                        {{ $report->frame_prescription->receipt_number }}
                    @endif
                </td>
                <td>
                    @if ($report->frame_prescription)
                        {{ $report->frame_prescription->frame_code }}
                    @endif
                </td>
                <td>
                    @if ($report->payment_bill)
                        {{ date('d-M-Y', strtotime($report->payment_bill->open_date)) }}
                    @endif
                </td>
                <td>
                    {{ $report->consultation_fee }}
                </td>
                <td>
                    @if ($report->payment_bill)
                        {{ $report->payment_bill->consultation_receipt_number }}
                    @endif
                </td>
                <td>
                    @if ($report->payment_bill)
                        {{ $report->payment_bill->bill_status }}
                    @endif
                </td>
                <td>
                    {{ $report->claimed_amount }}
                </td>
                <td>
                    {{ $report->agreed_amount }}
                </td>
                <td>
                    {{ $report->paid_amount }}
                </td>
                <td>
                    {{ $report->balance }}
                </td>
                <td>
                    @if ($report->payment_bill)
                        {{ $report->payment_bill->invoice_number }}
                    @endif
                </td>
                <td>
                    @if ($report->payment_bill)
                        {{ $report->payment_bill->kra_number }}
                    @endif
                </td>
                <td>
                    @if ($report->payment_bill)
                        {{ $report->payment_bill->approval_number }}
                    @endif
                </td>
                <td>
                    @if ($report->payment_bill)
                        {{ $report->payment_bill->approval_status }}
                    @endif
                </td>
                <td>
                    @if ($report->payment_bill)
                        @if ($report->payment_bill->close_date != null && $report->payment_bill->close_date != '')
                            {{ date('d-M-Y', strtotime($report->payment_bill->close_date)) }}
                        @endif
                    @endif
                </td>
                <td>
                    @if ($report->order)
                        {{ date('d-M-Y', strtotime($report->order->order_date)) }}
                    @endif
                </td>
                <td>
                    @if ($report->order)
                        {{ $report->order->status }}
                    @endif
                </td>
                <td>
                    @if ($report->order)
                        {{ $report->order->workshop->name }}
                    @endif
                </td>
                <td>
                    @isset($report->order->right_eye_lens)
                        {{ $report->order->right_eye_lens->hq_lens->code }}
                    @endisset
                </td>
                <td>
                    @isset($report->order->left_eye_lens)
                        {{ $report->order->left_eye_lens->hq_lens->code }}
                    @endisset
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="43">
                    No Reports Found
                </td>
            </tr>
        @endforelse
        <tr></tr>
    </tbody>
</table>
