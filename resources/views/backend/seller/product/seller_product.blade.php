@extends('backend.seller.seller-master')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header" style="padding-bottom:0px;">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Seller Product</h1>
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active">Seller Product</li>
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
                                <table id="productTbl" class="table table-bordered table-striped nowrap dt-responsive"
                                    style="width: 100%">
                                    <thead>
                                        <tr>
                                            <th width="6%">SL.</th>
                                            <th>Product Name</th>
                                            <th>Image</th>
                                            <th width="12%">Action</th>
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
            $("#productTbl").DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('sellers.product.list') }}",
                    data: function(data) {
                        let customFilter = {};
                        customFilter.created_at = null;
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
                        data: "name",
                        name: "name"
                    },
                    {
                        data: "image",
                        name: "image",
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