@extends('backend.layouts.master')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        {{-- Page Header --}}
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:22px;flex-wrap:wrap;gap:12px;">
            <div>
                <h1 style="font-size:22px;font-weight:800;color:#0f172a;margin:0;">
                    <i class="fas fa-boxes" style="color:#6366f1;margin-right:8px;"></i>
                    Products
                </h1>
                <p style="color:#64748b;font-size:13px;margin:2px 0 0;">
                    <a href="{{ route('home') }}" style="color:#6366f1;text-decoration:none;">Home</a>
                    <span style="margin:0 6px;color:#cbd5e1;">/</span>
                    Products
                </p>
            </div>
            <a class="btn btn-sm btn-primary" href="{{ route('products.add') }}" style="display:inline-flex;align-items:center;gap:6px;padding:9px 18px;background:#6366f1;border:none;border-radius:8px;font-size:13px;font-weight:600;color:#fff;text-decoration:none;">
                <i class="fas fa-plus-circle"></i> Add Product
            </a>
        </div>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <section class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <span class="card-title">
                                    <i class="fas fa-list" style="color:#6366f1;margin-right:6px;"></i>
                                    Manage Products
                                </span>
                            </div>
                            <div class="card-body">
                                <table id="productTbl" class="table table-bordered table-striped nowrap dt-responsive" style="width: 100%">
                                    <thead>
                                        <tr>
                                            <th class="text-center" width="30px">SL.</th>
                                            <th class="text-center">Image</th>
                                            <th class="text-center">Category</th>
                                            <th class="text-center">Brand</th>
                                            <th class="text-center">Product Name</th>
                                            <th class="text-center">Product Code</th>
                                            <th class="text-center">Origin</th>
                                            <th class="text-center">TP</th>
                                            <th class="text-center">MRP</th>
                                            <th class="text-center">Dis.</th>
                                            <th class="text-center">D.Price</th>
                                            <th class="text-center">Status</th>
                                            <th class="text-center">Created By</th>
                                            <th class="text-center" width="160px">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </section>
    </div>

    <script>
        $(function() {
            $("#productTbl").DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('products.list') }}",
                    data: function(data) {
                        let customFilter = {};
                        customFilter.category_id = null;
                        data.customFilter = customFilter;
                    },
                    type: "GET",
                },
                columns: [
                    {data: "sn", searchable: false, orderable: false, className: "text-center"},
                    {data: "image", name: "image", searchable: false, orderable: false, className: "text-center"},
                    {data: "category_id", name: "category_id", className: "text-center"},
                    {data: "brand_name", name: "brand_id", className: "text-center"},
                    {data: "name", name: "name", className: "text-center"},
                    {data: "sku", name: "sku", className: "text-center"},
                    {data: "country_id", name: "country_id", className: "text-center"},
                    {data: "trade_price", name: "trade_price", className: "text-center"},
                    {data: "price", name: "price", className: "text-center"},
                    {data: "discount", name: "discount", className: "text-center"},
                    {data: "disValue", name: "disValue", searchable: false, orderable: false, className: "text-center"},
                    {data: "status", name: "status", searchable: false, orderable: false, className: "text-center"},
                    {data: "created_by", name: "created_by", className: "text-center"},
                    {data: "action", name: "action", searchable: false, orderable: false, className: "text-center"},
                ],
                lengthMenu: [[15, 50, 100, -1], [15, 50, 100, "All"]],
            });
        });
    </script>
@endsection
