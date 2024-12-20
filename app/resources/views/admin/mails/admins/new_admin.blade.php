@component('mail::message')

<h2>Hello {{ $details['name'] }}</h2>
An account has been created for you on the {{ config('app.name') }} system.
<br>
Your account details are below:
<br>
Email: {{ $details['email'] }} <br>
Password: {{ $details['password'] }} <br>
Please click the link below to login and change your password.
<p>
@component('mail::button', ['url' => $details['login']])
    Login
@endcomponent
</p>

@endcomponent