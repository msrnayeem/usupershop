@extends('backend.layouts.master')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <h5 class="m-0"><i class='fas fa-hand-point-right'></i> Order Commission</h5>
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active">Order Commission</li>
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
                                <div class="msg"></div>
                              
                                <table id="orderCommissionTbl" class="table table-bordered table-striped nowrap dt-responsive"
                                    style="width: 100%">
                                    <thead>
                                        <tr style="background:#b6f7f4">  
                                            <th width="4%">SN</th>
                                            <th>Order ID</th>
                                            <th>Reseller</th>
                                            <th>Debit</th>
                                            <th>Credit</th>
                                            <th>Payment Mood</th>
                                            <th>Reference</th>
                                            <th>Comm. Date</th>
                                         
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>

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
    <script type="text/javascript">
        $(document).ready(function() {
           

            let orderCommissionTbl = $("#orderCommissionTbl").DataTable({
                processing: true,
                serverSide: true,
                searchable: true,
                ajax: {
                    url: "{{ route('order.commission.list') }}",
                    data: function(data) {
                        let customFilter = {};
                     
                    },
                    type: "GET",
                },
                columns: [
                    {
                        data: "sn",
                        searchable: false,
                        orderable: false
                    },
                    {
                        data: "order_id",
                        name: "order_id"
                    },
                    {
                        data: "reseller_id",
                        name: "reseller_id"
                    },
                    {
                        data: "debit_balance",
                        name: "debit_balance",
                        searchable: false,
                        orderable: false
                    },
                    {
                        data: "credit_balance",
                        name: "credit_balance",
                        searchable: false,
                        orderable: false
                    },
                    {
                        data: "payment_mood",
                        name: "payment_mood",
                        searchable: false,
                        orderable: false
                    },
                    {
                        data: "reference",
                        name: "reference",
                        searchable: false,
                        orderable: false
                    },
                    {
                        data: "comm_date",
                        name: "comm_date",
                        searchable: false,
                        orderable: false
                    }
                   
                ],
                /* dom: 'lBfrtip', */
                lengthMenu: [
                    [15, 50, 100, -1],
                    [15, 50, 100, "All"]
                ],
            });
            //setInterval($(""),1000);
            
            // Choosen code here....
            jQuery(function($) {
                $('.chosen-select').chosen({allow_single_deselect: true});
            });

        });
    </script>
@endsection
