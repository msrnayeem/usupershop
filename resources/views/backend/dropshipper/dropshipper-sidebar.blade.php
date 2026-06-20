@php
    use Illuminate\Support\Str;

    $routeName = Route::currentRouteName();

    function isMenuOpen(array $routes, $currentRoute)
    {
        foreach ($routes as $r) {
            if (Str::startsWith($currentRoute, $r)) {
                return true;
            }
        }
        return false;
    }
@endphp

<!-- Sidebar Menu -->
<nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

        {{-- Dashboard --}}
        <li class="nav-item">
            <a href="{{ route('dropshipper.dashboard') }}"
                class="nav-link {{ $routeName === 'dropshipper.dashboard' ? 'active' : '' }}">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>Dashboard</p>
            </a>
        </li>

        {{-- Refer --}}
        @if (auth()->user()->payment_status == 1)
            <li class="nav-item {{ isMenuOpen(['dropshipper.refer.'], $routeName) ? 'menu-open' : '' }}">
                <a href="#" class="nav-link {{ isMenuOpen(['dropshipper.refer.'], $routeName) ? 'active' : '' }}">
                    <i class="nav-icon fas fa-copy"></i>
                    <p>
                        Refer
                        <i class="fas fa-angle-left right"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{ route('dropshipper.refer.list') }}"
                            class="nav-link {{ $routeName === 'dropshipper.refer.list' ? 'active' : '' }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Refer List</p>
                        </a>
                    </li>
                </ul>
            </li>
        @endif

        {{-- Profile --}}
        <li
            class="nav-item {{ isMenuOpen(['dropshipper.view.profile', 'dropshipper.edit.profile', 'dropshipper.password.view'], $routeName) ? 'menu-open' : '' }}">
            <a href="#"
                class="nav-link {{ isMenuOpen(['dropshipper.view.profile', 'dropshipper.password.view'], $routeName) ? 'active' : '' }}">
                <i class="nav-icon fas fa-user"></i>
                <p>
                    Manage Profile
                    <i class="fas fa-angle-left right"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="{{ route('dropshipper.view.profile') }}"
                        class="nav-link {{ $routeName === 'dropshipper.view.profile' ? 'active' : '' }}">
                        <i class="far fa-circle nav-icon"></i>
                        <p>View Profile</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('dropshipper.password.view') }}"
                        class="nav-link {{ $routeName === 'dropshipper.password.view' ? 'active' : '' }}">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Change Password</p>
                    </a>
                </li>
            </ul>
        </li>

        {{-- Products --}}
        <li
            class="nav-item {{ isMenuOpen(['dropshipper.product.', 'dropshipper.shopkeeper_product', 'dropshipper.vendor.product'], $routeName) ? 'menu-open' : '' }}">
            <a href="#"
                class="nav-link {{ isMenuOpen(['dropshipper.product.', 'dropshipper.vendor.product'], $routeName) ? 'active' : '' }}">
                <i class="nav-icon fas fa-boxes"></i>
                <p>
                    Manage Products
                    <i class="fas fa-angle-left right"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="{{ route('dropshipper.shopkeeper_product') }}"
                        class="nav-link {{ $routeName === 'dropshipper.shopkeeper_product' ? 'active' : '' }}">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Shopkeeper Products</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('dropshipper.product.list') }}"
                        class="nav-link {{ $routeName === 'dropshipper.product.list' ? 'active' : '' }}">
                        <i class="far fa-circle nav-icon"></i>
                        <p>My Products</p>
                    </a>
                </li>
                {{-- <li class="nav-item">
                    <a href="{{ route('dropshipper.vendor.product.list') }}"
                        class="nav-link {{ $routeName === 'dropshipper.vendor.product.list' ? 'active' : '' }}">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Vendor Products</p>
                    </a>
                </li> --}}
            </ul>
        </li>

        {{-- Orders --}}
        <li class="nav-item {{ isMenuOpen(['dropshipper.orders.'], $routeName) ? 'menu-open' : '' }}">
            <a href="#" class="nav-link {{ isMenuOpen(['dropshipper.orders.'], $routeName) ? 'active' : '' }}">
                <i class="nav-icon fas fa-shopping-cart"></i>
                <p>
                    Manage Orders
                    <i class="fas fa-angle-left right"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                {{-- <li class="nav-item">
                    <a href="{{ route('dropshipper.orders.create') }}"
                        class="nav-link {{ $routeName === 'dropshipper.orders.create' ? 'active' : '' }}">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Place Order</p>
                    </a>
                </li> --}}
                <li class="nav-item">
                    <a href="{{ route('dropshipper.orders.pending.list') }}"
                        class="nav-link {{ $routeName === 'dropshipper.orders.pending.list' ? 'active' : '' }}">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Pending Orders</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('dropshipper.orders.confirmed.list') }}"
                        class="nav-link {{ $routeName === 'dropshipper.orders.confirmed.list' ? 'active' : '' }}">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Confirmed Orders</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('dropshipper.orders.packaging.list') }}"
                        class="nav-link {{ $routeName === 'dropshipper.orders.packaging.list' ? 'active' : '' }}">
                        <i class="far fa-circle nav-icon"></i>
                        <p>packaging Orders</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('dropshipper.orders.shipment.list') }}"
                        class="nav-link {{ $routeName === 'dropshipper.orders.shipment.list' ? 'active' : '' }}">
                        <i class="far fa-circle nav-icon"></i>
                        <p>shipment Orders</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('dropshipper.orders.cancel.list') }}"
                        class="nav-link {{ $routeName === 'dropshipper.orders.cancel.list' ? 'active' : '' }}">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Cancel Orders</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('dropshipper.orders.return.list') }}"
                        class="nav-link {{ $routeName === 'dropshipper.orders.return.list' ? 'active' : '' }}">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Return Orders</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('dropshipper.orders.delivered.list') }}"
                        class="nav-link {{ $routeName === 'dropshipper.orders.delivered.list' ? 'active' : '' }}">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Delivered Orders</p>
                    </a>
                </li>
            </ul>
        </li>

        {{-- Reports --}}
        <li class="nav-item {{ isMenuOpen(['dropshipper.reports.'], $routeName) ? 'menu-open' : '' }}">
            <a href="#" class="nav-link {{ isMenuOpen(['dropshipper.reports.'], $routeName) ? 'active' : '' }}">
                <i class="nav-icon fas fa-chart-line"></i>
                <p>
                    Reports
                    <i class="fas fa-angle-left right"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="{{ route('dropshipper.reports.sales') }}"
                        class="nav-link {{ $routeName === 'dropshipper.reports.sales' ? 'active' : '' }}">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Sales Report</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('dropshipper.reports.refer') }}"
                        class="nav-link {{ $routeName === 'dropshipper.reports.refer' ? 'active' : '' }}">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Refer Commission</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('dropshipper.reports.commission') }}"
                        class="nav-link {{ $routeName === 'dropshipper.reports.commission' ? 'active' : '' }}">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Reseller Commission</p>
                    </a>
                </li>
            </ul>
        </li>

        {{-- Wallet --}}
        <li
            class="nav-item {{ isMenuOpen(['dropshipper.wallet.', 'dropshipper.manage.wallets'], $routeName) ? 'menu-open' : '' }}">
            <a href="#"
                class="nav-link {{ isMenuOpen(['dropshipper.wallet.', 'dropshipper.manage.wallets'], $routeName) ? 'active' : '' }}">
                <i class="nav-icon fas fa-wallet"></i>
                <p>
                    Wallet & Payments
                    <i class="fas fa-angle-left right"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="{{ route('dropshipper.wallet.index') }}"
                        class="nav-link {{ $routeName === 'dropshipper.wallet.index' ? 'active' : '' }}">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Wallet</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('dropshipper.wallet.verified') }}"
                        class="nav-link {{ $routeName === 'dropshipper.wallet.verified' ? 'active' : '' }}">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Verified Wallets</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('dropshipper.wallet.payment') }}"
                        class="nav-link {{ $routeName === 'dropshipper.wallet.payment' ? 'active' : '' }}">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Payment Methods</p>
                    </a>
                </li>
            </ul>
        </li>

        {{-- Refer --}}
        {{-- <li class="nav-item">
            <a href="{{ route('dropshipper.refer.list') }}"
                class="nav-link {{ $routeName === 'dropshipper.refer.list' ? 'active' : '' }}">
                <i class="nav-icon fas fa-user-friends"></i>
                <p>Refer List</p>
            </a>
        </li> --}}

        {{-- Logout --}}
        <li class="nav-item">
            <a href="{{ route('logout') }}"
                onclick="event.preventDefault();document.getElementById('logout-form').submit();" class="nav-link">
                <i class="nav-icon fas fa-lock"></i>
                <p>Logout</p>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
            </a>
        </li>
    </ul>
</nav>
