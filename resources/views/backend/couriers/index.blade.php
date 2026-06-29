@extends('backend.layouts.master')
@section('content')
<div class="content-wrapper">
    {{-- Page Header --}}
    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:22px;flex-wrap:wrap;gap:12px;">
        <div>
            <h1 style="font-size:22px;font-weight:800;color:#0f172a;margin:0;">
                <i class="fas fa-truck" style="color:#6366f1;margin-right:8px;"></i>
                Courier Services
            </h1>
            <p style="color:#64748b;font-size:13px;margin:2px 0 0;">
                <a href="{{ route('home') }}" style="color:#6366f1;text-decoration:none;">Home</a>
                <span style="margin:0 6px;color:#cbd5e1;">/</span>
                Couriers List
            </p>
        </div>
        <a href="{{ route('couriers.create') }}" class="btn btn-sm btn-primary" style="display:inline-flex;align-items:center;gap:6px;padding:9px 18px;background:#6366f1;border:none;border-radius:8px;font-size:13px;font-weight:600;color:#fff;text-decoration:none;">
            <i class="fas fa-plus"></i> Add Courier
        </a>
    </div>

    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <span class="card-title">
                        <i class="fas fa-list" style="color:#6366f1;margin-right:6px;"></i>
                        Registered Courier Services List
                    </span>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped nowrap dt-responsive" id="courier-table" style="width:100%;">
                            <thead>
                                <tr>
                                    <th width="8%" class="text-center">ID</th>
                                    <th>Courier Name</th>
                                    <th>Client ID / API Key</th>
                                    <th>Store ID</th>
                                    <th class="text-center">Status</th>
                                    <th width="150px" class="text-center">Action</th>
                                </tr>
                            </thead>
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
    $(document).ready(function() {
        $('#courier-table').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: "{{ route('couriers.index') }}",
            columns: [
                { data: 'id', name: 'id', className: 'text-center' },
                { data: 'name', name: 'name', className: 'font-weight-bold text-dark' },
                { data: 'client_id', name: 'client_id', className: 'font-family-monospace' },
                { data: 'store_id', name: 'store_id', className: 'font-family-monospace' },
                { data: 'status', name: 'status', orderable: false, searchable: false, className: 'text-center' },
                { data: 'action', name: 'action', orderable: false, searchable: false, className: 'text-center' }
            ]
        });
    });
</script>
@endpush
