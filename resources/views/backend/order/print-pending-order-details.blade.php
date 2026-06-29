<!DOCTYPE html>
<html lang="bn">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Invoice {{ $order->invoice_no ?? ('USP' . str_pad($order->id, 5, '0', STR_PAD_LEFT)) }} — U Super Shop</title>
<link href="https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@400;500;600;700;800&display=swap" rel="stylesheet">
<style>
  *{box-sizing:border-box;margin:0;padding:0}
  body{font-family:'Hind Siliguri',Arial,sans-serif;background:#f0f2f5;color:#222;font-size:13px}
  .page{max-width:800px;margin:24px auto;background:#fff;border-radius:12px;overflow:hidden;box-shadow:0 4px 24px rgba(0,0,0,.08)}

  /* Header */
  .inv-header{background:linear-gradient(135deg,#6366f1,#4f46e5);padding:28px 32px;display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:16px}
  .inv-logo{display:flex;align-items:center;gap:14px}
  .inv-logo-box{background:#fff;border-radius:10px;padding:8px 16px;font-size:18px;font-weight:800;color:#6366f1;letter-spacing:.5px;white-space:nowrap}
  .inv-logo-sub{color:rgba(255,255,255,.85);font-size:13px;margin-top:4px}
  .inv-title-box{text-align:right}
  .inv-title-box h1{color:#fff;font-size:22px;font-weight:800;letter-spacing:1px;margin-bottom:4px}
  .inv-no{background:rgba(255,255,255,.2);color:#fff;font-size:13px;font-weight:700;padding:5px 14px;border-radius:20px;display:inline-block}

  /* Body */
  .inv-body{padding:28px 32px}

  /* Info row */
  .info-row{display:grid;grid-template-columns:1fr 1fr 1fr;gap:16px;margin-bottom:24px}
  .info-card{background:#f8fafc;border-radius:10px;padding:14px 16px;border-left:3px solid #6366f1;border:1px solid #e2e8f0;border-left:4px solid #6366f1;}
  .info-card h3{font-size:12px;font-weight:800;color:#6366f1;letter-spacing:1.5px;text-transform:uppercase;margin-bottom:8px}
  .info-card p{font-size:13px;color:#334155;line-height:1.7;margin:0}
  .info-card strong{color:#0f172a;font-weight:700}

  /* Status badge */
  .status-row{display:flex;align-items:center;justify-content:space-between;margin-bottom:20px;flex-wrap:wrap;gap:10px}
  .status-badge{padding:6px 16px;border-radius:20px;font-size:13px;font-weight:800;letter-spacing:.5px;text-transform:uppercase}
  .status-pending{background:#fef3c7;color:#d97706}
  .status-confirmed{background:#d1fae5;color:#059669}
  .status-processing{background:#eff6ff;color:#1d4ed8}
  .status-shipment{background:#f5f3ff;color:#6d28d9}
  .status-delivered{background:#d1fae5;color:#059669}
  .status-canceled{background:#fee2e2;color:#dc2626}
  .status-return{background:#fef3c7;color:#d97706}

  /* Table */
  .prod-table{width:100%;border-collapse:collapse;margin-bottom:0}
  .prod-table th{background:#f8fafc;color:#475569;padding:11px 14px;font-size:12px;font-weight:700;letter-spacing:.8px;text-transform:uppercase;text-align:left;border-bottom:1px solid #e2e8f0}
  .prod-table th:last-child,.prod-table td:last-child{text-align:right}
  .prod-table td{padding:12px 14px;border-bottom:1px solid #f0f0f0;vertical-align:middle;color:#334155;font-size:13px}
  .prod-table tr:nth-child(even) td{background:#fafafa}
  .prod-table tr:last-child td{border-bottom:none}
  .prod-img{width:44px;height:44px;border-radius:8px;object-fit:cover;border:1px solid #e2e8f0;background:#f8f9fa}
  .prod-name-cell{display:flex;align-items:center;gap:12px}
  .prod-name{font-weight:600;color:#0f172a;font-size:13px;margin-bottom:2px}
  .prod-variant{font-size:12px;color:#64748b}
  .table-wrap{border-radius:10px;overflow:hidden;border:1px solid #e2e8f0;margin-bottom:20px}

  /* Totals */
  .totals-row{display:flex;justify-content:flex-end;margin-bottom:24px}
  .totals-box{width:280px;background:#f8fafc;border-radius:10px;overflow:hidden;border:1px solid #e2e8f0}
  .total-line{display:flex;justify-content:space-between;padding:10px 16px;border-bottom:1px solid #e2e8f0;font-size:13px}
  .total-line:last-child{border-bottom:none;background:#6366f1;color:#fff;font-size:15px;font-weight:800}
  .total-line.discount{color:#10b981}
  .total-line.free-del{color:#10b981;font-weight:700}

  /* Footer */
  .inv-footer{background:#0f172a;padding:18px 32px;display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:10px}
  .inv-footer p{color:rgba(255,255,255,.7);font-size:13px}
  .inv-footer strong{color:#fff}
  .thank-you{text-align:center;padding:16px;color:#555;font-size:13px;border-top:1px solid #f0f0f0}

  /* Print */
  @media print{
    body{background:#fff}
    .page{box-shadow:none;border-radius:0;margin:0}
    .no-print{display:none!important}
  }
</style>
</head>
<body>

@php
  $invoice_no = $order->invoice_no ?? ('USP' . str_pad($order->id, 5, '0', STR_PAD_LEFT));
  $orderDate  = $order->created_at ? \Carbon\Carbon::parse($order->created_at)->setTimezone('Asia/Dhaka')->format('d M Y, h:i A') : 'N/A';

  try {
    $invoiceSetting = \App\Models\Setting::first();
    $footerNote  = $invoiceSetting->invoice_footer_note ?? 'পণ্য গ্রহণের সময় ডেলিভারি ম্যানের সামনেই চেক করুন। যেকোনো সমস্যায় WhatsApp করুন: 01816622128';
    $thankYouMsg = $invoiceSetting->invoice_thank_you ?? 'ধন্যবাদ U Super Shop-এ কেনাকাটার জন্য! আপনার সন্তুষ্টিই আমাদের লক্ষ্য।';
  } catch (\Exception $e) {
    $footerNote  = 'পণ্য গ্রহণের সময় ডেলিভারি ম্যানের সামনেই চেক করুন।';
    $thankYouMsg = 'ধন্যবাদ U Super Shop-এ কেনাকাটার জন্য!';
  }

  $statusMap = [
    'pending'    => ['label'=>'Pending ⏳',    'class'=>'status-pending'],
    'confirmed'  => ['label'=>'Confirmed ✅',  'class'=>'status-confirmed'],
    'processing' => ['label'=>'Processing 🔄', 'class'=>'status-processing'],
    'packaging'  => ['label'=>'Packaging 📦',  'class'=>'status-processing'],
    'shipment'   => ['label'=>'Shipped 🚚',    'class'=>'status-shipment'],
    'delivered'  => ['label'=>'Delivered ✅',  'class'=>'status-delivered'],
    'canceled'   => ['label'=>'Cancelled ❌',  'class'=>'status-canceled'],
    'return'     => ['label'=>'Returned ↩️',   'class'=>'status-return'],
  ];
  $statusInfo = $statusMap[$order->status] ?? ['label'=>ucfirst($order->status),'class'=>'status-pending'];

  $orderPayment     = $order->order_payment ?? 'Unpaid';
  $payMethod        = $order->pay_method ?? $order->payment_method ?? 0;
  $isCOD            = ($payMethod == 3 || strtolower($order->payments->payment_method ?? '') === 'cod');
  $isBkash          = ($payMethod == 1 || strtolower($order->payments->payment_method ?? '') === 'bkash');
  $isFreeDelivery   = ((float)($order->delivery_charge ?? 0)) <= 0;
  $isPaid           = in_array($orderPayment, ['Paid', 'Delivery Paid', 'completed']);
  $isDeliveryOnly   = ($orderPayment === 'Delivery Paid');
  $isFullPaid       = ($orderPayment === 'Paid');
  $trnId            = $order->tran_id ?? $order->payments->transaction_no ?? null;

  if ($isCOD && $isFreeDelivery) {
    $payStatusLabel = 'Cash on Delivery (Free Delivery)';
    $payStatusColor = '#0f766e';
    $payStatusBg    = '#ccfbf1';
  } elseif ($isCOD && !$isFreeDelivery && $isDeliveryOnly) {
    $payStatusLabel = 'Delivery Paid | COD Balance Due';
    $payStatusColor = '#b45309';
    $payStatusBg    = '#fef3c7';
  } elseif ($isCOD) {
    $payStatusLabel = 'Cash on Delivery';
    $payStatusColor = '#b45309';
    $payStatusBg    = '#fef3c7';
  } elseif ($isBkash && $isFullPaid) {
    $payStatusLabel = 'bKash — Full Payment';
    $payStatusColor = '#15803d';
    $payStatusBg    = '#d1fae5';
  } elseif ($isBkash && $isDeliveryOnly) {
    $payStatusLabel = 'bKash — Delivery Paid | COD Balance Due';
    $payStatusColor = '#b45309';
    $payStatusBg    = '#fef3c7';
  } elseif ($orderPayment === 'Unpaid') {
    $payStatusLabel = 'Unpaid';
    $payStatusColor = '#b91c1c';
    $payStatusBg    = '#fee2e2';
  } else {
    $payStatusLabel = $orderPayment;
    $payStatusColor = '#1e293b';
    $payStatusBg    = '#f1f5f9';
  }

  $grandTotal     = (float)($order->grand_total ?? $order->order_total ?? 0);
  $deliveryCharge = (float)($order->delivery_charge ?? 0);
  $amountPaid     = $isFullPaid ? $grandTotal : ($isDeliveryOnly ? $deliveryCharge : 0);
  $amountDue      = $isCOD && !$isFreeDelivery && $isDeliveryOnly
    ? ($grandTotal - $deliveryCharge)
    : ($isPaid ? 0 : $grandTotal);

  $subTotal = 0;
  foreach($order->order_details as $d) {
    $subTotal += ($d->sell_price ?? 0) * ($d->quantity ?? 1);
  }
  $discount     = $order->coupon_discount ?? 0;
  $deliveryCharge = $order->delivery_charge ?? 0;
  $grandTotal   = $order->grand_total ?? ($subTotal - $discount + $deliveryCharge);
  $isFreeDelivery = $deliveryCharge <= 0;
@endphp

<div class="page">

  {{-- Print / Download Button --}}
  <div class="no-print" style="padding:14px 32px;background:#fff;border-bottom:1px solid #eee;display:flex;gap:10px;justify-content:flex-end">
    <button onclick="window.print()" style="background:#6366f1;color:#fff;border:none;padding:8px 22px;border-radius:8px;font-size:13px;font-weight:700;cursor:pointer;font-family:'Hind Siliguri',sans-serif">
      🖨️ Print Invoice
    </button>
    <a href="javascript:history.back()" style="background:#f1f5f9;color:#334155;border:none;padding:8px 18px;border-radius:8px;font-size:13px;font-weight:700;cursor:pointer;text-decoration:none">
      ← Back
    </a>
  </div>

  {{-- Header --}}
  <div class="inv-header">
    <div class="inv-logo">
      <div>
        <div class="inv-logo-box">U SUPER SHOP</div>
        <div class="inv-logo-sub">📍 Dhaka, Bangladesh | 📞 01816622128</div>
        <div class="inv-logo-sub">🌐 usuper.shop | ✉️ usupershopbd@gmail.com</div>
      </div>
    </div>
    <div class="inv-title-box">
      <h1>INVOICE</h1>
      <div class="inv-no">{{ $invoice_no }}</div>
      <div style="color:rgba(255,255,255,.8);font-size:13px;margin-top:6px">📅 {{ $orderDate }}</div>
    </div>
  </div>

  <div class="inv-body">

    {{-- Status Row --}}
    <div class="status-row">
      <div>
        <span style="font-size:13px;color:#64748b;font-weight:600">Order Status:</span>
        <span class="status-badge {{ $statusInfo['class'] }}" style="margin-left:8px">{{ $statusInfo['label'] }}</span>
      </div>
      <div>
        <span style="font-size:13px;color:#64748b;font-weight:600">Payment:</span>
        <span style="background:{{ $payStatusBg }};color:{{ $payStatusColor }};font-weight:800;padding:5px 14px;border-radius:20px;font-size:13px;margin-left:8px">
          {{ $payStatusLabel }}
        </span>
      </div>
    </div>

    {{-- Info Cards --}}
    <div class="info-row">

      {{-- Customer / Shipping Info --}}
      <div class="info-card">
        <h3>🛍️ Ship To</h3>
        <p style="margin-top:8px">
          <strong>{{ $order->shipping->name ?? 'N/A' }}</strong><br>
          📱 {{ $order->shipping->mobile ?? 'N/A' }}<br>
          @if($order->shipping->email)
          ✉️ {{ $order->shipping->email }}<br>
          @endif
          📍 {{ $order->shipping->address ?? '' }}
          @if($order->shipping->city) , {{ $order->shipping->city }} @endif
          @if($order->shipping->area) , {{ $order->shipping->area }} @endif
        </p>
      </div>

      {{-- Order Info --}}
      <div class="info-card">
        <h3>📋 Order Info</h3>
        <p style="margin-top:8px">
          <strong>Invoice:</strong> {{ $invoice_no }}<br>
          <strong>Order No:</strong> #{{ $order->order_no }}<br>
          <strong>Date:</strong> {{ $orderDate }}<br>
          @if($order->note)
          <strong>Note:</strong> {{ $order->note }}
          @endif
        </p>
      </div>

      {{-- Payment Info --}}
      <div class="info-card" style="border-left-color:{{ $isPaid ? '#10b981' : '#ef4444' }}">
        <h3>💳 Payment Info</h3>
        <p style="margin-top:8px">
          <strong>Method:</strong>
          @if($isBkash) bKash 💳
          @elseif($isCOD) Cash on Delivery 🚚
          @else {{ $order->payments->payment_method ?? 'N/A' }}
          @endif
          <br>
          <strong>Status:</strong>
          <span style="background:{{ $payStatusBg }};color:{{ $payStatusColor }};font-weight:800;padding:2px 8px;border-radius:6px;font-size:13px">
            {{ $payStatusLabel }}
          </span>
          <br>
          @if($trnId)
          <strong>TXN ID:</strong> <span style="font-family:monospace;color:#4f46e5">{{ $trnId }}</span>
          @endif
          @if($amountPaid > 0)
          <br><strong>Amount Paid:</strong> <span style="color:#10b981;font-weight:800">৳{{ number_format($amountPaid, 0) }}</span>
          @endif
          @if($amountDue > 0)
          <br><strong>Amount Due:</strong> <span style="color:#ef4444;font-weight:800">৳{{ number_format($amountDue, 0) }}</span>
          @if($isCOD) <span style="font-size:12px;color:#64748b">(collect on delivery)</span> @endif
          @endif
          @if($isFreeDelivery)
          <br><span style="color:#10b981;font-weight:700">🎉 Free Delivery Applied</span>
          @endif
        </p>
      </div>
    </div>

    {{-- Products Table --}}
    <div class="table-wrap">
      <table class="prod-table">
        <thead>
          <tr>
            <th>#</th>
            <th>Product</th>
            <th>Variant</th>
            <th>Unit Price</th>
            <th>Qty</th>
            <th>Total</th>
          </tr>
        </thead>
        <tbody>
          @foreach($order->order_details as $i => $d)
          @php
            $price    = $d->sell_price ?? 0;
            $qty      = $d->quantity ?? 1;
            $lineTotal = $price * $qty;
          @endphp
          <tr>
            <td style="color:#94a3b8;font-weight:600">{{ $i + 1 }}</td>
            <td>
              <div class="prod-name-cell">
                @if($d->product && $d->product->image)
                <img class="prod-img"
                  src="{{ url('upload/product_images/' . $d->product->image) }}"
                  alt="{{ $d->product->name }}"
                  onerror="this.style.display='none'">
                @endif
                <div>
                  <div class="prod-name">{{ $d->product->name ?? 'Product Unavailable' }}</div>
                  @if($d->product && $d->product->sku)
                  <div class="prod-variant">SKU: {{ $d->product->sku }}</div>
                  @endif
                </div>
              </div>
            </td>
            <td>
              @if($d->color_name || $d->size_name)
                @if($d->color_name)<span style="background:#f1f5f9;padding:2px 8px;border-radius:4px;font-size:12px;color:#334155;">{{ $d->color_name }}</span>@endif
                @if($d->size_name)<span style="background:#f1f5f9;padding:2px 8px;border-radius:4px;font-size:12px;color:#334155;margin-left:4px">{{ $d->size_name }}</span>@endif
              @else
                <span style="color:#cbd5e1">—</span>
              @endif
            </td>
            <td style="font-weight:600;color:#0f172a;">৳{{ number_format($price, 0) }}</td>
            <td style="text-align:center;font-weight:700;color:#0f172a;">{{ $qty }}</td>
            <td style="font-weight:800;color:#6366f1">৳{{ number_format($lineTotal, 0) }}</td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>

    {{-- Totals --}}
    <div class="totals-row">
      <div class="totals-box">
        <div class="total-line">
          <span>Sub Total</span>
          <span style="font-weight:600;color:#0f172a;">৳{{ number_format($subTotal, 0) }}</span>
        </div>
        @if($discount > 0)
        <div class="total-line discount">
          <span>Coupon Discount</span>
          <span>− ৳{{ number_format($discount, 0) }}</span>
        </div>
        @endif
        <div class="total-line {{ $isFreeDelivery ? 'free-del' : '' }}">
          <span>Delivery Charge</span>
          <span>{{ $isFreeDelivery ? '🎉 FREE' : '৳' . number_format($deliveryCharge, 0) }}</span>
        </div>
        <div class="total-line">
          <span style="font-weight:800;">Grand Total</span>
          <span>৳{{ number_format($grandTotal, 0) }}</span>
        </div>
      </div>
    </div>

    {{-- Notes --}}
    <div style="background:#fffbeb;border:1px solid #fef3c7;border-left:4px solid #f59e0b;border-radius:10px;padding:14px 18px;margin-bottom:24px;font-size:13px;color:#b45309;line-height:1.7">
      <strong>📌 গুরুত্বপূর্ণ নোট:</strong><br>
      • পণ্য গ্রহণের সময় <strong>ডেলিভারি ম্যানের সামনেই</strong> প্যাকেট খুলে চেক করুন।<br>
      {{ $footerNote }}
    </div>

    {{-- Thank you --}}
    <div class="thank-you">
      <div style="font-size:22px;margin-bottom:6px">🙏</div>
      <strong style="font-size:14px;color:#0f172a">{{ $thankYouMsg }}</strong><br>
      <span style="color:#64748b">আপনার সন্তুষ্টিই আমাদের লক্ষ্য। আবার কেনাকাটার জন্য স্বাগতম।</span>
    </div>
  </div>

  {{-- Footer --}}
  <div class="inv-footer">
    <p>🌐 <strong>usuper.shop</strong> &nbsp;|&nbsp; 📞 <strong>01816622128</strong> &nbsp;|&nbsp; ✉️ <strong>usupershopbd@gmail.com</strong></p>
    <p style="font-size:13px">Invoice: <strong>{{ $invoice_no }}</strong></p>
  </div>

</div>

</body>
</html>
