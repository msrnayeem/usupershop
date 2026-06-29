@extends('backend.layouts.master')
@section('content')
    <div class="content-wrapper">
        {{-- Page Header --}}
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:22px;flex-wrap:wrap;gap:12px;">
            <div>
                <h1 style="font-size:22px;font-weight:800;color:#0f172a;margin:0;">
                    <i class="fas fa-hand-holding-usd" style="color:#6366f1;margin-right:8px;"></i>
                    Order Commission
                </h1>
                <p style="color:#64748b;font-size:13px;margin:2px 0 0;">
                    <a href="{{ route('home') }}" style="color:#6366f1;text-decoration:none;">Home</a>
                    <span style="margin:0 6px;color:#cbd5e1;">/</span>
                    Order Commission
                </p>
            </div>
        </div>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <section class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <span class="card-title">
                                    <i class="fas fa-receipt" style="color:#6366f1;margin-right:6px;"></i>
                                    Manage Order Commission
                                </span>
                            </div>
                            <div class="card-body">
                                <div class="msg mb-3"></div>
                              
                                <table id="orderCommissionTbl" class="table table-bordered table-striped nowrap dt-responsive" style="width: 100%">
                                    <thead>
                                        <tr>  
                                            <th class="text-center" width="4%">SN</th>
                                            <th class="text-center">Order ID</th>
                                            <th class="text-center">Reseller</th>
                                            <th class="text-center">Debit</th>
                                            <th class="text-center">Credit</th>
                                            <th class="text-center">Payment Mode</th>
                                            <th class="text-center">Reference</th>
                                            <th class="text-center">Comm. Date</th>
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

    <script type="text/javascript">
        $(document).ready(function() {
            let orderCommissionTbl = $("#orderCommissionTbl").DataTable({
                processing: true,
                serverSide: true,
                searchable: true,
                ajax: {
                    url: "{{ route('order.commission.list') }}",
                    data: function(data) {
                        let customFilter = {};
                    },
                    type: "GET",
                },
                columns: [
                    {data: "sn", searchable: false, orderable: false, className: "text-center"},
                    {data: "order_id", name: "order_id", className: "text-center"},
                    {data: "reseller_id", name: "reseller_id", className: "text-center"},
                    {data: "debit_balance", name: "debit_balance", searchable: false, orderable: false, className: "text-center"},
                    {data: "credit_balance", name: "credit_balance", searchable: false, orderable: false, className: "text-center"},
                    {data: "payment_mood", name: "payment_mood", searchable: false, orderable: false, className: "text-center"},
                    {data: "reference", name: "reference", searchable: false, orderable: false, className: "text-center"},
                    {data: "comm_date", name: "comm_date", searchable: false, orderable: false, className: "text-center"}
                ],
                lengthMenu: [[15, 50, 100, -1], [15, 50, 100, "All"]],
            });
            
            jQuery(function($) {
                $('.chosen-select').chosen({allow_single_deselect: true});
            });
        });
    </script>
@endsection
