@extends('backend.layouts.master')
@section('content')
    <div class="content-wrapper">
        {{-- Page Header --}}
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:22px;flex-wrap:wrap;gap:12px;">
            <div>
                <h1 style="font-size:22px;font-weight:800;color:#0f172a;margin:0;">
                    <i class="fas fa-file-invoice" style="color:#6366f1;margin-right:8px;"></i>Order Details
                </h1>
                <p style="color:#64748b;font-size:13px;margin:2px 0 0;">
                    <a href="{{ route('home') }}" style="color:#6366f1;text-decoration:none;">Home</a>
                    <span style="margin:0 6px;color:#cbd5e1;">/</span>
                    <a href="{{ route('orders.deliver.list') }}" style="color:#6366f1;text-decoration:none;">Delivered Orders</a>
                    <span style="margin:0 6px;color:#cbd5e1;">/</span>Order Details
                </p>
            </div>
            <div style="display:flex;gap:10px;">
                <a href="{{ route('orders.deliver.list') }}"
                    style="display:inline-flex;align-items:center;gap:6px;padding:9px 18px;background:#6366f1;border:none;border-radius:8px;font-size:13px;font-weight:600;color:#fff;text-decoration:none;">
                    <i class="fas fa-list"></i> Order Delivered List
                </a>
            </div>
        </div>

        @php
            $footercontent = Helper::getfootercontacts();
        @endphp

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                {{-- Order Info Cards --}}
                <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));gap:16px;margin-bottom:20px;">
                    <div style="background:#fff;border:1px solid #e2e8f0;border-radius:12px;padding:16px 20px;border-left:4px solid #6366f1;">
                        <p style="font-size:11px;font-weight:700;color:#94a3b8;text-transform:uppercase;letter-spacing:.06em;margin:0 0 4px;">Order No</p>
                        <p style="font-size:16px;font-weight:800;color:#0f172a;margin:0;">ODR-#{{ $order->order_no }}</p>
                        @if(!empty($order->shop_id))<p style="font-size:12px;color:#64748b;margin:2px 0 0;">Shop ID: {{ $order->shop_id }}</p>@endif
                    </div>
                    <div style="background:#fff;border:1px solid #e2e8f0;border-radius:12px;padding:16px 20px;border-left:4px solid #f59e0b;">
                        <p style="font-size:11px;font-weight:700;color:#94a3b8;text-transform:uppercase;letter-spacing:.06em;margin:0 0 4px;">Customer</p>
                        <p style="font-size:14px;font-weight:700;color:#0f172a;margin:0;">{{ $order['shipping']['name'] }}</p>
                        <p style="font-size:12px;color:#64748b;margin:2px 0 0;">{{ $order['shipping']['mobile'] }}</p>
                    </div>
                    <div style="background:#fff;border:1px solid #e2e8f0;border-radius:12px;padding:16px 20px;border-left:4px solid #10b981;">
                        <p style="font-size:11px;font-weight:700;color:#94a3b8;text-transform:uppercase;letter-spacing:.06em;margin:0 0 4px;">Payment</p>
                        <p style="font-size:14px;font-weight:700;color:#0f172a;margin:0;">{{ $order['payment']['payment_method'] }}</p>
                        <p style="font-size:12px;color:#64748b;margin:2px 0 0;">{{ $order['shipping']['address'] }}</p>
                    </div>
                </div>

                {{-- Products Card --}}
                <div class="card">
                    <div class="card-header">
                        <span class="card-title"><i class="fas fa-box" style="color:#6366f1;margin-right:6px;"></i>Order Items</span>
                        <div style="margin-left:auto;display:flex;align-items:center;gap:8px;">
                            <img src="{{ asset('frontend/assets/images/12345.png') }}" style="height:32px;object-fit:contain;" alt="{{ $logo->name }}">
                            <div style="font-size:12px;color:#64748b;line-height:1.5;">
                                <div>{{ $footercontent->mobile ?? '' }}</div>
                                <div>{{ $footercontent->email ?? '' }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body" style="padding:0;">
                        <table class="table" style="margin:0;">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th class="text-center">Color / Size</th>
                                    <th class="text-center">Qty × Price</th>
                                    <th class="text-center">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php $subtotal = 0; @endphp
                                @foreach ($order->order_details as $details)
                                @php
                                    $item_price = $details->sell_price;
                                    $item_total = $details->product ? ($details->quantity * $item_price) : 0;
                                    $subtotal += $item_total;
                                @endphp
                                <tr>
                                    <td>
                                        @if($details->product)
                                            <div style="display:flex;align-items:center;gap:10px;">
                                                <img src="{{ url('upload/product_images/'.$details->product->image) }}"
                                                    style="width:44px;height:44px;border-radius:8px;object-fit:cover;border:1px solid #e2e8f0;">
                                                <span style="font-weight:600;color:#0f172a;font-size:13px;">{{ $details->product->name }}</span>
                                            </div>
                                        @else <span style="color:#94a3b8;">No product info</span> @endif
                                    </td>
                                    <td class="text-center" style="color:#64748b;font-size:13px;">
                                        {{ $details->color_name ?? 'N/A' }} / {{ $details->size_name ?? 'N/A' }}
                                    </td>
                                    <td class="text-center" style="font-size:13px;">
                                        @if($details->product) {{ $details->quantity }} × {{ $item_price }} Tk. @else 0 @endif
                                    </td>
                                    <td class="text-center" style="font-weight:600;color:#0f172a;">{{ $item_total }} Tk.</td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr style="background:#f8fafc;">
                                    <td colspan="3" style="text-align:right;font-weight:600;color:#64748b;">Sub Total:</td>
                                    <td style="font-weight:700;color:#0f172a;">{{ $subtotal }} Tk.</td>
                                </tr>
                                @if($order->coupon_discount)
                                <tr>
                                    <td colspan="3" style="text-align:right;color:#64748b;">Coupon Discount:</td>
                                    <td style="color:#10b981;font-weight:600;">-{{ $order->coupon_discount }} Tk.</td>
                                </tr>
                                @endif
                                <tr>
                                    <td colspan="3" style="text-align:right;color:#64748b;">Delivery Charge:</td>
                                    <td style="color:#f59e0b;font-weight:600;">+{{ $order->delivery_charge }} Tk.</td>
                                </tr>
                                @php $grandTotal = round($subtotal - ($order->coupon_discount ?? 0) + $order->delivery_charge); @endphp
                                <tr style="background:#f0f9ff;">
                                    <td colspan="3" style="text-align:right;font-weight:800;color:#0f172a;">Grand Total:</td>
                                    <td style="font-weight:800;color:#6366f1;font-size:15px;">{{ $grandTotal }} Tk.</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
