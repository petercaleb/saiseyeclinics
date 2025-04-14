@component('mail::message')
    <h2>Hello {{ $details['name'] }}</h2>
    Your Account has beeen successfully removed from {{ config('app.name') }} system.
    <br>
    Please contact the administrator for more info. 
@endcomponent
{{-- Thanks,
<p>{{ config('app.name') }}</p> --}}