@extends('backend.dropshipper.dropshipper-master')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-6">
                        <h5 class="m-0"><i class='fas fa-hand-point-right'></i> Manage Products</h5>
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active">Products</li>
                            &nbsp;&nbsp;&nbsp;
                            <a class="btn btn-sm btn-primary float-right" href="{{ route('vendor.addproduct') }}"><i
                                    class="fas fa-plus-circle"></i> Add Product</a>
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
                                    Product List
                                    <a class="btn btn-sm btn-primary float-right" href="{{ route('products.add') }}"><i
                                            class="fas fa-plus-circle"></i> Add Product</a>
                                </h3>
                            </div> -->
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="productTbl" class="table table-bordered table-striped nowrap dt-responsive"
                                    style="width: 100%">
                                    <thead>
                                        <tr>
                                            <th width="6%">SL.</th>
                                            <th>Image</th>
                                            <th>Category</th>
                                            <th>Brand</th>
                                            <th>Product Name</th>
                                            <th>Product Code</th>
                                            <th>TP</th>
                                            <th>MRP</th>
                                            <th>Dis.</th>
                                            <th>D.Price</th>
                                            <th width="10%">Action</th>
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
                    url: "{{ route('vendor.productlist') }}",
                    data: function(data) {
                        let customFilter = {};

                        customFilter.category_id = null;
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
                        data: "image",
                        name: "image",
                        searchable: false,
                        orderable: false
                    },
                    {
                        data: "category_id",
                        name: "category_id"
                    },
                    {
                        data: "brand_name",
                        name: "brand_id"
                    },
                    {
                        data: "name",
                        name: "name"
                    },
                    {
                        data: "sku",
                        name: "sku"
                    },
                   
                    {
                        data: "tp",
                        name: "trade_price"
                    },
                    {
                        data: "price",
                        name: "price"
                    },
                    {
                        data: "discount",
                        name: "discount"
                    },
                    {
                        data: "disValue",
                        name: "disValue",
                        searchable: false,
                        orderable: false
                    },
                    {
                        data: "action",
                        name: "action",
                        searchable: false,
                        orderable: false
                    },
                ],
                lengthMenu: [
                    [15, 50, 100, -1],
                    [15, 50, 100, "All"]
                ],
            });
        });
    </script>
@endsection
