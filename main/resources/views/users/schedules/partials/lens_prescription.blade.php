@include('users.schedules.partials.script')

<div class="lensPrescriptionDiv">

    @include('users.schedules.partials.lens_prescription_form')

    @php
        $prescriptions = [
            'lensPrescription1' => $lens_prescription_1 ?? null,
            'lensPrescription' => $lens_prescription ?? null,
        ];
    @endphp
    <div class="d-flex justify-content-center p-md-5 p-3 d-none" id="lensPrescriptionPreamble">
        <h5 class="text-nowrap">Choose a treatment option</h5>
    </div>

    @foreach ($prescriptions as $id => $prescription)
        @if ($prescription)
            <div class="timeline timeline-inverse d-none" id="{{ $id }}">
                <div class="time-label">
                    <span class="bg-primary lensPrescriptionTitle">Lens Prescription</span>
                </div>

                @php
                    $items = [
                        [
                            'icon' => 'fa-tripadvisor bg-danger',
                            'title' => 'Lens Type',
                            'value' => $prescription->lens_type->type,
                        ],
                        [
                            'icon' => 'fa-cubes bg-warning',
                            'title' => 'Lens Material',
                            'value' => $prescription->lens_material->title,
                        ],
                        ['icon' => 'fa-th bg-purple', 'title' => 'Index/Thickness', 'value' => $prescription->index],
                        ['icon' => 'fa-tint bg-info', 'title' => 'Lens Tint', 'value' => $prescription->tint],
                        ['icon' => 'fa-th bg-info', 'title' => 'Diameter / Pupil', 'value' => $prescription->diameter],
                        [
                            'icon' => 'fa-text-height bg-danger',
                            'title' => 'Focal Height',
                            'value' => $prescription->focal_height,
                        ],
                    ];
                @endphp

                @foreach ($items as $item)
                    <div>
                        <i class="fa {{ $item['icon'] }}"></i>
                        <div class="timeline-item">
                            <h3 class="timeline-header"><a href="#">Lens</a> {{ $item['title'] }}</h3>
                            <div class="timeline-body table-responsive">
                                <p>{{ $item['value'] }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach

                @if ($frame_prescription)
                    <div class="timeline-footer">
                        <div class="row">
                            <div class="col-md-4">
                                <a href="#" data-id="{{ $frame_prescription->id }}"
                                    class="btn btn-block btn-primary btn-flat btn-sm frameCodeBtn">Frame Code</a>
                            </div>
                            <div class="col-md-8">
                                @if (Auth::user()->id == $schedule->user_id && isset($treatment) && $treatment->status !== 'ordered')
                                    <a href="#" data-id="{{ $prescription->id }}"
                                        class="btn btn-block btn-sm btn-secondary editPrescriptionBtn">Edit
                                        Prescription</a>
                                @endif
                            </div>
                        </div>
                    </div>
                @else
                    <div class="timeline-footer">
                        <div class="row">
                            @if (Auth::user()->id == $schedule->user_id)
                                <div class="col-md-4">
                                    <a href="#" data-id="{{ $prescription->id }}"
                                        class="btn btn-block btn-warning btn-flat btn-sm newFrameCodeBtn">Add Frame
                                        Code</a>
                                </div>
                                <div class="col-md-8">
                                    @if (isset($treatment) && $treatment->status !== 'ordered')
                                        <a href="#" data-id="{{ $prescription->id }}"
                                            class="btn btn-block btn-sm btn-secondary editPrescriptionBtn">Edit
                                            Prescription</a>
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>
                @endif
            </div>
        @endif
    @endforeach
</div>
<!--/ lensPrescriptionDiv -->
