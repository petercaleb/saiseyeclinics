<aside class="main-sidebar elevation-4 sidebar-light-primary">
    <!-- Brand Logo -->
    <a href="{{ route('admin.dashboard.index', $clinic->id) }}" class="brand-link navbar-primary">
        <img src="{{ asset('storage/clinics/' . $clinic->logo) }}" alt="{{ $clinic->clinic }}"
            class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">
            {{ $clinic->clinic }}
        </span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">

        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ asset('storage/admin/' . Auth::guard()->user()->profile) }}" class="img-circle elevation-2"
                    alt="{{ Auth::guard('admin')->user()->first_name }} {{ Auth::guard('admin')->user()->last_name }}">
            </div>
            <div class="info">
                <a href="{{ route('admin.personal.profile') }}" class="d-block">
                    {{ Auth::guard('admin')->user()->first_name }}
                    {{ Auth::guard('admin')->user()->last_name }}
                </a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class with font-awesome or any other icon font library -->
                <li class="nav-item">
                    <a href="{{ route('admin.dashboard.index', $clinic->id) }}"
                        class="nav-link 
                        {{ Route::is('admin.dashboard.index', $clinic->id) ? 'active' : '' }}
                    ">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            @lang('menus.admins.sidebar.dashboard')
                        </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('admin.patients.index', $clinic->id) }}"
                        class="nav-link @if ($page_title == trans('pages.patients')) active @endif">
                        <i class="nav-icon fa fa-users"></i>
                        <p>
                            @lang('pages.patients')
                            <span class="badge badge-info right">
                                {{ $clinic->patients_per_clinic() }}
                            </span>
                        </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('admin.appointments.index', $clinic->id) }}"
                        class="nav-link @if ($page_title == trans('pages.appointments')) active @endif">
                        <i class="nav-icon fa fa-check-square"></i>
                        <p>
                            @lang('pages.appointments')
                        </p>
                    </a>
                </li>

                <li class="nav-item has-treeview">
                    <a href="{{ route('admin.doctor.schedules.index', $clinic->id) }}"
                        class="nav-link @if ($page_title == trans('pages.schedule')) active @endif">
                        <i class="nav-icon fa fa-calendar"></i>
                        <p>
                            @lang('pages.schedule')
                        </p>
                    </a>
                </li>

                <li class="nav-item has-treeview @if ($page_title == trans('pages.payments')) menu-open @endif">
                    <a href="#" class="nav-link @if ($page_title == trans('pages.payments')) active @endif">
                        <i class="nav-icon fa fa-money"></i>
                        <p>
                            Payments/ Billing
                            <i class="fa fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.payments.bills.index', $clinic->id) }}"
                                class="nav-link @if (isset($payments_page) && $payments_page == trans('pages.payment_subpage.payments')) active @endif">
                                <i class="fa fa-circle nav-icon"></i>
                                <p>@lang('pages.payment_subpage.payments')</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.payments.closed.bills.index', $clinic->id) }}"
                                class="nav-link @if (isset($payments_page) && $payments_page == trans('pages.payment_subpage.closed')) active @endif">
                                <i class="fa fa-circle nav-icon"></i>
                                <p>@lang('pages.payment_subpage.closed')</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.payments.remittance.index', $clinic->id) }}"
                                class="nav-link @if (isset($payments_page) && $payments_page == trans('pages.payment_subpage.remittance')) active @endif">
                                <i class="fa fa-circle nav-icon"></i>
                                <p>@lang('pages.payment_subpage.remittance')</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item has-treeview">
                    <a href="{{ route('admin.orders.index', $clinic->id) }}"
                        class="nav-link @if ($page_title == trans('pages.orders')) active @endif">
                        <i class="nav-icon fa fa-cubes"></i>
                        <p>
                            @lang('pages.orders')
                        </p>
                    </a>
                </li>

                <li class="nav-item has-treeview">

                    <a href="#" class="nav-link">
                        <i class="nav-icon fa fa-database"></i>
                        <p>
                            Assets
                            <i class="fa fa-angle-left right"></i>
                        </p>
                    </a>

                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.assets.index', $clinic->id) }}" class="nav-link">
                                <i class="fa fa-circle nav-icon"></i>
                                <p>Assets</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.asset.tranfer.index', $clinic->id) }}" class="nav-link">
                                <i class="fa fa-circle nav-icon"></i>
                                <p>Transfered Assets</p>
                            </a>
                        </li>
                    </ul>

                </li>

                <li class="nav-item">
                    <a href="{{ route('admin.users.index', $clinic->id) }}"
                        class="nav-link @if ($page_title == trans('pages.users')) active @endif">
                        <i class="nav-icon fa fa-users"></i>
                        <p>
                            @lang('pages.users')
                        </p>
                    </a>
                </li>

                <li class="nav-header">
                    @lang('menus.admins.sidebar.headers.inventory')
                </li>

                <li class="nav-item">

                    <a href="{{ route('admin.clinic.inventory.frames.stocks.index', $clinic->id) }}"
                        class="nav-link
                                {{ Route::is('admin.clinic.inventory.frames.stocks.index', $clinic->id) ? 'active' : '' }}
                                ">
                        <i class="fas fa-chart-area nav-icon"></i>
                        <p>
                            @lang('menus.admins.sidebar.inventory.frames.title')
                        </p>
                    </a>
                </li>

                <li class="nav-item">

                    <a href="{{ route('admin.clinic.inventory.cases.stock.index', $clinic->id) }}"
                        class="nav-link
                                {{ Route::is('admin.clinic.inventory.cases.stock.index', $clinic->id) ? 'active' : '' }}
                                ">
                        <i class="fas fa-chart-bar nav-icon"></i>
                        <p>
                            @lang('menus.admins.sidebar.inventory.cases.title')
                        </p>
                    </a>
                </li>

                <li class="nav-header">
                    @lang('menus.admins.sidebar.headers.reports')
                </li>

                <li class="nav-item">
                    <a href="{{ route('admin.reports.main.index', $clinic->id) }}"
                        class="nav-link 
                        {{ Route::is('admin.reports.main.index', $clinic->id) ? 'active' : '' }}">
                        <i class="nav-icon fa fa-file-excel-o"></i>
                        <p>
                            @lang('menus.admins.sidebar.reports.main')
                        </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('admin.payments.reports.index', $clinic->id) }}"
                        class="nav-link 
                        {{ Route::is('admin.payments.reports.index', $clinic->id) ? 'active' : '' }}">
                        <i class="nav-icon fa fa-file-excel-o"></i>
                        <p>
                            @lang('menus.admins.sidebar.reports.payments')
                        </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('admin.order.reports.index', $clinic->id) }}"
                        class="nav-link 
                        {{ Route::is('admin.order.reports.index', $clinic->id) ? 'active' : '' }}
                        ">
                        <i class="nav-icon fa fa-file-excel-o"></i>
                        <p>
                            @lang('menus.admins.sidebar.reports.orders')
                        </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('admin.tat.reports.index', $clinic->id) }}"
                        class="nav-link 
                        {{ Route::is('admin.tat.reports.index', $clinic->id) ? 'active' : '' }}
                        ">
                        <i class="nav-icon fa fa-file-excel-o"></i>
                        <p>
                            @lang('menus.admins.sidebar.reports.tat')
                        </p>
                    </a>
                </li>

                <li class="nav-header">
                    @lang('menus.admins.sidebar.headers.settings')
                </li>

                <li class="nav-item">
                    <a href="{{ route('admin.clinics.view', $clinic->id) }}" class="nav-link">
                        <i class="nav-icon fa fa-cogs"></i>
                        <p>
                            Settings
                        </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('admin.organization.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            HQ Dashboard
                        </p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!--.sidebar-->
</aside>
