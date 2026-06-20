@php
    $route = Route::currentRouteName(); // e.g.  products.add
    $url = url()->current(); // needed only for ?status links
@endphp

<!-- Sidebar Menu -->
<nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

        {{-- ==================== ADMIN ONLY ==================== --}}
        @if (Auth::user()->role == 'admin')
            <li class="nav-item {{ in_array($route, ['users.add', 'users.view']) ? 'menu-open' : '' }}">
                <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-copy"></i>
                    <p>Manage User <i class="fas fa-angle-left right"></i></p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{ route('users.add') }}" class="nav-link {{ $route == 'users.add' ? 'active' : '' }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Add User</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('users.view') }}"
                            class="nav-link {{ $route == 'users.view' ? 'active' : '' }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>User List</p>
                        </a>
                    </li>
                </ul>
            </li>
        @endif

        {{-- ==================== PROFILE (all users) ==================== --}}
        <li class="nav-item {{ in_array($route, ['profiles.view', 'profiles.password.view']) ? 'menu-open' : '' }}">
            <a href="#" class="nav-link">
                <i class="nav-icon fas fa-copy"></i>
                <p>Manage Profile <i class="fas fa-angle-left right"></i></p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="{{ route('profiles.view') }}"
                        class="nav-link {{ $route == 'profiles.view' ? 'active' : '' }}">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Your Profile</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('profiles.password.view') }}"
                        class="nav-link {{ $route == 'profiles.password.view' ? 'active' : '' }}">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Change Password</p>
                    </a>
                </li>
            </ul>
        </li>

        {{-- ==================== ADMIN ONLY (the big block) ==================== --}}
        @if (Auth::user()->role == 'admin')
            {{-- Logo --}}
            <li class="nav-item {{ $route == 'logos.view' ? 'menu-open' : '' }}">
                <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-copy"></i>
                    <p>Manage Logo <i class="fas fa-angle-left right"></i></p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{ route('logos.view') }}"
                            class="nav-link {{ $route == 'logos.view' ? 'active' : '' }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Logo List</p>
                        </a>
                    </li>
                </ul>
            </li>

            {{-- Banners --}}
            <li class="nav-item {{ $route == 'banners.view' ? 'menu-open' : '' }}">
                <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-copy"></i>
                    <p>Manage Banners <i class="fas fa-angle-left right"></i></p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{ route('banners.view') }}"
                            class="nav-link {{ $route == 'banners.view' ? 'active' : '' }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Banner List</p>
                        </a>
                    </li>
                </ul>
            </li>

            {{-- Sliders --}}
            <li class="nav-item {{ in_array($route, ['sliders.add', 'sliders.view']) ? 'menu-open' : '' }}">
                <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-copy"></i>
                    <p>Manage Slider <i class="fas fa-angle-left right"></i></p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{ route('sliders.add') }}"
                            class="nav-link {{ $route == 'sliders.add' ? 'active' : '' }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Add Slider</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('sliders.view') }}"
                            class="nav-link {{ $route == 'sliders.view' ? 'active' : '' }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Slider List</p>
                        </a>
                    </li>
                </ul>
            </li>

            {{-- About --}}
            <li class="nav-item {{ $route == 'abouts.view' ? 'menu-open' : '' }}">
                <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-copy"></i>
                    <p>Manage About <i class="fas fa-angle-left right"></i></p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{ route('abouts.view') }}"
                            class="nav-link {{ $route == 'abouts.view' ? 'active' : '' }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Update About</p>
                        </a>
                    </li>
                </ul>
            </li>

            {{-- Settings --}}
            <li
                class="nav-item {{ in_array($route, ['settings.view', 'settings.commission.index']) ? 'menu-open' : '' }}">
                <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-copy"></i>
                    <p>Site settings <i class="fas fa-angle-left right"></i></p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{ route('settings.view') }}"
                            class="nav-link {{ $route == 'settings.view' ? 'active' : '' }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Meta Settings</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('settings.commission.index') }}"
                            class="nav-link {{ $route == 'settings.commission.index' ? 'active' : '' }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Commission Settings</p>
                        </a>
                    </li>
                </ul>
            </li>

            {{-- Pages --}}
            <li class="nav-item {{ $route == 'pages.index' ? 'menu-open' : '' }}">
                <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-copy"></i>
                    <p>Manage Pages <i class="fas fa-angle-left right"></i></p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{ route('pages.index') }}"
                            class="nav-link {{ $route == 'pages.index' ? 'active' : '' }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Update Page</p>
                        </a>
                    </li>
                </ul>
            </li>

            {{-- Reports --}}
            <li
                class="nav-item {{ in_array($route, [
                    'reports.refer_commission',
                    'reports.reseller_commission',
                    'reports.vendor_sales_reports',
                    'reports.admin_commission_for_vendor_product_sales',
                    'reports.dropshipper_history',
                ])
                    ? 'menu-open'
                    : '' }}">
                <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-copy"></i>
                    <p>Reports <i class="fas fa-angle-left right"></i></p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{ route('reports.refer_commission') }}"
                            class="nav-link {{ $route == 'reports.refer_commission' ? 'active' : '' }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Refer Commission</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('reports.reseller_commission') }}"
                            class="nav-link {{ $route == 'reports.reseller_commission' ? 'active' : '' }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Reseller Commission</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('reports.vendor_sales_reports') }}"
                            class="nav-link {{ $route == 'reports.vendor_sales_reports' ? 'active' : '' }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Vendor Sales</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('reports.admin_commission_for_vendor_product_sales') }}"
                            class="nav-link {{ $route == 'reports.admin_commission_for_vendor_product_sales' ? 'active' : '' }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Admin Commission</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('reports.dropshipper_history') }}"
                            class="nav-link {{ $route == 'reports.dropshipper_history' ? 'active' : '' }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Dropshipper History</p>
                        </a>
                    </li>
                </ul>
            </li>

            {{-- Payment Gateway --}}
            <li class="nav-item {{ $route == 'paymentgatways.view' ? 'menu-open' : '' }}">
                <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-copy"></i>
                    <p>Manage Payment Gateway <i class="fas fa-angle-left right"></i></p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{ route('paymentgatways.view') }}"
                            class="nav-link {{ $route == 'paymentgatways.view' ? 'active' : '' }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>View Payment Gateway</p>
                        </a>
                    </li>
                </ul>
            </li>

            {{-- SMS Gateway --}}
            <li class="nav-item {{ in_array($route, ['smsgateways.view', 'smsgateways.test.page']) ? 'menu-open' : '' }}">
                <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-copy"></i>
                    <p>Manage Sms Settings <i class="fas fa-angle-left right"></i></p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{ route('smsgateways.view') }}"
                            class="nav-link {{ $route == 'smsgateways.view' ? 'active' : '' }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>View Sms</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('smsgateways.test.page') }}"
                            class="nav-link {{ $route == 'smsgateways.test.page' ? 'active' : '' }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Test Sms</p>
                        </a>
                    </li>
                </ul>
            </li>

            {{-- Contact --}}
            <li class="nav-item {{ in_array($route, ['contacts.view', 'contacts.communicate']) ? 'menu-open' : '' }}">
                <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-copy"></i>
                    <p>Manage Contact <i class="fas fa-angle-left right"></i></p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{ route('contacts.view') }}"
                            class="nav-link {{ $route == 'contacts.view' ? 'active' : '' }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>View Contact</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('contacts.communicate') }}"
                            class="nav-link {{ $route == 'contacts.communicate' ? 'active' : '' }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>View Communication</p>
                        </a>
                    </li>
                </ul>
            </li>

            {{-- Category --}}
            <li class="nav-item {{ in_array($route, ['categories.add', 'categories.view']) ? 'menu-open' : '' }}">
                <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-copy"></i>
                    <p>Manage Category <i class="fas fa-angle-left right"></i></p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{ route('categories.add') }}"
                            class="nav-link {{ $route == 'categories.add' ? 'active' : '' }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Add Category</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('categories.view') }}"
                            class="nav-link {{ $route == 'categories.view' ? 'active' : '' }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Category List</p>
                        </a>
                    </li>
                </ul>
            </li>

            {{-- Sub-Category --}}
            <li
                class="nav-item {{ in_array($route, ['subcategories.add', 'subcategories.view']) ? 'menu-open' : '' }}">
                <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-copy"></i>
                    <p>Manage Sub Category <i class="fas fa-angle-left right"></i></p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{ route('subcategories.add') }}"
                            class="nav-link {{ $route == 'subcategories.add' ? 'active' : '' }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Add Subcategory</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('subcategories.view') }}"
                            class="nav-link {{ $route == 'subcategories.view' ? 'active' : '' }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Subcategory List</p>
                        </a>
                    </li>
                </ul>
            </li>

            {{-- Brand --}}
            <li class="nav-item {{ in_array($route, ['brands.add', 'brands.view']) ? 'menu-open' : '' }}">
                <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-copy"></i>
                    <p>Manage Brand <i class="fas fa-angle-left right"></i></p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{ route('brands.add') }}"
                            class="nav-link {{ $route == 'brands.add' ? 'active' : '' }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Add Brand</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('brands.view') }}"
                            class="nav-link {{ $route == 'brands.view' ? 'active' : '' }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Brand List</p>
                        </a>
                    </li>
                </ul>
            </li>

            {{-- Color --}}
            <li class="nav-item {{ in_array($route, ['colors.add', 'colors.view']) ? 'menu-open' : '' }}">
                <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-copy"></i>
                    <p>Manage Color <i class="fas fa-angle-left right"></i></p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{ route('colors.add') }}"
                            class="nav-link {{ $route == 'colors.add' ? 'active' : '' }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Add Color</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('colors.view') }}"
                            class="nav-link {{ $route == 'colors.view' ? 'active' : '' }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Color List</p>
                        </a>
                    </li>
                </ul>
            </li>

            {{-- Size --}}
            <li class="nav-item {{ in_array($route, ['sizes.add', 'sizes.view']) ? 'menu-open' : '' }}">
                <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-copy"></i>
                    <p>Manage Size <i class="fas fa-angle-left right"></i></p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{ route('sizes.add') }}"
                            class="nav-link {{ $route == 'sizes.add' ? 'active' : '' }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Add Size</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('sizes.view') }}"
                            class="nav-link {{ $route == 'sizes.view' ? 'active' : '' }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Size List</p>
                        </a>
                    </li>
                </ul>
            </li>

            {{-- Coupon --}}
            <li class="nav-item {{ in_array($route, ['coupons.add', 'coupons.view']) ? 'menu-open' : '' }}">
                <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-copy"></i>
                    <p>Manage Coupon <i class="fas fa-angle-left right"></i></p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{ route('coupons.add') }}"
                            class="nav-link {{ $route == 'coupons.add' ? 'active' : '' }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Add Coupon</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('coupons.view') }}"
                            class="nav-link {{ $route == 'coupons.view' ? 'active' : '' }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Coupon List</p>
                        </a>
                    </li>
                </ul>
            </li>

            {{-- Delivery (Charge + Courier) --}}
            <li
                class="nav-item {{ $route == 'areas.division' || request()->routeIs('couriers.*') ? 'menu-open' : '' }}">
                <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-copy"></i>
                    <p>Delivery <i class="fas fa-angle-left right"></i></p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{ route('areas.division') }}"
                            class="nav-link {{ $route == 'areas.division' ? 'active' : '' }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Charge Info</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('couriers.index') }}"
                            class="nav-link {{ request()->routeIs('couriers.*') ? 'active' : '' }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Courier Settings</p>
                        </a>
                    </li>
                </ul>
            </li>
        @endif

        {{-- ==================== PRODUCTS (all users) ==================== --}}
        <li class="nav-item {{ Str::startsWith($route, 'products.') ? 'menu-open' : '' }}">
            <a href="#" class="nav-link">
                <i class="nav-icon fas fa-copy"></i>
                <p>Manage Products <i class="fas fa-angle-left right"></i></p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="{{ route('products.add') }}"
                        class="nav-link {{ $route == 'products.add' ? 'active' : '' }}">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Add Product</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('products.pending.view') }}"
                        class="nav-link {{ $route == 'products.pending.view' ? 'active' : '' }}">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Total Pending Product</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('products.inactive.view') }}"
                        class="nav-link {{ $route == 'products.inactive.view' ? 'active' : '' }}">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Total Inactive Product</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('products.view') }}"
                        class="nav-link {{ $route == 'products.view' ? 'active' : '' }}">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Total Product Lists</p>
                    </a>
                </li>
            </ul>
        </li>

        {{-- ==================== ADMIN ONLY (Customers, Vendors, …) ==================== --}}
        @if (Auth::user()->role == 'admin')
            {{-- Customers --}}
            <li class="nav-item {{ in_array($route, ['customers.view', 'customers.draft.view']) ? 'menu-open' : '' }}">
                <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-copy"></i>
                    <p>Manage customers <i class="fas fa-angle-left right"></i></p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{ route('customers.view') }}"
                            class="nav-link {{ $route == 'customers.view' ? 'active' : '' }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Customer List</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('customers.draft.view') }}"
                            class="nav-link {{ $route == 'customers.draft.view' ? 'active' : '' }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Draft Customer</p>
                        </a>
                    </li>
                </ul>
            </li>

            {{-- Vendors (query-string tabs) --}}
            <li class="nav-item {{ Str::startsWith($route, 'vendors.') ? 'menu-open' : '' }}">
                <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-copy"></i>
                    <p>Manage Vendor <i class="fas fa-angle-left right"></i></p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{ route('vendors.view') }}?active"
                            class="nav-link {{ $url == route('vendors.view') . '?active' ? 'active' : '' }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Active Vendor List</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('vendors.view') }}?inactive"
                            class="nav-link {{ $url == route('vendors.view') . '?inactive' ? 'active' : '' }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Inactive Vendor List</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('vendors.view') }}?suspended"
                            class="nav-link {{ $url == route('vendors.view') . '?suspended' ? 'active' : '' }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Suspended Vendor List</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('vendors.view') }}?paid"
                            class="nav-link {{ $url == route('vendors.view') . '?paid' ? 'active' : '' }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Paid Vendor List</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('vendors.draft.view') }}?unpaid"
                            class="nav-link {{ $url == route('vendors.draft.view') . '?unpaid' ? 'active' : '' }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Unpaid Vendor List</p>
                        </a>
                    </li>
                </ul>
            </li>

            {{-- Dropshippers (query-string tabs) --}}
            <li class="nav-item {{ Str::startsWith($route, 'dropshippers.') ? 'menu-open' : '' }}">
                <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-copy"></i>
                    <p>Manage Dropshipper <i class="fas fa-angle-left right"></i></p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{ route('dropshippers.view') }}?active"
                            class="nav-link {{ $url == route('dropshippers.view') . '?active' ? 'active' : '' }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Dropshipper List</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('dropshippers.view') }}?inactive"
                            class="nav-link {{ $url == route('dropshippers.view') . '?inactive' ? 'active' : '' }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Inactive Dropshipper List</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('dropshippers.view') }}?suspended"
                            class="nav-link {{ $url == route('dropshippers.view') . '?suspended' ? 'active' : '' }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Suspended Dropshipper List</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('dropshippers.view') }}?paid"
                            class="nav-link {{ $url == route('dropshippers.view') . '?paid' ? 'active' : '' }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Paid Dropshipper List</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('dropshippers.draft.view') }}?unpaid"
                            class="nav-link {{ $url == route('dropshippers.draft.view') . '?unpaid' ? 'active' : '' }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Unpaid Dropshipper List</p>
                        </a>
                    </li>
                </ul>
            </li>

            {{-- Sellers (query-string tabs) --}}
            <li class="nav-item {{ Str::startsWith($route, 'sellers.') ? 'menu-open' : '' }}">
                <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-copy"></i>
                    <p>Manage Sellers <i class="fas fa-angle-left right"></i></p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{ route('sellers.view') }}?active"
                            class="nav-link {{ $url == route('sellers.view') . '?active' ? 'active' : '' }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Active Seller List</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('sellers.view') }}?inactive"
                            class="nav-link {{ $url == route('sellers.view') . '?inactive' ? 'active' : '' }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Inactive Seller List</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('sellers.view') }}?suspended"
                            class="nav-link {{ $url == route('sellers.view') . '?suspended' ? 'active' : '' }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Suspended Seller List</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('sellers.view') }}?paid"
                            class="nav-link {{ $url == route('sellers.view') . '?paid' ? 'active' : '' }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Paid Seller List</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('sellers.view') }}?unpaid"
                            class="nav-link {{ $url == route('sellers.view') . '?unpaid' ? 'active' : '' }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Unpaid Seller List</p>
                        </a>
                    </li>
                </ul>
            </li>

            {{-- Wallet --}}
            <li class="nav-item {{ in_array($route, ['wallets.view', 'varified.account']) ? 'menu-open' : '' }}">
                <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-copy"></i>
                    <p>Manage wallet <i class="fas fa-angle-left right"></i></p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{ route('wallets.view') }}"
                            class="nav-link {{ $route == 'wallets.view' ? 'active' : '' }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Wallet List</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('varified.account') }}"
                            class="nav-link {{ $route == 'varified.account' ? 'active' : '' }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Verified Account</p>
                        </a>
                    </li>
                </ul>
            </li>

            {{-- Subscriptions --}}
            <li class="nav-item {{ $route == 'subscriptions.view' ? 'menu-open' : '' }}">
                <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-copy"></i>
                    <p>Manage subscription <i class="fas fa-angle-left right"></i></p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{ route('subscriptions.view') }}"
                            class="nav-link {{ $route == 'subscriptions.view' ? 'active' : '' }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Subscription List</p>
                        </a>
                    </li>
                </ul>
            </li>
        @endif

        {{-- ==================== ORDERS ==================== --}}
        <li class="nav-item {{ Str::startsWith($route, 'orders.') ? 'menu-open' : '' }}">
            <a href="#" class="nav-link">
                <i class="nav-icon fas fa-copy"></i>
                <p>Manage Orders <i class="fas fa-angle-left right"></i></p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="{{ route('orders.all.list') }}"
                        class="nav-link {{ $route == 'orders.all.list' ? 'active' : '' }}">
                        <i class="far fa-circle nav-icon"></i>
                        <p>All Orders</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('orders.pending.list') }}"
                        class="nav-link {{ $route == 'orders.pending.list' ? 'active' : '' }}">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Total Order Pending</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('orders.delivered.list') }}"
                        class="nav-link {{ $route == 'orders.delivered.list' ? 'active' : '' }}">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Total Order Delivered</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('orders.return.list') }}"
                        class="nav-link {{ $route == 'orders.return.list' ? 'active' : '' }}">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Total Order Return</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('orders.canceled.list') }}"
                        class="nav-link {{ $route == 'orders.canceled.list' ? 'active' : '' }}">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Total Order Cancel</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('orders.courier.list') }}"
                        class="nav-link {{ $route == 'orders.courier.list' ? 'active' : '' }}">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Courier Assigned Orders</p>
                    </a>
                </li>

                @if (Auth::user()->role == 'admin')
                    <li class="nav-item">
                        <a href="{{ route('orders.seller.list') }}"
                            class="nav-link {{ $route == 'orders.seller.list' ? 'active' : '' }}">
                            <i class="far fa-circle nav-icon"></i>
                            <p>From Seller/Vendor Orders</p>
                        </a>
                    </li>
                @endif
            </ul>
        </li>

        {{-- ==================== BUSINESS SETTINGS ==================== --}}
        <li class="nav-item {{ $route == 'color-settings.index' ? 'menu-open' : '' }}">
            <a href="#" class="nav-link">
                <i class="nav-icon fas fa-palette"></i>
                <p>Manage Business Setting <i class="fas fa-angle-left right"></i></p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="{{ route('color-settings.index') }}"
                        class="nav-link {{ $route == 'color-settings.index' ? 'active' : '' }}">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Color Setting</p>
                    </a>
                </li>
            </ul>
        </li>

    </ul>
</nav>
