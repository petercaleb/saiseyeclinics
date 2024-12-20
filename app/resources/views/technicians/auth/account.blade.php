@extends('technicians.layouts.auth')

@section('content')
    <p class="login-box-msg">Account Status</p>
    <form method="post">
        <p class="text-danger text-center">
            You cannot login to your account
            Your account is inactive.
        </p>
        <p class="text-danger text-center">
            Please Contact the admin for further assistance
        </p>
    </form>
    <p class="mb-1">
        <a href="#"
            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            {{ __('Logout') }}
        </a>
    <form id="logout-form" action="{{ route('technicians.technicians.logout') }}" method="POST" class="d-none">
        @csrf
    </form>
    </p>
@endsection
