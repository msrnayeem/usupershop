@extends('backend.seller.seller-master')
@section('content')
    <div class="content-wrapper">
        {{-- Page Header --}}
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:22px;flex-wrap:wrap;gap:12px;">
            <div>
                <h1 style="font-size:22px;font-weight:800;color:#0f172a;margin:0;">
                    <i class="fas fa-chart-line" style="color:#6366f1;margin-right:8px;"></i>
                    {{ $pageTitle ?? 'Vendor Sales Report' }}
                </h1>
                <p style="color:#64748b;font-size:13px;margin:2px 0 0;">
                    <a href="{{ route('seller.dashboard') }}" style="color:#6366f1;text-decoration:none;">Dashboard</a>
                    <span style="margin:0 6px;color:#cbd5e1;">/</span>
                    Sales Performance Report
                </p>
            </div>
            <div style="display:flex;gap:8px;flex-wrap:wrap;">
                <a href="{{ route('seller.reports.sales.pdf') }}" class="btn btn-danger btn-sm" style="display:inline-flex;align-items:center;gap:6px;padding:8px 16px;border-radius:8px;font-size:13px;font-weight:600;">
                    <i class="fas fa-file-pdf"></i> Export PDF
                </a>
                <a href="{{ route('seller.reports.sales.excel') }}" class="btn btn-success btn-sm" style="display:inline-flex;align-items:center;gap:6px;padding:8px 16px;border-radius:8px;font-size:13px;font-weight:600;">
                    <i class="fas fa-file-excel"></i> Export Excel
                </a>
            </div>
        </div>

        <section class="content">
            <div class="container-fluid">
                <div class="card">
                    <div class="card-header">
                        <span class="card-title font-weight-bold text-dark"><i class="fas fa-shopping-bag mr-1 text-primary"></i> Sales Revenue by Order</span>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover table-striped mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="text-center" style="width:60px;">SL</th>
                                        <th>Date</th>
                                        <th>Order No</th>
                                        <th>Customer</th>
                                        <th class="text-right" style="width:160px;">Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($data as $i => $value)
                                        <tr>
                                            <td class="text-center" style="font-weight:700;color:#64748b;">{{ ++$i }}</td>
                                            <td style="color:#475569;font-size:13px;">{{ date('d M Y', strtotime($value->entry_date)) }}</td>
                                            <td>
                                                <span class="badge badge-light" style="font-family:monospace;font-size:13px;font-weight:700;border:1px solid #e2e8f0;color:#0f172a;padding:4px 8px;border-radius:4px;">
                                                    #{{ $value->order->order_no ?? 'N/A' }}
                                                </span>
                                            </td>
                                            <td style="font-weight:600;color:#0f172a;">{{ $value->order->users->name ?? 'Unknown' }}</td>
                                            <td class="text-right" style="font-weight:800;color:#6366f1;font-size:14px;">৳{{ number_format($value->credit_balance, 2) }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center text-muted py-4">
                                                <i class="fas fa-inbox" style="font-size:24px;opacity:0.3;display:block;margin-bottom:8px;"></i>
                                                No sales records found.
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
