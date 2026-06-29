@extends('backend.layouts.master')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        {{-- Page Header --}}
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:22px;flex-wrap:wrap;gap:12px;">
            <div>
                <h1 style="font-size:22px;font-weight:800;color:#0f172a;margin:0;">
                    <i class="fas fa-users" style="color:#6366f1;margin-right:8px;"></i>
                    Users List
                </h1>
                <p style="color:#64748b;font-size:13px;margin:2px 0 0;">
                    <a href="{{ route('home') }}" style="color:#6366f1;text-decoration:none;">Home</a>
                    <span style="margin:0 6px;color:#cbd5e1;">/</span>
                    Users
                </p>
            </div>
            <a class="btn btn-sm btn-primary" href="{{ route('users.add') }}" style="display:inline-flex;align-items:center;gap:6px;padding:9px 18px;background:#6366f1;border:none;border-radius:8px;font-size:13px;font-weight:600;color:#fff;text-decoration:none;">
                <i class="fas fa-plus-circle"></i> Add User
            </a>
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
                                    Manage Users
                                </span>
                            </div>
                            <div class="card-body">
                                <table id="usersTbl" class="table table-bordered table-striped nowrap dt-responsive" style="width: 100%">
                                    <thead>
                                        <tr>
                                            <th width="6%" class="text-center">SN</th>
                                            <th class="text-center">Role</th>
                                            <th class="text-center">Name</th>
                                            <th class="text-center">Email</th>
                                            <th width="12%" class="text-center">Action</th>
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
            $("#usersTbl").DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('users.list') }}",
                    data: function(data) {
                        let customFilter = {};
                        customFilter.usertype = null;
                        data.customFilter = customFilter;
                    },
                    type: "GET",
                },
                columns: [
                    {data: "sn", searchable: false, orderable: false, className: "text-center"},
                    {data: "role", name: "role", className: "text-center"},
                    {data: "name", name: "name", className: "text-center"},
                    {data: "email", name: "email", className: "text-center"},
                    {data: "action", name: "action", searchable: false, orderable: false, className: "text-center"}
                ]
            });
        });
    </script>
@endsection
