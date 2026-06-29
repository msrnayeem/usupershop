@extends('backend.layouts.master')

@section('admin_css')
<style>
/* ── Dashboard-specific styles ── */
.dash-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 28px;
    flex-wrap: wrap;
    gap: 12px;
}
.dash-header h1 {
    font-size: 24px;
    font-weight: 800;
    color: #0f172a;
    margin: 0;
}
.dash-header .subtitle {
    font-size: 13px;
    color: var(--text-muted);
    margin-top: 3px;
}

/* KPI Cards */
.kpi-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 16px;
    margin-bottom: 20px;
}
@media (max-width: 1100px) { .kpi-grid { grid-template-columns: repeat(2, 1fr); } }
@media (max-width: 560px)  { .kpi-grid { grid-template-columns: 1fr; } }

.kpi-card {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: var(--radius);
    padding: 20px;
    display: flex;
    align-items: flex-start;
    gap: 16px;
    position: relative;
    overflow: hidden;
    transition: transform 0.2s, border-color 0.2s, box-shadow 0.2s;
    text-decoration: none;
    cursor: default;
}
.kpi-card:hover {
    transform: translateY(-3px);
    border-color: #cbd5e1;
    box-shadow: 0 8px 32px rgba(0,0,0,0.1);
}
.kpi-card::before {
    content: '';
    position: absolute;
    top: 0; left: 0; right: 0;
    height: 3px;
    border-radius: var(--radius) var(--radius) 0 0;
}
.kpi-card.indigo::before { background: linear-gradient(90deg, #6366f1, #8b5cf6); }
.kpi-card.green::before  { background: linear-gradient(90deg, #10b981, #34d399); }
.kpi-card.amber::before  { background: linear-gradient(90deg, #f59e0b, #fcd34d); }
.kpi-card.red::before    { background: linear-gradient(90deg, #ef4444, #f87171); }
.kpi-card.blue::before   { background: linear-gradient(90deg, #3b82f6, #60a5fa); }
.kpi-card.purple::before { background: linear-gradient(90deg, #8b5cf6, #a78bfa); }
.kpi-card.pink::before   { background: linear-gradient(90deg, #ec4899, #f472b6); }
.kpi-card.teal::before   { background: linear-gradient(90deg, #14b8a6, #2dd4bf); }
.kpi-card.orange::before { background: linear-gradient(90deg, #f97316, #fb923c); }
.kpi-card.slate::before  { background: linear-gradient(90deg, #64748b, #94a3b8); }

.kpi-icon {
    width: 48px; height: 48px;
    border-radius: 12px;
    display: flex; align-items: center; justify-content: center;
    font-size: 20px; flex-shrink: 0;
}
.kpi-card.indigo .kpi-icon { background: rgba(99,102,241,0.15);  color: #6366f1; }
.kpi-card.green  .kpi-icon { background: rgba(16,185,129,0.15);  color: #10b981; }
.kpi-card.amber  .kpi-icon { background: rgba(245,158,11,0.15);  color: #f59e0b; }
.kpi-card.red    .kpi-icon { background: rgba(239,68,68,0.15);   color: #ef4444; }
.kpi-card.blue   .kpi-icon { background: rgba(59,130,246,0.15);  color: #3b82f6; }
.kpi-card.purple .kpi-icon { background: rgba(139,92,246,0.15);  color: #8b5cf6; }
.kpi-card.pink   .kpi-icon { background: rgba(236,72,153,0.15);  color: #ec4899; }
.kpi-card.teal   .kpi-icon { background: rgba(20,184,166,0.15);  color: #14b8a6; }
.kpi-card.orange .kpi-icon { background: rgba(249,115,22,0.15);  color: #f97316; }
.kpi-card.slate  .kpi-icon { background: rgba(100,116,139,0.15); color: #64748b; }

.kpi-body { flex: 1; min-width: 0; }
.kpi-label {
    font-size: 12px;
    font-weight: 600;
    color: #64748b;
    text-transform: uppercase;
    letter-spacing: 0.06em;
    margin-bottom: 4px;
}
.kpi-value {
    font-size: 28px;
    font-weight: 800;
    color: #0f172a;
    line-height: 1;
    margin-bottom: 6px;
}
.kpi-link {
    font-size: 11px;
    color: var(--text-muted);
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 4px;
    transition: color 0.15s;
}
.kpi-link:hover { color: var(--accent); }

/* Section heading */
.section-heading {
    font-size: 13px;
    font-weight: 700;
    color: #94a3b8;
    text-transform: uppercase;
    letter-spacing: 0.08em;
    margin: 28px 0 14px;
    display: flex;
    align-items: center;
    gap: 10px;
}
.section-heading::after {
    content: '';
    flex: 1;
    height: 1px;
    background: #e2e8f0;
}

/* Chart card */
.chart-card {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: var(--radius);
    padding: 20px;
    margin-bottom: 20px;
    box-shadow: 0 1px 4px rgba(0,0,0,0.06);
}
.chart-card-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 20px;
    flex-wrap: wrap;
    gap: 12px;
}
.chart-card-title {
    font-size: 15px;
    font-weight: 700;
    color: #0f172a;
}
.chart-card-subtitle {
    font-size: 12px;
    color: var(--text-muted);
    margin-top: 2px;
}

/* WhatsApp Banner */
.wa-banner {
    background: linear-gradient(135deg, #075E54 0%, #128C7E 100%);
    border-radius: var(--radius);
    padding: 18px 22px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 14px;
    margin-bottom: 20px;
    border: 1px solid rgba(255,255,255,0.1);
}
.wa-banner-left { display: flex; align-items: center; gap: 14px; }
.wa-icon {
    width: 46px; height: 46px;
    background: rgba(255,255,255,0.15);
    border-radius: 50%;
    display: flex; align-items: center; justify-content: center;
    font-size: 22px; color: #fff; flex-shrink: 0;
}
.wa-title { font-weight: 700; font-size: 15px; color: #fff; }
.wa-status { font-size: 13px; color: rgba(255,255,255,0.85); margin-top: 2px; }
.wa-desc  { font-size: 12px; color: rgba(255,255,255,0.65); margin-top: 2px; }
.wa-actions { display: flex; gap: 8px; flex-wrap: wrap; }
.wa-btn {
    background: rgba(255,255,255,0.2);
    color: #fff; padding: 8px 18px;
    border-radius: 40px;
    text-decoration: none;
    font-size: 13px; font-weight: 600;
    border: 1px solid rgba(255,255,255,0.3);
    transition: background 0.15s;
    display: inline-flex; align-items: center; gap: 6px;
}
.wa-btn:hover { background: rgba(255,255,255,0.3); color: #fff; }
.wa-btn-test { background: #25D366; border-color: #25D366; }
.wa-btn-test:hover { background: #1da851; }
</style>
@endsection

@section('content')
{{-- ── Dashboard Header ── --}}
<div class="dash-header">
    <div>
        <h1>Dashboard</h1>
        <div class="subtitle">Welcome back, {{ Auth::user()->name }} — here's what's happening today.</div>
    </div>
    <div style="display:flex;gap:10px;align-items:center;">
        <span style="font-size:12px;color:var(--text-muted);">
            <i class="fas fa-clock"></i> {{ now()->format('D, d M Y') }}
        </span>
        <a href="{{ url('/') }}" target="_blank" class="btn btn-outline-primary btn-sm">
            <i class="fas fa-external-link-alt"></i> View Store
        </a>
    </div>
</div>

{{-- ══════════════════════════════════════════════════
     SECTION 1 — Core KPIs
══════════════════════════════════════════════════ --}}
<div class="section-heading"><i class="fas fa-tachometer-alt"></i> Overview</div>
<div class="kpi-grid">

    <div class="kpi-card indigo">
        <div class="kpi-icon"><i class="fas fa-shopping-bag"></i></div>
        <div class="kpi-body">
            <div class="kpi-label">Total Orders</div>
            <div class="kpi-value">{{ number_format($orders ?? 0) }}</div>
            <a href="{{ route('orders.all.list') }}" class="kpi-link">View all <i class="fas fa-arrow-right"></i></a>
        </div>
    </div>

    <div class="kpi-card green">
        <div class="kpi-icon"><i class="fas fa-users"></i></div>
        <div class="kpi-body">
            <div class="kpi-label">Total Customers</div>
            <div class="kpi-value">{{ number_format($customers ?? 0) }}</div>
            <a href="{{ route('customers.view') }}" class="kpi-link">View all <i class="fas fa-arrow-right"></i></a>
        </div>
    </div>

    <div class="kpi-card amber">
        <div class="kpi-icon"><i class="fas fa-store-alt"></i></div>
        <div class="kpi-body">
            <div class="kpi-label">Total Sellers</div>
            <div class="kpi-value">{{ number_format($sellers ?? 0) }}</div>
            <a href="{{ route('sellers.view') }}?active" class="kpi-link">View all <i class="fas fa-arrow-right"></i></a>
        </div>
    </div>

    <div class="kpi-card blue">
        <div class="kpi-icon"><i class="fas fa-box-open"></i></div>
        <div class="kpi-body">
            <div class="kpi-label">Total Products</div>
            <div class="kpi-value">{{ number_format($products ?? 0) }}</div>
            <a href="{{ route('products.view') }}" class="kpi-link">View all <i class="fas fa-arrow-right"></i></a>
        </div>
    </div>

</div>

{{-- ══════════════════════════════════════════════════
     SECTION 2 — Order Status
══════════════════════════════════════════════════ --}}
<div class="section-heading"><i class="fas fa-shopping-cart"></i> Order Status</div>
<div class="kpi-grid" style="grid-template-columns: repeat(5,1fr);">

    <div class="kpi-card amber">
        <div class="kpi-icon" style="width:40px;height:40px;font-size:16px;"><i class="fas fa-clock"></i></div>
        <div class="kpi-body">
            <div class="kpi-label">Pending</div>
            <div class="kpi-value" style="font-size:22px;">{{ number_format($pending_order ?? 0) }}</div>
            <a href="{{ route('orders.pending.list') }}" class="kpi-link">View <i class="fas fa-arrow-right"></i></a>
        </div>
    </div>

    <div class="kpi-card indigo">
        <div class="kpi-icon" style="width:40px;height:40px;font-size:16px;"><i class="fas fa-check-circle"></i></div>
        <div class="kpi-body">
            <div class="kpi-label">Confirmed</div>
            <div class="kpi-value" style="font-size:22px;">{{ number_format($confirmed_order ?? 0) }}</div>
            <a href="{{ route('orders.all.list') }}" class="kpi-link">View <i class="fas fa-arrow-right"></i></a>
        </div>
    </div>

    <div class="kpi-card green">
        <div class="kpi-icon" style="width:40px;height:40px;font-size:16px;"><i class="fas fa-truck"></i></div>
        <div class="kpi-body">
            <div class="kpi-label">Delivered</div>
            <div class="kpi-value" style="font-size:22px;">{{ number_format($delivered_order ?? 0) }}</div>
            <a href="{{ route('orders.delivered.list') }}" class="kpi-link">View <i class="fas fa-arrow-right"></i></a>
        </div>
    </div>

    <div class="kpi-card blue">
        <div class="kpi-icon" style="width:40px;height:40px;font-size:16px;"><i class="fas fa-undo"></i></div>
        <div class="kpi-body">
            <div class="kpi-label">Returned</div>
            <div class="kpi-value" style="font-size:22px;">{{ number_format($return_order ?? 0) }}</div>
            <a href="{{ route('orders.return.list') }}" class="kpi-link">View <i class="fas fa-arrow-right"></i></a>
        </div>
    </div>

    <div class="kpi-card red">
        <div class="kpi-icon" style="width:40px;height:40px;font-size:16px;"><i class="fas fa-times-circle"></i></div>
        <div class="kpi-body">
            <div class="kpi-label">Cancelled</div>
            <div class="kpi-value" style="font-size:22px;">{{ number_format($cancel_order ?? 0) }}</div>
            <a href="{{ route('orders.canceled.list') }}" class="kpi-link">View <i class="fas fa-arrow-right"></i></a>
        </div>
    </div>

</div>

{{-- ══════════════════════════════════════════════════
     SECTION 3 — Products & Inventory
══════════════════════════════════════════════════ --}}
<div class="section-heading"><i class="fas fa-boxes"></i> Inventory</div>
<div class="kpi-grid" style="grid-template-columns: repeat(4,1fr);">

    <div class="kpi-card amber">
        <div class="kpi-icon" style="width:40px;height:40px;font-size:16px;"><i class="fas fa-hourglass-half"></i></div>
        <div class="kpi-body">
            <div class="kpi-label">Pending Products</div>
            <div class="kpi-value" style="font-size:22px;">{{ number_format($pending_products ?? 0) }}</div>
            <a href="{{ route('products.pending.view') }}" class="kpi-link">Review <i class="fas fa-arrow-right"></i></a>
        </div>
    </div>

    <div class="kpi-card slate">
        <div class="kpi-icon" style="width:40px;height:40px;font-size:16px;"><i class="fas fa-eye-slash"></i></div>
        <div class="kpi-body">
            <div class="kpi-label">Inactive Products</div>
            <div class="kpi-value" style="font-size:22px;">{{ number_format($inactive_products ?? 0) }}</div>
            <a href="{{ route('products.inactive.view') }}" class="kpi-link">View <i class="fas fa-arrow-right"></i></a>
        </div>
    </div>

    <div class="kpi-card red">
        <div class="kpi-icon" style="width:40px;height:40px;font-size:16px;"><i class="fas fa-exclamation-triangle"></i></div>
        <div class="kpi-body">
            <div class="kpi-label">Stock Out</div>
            <div class="kpi-value" style="font-size:22px;">{{ number_format($stock_out_count ?? 0) }}</div>
            <a href="{{ route('products.stockout.view') }}" class="kpi-link">View <i class="fas fa-arrow-right"></i></a>
        </div>
    </div>

    <div class="kpi-card orange">
        <div class="kpi-icon" style="width:40px;height:40px;font-size:16px;"><i class="fas fa-layer-group"></i></div>
        <div class="kpi-body">
            <div class="kpi-label">Low Stock</div>
            <div class="kpi-value" style="font-size:22px;">{{ number_format($low_stock_count ?? 0) }}</div>
            <a href="{{ route('products.lowstock.view') }}" class="kpi-link">View <i class="fas fa-arrow-right"></i></a>
        </div>
    </div>

</div>

{{-- ══════════════════════════════════════════════════
     SECTION 4 — Finance / Payments
══════════════════════════════════════════════════ --}}
<div class="section-heading"><i class="fas fa-coins"></i> Finance</div>
<div class="kpi-grid">

    <div class="kpi-card green">
        <div class="kpi-icon"><i class="fas fa-store-alt"></i></div>
        <div class="kpi-body">
            <div class="kpi-label">Sellers Paid</div>
            <div class="kpi-value">{{ number_format($paid_sellers ?? 0) }}</div>
            <a href="{{ route('sellers.view') }}?paid" class="kpi-link">View <i class="fas fa-arrow-right"></i></a>
        </div>
    </div>

    <div class="kpi-card red">
        <div class="kpi-icon"><i class="fas fa-store-alt"></i></div>
        <div class="kpi-body">
            <div class="kpi-label">Sellers Unpaid</div>
            <div class="kpi-value">{{ number_format($unPaid_sellers ?? 0) }}</div>
            <a href="{{ route('sellers.view') }}?unpaid" class="kpi-link">View <i class="fas fa-arrow-right"></i></a>
        </div>
    </div>

    <div class="kpi-card teal">
        <div class="kpi-icon"><i class="fas fa-building"></i></div>
        <div class="kpi-body">
            <div class="kpi-label">Vendors Paid</div>
            <div class="kpi-value">{{ number_format($paid_vendor ?? 0) }}</div>
            <a href="{{ route('vendors.view') }}?paid" class="kpi-link">View <i class="fas fa-arrow-right"></i></a>
        </div>
    </div>

    <div class="kpi-card pink">
        <div class="kpi-icon"><i class="fas fa-building"></i></div>
        <div class="kpi-body">
            <div class="kpi-label">Vendors Unpaid</div>
            <div class="kpi-value">{{ number_format($upPaid_vendor ?? 0) }}</div>
            <a href="{{ route('vendors.draft.view') }}?unpaid" class="kpi-link">View <i class="fas fa-arrow-right"></i></a>
        </div>
    </div>

</div>

{{-- ══════════════════════════════════════════════════
     SECTION 5 — Other Metrics
══════════════════════════════════════════════════ --}}
<div class="section-heading"><i class="fas fa-chart-pie"></i> Metrics</div>
<div class="kpi-grid">

    <div class="kpi-card indigo">
        <div class="kpi-icon"><i class="fas fa-user-check"></i></div>
        <div class="kpi-body">
            <div class="kpi-label">Verified Profiles</div>
            <div class="kpi-value">{{ number_format($is_profile_verify ?? 0) }}</div>
        </div>
    </div>

    <div class="kpi-card green">
        <div class="kpi-icon"><i class="fas fa-wallet"></i></div>
        <div class="kpi-body">
            <div class="kpi-label">Total User Balance</div>
            <div class="kpi-value" style="font-size:20px;">৳{{ number_format($user_total_balance ?? 0, 2) }}</div>
        </div>
    </div>

    <div class="kpi-card purple">
        <div class="kpi-icon"><i class="fas fa-share-alt"></i></div>
        <div class="kpi-body">
            <div class="kpi-label">Refer Codes</div>
            <div class="kpi-value">{{ number_format($total_reffer ?? 0) }}</div>
        </div>
    </div>

    <div class="kpi-card amber">
        <div class="kpi-icon"><i class="fas fa-money-check-alt"></i></div>
        <div class="kpi-body">
            <div class="kpi-label">Withdraw Requests</div>
            <div class="kpi-value">{{ number_format($total_withdraw_request ?? 0) }}</div>
            <a href="{{ route('wallets.view') }}" class="kpi-link">View <i class="fas fa-arrow-right"></i></a>
        </div>
    </div>

</div>

{{-- ══════════════════════════════════════════════════
     SECTION 6 — Chart
══════════════════════════════════════════════════ --}}
<div class="section-heading"><i class="fas fa-chart-line"></i> Analytics</div>
<div class="chart-card">
    <div class="chart-card-header">
        <div>
            <div class="chart-card-title">Order Trend — Last 14 Days</div>
            <div class="chart-card-subtitle">Daily order count</div>
        </div>
        <div style="display:flex;align-items:center;gap:8px;">
            <span style="width:10px;height:10px;background:#6366f1;border-radius:50%;display:inline-block;"></span>
            <span style="font-size:12px;color:var(--text-muted);">Orders</span>
        </div>
    </div>
    <canvas id="orderTrendChart" height="90"></canvas>
</div>

{{-- ══════════════════════════════════════════════════
     SECTION 7 — WhatsApp Banner
══════════════════════════════════════════════════ --}}
@php $waSetting = \App\Models\Setting::first(); @endphp
<div class="wa-banner">
    <div class="wa-banner-left">
        <div class="wa-icon"><i class="fab fa-whatsapp"></i></div>
        <div>
            <div class="wa-title">WhatsApp Notifications</div>
            @if(!empty($waSetting->whatsapp_notify_number))
                <div class="wa-status">✅ Active — <strong>{{ $waSetting->whatsapp_notify_number }}</strong></div>
                <div class="wa-desc">নতুন order ও member payment-এ এই নম্বরে WhatsApp message আসবে</div>
            @else
                <div class="wa-status" style="color:#FFD700;">⚠️ WhatsApp number সেট করা নেই</div>
                <div class="wa-desc">Settings থেকে number যোগ করুন</div>
            @endif
        </div>
    </div>
    <div class="wa-actions">
        <a href="{{ route('settings.view') }}" class="wa-btn">
            <i class="fas fa-cog"></i> {{ empty($waSetting->whatsapp_notify_number) ? 'Number যোগ করুন' : 'Settings' }}
        </a>
        @if(!empty($waSetting->whatsapp_notify_number))
        <a href="{{ route('whatsapp.test') }}" class="wa-btn wa-btn-test"
           onclick="return confirm('Test WhatsApp message পাঠাবেন?')">
            <i class="fab fa-whatsapp"></i> Test করুন
        </a>
        @endif
    </div>
</div>

@endsection

@section('custom_js')
<script>
$(document).ready(function () {

    /* ── Order Trend Chart (Last 14 days) ── */
    var ctx = document.getElementById('orderTrendChart');
    if (!ctx) return;

    // Generate last 14 day labels
    var labels = [];
    var today  = new Date();
    for (var i = 13; i >= 0; i--) {
        var d = new Date(today);
        d.setDate(today.getDate() - i);
        labels.push(d.toLocaleDateString('en-GB', { day: 'numeric', month: 'short' }));
    }

    // PHP-injected data or fallback zeros
    var orderData = @json($orderTrend ?? array_fill(0, 14, 0));

    new Chart(ctx.getContext('2d'), {
        type: 'line',
        data: {
            labels: labels,
            datasets: [{
                label: 'Orders',
                data: orderData,
                borderColor: '#6366f1',
                backgroundColor: 'rgba(99,102,241,0.07)',
                borderWidth: 2.5,
                pointBackgroundColor: '#6366f1',
                pointRadius: 4,
                pointHoverRadius: 6,
                tension: 0.4,
                fill: true,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: 'rgba(15,23,42,0.92)',
                    borderColor: '#e2e8f0',
                    borderWidth: 1,
                    titleColor: '#f1f5f9',
                    bodyColor: '#94a3b8',
                    padding: 12,
                    cornerRadius: 8,
                }
            },
            scales: {
                x: {
                    grid: { color: '#f1f5f9' },
                    ticks: { color: '#94a3b8', font: { size: 11 } },
                },
                y: {
                    grid: { color: '#f1f5f9' },
                    ticks: {
                        color: '#94a3b8',
                        font: { size: 11 },
                        stepSize: 1,
                        callback: function(v) { return v >= 0 ? v : ''; }
                    },
                    beginAtZero: true,
                    min: 0,
                }
            }
        }
    });

});
</script>
@endsection
