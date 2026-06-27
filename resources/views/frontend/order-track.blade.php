@extends('frontend.layouts.master')
@section('title', 'Order Tracking — ' . ($order->invoice_no ?? 'N/A'))

@section('custom_css')
<style>
@import url('https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@400;500;600;700&display=swap');

.track-page { padding: 30px 0 60px; background: #f6f7fb; min-height: 70vh; }

/* ── Invoice Card ─────────────────────────── */
.invoice-card {
    background: #fff;
    border-radius: 14px;
    box-shadow: 0 2px 16px rgba(0,0,0,.06);
    overflow: hidden;
    margin-bottom: 22px;
}
.invoice-head {
    background: linear-gradient(135deg, #1e25fa 0%, #0d14b3 100%);
    padding: 20px 24px;
    display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 10px;
}
.invoice-head h2 { color: #fff; font-size: 18px; font-weight: 700; margin: 0; }
.invoice-no-badge {
    background: rgba(255,255,255,.18);
    color: #fff; font-size: 16px; font-weight: 700;
    padding: 6px 18px; border-radius: 30px;
    letter-spacing: 1px; font-family: monospace;
}
.invoice-body { padding: 20px 24px; }
.info-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(160px, 1fr)); gap: 16px; }
.info-item label { font-size:13px; color: #999; text-transform: uppercase; letter-spacing: .5px; display: block; margin-bottom: 4px; }
.info-item span { font-size: 14px; color: #222; font-weight: 600; }
.status-pill {
    display: inline-block; padding: 4px 14px; border-radius: 20px;
    font-size:14px; font-weight: 700; text-transform: uppercase; letter-spacing: .5px;
}
.pill-pending    { background: #fff3cd; color: #856404; }
.pill-confirmed  { background: #d1e7dd; color: #0a3622; }
.pill-packaging  { background: #cfe2ff; color: #084298; }
.pill-shipment   { background: #e0cffc; color: #432874; }
.pill-delivered  { background: #d1e7dd; color: #0a3622; }
.pill-canceled   { background: #f8d7da; color: #842029; }
.pill-return     { background: #fff3cd; color: #856404; }

/* ── Timeline ─────────────────────────────── */
.timeline-card {
    background: #fff;
    border-radius: 14px;
    box-shadow: 0 2px 16px rgba(0,0,0,.06);
    padding: 28px 24px 22px;
    margin-bottom: 22px;
}
.timeline-card h3 { font-size: 14px; font-weight: 700; color: #333; margin: 0 0 28px; letter-spacing: .5px; text-transform: uppercase; }

/* Desktop horizontal */
.track-wrap { position: relative; }
.track-line-bg {
    position: absolute; top: 25px; left: 7%; width: 86%;
    height: 5px; background: #e8e8e8; border-radius: 3px; z-index: 1;
}
.track-line-fill {
    position: absolute; top: 25px; left: 7%;
    height: 5px; background: linear-gradient(90deg,#1e25fa,#00c96e); border-radius: 3px; z-index: 2;
    transition: width .6s ease;
}
.track-line-fill.canceled { background: linear-gradient(90deg,#e8001d,#ff6b6b); }

.steps-row { display: flex; justify-content: space-between; position: relative; z-index: 3; }
.step-col { flex: 1; text-align: center; }
.step-circle {
    width: 50px; height: 50px; border-radius: 50%; margin: 0 auto;
    display: flex; align-items: center; justify-content: center;
    font-size: 18px; border: 4px solid #fff;
    box-shadow: 0 0 0 3px #e8e8e8;
    background: #e8e8e8; color: #bbb;
    transition: all .3s;
}
.step-col.done .step-circle  { background: #1e25fa; color: #fff; box-shadow: 0 0 0 3px #c7cafe; }
.step-col.active .step-circle{ background: #00c96e; color: #fff; box-shadow: 0 0 0 4px #c3f0db; animation: stepPulse 1.5s infinite; }
.step-col.canceled .step-circle{ background: #e8001d; color: #fff; box-shadow: 0 0 0 3px #fcd8db; }
@keyframes stepPulse { 0%,100%{box-shadow:0 0 0 4px rgba(0,201,110,.3)} 50%{box-shadow:0 0 0 8px rgba(0,201,110,.1)} }

.step-label { margin-top: 10px; font-size:14px; color: #888; font-weight: 500; }
.step-col.done .step-label,
.step-col.active .step-label { color: #333; font-weight: 600; }
.step-time { font-size:13px; color: #aaa; margin-top: 3px; }
.step-col.done .step-time,
.step-col.active .step-time { color: #888; }

/* Mobile vertical */
@media (max-width: 600px) {
    .track-line-bg  { left: 24px; top: 0; width: 5px; height: 100%; }
    .track-line-fill{ left: 24px; top: 0; width: 5px !important; }
    .steps-row { flex-direction: column; gap: 0; }
    .step-col { display: flex; align-items: flex-start; gap: 14px; text-align: left; padding: 0 0 28px 0; }
    .step-circle { flex-shrink: 0; width: 46px; height: 46px; margin: 0; }
    .step-label { margin-top: 4px; font-size: 13px; }
    .step-time { font-size:13px; }
    .track-line-fill { height: var(--fill-h, 0) !important; }
}

/* Canceled banner */
.canceled-banner {
    background: #fff5f5; border: 1px solid #fcd8da;
    border-radius: 10px; padding: 16px 20px;
    display: flex; align-items: center; gap: 12px;
    color: #842029; font-weight: 600; margin-bottom: 22px;
}
.canceled-banner .icon { font-size: 28px; }

/* ── Order Items ──────────────────────────── */
.items-card {
    background: #fff; border-radius: 14px;
    box-shadow: 0 2px 16px rgba(0,0,0,.06);
    padding: 20px 24px; margin-bottom: 22px;
}
.items-card h3 { font-size: 14px; font-weight: 700; color: #333; margin: 0 0 18px; text-transform: uppercase; letter-spacing: .5px; }
.item-row {
    display: flex; align-items: center; gap: 14px;
    padding: 12px 0; border-bottom: 1px solid #f0f0f0;
}
.item-row:last-child { border-bottom: none; }
.item-img { width: 70px; height: 70px; object-fit: cover; border-radius: 8px; border: 1px solid #eee; flex-shrink: 0; }
.item-info { flex: 1; min-width: 0; }
.item-name { font-size: 14px; font-weight: 600; color: #222; margin-bottom: 4px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
.item-meta { font-size:14px; color: #888; }
.item-qty { font-size: 13px; font-weight: 700; color: #1e25fa; white-space: nowrap; }

/* ── Back btn ─────────────────────────────── */
.back-btn {
    display: inline-flex; align-items: center; gap: 8px;
    background: #1e25fa; color: #fff; padding: 10px 22px;
    border-radius: 30px; text-decoration: none; font-size: 14px; font-weight: 600;
    transition: background .2s;
}
.back-btn:hover { background: #1318c7; color: #fff; }
</style>
@endsection

@section('content')
<div class="track-page">
<div class="container">
<div class="row justify-content-center">
<div class="col-lg-9 col-md-11">

@php
    $statusOrder = ['pending'=>0,'confirmed'=>1,'packaging'=>2,'shipment'=>3,'delivered'=>4,'return'=>5];
    $currentStep = $statusOrder[$order->status] ?? 0;
    $isCanceled  = $order->status === 'canceled';
    $isReturn    = $order->status === 'return';
    $stepCount   = 5; // 0..4 (pending to delivered), return is special
    $percentage  = $isCanceled ? 100 : min(100, ($currentStep / 4) * 100);

    $steps = [
        ['label'=>'Pending',    'bn'=>'অর্ডার হয়েছে',   'icon'=>'🕐', 'ts'=>'created_at'],
        ['label'=>'Confirmed',  'bn'=>'নিশ্চিত হয়েছে',  'icon'=>'✅', 'ts'=>'confirmed_at'],
        ['label'=>'Packaging',  'bn'=>'প্যাকেজিং',       'icon'=>'📦', 'ts'=>'packaging_at'],
        ['label'=>'Shipped',    'bn'=>'পাঠানো হয়েছে',   'icon'=>'🚚', 'ts'=>'shipment_at'],
        ['label'=>'Delivered',  'bn'=>'ডেলিভারি হয়েছে', 'icon'=>'🎉', 'ts'=>'delivered_at'],
    ];

    $pillClass = match($order->status) {
        'pending'   => 'pill-pending',
        'confirmed' => 'pill-confirmed',
        'packaging' => 'pill-packaging',
        'shipment'  => 'pill-shipment',
        'delivered' => 'pill-delivered',
        'canceled'  => 'pill-canceled',
        'return'    => 'pill-return',
        default     => 'pill-pending',
    };
@endphp

{{-- ── Invoice Card ──────────────────────── --}}
<div class="invoice-card">
    <div class="invoice-head">
        <h2>📋 Order Details</h2>
        <div class="invoice-no-badge">{{ $order->invoice_no }}</div>
    </div>
    <div class="invoice-body">
        <div class="info-grid">
            <div class="info-item">
                <label>Invoice No</label>
                <span style="color:#1e25fa; font-family:monospace;">{{ $order->invoice_no }}</span>
            </div>
            <div class="info-item">
                <label>Order Date</label>
                <span>{{ $order->created_at->format('d M Y') }}<br>
                    <small style="font-weight:400;color:#888;">{{ $order->created_at->format('h:i A') }}</small>
                </span>
            </div>
            <div class="info-item">
                <label>Customer</label>
                <span>{{ $order->shipping->name ?? ($order->users->name ?? 'N/A') }}</span>
            </div>
            <div class="info-item">
                <label>Phone</label>
                <span>{{ $order->shipping->mobile ?? 'N/A' }}</span>
            </div>
            <div class="info-item">
                <label>Total</label>
                <span style="color:#00a855; font-size:16px;">৳ {{ number_format($order->grand_total ?? $order->order_total, 0) }}</span>
            </div>
            <div class="info-item">
                <label>Payment</label>
                <span>{{ $order->order_payment ?? 'N/A' }}</span>
            </div>
            <div class="info-item">
                <label>Status</label>
                <span class="status-pill {{ $pillClass }}">{{ ucfirst($order->status) }}</span>
            </div>
            @if($order->shipping && $order->shipping->address)
            <div class="info-item">
                <label>Address</label>
                <span style="font-size:13px;">{{ $order->shipping->address }}</span>
            </div>
            @endif
        </div>
    </div>
</div>

{{-- ── Canceled ───────────────────────────── --}}
@if($isCanceled)
<div class="canceled-banner">
    <div class="icon">🚫</div>
    <div>
        <div>এই অর্ডারটি বাতিল করা হয়েছে</div>
        <div style="font-size:13px; font-weight:400; color:#c0626a; margin-top:2px;">
            This order has been canceled.
            @if($order->canceled_at)
                — {{ \Carbon\Carbon::parse($order->canceled_at)->format('d M Y, h:i A') }}
            @endif
        </div>
    </div>
</div>
@endif

{{-- ── Timeline ───────────────────────────── --}}
<div class="timeline-card">
    <h3>Order Status Timeline</h3>
    <div class="track-wrap">
        @if(!$isCanceled)
        <div class="track-line-bg"></div>
        <div class="track-line-fill {{ $isReturn ? '' : '' }}"
             style="width: {{ $percentage }}%;"
             id="trackFill"></div>
        @endif

        <div class="steps-row" id="stepsRow">
            @foreach($steps as $i => $step)
                @php
                    if ($isCanceled) {
                        $cls = 'canceled';
                    } elseif ($i < $currentStep) {
                        $cls = 'done';
                    } elseif ($i === $currentStep) {
                        $cls = 'active';
                    } else {
                        $cls = '';
                    }
                    $ts = $step['ts'];
                    $time = (!empty($order->$ts)) 
                        ? \Carbon\Carbon::parse($order->$ts)->format('d M, h:i A')
                        : null;
                @endphp
                <div class="step-col {{ $cls }}">
                    <div class="step-circle">{{ $step['icon'] }}</div>
                    <div>
                        <div class="step-label english_lang">{{ $step['label'] }}</div>
                        <div class="step-label bangla_lang" style="display:none">{{ $step['bn'] }}</div>
                        @if($time)
                            <div class="step-time">{{ $time }}</div>
                        @elseif($cls === '')
                            <div class="step-time">—</div>
                        @endif
                    </div>
                </div>
            @endforeach

            @if($isReturn)
                <div class="step-col active">
                    <div class="step-circle">↩️</div>
                    <div>
                        <div class="step-label">Return</div>
                        @if($order->returned_at)
                            <div class="step-time">{{ \Carbon\Carbon::parse($order->returned_at)->format('d M, h:i A') }}</div>
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

{{-- ── Order Items ────────────────────────── --}}
@if($orderItems->count())
<div class="items-card">
    <h3>Products ({{ $orderItems->count() }} item{{ $orderItems->count()>1?'s':'' }})</h3>
    @foreach($orderItems as $item)
    <div class="item-row">
        @if(!empty($item->product->image))
            <img src="{{ url('upload/product_images/'.$item- loading="lazy">product->image) }}"
                 onerror="this.src='{{ asset('frontend/no-image-icon.jpg') }}'"
                 class="item-img" alt="">
        @else
            <img src="{{ asset('frontend/no-image-icon.jpg') }}" class="item-img" alt="">
        @endif
        <div class="item-info">
            <div class="item-name">
                {{ $item->product->name ?? 'Product unavailable' }}
            </div>
            <div class="item-meta">
                @if($item->size_name)  Size: {{ $item->size_name }} &nbsp;@endif
                @if($item->color_name) Color: {{ $item->color_name }} &nbsp;@endif
                Qty: {{ $item->quantity }}
            </div>
            @if($item->sell_price)
            <div style="font-size:13px; color:#00a855; font-weight:600; margin-top:3px;">
                ৳ {{ number_format($item->sell_price, 0) }} × {{ $item->quantity }}
                = ৳ {{ number_format($item->sell_price * $item->quantity, 0) }}
            </div>
            @endif
        </div>
    </div>
    @endforeach
</div>
@endif

{{-- ── Back ───────────────────────────────── --}}
<div>
    <a href="javascript:void(0)" onclick="history.back(); return false;" class="back-btn">
        ← Back
    </a>
    @auth
    <a href="{{ route('dashboard') }}" class="back-btn" style="background:#00a855; margin-left:10px;">
        My Orders
    </a>
    @endauth
</div>

</div>
</div>
</div>
</div>

<script>
// Mobile: set vertical fill height
(function(){
    var fill = document.getElementById('trackFill');
    var rows = document.getElementById('stepsRow');
    if (!fill || !rows) return;
    if (window.innerWidth <= 600) {
        var cols = rows.querySelectorAll('.step-col');
        var done = Array.from(cols).filter(c => c.classList.contains('done') || c.classList.contains('active')).length;
        var total = cols.length;
        var h = total > 1 ? ((done - 1) / (total - 1)) * rows.offsetHeight : 0;
        fill.style.height = Math.max(0, h) + 'px';
        fill.style.width = '5px';
    }
})();
</script>
@endsection
