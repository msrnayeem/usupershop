@extends('backend.seller.seller-master')
@section('content')
    @php
        $myUserType = auth()->user()->usertype; // 'seller' or 'vendor'
        $shopURL    = route('seller.home', ['shopID' => auth()->id()]);
        $refCode    = auth()->user()->refer_code;
        $refURL     = $refCode ? url('/ref/' . $refCode) : null;
        $shopName   = auth()->user()->shop_name ?? auth()->user()->name;
    @endphp

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        {{-- Page Header --}}
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:22px;flex-wrap:wrap;gap:12px;">
            <div>
                <h1 style="font-size:22px;font-weight:800;color:#0f172a;margin:0;">
                    <i class="fas fa-th-large" style="color:#6366f1;margin-right:8px;"></i>
                    Dashboard Overview
                </h1>
                <p style="color:#64748b;font-size:13px;margin:2px 0 0;">
                    Welcome back, {{ auth()->user()->name }}! Here's what's happening with your store.
                </p>
            </div>
        </div>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                
                @if (auth()->user()->payment_status == 1)
                    {{-- Promotion Shop & Share Links --}}
                    <div class="row">
                        {{-- Shop Page Card --}}
                        <div class="col-md-6 mb-4">
                            <div class="card h-100">
                                <div class="card-header d-flex align-items-center" style="background:#f0fdf4; border-bottom:1px solid #dcfce7;">
                                    <span class="card-title font-weight-bold" style="color:#15803d;">
                                        <i class="fas fa-store mr-2"></i>
                                        {{ $myUserType === 'vendor' ? '🏭 My Vendor Shop' : '🏪 My Reseller Store' }}
                                    </span>
                                </div>
                                <div class="card-body">
                                    <p style="font-size:13px;color:#475569;line-height:1.6;margin-bottom:15px;">
                                        Your customer-facing storefront page. Customers purchasing through this link will see products and check out directly under your merchant profile.
                                    </p>

                                    <div class="form-group mb-3">
                                        <label style="font-weight:700;color:#334155;font-size:12px;">🌐 Storefront URL:</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" style="font-family:monospace;font-size:13px;background:#f8fafc;" id="shopPageLink" value="{{ $shopURL }}" readonly onclick="this.select()">
                                            <div class="input-group-append">
                                                <a href="{{ $shopURL }}" target="_blank" class="btn btn-success d-flex align-items-center" style="background:#22c55e;border:none;font-weight:600;gap:6px;border-top-right-radius:0;border-bottom-right-radius:0;">
                                                    <i class="fas fa-eye"></i> View
                                                </a>
                                                <button class="btn btn-primary" onclick="copyLink('shopPageLink','shopMsg')" style="background:#6366f1;border:none;">
                                                    <i class="fas fa-copy"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <small id="shopMsg" class="text-success font-weight-bold mt-1" style="display:none;"><i class="fas fa-check-circle mr-1"></i>Copied to Clipboard!</small>
                                    </div>

                                    {{-- Social Share --}}
                                    <div class="d-flex flex-wrap" style="gap:8px;">
                                        <a target="_blank" class="btn btn-sm btn-outline-success font-weight-bold d-inline-flex align-items-center" style="border-radius:6px;gap:6px;padding:6px 12px;"
                                            href="https://api.whatsapp.com/send?text={{ rawurlencode('🏪 Visit ' . $shopName . ' Storefront on U Super Shop! ' . $shopURL) }}">
                                            <i class="fab fa-whatsapp"></i> WhatsApp
                                        </a>
                                        <a target="_blank" class="btn btn-sm btn-outline-primary font-weight-bold d-inline-flex align-items-center" style="border-radius:6px;gap:6px;padding:6px 12px;"
                                            href="https://www.facebook.com/sharer/sharer.php?u={{ rawurlencode($shopURL) }}">
                                            <i class="fab fa-facebook"></i> Facebook
                                        </a>
                                        <a target="_blank" class="btn btn-sm btn-outline-info font-weight-bold d-inline-flex align-items-center" style="border-radius:6px;gap:6px;padding:6px 12px;"
                                            href="https://t.me/share/url?url={{ rawurlencode($shopURL) }}&text={{ rawurlencode(' Visit ' . $shopName . ' Storefront!') }}">
                                            <i class="fab fa-telegram"></i> Telegram
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Referral Commission Card --}}
                        <div class="col-md-6 mb-4">
                            <div class="card h-100">
                                <div class="card-header d-flex align-items-center" style="background:#eff6ff; border-bottom:1px solid #dbeafe;">
                                    <span class="card-title font-weight-bold" style="color:#1d4ed8;">
                                        <i class="fas fa-percentage mr-2"></i>
                                        Referral System Commission
                                    </span>
                                </div>
                                <div class="card-body">
                                    <p style="font-size:13px;color:#475569;line-height:1.6;margin-bottom:15px;">
                                        Share your partner referral code. Users signing up or completing catalog purchases through your link trigger affiliate balances instantly.
                                    </p>

                                    @if($refURL)
                                        <div class="form-group mb-3">
                                            <label style="font-weight:700;color:#334155;font-size:12px;">🔗 Affiliate Link:</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control" style="font-family:monospace;font-size:13px;background:#f8fafc;" id="siteRefLink" value="{{ $refURL }}" readonly onclick="this.select()">
                                                <div class="input-group-append">
                                                    <button class="btn btn-primary" onclick="copyLink('siteRefLink','refMsg')" style="background:#6366f1;border:none;border-top-right-radius:8px;border-bottom-right-radius:8px;">
                                                        <i class="fas fa-copy"></i> Copy Link
                                                    </button>
                                                </div>
                                            </div>
                                            <small id="refMsg" class="text-success font-weight-bold mt-1" style="display:none;"><i class="fas fa-check-circle mr-1"></i>Copied to Clipboard!</small>
                                        </div>

                                        <div class="d-flex flex-wrap" style="gap:8px;">
                                            <a target="_blank" class="btn btn-sm btn-outline-success font-weight-bold d-inline-flex align-items-center" style="border-radius:6px;gap:6px;padding:6px 12px;"
                                                href="https://api.whatsapp.com/send?text={{ rawurlencode('🛍️ Sign up on U Super Shop using my referral link: ' . $refURL) }}">
                                                <i class="fab fa-whatsapp"></i> WhatsApp
                                            </a>
                                            <a target="_blank" class="btn btn-sm btn-outline-primary font-weight-bold d-inline-flex align-items-center" style="border-radius:6px;gap:6px;padding:6px 12px;"
                                                href="https://www.facebook.com/sharer/sharer.php?u={{ rawurlencode($refURL) }}">
                                                <i class="fab fa-facebook"></i> Facebook
                                            </a>
                                        </div>
                                    @else
                                        <div class="alert alert-warning border-0 mb-0 d-flex align-items-center gap-2" style="font-size:13px;background:#fffbeb;color:#854d0e;border-radius:8px;">
                                            <i class="fas fa-exclamation-triangle"></i> Referral Code not generated. Please contact store support.
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Welcome Message --}}
                    <div class="alert alert-success border-0 mb-4 d-flex align-items-center justify-content-between p-3" style="background:#f0fdf4;color:#15803d;border-radius:12px;">
                        <span style="font-weight:700;"><i class="fas fa-check-circle mr-2"></i>Welcome! You are registered as a <strong>{{ ucfirst($myUserType) }}</strong> on our platform.</span>
                    </div>

                    {{-- Vendor Stats Cards --}}
                    @if (auth()->user()->usertype === 'vendor')
                        <div class="row">
                            {{-- Balance --}}
                            <div class="col-lg-3 col-6 mb-4">
                                <div style="background:#fff;border:1px solid #e2e8f0;border-radius:12px;padding:20px;display:flex;align-items:center;justify-content:space-between;height:100%;">
                                    <div>
                                        <span style="color:#64748b;font-size:12px;font-weight:700;text-transform:uppercase;">Main Balance</span>
                                        <h3 style="font-weight:800;color:#0f172a;margin:5px 0 0;font-size:24px;">৳{{ number_format($data['user_balance'], 2) }}</h3>
                                    </div>
                                    <div style="background:#e0e7ff;color:#6366f1;width:48px;height:48px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:20px;">
                                        <i class="fas fa-wallet"></i>
                                    </div>
                                </div>
                            </div>

                            {{-- Refer Commission --}}
                            <div class="col-lg-3 col-6 mb-4">
                                <div style="background:#fff;border:1px solid #e2e8f0;border-radius:12px;padding:20px;display:flex;align-items:center;justify-content:space-between;height:100%;">
                                    <div>
                                        <span style="color:#64748b;font-size:12px;font-weight:700;text-transform:uppercase;">Refer Commission</span>
                                        <h3 style="font-weight:800;color:#0f172a;margin:5px 0 0;font-size:24px;">৳{{ number_format($data['user_refer_commission'], 2) }}</h3>
                                    </div>
                                    <div style="background:#fef3c7;color:#d97706;width:48px;height:48px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:20px;">
                                        <i class="fas fa-percentage"></i>
                                    </div>
                                </div>
                            </div>

                            {{-- Active Products --}}
                            <div class="col-lg-3 col-6 mb-4">
                                <div style="background:#fff;border:1px solid #e2e8f0;border-radius:12px;padding:20px;display:flex;align-items:center;justify-content:space-between;height:100%;">
                                    <div>
                                        <span style="color:#64748b;font-size:12px;font-weight:700;text-transform:uppercase;">Active Products</span>
                                        <h3 style="font-weight:800;color:#0f172a;margin:5px 0 0;font-size:24px;">{{ $data['active_product_count'] }}</h3>
                                    </div>
                                    <div style="background:#dcfce7;color:#16a34a;width:48px;height:48px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:20px;">
                                        <i class="fas fa-box-open"></i>
                                    </div>
                                </div>
                            </div>

                            {{-- Total Sales --}}
                            <div class="col-lg-3 col-6 mb-4">
                                <div style="background:#fff;border:1px solid #e2e8f0;border-radius:12px;padding:20px;display:flex;align-items:center;justify-content:space-between;height:100%;">
                                    <div>
                                        <span style="color:#64748b;font-size:12px;font-weight:700;text-transform:uppercase;">Total Sales</span>
                                        <h3 style="font-weight:800;color:#0f172a;margin:5px 0 0;font-size:24px;">৳{{ number_format($data['vendor_product_sales_commission'], 2) }}</h3>
                                    </div>
                                    <div style="background:#eff6ff;color:#2563eb;width:48px;height:48px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:20px;">
                                        <i class="fas fa-chart-line"></i>
                                    </div>
                                </div>
                            </div>

                            {{-- Pending Orders --}}
                            <div class="col-lg-3 col-6 mb-4">
                                <div style="background:#fff;border:1px solid #e2e8f0;border-radius:12px;padding:20px;display:flex;align-items:center;justify-content:space-between;height:100%;">
                                    <div>
                                        <span style="color:#64748b;font-size:12px;font-weight:700;text-transform:uppercase;">Pending Orders</span>
                                        <h3 style="font-weight:800;color:#ef4444;margin:5px 0 0;font-size:24px;">{{ $data['pending_order_item_count'] }}</h3>
                                    </div>
                                    <div style="background:#fee2e2;color:#ef4444;width:48px;height:48px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:20px;">
                                        <i class="fas fa-hourglass-start"></i>
                                    </div>
                                </div>
                            </div>

                            {{-- Delivered Orders --}}
                            <div class="col-lg-3 col-6 mb-4">
                                <div style="background:#fff;border:1px solid #e2e8f0;border-radius:12px;padding:20px;display:flex;align-items:center;justify-content:space-between;height:100%;">
                                    <div>
                                        <span style="color:#64748b;font-size:12px;font-weight:700;text-transform:uppercase;">Delivered Orders</span>
                                        <h3 style="font-weight:800;color:#16a34a;margin:5px 0 0;font-size:24px;">{{ $data['delivered_order_item_count'] }}</h3>
                                    </div>
                                    <div style="background:#dcfce7;color:#16a34a;width:48px;height:48px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:20px;">
                                        <i class="fas fa-truck-loading"></i>
                                    </div>
                                </div>
                            </div>

                            {{-- Return Orders --}}
                            <div class="col-lg-3 col-6 mb-4">
                                <div style="background:#fff;border:1px solid #e2e8f0;border-radius:12px;padding:20px;display:flex;align-items:center;justify-content:space-between;height:100%;">
                                    <div>
                                        <span style="color:#64748b;font-size:12px;font-weight:700;text-transform:uppercase;">Returned Orders</span>
                                        <h3 style="font-weight:800;color:#ea580c;margin:5px 0 0;font-size:24px;">{{ $data['return_order_item_count'] }}</h3>
                                    </div>
                                    <div style="background:#ffedd5;color:#ea580c;width:48px;height:48px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:20px;">
                                        <i class="fas fa-undo"></i>
                                    </div>
                                </div>
                            </div>

                            {{-- Cancel Orders --}}
                            <div class="col-lg-3 col-6 mb-4">
                                <div style="background:#fff;border:1px solid #e2e8f0;border-radius:12px;padding:20px;display:flex;align-items:center;justify-content:space-between;height:100%;">
                                    <div>
                                        <span style="color:#64748b;font-size:12px;font-weight:700;text-transform:uppercase;">Cancelled Orders</span>
                                        <h3 style="font-weight:800;color:#64748b;margin:5px 0 0;font-size:24px;">{{ $data['canceled_order_item_count'] }}</h3>
                                    </div>
                                    <div style="background:#f1f5f9;color:#64748b;width:48px;height:48px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:20px;">
                                        <i class="fas fa-times-circle"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    {{-- Reseller / Seller Stats Cards --}}
                    @if (auth()->user()->usertype === 'seller')
                        <div class="row">
                            {{-- Balance --}}
                            <div class="col-lg-3 col-6 mb-4">
                                <div style="background:#fff;border:1px solid #e2e8f0;border-radius:12px;padding:20px;display:flex;align-items:center;justify-content:space-between;height:100%;">
                                    <div>
                                        <span style="color:#64748b;font-size:12px;font-weight:700;text-transform:uppercase;">Main Balance</span>
                                        <h3 style="font-weight:800;color:#0f172a;margin:5px 0 0;font-size:24px;">৳{{ number_format($data['user_balance'], 2) }}</h3>
                                    </div>
                                    <div style="background:#e0e7ff;color:#6366f1;width:48px;height:48px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:20px;">
                                        <i class="fas fa-wallet"></i>
                                    </div>
                                </div>
                            </div>

                            {{-- Refer Commission --}}
                            <div class="col-lg-3 col-6 mb-4">
                                <div style="background:#fff;border:1px solid #e2e8f0;border-radius:12px;padding:20px;display:flex;align-items:center;justify-content:space-between;height:100%;">
                                    <div>
                                        <span style="color:#64748b;font-size:12px;font-weight:700;text-transform:uppercase;">Refer Commission</span>
                                        <h3 style="font-weight:800;color:#0f172a;margin:5px 0 0;font-size:24px;">৳{{ number_format($data['user_refer_commission'], 2) }}</h3>
                                    </div>
                                    <div style="background:#fef3c7;color:#d97706;width:48px;height:48px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:20px;">
                                        <i class="fas fa-percentage"></i>
                                    </div>
                                </div>
                            </div>

                            {{-- Reseller Commission / Sales --}}
                            <div class="col-lg-3 col-6 mb-4">
                                <div style="background:#fff;border:1px solid #e2e8f0;border-radius:12px;padding:20px;display:flex;align-items:center;justify-content:space-between;height:100%;">
                                    <div>
                                        <span style="color:#64748b;font-size:12px;font-weight:700;text-transform:uppercase;">Reseller Commission</span>
                                        <h3 style="font-weight:800;color:#0f172a;margin:5px 0 0;font-size:24px;">৳{{ number_format($data['reseller_sales_commission'], 2) }}</h3>
                                    </div>
                                    <div style="background:#eff6ff;color:#2563eb;width:48px;height:48px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:20px;">
                                        <i class="fas fa-chart-line"></i>
                                    </div>
                                </div>
                            </div>

                            {{-- Pending Orders --}}
                            <div class="col-lg-3 col-6 mb-4">
                                <div style="background:#fff;border:1px solid #e2e8f0;border-radius:12px;padding:20px;display:flex;align-items:center;justify-content:space-between;height:100%;">
                                    <div>
                                        <span style="color:#64748b;font-size:12px;font-weight:700;text-transform:uppercase;">Pending Orders</span>
                                        <h3 style="font-weight:800;color:#ef4444;margin:5px 0 0;font-size:24px;">{{ $data['pending_order_item_count'] }}</h3>
                                    </div>
                                    <div style="background:#fee2e2;color:#ef4444;width:48px;height:48px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:20px;">
                                        <i class="fas fa-hourglass-start"></i>
                                    </div>
                                </div>
                            </div>

                            {{-- Delivered Orders --}}
                            <div class="col-lg-3 col-6 mb-4">
                                <div style="background:#fff;border:1px solid #e2e8f0;border-radius:12px;padding:20px;display:flex;align-items:center;justify-content:space-between;height:100%;">
                                    <div>
                                        <span style="color:#64748b;font-size:12px;font-weight:700;text-transform:uppercase;">Delivered Orders</span>
                                        <h3 style="font-weight:800;color:#16a34a;margin:5px 0 0;font-size:24px;">{{ $data['delivered_order_item_count'] }}</h3>
                                    </div>
                                    <div style="background:#dcfce7;color:#16a34a;width:48px;height:48px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:20px;">
                                        <i class="fas fa-truck-loading"></i>
                                    </div>
                                </div>
                            </div>

                            {{-- Return Orders --}}
                            <div class="col-lg-3 col-6 mb-4">
                                <div style="background:#fff;border:1px solid #e2e8f0;border-radius:12px;padding:20px;display:flex;align-items:center;justify-content:space-between;height:100%;">
                                    <div>
                                        <span style="color:#64748b;font-size:12px;font-weight:700;text-transform:uppercase;">Returned Orders</span>
                                        <h3 style="font-weight:800;color:#ea580c;margin:5px 0 0;font-size:24px;">{{ $data['return_order_item_count'] }}</h3>
                                    </div>
                                    <div style="background:#ffedd5;color:#ea580c;width:48px;height:48px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:20px;">
                                        <i class="fas fa-undo"></i>
                                    </div>
                                </div>
                            </div>

                            {{-- Cancel Orders --}}
                            <div class="col-lg-3 col-6 mb-4">
                                <div style="background:#fff;border:1px solid #e2e8f0;border-radius:12px;padding:20px;display:flex;align-items:center;justify-content:space-between;height:100%;">
                                    <div>
                                        <span style="color:#64748b;font-size:12px;font-weight:700;text-transform:uppercase;">Cancelled Orders</span>
                                        <h3 style="font-weight:800;color:#64748b;margin:5px 0 0;font-size:24px;">{{ $data['canceled_order_item_count'] }}</h3>
                                    </div>
                                    <div style="background:#f1f5f9;color:#64748b;width:48px;height:48px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:20px;">
                                        <i class="fas fa-times-circle"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @endif

                {{-- Inactive Seller Payment Request Form --}}
                @if (auth()->user()->payment_status == 0)
                    <div class="row">
                        <div class="col-md-8 mx-auto">
                            <div class="card">
                                <div class="card-header bg-danger text-white d-flex align-items-center">
                                    <span class="card-title text-white font-weight-bold mb-0">
                                        <i class="fas fa-exclamation-triangle mr-2"></i>
                                        Account Inactive — Subscription Payment Required
                                    </span>
                                </div>
                                <div class="card-body">
                                    @if ($errors->any())
                                        <div class="alert alert-danger border-0" style="border-radius:8px;background:#fef2f2;color:#b91c1c;">
                                            <ul class="mb-0">
                                                @foreach ($errors->all() as $error)
                                                    <li>{{ $error }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif

                                    @if (session()->has('message'))
                                        <div class="alert alert-{{ session('type') }} border-0" style="border-radius:8px;">
                                            {{ session('message') }}
                                        </div>
                                    @endif

                                    <p style="font-size:13.5px;color:#475569;line-height:1.7;margin-bottom:20px;">
                                        To start listing products, managing order consignments, and earning referral commission payouts, choose a package level subscription plan below and settle payment.
                                    </p>

                                    <form action="{{ route('seller.processPayment') }}" method="POST">
                                        @csrf
                                        <div class="form-group mb-3">
                                            <label for="seller_type">Select Package Plan Level <span class="text-danger">*</span></label>
                                            <select name="seller_type" id="seller_type" class="form-control select2" required>
                                                <option value="">Choose your plan...</option>
                                                @foreach ($sellerfees as $fee)
                                                    <option value="{{ $fee->account_type_of_myshop }}">
                                                        {{ $fee->account_type_of_myshop ?? '' }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="form-group mb-4">
                                            <label for="subscription_fee">Plan Activation Fee</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text" style="background:#f1f5f9;font-weight:700;">৳</span>
                                                </div>
                                                <input type="text" name="subscription_fee" class="form-control" id="subscription_fee" value="0" readonly required style="background:#f8fafc;font-weight:700;font-size:18px;color:#0f172a;font-family:monospace;">
                                            </div>
                                        </div>

                                        <div class="form-group mb-0">
                                            <button class="btn btn-success btn-lg btn-block" type="submit" style="background:#22c55e;border:none;padding:12px;font-weight:700;font-size:15px;border-radius:8px;box-shadow:0 4px 6px -1px rgba(34,197,94,0.2);">
                                                <i class="fas fa-credit-card mr-2"></i> Proceed to Secure Payment
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </section>
    </div>

    <script>
        function copyLink(inputId, msgId) {
            var inp = document.getElementById(inputId);
            if (!inp) return;
            inp.select(); inp.setSelectionRange(0, 99999);
            try { document.execCommand('copy'); } catch(e) {
                if (navigator.clipboard) navigator.clipboard.writeText(inp.value);
            }
            if (msgId) {
                var msg = document.getElementById(msgId);
                if (msg) { msg.style.display='inline'; setTimeout(function(){msg.style.display='none';},2000); }
            }
        }
    </script>
@endsection

@section('custom_js')
    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
        });

        $("#seller_type").change(function() {
            const sellerType = $(this).val();
            if (!sellerType) {
                $('#subscription_fee').val(0);
                return;
            }

            $.ajax({
                url: "{{ route('seller.subscriptionfee') }}",
                method: 'GET',
                dataType: 'json',
                data: {
                    seller_type: sellerType,
                },
                success: function(response) {
                    if (response.status === 'success' && response.sellerfees) {
                        const subscriptionFee = response.sellerfees.subscription_fees || 0;
                        $('#subscription_fee').val(subscriptionFee);
                    } else {
                        alert(response.message || 'No plan details found.');
                        $('#subscription_fee').val(0);
                    }
                },
                error: function() {
                    alert('Failed to retrieve subscription fee details.');
                    $('#subscription_fee').val(0);
                },
            });
        });
    </script>
@endsection
