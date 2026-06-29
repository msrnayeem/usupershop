@extends('backend.layouts.master')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        {{-- Page Header --}}
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:22px;flex-wrap:wrap;gap:12px;">
            <div>
                <h1 style="font-size:22px;font-weight:800;color:#0f172a;margin:0;">
                    <i class="fas fa-map-marker-alt" style="color:#6366f1;margin-right:8px;"></i>
                    Manage Location
                </h1>
                <p style="color:#64748b;font-size:13px;margin:2px 0 0;">
                    <a href="{{ route('home') }}" style="color:#6366f1;text-decoration:none;">Home</a>
                    <span style="margin:0 6px;color:#cbd5e1;">/</span>
                    Locations List
                </p>
            </div>
            <a class="btn btn-sm btn-primary" href="{{ route('areas.location.add') }}" style="display:inline-flex;align-items:center;gap:6px;padding:9px 18px;background:#6366f1;border:none;border-radius:8px;font-size:13px;font-weight:600;color:#fff;text-decoration:none;">
                <i class="fas fa-plus-circle"></i> Add Location
            </a>
        </div>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="card">
                    <div class="card-header">
                        <span class="card-title">
                            <i class="fas fa-list" style="color:#6366f1;margin-right:6px;"></i>
                            Locations / Districts List
                        </span>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="locationTbl" class="table table-bordered table-striped nowrap dt-responsive" style="width: 100%">
                                <thead>
                                    <tr>
                                        <th width="8%" class="text-center">SN</th>
                                        <th>Division</th>
                                        <th>Location / District</th>
                                        <th width="15%" class="text-center">Action</th>
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
            $("#locationTbl").DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: {
                    url: "{{ route('areas.location.list') }}",
                    data: function(data) {
                        let customFilter = {};
                        customFilter.division_id = null;
                        data.customFilter = customFilter;
                    },
                    type: "GET",
                },
                columns: [
                    { data: "sn", searchable: false, orderable: false, className: 'text-center' },
                    { data: "division_id", name: "division_id", className: 'font-weight-bold text-dark' },
                    { data: "location_name", name: "location_name" },
                    { data: "action", name: "action", searchable: false, orderable: false, className: 'text-center' }
                ]
            });
        });
    </script>
@endpush
