@extends('backend.seller.seller-master')

@section('title')
    Payment Setting
@endsection

@section('content')
    <div class="content-wrapper">
        {{-- Page Header --}}
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:22px;flex-wrap:wrap;gap:12px;">
            <div>
                <h1 style="font-size:22px;font-weight:800;color:#0f172a;margin:0;">
                    <i class="fas fa-credit-card" style="color:#6366f1;margin-right:8px;"></i>
                    Payment Settings
                </h1>
                <p style="color:#64748b;font-size:13px;margin:2px 0 0;">
                    <a href="{{ route('seller.dashboard') }}" style="color:#6366f1;text-decoration:none;">Dashboard</a>
                    <span style="margin:0 6px;color:#cbd5e1;">/</span>
                    Configure Payment Method
                </p>
            </div>
        </div>

        <section class="content">
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <span class="card-title font-weight-bold text-dark"><i class="fas fa-cog mr-1 text-primary"></i> Configure Withdrawal Method</span>
                            </div>
                            <div class="card-body">
                                @if (session('success'))
                                    <div class="alert alert-success border-0" style="border-radius:10px;">
                                        <i class="fas fa-check-circle mr-1"></i> {{ session('success') }}
                                    </div>
                                @endif

                                <form action="{{ route('manage.wallets.payment.store') }}" method="POST">
                                    @csrf

                                    <div class="form-group">
                                        <label for="method">Payment Method <span class="text-danger">*</span></label>
                                        <select name="method" id="method" class="form-control" required>
                                            <option value="">-- Select Method --</option>
                                            <option value="Bkash" {{ $payment?->method == 'Bkash' ? 'selected' : '' }}>📱 Bkash</option>
                                            <option value="Nagad" {{ $payment?->method == 'Nagad' ? 'selected' : '' }}>💳 Nagad</option>
                                            <option value="Rocket" {{ $payment?->method == 'Rocket' ? 'selected' : '' }}>🚀 Rocket</option>
                                        </select>
                                        @error('method')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <label for="number">Account Number <span class="text-danger">*</span></label>
                                        <input type="text" name="number" id="number" class="form-control"
                                            value="{{ $payment?->number }}" required placeholder="e.g. 017XXXXXXXX">
                                        @error('number')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <button type="submit" class="btn btn-primary" style="background:#6366f1;border:none;border-radius:8px;font-weight:700;padding:10px 28px;">
                                        <i class="fas fa-save mr-1"></i> Save Payment Method
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@section('custom_js')
    <script>
        $('#method').on('change', function() {
            let method = $(this).val();
            if (method === "") { $('#number').val(""); return; }
            $.ajax({
                url: "{{ route('manage.wallets.payment') }}",
                type: "GET",
                data: { method_type: method },
                success: function(res) {
                    $('#number').val(res.data ? res.data.number : "");
                }
            });
        });
    </script>
@endsection
