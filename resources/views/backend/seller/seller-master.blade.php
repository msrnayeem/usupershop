<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>U Super Shop — Seller Panel</title>
    <link rel="icon" type="image/png" href="{{ asset('frontend') }}/images/icons/favicon.png" />
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('backend') }}/plugins/fontawesome-free/css/all.min.css" />
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" />
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet" href="{{ asset('backend') }}/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css" />
    <!-- iCheck -->
    <link rel="stylesheet" href="{{ asset('backend') }}/plugins/icheck-bootstrap/icheck-bootstrap.min.css" />
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('backend') }}/dist/css/adminlte.min.css" />
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{ asset('backend') }}/plugins/overlayScrollbars/css/OverlayScrollbars.min.css" />
    <!-- Daterange picker -->
    <link rel="stylesheet" href="{{ asset('backend') }}/plugins/daterangepicker/daterangepicker.css" />
    <!-- summernote -->
    <link rel="stylesheet" href="{{ asset('backend') }}/plugins/summernote/summernote-bs4.min.css" />
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('backend') }}/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="{{ asset('backend') }}/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="{{ asset('backend') }}/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">

    <!-- jQuery -->
    <script src="{{ asset('backend') }}/plugins/jquery/jquery.min.js"></script>
    <script src="{{ asset('js/notify.min.js') }}"></script>
    <script src="{{ asset('js/sweetalert2.all.min.js') }}"></script>
    <script src="{{ asset('backend') }}/sweetalert/sweetalert.js"></script>
    <link href="{{ asset('backend') }}/sweetalert/sweetalert.css" rel="stylesheet" type="text/css" />
    
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('backend') }}/plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="{{ asset('backend') }}/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">

    <style type="text/css">
        body {
            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            background-color: #f8fafc;
            color: #0f172a;
        }

        .notifyjs-corner {
            z-index: 10000 !important;
        }

        /* Top Navbar Customization */
        .main-header.navbar {
            background-color: #ffffff;
            border-bottom: 1px solid #e2e8f0;
            padding: 0.6rem 1.5rem;
        }
        .main-header.navbar .nav-link {
            color: #475569;
            font-weight: 500;
            font-size: 14px;
        }
        .main-header.navbar .nav-link:hover {
            color: #6366f1;
        }

        /* Clean Sidebar Design */
        .main-sidebar {
            background-color: #ffffff !important;
            border-right: 1px solid #e2e8f0;
            box-shadow: none !important;
        }
        .main-sidebar .brand-link {
            border-bottom: 1px solid #e2e8f0 !important;
            background: #ffffff !important;
            color: #0f172a !important;
            padding: 15px;
            text-align: center;
        }
        .main-sidebar .brand-link .brand-text {
            color: #0f172a !important;
            font-weight: 800 !important;
            font-size: 19px !important;
            letter-spacing: -0.5px;
        }
        
        .user-panel {
            background: #f8fafc !important;
            border-bottom: 1px solid #e2e8f0 !important;
            padding: 16px !important;
            margin: 0 !important;
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .user-panel .image img {
            width: 44px;
            height: 44px;
            border: 2px solid #6366f1;
            box-shadow: 0 4px 6px -1px rgba(99, 102, 241, 0.15);
        }
        .user-panel .info {
            padding: 0 !important;
        }
        .user-panel .info a {
            color: #0f172a !important;
            font-weight: 700;
            font-size: 14px;
            margin-bottom: 2px;
            display: block;
        }
        .user-panel .info .badge-usertype {
            background: #6366f1;
            color: #fff;
            font-size: 10px;
            font-weight: 700;
            padding: 2px 8px;
            border-radius: 20px;
            display: inline-block;
            text-transform: uppercase;
        }

        /* Sidebar Nav Links */
        .sidebar {
            padding: 0 !important;
        }
        .sidebar .nav-sidebar .nav-item > .nav-link {
            color: #475569 !important;
            font-weight: 500;
            padding: 10px 18px;
            border-radius: 8px;
            margin: 3px 10px;
            font-size: 13.5px;
            transition: all 0.2s ease;
        }
        .sidebar .nav-sidebar .nav-item > .nav-link i.nav-icon {
            color: #64748b !important;
            margin-right: 10px;
            font-size: 15px;
            transition: color 0.2s ease;
        }
        .sidebar .nav-sidebar .nav-item:hover > .nav-link,
        .sidebar .nav-sidebar .nav-item > .nav-link.active,
        .sidebar .nav-sidebar .menu-open > .nav-link {
            background-color: #f1f5f9 !important;
            color: #6366f1 !important;
        }
        .sidebar .nav-sidebar .nav-item:hover > .nav-link i.nav-icon,
        .sidebar .nav-sidebar .nav-item > .nav-link.active i.nav-icon,
        .sidebar .nav-sidebar .menu-open > .nav-link i.nav-icon {
            color: #6366f1 !important;
        }

        .sidebar .nav-treeview .nav-item > .nav-link {
            padding: 8px 18px 8px 45px !important;
            margin: 2px 10px !important;
            font-size: 13px;
        }
        .sidebar .nav-treeview .nav-item > .nav-link.active {
            background-color: #e0e7ff !important;
            color: #6366f1 !important;
            font-weight: 600;
        }

        /* Content Area Cards & Form Styling */
        .content-wrapper {
            background-color: #f8fafc;
            padding: 24px 30px;
        }
        .card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.05), 0 1px 2px -1px rgba(0, 0, 0, 0.05);
            border-radius: 12px;
            margin-bottom: 24px;
            overflow: hidden;
        }
        .card-header {
            background-color: #ffffff;
            border-bottom: 1px solid #e2e8f0;
            padding: 16px 20px;
        }
        .card-header .card-title {
            font-size: 15px;
            font-weight: 700;
            color: #0f172a;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .card-body {
            padding: 20px;
        }

        /* Form elements */
        .form-control, .select2-container--default .select2-selection--single {
            border: 1px solid #cbd5e1 !important;
            border-radius: 8px !important;
            padding: 10px 14px !important;
            height: auto !important;
            font-size: 13.5px !important;
            color: #0f172a !important;
            background-color: #ffffff !important;
            transition: all 0.2s ease !important;
        }
        .form-control:focus, .select2-container--default.select2-container--focus .select2-selection--single {
            border-color: #6366f1 !important;
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.15) !important;
            outline: none !important;
        }
        label {
            font-weight: 600;
            color: #334155;
            font-size: 13px;
            margin-bottom: 6px;
        }

        /* Mobile Bottom Nav styling */
        .bottom-nav {
            background: #ffffff !important;
            border-top: 1px solid #e2e8f0;
            box-shadow: 0 -4px 12px rgba(0, 0, 0, 0.03);
            height: 64px;
            z-index: 1030;
        }
        .bottom-nav .nav-link {
            color: #64748b;
            font-size: 10px;
            font-weight: 500;
            padding: 6px 0;
            transition: all 0.2s ease;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }
        .bottom-nav .nav-link i {
            font-size: 18px;
            margin-bottom: 4px;
            color: #64748b;
            transition: transform 0.2s ease, color 0.2s ease;
        }
        .bottom-nav .nav-link.active {
            color: #6366f1 !important;
            background: none !important;
            font-weight: 700;
        }
        .bottom-nav .nav-link.active i {
            color: #6366f1;
            transform: scale(1.1);
        }

        .main-footer {
            background: #ffffff;
            border-top: 1px solid #e2e8f0;
            color: #64748b;
            font-size: 13px;
            padding: 15px 30px;
            margin-bottom: 64px; /* offset bottom tab menu height for mobile views */
        }
        
        @media(min-width:768px) {
            .main-footer {
                margin-bottom: 0;
            }
            .fixed-bottom {
                display: none !important;
            }
        }
    </style>
    @yield('custom_css')
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <!-- Preloader -->
        <div class="preloader flex-column justify-content-center align-items-center" style="background:#ffffff;">
            <img style="width: 70px;height:70px;border: 3px solid #e2e8f0;padding:4px;"
                src="{{ !empty(Auth::user()->logo) ? url('public/upload/user_images/' . Auth::user()->logo) : url('public/upload/profile.jpg') }}"
                class="img-circle" alt="User Image" onerror="this.src='{{ url('public/upload/profile.jpg') }}'" />
        </div>

        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>

                @if (auth()->user()->payment_status == 1)
                    @if (auth()->user()->usertype === 'seller' || auth()->user()->usertype === 'vendor')
                        <li class="nav-item pl-2">
                            <a class="btn btn-sm btn-success" href="{{ url('shops/' . auth()->user()->id . '?refer=' . auth()->user()->code) }}" target="_blank" style="background:#22c55e;border:none;border-radius:6px;font-weight:600;padding:6px 14px;">
                                <i class="fas fa-store mr-1"></i> Visit My Shop
                            </a>
                        </li>
                        <li class="nav-item pl-2">
                            <button class="copy-btn btn btn-sm btn-warning text-white" onclick="copyReferLink()" style="background:#f59e0b;border:none;border-radius:6px;font-weight:600;padding:6px 14px;">
                                <i class="fas fa-share-alt mr-1"></i> Copy Referral Link
                            </button>
                        </li>
                        <textarea type="text" id="password" class="form-control d-none">{{ route('seller.signup') }}?refer={{ auth()->user()->refer_code }}</textarea>
                    @endif
                @endif
            </ul>

            <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link font-weight-bold" data-toggle="dropdown" href="#" style="display:flex;align-items:center;gap:6px;">
                        <i class="fas fa-user-circle" style="font-size:18px;color:#64748b;"></i>
                        <span>{{ Auth::user()->name }}</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right" style="border:1px solid #cbd5e1;box-shadow:0 10px 15px -3px rgba(0,0,0,0.05);border-radius:8px;">
                        <div class="dropdown-divider"></div>
                        <a href="{{ route('logout') }}"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                            class="dropdown-item dropdown-footer font-weight-bold text-danger">
                            <i class="fas fa-sign-out-alt mr-2"></i> Log out
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </div>
                </li>
            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="{{ route('seller.dashboard') }}" class="brand-link">
                <span class="brand-text">U SUPER SHOP</span>
            </a>
            
            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user panel (optional) -->
                <div class="user-panel">
                    <div class="image">
                        <img src="{{ !empty(Auth::user()->logo) ? url('public/upload/user_images/' . Auth::user()->logo) : url('public/upload/profile.jpg') }}"
                            class="img-circle" alt="User Image" onerror="this.src='{{ url('public/upload/profile.jpg') }}'" />
                    </div>
                    <div class="info">
                        <a href="{{ route('sellers.view.profile') }}">{{ Auth::user()->name }}</a>
                        <span class="badge-usertype">{{ Auth::user()->usertype ?? 'Member' }}</span>
                        <div style="font-size:12px;font-weight:700;color:#64748b;margin-top:4px;">
                            Balance: ৳{{ number_format(Auth::user()->balance ?? 0, 2) }}
                        </div>
                    </div>
                </div>
                @include('backend.seller.seller-sidebar')
            </div>
            <!-- /.sidebar -->
        </aside>

        @yield('content')

        @if (session()->has('success'))
            <script type="text/javascript">
                $(function() {
                    $.notify("{{ session()->get('success') }}", {
                        globalPosition: 'top right',
                        className: 'success'
                    });
                });
            </script>
        @endif
        @if (session()->has('error'))
            <script type="text/javascript">
                $(function() {
                    $.notify("{{ session()->get('error') }}", {
                        globalPosition: 'top right',
                        className: 'error'
                    });
                });
            </script>
        @endif

        <!-- Mobile-only Bottom Tab Menu - Horizontal Side-by-Side with 5 Tabs -->
        <nav class="navbar fixed-bottom navbar-light bg-white border-top shadow-sm bottom-nav">
            <div class="container-fluid px-0">
                <ul class="nav nav-pills w-100 d-flex justify-content-around align-items-center m-0 p-0" style="list-style:none;">
                    <!-- Shop -->
                    <li class="text-center flex-grow-1">
                        <a class="nav-link {{ request()->routeIs('dropshipper.shopkeeper_product') || request()->routeIs('sellers.shopkeeper_product') ? 'active' : '' }}"
                            href="{{ route('sellers.shopkeeper_product') }}">
                            <i class="fas fa-home"></i>
                            <span>Shop</span>
                        </a>
                    </li>

                    <!-- Order Track -->
                    <li class="text-center flex-grow-1">
                        <a class="nav-link {{ request()->routeIs('seller.orders.pending.list') ? 'active' : '' }}"
                            href="{{ route('seller.orders.pending.list') }}">
                            <i class="fas fa-shopping-cart"></i>
                            <span>Orders</span>
                        </a>
                    </li>

                    <!-- Home (Dashboard) -->
                    <li class="text-center flex-grow-1">
                        <a class="nav-link {{ request()->routeIs('seller.dashboard') ? 'active' : '' }}"
                            href="{{ route('seller.dashboard') }}">
                            <i class="fas fa-box"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>

                    <!-- My Cart -->
                    <li class="text-center flex-grow-1">
                        <a class="nav-link {{ request()->routeIs('show.cart') ? 'active' : '' }}"
                            href="{{ route('show.cart') }}">
                            <i class="fas fa-shopping-bag"></i>
                            <span>Cart</span>
                        </a>
                    </li>

                    <!-- Me -->
                    <li class="text-center flex-grow-1">
                        <a class="nav-link {{ request()->routeIs('sellers.view.profile') ? 'active' : '' }}"
                            href="{{ route('sellers.view.profile') }}">
                            <i class="fas fa-user"></i>
                            <span>Profile</span>
                        </a>
                    </li>
                </ul>
            </div>
        </nav>

        <footer class="main-footer">
            <strong>Copyright &copy; <a href="{{ route('frontend.home') }}" target="_blank">U Super Shop</a>.</strong>
            <div class="float-right d-none d-sm-inline-block">
                <b>Designed & Developed By</b> <a href="{{ route('frontend.home') }}">U Super Shop</a>
            </div>
        </footer>

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
    </div>

    <!-- jQuery UI 1.11.4 -->
    <script src="{{ asset('backend') }}/plugins/jquery-ui/jquery-ui.min.js"></script>
    <script>
        $.widget.bridge("uibutton", $.ui.button);
    </script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('backend') }}/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- ChartJS -->
    <script src="{{ asset('backend') }}/plugins/chart.js/Chart.min.js"></script>
    <!-- Sparkline -->
    <script src="{{ asset('backend') }}/plugins/sparklines/sparkline.js"></script>
    <!-- JQVMap -->
    <script src="{{ asset('backend') }}/plugins/jqvmap/jquery.vmap.min.js"></script>
    <script src="{{ asset('backend') }}/plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
    <!-- jQuery Knob Chart -->
    <script src="{{ asset('backend') }}/plugins/jquery-knob/jquery.knob.min.js"></script>
    <!-- daterangepicker -->
    <script src="{{ asset('backend') }}/plugins/moment/moment.min.js"></script>
    <script src="{{ asset('backend') }}/plugins/daterangepicker/daterangepicker.js"></script>
    <!-- Tempusdominus Bootstrap 4 -->
    <script src="{{ asset('backend') }}/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
    <!-- Summernote -->
    <script src="{{ asset('backend') }}/plugins/summernote/summernote-bs4.min.js"></script>
    <!-- overlayScrollbars -->
    <script src="{{ asset('backend') }}/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('backend') }}/dist/js/adminlte.js"></script>
    <!-- DataTables  & Plugins -->
    <script src="{{ asset('backend') }}/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="{{ asset('backend') }}/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="{{ asset('backend') }}/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="{{ asset('backend') }}/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <script src="{{ asset('backend') }}/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
    <script src="{{ asset('backend') }}/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
    <script src="{{ asset('backend') }}/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
    <script src="{{ asset('backend') }}/plugins/datatables-buttons/js/buttons.print.min.js"></script>
    <script src="{{ asset('backend') }}/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
    <script src="{{ asset('backend') }}/plugins/jquery-validation/jquery.validate.min.js"></script>
    <script src="{{ asset('backend') }}/plugins/jquery-validation/additional-methods.min.js"></script>
    <script src="{{ asset('backend') }}/plugins/select2/js/select2.full.min.js"></script>

    <script>
        function copyReferLink() {
            let passwordText = document.getElementById("password").value;
            navigator.clipboard.writeText(passwordText).then(() => {
                alert("Refer Link Copied!");
            }).catch(err => {
                console.error("Failed to copy text: ", err);
            });
        }
    </script>
    @yield('custom_js')
</body>
</html>
