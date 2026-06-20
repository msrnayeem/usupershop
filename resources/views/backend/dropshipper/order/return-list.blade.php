@extends('backend.dropshipper.dropshipper-master')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <h5 class="m-0"><i class='fas fa-hand-point-right'></i> Manage Return Orders</h5>
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('dropshipper.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Return Orders</li>
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
                            <!-- /.card-header -->
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="returnOrderTbl" class="table table-bordered table-striped dt-responsive"
                                    style="width: 100%">
                                    <thead>
                                        <tr>
                                            <th width="6%">SN</th>
                                            <th>Order No</th>
                                            <th>Total Amm.</th>
                                            <th>Payment Type</th>
                                            <th>Comm.</th>
                                            <th>Order Date</th>
                                            <th>Status</th>
                                            <th width="10%">Action</th>
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
            $("#returnOrderTbl").DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('dropshipper.orders.return.list') }}",
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
                        orderable: false
                    },
                    {
                        data: "order_no",
                        name: "order_no"
                    },
                    {
                        data: "order_total",
                        name: "order_total"
                    },
                    {
                        data: "payment_id",
                        name: "payment_id",
                        searchable: false,
                        orderable: false
                    },
                    {
                        data: "commission",
                        name: "commission",
                        searchable: false,
                        orderable: false
                    },
                    {
                        data: "order_date",
                        name: "order_date",
                        searchable: false,
                        orderable: false
                    },
                    {
                        data: "status",
                        name: "status",
                        searchable: false,
                        orderable: false
                    },
                    {
                        data: "action",
                        name: "action",
                        searchable: false,
                        orderable: false
                    },
                ]
            });
        });
    </script>
@endsection
