@extends('backend.seller.seller-master')
@section('content')
    <div class="content-wrapper">
        {{-- Page Header --}}
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:22px;flex-wrap:wrap;gap:12px;">
            <div>
                <h1 style="font-size:22px;font-weight:800;color:#0f172a;margin:0;">
                    <i class="fas fa-users" style="color:#6366f1;margin-right:8px;"></i>
                    {{ $pageTitle ?? 'Refer List' }}
                </h1>
                <p style="color:#64748b;font-size:13px;margin:2px 0 0;">
                    <a href="{{ route('seller.dashboard') }}" style="color:#6366f1;text-decoration:none;">Dashboard</a>
                    <span style="margin:0 6px;color:#cbd5e1;">/</span>
                    Referral Network
                </p>
            </div>
        </div>

        <section class="content">
            <div class="container-fluid">
                <div class="card">
                    <div class="card-header">
                        <span class="card-title font-weight-bold text-dark"><i class="fas fa-share-alt mr-1 text-primary"></i> Users Referred by You</span>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover table-striped mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="text-center" style="width:60px;">SL</th>
                                        <th>Name & Refer ID</th>
                                        <th>Phone</th>
                                        <th class="text-center">User Type</th>
                                        <th class="text-center">Payment Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($data as $i => $value)
                                        <tr>
                                            <td class="text-center" style="font-weight:700;color:#64748b;">{{ ++$i }}</td>
                                            <td>
                                                <div style="font-weight:700;color:#0f172a;">{{ $value->name }}</div>
                                                <div style="font-size:11px;color:#94a3b8;font-family:monospace;">Refer ID: {{ $value->refer_code }}</div>
                                            </td>
                                            <td style="color:#475569;">{{ $value->mobile }}</td>
                                            <td class="text-center">
                                                <span class="badge badge-secondary" style="font-size:12px;border-radius:4px;padding:4px 8px;text-transform:capitalize;">{{ $value->usertype }}</span>
                                            </td>
                                            <td class="text-center">
                                                @if ($value->payment_status == 1)
                                                    <span class="badge badge-success" style="font-size:12px;border-radius:4px;padding:4px 8px;">✓ Paid</span>
                                                @else
                                                    <span class="badge badge-danger" style="font-size:12px;border-radius:4px;padding:4px 8px;">✗ Unpaid</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center text-muted py-4">
                                                <i class="fas fa-inbox" style="font-size:24px;opacity:0.3;display:block;margin-bottom:8px;"></i>
                                                No referred users found.
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
