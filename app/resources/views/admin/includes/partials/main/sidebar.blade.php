<aside class="main-sidebar elevation-4 sidebar-light-primary">
    <!-- Brand Logo -->
    <a href="{{ route('admin.organization.index') }}" class="brand-link navbar-primary">
        <img src="{{ asset('storage/logo/AdminLTELogo.png') }}" alt="AdminLTE Logo"
            class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">
            {{ config('app.name') }}
        </span>
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
                <li class="nav-item ">
                    <a href="{{ route('admin.organization.index') }}"
                        class="nav-link 
                    {{ Route::is('admin.organization.index') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            @lang('admin.page.dashboard.title')
                        </p>
                    </a>
                </li>

                <li class="nav-item has-treeview">
                    <a href="{{ route('admin.clinics.index') }}"
                        class="nav-link
                    {{ Route::is('admin.clinics.index') ? 'active' : '' }}
                    ">
                        <i class="nav-icon fa fa-database"></i>
                        <p>
                            @lang('admin.page.clinic.title')
                        </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('admin.workshop.index') }}"
                        class="nav-link
                    {{ Route::is('admin.workshop.index') ? 'active' : '' }}
                    ">
                        <i class="nav-icon fas fa-building"></i>
                        <p>
                            @lang('admin.page.workshop.title')
                        </p>
                    </a>
                </li>



                <li class="nav-header">
                    @lang('admin.header.inventory')
                </li>

                <li class="nav-item has-treeview 
                {{ Route::is('admin.hq.frame.stocks.index') ? 'menu-open' : '' }}
                {{ Route::is('admin.hq.frame.purchases.index') ? 'menu-open' : '' }}
                {{ Route::is('admin.hq.frame.transfers.index') ? 'menu-open' : '' }}
                ">
                    <a href="#" class="nav-link
                    {{ Route::is('admin.hq.frame.stocks.index') ? 'active' : '' }}
                    {{ Route::is('admin.hq.frame.purchases.index') ? 'active' : '' }}
                    {{ Route::is('admin.hq.frame.transfers.index') ? 'active' : '' }}
                    ">
                        <i class="nav-icon fas fa-address-card"></i>
                        <p>
                            @lang('admin.page.frames.title')
                            <i class="fa fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.hq.frame.stocks.index') }}" class="nav-link
                            {{ Route::is('admin.hq.frame.stocks.index') ? 'active' : '' }}
                            ">
                                <i class="fa fa-circle nav-icon"></i>
                                <p>@lang('admin.page.frames.sub_page.frame_stocks')</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('admin.hq.frame.purchases.index') }}" class="nav-link
                            {{ Route::is('admin.hq.frame.purchases.index') ? 'active' : '' }}
                            ">
                                <i class="fa fa-circle nav-icon"></i>
                                <p>
                                    @lang('admin.page.frames.sub_page.purchases')
                                </p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('admin.hq.frame.transfers.index') }}" class="nav-link
                            {{ Route::is('admin.hq.frame.transfers.index') ? 'active' : '' }}
                            ">
                                <i class="fa fa-circle nav-icon"></i>
                                <p>@lang('admin.page.frames.sub_page.transfers')</p>
                            </a>
                        </li>

                       
                    </ul>
                </li>

                <li class="nav-item has-treeview
                {{ Route::is('admin.hq.lenses.stocks.index') ? 'menu-open' : '' }}
                {{ Route::is('admin.hq.lenses.purchases.index') ? 'menu-open' : '' }}
                {{ Route::is('admin.hq.lenses.transfers.index') ? 'menu-open' : '' }}
                ">
                    <a href="#" class="nav-link
                    {{ Route::is('admin.hq.lenses.stocks.index') ? 'active' : '' }}
                    {{ Route::is('admin.hq.lenses.purchases.index') ? 'active' : '' }}
                    {{ Route::is('admin.hq.lenses.transfers.index') ? 'active' : '' }}
                    ">
                        <i class="nav-icon fas fa-eye"></i>
                        <p>
                            @lang('admin.page.lenses.title')
                            <i class="fa fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.hq.lenses.stocks.index') }}" class="nav-link 
                            {{ Route::is('admin.hq.lenses.stocks.index') ? 'active' : '' }}
                            ">
                                <i class="fa fa-circle nav-icon"></i>
                                <p>@lang('admin.page.lenses.sub_page.lense_stock')</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('admin.hq.lenses.purchases.index') }}" class="nav-link
                            {{ Route::is('admin.hq.lenses.purchases.index') ? 'active' : '' }}
                            ">
                                <i class="fa fa-circle nav-icon"></i>
                                <p>@lang('admin.page.lenses.sub_page.purchases')</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('admin.hq.lenses.transfers.index') }}" class="nav-link
                            {{ Route::is('admin.hq.lenses.transfers.index') ? 'active' : '' }}
                            ">
                                <i class="fa fa-circle nav-icon"></i>
                                <p>@lang('admin.page.lenses.sub_page.transfers')</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item has-treeview
                {{ Route::is('admin.hq.cases.stocks.index') ? 'menu-open' : '' }}
                {{ Route::is('admin.hq.cases.purchases.index') ? 'menu-open' : ''  }}
                {{ Route::is('admin.hq.cases.transfers.index') ? 'menu-open' : '' }}
                ">
                    <a href="#" class="nav-link
                    {{ Route::is('admin.hq.cases.stocks.index') ? 'active' : '' }}
                    {{ Route::is('admin.hq.cases.purchases.index') ? 'active' : ''  }}
                    {{ Route::is('admin.hq.cases.transfers.index') ? 'active' : '' }}
                    ">
                        <i class="nav-icon fas fa-briefcase-medical"></i>
                        <p>
                            @lang('admin.page.cases.title')
                            <i class="fa fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.hq.cases.stocks.index') }}" class="nav-link
                            {{ Route::is('admin.hq.cases.stocks.index') ? 'active' : '' }}
                            ">
                                <i class="fa fa-circle nav-icon"></i>
                                <p>@lang('admin.page.cases.sub_page.case_stocks')</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('admin.hq.cases.purchases.index') }}" class="nav-link
                            {{ Route::is('admin.hq.cases.purchases.index') ? 'active' : ''  }}
                            ">
                                <i class="fa fa-circle nav-icon"></i>
                                <p>@lang('admin.page.cases.sub_page.purchases')</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('admin.hq.cases.transfers.index') }}" class="nav-link
                            {{ Route::is('admin.hq.cases.transfers.index') ? 'active' : '' }}
                            ">
                                <i class="fa fa-circle nav-icon"></i>
                                <p>@lang('admin.page.cases.sub_page.transfers')</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-header">
                    @lang('menus.admins.sidebar.headers.reports')
                </li>

                <li class="nav-item">
                    <a href="{{ route('admin.clinics.reports.index') }}"
                        class="nav-link
                    {{ Route::is('admin.clinics.reports.index') ? 'active' : '' }}
                    ">
                        <i class="nav-icon fa fa-line-chart"></i>
                        <p>
                            @lang('menus.admins.sidebar.reports.main')
                        </p>
                    </a>
                </li>

                <li class="nav-header">@lang('admin.header.user_management')</li>

                <li class="nav-item">
                    <a href="{{ route('admin.admins.index') }}"
                        class="nav-link
                    {{ Route::is('admin.admins.index') ? 'active' : '' }}
                    ">
                        <i class="nav-icon fas fa-user-cog"></i>
                        <p>
                            @lang('admin.page.admins.title')
                        </p>
                    </a>
                </li>


                <li class="nav-header">SETTINGS</li>

                <li class="nav-item">
                    <a href="{{ route('admin.organization.view') }}"
                        class="nav-link 
                    {{ Route::is('admin.organization.view') ? 'active' : '' }}">
                        <i class="nav-icon fa fa-bank"></i>
                        <p>
                            Organizaton
                        </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('admin.settings.index') }}"
                        class="nav-link
                        {{ Route::is('admin.settings.index') ? 'active' : '' }}
                        ">
                        <i class="nav-icon fa fa-gear"></i>
                        <p>
                            @lang('admin.page.settings.title')
                        </p>
                    </a>
                </li>

            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
