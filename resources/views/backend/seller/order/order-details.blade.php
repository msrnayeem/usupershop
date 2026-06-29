@extends('backend.seller.seller-master')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        {{-- Page Header --}}
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:22px;flex-wrap:wrap;gap:12px;">
            <div>
                <h1 style="font-size:22px;font-weight:800;color:#0f172a;margin:0;">
                    <i class="fas fa-shopping-bag" style="color:#6366f1;margin-right:8px;"></i>
                    Order Details
                </h1>
                <p style="color:#64748b;font-size:13px;margin:2px 0 0;">
                    <a href="{{ route('seller.dashboard') }}" style="color:#6366f1;text-decoration:none;">Dashboard</a>
                    <span style="margin:0 6px;color:#cbd5e1;">/</span>
                    <a href="{{ route('seller.orders.approved.list') }}" style="color:#6366f1;text-decoration:none;">Orders</a>
                    <span style="margin:0 6px;color:#cbd5e1;">/</span>
                    Details
                </p>
            </div>
            <a class="btn btn-sm btn-primary" href="{{ route('seller.orders.approved.list') }}" style="display:inline-flex;align-items:center;gap:6px;padding:9px 18px;background:#6366f1;border:none;border-radius:8px;font-size:13px;font-weight:600;color:#fff;text-decoration:none;">
                <i class="fas fa-list"></i> Orders List
            </a>
        </div>

        @php
            $footercontent = Helper::getfootercontacts();
        @endphp

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                {{-- Info Section Cards --}}
                <div class="row">
                    {{-- Company/Order Info --}}
                    <div class="col-md-6 mb-4">
                        <div class="card h-100">
                            <div class="card-header">
                                <span class="card-title font-weight-bold text-dark"><i class="fas fa-info-circle mr-1 text-primary"></i> Order Reference</span>
                            </div>
                            <div class="card-body">
                                <div style="display:flex;align-items:center;gap:12px;margin-bottom:15px;">
                                    <div style="background:#e0e7ff;color:#6366f1;width:44px;height:44px;border-radius:8px;display:flex;align-items:center;justify-content:center;font-size:18px;">
                                        <i class="fas fa-file-invoice"></i>
                                    </div>
                                    <div>
                                        <div style="font-size:11px;font-weight:700;color:#64748b;text-transform:uppercase;">Order ID</div>
                                        <div style="font-size:15px;font-weight:800;color:#0f172a;">ODR-#{{ $order->order_no }}</div>
                                    </div>
                                </div>
                                @if(!empty($order->shop_id))
                                    <div style="font-size:13px;color:#475569;margin-bottom:6px;">
                                        <strong>Shop ID:</strong> {{ $order->shop_id }}
                                    </div>
                                @endif
                                <div style="font-size:13px;color:#475569;margin-bottom:6px;">
                                    <strong>Merchant Contact:</strong> {{ $footercontent->mobile ?? '' }}
                                </div>
                                <div style="font-size:13px;color:#475569;margin-bottom:6px;">
                                    <strong>Merchant Email:</strong> {{ $footercontent->email ?? '' }}
                                </div>
                                <div style="font-size:13px;color:#475569;">
                                    <strong>Warehouse Address:</strong> {{ $footercontent->address ?? '' }}
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Billing/Shipping Info --}}
                    <div class="col-md-6 mb-4">
                        <div class="card h-100">
                            <div class="card-header">
                                <span class="card-title font-weight-bold text-dark"><i class="fas fa-shipping-fast mr-1 text-primary"></i> Delivery Coordinates</span>
                            </div>
                            <div class="card-body">
                                <div style="font-size:13px;color:#475569;margin-bottom:8px;padding-bottom:8px;border-bottom:1px solid #f1f5f9;">
                                    <strong>Recipient Name:</strong> {{ $order['shipping']['name'] }}
                                </div>
                                <div style="font-size:13px;color:#475569;margin-bottom:8px;padding-bottom:8px;border-bottom:1px solid #f1f5f9;">
                                    <strong>Mobile Number:</strong> {{ $order['shipping']['mobile'] }}
                                </div>
                                <div style="font-size:13px;color:#475569;margin-bottom:8px;padding-bottom:8px;border-bottom:1px solid #f1f5f9;">
                                    <strong>Email Address:</strong> {{ $order['shipping']['email'] ?? 'N/A' }}
                                </div>
                                <div style="font-size:13px;color:#475569;margin-bottom:8px;padding-bottom:8px;border-bottom:1px solid #f1f5f9;">
                                    <strong>Shipping Address:</strong> {{ $order['shipping']['address'] }}
                                </div>
                                <div style="font-size:13px;color:#475569;">
                                    <strong>Payment Gateway:</strong> <span class="badge badge-secondary" style="font-weight:700;border-radius:4px;padding:3px 8px;">{{ $order['payment']['payment_method'] }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Product List Grid --}}
                <div class="card mb-4">
                    <div class="card-header">
                        <span class="card-title font-weight-bold text-dark"><i class="fas fa-box-open mr-1 text-primary"></i> Consignment Items</span>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover table-striped mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th>Product Name & Image</th>
                                        <th class="text-center">Color & Size</th>
                                        <th class="text-right">Price per unit</th>
                                        <th class="text-center">Quantity</th>
                                        <th class="text-right">Total Price</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $subtotal = 0;
                                    @endphp
                                    @foreach ($order->order_details as $details)
                                        <tr>
                                            <td>
                                                <div style="display:flex;align-items:center;gap:12px;">
                                                    @if ($details->product)
                                                        <div style="background:#f8fafc;border:1px solid #cbd5e1;padding:4px;border-radius:6px;width:44px;height:44px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                                            <img src="{{ url('upload/product_images/' . $details->product->image) }}" style="max-height:100%;max-width:100%;object-fit:contain;">
                                                        </div>
                                                        <strong style="color:#0f172a;font-size:13.5px;">{{ $details->product->name }}</strong>
                                                    @else
                                                        <span class="text-muted">No product details available</span>
                                                    @endif
                                                </div>
                                            </td>
                                            <td class="text-center" style="font-weight:600;color:#475569;">
                                                {{ $details->color_name ?? 'N/A' }} / {{ $details->size_name ?? 'N/A' }}
                                            </td>
                                            <td class="text-right" style="font-weight:600;">৳{{ number_format($details->sell_price, 2) }}</td>
                                            <td class="text-center" style="font-weight:700;">{{ $details->quantity }}</td>
                                            <td class="text-right" style="font-weight:700;color:#0f172a;">
                                                @php
                                                    $item_total = $details->quantity * $details->sell_price;
                                                    $subtotal += $item_total;
                                                @endphp
                                                ৳{{ number_format($item_total, 2) }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                {{-- Totals Summary --}}
                <div class="row justify-content-end">
                    <div class="col-md-5">
                        <div class="card">
                            <div class="card-body p-0">
                                <table class="table mb-0">
                                    <tbody>
                                        <tr>
                                            <td style="border-top:none;color:#64748b;font-weight:600;font-size:13px;">Subtotal Amount:</td>
                                            <td class="text-right" style="border-top:none;font-weight:700;color:#0f172a;">৳{{ number_format($subtotal, 2) }}</td>
                                        </tr>
                                        @if ($order->coupon_discount != null)
                                            <tr>
                                                <td style="color:#64748b;font-weight:600;font-size:13px;">Coupon Discount Applied:</td>
                                                <td class="text-right text-success" style="font-weight:700;">- ৳{{ number_format($order->coupon_discount, 2) }}</td>
                                            </tr>
                                        @endif
                                        <tr>
                                            <td style="color:#64748b;font-weight:600;font-size:13px;">Shipping Logistics Fee:</td>
                                            <td class="text-right" style="font-weight:700;color:#0f172a;">৳{{ number_format($order->delivery_charge, 2) }}</td>
                                        </tr>
                                        @php
                                            $grandTotal = round($subtotal - ($order->coupon_discount ?? 0) + $order->delivery_charge);
                                        @endphp
                                        <tr style="background:#f8fafc;">
                                            <td style="font-size:14px;font-weight:800;color:#0f172a;">Grand Payable Total:</td>
                                            <td class="text-right" style="font-size:16px;font-weight:800;color:#6366f1;">৳{{ number_format($grandTotal, 2) }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
