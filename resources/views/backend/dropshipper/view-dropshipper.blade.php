@extends('backend.layouts.master')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        {{-- Page Header --}}
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:22px;flex-wrap:wrap;gap:12px;">
            <div>
                <h1 style="font-size:22px;font-weight:800;color:#0f172a;margin:0;">
                    <i class="fas fa-truck-loading" style="color:#6366f1;margin-right:8px;"></i>
                    {{ $pageTitle }}
                </h1>
                <p style="color:#64748b;font-size:13px;margin:2px 0 0;">
                    <a href="{{ route('home') }}" style="color:#6366f1;text-decoration:none;">Home</a>
                    <span style="margin:0 6px;color:#cbd5e1;">/</span>
                    {{ $pageTitle }}
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
                                    Manage Dropshippers
                                </span>
                            </div>
                            <div class="card-body">
                                <div class="msg"></div>
                                <table class="dataTables table table-bordered table-striped nowrap dt-responsive" style="width: 100%">
                                    <thead>
                                        <tr>
                                            <th class="text-center all" style="width: 50px;">SN</th>
                                            <th class="text-center all" style="width: 18%;">Name</th>
                                            <th class="text-center none">Email</th>
                                            <th class="text-center" style="width: 15%;">Phone No</th>
                                            <th class="text-center" style="width: 20%;">Shop Name</th>
                                            <th class="text-center none">Address</th>
                                            <th class="text-center none">Registered / Active On</th>
                                            <th class="text-center" style="width: 12%;">Payment</th>
                                            <th class="text-center" style="width: 12%;">Status</th>
                                            <th class="text-center all" style="width: 100px;">Action</th>
                                        </tr>
                                    </thead>
                                        <tbody>
                                            @foreach ($vendors as $i => $vendor)
                                                <tr>
                                                    <td class="text-center">{{ ++$i }}</td>
                                                    <td class="text-center">{{ $vendor->name }}</td>
                                                    <td class="text-center">{{ $vendor->email }}</td>
                                                    <td class="text-center">{{ $vendor->mobile }}</td>
                                                    <td class="text-center">{{ $vendor->shop_name }}</td>
                                                    <td class="text-center">{{ $vendor->address }}</td>
                                                    <td class="text-center" style="font-size:12px;color:#475569;">
                                                        <div><strong>Registered:</strong> {{ optional($vendor->created_at)->format('d M Y, h:i A') ?? '--' }}</div>
                                                        <div class="mt-1"><strong>Active:</strong> {{ optional($vendor->activated_at ?: $vendor->created_at)->format('d M Y, h:i A') ?? '--' }}</div>
                                                    </td>
                                                    <td class="text-center">
                                                        @if ($vendor->payment_status == 1)
                                                            <span class="badge badge-success" style="padding:5px 10px;border-radius:6px;">Paid</span>
                                                        @else
                                                            <span class="badge badge-danger" style="padding:5px 10px;border-radius:6px;">UnPaid</span>
                                                        @endif
                                                    </td>
                                                    <td class="text-center">
                                                        @if ($vendor->status == 0)
                                                            <span class="badge badge-warning" style="padding:5px 10px;border-radius:6px;">Inactive</span>
                                                        @elseif ($vendor->status == 1)
                                                            <span class="badge badge-success" style="padding:5px 10px;border-radius:6px;">Active</span>
                                                        @else
                                                            <span class="badge badge-danger" style="padding:5px 10px;border-radius:6px;">Suspended</span>
                                                        @endif
                                                    </td>
                                                    <td class="text-center">
                                                        <div class="dropdown">
                                                            <button class="btn btn-xs btn-outline-secondary dropdown-toggle" type="button" id="dropdownMenu{{ $vendor->id }}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="border-radius:6px; padding:5px 12px; font-weight:600; background:#fff; border:1px solid #cbd5e1; color:#475569; display:inline-flex; align-items:center; gap:4px;">
                                                                Actions
                                                            </button>
                                                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenu{{ $vendor->id }}" style="border-radius:8px; border:1px solid #e2e8f0; box-shadow:0 4px 12px rgba(0,0,0,0.08); padding:6px 0; min-width:160px;">
                                                                <a class="dropdown-item" href="{{ route('dropshippers.edit', $vendor->id) }}" style="font-size:13px; padding:8px 16px; color:#334155; display:flex; align-items:center; gap:8px;">
                                                                    <i class="fas fa-edit" style="color:#6366f1; width:16px;"></i> Edit Profile
                                                                </a>
                                                                <a class="dropdown-item" href="{{ route('dropshippers.profile.verify', $vendor->id) }}" style="font-size:13px; padding:8px 16px; color:#334155; display:flex; align-items:center; gap:8px;">
                                                                    <i class="fas fa-id-card" style="color:#10b981; width:16px;"></i> View Profile
                                                                </a>
                                                                
                                                                <div class="dropdown-divider" style="border-top:1px solid #f1f5f9; margin:6px 0;"></div>
                                                                
                                                                @if ($vendor->status == 0)
                                                                    <a class="dropdown-item" href="{{ route('dropshippers.status', ['id' => $vendor->id, 'status' => '1']) }}" style="font-size:13px; padding:8px 16px; color:#10b981; font-weight:600; display:flex; align-items:center; gap:8px;">
                                                                        <i class="fas fa-check" style="width:16px;"></i> Activate
                                                                    </a>
                                                                @else
                                                                    <a class="dropdown-item" href="{{ route('dropshippers.status', ['id' => $vendor->id, 'status' => '0']) }}" style="font-size:13px; padding:8px 16px; color:#f59e0b; font-weight:600; display:flex; align-items:center; gap:8px;">
                                                                        <i class="fas fa-ban" style="width:16px;"></i> Deactivate
                                                                    </a>
                                                                @endif
                                                                <a class="dropdown-item" href="{{ route('dropshippers.status', ['id' => $vendor->id, 'status' => '2']) }}" style="font-size:13px; padding:8px 16px; color:#ef4444; font-weight:600; display:flex; align-items:center; gap:8px;">
                                                                    <i class="fas fa-times-circle" style="width:16px;"></i> Suspend
                                                                </a>
                                                                
                                                                <div class="dropdown-divider" style="border-top:1px solid #f1f5f9; margin:6px 0;"></div>
                                                                
                                                                @if ($vendor->payment_status == 0)
                                                                    <a class="dropdown-item" href="{{ route('dropshippers.payment_status', ['id' => $vendor->id, 'payment_status' => '1']) }}" style="font-size:13px; padding:8px 16px; color:#10b981; display:flex; align-items:center; gap:8px;">
                                                                        <i class="fas fa-dollar-sign" style="width:16px;"></i> Mark as Paid
                                                                    </a>
                                                                @else
                                                                    <a class="dropdown-item" href="{{ route('dropshippers.payment_status', ['id' => $vendor->id, 'payment_status' => '0']) }}" style="font-size:13px; padding:8px 16px; color:#ef4444; display:flex; align-items:center; gap:8px;">
                                                                        <i class="fas fa-exclamation-circle" style="width:16px;"></i> Mark as Unpaid
                                                                    </a>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                </table>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function () {
            $('.dataTables').DataTable({
                responsive: true,
                autoWidth: false
            });
        });
    </script>
@endpush
