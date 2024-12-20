<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-dark navbar-primary">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button">
                <i class="fa fa-bars"></i>
            </a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="{{ route('admin.organization.index') }}" class="nav-link">HQ</a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="{{ route('admin.dashboard.index', $clinic->id) }}" class="nav-link">Home</a>
        </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <!-- Notifications Dropdown Menu -->
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <i class="fa fa-user"></i> {{ Auth::guard('admin')->user()->username }}
            </a>
            <div class="dropdown-menu dropdown-menu-md dropdown-menu-right">
                <a href="{{ route('admin.clinics.view', $clinic->id) }}" class="dropdown-item">
                    <i class="fa fa-cogs mr-2"></i> settings
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt mr-2"></i> {{ __('Logout') }}
                </a>
                <form id="logout-form" action="{{ route('admin.personal.logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </div>
        </li>
    </ul>
</nav>
<!-- /.navbar -->
