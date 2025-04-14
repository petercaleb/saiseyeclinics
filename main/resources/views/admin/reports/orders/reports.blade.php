<table>
    <thead>
        <tr>
            <th style="background-color: #FFFF00; font-size:14px; padding:10px;">Clinic</th>
            <th style="background-color: #FFFF00; font-size:14px; padding:10px;">Order #</th>
            <th style="background-color: #FFFF00; font-size:14px; padding:10px;">Receipt #</th>
            <th style="background-color: #FFFF00; font-size:14px; padding:10px;">Order Date</th>
            <th style="background-color: #FFFF00; font-size:14px; padding:10px;">Patient Names</th>
            <th style="background-color: #FFFF00; font-size:14px; padding:10px;">Lens Power</th>
            <th style="background-color: #FFFF00; font-size:14px; padding:10px;">Lens Type</th>
            <th style="background-color: #FFFF00; font-size:14px; padding:10px;">Lens Material</th>
            <th style="background-color: #FFFF00; font-size:14px; padding:10px;">Lens Index</th>
            <th style="background-color: #FFFF00; font-size:14px; padding:10px;">Frame Code</th>
            <th style="background-color: #FFFF00; font-size:14px; padding:10px;">Frame Quantity</th>
            <th style="background-color: #FFFF00; font-size:14px; padding:10px;">Order Status</th>
            <th style="background-color: #FFFF00; font-size:14px; padding:10px;">Right Eye Lens Power</th>
            <th style="background-color: #FFFF00; font-size:14px; padding:10px;">Right Eye Lens Type</th>
            <th style="background-color: #FFFF00; font-size:14px; padding:10px;">Right Eye Lens Material</th>
            <th style="background-color: #FFFF00; font-size:14px; padding:10px;">Left Eye Lens Power</th>
            <th style="background-color: #FFFF00; font-size:14px; padding:10px;">Left Eye Lens Type</th>
            <th style="background-color: #FFFF00; font-size:14px; padding:10px;">Left Eye Lens Material</th>
            <th style="background-color: #FFFF00; font-size:14px; padding:10px;">Closed Date</th>
            <th style="background-color: #FFFF00; font-size:14px; padding:10px;">Workshop</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($reports as $report)
            <tr>
                <td>{{ $report->clinic->clinic }}</td>
                <td>#{{ $report->id }}</td>
                <td>{{ $report->receipt_number }}</td>
                <td>{{ date('d F Y', strtotime($report->track_date)) }}</td>
                <td>{{ $report->patient->first_name }} {{ $report->patient->last_name }}</td>
                <td>{{ $report->lens_power->right_sphere }}/{{ $report->lens_power->right_cylinder }}/{{ $report->lens_power->right_axis }}
                    -
                    {{ $report->lens_power->left_axis }}/{{ $report->lens_power->left_cylinder }}/{{ $report->lens_power->left_axis }}
                </td>
                <td>{{ $report->lens_prescription->lens_type->type }}</td>
                <td>{{ $report->lens_prescription->lens_material->title }}</td>
                <td>{{ $report->lens_prescription->index }}</td>
                <td>{{ $report->frame_prescription->frame_code }}</td>
                <td>{{ $report->frame_prescription->quantity }}</td>
                <td>{{ $report->track_status }}</td>
                <td>
                    @if ($report->right_eye_lens)
                        {{ $report->right_eye_lens->hq_lens->power }}
                    @endif
                </td>
                <td>
                    @if ($report->right_eye_lens)
                        {{ $report->right_eye_lens->hq_lens->lens_type->type }}
                    @endif
                </td>
                <td>
                    @if ($report->right_eye_lens)
                        {{ $report->right_eye_lens->hq_lens->lens_material->title }}
                    @endif
                </td>
                
                <td>
                    @if ($report->left_eye_lens)
                        {{ $report->left_eye_lens->hq_lens->power }}
                    @endif
                </td>
                <td>
                    @if ($report->left_eye_lens)
                        {{ $report->left_eye_lens->hq_lens->lens_type->type }}
                    @endif
                </td>
                <td>
                    @if ($report->left_eye_lens)
                        {{ $report->left_eye_lens->hq_lens->lens_material->title }}
                    @endif
                </td>

                <td>
                    @if ($report->closed_date)
                        {{ date('d F Y', strtotime($report->closed_date)) }}
                    @endif
                </td>
                <td>{{ $report->workshop->name }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="14">
                    No Order reports
                </td>
            </tr>
        @endforelse

    </tbody>
</table>
