@extends('backend.layouts.master')
@section('content')
<div class="content-wrapper">
    {{-- Page Header --}}
    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:22px;flex-wrap:wrap;gap:12px;">
        <div>
            <h1 style="font-size:22px;font-weight:800;color:#0f172a;margin:0;">
                <i class="fas fa-sms" style="color:#6366f1;margin-right:8px;"></i>
                SMS Message Templates
            </h1>
            <p style="color:#64748b;font-size:13px;margin:2px 0 0;">
                <a href="{{ route('home') }}" style="color:#6366f1;text-decoration:none;">Home</a>
                <span style="margin:0 6px;color:#cbd5e1;">/</span>
                SMS Templates
            </p>
        </div>
        <a class="btn btn-sm btn-primary" href="{{ route('smsgateways.view') }}" style="display:inline-flex;align-items:center;gap:6px;padding:9px 18px;background:#6366f1;border:none;border-radius:8px;font-size:13px;font-weight:600;color:#fff;text-decoration:none;">
            <i class="fas fa-cog"></i> SMS Gateway Settings
        </a>
    </div>

    <section class="content">
        <div class="container-fluid">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" style="border:none;border-radius:8px;background:#f0fdf4;color:#15803d;margin-bottom:20px;">
                    <i class="fas fa-check-circle mr-1"></i> {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
                </div>
            @endif

            {{-- Variables Reference Card --}}
            <div class="card mb-4">
                <div class="card-header bg-light d-flex align-items-center justify-content-between">
                    <span class="card-title font-weight-bold text-dark mb-0">
                        <i class="fas fa-code mr-2" style="color:#6366f1;"></i>
                        Available System Placeholder Variables
                    </span>
                    <button class="btn btn-xs btn-outline-secondary" data-card-widget="collapse" style="border-radius:6px;padding:3px 8px;"><i class="fas fa-minus"></i></button>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 mb-3 mb-md-0">
                            <h6 class="font-weight-bold text-primary mb-3" style="font-size:14px;"><i class="fas fa-shopping-cart mr-1"></i> Order Events</h6>
                            <table class="table table-sm table-bordered" style="font-size:12px;color:#475569;">
                                <tr><td style="font-family:monospace;font-weight:700;">{name}</td><td>Customer Full Name</td></tr>
                                <tr><td style="font-family:monospace;font-weight:700;">{invoice}</td><td>Invoice Serial No.</td></tr>
                                <tr><td style="font-family:monospace;font-weight:700;">{amount}</td><td>Total Cost</td></tr>
                                <tr><td style="font-family:monospace;font-weight:700;">{delivery_charge}</td><td>Delivery Fee</td></tr>
                                <tr><td style="font-family:monospace;font-weight:700;">{due_amount}</td><td>Cash Due at Doorstep</td></tr>
                                <tr><td style="font-family:monospace;font-weight:700;">{track_link}</td><td>Order Track Link Route</td></tr>
                            </table>
                        </div>
                        <div class="col-md-4 mb-3 mb-md-0">
                            <h6 class="font-weight-bold text-success mb-3" style="font-size:14px;"><i class="fas fa-store mr-1"></i> Member Signups</h6>
                            <table class="table table-sm table-bordered" style="font-size:12px;color:#475569;">
                                <tr><td style="font-family:monospace;font-weight:700;">{name}</td><td>Seller/Vendor Business Name</td></tr>
                                <tr><td style="font-family:monospace;font-weight:700;">{invoice}</td><td>Registration Invoice No.</td></tr>
                                <tr><td style="font-family:monospace;font-weight:700;">{phone}</td><td>Registered Mobile No.</td></tr>
                                <tr><td style="font-family:monospace;font-weight:700;">{password}</td><td>Decoded Setup Password</td></tr>
                                <tr><td style="font-family:monospace;font-weight:700;">{date}</td><td>Creation Date timestamp</td></tr>
                                <tr><td style="font-family:monospace;font-weight:700;">{expire_date}</td><td>Plan Expiration Date</td></tr>
                                <tr><td style="font-family:monospace;font-weight:700;">{package}</td><td>Chosen Subscription Plan</td></tr>
                            </table>
                        </div>
                        <div class="col-md-4">
                            <h6 class="font-weight-bold text-warning mb-3" style="font-size:14px;"><i class="fas fa-wallet mr-1"></i> Wallet & Cashout</h6>
                            <table class="table table-sm table-bordered" style="font-size:12px;color:#475569;">
                                <tr><td style="font-family:monospace;font-weight:700;">{days}</td><td>Remaining Days</td></tr>
                                <tr><td style="font-family:monospace;font-weight:700;">{expire_date}</td><td>Expiration Date</td></tr>
                                <tr><td style="font-family:monospace;font-weight:700;">{amount}</td><td>Requested Payout Sum</td></tr>
                                <tr><td style="font-family:monospace;font-weight:700;">{txn_id}</td><td>Payout Transaction ID</td></tr>
                                <tr><td style="font-family:monospace;font-weight:700;">{method}</td><td>Cashout channel name</td></tr>
                                <tr><td style="font-family:monospace;font-weight:700;">{date}</td><td>Transaction Date</td></tr>
                            </table>
                        </div>
                    </div>
                    <div class="alert alert-warning border-0 mb-0 mt-3" style="font-size:13px;background:#fffbeb;color:#854d0e;border-radius:8px;padding:12px;line-height:1.6;">
                        <i class="fas fa-exclamation-triangle mr-1"></i>
                        <strong>Important:</strong> Character counts dictates cost limits. Keep template lengths short. Dynamic variables are replaced at runtime prior to dispatch.
                    </div>
                </div>
            </div>

            {{-- Templates Form --}}
            <form action="{{ route('sms.templates.update') }}" method="POST">
                @csrf
                @method('PUT')

                @php
                    $templates = [
                        'order' => [
                            ['key' => 'tpl_order_confirmed_cod_free', 'label' => 'Order Confirmed — COD + Free Delivery (≥৳1000)', 'icon' => 'fa-check-circle text-success', 'badge' => 'success', 'badge_text' => 'Order'],
                            ['key' => 'tpl_order_confirmed_cod_paid', 'label' => 'Order Confirmed — COD + Delivery Charge (<৳1000)', 'icon' => 'fa-check-circle text-success', 'badge' => 'success', 'badge_text' => 'Order'],
                            ['key' => 'tpl_order_confirmed_bkash',   'label' => 'Order Confirmed — bKash Full Payment', 'icon' => 'fa-check-circle text-primary', 'badge' => 'primary', 'badge_text' => 'Order'],
                            ['key' => 'tpl_order_processing', 'label' => 'Order Processing / Packaging', 'icon' => 'fa-spinner text-info', 'badge' => 'info', 'badge_text' => 'Order'],
                            ['key' => 'tpl_order_shipped',    'label' => 'Order Shipped — Handed to Courier', 'icon' => 'fa-truck text-purple', 'badge' => 'secondary', 'badge_text' => 'Order'],
                            ['key' => 'tpl_order_delivered',  'label' => 'Order Delivered — Transaction Settled', 'icon' => 'fa-box-open text-success', 'badge' => 'success', 'badge_text' => 'Order'],
                            ['key' => 'tpl_order_cancelled',  'label' => 'Order Cancelled — Rejected', 'icon' => 'fa-times-circle text-danger', 'badge' => 'danger', 'badge_text' => 'Order'],
                            ['key' => 'tpl_order_return',     'label' => 'Order Returned — Package Returned', 'icon' => 'fa-undo text-warning', 'badge' => 'warning', 'badge_text' => 'Order'],
                        ],
                        'member' => [
                            ['key' => 'tpl_welcome_seller',       'label' => 'Welcome — New Seller Activation', 'icon' => 'fa-store text-primary', 'badge' => 'primary', 'badge_text' => 'Member'],
                            ['key' => 'tpl_welcome_vendor',       'label' => 'Welcome — New Vendor Activation', 'icon' => 'fa-industry text-success', 'badge' => 'success', 'badge_text' => 'Member'],
                            ['key' => 'tpl_welcome_dropshipper',  'label' => 'Welcome — New Dropshipper Activation', 'icon' => 'fa-rocket text-danger', 'badge' => 'danger', 'badge_text' => 'Member'],
                            ['key' => 'tpl_subscription_expiry',  'label' => 'Subscription Expiry Notice (30 Days Remaining)', 'icon' => 'fa-bell text-warning', 'badge' => 'warning', 'badge_text' => 'Member'],
                            ['key' => 'tpl_withdrawal_approved',  'label' => 'Withdrawal Approved — Funds Dispatched', 'icon' => 'fa-money-bill-wave text-success', 'badge' => 'success', 'badge_text' => 'Wallet'],
                            ['key' => 'tpl_password_reset',       'label' => 'Password Reset OTP Alerts', 'icon' => 'fa-lock text-danger', 'badge' => 'danger', 'badge_text' => 'Security'],
                        ],
                    ];
                @endphp

                {{-- Order Notifications --}}
                <div class="card mb-4">
                    <div class="card-header bg-primary text-white">
                        <span class="card-title font-weight-bold text-white"><i class="fas fa-shopping-bag mr-2"></i>Order Notifications Templates</span>
                    </div>
                    <div class="card-body p-0">
                        @foreach($templates['order'] as $i => $tpl)
                            <div style="border-bottom:1px solid #e2e8f0;padding:20px 24px;{{ $i % 2 == 0 ? 'background:#fff;' : 'background:#f8fafc;' }}">
                                <div class="d-flex align-items-center mb-2">
                                    <i class="fas {{ $tpl['icon'] }} mr-2"></i>
                                    <strong style="font-size:14px;color:#0f172a;">{{ $tpl['label'] }}</strong>
                                    <span class="badge badge-{{ $tpl['badge'] }} ml-2" style="font-weight:700;border-radius:4px;">{{ $tpl['badge_text'] }}</span>
                                </div>
                                <textarea name="{{ $tpl['key'] }}" rows="5" class="form-control" style="font-family: 'Courier New', monospace; font-size:13px; line-height:1.6; border-radius:8px;" placeholder="Type SMS body here..." required>{{ old($tpl['key'], $smsSettings->{$tpl['key']} ?? '') }}</textarea>
                                <div class="text-muted mt-1" style="font-size:11px;">
                                    <span class="char-count font-weight-bold" id="count_{{ $tpl['key'] }}" style="color:#0f172a;">0</span> characters
                                    | ~<span class="sms-parts font-weight-bold" id="parts_{{ $tpl['key'] }}">1</span> SMS part(s)
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- Member Notifications --}}
                <div class="card mb-4">
                    <div class="card-header bg-success text-white" style="background:#16a34a !important;">
                        <span class="card-title font-weight-bold text-white"><i class="fas fa-users mr-2"></i>Member Status Notifications Templates</span>
                    </div>
                    <div class="card-body p-0">
                        @foreach($templates['member'] as $i => $tpl)
                            <div style="border-bottom:1px solid #e2e8f0;padding:20px 24px;{{ $i % 2 == 0 ? 'background:#fff;' : 'background:#f8fafc;' }}">
                                <div class="d-flex align-items-center mb-2">
                                    <i class="fas {{ $tpl['icon'] }} mr-2"></i>
                                    <strong style="font-size:14px;color:#0f172a;">{{ $tpl['label'] }}</strong>
                                    <span class="badge badge-{{ $tpl['badge'] }} ml-2" style="font-weight:700;border-radius:4px;">{{ $tpl['badge_text'] }}</span>
                                </div>
                                <textarea name="{{ $tpl['key'] }}" rows="5" class="form-control" style="font-family: 'Courier New', monospace; font-size:13px; line-height:1.6; border-radius:8px;" placeholder="Type SMS body here..." required>{{ old($tpl['key'], $smsSettings->{$tpl['key']} ?? '') }}</textarea>
                                <div class="text-muted mt-1" style="font-size:11px;">
                                    <span class="char-count font-weight-bold" id="count_{{ $tpl['key'] }}" style="color:#0f172a;">0</span> characters
                                    | ~<span class="sms-parts font-weight-bold" id="parts_{{ $tpl['key'] }}">1</span> SMS part(s)
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div style="display:flex;gap:12px;margin-bottom:40px;">
                    <button type="submit" class="btn btn-primary" style="background:#6366f1;border:none;padding:12px 30px;border-radius:8px;font-weight:600;box-shadow: 0 4px 6px -1px rgba(99,102,241,0.2);">
                        <i class="fas fa-save mr-2"></i> Save All Message Templates
                    </button>
                    <a href="{{ route('smsgateways.view') }}" class="btn btn-secondary" style="background:#f1f5f9;border:1px solid #cbd5e1;color:#475569;padding:12px 24px;border-radius:8px;font-weight:600;">
                        <i class="fas fa-arrow-left mr-2"></i> Back
                    </a>
                </div>
            </form>
        </div>
    </section>
</div>
@endsection

@push('scripts')
<script>
    document.querySelectorAll('textarea').forEach(function(ta) {
        var key = ta.name;
        var countEl = document.getElementById('count_' + key);
        var partsEl = document.getElementById('parts_' + key);

        function update() {
            var len = ta.value.length;
            if (countEl) countEl.textContent = len;
            if (partsEl) {
                var parts = len <= 160 ? 1 : Math.ceil(len / 153);
                partsEl.textContent = parts;
                partsEl.style.color = parts > 2 ? '#ef4444' : parts > 1 ? '#f97316' : '#22c55e';
            }
        }
        ta.addEventListener('input', update);
        update();
    });
</script>
@endpush
