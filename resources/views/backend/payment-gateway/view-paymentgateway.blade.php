@extends('backend.layouts.master')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        {{-- Page Header --}}
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:22px;flex-wrap:wrap;gap:12px;">
            <div>
                <h1 style="font-size:22px;font-weight:800;color:#0f172a;margin:0;">
                    <i class="fas fa-credit-card" style="color:#6366f1;margin-right:8px;"></i>
                    Payment Gateways
                </h1>
                <p style="color:#64748b;font-size:13px;margin:2px 0 0;">
                    <a href="{{ route('home') }}" style="color:#6366f1;text-decoration:none;">Home</a>
                    <span style="margin:0 6px;color:#cbd5e1;">/</span>
                    Payment Gateways Configuration
                </p>
            </div>
            @if ($countpay < 1)
                <a class="btn btn-sm btn-primary" href="{{ route('paymentgatways.add') }}" style="display:inline-flex;align-items:center;gap:6px;padding:9px 18px;background:#6366f1;border:none;border-radius:8px;font-size:13px;font-weight:600;color:#fff;text-decoration:none;">
                    <i class="fas fa-plus-circle"></i> Add Payment Gateway
                </a>
            @endif
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
                            <i class="fas fa-sliders-h" style="color:#6366f1;margin-right:6px;"></i>
                            API Configuration Details
                        </span>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="example1" class="dataTables table table-bordered table-striped nowrap dt-responsive" style="width: 100%">
                                <thead>
                                    <tr>
                                        <th width="6%" class="text-center">SN</th>
                                        <th>Bkash Username</th>
                                        <th>Bkash API Key</th>
                                        <th>Bkash Secret Key</th>
                                        <th>Nagad Username</th>
                                        <th width="12%" class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($allData as $key => $payment)
                                        <tr class="{{ $payment->id }}">
                                            <td class="text-center">{{ $key + 1 }}</td>
                                            <td style="font-weight:600;color:#0f172a;">{{ $payment->BKASH_USERNAME ?? ''}}</td>
                                            <td style="font-family:monospace;font-size:12px;">{{ Str::limit($payment->BKASH_API_KEY ?? '', 20) }}</td>
                                            <td style="font-family:monospace;font-size:12px;">{{ Str::limit($payment->BKASH_SECRET_KEY ?? '', 20) }}</td>
                                            <td style="font-weight:600;color:#0f172a;">{{ $payment->NAGAD_USERNAME ?? ''}}</td>
                                            <td class="text-center">
                                                <a class="btn btn-sm btn-info" href="{{ route('paymentgatways.edit', $payment->id) }}" style="border-radius:6px;padding:5px 12px;font-weight:600;">
                                                    <i class="fas fa-edit mr-1"></i> Edit API Info
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
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
