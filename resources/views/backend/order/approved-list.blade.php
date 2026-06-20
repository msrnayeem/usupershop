@extends('backend.layouts.master')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <h5 class="m-0"><i class='fas fa-hand-point-right'></i> Manage Delivered Orders</h5>
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active">Delivered Orders</li>
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
                            
                            <div class="card-body">
                                <table id="dOrderTbl" class="table table-bordered table-striped nowrap dt-responsive"
                                    style="width: 100%">
                                    <thead>
                                        <tr>
                                            <th class="text-center" width="6%">SN</th>
                                            <th class="text-center">Order No</th>
                                            <th class="text-center">Total Amount</th>
                                            <th class="text-center">Payment Type</th>
                                            <th class="text-center">Order Date</th>
                                            <th class="text-center">Status</th>
                                            <th class="text-center" width="16%">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        
                                    </tbody>
                                </table>
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
            $("#dOrderTbl").DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('orders.dlist') }}",
                    data: function(data) {
                        let customFilter = {};
                        customFilter.order_no = null;
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
                        data: "order_no",
                        className: "text-center",
                        name: "order_no"
                    },
                    {
                        data: "order_total",
                        className: "text-center",
                        name: "order_total"
                    },
                    {
                        data: "payment_id",
                        name: "payment_id",
                        className: "text-center",
                        searchable: false,
                        orderable: false
                    },
                  
                    {
                        data: "order_date",
                        name: "order_date",
                        className: "text-center",
                        searchable: false,
                        orderable: false
                    },
                    {
                        data: "status",
                        name: "status",
                        className: "text-center",
                        searchable: false,
                        orderable: false
                    },
                    {
                        data: "action",
                        name: "action",
                        className: "text-center",
                        searchable: false,
                        orderable: false
                    },
                ]
            });
        });
    </script>
@endsection
