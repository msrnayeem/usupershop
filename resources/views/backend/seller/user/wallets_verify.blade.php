@extends('backend.seller.seller-master')
@section('content')
    <div class="content-wrapper">
        {{-- Page Header --}}
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:22px;flex-wrap:wrap;gap:12px;">
            <div>
                <h1 style="font-size:22px;font-weight:800;color:#0f172a;margin:0;">
                    <i class="fas fa-shield-alt" style="color:#6366f1;margin-right:8px;"></i>
                    Wallet Verification
                </h1>
                <p style="color:#64748b;font-size:13px;margin:2px 0 0;">
                    <a href="{{ route('seller.dashboard') }}" style="color:#6366f1;text-decoration:none;">Dashboard</a>
                    <span style="margin:0 6px;color:#cbd5e1;">/</span>
                    Verified Wallet Info
                </p>
            </div>
            <div style="display:flex;gap:10px;flex-wrap:wrap;">
                @if (auth()->check() && auth()->user()->balance >= 200)
                    <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#exampleModal" style="display:inline-flex;align-items:center;gap:6px;padding:9px 18px;border-radius:8px;font-size:13px;font-weight:600;">
                        <i class="fas fa-hand-holding-usd"></i> Withdraw Request
                    </button>
                @endif
                <a href="{{ route('transaction.history') }}" class="btn btn-secondary btn-sm" style="display:inline-flex;align-items:center;gap:6px;padding:9px 18px;border-radius:8px;font-size:13px;font-weight:600;text-decoration:none;">
                    <i class="fas fa-history"></i> Transaction History
                </a>
            </div>
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

                @if ($profile != null)
                    <div class="card">
                        <div class="card-header">
                            <span class="card-title font-weight-bold text-dark"><i class="fas fa-id-card mr-1 text-primary"></i> Verified Wallet Information</span>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover table-striped mb-0">
                                    <thead class="bg-light">
                                        <tr>
                                            <th>Account Holder</th>
                                            <th>NID Number</th>
                                            <th>Phone No</th>
                                            <th>NID Front</th>
                                            <th>Payment Type</th>
                                            <th>Status</th>
                                            <th class="text-right">Balance</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td style="font-weight:600;color:#0f172a;">{{ $profile->name ?? '' }}</td>
                                            <td style="font-family:monospace;">{{ $profile->nid_no ?? 'N/A' }}</td>
                                            <td>{{ $profile->mobile_no ?? '' }}</td>
                                            <td>
                                                @if (!empty($profile->front_image))
                                                    <img src="{{ asset('public/upload/profile_verify/' . $profile->front_image) }}" width="60" style="border-radius:6px;border:1px solid #e2e8f0;">
                                                @else
                                                    <span class="text-muted">N/A</span>
                                                @endif
                                            </td>
                                            <td>{{ $profile->payment_type ?? 'N/A' }}</td>
                                            <td>
                                                <span class="badge badge-{{ $profile->transaction_status === 'Completed' ? 'success' : 'secondary' }}" style="font-size:12px;border-radius:4px;padding:4px 8px;">
                                                    {{ $profile->transaction_status ?? 'N/A' }}
                                                </span>
                                            </td>
                                            <td class="text-right" style="font-weight:800;font-size:15px;color:#6366f1;">৳{{ number_format($profile->balance ?? 0, 2) }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </section>
    </div>

    {{-- Withdraw Modal --}}
    @php
        $paymentSetting = \App\Models\PaymentSetting::where('user_id', auth()->id())->get();
    @endphp

    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content" style="border-radius:12px;overflow:hidden;">
                <div class="modal-header" style="background:#f8fafc;border-bottom:1px solid #e2e8f0;">
                    <h5 class="modal-title font-weight-bold text-dark" id="exampleModalLabel">
                        <i class="fas fa-hand-holding-usd mr-2 text-primary"></i> Withdraw Request
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="{{ route('wallet.save') }}">
                        @csrf

                        <div class="form-group">
                            <label for="payment_type">Payment Method</label>
                            <select class="form-control" name="payment_type" id="payment_type">
                                <option value="">Select Payment Type</option>
                                @foreach ($paymentSetting as $ps)
                                    <option value="{{ $ps->method }}" {{ old('payment_type') == $ps->method ? 'selected' : '' }}>
                                        {{ $ps->method }}
                                    </option>
                                @endforeach
                            </select>
                            @error('payment_type')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="mobile_no">Registered Phone Number</label>
                            <input type="text" class="form-control" id="mobile_no" name="mobile_no" placeholder="Auto-filled on selection" readonly>
                            @error('mobile_no')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="amount">Withdrawal Amount <small class="text-muted">(Min: ৳200)</small></label>
                            <input type="number" class="form-control" id="amount" name="amount"
                                step="0.01" placeholder="Enter amount" min="200"
                                max="{{ $profile->balance ?? 0 }}" value="{{ $profile->balance ?? 0 }}">
                            @error('amount')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary btn-block" style="background:#6366f1;border:none;border-radius:8px;font-weight:700;padding:12px;">
                            <i class="fas fa-paper-plane mr-1"></i> Submit Request
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('custom_js')
    <script>
        $('#payment_type').on('change', function() {
            let method = $(this).val();
            if (method === "") { $('#mobile_no').val(""); return; }
            $.ajax({
                url: "{{ route('manage.wallets.payment') }}",
                type: "GET",
                data: { method_type: method },
                success: function(res) {
                    $('#mobile_no').val(res.data ? res.data.number : "");
                }
            });
        });
    </script>
@endsection
