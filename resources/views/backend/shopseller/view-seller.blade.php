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
                    <i class="fas fa-percent"></i> Add Seller Commission
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
                                    Manage Sellers
                                </span>
                            </div>
                            <div class="card-body">
                                <div class="msg"></div>
                                <table id="shopTblseller" class="dataTables table table-bordered table-striped nowrap dt-responsive" style="width: 100%">
                                    <thead>
                                        <tr>
                                            <th class="text-center all" style="width: 50px;">SN</th>
                                            <th class="text-center all" style="width: 18%;">Name</th>
                                            <th class="text-center none">Email</th>
                                            <th class="text-center" style="width: 15%;">Phone No</th>
                                            <th class="text-center" style="width: 20%;">Shop Name</th>
                                            <th class="text-center none">Address</th>
                                            <th class="text-center none">Commission</th>
                                            <th class="text-center none">Registered / Active On</th>
                                            <th class="text-center" style="width: 12%;">Payment</th>
                                            <th class="text-center" style="width: 12%;">Status</th>
                                            <th class="text-center all" style="width: 100px;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($sellers as $i => $seller)
                                            <tr>
                                                <td class="text-center">{{ ++$i }}</td>
                                                <td class="text-center">{{ $seller->name }}</td>
                                                <td class="text-center">{{ $seller->email }}</td>
                                                <td class="text-center">{{ $seller->mobile }}</td>
                                                <td class="text-center">{{ $seller->shop_name }}</td>
                                                <td class="text-center">{{ $seller->address }}</td>
                                                <td class="text-center"><span class="badge badge-light" style="font-size:13px;font-weight:700;color:#475569;background:#f1f5f9;border:1px solid #cbd5e1;padding:4px 8px;border-radius:6px;">{{ $seller->commission . '%' }}</span></td>
                                                <td class="text-center" style="font-size:12px;color:#475569;">
                                                    <div><strong>Registered:</strong> {{ optional($seller->created_at)->format('d M Y, h:i A') ?? '--' }}</div>
                                                    <div class="mt-1"><strong>Active:</strong> {{ optional($seller->activated_at ?: $seller->created_at)->format('d M Y, h:i A') ?? '--' }}</div>
                                                </td>
                                                <td class="text-center">
                                                    @if ($seller->payment_status == 1)
                                                        <span class="badge badge-success" style="padding:5px 10px;border-radius:6px;">Paid</span>
                                                    @else
                                                        <span class="badge badge-danger" style="padding:5px 10px;border-radius:6px;">UnPaid</span>
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    @if ($seller->status == 0)
                                                        <span class="badge badge-warning" style="padding:5px 10px;border-radius:6px;">Inactive</span>
                                                    @elseif ($seller->status == 1)
                                                        <span class="badge badge-success" style="padding:5px 10px;border-radius:6px;">Active</span>
                                                    @else
                                                        <span class="badge badge-danger" style="padding:5px 10px;border-radius:6px;">Suspended</span>
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    @php
                                                        $reseller = App\Models\User::find($seller->reseller_id);
                                                    @endphp
                                                    <div class="dropdown">
                                                        <button class="btn btn-xs btn-outline-secondary dropdown-toggle" type="button" id="dropdownMenu{{ $seller->id }}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="border-radius:6px; padding:5px 12px; font-weight:600; background:#fff; border:1px solid #cbd5e1; color:#475569; display:inline-flex; align-items:center; gap:4px;">
                                                            Actions
                                                        </button>
                                                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenu{{ $seller->id }}" style="border-radius:8px; border:1px solid #e2e8f0; box-shadow:0 4px 12px rgba(0,0,0,0.08); padding:6px 0; min-width:160px;">
                                                            <a class="dropdown-item" href="{{ route('sellers.edit', $seller->id) }}" style="font-size:13px; padding:8px 16px; color:#334155; display:flex; align-items:center; gap:8px;">
                                                                <i class="fas fa-edit" style="color:#6366f1; width:16px;"></i> Edit Profile
                                                            </a>
                                                            <a class="dropdown-item" href="{{ route('sellers.profile', $seller->id) }}" style="font-size:13px; padding:8px 16px; color:#334155; display:flex; align-items:center; gap:8px;">
                                                                <i class="fas fa-id-card" style="color:#10b981; width:16px;"></i> View Profile
                                                            </a>
                                                            <a class="dropdown-item edit-commission" href="#" data-toggle="modal" data-target="#sellerCommissionModal" data-user-id="{{ $seller->id }}" data-commission="{{ str_replace('%', '', $seller->commission) }}" style="font-size:13px; padding:8px 16px; color:#334155; display:flex; align-items:center; gap:8px;">
                                                                <i class="fas fa-percent" style="color:#3b82f6; width:16px;"></i> Commission
                                                            </a>
                                                            @if ($reseller)
                                                                <a class="dropdown-item edit-refer" href="#" data-toggle="modal" data-target="#sellerReferModal" data-reseller-id="{{ $reseller->id }}" data-reseller-name="{{ $reseller->mobile }}" data-reseller-balance="{{ $reseller->balance }}" style="font-size:13px; padding:8px 16px; color:#334155; display:flex; align-items:center; gap:8px;">
                                                                    <i class="fas fa-money-bill" style="color:#8b5cf6; width:16px;"></i> Refer Balance
                                                                </a>
                                                            @endif
                                                            
                                                            <div class="dropdown-divider" style="border-top:1px solid #f1f5f9; margin:6px 0;"></div>
                                                            
                                                            @if ($seller->status == 0)
                                                                <a class="dropdown-item" href="{{ route('vendors.status', ['id' => $seller->id, 'status' => '1']) }}" style="font-size:13px; padding:8px 16px; color:#10b981; font-weight:600; display:flex; align-items:center; gap:8px;">
                                                                    <i class="fas fa-check" style="width:16px;"></i> Activate Seller
                                                                </a>
                                                            @else
                                                                <a class="dropdown-item" href="{{ route('vendors.status', ['id' => $seller->id, 'status' => '0']) }}" style="font-size:13px; padding:8px 16px; color:#f59e0b; font-weight:600; display:flex; align-items:center; gap:8px;">
                                                                    <i class="fas fa-ban" style="width:16px;"></i> Deactivate Seller
                                                                </a>
                                                            @endif
                                                            <a class="dropdown-item" href="{{ route('vendors.status', ['id' => $seller->id, 'status' => '2']) }}" style="font-size:13px; padding:8px 16px; color:#ef4444; font-weight:600; display:flex; align-items:center; gap:8px;">
                                                                <i class="fas fa-times-circle" style="width:16px;"></i> Suspend Seller
                                                            </a>
                                                            
                                                            <div class="dropdown-divider" style="border-top:1px solid #f1f5f9; margin:6px 0;"></div>
                                                            
                                                            @if ($seller->payment_status == 0)
                                                                <a class="dropdown-item" href="{{ route('vendors.payment_status', ['id' => $seller->id, 'payment_status' => '1']) }}" style="font-size:13px; padding:8px 16px; color:#10b981; display:flex; align-items:center; gap:8px;">
                                                                    <i class="fas fa-dollar-sign" style="width:16px;"></i> Mark as Paid
                                                                </a>
                                                            @else
                                                                <a class="dropdown-item" href="{{ route('vendors.payment_status', ['id' => $seller->id, 'payment_status' => '0']) }}" style="font-size:13px; padding:8px 16px; color:#ef4444; display:flex; align-items:center; gap:8px;">
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

    <!-- Seller Commission Modal -->
    <div class="modal fade" id="sellerCommissionModal" tabindex="-1" role="dialog" aria-labelledby="sellerCommissionModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content border-0" style="border-radius:12px;box-shadow:0 10px 25px -5px rgba(0,0,0,0.1);">
                <form id="commissionForm" method="POST" action="{{ route('sellers.commission') }}">
                    @csrf
                    <input type="hidden" name="user_id" id="modalUserId">
                    <div class="modal-header" style="border-bottom:1px solid #e2e8f0;background:#f8fafc;border-top-left-radius:12px;border-top-right-radius:12px;">
                        <h6 class="modal-title" style="font-weight:700;color:#0f172a;">Commission Settings</h6>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" style="padding:20px;">
                        <div class="form-group mb-0">
                            <label for="sellerCommissionInput" style="font-weight:600;color:#334155;">Seller Commission (%)</label>
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

    <!-- Refer Balance Modal -->
    <div class="modal fade" id="sellerReferModal" tabindex="-1" role="dialog" aria-labelledby="sellerReferModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content border-0" style="border-radius:12px;box-shadow:0 10px 25px -5px rgba(0,0,0,0.1);">
                <form id="ReferForm" method="POST" action="{{ route('sellers.add.balance') }}">
                    @csrf
                    <input type="hidden" name="reseller_id" id="resellerIdInput">
                    <div class="modal-header" style="border-bottom:1px solid #e2e8f0;background:#f8fafc;border-top-left-radius:12px;border-top-right-radius:12px;">
                        <h6 class="modal-title" style="font-weight:700;color:#0f172a;">Add Refer Balance</h6>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" style="padding:20px;">
                        <div class="form-group">
                            <label id="resellerLabel" style="font-weight:600;color:#334155;display:block;margin-bottom:8px;font-size:13px;"></label>
                            <input type="number" class="form-control" id="resellerBalanceField" name="balance" placeholder="Enter amount" min="0" required>
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

    <!-- Global Vendor Commission Modal -->
    <div class="modal fade" id="vendorCommissionModal" tabindex="-1" role="dialog" aria-labelledby="vendorCommissionModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content border-0" style="border-radius:12px;box-shadow:0 10px 25px -5px rgba(0,0,0,0.1);">
                <form id="globalCommissionForm" method="POST" action="{{ route('dropshippers.commission') }}">
                    @csrf
                    <div class="modal-header" style="border-bottom:1px solid #e2e8f0;background:#f8fafc;border-top-left-radius:12px;border-top-right-radius:12px;">
                        <h6 class="modal-title" style="font-weight:700;color:#0f172a;">Global Seller Commission</h6>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" style="padding:20px;">
                        <div class="form-group mb-0">
                            <label for="globalCommissionInput" style="font-weight:600;color:#334155;">Commission for all sellers (%)</label>
                            <input type="number" class="form-control" id="globalCommissionInput" name="commission" placeholder="e.g., 10" min="0" max="100" required>
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
                responsive: true,
                autoWidth: false
            });
        });

        $(document).on('click', '.edit-commission', function() {
            var userId = $(this).data('user-id');
            var commission = $(this).data('commission');
            $('#modalUserId').val(userId);
            $('#sellerCommissionInput').val(commission);
        });

        $(document).on('click', '.edit-refer', function() {
            const resellerId = $(this).data('reseller-id');
            const resellerName = $(this).data('reseller-name');
            const resellerBalance = $(this).data('reseller-balance');
            $('#resellerIdInput').val(resellerId);
            $('#resellerLabel').text('Add/Update Refer Balance for Reseller Phone: ' + resellerName);
            $('#resellerBalanceField').val(resellerBalance || 0);
        });

        // Async submit for individual commission
        $('#commissionForm').on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                url: $(this).attr('action'),
                method: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    $('#sellerCommissionModal').modal('hide');
                    toastr.success('Seller commission updated successfully!');
                    setTimeout(function() {
                        window.location.reload();
                    }, 1000);
                },
                error: function(xhr) {
                    toastr.error('Error updating commission');
                }
            });
        });
    </script>
@endpush
