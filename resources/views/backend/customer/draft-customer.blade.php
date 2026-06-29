@extends('backend.layouts.master')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        {{-- Page Header --}}
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:22px;flex-wrap:wrap;gap:12px;">
            <div>
                <h1 style="font-size:22px;font-weight:800;color:#0f172a;margin:0;">
                    <i class="fas fa-user-clock" style="color:#eab308;margin-right:8px;"></i>
                    Draft Customers List
                </h1>
                <p style="color:#64748b;font-size:13px;margin:2px 0 0;">
                    <a href="{{ route('home') }}" style="color:#6366f1;text-decoration:none;">Home</a>
                    <span style="margin:0 6px;color:#cbd5e1;">/</span>
                    Draft Customers
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
                                    Manage Draft Customers
                                </span>
                            </div>
                            <div class="card-body">
                                <table id="draftCustomerTbl" class="table table-bordered table-striped nowrap dt-responsive" style="width: 100%">
                                    <thead>
                                        <tr>
                                            <th width="6%" class="text-center">SN</th>
                                            <th class="text-center">Name</th>
                                            <th class="text-center">Email</th>
                                            <th class="text-center">Mobile No</th>
                                            <th class="text-center">Address</th>
                                            <th class="text-center">Signup Status</th>
                                            <th width="10%" class="text-center">Action</th>
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
            $("#draftCustomerTbl").DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('customers.draft.list') }}",
                    data: function(data) {
                        let customFilter = {};
                        customFilter.usertype = null;
                        data.customFilter = customFilter;
                    },
                    type: "GET",
                },
                columns: [
                    {data: "sn", searchable: false, orderable: false, className: "text-center"},
                    {data: "name", name: "name", className: "text-center"},
                    {data: "email", name: "email", className: "text-center"},
                    {data: "mobile", name: "mobile", className: "text-center"},
                    {data: "address", name: "address", className: "text-center"},
                    {data: "difference", name: "difference", searchable: false, orderable: false, className: "text-center"},
                    {data: "action", name: "action", searchable: false, orderable: false, className: "text-center"}
                ]
            });
        });
    </script>
@endsection
