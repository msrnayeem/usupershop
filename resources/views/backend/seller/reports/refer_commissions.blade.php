@extends('backend.seller.seller-master')
@section('content')
    <div class="content-wrapper">
        {{-- Page Header --}}
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:22px;flex-wrap:wrap;gap:12px;">
            <div>
                <h1 style="font-size:22px;font-weight:800;color:#0f172a;margin:0;">
                    <i class="fas fa-chart-pie" style="color:#6366f1;margin-right:8px;"></i>
                    {{ $pageTitle ?? 'Refer Commissions' }}
                </h1>
                <p style="color:#64748b;font-size:13px;margin:2px 0 0;">
                    <a href="{{ route('seller.dashboard') }}" style="color:#6366f1;text-decoration:none;">Dashboard</a>
                    <span style="margin:0 6px;color:#cbd5e1;">/</span>
                    Referral Commission Report
                </p>
            </div>
            <div style="display:flex;gap:8px;flex-wrap:wrap;">
                <a href="{{ route('seller.reports.refer.pdf') }}" class="btn btn-danger btn-sm" style="display:inline-flex;align-items:center;gap:6px;padding:8px 16px;border-radius:8px;font-size:13px;font-weight:600;">
                    <i class="fas fa-file-pdf"></i> Export PDF
                </a>
                <a href="{{ route('seller.reports.refer.excel') }}" class="btn btn-success btn-sm" style="display:inline-flex;align-items:center;gap:6px;padding:8px 16px;border-radius:8px;font-size:13px;font-weight:600;">
                    <i class="fas fa-file-excel"></i> Export Excel
                </a>
            </div>
        </div>

        <section class="content">
            <div class="container-fluid">
                <div class="card">
                    <div class="card-header">
                        <span class="card-title font-weight-bold text-dark"><i class="fas fa-share-alt mr-1 text-primary"></i> Commission Earnings from Referrals</span>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover table-striped mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="text-center" style="width:60px;">SL</th>
                                        <th>Referred By</th>
                                        <th>Description / Note</th>
                                        <th class="text-right" style="width:160px;">Commission Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($data as $i => $value)
                                        <tr>
                                            <td class="text-center" style="font-weight:700;color:#64748b;">{{ ++$i }}</td>
                                            <td style="font-weight:600;color:#0f172a;">{{ $value->from_user->name }}</td>
                                            <td style="color:#475569;">{{ $value->note }}</td>
                                            <td class="text-right" style="font-weight:800;color:#22c55e;font-size:14px;">৳{{ number_format($value->credit, 2) }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center text-muted py-4">
                                                <i class="fas fa-inbox" style="font-size:24px;opacity:0.3;display:block;margin-bottom:8px;"></i>
                                                No referral commissions found.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
