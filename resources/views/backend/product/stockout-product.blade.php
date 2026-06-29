@extends('backend.layouts.master')
@section('content')
<div class="content-wrapper">
    {{-- Page Header --}}
    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:22px;flex-wrap:wrap;gap:12px;">
        <div>
            <h1 style="font-size:22px;font-weight:800;color:#0f172a;margin:0;">
                <i class="fas fa-times-circle" style="color:#ef4444;margin-right:8px;"></i>
                Stock Out Products
            </h1>
            <p style="color:#64748b;font-size:13px;margin:2px 0 0;">
                <a href="{{ route('home') }}" style="color:#6366f1;text-decoration:none;">Home</a>
                <span style="margin:0 6px;color:#cbd5e1;">/</span>
                <a href="{{ route('products.view') }}" style="color:#6366f1;text-decoration:none;">Products</a>
                <span style="margin:0 6px;color:#cbd5e1;">/</span>
                Stock Out
            </p>
        </div>
        <a href="{{ route('products.lowstock.view') }}" class="btn btn-sm btn-warning" style="display:inline-flex;align-items:center;gap:6px;padding:9px 18px;background:#f59e0b;border:none;border-radius:8px;font-size:13px;font-weight:600;color:#fff;text-decoration:none;">
            <i class="fas fa-exclamation-triangle"></i> Low Stock Products
        </a>
    </div>

    {{-- Quick Stats Row --}}
    <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));gap:16px;margin-bottom:24px;">
        <div style="background:#ffffff;border:1px solid #e2e8f0;border-radius:12px;padding:16px 20px;display:flex;align-items:center;gap:14px;box-shadow:0 1px 4px rgba(0,0,0,0.06);">
            <div style="background:rgba(16,185,129,0.1);color:#10b981;width:44px;height:44px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:18px;">
                <i class="fas fa-check-circle"></i>
            </div>
            <div>
                <span style="display:block;font-size:12px;color:#64748b;font-weight:600;text-transform:uppercase;">Active</span>
                <span style="font-size:22px;font-weight:800;color:#0f172a;line-height:1;">{{ \App\Models\Product::where('status',1)->count() }}</span>
            </div>
        </div>
        <div style="background:#ffffff;border:1px solid #e2e8f0;border-radius:12px;padding:16px 20px;display:flex;align-items:center;gap:14px;box-shadow:0 1px 4px rgba(0,0,0,0.06);">
            <div style="background:rgba(245,158,11,0.1);color:#f59e0b;width:44px;height:44px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:18px;">
                <i class="fas fa-clock"></i>
            </div>
            <div>
                <span style="display:block;font-size:12px;color:#64748b;font-weight:600;text-transform:uppercase;">Pending</span>
                <span style="font-size:22px;font-weight:800;color:#0f172a;line-height:1;">{{ \App\Models\Product::where('status',2)->count() }}</span>
            </div>
        </div>
        <div style="background:#ffffff;border:1px solid #e2e8f0;border-radius:12px;padding:16px 20px;display:flex;align-items:center;gap:14px;box-shadow:0 1px 4px rgba(0,0,0,0.06);">
            <div style="background:rgba(100,116,139,0.1);color:#64748b;width:44px;height:44px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:18px;">
                <i class="fas fa-ban"></i>
            </div>
            <div>
                <span style="display:block;font-size:12px;color:#64748b;font-weight:600;text-transform:uppercase;">Inactive</span>
                <span style="font-size:22px;font-weight:800;color:#0f172a;line-height:1;">{{ \App\Models\Product::where('status',0)->count() }}</span>
            </div>
        </div>
        <div style="background:#ffffff;border:1px solid #e2e8f0;border-radius:12px;padding:16px 20px;display:flex;align-items:center;gap:14px;box-shadow:0 1px 4px rgba(0,0,0,0.06);">
            <div style="background:rgba(239,68,68,0.1);color:#ef4444;width:44px;height:44px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:18px;">
                <i class="fas fa-times-circle"></i>
            </div>
            <div>
                <span style="display:block;font-size:12px;color:#64748b;font-weight:600;text-transform:uppercase;">Stock Out</span>
                <span style="font-size:22px;font-weight:800;color:#0f172a;line-height:1;">{{ \App\Models\Product::where('quantity','<=',0)->where('status',1)->count() }}</span>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="card shadow-sm">
                <div class="card-header" style="background:#ef4444;color:#fff;">
                    <span class="card-title"><i class="fas fa-times-circle mr-2"></i>Stock Out Products</span>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="stockoutTbl" class="table table-bordered table-striped nowrap" style="width:100%">
                            <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th class="text-center">Image</th>
                                    <th class="text-center">Product Name</th>
                                    <th class="text-center">Price</th>
                                    <th class="text-center">Stock</th>
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
  $('#stockoutTbl').DataTable({
    processing: true,
    serverSide: true,
    ajax: '{{ route("products.stockout.list") }}',
    columns: [
      { data: 'id', className: "text-center" },
      { data: 'image', orderable: false, className: "text-center" },
      { data: 'name', className: "text-center" },
      { data: 'price', className: "text-center" },
      { data: 'qty', className: "text-center" },
      { data: 'vendor', className: "text-center" },
      { data: 'action', orderable: false, className: "text-center" }
    ],
    order: [[0, 'desc']]
  });
});
</script>
@endpush
@endsection
