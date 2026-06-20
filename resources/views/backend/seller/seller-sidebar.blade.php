@php
    use Illuminate\Support\Str;

    $routeName = Route::currentRouteName();

    // Helper function to check if current route starts with a prefix of route names
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

        {{-- Admin Menu --}}
        @if (Auth::user()->role === 'admin')
            <li class="nav-item {{ isMenuOpen(['users.'], $routeName) ? 'menu-open' : '' }}">
                <a href="#" class="nav-link {{ isMenuOpen(['users.'], $routeName) ? 'active' : '' }}">
                    <i class="nav-icon fas fa-users"></i>
                    <p>
                        Manage Users
                        <i class="fas fa-angle-left right"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{ route('users.add') }}"
                            class="nav-link {{ $routeName === 'users.add' ? 'active' : '' }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Add User</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('users.view') }}"
                            class="nav-link {{ $routeName === 'users.view' ? 'active' : '' }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>User List</p>
                        </a>
                    </li>
                </ul>
            </li>
        @endif

        {{-- Paid Users Section --}}
        @if (auth()->user()->payment_status == 1)

            {{-- Refer --}}
            <li class="nav-item {{ isMenuOpen(['sellers.refer.'], $routeName) ? 'menu-open' : '' }}">
                <a href="#" class="nav-link {{ isMenuOpen(['sellers.refer.'], $routeName) ? 'active' : '' }}">
                    <i class="nav-icon fas fa-copy"></i>
                    <p>
                        Refer
                        <i class="fas fa-angle-left right"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{ route('sellers.refer.list') }}"
                            class="nav-link {{ $routeName === 'sellers.refer.list' ? 'active' : '' }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Refer List</p>
                        </a>
                    </li>
                </ul>
            </li>

            {{-- Profile --}}
            <li class="nav-item {{ isMenuOpen(['sellers.'], $routeName) ? 'menu-open' : '' }}">
                <a href="#" class="nav-link {{ isMenuOpen(['sellers.'], $routeName) ? 'active' : '' }}">
                    <i class="nav-icon fas fa-user"></i>
                    <p>
                        Manage Profile
                        <i class="fas fa-angle-left right"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{ route('sellers.view.profile') }}"
                            class="nav-link {{ $routeName === 'sellers.view.profile' ? 'active' : '' }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Your Profile</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('sellers.password.view') }}"
                            class="nav-link {{ $routeName === 'sellers.password.view' ? 'active' : '' }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Change Password</p>
                        </a>
                    </li>
                </ul>
            </li>

            {{-- Products --}}
            <li
                class="nav-item {{ isMenuOpen(['sellers.', 'vendor.', 'dropshipper.product.'], $routeName) ? 'menu-open' : '' }}">
                <a href="#"
                    class="nav-link {{ isMenuOpen(['sellers.', 'vendor.', 'dropshipper.product.'], $routeName) ? 'active' : '' }}">
                    <i class="nav-icon fas fa-boxes"></i>
                    <p>
                        Manage Products
                        <i class="fas fa-angle-left right"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    @if (auth()->user()->usertype === 'seller')
                        <li class="nav-item">
                            <a href="{{ route('sellers.shopkeeper_product') }}"
                                class="nav-link {{ $routeName === 'sellers.shopkeeper_product' ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Usupershop Product</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('sellers.seller_product') }}"
                                class="nav-link {{ $routeName === 'sellers.seller_product' ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>My Products</p>
                            </a>
                        </li>
                    @endif

                    @if (auth()->user()->usertype === 'vendor')
                        <li class="nav-item">
                            <a href="{{ route('vendor.productview') }}"
                                class="nav-link {{ $routeName === 'vendor.productview' ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Product Lists</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('vendor.addproduct') }}"
                                class="nav-link {{ $routeName === 'vendor.addproduct' ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Add Product</p>
                            </a>
                        </li>
                    @endif

                    @if (auth()->user()->usertype === 'dropshipper')
                        <li class="nav-item">
                            <a href="{{ route('dropshipper.product.list') }}"
                                class="nav-link {{ $routeName === 'dropshipper.product.list' ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Product Lists</p>
                            </a>
                        </li>
                    @endif
                </ul>
            </li>

            {{-- Orders --}}
            <li class="nav-item {{ isMenuOpen(['seller.orders.'], $routeName) ? 'menu-open' : '' }}">
                <a href="#" class="nav-link {{ isMenuOpen(['seller.orders.'], $routeName) ? 'active' : '' }}">
                    <i class="nav-icon fas fa-shopping-cart"></i>
                    <p>
                        Manage Orders
                        <i class="fas fa-angle-left right"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{ route('seller.orders.pending.list') }}"
                            class="nav-link {{ $routeName === 'seller.orders.pending.list' ? 'active' : '' }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Pending Orders</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('seller.orders.confirmed.list') }}"
                            class="nav-link {{ $routeName === 'seller.orders.confirmed.list' ? 'active' : '' }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Confirmed Orders</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('seller.orders.packaging.list') }}"
                            class="nav-link {{ $routeName === 'seller.orders.packaging.list' ? 'active' : '' }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>packaging Orders</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('seller.orders.shipment.list') }}"
                            class="nav-link {{ $routeName === 'seller.orders.shipment.list' ? 'active' : '' }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>shipment Orders</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('seller.orders.cancel.list') }}"
                            class="nav-link {{ $routeName === 'seller.orders.cancel.list' ? 'active' : '' }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Cancel Orders</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('seller.orders.return.list') }}"
                            class="nav-link {{ $routeName === 'seller.orders.return.list' ? 'active' : '' }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Return Orders</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('seller.orders.delivered.list') }}"
                            class="nav-link {{ $routeName === 'seller.orders.delivered.list' ? 'active' : '' }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Delivered Orders</p>
                        </a>
                    </li>
                </ul>
            </li>

            {{-- Reports --}}
            <li class="nav-item {{ isMenuOpen(['seller.reports.'], $routeName) ? 'menu-open' : '' }}">
                <a href="#" class="nav-link {{ isMenuOpen(['seller.reports.'], $routeName) ? 'active' : '' }}">
                    <i class="nav-icon fas fa-chart-line"></i>
                    <p>
                        Reports
                        <i class="fas fa-angle-left right"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    @if (auth()->user()->usertype === 'vendor')
                        <li class="nav-item">
                            <a href="{{ route('seller.reports.sales') }}"
                                class="nav-link {{ $routeName === 'seller.reports.sales' ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Product Sales</p>
                            </a>
                        </li>
                    @endif
                    @if (auth()->user()->usertype === 'seller')
                        <li class="nav-item">
                            <a href="{{ route('seller.reports.reseller_commission_reports') }}"
                                class="nav-link {{ $routeName === 'seller.reports.reseller_commission_reports' ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Reseller Commission</p>
                            </a>
                        </li>
                    @endif
                    <li class="nav-item">
                        <a href="{{ route('seller.reports.refer') }}"
                            class="nav-link {{ $routeName === 'seller.reports.refer' ? 'active' : '' }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Refer Commission</p>
                        </a>
                    </li>
                </ul>
            </li>

            {{-- Wallets --}}
            <li class="nav-item {{ isMenuOpen(['manage.wallets'], $routeName) ? 'menu-open' : '' }}">
                <a href="#" class="nav-link {{ isMenuOpen(['manage.wallets'], $routeName) ? 'active' : '' }}">
                    <i class="nav-icon fas fa-wallet"></i>
                    <p>
                        Manage Wallets
                        <i class="fas fa-angle-left right"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{ route('manage.wallets.payment') }}"
                            class="nav-link {{ $routeName === 'manage.wallets.payment' ? 'active' : '' }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Payment</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('manage.wallets') }}"
                            class="nav-link {{ $routeName === 'manage.wallets' ? 'active' : '' }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Wallet</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('manage.wallets.verified') }}"
                            class="nav-link {{ $routeName === 'manage.wallets.verified' ? 'active' : '' }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Verified</p>
                        </a>
                    </li>
                </ul>
            </li>

        @endif

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
