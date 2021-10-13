<div class="left-side-bar">
    <div class="brand-logo">
        <a href="index.html">
            <img src="{{ asset('assets/vendors/images/deskapp-logo.svg') }}" alt="" class="dark-logo">
            <img src="{{ asset('assets/vendors/images/deskapp-logo-white.svg') }}" alt="" class="light-logo">
        </a>
        <div class="close-sidebar" data-toggle="left-sidebar-close">
            <i class="ion-close-round"></i>
        </div>
    </div>
    <div class="menu-block customscroll">
        <div class="sidebar-menu">
            <ul id="accordion-menu">
                <li>
                    <a href="{{ route('dashboard') }}" class="dropdown-toggle no-arrow">
                        <span class="micon dw dw-house-1"></span><span class="mtext">Dashboard</span>
                    </a>
                </li>
                <li class="dropdown {{ in_array($route, $customers) ? 'show' : ''}}">
                    <a href="javascript:;" class="dropdown-toggle">
                        <span class="micon dw dw-user3"></span><span class="mtext">Customers</span>
                    </a>
                    <ul class="submenu">
                        <li><a href="{{ route('customers.index') }}" class="{{ $route == 'customers.index'? 'active' : ''}}">List</a></li>
                        <li><a href="{{ route('customers.create') }}" class="{{ $route == 'customers.create'? 'active' : ''}}">New</a></li>
                    </ul>
                </li>
                <li class="dropdown {{ in_array($route, $invoices) ? 'show' : ''}}">
                    <a href="javascript:;" class="dropdown-toggle">
                        <span class="micon dw dw-user3"></span><span class="mtext">Invoices</span>
                    </a>
                    <ul class="submenu">
                        <li><a href="{{ route('invoices.index') }}" class="{{ $route == 'invoices.index'? 'active' : ''}}">List</a></li>
                        <li><a href="{{ route('invoices.create') }}" class="{{ $route == 'invoices.create'? 'active' : ''}}">New</a></li>
                    </ul>
                </li>
                <li class="dropdown {{ in_array($route, $reports) ? 'show' : ''}}">
                    <a href="javascript:;" class="dropdown-toggle">
                        <span class="micon dw dw-apartment"></span><span class="mtext">Reports</span>
                    </a>
                    <ul class="submenu">
                        <li class="dropdown {{ $route == 'reports.customers'? 'show' : ''}}">
                            <a href="javascript:;" class="dropdown-toggle">
                                <span class="micon fa fa-plug"></span><span class="mtext">Customers</span>
                            </a>
                            <ul class="submenu child">
                                <li><a href="{{ route('reports.customers') }}" class="{{ $route == 'reports.customers'? 'active' : ''}}">Customers</a></li>
                            </ul>
                        </li>
                        <li class="dropdown show">
                            <a href="javascript:;" class="dropdown-toggle">
                                <span class="micon fa fa-plug"></span><span class="mtext">Invoices</span>
                            </a>
                            <ul class="submenu child">
                                <li><a href="{{ route('reports.invoices') }}" class="{{ $route == 'reports.invoices'? 'active' : ''}}">All</a></li>
                                <li><a href="{{ route('reports.invoices',['status' => 'due']) }}" class="{{ $route == 'reports.invoices'? 'active' : ''}}"> Due</a></li>
                                <li><a href="{{ route('reports.invoices',['status' => 'paid']) }}" class="{{ $route == 'reports.invoices'? 'active' : ''}}"> Paid</a></li>
                                <li><a href="{{ route('reports.invoices',['status' => 'partial']) }}" class="{{ $route == 'reports.invoices'? 'active' : ''}}"> Paid</a></li>
                            </ul>
                        </li>
                    </ul>
                </li>
                <li>
                    <form class="dropdown-toggle no-arrow" method="POST" action="{{ route('logout') }}">
                        @csrf
                        <span class="micon dw dw-logout"></span>
                        <x-dropdown-link class="link-logout" style="padding-left: 0!important" :href="route('logout')"
                                onclick="event.preventDefault();
                                            this.closest('form').submit();">
                            {{ __('Log Out') }}
                        </x-dropdown-link>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</div>