<div>

    <strong><i class="fa fa-hourglass mr-1"></i> Client Type</strong>

    <p class="text-muted">
        {{ $appointment->payment_detail->client_type->type }}
    </p>

    <hr>

    @if ($appointment->payment_detail->insurance)
        <strong><i class="fa fa-building mr-1"></i> Insurance Company</strong>

        <p class="text-muted">
            {{ $appointment->payment_detail->insurance->title }}
        </p>

        <hr>

        <strong><i class="fa fa-building mr-1"></i> Scheme</strong>

        <p class="text-muted">
            {{ $appointment->payment_detail->scheme }}
        </p>

        <hr>

        <strong><i class="fa fa-user mr-1"></i> Principal Member</strong>

        <p class="text-muted">
            {{ $appointment->payment_detail->principal }}
        </p>

        <hr>
        <strong><i class="fa fa-phone mr-1"></i> Principal Telephone Number</strong>

        <p class="text-muted">
            {{ $appointment->payment_detail->phone }}
        </p>

        <hr>
        <strong><i class="fa fa-map-pin mr-1"></i> Principal Workplace</strong>

        <p class="text-muted">
            {{ $appointment->payment_detail->workplace }}
        </p>

        <hr>
        <strong><i class="fa fa-credit-card mr-1"></i> Insurance Card Number</strong>

        <p class="text-muted">
            {{ $appointment->payment_detail->card_number }}
        </p>

        <hr>
    @endif

    <strong><i class="fa fa-map-pin mr-1"></i> Patient Workplace</strong>

    <p class="text-muted">
        {{ $appointment->payment_detail->principal_workplace }}
    </p>

</div>
