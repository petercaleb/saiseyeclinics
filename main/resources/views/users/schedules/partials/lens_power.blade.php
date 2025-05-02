@include('users.schedules.partials.script')


<div class="lensPowerDiv">

    @include('users.schedules.partials.lens_power_form')

    <div class="d-flex justify-content-center p-md-5 p-3" id="lensPowerPreamble">
        <h5 class="text-nowrap">Choose a treatment option</h5>
    </div>
    @foreach ([$lens_power, $lens_power_1] as $index => $lens)
        @if ($lens)
            @php $lensId = 'lensPower' . ($index ? '1' : ''); @endphp
            @php $lensFunction = $index ? 'lensPower1__Details' : 'lensPower__Details'; @endphp
            <div class="timeline timeline-inverse d-none" id="{{ $lensId }}">
                <div class="time-label">
                    <span class="bg-primary lensPowerTitle">Lens Power</span>
                </div>

                @foreach (['right' => 'danger', 'left' => 'warning'] as $side => $color)
                    <div>
                        <i class="fa fa-eye bg-{{ $color }}"></i>
                        <div class="timeline-item">
                            <h3 class="timeline-header">
                                <a href="#">{{ ucfirst($side) }}</a> Eye
                            </h3>
                            <div class="timeline-body table-responsive">
                                <table class="table table-bordered">
                                    <tbody>
                                        @foreach (['sphere', 'cylinder', 'axis', 'add'] as $param)
                                            <tr>
                                                <th>{{ ucfirst($param) }}</th>
                                                <td>{{ $lens->{$side . '_' . $param} }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                @endforeach

                <div class="time-label">
                    <span class="bg-success">Additional Information</span>
                </div>
                <div>
                    <i class="fa fa-info-circle bg-purple"></i>
                    <div class="timeline-item">
                        <div class="timeline-body">{{ $lens->notes }}</div>
                        <div class="timeline-footer">
                            <div class="row">
                                <div class="col-md-4">
                                    @if (!$lens_prescription)
                                        <a href="#" data-id="{{ $lens->id }}"
                                            class="btn btn-warning btn-sm btn-block newLensPrescriptionBtn">Add Lens
                                            Prescription</a>
                                    @else
                                        <a href="#" data-id="{{ $lens_prescription->id }}"
                                            class="btn btn-primary btn-sm btn-block viewLensPrescription">Lens
                                            Prescription</a>
                                    @endif
                                </div>
                                <div class="col-md-8">
                                    @if (Auth::user()->id == $schedule->user_id && isset($treatment) && $treatment->status !== 'ordered')
                                        <a href="#" data-id="{{ $lens->id }}"
                                            class="btn btn-secondary btn-sm btn-block editLensPowerBtn">Edit Lens
                                            Power</a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div><i class="fa fa-stop bg-gray"></i></div>
            </div>
            <script>
                if (typeof window["{{ $lensFunction }}"] === "function") {
                    $get(window["{{ $lensFunction }}"]);
                }
            </script>
        @endif
    @endforeach

    <script>
        @if (!$lens_power_1 && $lens_power)
            $get(lensPower__Form);
        @elseif (!$lens_power && $lens_power_1)
            $get(lensPower1__Form);
        @endif
    </script>

    @if (!$lens_power && !$lens_power_1)
        <script>
            editHTML(".treatmentOptionTitle", "Lens Power 1");
            toggleVisibility("lensPowerForm", "show");
            toggleVisibility("lensPowerPreamble", "hide");
        </script>
    @endif

</div>
<!--#lensPowerDiv -->
