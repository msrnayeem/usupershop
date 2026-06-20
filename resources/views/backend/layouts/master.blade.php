<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf_token" content="{{ csrf_token() }}" />
    <title>U Super Shop</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('frontend') }}/images/favicon.ico">
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
    </style>
    <script src="{{ asset('js/notify.min.js') }}"></script>
    <script src="{{ asset('js/sweetalert2.all.min.js') }}"></script>
    <!---- Sweet alert ---->
    <script src="{{ asset('backend') }}/sweetalert/sweetalert.js"></script>
    <link href="{{ asset('backend') }}/sweetalert/sweetalert.css" rel="stylesheet" type="text/css" />
    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('backend') }}/plugins/select2/css/select2.min.css">
    <link rel="stylesheet" href="{{ asset('backend') }}/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">

    <!-- Following code for Calendar -->
    <link rel="stylesheet" type="text/css" media="all"
        href="{{ asset('backend') }}/calendar/calendar-win2k-cold-1.css" title="win2k-cold-1">
    <script type="text/javascript" src="{{ asset('backend') }}/calendar/calendar.js"></script>
    <script type="text/javascript" src="{{ asset('backend') }}/calendar/calendar-en.js"></script>
    <script type="text/javascript" src="{{ asset('backend') }}/calendar/calendar-setup.js"></script>

    <!--Following code for Choosen-->
    <link rel="stylesheet" href="{{ asset('backend') }}/css/chosen.min.css" />
    <script src="{{ asset('backend') }}/js/chosen.jquery.min.js"></script>
    <script src="{{ asset('backend') }}/js/ace.min.js"></script>

    <style>
        .content-header {
            padding: 8px .5rem;
        }

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

        .card-body {
            padding: .5rem;
        }

        .page-link {
            padding: .25rem .75rem;
        }

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
        }
    </style>
    @yield('admin_css')
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <!-- Preloader -->
        <div class="preloader flex-column justify-content-center align-items-center">
            <!--<img class="animation__shake" src="{{ asset('backend') }}/dist/img/AdminLTELogo.png" alt="AdminLTELogo"
                height="60" width="60" /> -->
            <img style="width: 80px;height:80px"
                src="{{ !empty(Auth::user()->image) ? url('public/upload/user_images/' . Auth::user()->image) : url('public/upload/profile.jpg') }}"
                class="img-circle elevation-2" alt="User Image" />
        </div>

        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i
                            class="fas fa-bars"></i></a>
                </li>

            </ul>

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
            <a href="{{ route('home') }}" class="brand-link">
                <img src="{{ asset('backend') }}/dist/img/AdminLTELogo.png" alt="AdminLTE Logo"
                    class="brand-image img-circle elevation-3" style="opacity: 0.8" />
                <span class="brand-text " style="font-weight: 600;">U Super Shop</span>
            </a>
            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user panel (optional) -->
                <div style="background: #dc3545" class="user-panel mt-3 d-flex">
                    <div class="image">
                        <img src="{{ !empty(Auth::user()->image) ? url('public/upload/user_images/' . Auth::user()->image) : url('public/upload/profile.jpg') }}"
                            class="img-circle elevation-2" alt="User Image" />
                    </div>
                    <div class="info">
                        <a href="{{ route('profiles.view') }}" class="d-block">{{ Auth::user()->name }}</a>
                    </div>
                </div>
                @include('backend.layouts.sidebar')
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
        <footer class="main-footer">
            <strong>Copyright &copy; U Super Shop
                <a href="http://gammasoftbd.com"></a>.</strong>
            <div class="float-right d-none d-sm-inline-block">
                <b>Design & Developed By</b> U Super Shop
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
    
    @if(request()->routeIs('home'))
    <!-- ChartJS (Only for dashboard) -->
    <script src="{{ asset('backend') }}/plugins/chart.js/Chart.min.js"></script>
    <!-- Sparkline (Only for dashboard) -->
    <script src="{{ asset('backend') }}/plugins/sparklines/sparkline.js"></script>
    <!-- JQVMap (Only for dashboard) -->
    <script src="{{ asset('backend') }}/plugins/jqvmap/jquery.vmap.min.js"></script>
    <script src="{{ asset('backend') }}/plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
    <!-- jQuery Knob Chart (Only for dashboard) -->
    <script src="{{ asset('backend') }}/plugins/jquery-knob/jquery.knob.min.js"></script>
    @endif
    
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
    <!-- AdminLTE dashboard demo (Only load on dashboard page) -->
    @if(request()->routeIs('home'))
    <script src="{{ asset('backend') }}/dist/js/pages/dashboard.js"></script>
    @endif
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
    <!-- <script>
        $(function() {
            $("#example1").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
        });
        -- >
    </script>

    <!-- <script type="text/javascript">
        $(function() {
            $(document).on('click', '#delete', function(e) {
                e.preventDefault();
                var link = $(this).attr("href");
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be delete this data!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = link;
                        Swal.fire(
                            'Deleted!',
                            'Your file has been deleted.',
                            'success'
                        )
                    }
                })
            });
        });
    </script> -->

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



    <script>
        $(function() {
            $('.select2').select2();
        });
    </script>
    <script>
        $(function() {
            $('#summernote').summernote();
        });
         $(function() {
            $('.summernote').summernote();
        });
    </script>
    @yield('custom_js')
    @stack('scripts')
</body>

</html>
