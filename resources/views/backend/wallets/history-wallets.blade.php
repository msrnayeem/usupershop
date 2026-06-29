@extends('backend.layouts.master')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        {{-- Page Header --}}
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:22px;flex-wrap:wrap;gap:12px;">
            <div>
                <h1 style="font-size:22px;font-weight:800;color:#0f172a;margin:0;">
                    <i class="fas fa-history" style="color:#6366f1;margin-right:8px;"></i>
                    Wallets History
                </h1>
                <p style="color:#64748b;font-size:13px;margin:2px 0 0;">
                    <a href="{{ route('home') }}" style="color:#6366f1;text-decoration:none;">Home</a>
                    <span style="margin:0 6px;color:#cbd5e1;">/</span>
                    <a href="{{ route('wallets.view') }}" style="color:#6366f1;text-decoration:none;">Wallets</a>
                    <span style="margin:0 6px;color:#cbd5e1;">/</span>
                    History
                </p>
            </div>
            <a class="btn btn-sm btn-primary" href="{{ route('wallets.view') }}" style="display:inline-flex;align-items:center;gap:6px;padding:9px 18px;background:#6366f1;border:none;border-radius:8px;font-size:13px;font-weight:600;color:#fff;text-decoration:none;">
                <i class="fas fa-wallet"></i> Manage Wallets
            </a>
        </div>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="card">
                    <div class="card-header">
                        <span class="card-title">
                            <i class="fas fa-list" style="color:#6366f1;margin-right:6px;"></i>
                            Transaction Records History
                        </span>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="example1" class="dataTables table table-bordered table-striped nowrap dt-responsive" style="width: 100%">
                                <thead>
                                    <tr>
                                        <th width="6%" class="text-center">SN</th>
                                        <th>User Name</th>
                                        <th>Nid Number</th>
                                        <th>Phone No</th>
                                        <th>Payment Type</th>
                                        <th>Transaction Status</th>
                                        <th>Transaction Date</th>
                                        <th>Transaction Balance</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if($wallets!=null)
                                        @forelse ($wallets as $key=>$wallet)
                                            <tr class="{{ $wallet->id }}">
                                                <td class="text-center">{{ $key + 1 }}</td>
                                                <td style="font-weight:700;color:#0f172a;">{{ $wallet->name ?? ''}}</td>
                                                <td>{{ $wallet->nid_no ?? 'N/A'}}</td>
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
                                                    <span class="badge badge-success" style="padding:5px 10px;border-radius:6px;background:#f0fdf4;color:#16a34a;border:1px solid #bbf7d0;">{{ $wallet->transaction_status ?? 'Paid' }}</span>
                                                </td>
                                                <td class="wallet-date" style="font-size:13px;color:#475569;">{{ $wallet->transaction_date ?? ''}}</td>
                                                <td class="wallet-balance" style="font-weight:700;color:#16a34a;">৳{{ number_format($wallet->transaction_balance ?? 0, 2) }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="8" class="text-center py-5 text-muted">
                                                    <i class="fas fa-history fa-3x mb-2" style="opacity:0.8;"></i>
                                                    <p style="font-weight:600;margin-bottom:0;color:#1e293b;">No Transaction History Found</p>
                                                </td>
                                            </tr>
                                        @endforelse
                                    @endif
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
