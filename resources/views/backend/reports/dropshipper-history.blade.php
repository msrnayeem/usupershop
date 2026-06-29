@extends('backend.layouts.master')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        {{-- Page Header --}}
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:22px;flex-wrap:wrap;gap:12px;">
            <div>
                <h1 style="font-size:22px;font-weight:800;color:#0f172a;margin:0;">
                    <i class="fas fa-history" style="color:#6366f1;margin-right:8px;"></i>
                    {{ $pageTitle }}
                </h1>
                <p style="color:#64748b;font-size:13px;margin:2px 0 0;">
                    <a href="{{ route('home') }}" style="color:#6366f1;text-decoration:none;">Home</a>
                    <span style="margin:0 6px;color:#cbd5e1;">/</span>
                    Reports
                    <span style="margin:0 6px;color:#cbd5e1;">/</span>
                    Dropshipper History
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
                            Transaction History Records
                        </span>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="dataTables" class="table table-bordered table-striped nowrap dt-responsive" style="width: 100%">
                                <thead>
                                    <tr>
                                        <th width="6%" class="text-center">SL.</th>
                                        <th>Dropshipper Details</th>
                                        <th>From User</th>
                                        <th style="width: 250px;">Note / Particulars</th>
                                        <th class="text-center">Transaction Type</th>
                                        <th class="text-right">Amount</th>
                                        <th class="text-center">Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($history as $i => $data)
                                        <tr>
                                            <td class="text-center">{{ ++$i }}</td>
                                            <td>
                                                <strong style="color:#0f172a;">{{ $data->user->name ?? 'N/A' }}</strong><br>
                                                <small style="color:#64748b;font-weight:600;"><i class="fas fa-phone-alt mr-1" style="font-size:11px;"></i>{{ $data->user->mobile ?? '' }}</small>
                                            </td>
                                            <td style="font-weight:600;color:#475569;">{{ $data->from_user->name ?? 'N/A' }}</td>
                                            <td style="width: 250px;font-size:13px;color:#475569;white-space:normal;line-height:1.5;">{{ $data->note }}</td>
                                            <td class="text-center">
                                                @php
                                                    $type = 'Unknown';
                                                    foreach(\App\utilities\Constant::TRANSACTION_TYPE as $key => $val){
                                                        if($val == $data->tnx_type){
                                                            $type = str_replace('_', ' ', ucwords($key, '_'));
                                                            break;
                                                        }
                                                    }
                                                @endphp
                                                <span class="badge badge-light" style="padding:5px 10px;border-radius:6px;font-weight:700;border:1px solid #cbd5e1;color:#334155;">{{ $type }}</span>
                                            </td>
                                            <td class="text-right" style="font-weight:800;color:#0f172a;">
                                                ৳{{ number_format($data->credit > 0 ? $data->credit : $data->debit, 2) }}
                                            </td>
                                            <td class="text-center" style="font-size:13px;color:#475569;">{{ $data->created_at->format('d M, Y') }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center py-5 text-muted">
                                                <i class="fas fa-receipt fa-3x mb-2" style="opacity:0.8;"></i>
                                                <p style="font-weight:600;margin-bottom:0;color:#1e293b;">No Dropshipper History Data Found</p>
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
