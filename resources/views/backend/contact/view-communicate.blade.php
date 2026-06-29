@extends('backend.layouts.master')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        {{-- Page Header --}}
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:22px;flex-wrap:wrap;gap:12px;">
            <div>
                <h1 style="font-size:22px;font-weight:800;color:#0f172a;margin:0;">
                    <i class="fas fa-envelope-open-text" style="color:#6366f1;margin-right:8px;"></i>
                    Customer Communications
                </h1>
                <p style="color:#64748b;font-size:13px;margin:2px 0 0;">
                    <a href="{{ route('home') }}" style="color:#6366f1;text-decoration:none;">Home</a>
                    <span style="margin:0 6px;color:#cbd5e1;">/</span>
                    Inbound Messages
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
                            Customer Messages List
                        </span>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="communicationTbl" class="table table-bordered table-striped nowrap dt-responsive" style="width: 100%">
                                <thead>
                                    <tr>
                                        <th width="8%" class="text-center">SN</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Mobile No</th>
                                        <th>Message</th>
                                        <th>Timestamp</th>
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
            $("#communicationTbl").DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: {
                    url: "{{ route('contacts.communicate.list') }}",
                    data: function(data) {
                        let customFilter = {};
                        customFilter.mobile = null;
                        data.customFilter = customFilter;
                    },
                    type: "GET",
                },
                columns: [
                    { data: "sn", searchable: false, orderable: false, className: 'text-center' },
                    { data: "name", name: "name", className: 'font-weight-bold text-dark' },
                    { data: "email", name: "email" },
                    { data: "mobile", name: "mobile", className: 'font-family-monospace' },
                    { data: "message", name: "message" },
                    { data: "difference", name: "difference", searchable: false, orderable: false },
                    { data: "action", name: "action", searchable: false, orderable: false, className: 'text-center' }
                ]
            });
        });
    </script>
@endpush
