@component('mail::message')
    {{ $details['title'] }}

    {{ $details['body'] }}

    Thanks,
    {{ config('app.name') }}
@endcomponent