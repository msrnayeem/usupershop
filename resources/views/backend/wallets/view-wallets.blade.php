@extends('backend.layouts.master')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        {{-- Page Header --}}
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:22px;flex-wrap:wrap;gap:12px;">
            <div>
                <h1 style="font-size:22px;font-weight:800;color:#0f172a;margin:0;">
                    <i class="fas fa-wallet" style="color:#6366f1;margin-right:8px;"></i>
                    Manage Wallets
                </h1>
                <p style="color:#64748b;font-size:13px;margin:2px 0 0;">
                    <a href="{{ route('home') }}" style="color:#6366f1;text-decoration:none;">Home</a>
                    <span style="margin:0 6px;color:#cbd5e1;">/</span>
                    Wallets
                </p>
            </div>
            <a class="btn btn-sm btn-primary" href="{{ route('wallets.received') }}" style="display:inline-flex;align-items:center;gap:6px;padding:9px 18px;background:#6366f1;border:none;border-radius:8px;font-size:13px;font-weight:600;color:#fff;text-decoration:none;">
                <i class="fas fa-history"></i> Wallet History
            </a>
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
                            <i class="fas fa-list-ul" style="color:#6366f1;margin-right:6px;"></i>
                            Active Wallets List
                        </span>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="example1" class="dataTables table table-bordered table-striped nowrap dt-responsive" style="width:100%">
                                <thead>
                                    <tr>
                                        <th width="6%" class="text-center">SN</th>
                                        <th>User Name</th>
                                        <th class="d-none">User id</th>
                                        <th>Bkash Phone No</th>
                                        <th>Payment Type</th>
                                        <th>Transaction Status</th>
                                        <th>Balance</th>
                                        <th width="12%" class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if($wallets!=null)
                                        @forelse ($wallets as $key=>$wallet)
                                            <tr class="{{ $wallet->id }}">
                                                <td class="text-center">{{ $key + 1 }}</td>
                                                <td style="font-weight:700;color:#0f172a;">{{ $wallet->name ?? ''}}</td>
                                                <td class="d-none userID">{{ $wallet->user_id}}</td>
                                                <td class="wallet-mobile">{{ $wallet->mobile_no ?? ''}}</td>
                                                <td class="wallet-payment-type">
                                                    @if(strtolower($wallet->payment_type ?? '') == 'bkash')
                                                        <span class="badge badge-danger" style="background:#e11d48;padding:5px 10px;border-radius:6px;">bKash</span>
                                                    @elseif(strtolower($wallet->payment_type ?? '') == 'nagad')
                                                        <span class="badge badge-warning" style="background:#ea580c;color:#fff;padding:5px 10px;border-radius:6px;">Nagad</span>
                                                    @else
                                                        <span class="badge badge-secondary" style="padding:5px 10px;border-radius:6px;">{{ $wallet->payment_type ?? 'Other' }}</span>
                                                    @endif
                                                </td>
                                                <td class="wallet-transaction_status">
                                                    <span class="badge badge-info" style="padding:5px 10px;border-radius:6px;">{{ $wallet->transaction_status ?? 'Pending' }}</span>
                                                </td>
                                                <td class="wallet-balance" style="font-weight:700;color:#0f172a;">{{ $wallet->balance ?? '0.00'}}</td>
                                                <td class="text-center">
                                                    <button type="button" class="btn btn-sm btn-success open-modal" data-toggle="modal" data-target="#paymentModal" style="border-radius:6px;font-weight:600;padding:5px 12px;">
                                                        <i class="fas fa-money-check mr-1"></i> Pay Now
                                                    </button>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="8" class="text-center py-5 text-muted">
                                                    <i class="fas fa-wallet fa-3x mb-2" style="opacity:0.8;"></i>
                                                    <p style="font-weight:600;margin-bottom:0;color:#1e293b;">No Wallets Found</p>
                                                </td>
                                            </tr>
                                        @endforelse
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                {{-- Payment Modal --}}
                <div class="modal fade" id="paymentModal" tabindex="-1" role="dialog" aria-labelledby="paymentModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content border-0" style="border-radius:12px;box-shadow:0 10px 25px -5px rgba(0,0,0,0.1);">
                            <div class="modal-header" style="border-bottom:1px solid #e2e8f0;background:#f8fafc;border-top-left-radius:12px;border-top-right-radius:12px;">
                                <h6 class="modal-title font-weight-bold" id="paymentModalLabel" style="color:#0f172a;font-size:16px;">Payment Details</h6>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form method="post" class="form" action="{{ route('wallets.money') }}">
                                @csrf
                                <input type="hidden" id="user_id" name="user_id" value=""/>
                                <div class="modal-body" style="padding:20px;">
                                    <div class="form-group">
                                        <label for="mobile_no" style="font-weight:600;color:#334155;font-size:13px;">Recipient Phone Number</label>
                                        <input type="text" class="form-control" id="mobile_no" name="mobile_no" readonly style="background:#f8fafc;">
                                    </div>
                                    <div class="form-group">
                                        <label for="payment_type" style="font-weight:600;color:#334155;font-size:13px;">Payment Type</label>
                                        <select disabled class="custom-select" id="payment_type" name="payment_type" style="background:#f8fafc;">
                                            <option value="Bkash">Bkash</option>
                                            <option value="Nagad">Nagad</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="balance" style="font-weight:600;color:#334155;font-size:13px;">Requested Balance</label>
                                        <input type="number" class="form-control" id="balance" name="balance" readonly style="background:#f8fafc;">
                                    </div>
                                    <div class="form-group mb-0">
                                        <label for="transaction_id" style="font-weight:600;color:#334155;font-size:13px;">Transaction ID <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="transaction_id" name="transaction_id" placeholder="Enter Txn ID" required>
                                    </div>
                                </div>
                                <div class="modal-footer" style="border-top:1px solid #e2e8f0;background:#f8fafc;border-bottom-left-radius:12px;border-bottom-right-radius:12px;">
                                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal" style="border-radius:6px;font-weight:600;">Cancel</button>
                                    <button type="submit" class="btn btn-primary btn-sm" style="background:#6366f1;border:none;border-radius:6px;font-weight:600;padding:7px 18px;">Submit Payment</button>
                                </div>
                            </form>
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

        document.addEventListener("DOMContentLoaded", function () {
            // Handle modal open button click
            document.querySelectorAll('.open-modal').forEach(button => {
                button.addEventListener('click', function (event) {
                    const row = event.target.closest('tr'); // Get the row of the clicked button
                    
                    const mobileNo = row.querySelector('.wallet-mobile').textContent.trim();
                    const userid = row.querySelector('.userID').textContent.trim();
                    const paymentType = row.querySelector('.wallet-payment-type').textContent.trim();
                    const balance = row.querySelector('.wallet-balance').textContent.trim();
                    
                    // Populate modal fields
                    document.getElementById('mobile_no').value = mobileNo;
                    document.getElementById('user_id').value = userid;
                    document.getElementById('payment_type').value = paymentType;
                    document.getElementById('balance').value = balance;
                });
            });
        });
    </script>
@endpush
