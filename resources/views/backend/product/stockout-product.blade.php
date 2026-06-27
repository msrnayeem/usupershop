@extends('backend.layouts.master')
@section('content')
<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h5 class="m-0"><i class="fas fa-times-circle text-danger"></i> Stock Out Products</h5>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('products.view') }}">Products</a></li>
            <li class="breadcrumb-item active">Stock Out</li>
          </ol>
        </div>
      </div>

      {{-- Quick Stats Row --}}
      <div class="row mb-3">
        <div class="col-md-3">
          <div class="info-box shadow-sm">
            <span class="info-box-icon bg-success"><i class="fas fa-check-circle"></i></span>
            <div class="info-box-content">
              <span class="info-box-text">Active</span>
              <span class="info-box-number">{{ \App\Models\Product::where('status',1)->count() }}</span>
            </div>
          </div>
        </div>
        <div class="col-md-3">
          <div class="info-box shadow-sm">
            <span class="info-box-icon bg-warning"><i class="fas fa-clock"></i></span>
            <div class="info-box-content">
              <span class="info-box-text">Pending</span>
              <span class="info-box-number">{{ \App\Models\Product::where('status',2)->count() }}</span>
            </div>
          </div>
        </div>
        <div class="col-md-3">
          <div class="info-box shadow-sm">
            <span class="info-box-icon bg-secondary"><i class="fas fa-ban"></i></span>
            <div class="info-box-content">
              <span class="info-box-text">Inactive</span>
              <span class="info-box-number">{{ \App\Models\Product::where('status',0)->count() }}</span>
            </div>
          </div>
        </div>
        <div class="col-md-3">
          <div class="info-box shadow-sm">
            <span class="info-box-icon bg-danger"><i class="fas fa-times-circle"></i></span>
            <div class="info-box-content">
              <span class="info-box-text">Stock Out</span>
              <span class="info-box-number">{{ \App\Models\Product::where('quantity','<=',0)->where('status',1)->count() }}</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <section class="content">
    <div class="container-fluid">
      <div class="card shadow-sm">
        <div class="card-header bg-danger text-white">
          <h3 class="card-title"><i class="fas fa-times-circle mr-2"></i>Stock Out Products</h3>
          <div class="card-tools">
            <a href="{{ route('products.lowstock.view') }}" class="btn btn-warning btn-sm">
              <i class="fas fa-exclamation-triangle"></i> Low Stock
            </a>
          </div>
        </div>
        <div class="card-body">
          <table id="stockoutTbl" class="table table-bordered table-striped nowrap dt-responsive" style="width:100%">
            <thead class="bg-light">
              <tr>
                <th>#</th>
                <th>Image</th>
                <th>Product Name</th>
                <th>Price</th>
                <th>Stock</th>
                <th>Vendor</th>
                <th>Action</th>
              </tr>
            </thead>
          </table>
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
      { data: 'id' },
      { data: 'image', orderable: false },
      { data: 'name' },
      { data: 'price' },
      { data: 'qty' },
      { data: 'vendor' },
      { data: 'action', orderable: false }
    ],
    order: [[0, 'desc']],
    responsive: true
  });
});
</script>
@endpush
@endsection
