<aside class="main-sidebar elevation-4 sidebar-light-primary">
    <!-- Brand Logo -->
    <a href="#" class="brand-link navbar-primary">
        <img src="{{ asset('storage/logo/AdminLTELogo.png') }}" alt="AdminLTE Logo"
            class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">Clinic App</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ asset('storage/admin/' . Auth::guard()->user()->profile) }}" class="img-circle elevation-2"
                    alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">{{ Auth::guard('admin')->user()->first_name }}
                    {{ Auth::guard('admin')->user()->last_name }}</a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class with font-awesome or any other icon font library -->
                <li class="nav-item">
                    <a href="{{ route('admin.dashboard.workshop.index', $workshop->id) }}" class="nav-link 
                        {{ Route::is('admin.dashboard.workshop.index', $workshop->id) ? 'active' : '' }}
                        ">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            @lang('menus.admins.sidebar.dashboard')
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
                            <a href="{{ route('admin.workshop.assets.index', $workshop->id) }}" class="nav-link">
                                <i class="fa fa-circle nav-icon"></i>
                                <p>Assets</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.workshop.assets.transfer.index', $workshop->id) }}"
                                class="nav-link">
                                <i class="fa fa-circle nav-icon"></i>
                                <p>Transfered Assets</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fa fa-check-square"></i>
                        <p>
                            Orders
                            <i class="right fa fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.workshop.orders.index', $workshop->id) }}" class="nav-link">
                                <i class="fa fa-circle nav-icon"></i>
                                <p>Orders</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fa fa-bar-chart"></i>
                        <p>
                            Sales
                            <i class="right fa fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.workshop.sales.index', $workshop->id) }}" class="nav-link">
                                <i class="fa fa-circle nav-icon"></i>
                                <p>Sales</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fa fa-users"></i>
                        <p>
                            Technicians
                            <i class="fa fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.workshop.technicians.index', $workshop->id) }}" class="nav-link">
                                <i class="fa fa-circle nav-icon"></i>
                                <p>Technicians</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-header">
                    @lang('menus.admins.sidebar.headers.inventory')
                </li>


                <li class="nav-item">
                    <a href="{{ route('admin.workshop.inventory.lens.stocks.index', $workshop->id) }}"
                        class="nav-link
                        {{ Route::is('admin.workshop.inventory.lens.stocks.index', $workshop->id) ? 'active' : '' }}
                        ">
                        <i class="nav-icon fas fa-eye"></i>
                        <p>
                            @lang('menus.admins.sidebar.inventory.lenses.title')
                        </p>
                    </a>
                </li>


                <li class="nav-item">
                    <a href="{{ route('admin.workshop.inventory.cases.stock.index', $workshop->id) }}"
                        class="nav-link
                        {{ Route::is('admin.workshop.inventory.cases.stock.index', $workshop->id) ? 'active' : '' }}
                        ">
                        <i class="nav-icon fas fa-chart-bar"></i>
                        <p>
                            @lang('menus.admins.sidebar.inventory.cases.title')
                        </p>
                    </a>
                </li>


                <li class="nav-header">REPORTS</li>

                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fa fa-file-excel-o"></i>
                        <p>
                            Reports
                        </p>
                    </a>
                </li>

                <li class="nav-header">SETTINGS</li>

                <li class="nav-item">
                    <a href="{{ route('admin.workshop.view', $workshop->id) }}" class="nav-link">
                        <i class="nav-icon fa fa-cogs"></i>
                        <p>
                            Settings
                        </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('admin.organization.index') }}" class="nav-link">
                        <i class="nav-icon fa fa-database"></i>
                        <p>
                            Clinics
                        </p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!--.sidebar-->
</aside>
