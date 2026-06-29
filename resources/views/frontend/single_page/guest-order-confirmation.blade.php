@extends('frontend.layouts.master')
@section('title', 'Order Complete | ' . config('app.name'))

@push('meta')
    <meta name="robots" content="noindex, nofollow">
@endpush

@section('content')
    <style>
        .checkout-steps {
            background: #fff;
            padding: 12px 20px;
            display: flex;
            align-items: center;
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            margin-bottom: 15px;
            margin-top: 65px;
            font-family: 'Hind Siliguri', sans-serif;
            justify-content: space-between;
        }
        .checkout-steps .stp { display: flex; align-items: center; gap: 6px; }
        .checkout-steps .sc {
            width: 26px; height: 26px; border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            font-size: 12px; font-weight: 800; flex-shrink: 0;
        }
        .checkout-steps .sc.on  { background: #e8001d; color: #fff; }
        .checkout-steps .sc.off { background: #eee; color: #aaa; }
        .checkout-steps .sc.d   { background: #00a855; color: #fff; }
        .checkout-steps .sl { font-size: 13px; font-weight: 700; }
        .checkout-steps .sl.on  { color: #e8001d; }
        .checkout-steps .sl.off { color: #bbb; }
        .checkout-steps .sl.d   { color: #00a855; }
        .checkout-steps .sl-line { flex: 1; height: 2px; background: #eee; margin: 0 10px; }
        .checkout-steps .sl-line.d { background: #00a855; }

        @media (max-width: 480px) {
            .checkout-steps { padding: 10px; }
            .checkout-steps .sl { display: none; }
            .checkout-steps .stp { gap: 0; }
            .checkout-steps .sl-line { margin: 0 5px; }
        }
        @media (min-width: 400px) and (max-width: 480px) {
            .checkout-steps .sl { display: block; font-size: 11px; }
            .checkout-steps .stp { gap: 4px; }
        }

        .confirmation-card {
            background: #fff;
            border-radius: 14px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.06);
            overflow: hidden;
            border: 1.5px solid #eee;
            margin-bottom: 25px;
            font-family: 'Hind Siliguri', sans-serif;
        }
        .confirmation-header {
            background: linear-gradient(135deg, #00a855 0%, #007a3d 100%);
            color: #fff;
            padding: 24px;
            text-align: center;
        }
        .confirmation-header h2 { margin: 0; font-size: 24px; font-weight: 800; }
        .confirmation-header p { margin: 8px 0 0; font-size: 14px; opacity: 0.9; }
        .confirmation-body { padding: 24px; }
        .grid-info { display: grid; grid-template-columns: repeat(2, 1fr); gap: 15px; margin-bottom: 20px; }
        .grid-item { background: #f8fafc; border-radius: 10px; padding: 12px; border: 1px solid #f1f5f9; }
        .grid-item label { font-size: 12px; color: #64748b; text-transform: uppercase; display: block; margin-bottom: 4px; font-weight: 600; }
        .grid-item span { font-size: 15px; font-weight: 700; color: #0f172a; }
        .btn-action { display: inline-flex; align-items: center; justify-content: center; gap: 8px; font-weight: 700; font-size: 14px; padding: 12px 20px; border-radius: 10px; cursor: pointer; text-decoration: none; transition: transform 0.1s; }
        .btn-action:active { transform: scale(0.98); }
        .btn-track { background: #e8001d; color: #fff; border: none; }
        .btn-track:hover { background: #cc0019; color: #fff; }
        .btn-home { background: #fff; color: #333; border: 1.5px solid #ddd; }
        .btn-home:hover { background: #f5f5f5; color: #333; }
    </style>

    <div class="body-content outer-top-xs">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    
                    <!-- STEP PROGRESS BAR -->
                    <div class="checkout-steps">
                        <div class="stp"><div class="sc d">✓</div><div class="sl d">Cart</div></div>
                        <div class="sl-line d"></div>
                        <div class="stp"><div class="sc d">✓</div><div class="sl d">Checkout</div></div>
                        <div class="sl-line d"></div>
                        <div class="stp"><div class="sc on">3</div><div class="sl on">Done</div></div>
                    </div>

                    <div class="confirmation-card">
                        <div class="confirmation-header">
                            <h2>🎉 Order Placed Successfully</h2>
                            <p>আপনার অর্ডারটি সফলভাবে গ্রহণ করা হয়েছে!</p>
                        </div>
                        <div class="confirmation-body">
                            <div class="grid-info">
                                <div class="grid-item">
                                    <label>Invoice No</label>
                                    <span style="color:#e8001d;">{{ $order->invoice_no }}</span>
                                </div>
                                <div class="grid-item">
                                    <label>Status</label>
                                    <span>{{ ucfirst((string) $order->status) }}</span>
                                </div>
                                <div class="grid-item">
                                    <label>Customer</label>
                                    <span>{{ $order->shipping->name ?? 'Guest Customer' }}</span>
                                </div>
                                <div class="grid-item">
                                    <label>Total</label>
                                    <span style="color:#00a855;">৳{{ number_format((float) $order->grand_total, 0) }}</span>
                                </div>
                            </div>

                            <div style="background: #f8fafc; border-radius: 10px; padding: 15px; border: 1px solid #f1f5f9; margin-bottom: 25px;">
                                <div style="font-weight: 700; font-size: 14px; margin-bottom: 6px; color: #0f172a;">Delivery Information</div>
                                <div style="color: #475569; font-size: 13px; line-height: 1.6;">
                                    <div><strong>Name:</strong> {{ $order->shipping->name ?? 'N/A' }}</div>
                                    <div><strong>Phone:</strong> {{ $order->shipping->mobile ?? 'N/A' }}</div>
                                    <div><strong>Address:</strong> {{ $order->shipping->address ?? 'N/A' }}</div>
                                </div>
                            </div>

                            <div style="display: flex; gap: 12px; flex-wrap: wrap;">
                                <a href="{{ route('order.track') }}?invoice={{ $order->invoice_no }}" class="btn-action btn-track">
                                    🔍 Track Order (অর্ডার ট্র্যাক করুন)
                                </a>
                                <a href="{{ route('frontend.home') }}" class="btn-action btn-home">
                                    🏠 Return to Homepage
                                </a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection