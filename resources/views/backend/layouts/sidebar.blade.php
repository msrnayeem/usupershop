@php
    $route = Route::currentRouteName();
    $url   = url()->full();
@endphp

<div class="sidebar-section-label">Main</div>
<ul class="nav-group">
    <li class="nav-item">
        <a href="{{ route('home') }}" class="nav-link {{ $route == 'home' ? 'active' : '' }}">
            <i class="nav-icon fas fa-th-large"></i>
            <p>Dashboard</p>
        </a>
    </li>
</ul>

{{-- ==================== CONTENT ==================== --}}
<div class="sidebar-section-label">Content</div>
<ul class="nav-group">

    {{-- Logo --}}
    @if (Auth::user()->role == 'admin')
    <li class="nav-item {{ $route == 'logos.view' ? 'menu-open' : '' }}">
        <a href="#" class="nav-link" data-toggle="treeview">
            <i class="nav-icon fas fa-image"></i>
            <p>Logo <i class="fas fa-angle-left right"></i></p>
        </a>
        <ul class="nav-treeview">
            <li class="nav-item">
                <a href="{{ route('logos.view') }}" class="nav-link {{ $route == 'logos.view' ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon"></i><p>Logo List</p>
                </a>
            </li>
        </ul>
    </li>

    {{-- Banners --}}
    <li class="nav-item {{ $route == 'banners.view' ? 'menu-open' : '' }}">
        <a href="#" class="nav-link" data-toggle="treeview">
            <i class="nav-icon fas fa-images"></i>
            <p>Banners <i class="fas fa-angle-left right"></i></p>
        </a>
        <ul class="nav-treeview">
            <li class="nav-item">
                <a href="{{ route('banners.view') }}" class="nav-link {{ $route == 'banners.view' ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon"></i><p>Banner List</p>
                </a>
            </li>
        </ul>
    </li>

    {{-- Sliders --}}
    <li class="nav-item {{ in_array($route, ['sliders.add','sliders.view']) ? 'menu-open' : '' }}">
        <a href="#" class="nav-link" data-toggle="treeview">
            <i class="nav-icon fas fa-film"></i>
            <p>Sliders <i class="fas fa-angle-left right"></i></p>
        </a>
        <ul class="nav-treeview">
            <li class="nav-item">
                <a href="{{ route('sliders.add') }}" class="nav-link {{ $route == 'sliders.add' ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon"></i><p>Add Slider</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('sliders.view') }}" class="nav-link {{ $route == 'sliders.view' ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon"></i><p>Slider List</p>
                </a>
            </li>
        </ul>
    </li>

    {{-- About --}}
    <li class="nav-item {{ $route == 'abouts.view' ? 'menu-open' : '' }}">
        <a href="#" class="nav-link" data-toggle="treeview">
            <i class="nav-icon fas fa-info-circle"></i>
            <p>About <i class="fas fa-angle-left right"></i></p>
        </a>
        <ul class="nav-treeview">
            <li class="nav-item">
                <a href="{{ route('abouts.view') }}" class="nav-link {{ $route == 'abouts.view' ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon"></i><p>Update About</p>
                </a>
            </li>
        </ul>
    </li>

    {{-- Pages --}}
    <li class="nav-item {{ $route == 'pages.index' ? 'menu-open' : '' }}">
        <a href="#" class="nav-link" data-toggle="treeview">
            <i class="nav-icon fas fa-file-alt"></i>
            <p>Pages <i class="fas fa-angle-left right"></i></p>
        </a>
        <ul class="nav-treeview">
            <li class="nav-item">
                <a href="{{ route('pages.index') }}" class="nav-link {{ $route == 'pages.index' ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon"></i><p>Manage Pages</p>
                </a>
            </li>
        </ul>
    </li>
    @endif

</ul>

{{-- ==================== CATALOG ==================== --}}
<div class="sidebar-section-label">Catalog</div>
<ul class="nav-group">

    {{-- Products (all users) --}}
    <li class="nav-item {{ Str::startsWith($route, 'products.') ? 'menu-open' : '' }}">
        <a href="#" class="nav-link" data-toggle="treeview">
            <i class="nav-icon fas fa-box-open"></i>
            <p>Products <i class="fas fa-angle-left right"></i></p>
        </a>
        <ul class="nav-treeview">
            <li class="nav-item">
                <a href="{{ route('products.add') }}" class="nav-link {{ $route == 'products.add' ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon"></i><p>Add Product</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('products.view') }}" class="nav-link {{ $route == 'products.view' ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon"></i><p>All Products</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('products.pending.view') }}" class="nav-link {{ $route == 'products.pending.view' ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Pending <span class="badge badge-warning">{{ \App\Models\Product::where('status',2)->count() }}</span></p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('products.inactive.view') }}" class="nav-link {{ $route == 'products.inactive.view' ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon"></i><p>Inactive</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('products.stockout.view') }}" class="nav-link {{ $route == 'products.stockout.view' ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Stock Out <span class="badge badge-danger">{{ \App\Models\Product::where('quantity','<=',0)->where('status',1)->count() }}</span></p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('products.lowstock.view') }}" class="nav-link {{ $route == 'products.lowstock.view' ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Low Stock <span class="badge badge-warning">{{ \App\Models\Product::where('quantity','>',0)->where('quantity','<=',5)->where('status',1)->count() }}</span></p>
                </a>
            </li>
        </ul>
    </li>

    @if (Auth::user()->role == 'admin')
    {{-- Categories --}}
    <li class="nav-item {{ in_array($route, ['categories.add','categories.view']) ? 'menu-open' : '' }}">
        <a href="#" class="nav-link" data-toggle="treeview">
            <i class="nav-icon fas fa-tags"></i>
            <p>Categories <i class="fas fa-angle-left right"></i></p>
        </a>
        <ul class="nav-treeview">
            <li class="nav-item">
                <a href="{{ route('categories.add') }}" class="nav-link {{ $route == 'categories.add' ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon"></i><p>Add Category</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('categories.view') }}" class="nav-link {{ $route == 'categories.view' ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon"></i><p>Category List</p>
                </a>
            </li>
        </ul>
    </li>

    {{-- Sub-Category --}}
    <li class="nav-item {{ in_array($route, ['subcategories.add','subcategories.view']) ? 'menu-open' : '' }}">
        <a href="#" class="nav-link" data-toggle="treeview">
            <i class="nav-icon fas fa-tag"></i>
            <p>Sub Categories <i class="fas fa-angle-left right"></i></p>
        </a>
        <ul class="nav-treeview">
            <li class="nav-item">
                <a href="{{ route('subcategories.add') }}" class="nav-link {{ $route == 'subcategories.add' ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon"></i><p>Add Subcategory</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('subcategories.view') }}" class="nav-link {{ $route == 'subcategories.view' ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon"></i><p>Subcategory List</p>
                </a>
            </li>
        </ul>
    </li>

    {{-- Brand --}}
    <li class="nav-item {{ in_array($route, ['brands.add','brands.view']) ? 'menu-open' : '' }}">
        <a href="#" class="nav-link" data-toggle="treeview">
            <i class="nav-icon fas fa-trademark"></i>
            <p>Brands <i class="fas fa-angle-left right"></i></p>
        </a>
        <ul class="nav-treeview">
            <li class="nav-item">
                <a href="{{ route('brands.add') }}" class="nav-link {{ $route == 'brands.add' ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon"></i><p>Add Brand</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('brands.view') }}" class="nav-link {{ $route == 'brands.view' ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon"></i><p>Brand List</p>
                </a>
            </li>
        </ul>
    </li>

    {{-- Color --}}
    <li class="nav-item {{ in_array($route, ['colors.add','colors.view']) ? 'menu-open' : '' }}">
        <a href="#" class="nav-link" data-toggle="treeview">
            <i class="nav-icon fas fa-palette"></i>
            <p>Colors <i class="fas fa-angle-left right"></i></p>
        </a>
        <ul class="nav-treeview">
            <li class="nav-item">
                <a href="{{ route('colors.add') }}" class="nav-link {{ $route == 'colors.add' ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon"></i><p>Add Color</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('colors.view') }}" class="nav-link {{ $route == 'colors.view' ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon"></i><p>Color List</p>
                </a>
            </li>
        </ul>
    </li>

    {{-- Size --}}
    <li class="nav-item {{ in_array($route, ['sizes.add','sizes.view']) ? 'menu-open' : '' }}">
        <a href="#" class="nav-link" data-toggle="treeview">
            <i class="nav-icon fas fa-ruler"></i>
            <p>Sizes <i class="fas fa-angle-left right"></i></p>
        </a>
        <ul class="nav-treeview">
            <li class="nav-item">
                <a href="{{ route('sizes.add') }}" class="nav-link {{ $route == 'sizes.add' ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon"></i><p>Add Size</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('sizes.view') }}" class="nav-link {{ $route == 'sizes.view' ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon"></i><p>Size List</p>
                </a>
            </li>
        </ul>
    </li>
    @endif

</ul>

{{-- ==================== ORDERS ==================== --}}
<div class="sidebar-section-label">Orders</div>
<ul class="nav-group">

    <li class="nav-item {{ Str::startsWith($route, 'orders.') ? 'menu-open' : '' }}">
        <a href="#" class="nav-link" data-toggle="treeview">
            <i class="nav-icon fas fa-shopping-cart"></i>
            <p>Orders <i class="fas fa-angle-left right"></i></p>
        </a>
        <ul class="nav-treeview">
            <li class="nav-item">
                <a href="{{ route('orders.all.list') }}" class="nav-link {{ $route == 'orders.all.list' ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon"></i><p>All Orders</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('orders.pending.list') }}" class="nav-link {{ $route == 'orders.pending.list' ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon"></i><p>Pending</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('orders.delivered.list') }}" class="nav-link {{ $route == 'orders.delivered.list' ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon"></i><p>Delivered</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('orders.return.list') }}" class="nav-link {{ $route == 'orders.return.list' ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon"></i><p>Returned</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('orders.canceled.list') }}" class="nav-link {{ $route == 'orders.canceled.list' ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon"></i><p>Cancelled</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('orders.courier.list') }}" class="nav-link {{ $route == 'orders.courier.list' ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon"></i><p>Courier Assigned</p>
                </a>
            </li>
            @if (Auth::user()->role == 'admin')
            <li class="nav-item">
                <a href="{{ route('orders.seller.list') }}" class="nav-link {{ $route == 'orders.seller.list' ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon"></i><p>Seller/Vendor Orders</p>
                </a>
            </li>
            @endif
        </ul>
    </li>

    @if (Auth::user()->role == 'admin')
    {{-- Coupons --}}
    <li class="nav-item {{ in_array($route, ['coupons.add','coupons.view']) ? 'menu-open' : '' }}">
        <a href="#" class="nav-link" data-toggle="treeview">
            <i class="nav-icon fas fa-ticket-alt"></i>
            <p>Coupons <i class="fas fa-angle-left right"></i></p>
        </a>
        <ul class="nav-treeview">
            <li class="nav-item">
                <a href="{{ route('coupons.add') }}" class="nav-link {{ $route == 'coupons.add' ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon"></i><p>Add Coupon</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('coupons.view') }}" class="nav-link {{ $route == 'coupons.view' ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon"></i><p>Coupon List</p>
                </a>
            </li>
        </ul>
    </li>
    @endif

</ul>

{{-- ==================== USERS ==================== --}}
@if (Auth::user()->role == 'admin')
<div class="sidebar-section-label">Users</div>
<ul class="nav-group">

    {{-- Admin Users --}}
    <li class="nav-item {{ in_array($route, ['users.add','users.view']) ? 'menu-open' : '' }}">
        <a href="#" class="nav-link" data-toggle="treeview">
            <i class="nav-icon fas fa-user-shield"></i>
            <p>Admin Users <i class="fas fa-angle-left right"></i></p>
        </a>
        <ul class="nav-treeview">
            <li class="nav-item">
                <a href="{{ route('users.add') }}" class="nav-link {{ $route == 'users.add' ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon"></i><p>Add User</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('users.view') }}" class="nav-link {{ $route == 'users.view' ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon"></i><p>User List</p>
                </a>
            </li>
        </ul>
    </li>

    {{-- Customers --}}
    <li class="nav-item {{ in_array($route, ['customers.view','customers.draft.view']) ? 'menu-open' : '' }}">
        <a href="#" class="nav-link" data-toggle="treeview">
            <i class="nav-icon fas fa-users"></i>
            <p>Customers <i class="fas fa-angle-left right"></i></p>
        </a>
        <ul class="nav-treeview">
            <li class="nav-item">
                <a href="{{ route('customers.view') }}" class="nav-link {{ $route == 'customers.view' ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon"></i><p>Customer List</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('customers.draft.view') }}" class="nav-link {{ $route == 'customers.draft.view' ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon"></i><p>Draft Customers</p>
                </a>
            </li>
        </ul>
    </li>

    {{-- Sellers --}}
    <li class="nav-item {{ Str::startsWith($route, 'sellers.') ? 'menu-open' : '' }}">
        <a href="#" class="nav-link" data-toggle="treeview">
            <i class="nav-icon fas fa-store-alt"></i>
            <p>Sellers <i class="fas fa-angle-left right"></i></p>
        </a>
        <ul class="nav-treeview">
            <li class="nav-item"><a href="{{ route('sellers.view') }}?active" class="nav-link {{ request()->routeIs('sellers.view') && request()->has('active') ? 'active' : '' }}"><i class="far fa-circle nav-icon"></i><p>Active</p></a></li>
            <li class="nav-item"><a href="{{ route('sellers.view') }}?inactive" class="nav-link {{ request()->routeIs('sellers.view') && request()->has('inactive') ? 'active' : '' }}"><i class="far fa-circle nav-icon"></i><p>Inactive</p></a></li>
            <li class="nav-item"><a href="{{ route('sellers.view') }}?suspended" class="nav-link {{ request()->routeIs('sellers.view') && request()->has('suspended') ? 'active' : '' }}"><i class="far fa-circle nav-icon"></i><p>Suspended</p></a></li>
            <li class="nav-item"><a href="{{ route('sellers.view') }}?paid" class="nav-link {{ request()->routeIs('sellers.view') && request()->has('paid') ? 'active' : '' }}"><i class="far fa-circle nav-icon"></i><p>Paid</p></a></li>
            <li class="nav-item"><a href="{{ route('sellers.view') }}?unpaid" class="nav-link {{ request()->routeIs('sellers.view') && request()->has('unpaid') ? 'active' : '' }}"><i class="far fa-circle nav-icon"></i><p>Unpaid</p></a></li>
        </ul>
    </li>

    {{-- Vendors --}}
    <li class="nav-item {{ Str::startsWith($route, 'vendors.') ? 'menu-open' : '' }}">
        <a href="#" class="nav-link" data-toggle="treeview">
            <i class="nav-icon fas fa-building"></i>
            <p>Vendors <i class="fas fa-angle-left right"></i></p>
        </a>
        <ul class="nav-treeview">
            <li class="nav-item"><a href="{{ route('vendors.view') }}?active" class="nav-link {{ request()->routeIs('vendors.view') && request()->has('active') ? 'active' : '' }}"><i class="far fa-circle nav-icon"></i><p>Active</p></a></li>
            <li class="nav-item"><a href="{{ route('vendors.view') }}?inactive" class="nav-link {{ request()->routeIs('vendors.view') && request()->has('inactive') ? 'active' : '' }}"><i class="far fa-circle nav-icon"></i><p>Inactive</p></a></li>
            <li class="nav-item"><a href="{{ route('vendors.view') }}?suspended" class="nav-link {{ request()->routeIs('vendors.view') && request()->has('suspended') ? 'active' : '' }}"><i class="far fa-circle nav-icon"></i><p>Suspended</p></a></li>
            <li class="nav-item"><a href="{{ route('vendors.view') }}?paid" class="nav-link {{ request()->routeIs('vendors.view') && request()->has('paid') ? 'active' : '' }}"><i class="far fa-circle nav-icon"></i><p>Paid</p></a></li>
            <li class="nav-item"><a href="{{ route('vendors.draft.view') }}?unpaid" class="nav-link {{ request()->routeIs('vendors.draft.view') && request()->has('unpaid') ? 'active' : '' }}"><i class="far fa-circle nav-icon"></i><p>Unpaid</p></a></li>
        </ul>
    </li>

    {{-- Dropshippers --}}
    <li class="nav-item {{ Str::startsWith($route, 'dropshippers.') ? 'menu-open' : '' }}">
        <a href="#" class="nav-link" data-toggle="treeview">
            <i class="nav-icon fas fa-people-carry"></i>
            <p>Dropshippers <i class="fas fa-angle-left right"></i></p>
        </a>
        <ul class="nav-treeview">
            <li class="nav-item"><a href="{{ route('dropshippers.view') }}?active" class="nav-link {{ request()->routeIs('dropshippers.view') && request()->has('active') ? 'active' : '' }}"><i class="far fa-circle nav-icon"></i><p>Active</p></a></li>
            <li class="nav-item"><a href="{{ route('dropshippers.view') }}?inactive" class="nav-link {{ request()->routeIs('dropshippers.view') && request()->has('inactive') ? 'active' : '' }}"><i class="far fa-circle nav-icon"></i><p>Inactive</p></a></li>
            <li class="nav-item"><a href="{{ route('dropshippers.view') }}?suspended" class="nav-link {{ request()->routeIs('dropshippers.view') && request()->has('suspended') ? 'active' : '' }}"><i class="far fa-circle nav-icon"></i><p>Suspended</p></a></li>
            <li class="nav-item"><a href="{{ route('dropshippers.view') }}?paid" class="nav-link {{ request()->routeIs('dropshippers.view') && request()->has('paid') ? 'active' : '' }}"><i class="far fa-circle nav-icon"></i><p>Paid</p></a></li>
            <li class="nav-item"><a href="{{ route('dropshippers.draft.view') }}?unpaid" class="nav-link {{ request()->routeIs('dropshippers.draft.view') && request()->has('unpaid') ? 'active' : '' }}"><i class="far fa-circle nav-icon"></i><p>Unpaid</p></a></li>
        </ul>
    </li>

    {{-- Staff --}}
    <li class="nav-item {{ in_array($route, ['staff.index','staff.create','staff.edit']) ? 'menu-open' : '' }}">
        <a href="#" class="nav-link" data-toggle="treeview">
            <i class="nav-icon fas fa-users-cog"></i>
            <p>Staff <span class="badge badge-warning">{{ \App\Models\Staff::where('created_by',auth()->id())->where('is_active',1)->count() }}</span> <i class="fas fa-angle-left right"></i></p>
        </a>
        <ul class="nav-treeview">
            <li class="nav-item"><a href="{{ route('staff.index') }}" class="nav-link {{ $route == 'staff.index' ? 'active' : '' }}"><i class="far fa-circle nav-icon"></i><p>All Staff</p></a></li>
            <li class="nav-item"><a href="{{ route('staff.create') }}" class="nav-link {{ $route == 'staff.create' ? 'active' : '' }}"><i class="far fa-circle nav-icon"></i><p>Add Staff</p></a></li>
        </ul>
    </li>

    {{-- Blocked Accounts --}}
    @php $blockedCount = \App\Models\User::whereNotNull('login_blocked_at')->whereIn('usertype',['seller','vendor','dropshipper','customer'])->count(); @endphp
    @if($blockedCount > 0)
    <li class="nav-item">
        <a href="{{ route('sellers.blocked') }}" class="nav-link {{ $route === 'sellers.blocked' ? 'active' : '' }}">
            <i class="nav-icon fas fa-ban" style="color:var(--red)"></i>
            <p>Blocked Accounts <span class="badge badge-danger">{{ $blockedCount }}</span></p>
        </a>
    </li>
    @endif

</ul>
@endif

{{-- ==================== FINANCE ==================== --}}
@if (Auth::user()->role == 'admin')
<div class="sidebar-section-label">Finance</div>
<ul class="nav-group">

    {{-- Wallet --}}
    <li class="nav-item {{ in_array($route, ['wallets.view','varified.account']) ? 'menu-open' : '' }}">
        <a href="#" class="nav-link" data-toggle="treeview">
            <i class="nav-icon fas fa-wallet"></i>
            <p>Wallets <i class="fas fa-angle-left right"></i></p>
        </a>
        <ul class="nav-treeview">
            <li class="nav-item"><a href="{{ route('wallets.view') }}" class="nav-link {{ $route == 'wallets.view' ? 'active' : '' }}"><i class="far fa-circle nav-icon"></i><p>Wallet List</p></a></li>
            <li class="nav-item"><a href="{{ route('varified.account') }}" class="nav-link {{ $route == 'varified.account' ? 'active' : '' }}"><i class="far fa-circle nav-icon"></i><p>Verified Accounts</p></a></li>
        </ul>
    </li>

    {{-- Withdrawal Methods --}}
    <li class="nav-item">
        <a href="{{ route('withdrawal.methods.index') }}" class="nav-link {{ str_starts_with($route ?? '', 'withdrawal') ? 'active' : '' }}">
            <i class="nav-icon fas fa-money-bill-wave"></i>
            <p>Withdrawal Methods</p>
        </a>
    </li>

    {{-- Subscriptions --}}
    <li class="nav-item {{ Str::startsWith($route ?? '', 'subscriptions.') ? 'menu-open' : '' }}">
        <a href="#" class="nav-link" data-toggle="treeview">
            <i class="nav-icon fas fa-crown"></i>
            <p>Subscriptions <i class="fas fa-angle-left right"></i></p>
        </a>
        <ul class="nav-treeview">
            <li class="nav-item"><a href="{{ route('subscriptions.view') }}" class="nav-link {{ Str::startsWith($route ?? '', 'subscriptions.') ? 'active' : '' }}"><i class="far fa-circle nav-icon"></i><p>Subscription List</p></a></li>
        </ul>
    </li>

    {{-- Payment Gateway --}}
    <li class="nav-item {{ $route == 'paymentgatways.view' ? 'menu-open' : '' }}">
        <a href="#" class="nav-link" data-toggle="treeview">
            <i class="nav-icon fas fa-credit-card"></i>
            <p>Payment Gateway <i class="fas fa-angle-left right"></i></p>
        </a>
        <ul class="nav-treeview">
            <li class="nav-item"><a href="{{ route('paymentgatways.view') }}" class="nav-link {{ $route == 'paymentgatways.view' ? 'active' : '' }}"><i class="far fa-circle nav-icon"></i><p>View Gateway</p></a></li>
        </ul>
    </li>

    {{-- Reports --}}
    <li class="nav-item {{ in_array($route, ['reports.refer_commission','reports.reseller_commission','reports.vendor_sales_reports','reports.admin_commission_for_vendor_product_sales','reports.dropshipper_history']) ? 'menu-open' : '' }}">
        <a href="#" class="nav-link" data-toggle="treeview">
            <i class="nav-icon fas fa-chart-bar"></i>
            <p>Reports <i class="fas fa-angle-left right"></i></p>
        </a>
        <ul class="nav-treeview">
            <li class="nav-item"><a href="{{ route('reports.refer_commission') }}" class="nav-link {{ $route == 'reports.refer_commission' ? 'active' : '' }}"><i class="far fa-circle nav-icon"></i><p>Refer Commission</p></a></li>
            <li class="nav-item"><a href="{{ route('reports.reseller_commission') }}" class="nav-link {{ $route == 'reports.reseller_commission' ? 'active' : '' }}"><i class="far fa-circle nav-icon"></i><p>Reseller Commission</p></a></li>
            <li class="nav-item"><a href="{{ route('reports.vendor_sales_reports') }}" class="nav-link {{ $route == 'reports.vendor_sales_reports' ? 'active' : '' }}"><i class="far fa-circle nav-icon"></i><p>Vendor Sales</p></a></li>
            <li class="nav-item"><a href="{{ route('reports.admin_commission_for_vendor_product_sales') }}" class="nav-link {{ $route == 'reports.admin_commission_for_vendor_product_sales' ? 'active' : '' }}"><i class="far fa-circle nav-icon"></i><p>Admin Commission</p></a></li>
            <li class="nav-item"><a href="{{ route('reports.dropshipper_history') }}" class="nav-link {{ $route == 'reports.dropshipper_history' ? 'active' : '' }}"><i class="far fa-circle nav-icon"></i><p>Dropshipper History</p></a></li>
        </ul>
    </li>

</ul>
@endif

{{-- ==================== DELIVERY ==================== --}}
@if (Auth::user()->role == 'admin')
<div class="sidebar-section-label">Delivery</div>
<ul class="nav-group">

    <li class="nav-item {{ Str::startsWith($route ?? '', 'areas.division') || Str::startsWith($route ?? '', 'couriers') ? 'menu-open' : '' }}">
        <a href="#" class="nav-link" data-toggle="treeview">
            <i class="nav-icon fas fa-shipping-fast"></i>
            <p>Delivery <i class="fas fa-angle-left right"></i></p>
        </a>
        <ul class="nav-treeview">
            <li class="nav-item"><a href="{{ route('areas.division') }}" class="nav-link {{ Str::startsWith($route ?? '', 'areas.division') ? 'active' : '' }}"><i class="far fa-circle nav-icon"></i><p>Charge Info</p></a></li>
            <li class="nav-item">
                <a href="{{ route('couriers.settings') }}" class="nav-link {{ Str::startsWith($route ?? '', 'couriers') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon"></i>
                    <p style="display: inline-flex; align-items: center; gap: 6px; margin: 0; width: 100%;">
                        Courier Settings
                        @php $activeCouriers = \App\Models\Courier::where('is_active', 1)->count(); @endphp
                        <span class="badge {{ $activeCouriers ? 'badge-success' : 'badge-secondary' }}" style="font-size: 10px; padding: 2px 6px; border-radius: 4px;">{{ $activeCouriers ? $activeCouriers.' ON' : 'OFF' }}</span>
                    </p>
                </a>
            </li>
        </ul>
    </li>

    {{-- Contact --}}
    <li class="nav-item {{ in_array($route, ['contacts.view','contacts.communicate']) ? 'menu-open' : '' }}">
        <a href="#" class="nav-link" data-toggle="treeview">
            <i class="nav-icon fas fa-envelope"></i>
            <p>Contact <i class="fas fa-angle-left right"></i></p>
        </a>
        <ul class="nav-treeview">
            <li class="nav-item"><a href="{{ route('contacts.view') }}" class="nav-link {{ $route == 'contacts.view' ? 'active' : '' }}"><i class="far fa-circle nav-icon"></i><p>View Messages</p></a></li>
            <li class="nav-item"><a href="{{ route('contacts.communicate') }}" class="nav-link {{ $route == 'contacts.communicate' ? 'active' : '' }}"><i class="far fa-circle nav-icon"></i><p>Communication</p></a></li>
        </ul>
    </li>

</ul>
@endif

{{-- ==================== SETTINGS ==================== --}}
<div class="sidebar-section-label">Settings</div>
<ul class="nav-group">

    {{-- Profile --}}
    <li class="nav-item {{ Str::startsWith($route ?? '', 'profiles') ? 'menu-open' : '' }}">
        <a href="#" class="nav-link" data-toggle="treeview">
            <i class="nav-icon fas fa-user-circle"></i>
            <p>Profile <i class="fas fa-angle-left right"></i></p>
        </a>
        <ul class="nav-treeview">
            <li class="nav-item"><a href="{{ route('profiles.view') }}" class="nav-link {{ in_array($route, ['profiles.view', 'profiles.edit', 'profiles.update']) ? 'active' : '' }}"><i class="far fa-circle nav-icon"></i><p>Your Profile</p></a></li>
            <li class="nav-item"><a href="{{ route('profiles.password.view') }}" class="nav-link {{ in_array($route, ['profiles.password.view', 'profiles.password.update']) ? 'active' : '' }}"><i class="far fa-circle nav-icon"></i><p>Change Password</p></a></li>
        </ul>
    </li>

    <li class="nav-item {{ Str::startsWith($route ?? '', 'settings.') ? 'menu-open' : '' }}">
        <a href="#" class="nav-link" data-toggle="treeview">
            <i class="nav-icon fas fa-cog"></i>
            <p>Site Settings <i class="fas fa-angle-left right"></i></p>
        </a>
        <ul class="nav-treeview">
            <li class="nav-item"><a href="{{ route('settings.view') }}" class="nav-link {{ in_array($route, ['settings.view', 'settings.edit', 'settings.update']) ? 'active' : '' }}"><i class="far fa-circle nav-icon"></i><p>General</p></a></li>
            <li class="nav-item"><a href="{{ route('settings.commission.index') }}" class="nav-link {{ Str::startsWith($route ?? '', 'settings.commission') ? 'active' : '' }}"><i class="far fa-circle nav-icon"></i><p>Commission</p></a></li>
            <li class="nav-item">
                <a href="{{ route('settings.notification') }}" class="nav-link {{ Str::startsWith($route ?? '', 'settings.notification') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Notifications
                        @php $notifSetting = \App\Models\Setting::first(); @endphp
                        @if(empty($notifSetting->callmebot_api_key))
                            <span class="badge badge-danger">Setup!</span>
                        @else
                            <span class="badge badge-success">✓</span>
                        @endif
                    </p>
                </a>
            </li>
            <li class="nav-item"><a href="{{ route('settings.invoice') }}" class="nav-link {{ Str::startsWith($route ?? '', 'settings.invoice') ? 'active' : '' }}"><i class="far fa-circle nav-icon"></i><p>Invoice</p></a></li>
            <li class="nav-item">
                <a href="{{ route('settings.livechat') }}" class="nav-link {{ Str::startsWith($route ?? '', 'settings.livechat') ? 'active' : '' }}">
                    <i class="far fa-circle nav-icon"></i>
                    <p>Live Chat
                        @php $lc = \App\Models\Setting::first(); @endphp
                        <span class="badge {{ ($lc && $lc->livechat_enabled) ? 'badge-success' : 'badge-secondary' }}">{{ ($lc && $lc->livechat_enabled) ? 'ON' : 'OFF' }}</span>
                    </p>
                </a>
            </li>
            <li class="nav-item"><a href="{{ route('settings.seo') }}" class="nav-link {{ Str::startsWith($route ?? '', 'settings.seo') ? 'active' : '' }}"><i class="far fa-circle nav-icon"></i><p>SEO</p></a></li>
        </ul>
    </li>

    {{-- SMS --}}
    <li class="nav-item {{ in_array($route, ['smsgateways.view','smsgateways.test.page','sms.templates.view']) ? 'menu-open' : '' }}">
        <a href="#" class="nav-link" data-toggle="treeview">
            <i class="nav-icon fas fa-sms"></i>
            <p>SMS Gateway <i class="fas fa-angle-left right"></i></p>
        </a>
        <ul class="nav-treeview">
            <li class="nav-item"><a href="{{ route('smsgateways.view') }}" class="nav-link {{ $route == 'smsgateways.view' ? 'active' : '' }}"><i class="far fa-circle nav-icon"></i><p>SMS Settings</p></a></li>
            <li class="nav-item"><a href="{{ route('smsgateways.test.page') }}" class="nav-link {{ $route == 'smsgateways.test.page' ? 'active' : '' }}"><i class="far fa-circle nav-icon"></i><p>Test SMS</p></a></li>
            <li class="nav-item"><a href="{{ route('sms.templates.view') }}" class="nav-link {{ $route == 'sms.templates.view' ? 'active' : '' }}"><i class="far fa-circle nav-icon"></i><p>SMS Templates</p></a></li>
        </ul>
    </li>

    {{-- Color Settings / Business --}}
    <li class="nav-item {{ $route == 'color-settings.index' ? 'menu-open' : '' }}">
        <a href="#" class="nav-link" data-toggle="treeview">
            <i class="nav-icon fas fa-paint-roller"></i>
            <p>Business Settings <i class="fas fa-angle-left right"></i></p>
        </a>
        <ul class="nav-treeview">
            <li class="nav-item"><a href="{{ route('color-settings.index') }}" class="nav-link {{ $route == 'color-settings.index' ? 'active' : '' }}"><i class="far fa-circle nav-icon"></i><p>Color Settings</p></a></li>
        </ul>
    </li>

    {{-- Recycle Bin --}}
    @if(auth()->user()->usertype === 'admin')
    @php
        $recycleBinCount = 0;
        try {
            $recycleBinCount = \App\Models\Product::onlyTrashed()->count()
                + \App\Models\User::onlyTrashed()->count()
                + \App\Models\Order::onlyTrashed()->count()
                + \App\Models\Coupon::onlyTrashed()->count();
        } catch(\Exception $e) {}
    @endphp
    <li class="nav-item">
        <a href="{{ route('recycle.bin') }}" class="nav-link {{ str_starts_with($route ?? '', 'recycle') ? 'active' : '' }}">
            <i class="nav-icon fas fa-trash-restore" style="color:var(--red)"></i>
            <p>Recycle Bin
                @if($recycleBinCount > 0)
                <span class="badge badge-danger">{{ $recycleBinCount }}</span>
                @endif
            </p>
        </a>
    </li>
    @endif

</ul>
