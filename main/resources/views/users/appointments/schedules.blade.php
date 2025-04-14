@if ($appointment->doctor_schedule)
    <div class="callout callout-info">
        <h5>
            <i class="fa fa-fighter-jet mr-1"></i> Scheduled Day
        </h5>

        <p>
            {{ $appointment->doctor_schedule->day }}
        </p>
    </div>
    <hr>
    <div class="callout callout-info">
        <h5>
            <i class="fa fa-calendar mr-1"></i> Scheduled Dates
        </h5>

        <p>
            {{ $appointment->doctor_schedule->date }}
        </p>
    </div>

    <hr>
    <div class="callout callout-info">
        <h5>
            <i class="fa fa-clock-o mr-1"></i> Scheduled Time
        </h5>

        <p>
            {{ $appointment->doctor_schedule->time }}
        </p>
    </div>

    <hr>
    <div class="callout callout-info">
        <h5>
            <i class="fa fa-user mr-1"></i> Doctor/ Optimetrist
        </h5>

        <p>
            {{ $appointment->doctor_schedule->user->first_name }}
            {{ $appointment->doctor_schedule->user->last_name }}
        </p>
    </div>

    @if (Auth::user()->id == $appointment->doctor_schedule->user_id)
        <hr>
        <a href="{{ route('users.doctor.schedules.view', $appointment->doctor_schedule->id) }}"
            class="btn btn-default btn-block">
            View Schedule
        </a>
    @endif
@else
    <div class="post">
        <p>
            No schedule found for this appointment.
        </p>

        <p>
            <a href="javascript:void(0)" class="btn btn-block btn-sm btn-outline-primary mr-2 scheduleAppointmentBtn">
                <i class="fas fa-calendar mr-1"></i> Schedule this appointment
            </a>
        </p>
    </div>
    <!-- /.post -->
@endif
