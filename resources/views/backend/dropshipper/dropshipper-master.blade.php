<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>U Super Shop</title>
    <link rel="icon" type="image/png" href="{{ asset('frontend') }}/images/icons/favicon.png" />
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback" />
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('backend') }}/plugins/fontawesome-free/css/all.min.css" />
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" />
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet"
        href="{{ asset('backend') }}/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css" />
    <!-- iCheck -->
    <link rel="stylesheet" href="{{ asset('backend') }}/plugins/icheck-bootstrap/icheck-bootstrap.min.css" />
    <!-- JQVMap -->
    <link rel="stylesheet" href="{{ asset('backend') }}/plugins/jqvmap/jqvmap.min.css" />
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
    <link rel="stylesheet"
        href="{{ asset('backend') }}/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="{{ asset('backend') }}/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">


    <!-- Theme style -->
    <!-- jQuery -->
    <script src="{{ asset('backend') }}/plugins/jquery/jquery.min.js"></script>
    <style type="text/css">
        .notifyjs-corner {
            z-index: 10000 !important;
        }

        /* Add this to your CSS */
        .bottom-nav .nav-link {
            color: #6c757d;
            transition: all 0.2s ease;
        }

        .bottom-nav .nav-link.active {
            color: #0d6efd;
            font-weight: 600;
        }

        .bottom-nav .nav-link.active i {
            transform: scale(1.15);
        }
    </style>
    <script src="{{ asset('js/notify.min.js') }}"></script>
    <script src="{{ asset('js/sweetalert2.all.min.js') }}"></script>
    {{-- Sweet alert --}}
    <script src="{{ asset('backend') }}/sweetalert/sweetalert.js"></script>
    <link href="{{ asset('backend') }}/sweetalert/sweetalert.css" rel="stylesheet" type="text/css" />
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('backend') }}/plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="{{ asset('backend') }}/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
    <style>
        .table td,
        .table th {
            padding: .15rem !important;
        }

        .btn-group-sm>.btn,
        .btn-sm {
            line-height: 1.2;
        }

        .nav-link {
            padding: .2rem 1rem;
        }

        .profilevarify {
            height: 300px;
        }

        /* Responsive Table for Small Screens */
        @media (max-width: 768px) {
            table tr {
                display: block;
                overflow-x: auto;
                width: 100%;
            }

            table tr,
            td {
                width: 100%;
                overflow: hidden;
            }

            .profilevarify {
                height: 280px;
            }
        }

        @media (max-width: 568px) {
            table tr {
                display: block;
                overflow-x: auto;
                width: 100%;
            }

            table tr,
            td {
                width: 100%;
                overflow: hidden;
            }

            .profilevarify {
                height: 380px;
            }
        }

        @media (max-width: 368px) {
            table {
                display: block;
                overflow-x: auto;
                width: 100%;
            }

            table tr,
            td {
                width: 100%;
                overflow: hidden;
            }

            .profilevarify {
                height: 480px;
            }
        }

        .copy-cell {
            position: relative;
            cursor: pointer;
        }

        .copy-icon {
            display: none;
            position: absolute;
            right: 8px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 13px;
            color: #666;
        }

        .copy-cell:hover .copy-icon {
            display: inline;
        }

        .copy-cell:hover {
            background-color: #f5f5f5;
        }

        .download-cell {
            position: relative;
        }

        .download-cell img {
            display: block;
            width: 100px;
        }

        .download-icon {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 24px;
            background: rgba(0, 0, 0, 0.6);
            color: white;
            padding: 5px 8px;
            border-radius: 50%;
            display: none;
            cursor: pointer;
        }

        .download-cell:hover .download-icon {
            display: block;
        }
    </style>
        @yield('custom_css')
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <!-- Preloader -->
        <div class="preloader flex-column justify-content-center align-items-center">
            <!-- <img class="animation__shake" src="{{ asset('backend') }}/dist/img/AdminLTELogo.png" alt="AdminLTELogo"
                height="60" width="60" /> -->
            <img style="width: 80px;height:80px"
                src="{{ !empty(Auth::user()->image) ? url('public/upload/user_images/' . Auth::user()->image) : url('public/upload/profile.jpg') }}"
                class="img-circle elevation-2" alt="User Image" />
        </div>

        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i
                            class="fas fa-bars"></i></a>
                </li>

                @if (auth()->user()->payment_status == 1)
                    <li class="nav-item">
                        <a class="btn btn-success btn-sm mt-1"
                            href="<?php echo url('shops/' . auth()->user()->id . '?refer=' . auth()->user()->code); ?>" target="_blank">Go
                            Shop</a>
                    </li>
                    <li class="nav-item pl-2">
                        <button class="copy-btn btn btn-warning text-white btn-sm mt-1"
                            onclick="copyReferLink()">Referal Link</button>
                    </li>

                    <textarea type="text" id="password" class="form-control d-none" rows="2" cols="4">{{ route('seller.signup') }}?refer={{ auth()->user()->refer_code }}</textarea>
                @endif

            </ul>
            <!-- Left navbar links -->
            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <!-- Messages Dropdown Menu -->
                <li class="nav-item dropdown">
                    <a class="nav-link" data-toggle="dropdown" href="#">
                        <span><i class="fas fa-user"></i> {{ Auth::user()->name }}</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                        <div class="dropdown-divider"></div>
                        <a href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                                                        document.getElementById('logout-form').submit();"
                            class="dropdown-item dropdown-footer">Logout</a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </div>
                </li>
                <!-- Notifications Dropdown Menu -->
            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="{{ route('frontend.home') }}" class="brand-link">
                <img src="{{ asset('backend//dist/img/AdminLTELogo.png') }}" alt="{{ Auth::user()->shop_name ?? '' }}"
                    class="brand-image img-circle elevation-3" style="background:#ddd" />
                <span class="brand-text" style="font-weight:700;font-size:22px;">U Super Shop</span>
            </a>
            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user panel (optional) -->
                <div style="background: #dc3545" class="user-panel d-flex">
                    <div class="image mt-2">
                        <img src="{{ !empty(Auth::user()->logo) ? url('public/upload/user_images/' . Auth::user()->logo) : url('public/upload/profile.jpg') }}"
                            class="img-circle elevation-2" alt="User Image" />


                    </div>
                    <div class="info">
                        <a href="{{ route('dropshipper.view.profile') }}" class="d-block">{{ Auth::user()->name }}
                        </a>
                        <span class="d-block text-white"> {{ Auth::user()->shop_name ?? 'shop name' }}
                        </span>
                        <span class="d-block text-white"> Balance: {{ Auth::user()->balance }}
                        </span>

                        <span class="d-block text-white text-uppercase"> {{ Auth::user()->usertype ?? 'usertype' }}
                        </span>
                    </div>
                </div>
                @include('backend.dropshipper.dropshipper-sidebar')
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
        <nav class="navbar fixed-bottom navbar-light bg-white border-top shadow-sm"
            style="height: 64px; z-index: 1030;"> <!-- slightly taller for better touch target -->
            <div class="container-fluid px-0">
                <ul class="nav nav-pills w-100 d-flex justify-content-around align-items-center" role="tablist">
                    <!-- Shop -->
                    <li class="nav-item text-center flex-grow-1">
                        <a class="nav-link py-2 px-1 d-flex flex-column align-items-center {{ request()->routeIs('dropshipper.shopkeeper_product') ? 'active' : '' }}"
                            href="{{ route('dropshipper.shopkeeper_product') }}">
                            <i class="fas fa-home mb-1"></i>
                            <small class="font-weight-medium">Shop</small>
                        </a>
                    </li>

                    <!-- Order Track -->
                    <li class="nav-item text-center flex-grow-1">
                        <a class="nav-link py-2 px-1 d-flex flex-column align-items-center {{ request()->routeIs('dropshipper.orders.pending.list') ? 'active' : '' }}"
                            href="{{ route('dropshipper.orders.pending.list') }}">
                            <i class="fas fa-shopping-cart  mb-1"></i>
                            <small class="font-weight-medium">Orders</small>
                        </a>
                    </li>

                    <!-- Home (Dashboard) - often center position is prominent -->
                    <li class="nav-item text-center flex-grow-1">
                        <a class="nav-link py-2 px-1 d-flex flex-column align-items-center {{ request()->routeIs('dropshipper.dashboard') ? 'active' : '' }}"
                            href="{{ route('frontend.home') }}">
                            <i class="fas fa-box mb-1"></i> <!-- bigger icon in center -->
                            <small class="font-weight-medium">Home</small>
                        </a>
                    </li>

                    <!-- My Cart -->
                    <li class="nav-item text-center flex-grow-1">
                        <a class="nav-link py-2 px-1 d-flex flex-column align-items-center {{ request()->routeIs('show.cart') ? 'active' : '' }}"
                            href="{{ route('show.cart') }}">
                            <i class="fas fa-shopping-bag  mb-1"></i>
                            <small class="font-weight-medium">Cart</small>
                        </a>
                    </li>

                    <!-- Me -->
                    <li class="nav-item text-center flex-grow-1">
                        <a class="nav-link py-2 px-1 d-flex flex-column align-items-center {{ request()->routeIs('dropshipper.view.profile') ? 'active' : '' }}"
                            href="{{ route('dropshipper.dashboard') }}">
                            <i class="fas fa-user  mb-1"></i>
                            <small class="font-weight-medium">Me</small>
                        </a>
                    </li>
                </ul>
            </div>
        </nav>
        <footer class="main-footer">
            <strong>Copyright &copy;
                <a href="{{ route('frontend.home') }}">U Super Shop</a>.</strong>
            <div class="float-right d-none d-sm-inline-block">
                <b>Design & Developed By</b>
                <a href="{{ route('frontend.home') }}">
                    U Super Shop
                </a>
            </div>
        </footer>

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

    <!-- jQuery UI 1.11.4 -->
    <script src="{{ asset('backend') }}/plugins/jquery-ui/jquery-ui.min.js"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
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
    <!-- AdminLTE for demo purposes -->
    <script src="{{ asset('backend') }}/dist/js/demo.js"></script>
    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
    <script src="{{ asset('backend') }}/dist/js/pages/dashboard.js"></script>
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




    <!-- Select2 -->
    <script src="{{ asset('backend') }}/plugins/select2/js/select2.full.min.js"></script>
    <script>
        function copyReferLink() {
            let passwordText = document.getElementById("password").value; // Use .value instead of .innerText
            navigator.clipboard.writeText(passwordText).then(() => {
                alert("Refer Link Copied!");
            }).catch(err => {
                console.error("Failed to copy text: ", err);
            });
        }

        $(function() {
            $("#example1").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
        });
    </script>


    <script>
        $(document).ready(function() {
            $(document).on('click', '#delete', function() {
                var actionTo = $(this).attr('href');
                var token = $(this).attr('data-token');
                var id = $(this).attr('data-id');
                swal({
                        title: "Are you sure?",
                        type: "success",
                        showCancelButton: true,
                        confirmButtonClass: 'btn-danger',
                        confirmButtonText: 'Yes',
                        cancelButtonText: 'No',
                        closeOnConfirm: false,
                        closeOnCancel: false
                    },
                    function(isConfirm) {
                        if (isConfirm) {
                            $.ajax({
                                url: actionTo,
                                type: 'post',
                                data: {
                                    id: id,
                                    _token: token
                                },
                                success: function(data) {
                                    swal({
                                            title: "Deleted!",
                                            type: "success"
                                        },
                                        function(isConfirm) {
                                            if (isConfirm) {
                                                $('.' + id).fadeOut();
                                            }
                                        });
                                }
                            });
                        } else {
                            swal("Cancelled", "", "error");
                        }
                    });
                return false;
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $(document).on('click', '#approve', function() {
                var actionTo = $(this).attr('href');
                var token = $(this).attr('data-token');
                var id = $(this).attr('data-id');
                swal({
                        title: "Are you sure?",
                        type: "success",
                        showCancelButton: true,
                        confirmButtonClass: 'btn-primary',
                        confirmButtonText: 'Yes',
                        cancelButtonText: 'No',
                        closeOnConfirm: false,
                        closeOnCancel: false
                    },
                    function(isConfirm) {
                        if (isConfirm) {
                            $.ajax({
                                url: actionTo,
                                type: 'post',
                                data: {
                                    id: id,
                                    _token: token
                                },
                                success: function(data) {
                                    swal({
                                            title: "Approved!",
                                            type: "success"
                                        },
                                        function(isConfirm) {
                                            if (isConfirm) {
                                                $('.' + id).fadeOut();
                                            }
                                        });
                                }
                            });
                        } else {
                            swal("Cancelled", "", "error");
                        }
                    });
                return false;
            });
        });
    </script>

    <script type="text/javascript">
        $(document).ready(function() {
            $('#image').change(function(e) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#showImage').attr('src', e.target.result);
                }
                reader.readAsDataURL(e.target.files['0']);
            });
        });
    </script>

    <script>
        $(function() {
            $('.select2').select2();
        });
    </script>

    <script type="text/javascript">
        function addToMyShop(product_id) {
            // Properly generate the URL with placeholder
            let url = "{{ route('dropshipper.add_to_my_shop', ':id') }}";
            url = url.replace(':id', product_id);

            $.ajax({
                type: "GET",
                dataType: 'json',
                url: url,
                success: function(data) {
                    // Toast notification
                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000
                    });

                    if (data.success) {
                        Toast.fire({
                            icon: 'success',
                            title: data.success
                        });
                    } else if (data.error) {
                        Toast.fire({
                            icon: 'error',
                            title: data.error
                        });
                    }
                },
                error: function(xhr) {
                    console.error(xhr.responseText);
                    Swal.fire({
                        icon: 'error',
                        title: 'Something went wrong!'
                    });
                }
            });
        };
    </script>

    <script>
        $(function() {
            $('.summernote').summernote();
        });
    </script>
    @yield('custom_js')
</body>

</html>
