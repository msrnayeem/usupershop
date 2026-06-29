@extends('backend.layouts.master')
@section('content')
<div class="content-wrapper">
    {{-- Page Header --}}
    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:22px;flex-wrap:wrap;gap:12px;">
        <div>
            <h1 style="font-size:22px;font-weight:800;color:#0f172a;margin:0;">
                <i class="fas fa-check-circle" style="color:#10b981;margin-right:8px;"></i>Delivered Orders
            </h1>
            <p style="color:#64748b;font-size:13px;margin:2px 0 0;">
                <a href="{{ route('home') }}" style="color:#6366f1;text-decoration:none;">Home</a>
                <span style="margin:0 6px;color:#cbd5e1;">/</span>Delivered Orders
            </p>
        </div>
    </div>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <span class="card-title"><i class="fas fa-list" style="color:#6366f1;margin-right:6px;"></i>Manage Delivered Orders</span>
                </div>
                <div class="card-body">
                    <table id="dOrderTbl" class="table table-bordered table-striped nowrap dt-responsive" style="width: 100%">
                        <thead>
                            <tr>
                                <th class="text-center" width="6%">SN</th>
                                <th class="text-center">Order No</th>
                                <th class="text-center">Total Amount</th>
                                <th class="text-center">Payment Type</th>
                                <th class="text-center">Order Date</th>
                                <th class="text-center">Status</th>
                                <th class="text-center" width="16%">Action</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
</div>

<script>
    $(function() {
        $("#dOrderTbl").DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('orders.dlist') }}",
                data: function(data) {
                    let customFilter = {};
                    customFilter.order_no = null;
                    data.customFilter = customFilter;
                },
                type: "GET",
            },
            columns: [
                {data: "sn", searchable: false, orderable: false, className: "text-center"},
                {data: "order_no", className: "text-center", name: "order_no"},
                {data: "order_total", className: "text-center", name: "order_total"},
                {data: "payment_id", name: "payment_id", className: "text-center", searchable: false, orderable: false},
                {data: "order_date", name: "order_date", className: "text-center", searchable: false, orderable: false},
                {data: "status", name: "status", className: "text-center", searchable: false, orderable: false},
                {data: "action", name: "action", className: "text-center", searchable: false, orderable: false},
            ]
        });
    });
</script>
@endsection
