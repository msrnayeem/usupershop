@extends('backend.seller.seller-master')
@section('content')
    <div class="content-wrapper">
        {{-- Page Header --}}
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:22px;flex-wrap:wrap;gap:12px;">
            <div>
                <h1 style="font-size:22px;font-weight:800;color:#0f172a;margin:0;">
                    <i class="fas fa-exchange-alt" style="color:#6366f1;margin-right:8px;"></i>
                    Transaction History
                </h1>
                <p style="color:#64748b;font-size:13px;margin:2px 0 0;">
                    <a href="{{ route('seller.dashboard') }}" style="color:#6366f1;text-decoration:none;">Dashboard</a>
                    <span style="margin:0 6px;color:#cbd5e1;">/</span>
                    Transaction Ledger
                </p>
            </div>
            <a href="{{ route('sellers.manage.wallets') }}" class="btn btn-sm btn-secondary" style="display:inline-flex;align-items:center;gap:6px;padding:9px 18px;border-radius:8px;font-size:13px;font-weight:600;text-decoration:none;">
                <i class="fas fa-wallet"></i> Wallet
            </a>
        </div>

        <section class="content">
            <div class="container-fluid">

                @if ($errors->any())
                    <div class="alert alert-danger border-0" style="border-radius:10px;">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if (session()->has('message'))
                    <div class="alert alert-{{ session('type') }} border-0" style="border-radius:10px;">{{ session('message') }}</div>
                @endif

                <div class="card">
                    <div class="card-header">
                        <span class="card-title font-weight-bold text-dark"><i class="fas fa-list-alt mr-1 text-primary"></i> Withdrawal Transaction Records</span>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table id="Tbl" class="table table-hover table-striped mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th>Account Holder</th>
                                        <th>Phone Number</th>
                                        <th>Payment Type</th>
                                        <th class="text-center">Transaction Status</th>
                                        <th class="text-center">Transaction Date</th>
                                        <th class="text-right">Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($transaction != null)
                                        @foreach ($transaction as $txn)
                                            <tr>
                                                <td style="font-weight:600;color:#0f172a;">{{ $txn->name ?? '' }}</td>
                                                <td>{{ $txn->mobile_no ?? '' }}</td>
                                                <td>
                                                    <span class="badge badge-secondary" style="font-size:12px;border-radius:4px;padding:4px 8px;">{{ $txn->payment_type ?? 'N/A' }}</span>
                                                </td>
                                                <td class="text-center">
                                                    @php
                                                        $statusColor = match($txn->transaction_status ?? '') {
                                                            'Completed', 'Success' => 'badge-success',
                                                            'Pending' => 'badge-warning',
                                                            'Failed', 'Rejected' => 'badge-danger',
                                                            default => 'badge-secondary'
                                                        };
                                                    @endphp
                                                    <span class="badge {{ $statusColor }}" style="font-size:12px;border-radius:4px;padding:4px 8px;">
                                                        {{ $txn->transaction_status ?? 'N/A' }}
                                                    </span>
                                                </td>
                                                <td class="text-center" style="font-size:13px;color:#475569;">{{ $txn->transaction_date ?? '' }}</td>
                                                <td class="text-right" style="font-weight:700;color:#0f172a;">৳{{ number_format($txn->transaction_balance ?? 0, 2) }}</td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="6" class="text-center text-muted py-4">No transactions found yet.</td>
                                        </tr>
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
@section('custom_js')
    <script></script>
@endsection
