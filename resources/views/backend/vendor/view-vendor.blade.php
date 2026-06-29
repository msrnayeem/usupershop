@extends('backend.layouts.master')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        {{-- Page Header --}}
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:22px;flex-wrap:wrap;gap:12px;">
            <div>
                <h1 style="font-size:22px;font-weight:800;color:#0f172a;margin:0;">
                    <i class="fas fa-store" style="color:#6366f1;margin-right:8px;"></i>
                    {{ $pageTitle }}
                </h1>
                <p style="color:#64748b;font-size:13px;margin:2px 0 0;">
                    <a href="{{ route('home') }}" style="color:#6366f1;text-decoration:none;">Home</a>
                    <span style="margin:0 6px;color:#cbd5e1;">/</span>
                    {{ $pageTitle }}
                </p>
            </div>
            <div>
                <button type="button" class="btn btn-sm btn-primary edit-commission" data-toggle="modal" data-target="#vendorCommissionModal" data-user-id="" data-commission="" style="display:inline-flex;align-items:center;gap:6px;padding:9px 18px;background:#6366f1;border:none;border-radius:8px;font-size:13px;font-weight:600;color:#fff;">
                    <i class="fas fa-percent"></i> Add Vendor Commission
                </button>
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
                                    Manage Vendors
                                </span>
                            </div>
                            <div class="card-body">
                                <div class="msg"></div>
                                <table class="dataTables table table-bordered table-striped nowrap dt-responsive" style="width: 100%">
                                    <thead>
                                        <tr>
                                            <th class="text-center" style="width: 40px;">SN</th>
                                            <th class="text-center">Name</th>
                                            <th class="text-center">Email</th>
                                            <th class="text-center">Phone No</th>
                                            <th class="text-center">Shop Name</th>
                                            <th class="text-center">Address</th>
                                            <th class="text-center">Commission</th>
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
                                                <td class="text-center"><span class="badge badge-light" style="font-size:13px;font-weight:700;color:#475569;background:#f1f5f9;border:1px solid #cbd5e1;padding:4px 8px;border-radius:6px;">{{ $vendor->commission . '%' }}</span></td>
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
                                                            <a class="btn btn-xs btn-success" href="{{ route('vendors.status', ['id' => $vendor->id, 'status' => '1']) }}">Activate</a>
                                                        @elseif ($vendor->status == 1)
                                                            <a class="btn btn-xs btn-warning" href="{{ route('vendors.status', ['id' => $vendor->id, 'status' => '0']) }}">Deactivate</a>
                                                        @else
                                                            <a class="btn btn-xs btn-warning" href="{{ route('vendors.status', ['id' => $vendor->id, 'status' => '0']) }}">Deactivate</a>
                                                        @endif

                                                        <a class="btn btn-xs btn-danger" href="{{ route('vendors.status', ['id' => $vendor->id, 'status' => '2']) }}">Suspend</a>

                                                        @if ($vendor->payment_status == 0)
                                                            <a class="btn btn-xs btn-outline-success" href="{{ route('vendors.payment_status', ['id' => $vendor->id, 'payment_status' => '1']) }}">Paid</a>
                                                        @else
                                                            <a class="btn btn-xs btn-outline-danger" href="{{ route('vendors.payment_status', ['id' => $vendor->id, 'payment_status' => '0']) }}">Unpaid</a>
                                                        @endif

                                                        <a class="btn btn-xs btn-primary" href="{{ route('vendors.edit', $vendor->id) }}">
                                                            <i class="fas fa-edit"></i> Edit
                                                        </a>

                                                        <a class="btn btn-xs btn-success" href="{{ route('vendors.profile.verify', $vendor->id) }}">
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
                    </section>
                </div>
            </div>
        </section>
    </div>

    <!-- Vendor Commission Modal -->
    <div class="modal fade" id="vendorCommissionModal" tabindex="-1" role="dialog" aria-labelledby="vendorCommissionModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content border-0" style="border-radius:12px;box-shadow:0 10px 25px -5px rgba(0,0,0,0.1);">
                <form id="commissionForm" method="POST" action="{{ route('vendors.commission') }}">
                    @csrf
                    <input type="hidden" name="user_id" id="modalUserId">
                    <div class="modal-header" style="border-bottom:1px solid #e2e8f0;background:#f8fafc;border-top-left-radius:12px;border-top-right-radius:12px;">
                        <h6 class="modal-title" style="font-weight:700;color:#0f172a;">Vendor Commission</h6>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" style="padding:20px;">
                        <div class="form-group mb-0">
                            <label for="sellerCommissionInput" style="font-weight:600;color:#334155;">Vendor Commission (%)</label>
                            <input type="number" class="form-control" id="sellerCommissionInput" name="commission" placeholder="e.g., 10" min="0" max="100" required>
                        </div>
                    </div>
                    <div class="modal-footer" style="border-top:1px solid #e2e8f0;">
                        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal" style="border-radius:6px;">Close</button>
                        <button type="submit" class="btn btn-primary btn-sm" style="background:#6366f1;border:none;border-radius:6px;">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function () {
            $('.dataTables').DataTable({
                responsive: true
            });
        });

        $(document).on('click', '.edit-commission', function() {
            var userId = $(this).data('user-id');
            var commission = $(this).data('commission');
            $('#modalUserId').val(userId);
            $('#sellerCommissionInput').val(commission);
        });
    </script>
@endpush
