@extends('backend.layouts.master')
@section('content')
<div class="content-wrapper">
    {{-- Page Header --}}
    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:22px;flex-wrap:wrap;gap:12px;">
        <div>
            <h1 style="font-size:22px;font-weight:800;color:#0f172a;margin:0;">
                <i class="fas fa-exclamation-triangle" style="color:#f59e0b;margin-right:8px;"></i>
                Low Stock Products
            </h1>
            <p style="color:#64748b;font-size:13px;margin:2px 0 0;">
                <a href="{{ route('home') }}" style="color:#6366f1;text-decoration:none;">Home</a>
                <span style="margin:0 6px;color:#cbd5e1;">/</span>
                <a href="{{ route('products.view') }}" style="color:#6366f1;text-decoration:none;">Products</a>
                <span style="margin:0 6px;color:#cbd5e1;">/</span>
                Low Stock
            </p>
        </div>
        <a href="{{ route('products.stockout.view') }}" class="btn btn-sm btn-danger" style="display:inline-flex;align-items:center;gap:6px;padding:9px 18px;background:#ef4444;border:none;border-radius:8px;font-size:13px;font-weight:600;color:#fff;text-decoration:none;">
            <i class="fas fa-times-circle"></i> Stock Out Products
        </a>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="card shadow-sm">
                <div class="card-header" style="background:#f59e0b;color:#fff;">
                    <span class="card-title"><i class="fas fa-exclamation-triangle mr-2"></i>Low Stock Products (Qty ≤ 5)</span>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="lowstockTbl" class="table table-bordered table-striped nowrap" style="width:100%">
                            <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th class="text-center">Image</th>
                                    <th class="text-center">Product Name</th>
                                    <th class="text-center">Price</th>
                                    <th class="text-center">Stock Left</th>
                                    <th class="text-center">Vendor</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

@push('scripts')
<script>
$(document).ready(function () {
  $('#lowstockTbl').DataTable({
    processing: true,
    serverSide: true,
    ajax: '{{ route("products.lowstock.list") }}',
    columns: [
      { data: 'id', className: "text-center" },
      { data: 'image', orderable: false, className: "text-center" },
      { data: 'name', className: "text-center" },
      { data: 'price', className: "text-center" },
      { data: 'qty', className: "text-center" },
      { data: 'vendor', className: "text-center" },
      { data: 'action', orderable: false, className: "text-center" }
    ],
    order: [[4, 'asc']]
  });
});
</script>
@endpush
@endsection
