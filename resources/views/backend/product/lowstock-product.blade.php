@extends('backend.layouts.master')
@section('content')
<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h5 class="m-0"><i class="fas fa-exclamation-triangle text-warning"></i> Low Stock Products</h5>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('products.view') }}">Products</a></li>
            <li class="breadcrumb-item active">Low Stock</li>
          </ol>
        </div>
      </div>
    </div>
  </div>

  <section class="content">
    <div class="container-fluid">
      <div class="card shadow-sm">
        <div class="card-header bg-warning">
          <h3 class="card-title"><i class="fas fa-exclamation-triangle mr-2"></i>Low Stock Products (Qty ≤ 5)</h3>
          <div class="card-tools">
            <a href="{{ route('products.stockout.view') }}" class="btn btn-danger btn-sm">
              <i class="fas fa-times-circle"></i> Stock Out
            </a>
          </div>
        </div>
        <div class="card-body">
          <table id="lowstockTbl" class="table table-bordered table-striped nowrap dt-responsive" style="width:100%">
            <thead class="bg-light">
              <tr>
                <th>#</th>
                <th>Image</th>
                <th>Product Name</th>
                <th>Price</th>
                <th>Stock Left</th>
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
  $('#lowstockTbl').DataTable({
    processing: true,
    serverSide: true,
    ajax: '{{ route("products.lowstock.list") }}',
    columns: [
      { data: 'id' },
      { data: 'image', orderable: false },
      { data: 'name' },
      { data: 'price' },
      { data: 'qty' },
      { data: 'vendor' },
      { data: 'action', orderable: false }
    ],
    order: [[4, 'asc']],
    responsive: true
  });
});
</script>
@endpush
@endsection
