@extends('backend.layouts.master')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        {{-- Page Header --}}
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:22px;flex-wrap:wrap;gap:12px;">
            <div>
                <h1 style="font-size:22px;font-weight:800;color:#0f172a;margin:0;">
                    <i class="fas fa-users" style="color:#6366f1;margin-right:8px;"></i>
                    Customers List
                </h1>
                <p style="color:#64748b;font-size:13px;margin:2px 0 0;">
                    <a href="{{ route('home') }}" style="color:#6366f1;text-decoration:none;">Home</a>
                    <span style="margin:0 6px;color:#cbd5e1;">/</span>
                    Customers
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
                                    <i class="fas fa-list" style="color:#6366f1;margin-right:6px;"></i>
                                    Manage Customers
                                </span>
                            </div>
                            <div class="card-body">
                                <table id="customerTbl" class="table table-bordered table-striped nowrap dt-responsive" style="width: 100%">
                                    <thead>
                                        <tr>
                                            <th class="text-center" width="6%">SN</th>
                                            <th class="text-center">Name</th>
                                            <th class="text-center">Email</th>
                                            <th class="text-center">Mobile No</th>
                                            <th class="text-center">Address</th>
                                            <th class="text-center" width="10%">Action</th>
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
            $("#customerTbl").DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('customers.list') }}",
                    data: function(data) {
                        let customFilter = {};
                        customFilter.usertype = null;
                        data.customFilter = customFilter;
                    },
                    type: "GET",
                },
                columns: [
                    {data: "sn", searchable: false, className: "text-center", orderable: false},
                    {data: "name", className: "text-center", name: "name"},
                    {data: "email", className: "text-center", name: "email"},
                    {data: "mobile", className: "text-center", name: "mobile"},
                    {data: "address", className: "text-center", name: "address"},
                    {data: "action", className: "text-center", name: "action", searchable: false, orderable: false}
                ]
            });
        });
    </script>
@endsection
