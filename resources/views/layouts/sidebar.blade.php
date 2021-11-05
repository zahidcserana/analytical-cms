<div class="left-side-bar">
    <div class="brand-logo">
        <a href="{{ route('dashboard') }}">
            <img src="{{ asset('assets/vendors/images/analyticalj.png') }}" alt="" class="dark-logo">
            <img src="{{ asset('assets/vendors/images/analyticalj.png') }}" alt="" class="light-logo">
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
                        <span class="micon dw dw-user-2"></span><span class="mtext">Customers</span>
                    </a>
                    <ul class="submenu">
                        <li><a href="{{ route('customers.index') }}" class="{{ $route == 'customers.index'? 'active' : ''}}">List</a></li>
                        <li><a href="{{ route('customers.create') }}" class="{{ $route == 'customers.create'? 'active' : ''}}">New</a></li>
                    </ul>
                </li>
                <li class="dropdown {{ in_array($route, $invoices) ? 'show' : ''}}">
                    <a href="javascript:;" class="dropdown-toggle">
                        <span class="micon dw dw-invoice"></span><span class="mtext">Invoices</span>
                    </a>
                    <ul class="submenu">
                        <li><a href="{{ route('invoices.index') }}" class="{{ $route == 'invoices.index'? 'active' : ''}}">List</a></li>
                        <li><a href="{{ route('invoices.create') }}" class="{{ $route == 'invoices.create'? 'active' : ''}}">Corporate Bill</a></li>
                        <li><a href="{{ route('invoices.create', ['type' => 2]) }}" class="{{ $uri == '/invoices?type=2'? 'active' : ''}}">Local Bill</a></li>
                    </ul>
                </li>
                <li class="dropdown {{ in_array($route, $payments) ? 'show' : ''}}">
                    <a href="javascript:;" class="dropdown-toggle">
                        <span class="micon dw dw-money"></span><span class="mtext">Payments</span>
                    </a>
                    <ul class="submenu">
                        <li><a href="{{ route('payments.index') }}" class="{{ $route == 'payments.index'? 'active' : ''}}">List</a></li>
                        <li><a href="{{ route('payments.create') }}" class="{{ $route == 'payments.create'? 'active' : ''}}">New</a></li>
                    </ul>
                </li>
                <li>
                    <div class="dropdown-divider"></div>
                </li>
                <li>
                    <div class="sidebar-small-cap">Reports</div>
                </li>
                <li class="dropdown {{ $route == 'reports.customers'? 'show' : ''}}">
                    <a href="javascript:;" class="dropdown-toggle">
                        <span class="micon dw dw-calculator"></span><span class="mtext">Customers</span>
                    </a>
                    <ul class="submenu child">
                        <li><a href="{{ route('reports.customers') }}" class="{{ $route == 'reports.customers'? 'active' : ''}}">Customers</a></li>
                    </ul>
                </li>
                <li class="dropdown {{ $route == 'reports.invoices'? 'show' : ''}}">
                    <a href="javascript:;" class="dropdown-toggle">
                        <span class="micon dw dw-computer-1"></span><span class="mtext">Invoices</span>
                    </a>
                    <ul class="submenu child">
                        <li><a href="{{ route('reports.invoices') }}" class="{{ $uri == '/reports/invoices'? 'active' : ''}}">All</a></li>
                        <li><a href="{{ route('reports.invoices',['status' => 'due']) }}" class="{{ $uri == '/reports/invoices?status=due'? 'active' : ''}}"> Due</a></li>
                        <li><a href="{{ route('reports.invoices',['status' => 'paid']) }}" class="{{ $uri == '/reports/invoices?status=paid'? 'active' : ''}}"> Paid</a></li>
                        <li><a href="{{ route('reports.invoices',['status' => 'pending']) }}" class="{{ $uri == '/reports/invoices?status=pending'? 'active' : ''}}"> Pending</a></li>
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