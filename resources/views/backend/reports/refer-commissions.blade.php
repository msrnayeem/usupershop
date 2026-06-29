@extends('backend.layouts.master')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        {{-- Page Header --}}
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:22px;flex-wrap:wrap;gap:12px;">
            <div>
                <h1 style="font-size:22px;font-weight:800;color:#0f172a;margin:0;">
                    <i class="fas fa-chart-line" style="color:#6366f1;margin-right:8px;"></i>
                    {{ $pageTitle }}
                </h1>
                <p style="color:#64748b;font-size:13px;margin:2px 0 0;">
                    <a href="{{ route('home') }}" style="color:#6366f1;text-decoration:none;">Home</a>
                    <span style="margin:0 6px;color:#cbd5e1;">/</span>
                    Reports
                    <span style="margin:0 6px;color:#cbd5e1;">/</span>
                    Refer Commissions
                </p>
            </div>
        </div>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="card">
                    <div class="card-header">
                        <span class="card-title">
                            <i class="fas fa-list" style="color:#6366f1;margin-right:6px;"></i>
                            Commission Ledger
                        </span>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="dataTables" class="table table-bordered table-striped nowrap dt-responsive" style="width: 100%">
                                <thead>
                                    <tr>
                                        <th width="8%" class="text-center">SL.</th>
                                        <th>User Recipient</th>
                                        <th>Referred From User</th>
                                        <th>Note / Remarks</th>
                                        <th class="text-right" style="width: 150px;">Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($commissions as $i => $data)
                                        <tr>
                                            <td class="text-center">{{ ++$i }}</td>
                                            <td style="font-weight:700;color:#0f172a;">{{ $data->user->name ?? 'N/A' }}</td>
                                            <td style="font-weight:600;color:#475569;">{{ $data->from_user->name ?? 'N/A' }}</td>
                                            <td style="font-size:13px;color:#64748b;">{{ $data->note }}</td>
                                            <td class="text-right" style="font-weight:700;color:#16a34a;width:150px;">৳{{ number_format($data->credit ?? 0, 2) }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center py-5 text-muted">
                                                <i class="fas fa-gift fa-3x mb-2" style="opacity:0.8;"></i>
                                                <p style="font-weight:600;margin-bottom:0;color:#1e293b;">No Refer Commission Data Found</p>
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

@push('scripts')
    <script>
        $(document).ready(function(){
            $("#dataTables").DataTable({
                responsive: true
            });
        });
    </script>
@endpush
