@extends('backend.seller.seller-master')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        {{-- Page Header --}}
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:22px;flex-wrap:wrap;gap:12px;">
            <div>
                <h1 style="font-size:22px;font-weight:800;color:#0f172a;margin:0;">
                    <i class="fas fa-boxes" style="color:#6366f1;margin-right:8px;"></i>
                    My Products
                </h1>
                <p style="color:#64748b;font-size:13px;margin:2px 0 0;">
                    <a href="{{ route('seller.dashboard') }}" style="color:#6366f1;text-decoration:none;">Dashboard</a>
                    <span style="margin:0 6px;color:#cbd5e1;">/</span>
                    My Active Products
                </p>
            </div>
            <a class="btn btn-sm btn-primary" href="{{ route('sellers.shopkeeper_product') }}" style="display:inline-flex;align-items:center;gap:6px;padding:9px 18px;background:#6366f1;border:none;border-radius:8px;font-size:13px;font-weight:600;color:#fff;text-decoration:none;">
                <i class="fas fa-plus-circle"></i> Add Products from Catalog
            </a>
        </div>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="card">
                    <div class="card-header">
                        <span class="card-title">
                            <i class="fas fa-list" style="color:#6366f1;margin-right:6px;"></i>
                            List of active products inside my storefront
                        </span>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="productTbl" class="table table-bordered table-striped nowrap dt-responsive" style="width: 100%">
                                <thead>
                                    <tr>
                                        <th width="8%" class="text-center">SN</th>
                                        <th>Product Name</th>
                                        <th width="15%" class="text-center">Image</th>
                                        <th width="15%" class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <script>
        $(function() {
            $("#productTbl").DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: {
                    url: "{{ route('sellers.product.list') }}",
                    data: function(data) {
                        let customFilter = {};
                        customFilter.created_at = null;
                        data.customFilter = customFilter;
                    },
                    type: "GET",
                },
                columns: [
                    { data: "sn", searchable: false, orderable: false, className: 'text-center' },
                    { data: "name", name: "name", className: 'font-weight-bold text-dark' },
                    { data: "image", name: "image", searchable: false, orderable: false, className: 'text-center' },
                    { data: "action", name: "action", searchable: false, orderable: false, className: 'text-center' }
                ]
            });
        });
    </script>
@endpush