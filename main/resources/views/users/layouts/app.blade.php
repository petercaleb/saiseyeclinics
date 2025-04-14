<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Favicon -->
    <link href="{{ asset(config('app.favicon')) }}" rel="icon">

    <title>{{ config('app.name') }} | {{ $page_title }}</title>



    @include('users.components.styles')

    @stack('styles')
</head>

<body class="hold-transition sidebar-mini accent-primary">
    <div class="wrapper">
        <!-- Navbar -->
        @include('users.includes.partials.nav')

        <!-- Main Sidebar Container -->
        @include('users.includes.partials.sidebar')

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            @yield('content')
        </div>
        <!-- /.content-wrapper -->

        @stack('modals')

        <!-- Main Footer -->
        @include('users.includes.partials.footer')

    </div>
    <!-- ./wrapper -->

    <!-- REQUIRED SCRIPTS -->
    @include('users.components.scripts')

    @stack('scripts')

</body>

</html>
