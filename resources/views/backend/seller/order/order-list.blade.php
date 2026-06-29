@extends('backend.seller.seller-master')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        {{-- Page Header --}}
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:22px;flex-wrap:wrap;gap:12px;">
            <div>
                <h1 style="font-size:22px;font-weight:800;color:#0f172a;margin:0;">
                    <i class="fas fa-shopping-bag" style="color:#6366f1;margin-right:8px;"></i>
                    Manage Orders
                </h1>
                <p style="color:#64748b;font-size:13px;margin:2px 0 0;">
                    <a href="{{ route('seller.dashboard') }}" style="color:#6366f1;text-decoration:none;">Dashboard</a>
                    <span style="margin:0 6px;color:#cbd5e1;">/</span>
                    All Orders List
                </p>
            </div>
        </div>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="card">
                    <div class="card-header">
                        <span class="card-title">
                            <i class="fas fa-list" style="color:#6366f1;margin-right:6px;"></i>
                            List of all customer orders
                        </span>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="penOrderTbl" class="table table-bordered table-striped nowrap dt-responsive" style="width: 100%">
                                <thead>
                                    <tr>
                                        <th width="8%" class="text-center">SN</th>
                                        <th>Order No</th>
                                        <th>Total Amount</th>
                                        <th>Payment Type</th>
                                        <th>Commission</th>
                                        <th>Order Date</th>
                                        <th class="text-center">Status</th>
                                        <th width="12%" class="text-center">Action</th>
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
            $("#penOrderTbl").DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: {
                    url: "{{ route('seller.orders.plist') }}",
                    data: function(data) {
                        let customFilter = {};
                        customFilter.order_no = null;
                        data.customFilter = customFilter;
                    },
                    type: "GET",
                },
                columns: [
                    { data: "sn", searchable: false, orderable: false, className: 'text-center' },
                    { data: "order_no", name: "order_no", className: 'font-weight-bold text-dark' },
                    { data: "order_total", name: "order_total" },
                    { data: "payment_id", name: "payment_id", searchable: false, orderable: false },
                    { data: "commission", name: "commission", searchable: false, orderable: false },
                    { data: "order_date", name: "order_date", searchable: false, orderable: false },
                    { data: "status", name: "status", searchable: false, orderable: false, className: 'text-center' },
                    { data: "action", name: "action", searchable: false, orderable: false, className: 'text-center' }
                ]
            });
        });
    </script>
@endpush
