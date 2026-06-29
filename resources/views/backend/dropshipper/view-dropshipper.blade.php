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
                                <div class="table-responsive">
                                    <table class="dataTables table table-bordered table-striped nowrap dt-responsive" style="width: 100%">
                                        <thead>
                                            <tr>
                                                <th class="text-center" style="width: 40px;">SN</th>
                                                <th class="text-center">Name</th>
                                                <th class="text-center">Email</th>
                                                <th class="text-center">Phone No</th>
                                                <th class="text-center">Shop Name</th>
                                                <th class="text-center">Address</th>
                                                <th class="text-center">Registered / Active On</th>
                                                <th class="text-center">Payment</th>
                                                <th class="text-center">Status</th>
                                                <th class="text-center" width="12%">Action</th>
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
                                                        <div style="display:flex;flex-wrap:wrap;gap:6px;justify-content:center;">
                                                            @if ($vendor->status == 0)
                                                                <a class="btn btn-xs btn-success" href="{{ route('dropshippers.status', ['id' => $vendor->id, 'status' => '1']) }}">Activate</a>
                                                            @elseif ($vendor->status == 1)
                                                                <a class="btn btn-xs btn-warning" href="{{ route('dropshippers.status', ['id' => $vendor->id, 'status' => '0']) }}">Deactivate</a>
                                                            @else
                                                                <a class="btn btn-xs btn-warning" href="{{ route('dropshippers.status', ['id' => $vendor->id, 'status' => '0']) }}">Deactivate</a>
                                                            @endif

                                                            <a class="btn btn-xs btn-danger" href="{{ route('dropshippers.status', ['id' => $vendor->id, 'status' => '2']) }}">Suspend</a>

                                                            @if ($vendor->payment_status == 0)
                                                                <a class="btn btn-xs btn-outline-success" href="{{ route('dropshippers.payment_status', ['id' => $vendor->id, 'payment_status' => '1']) }}">Paid</a>
                                                            @else
                                                                <a class="btn btn-xs btn-outline-danger" href="{{ route('dropshippers.payment_status', ['id' => $vendor->id, 'payment_status' => '0']) }}">Unpaid</a>
                                                            @endif

                                                            <a class="btn btn-xs btn-primary" href="{{ route('dropshippers.edit', $vendor->id) }}">
                                                                <i class="fas fa-edit"></i> Edit
                                                            </a>

                                                            <a class="btn btn-xs btn-success" href="{{ route('dropshippers.profile.verify', $vendor->id) }}">
                                                                <i class="fas fa-id-card"></i> Profile
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
                responsive: true
            });
        });
    </script>
@endpush
