@extends('backend.layouts.master')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <h5 class="m-0"><i class='fas fa-hand-point-right'></i> Manage Customers</h5>
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active">Customers</li>
                        </ol>
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <!-- Main row -->
                <div class="row">
                    <!-- Left col -->
                    <section class="col-md-12">
                        <!-- Custom tabs (Charts with tabs)-->
                        <div class="card">
                            <!-- <div class="card-header">
                                <h3>
                                    Customers List
                                    <a class="btn btn-sm btn-primary float-right" href="{{ route('users.add') }}"><i
                                            class="fas fa-plus-circle"></i> Add Customer</a>
                                </h3>
                            </div> -->
                            <!-- /.card-header -->
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="customerTbl" class="table table-bordered table-striped nowrap dt-responsive"
                                    style="width: 100%">
                                    <thead>
                                        <tr>
                                            <th class="text-center" width="6%">SN</th>
                                            <th class="text-left">Name</th>
                                            <th class="text-left">Email</th>
                                            <th class="text-center">Mobile No</th>
                                            <th class="text-center">Address</th>
                                            <th class="text-center" width="10%">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                                </div>
                               
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                        <!-- /.card -->
                    </section>
                    <!-- /.Left col -->
                </div>
                <!-- /.row (main row) -->
            </div>
            <!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <script>
        $(function() {
            $("#customerTbl").DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('customers.list') }}",
                    data: function(data) {
                        let customFilter = {};
                        customFilter.usertype = null;
                        data.customFilter = customFilter;
                    },
                    type: "GET",
                },
                columns: [{
                        data: "sn",
                        searchable: false,
                        className: "text-center",
                        orderable: false
                    },
                    {
                        data: "name",
                        className: "text-left",
                        name: "name"
                    },
                    {
                        data: "email",
                        className: "text-left",
                        name: "email"
                    },
                    {
                        data: "mobile",
                        className: "text-center",
                        name: "mobile"
                    },
                    {
                        data: "address",
                        className: "text-center",
                        name: "address"
                    },
                    {
                        data: "action",
                        className: "text-center",
                        name: "action",
                        searchable: false,
                        orderable: false
                    },
                ]
            });
        });
    </script>
@endsection
