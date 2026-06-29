@extends('backend.layouts.master')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        {{-- Page Header --}}
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:22px;flex-wrap:wrap;gap:12px;">
            <div>
                <h1 style="font-size:22px;font-weight:800;color:#0f172a;margin:0;">
                    <i class="fas fa-cubes" style="color:#6366f1;margin-right:8px;"></i>
                    Manage Subscriptions
                </h1>
                <p style="color:#64748b;font-size:13px;margin:2px 0 0;">
                    <a href="{{ route('home') }}" style="color:#6366f1;text-decoration:none;">Home</a>
                    <span style="margin:0 6px;color:#cbd5e1;">/</span>
                    Subscription Plan Settings
                </p>
            </div>
            @if ($countSellerFee > 1)
                <a class="btn btn-sm btn-primary" href="{{ route('subscriptions.add') }}" style="display:inline-flex;align-items:center;gap:6px;padding:9px 18px;background:#6366f1;border:none;border-radius:8px;font-size:13px;font-weight:600;color:#fff;text-decoration:none;">
                    <i class="fas fa-plus-circle"></i> Add Plan
                </a>
            @endif
        </div>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" style="border:none;border-radius:8px;background:#f0fdf4;color:#15803d;margin-bottom:20px;">
                        <i class="fas fa-check-circle mr-1"></i> {{ session('success') }}
                        <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
                    </div>
                @endif

                <div class="card">
                    <div class="card-header">
                        <span class="card-title">
                            <i class="fas fa-list" style="color:#6366f1;margin-right:6px;"></i>
                            Subscription Plans List
                        </span>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="example1" class="dataTables table table-bordered table-striped nowrap dt-responsive" style="width: 100%">
                                <thead>
                                    <tr>
                                        <th width="6%" class="text-center">SN</th>
                                        <th>Account Type</th>
                                        <th>Fee (৳)</th>
                                        <th>Duration</th>
                                        <th>Features / Allowances</th>
                                        <th width="12%" class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($allData as $key => $logo)
                                        <tr class="{{ $logo->id }}">
                                            <td class="text-center">{{ $key + 1 }}</td>
                                            <td style="font-weight:700;color:#0f172a;">{{ $logo->account_type_of_myshop ?? ''}}</td>
                                            <td style="font-weight:700;color:#16a34a;">৳{{ number_format($logo->subscription_fees ?? 0, 2) }}</td>
                                            <td>
                                                <span class="badge badge-light" style="font-size:12px;font-weight:600;background:#f1f5f9;color:#475569;border:1px solid #cbd5e1;padding:4px 10px;border-radius:6px;">
                                                    {{ ucfirst($logo->duration ?? 'Monthly') }}
                                                </span>
                                            </td>
                                            <td>
                                                @if (!empty($logo->plan_features) && is_array($logo->plan_features))
                                                    <ul class="mb-0 pl-3" style="font-size:13px;color:#475569;line-height:1.7;">
                                                        @foreach ($logo->plan_features as $feature)
                                                            <li>{{ $feature }}</li>
                                                        @endforeach
                                                    </ul>
                                                @else
                                                    <span class="text-muted" style="font-size:12px;">No features listed</span>
                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <div style="display:flex;gap:6px;justify-content:center;">
                                                    <a class="btn btn-xs btn-info" href="{{ route('subscriptions.edit', $logo->id) }}" style="border-radius:6px;padding:4px 8px;font-weight:600;">
                                                        <i class="fas fa-edit mr-1"></i> Edit
                                                    </a>
                                                    <a class="btn btn-xs btn-danger" href="{{ route('subscriptions.delete', $logo->id) }}" style="border-radius:6px;padding:4px 8px;font-weight:600;" onclick="return confirm('Are you sure you want to delete this subscription plan?')">
                                                        <i class="fas fa-trash mr-1"></i> Delete
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
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
        $(document).ready(function () {
            $('.dataTables').DataTable({
                responsive: true
            });
        });
    </script>
@endpush
