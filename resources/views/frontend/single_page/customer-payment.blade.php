@extends('frontend.layouts.master')
@section('title', 'Payment | ' . config('app.name'))

@section('meta_description', 'Secure payment page at ' . config('app.name') . ' — complete your order safely using multiple payment options with fast and reliable delivery.')
@section('meta_keywords', 'Payment, Secure Payment, Checkout, Customer Account, ' . config('app.name'))
@section('meta_author', config('app.name'))

@push('meta')
    {{-- Prevent indexing by search engines --}}
    <meta name="robots" content="noindex, nofollow">

    {{-- Open Graph / Facebook --}}
    <meta property="og:title" content="Payment - {{ config('app.name') }}" />
    <meta property="og:description" content="Complete your order securely at {{ config('app.name') }} using multiple payment options." />
    <meta property="og:image" content="{{ asset('frontend/images/og-default.jpg') }}" />
    <meta property="og:url" content="{{ url()->current() }}" />
    <meta property="og:type" content="website" />

    {{-- Twitter Card --}}
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Payment - {{ config('app.name') }}">
    <meta name="twitter:description" content="Complete your order securely at {{ config('app.name') }} using multiple payment options.">
    <meta name="twitter:image" content="{{ asset('frontend/images/og-default.jpg') }}">
@endpush

@section('content')
    <style>
        .payment-options {
            display: flex;
            width: 100%;
            margin-bottom: 13px;
        }

        .payment-options .payment-item {
            overflow: hidden;
        }

        .payment-options .payment-item label {
            height: 60px;
            width: 80px;
            display: block;
            overflow: hidden;
            border: 1px solid #ddd;
            margin: auto;
            margin-right: 10px;
            border-radius: 4px;
            text-align: center;
            vertical-align: middle;
            cursor: pointer;
            transition: 0.3s;
        }
        .payment-options .payment-item label:hover, .payment-options .payment-item label.active {
            border: 1px solid #0824acd1;
        }

        .payment-options .payment-item label img {
            width: 80px;
            height: auto;
            vertical-align: middle;
            margin: auto;
            text-align: center;
            margin-top: 5px;
            padding: 4px;
        }

        .payment-options .payment-item input {
            display: none;
        }

        .cart-wrapper {
            width: 100%;
            padding: 20px;
            background-color: #fafafa;
            border: 1px solid #f1f1f1;
            border-radius: 4px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
        }

        /* Each cart row */
        .cart-row {
            display: flex;
            border: 1px solid #e0e0e0;
            margin-bottom: 10px;
            padding: 10px;
            border-radius: 6px;
            background-color: #fff;
            align-items: center;
            transition: box-shadow 0.2s;
            width: 100%;
            margin: auto;
            position: relative;
            margin-bottom: 10px;
        }

        .cart-row:hover {
            box-shadow: 0 0 8px rgba(0, 0, 0, 0.1);
        }

        /* Individual columns */

        .cart-subtotal {
            text-align: center;
            font-weight: 600;
            color: #333;
            margin: auto;
            margin-left: 10px;
        }

        /* Product section */
        .cart-product {
            display: flex;
            align-items: center;
            float: left;
            margin-left: 0px;
            margin-right: auto;
        }

        .product-image img {
            width: 80px;
            height: 80px;
            border: 1px solid #ddd;
            border-radius: 4px;
            padding: 2px;
        }

        .product-info {
            font-size: 14px;
            color: #444;
        }

        .product-info h4 {
            font-size: 13px;
            font-weight: 600;
            margin: 0px;
            margin-bottom: 4px;
        }

        .product-info p {
            margin: 0px;
            font-size:13px;
        }

        /* Quantity input */
        .cart-quantity {
            text-align: center;
            float: right;
            display: flex;
            margin: auto;
            margin-right: 20px;
        }

        .qty-input {
            width: 45px;
            padding: 4px;
            text-align: center;
            border: 1px solid #ccc;
            border-radius: 2px;
            outline: none;
        }

        button.qty-minus,
        button.qty-plus {
            padding: 4px 8px;
            border: 1px solid #ddd;
            border-radius: 2px;
        }

        /* Update button */
        .update-btn {
            margin-top: 5px;
            padding: 5px 8px;
            background: #007bff;
            color: #fff;
            border: none;
            font-size:14px;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.2s;
        }

        .update-btn:hover {
            background-color: #0056b3;
        }

        /* Delete button */
        .delete-btn {
            color: #ff0808;
            font-size: 17px;
            position: absolute;
            right: 4px;
            top: 4px;
            padding: 5px 7px;
            background: #ff080830;
            border-radius: 50%;
            line-height: 10px;
            border: none;
        }

        .delete-btn:hover {
            color: #be0909;
        }

        /* Footer section */
        .cart-footer {
            text-align: right;
            margin-top: 20px;
        }

        /* Empty cart message */
        .empty-cart-message {
            text-align: center;
            margin-top: 30px;
            font-weight: bold;
            color: #cc0000;
            font-size: 16px;
        }

        @media (max-width: 768px) {
            .breadcrumb {
                margin-top: 22% !important;
            }
        }

        /* Responsive design */
        @media (max-width: 768px) {
            .cart-wrapper {
                width: 100%;
                margin: 0 auto;
                padding: 15px;
            }

            .cart-row {
                flex-direction: column;
                align-items: flex-start;
            }


            .cart-quantity {
                margin-left: 0px;
                margin-right: 0px;
                margin-top: 10px;
            }
            .bg0 {
                margin-top: 110px;
            }




        }
    </style>

    <!-- Shoping Cart -->
    <div class="bg0 p-t-75 p-b-85" style="padding:10px 0">
        <div class="container"style="width:100%;">
            <div class="row">
                <div class="col-md-12 col-lg-12 col-xl-12" style="padding-bottom:10px;">

                    <div class="cart-wrapper">
                        @php
                            $i = 1;
                            $contents = Cart::content();
                            $total = 0;
                            $deliveryArea = Helper::getdeliveryZone();
                        @endphp

                        @foreach ($contents as $content)
                            <div class="cart-row">

                                <div class="cart-product">
                                    <div class="product-image" style="margin-right: 5px;">
                                        <img src="{{ url('upload/product_images/' . $content- loading="lazy">options->image) }}"
                                            alt="{{ $content->name }}">
                                    </div>
                                    <div class="product-info">
                                        <h4>{{ $content->name }}</h4>
                                        <p><strong>Color :</strong> {{ $content->options->color_name }}</p>
                                        <p><strong>Size :</strong> {{ $content->options->size_name }}</p>
                                        <p><strong>Price :</strong> &#2547; {{ $content->price }}</p>
                                    </div>
                                </div>


                                <div class="cart-quantity">
                                    <strong>QTY</strong> : {{ $content->qty }}
                                    <div class="cart-subtotal">Price : &#2547; {{ $content->subtotal }}</div>
                                </div>



                            </div>
                            @php

                                $cDiss = Session::get('coupon_discount');
                                $deliveryCharged = 0;
                                $deliveryCharged = Session::get('delivery_charge');
                                $gTotal = $total - $cDiss + $deliveryCharged;

                                $total += $content->subtotal;
                            @endphp
                        @endforeach

                        @if ($contents->isEmpty())
                            <div class="empty-cart-message">
                                <h4 class="text-danger">Cart is Empty... !!!</h4>
                            </div>
                        @endif

                        @php
                            $FREE_THRESHOLD = 1000;
                            $isFreeDelivery = $total >= $FREE_THRESHOLD;
                            $effectiveDelivery = $isFreeDelivery ? 0 : $deliveryCharged;
                            $grandTotal = $total - $cDiss + $effectiveDelivery;
                            $remaining = $FREE_THRESHOLD - $total;
                        @endphp

                        <div class="payment-method">
                            @if (Session::get('message'))
                                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                    <strong>{{ Session::get('message') }}</strong>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif

                            {{-- ── FREE DELIVERY BANNER ── --}}
                            @if($isFreeDelivery)
                            <div style="background:linear-gradient(135deg,#00a855,#007a3d);border-radius:12px;padding:14px 16px;margin-bottom:14px;display:flex;align-items:center;gap:12px;">
                                <div style="font-size:28px;flex-shrink:0;">🎉</div>
                                <div>
                                    <strong style="color:#fff;font-size:14px;display:block;margin-bottom:2px;">আপনি FREE DELIVERY পেয়েছেন!</strong>
                                    <span style="color:rgba(255,255,255,.88);font-size:14px;">১,০০০ টাকার উপরে অর্ডারে ডেলিভারি সম্পূর্ণ বিনামূল্যে।</span>
                                </div>
                            </div>
                            @else
                            <div style="background:#fff5f5;border:1.5px solid #ffb3b3;border-radius:12px;padding:14px 16px;margin-bottom:14px;">
                                <div style="display:flex;align-items:center;gap:10px;margin-bottom:8px;">
                                    <span style="font-size:22px;">🚚</span>
                                    <strong style="color:#e8001d;font-size:13px;">ডেলিভারি চার্জ প্রযোজ্য</strong>
                                </div>
                                <p style="color:#555;font-size:14px;margin:0 0 8px;line-height:1.6;">
                                    ১,০০০ টাকার কম অর্ডারে ডেলিভারি চার্জ <strong>bKash-এ আগে পরিশোধ</strong> করতে হবে।<br>
                                    Cash on Delivery বা bKash — যেকোনো মেথডে অর্ডার করলেও ডেলিভারি চার্জ আগেই দিতে হবে।
                                </p>
                                <div style="background:#e8001d;color:#fff;border-radius:8px;padding:8px 12px;font-size:14px;font-weight:700;">
                                    আরও ৳{{ number_format($remaining, 0) }} টাকার কেনাকাটা করলে FREE DELIVERY পাবেন! 🎁
                                </div>
                            </div>
                            @endif

                            {{-- ── ORDER SUMMARY ── --}}
                            <div style="background:#f8f9fa;border:1px solid #eee;border-radius:10px;padding:12px 14px;margin-bottom:14px;">
                                <div style="display:flex;justify-content:space-between;font-size:14px;color:#666;margin-bottom:6px;">
                                    <span>পণ্যের মোট দাম</span>
                                    <span>৳{{ number_format($total, 0) }}</span>
                                </div>
                                @if($cDiss > 0)
                                <div style="display:flex;justify-content:space-between;font-size:14px;color:#00a855;margin-bottom:6px;">
                                    <span>কুপন ছাড়</span>
                                    <span>-৳{{ number_format($cDiss, 0) }}</span>
                                </div>
                                @endif
                                <div style="display:flex;justify-content:space-between;font-size:14px;color:#666;margin-bottom:8px;">
                                    <span>ডেলিভারি চার্জ</span>
                                    @if($isFreeDelivery)
                                        <span style="color:#00a855;font-weight:700;">বিনামূল্যে 🎉</span>
                                    @else
                                        <span style="color:#e8001d;">৳{{ number_format($effectiveDelivery, 0) }}</span>
                                    @endif
                                </div>
                                <div style="border-top:1px solid #ddd;padding-top:8px;display:flex;justify-content:space-between;font-size:15px;font-weight:800;color:#111;">
                                    <span>সর্বমোট</span>
                                    <span style="color:#e8001d;">৳{{ number_format($grandTotal, 0) }}</span>
                                </div>
                                @if(!$isFreeDelivery)
                                <div style="margin-top:8px;padding:6px 10px;background:#fff3cd;border-radius:6px;font-size:13px;color:#856404;">
                                    ⚠️ bKash-এ এখন পরিশোধ করতে হবে: <strong>৳{{ number_format($effectiveDelivery, 0) }}</strong> (ডেলিভারি চার্জ)
                                </div>
                                @endif
                            </div>

                            <form action="{{ route('customer.payment.store') }}" method="POST" id="paymentForm" class="form">
                                @csrf
                                @foreach ($contents as $content)
                                    <input type="hidden" name="product_id" value="{{ $content->id }}">
                                @endforeach
                                <input type="hidden" name="order_total" value="{{ $total }}">
                                <input type="hidden" name="free_delivery" value="{{ $isFreeDelivery ? '1' : '0' }}">


                                {{-- ── Coupon Section (Optional) ──────────────────────── --}}
                                @php $appliedCoupon = Session::get('coupon_code'); $cDiscount = Session::get('coupon_discount', 0); @endphp
                                <div style="margin-bottom:14px">
                                    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:8px">
                                        <div style="font-size:13px;font-weight:800;color:#111">🎟️ কুপন কোড <span style="background:#f0f0f0;color:#888;font-size:13px;padding:2px 8px;border-radius:10px;font-weight:600;margin-left:4px">Optional</span></div>
                                        @if($appliedCoupon)
                                        <a href="{{ route('remove.coupon') }}" style="font-size:13px;color:#e8001d;font-weight:700;text-decoration:none">✕ সরান</a>
                                        @endif
                                    </div>
                                    @if($appliedCoupon && $cDiscount > 0)
                                    <div style="background:#e8f5e9;border:1.5px solid #a5d6a7;border-radius:10px;padding:10px 14px;display:flex;align-items:center;gap:10px">
                                        <div style="font-size:20px">✅</div>
                                        <div>
                                            <div style="font-size:13px;font-weight:800;color:#2e7d32">{{ $appliedCoupon }} — কুপন প্রয়োগ হয়েছে!</div>
                                            <div style="font-size:14px;color:#388e3c">৳{{ number_format($cDiscount, 0) }} ছাড় পাচ্ছেন</div>
                                        </div>
                                    </div>
                                    @else
                                    <div style="display:flex;gap:8px">
                                        <input type="text" id="couponInput"
                                            placeholder="কুপন কোড দিন (যেমন: SAVE100)"
                                            style="flex:1;padding:11px 14px;border:1.5px solid #e5e5e5;border-radius:10px;font-size:13px;font-family:'Hind Siliguri',sans-serif;outline:none;transition:border-color .2s"
                                            onfocus="this.style.borderColor='#e8001d'"
                                            onblur="this.style.borderColor='#e5e5e5'">
                                        <button type="button" onclick="applyCoupon()"
                                            style="background:#e8001d;color:#fff;border:none;padding:11px 16px;border-radius:10px;font-size:13px;font-weight:700;cursor:pointer;font-family:'Hind Siliguri',sans-serif;white-space:nowrap">
                                            Apply
                                        </button>
                                    </div>
                                    <div id="couponMsg" style="font-size:14px;margin-top:5px;display:none"></div>
                                    @endif
                                </div>

                                <script>
                                function applyCoupon() {
                                    var code = document.getElementById('couponInput').value.trim();
                                    var msg  = document.getElementById('couponMsg');
                                    if (!code) {
                                        msg.style.display = 'block';
                                        msg.style.color   = '#e8001d';
                                        msg.textContent   = '❌ কুপন কোড লিখুন।';
                                        return;
                                    }
                                    msg.style.display = 'block';
                                    msg.style.color   = '#888';
                                    msg.textContent   = '⏳ যাচাই করা হচ্ছে...';

                                    fetch('{{ route("ajax.apply.coupon") }}', {
                                        method: 'POST',
                                        headers: {
                                            'Content-Type': 'application/json',
                                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                        },
                                        body: JSON.stringify({ coupon_code: code, total: {{ $total }} })
                                    })
                                    .then(function(r){ return r.json(); })
                                    .then(function(data) {
                                        msg.style.display = 'block';
                                        if (data.success) {
                                            msg.style.color = '#00a855';
                                            msg.textContent = '✅ ' + data.message;
                                            setTimeout(function(){ location.reload(); }, 800);
                                        } else {
                                            msg.style.color = '#e8001d';
                                            msg.textContent = '❌ ' + data.message;
                                        }
                                    })
                                    .catch(function() {
                                        msg.style.color = '#e8001d';
                                        msg.textContent = '❌ সংযোগ সমস্যা। আবার চেষ্টা করুন।';
                                    });
                                }
                                // Enter key support
                                document.addEventListener('DOMContentLoaded', function() {
                                    var inp = document.getElementById('couponInput');
                                    if (inp) inp.addEventListener('keypress', function(e) {
                                        if (e.key === 'Enter') { e.preventDefault(); applyCoupon(); }
                                    });
                                });
                                </script>

                                {{-- ── Payment Options ──────────────────────────────────── --}}
                                @if($isFreeDelivery)
                                {{-- ≥১,০০০ টাকা: COD ও Full bKash Payment --}}
                                <p style="font-size:14px;font-weight:700;color:#333;margin-bottom:12px">💳 পেমেন্ট পদ্ধতি বেছে নিন:</p>

                                {{-- COD Button --}}
                                <div id="codSection">
                                    <div class="payment-item" id="codCard"
                                        style="border:2px solid #00a855;background:#f0fff8;border-radius:14px;padding:14px 16px;cursor:pointer;margin-bottom:10px;display:flex;align-items:center;gap:14px"
                                        onclick="selectCOD()">
                                        <div style="font-size:32px;flex-shrink:0">🏠</div>
                                        <div>
                                            <div style="font-size:14px;font-weight:800;color:#1a1a1a">Cash on Delivery-তে অর্ডার করুন</div>
                                            <div style="font-size:14px;color:#666;margin-top:2px">পণ্য পেয়ে দরজায় পেমেন্ট করুন</div>
                                        </div>
                                        <div style="margin-left:auto;width:20px;height:20px;border-radius:50%;background:#00a855;display:flex;align-items:center;justify-content:center;color:#fff;font-size:14px;font-weight:800;flex-shrink:0" id="codCheck">✓</div>
                                    </div>
                                    <input type="radio" id="cash_on_delivery" name="payment_method" value="Cash on Delivery" checked style="display:none">
                                </div>

                                {{-- Full Payment Button --}}
                                <div id="bkashSection">
                                    <div class="payment-item" id="bkashCard"
                                        style="border:2px solid #eee;background:#fff;border-radius:14px;padding:14px 16px;cursor:pointer;margin-bottom:10px;display:flex;align-items:center;gap:14px"
                                        onclick="selectBkash()">
                                        <div style="background:#e8001d;color:#fff;font-size:14px;font-weight:800;border-radius:8px;padding:6px 12px;flex-shrink:0">bKash</div>
                                        <div>
                                            <div style="font-size:14px;font-weight:800;color:#1a1a1a">Full Payment করে অর্ডার করুন</div>
                                            <div style="font-size:14px;color:#666;margin-top:2px">bKash-এ এখনই সম্পূর্ণ পেমেন্ট করুন</div>
                                        </div>
                                        <div style="margin-left:auto;width:20px;height:20px;border-radius:50%;border:2px solid #eee;flex-shrink:0" id="bkashCheck"></div>
                                    </div>
                                    <input type="radio" id="bkash" name="payment_method" value="Bkash" style="display:none">
                                </div>

                                @else
                                {{-- <১,০০০ টাকা: দুটো option — COD (delivery bKash) অথবা Full bKash --}}
                                <p style="font-size:14px;font-weight:700;color:#333;margin-bottom:12px">💳 বিকাশে পেমেন্ট করুন:</p>

                                <div style="background:#fff3cd;border:1.5px solid #ffd54f;border-radius:12px;padding:12px 14px;margin-bottom:12px;font-size:13px;color:#856404;line-height:1.7">
                                    ⚠️ ১,০০০ টাকার কম অর্ডারে ডেলিভারি চার্জ <strong>bKash-এ আগে</strong> পরিশোধ করতে হবে।
                                </div>

                                {{-- Option 1: COD — delivery charge bKash --}}
                                <div id="codSection">
                                    <div class="payment-item" id="codCard"
                                        style="border:2px solid #00a855;background:#f0fff8;border-radius:14px;padding:14px 16px;cursor:pointer;margin-bottom:10px;display:flex;align-items:center;gap:14px"
                                        onclick="selectCOD()">
                                        <div style="font-size:32px;flex-shrink:0">🏠</div>
                                        <div>
                                            <div style="font-size:13px;font-weight:800;color:#1a1a1a">Cash on Delivery-তে অর্ডার করতে</div>
                                            <div style="font-size:14px;font-weight:700;color:#e8001d;margin-top:2px">ডেলিভারি চার্জ (৳{{ number_format($effectiveDelivery, 0) }}) বিকাশে পে করুন</div>
                                        </div>
                                        <div style="margin-left:auto;width:20px;height:20px;border-radius:50%;background:#00a855;display:flex;align-items:center;justify-content:center;color:#fff;font-size:14px;font-weight:800;flex-shrink:0" id="codCheck">✓</div>
                                    </div>
                                    <input type="radio" id="cash_on_delivery" name="payment_method" value="Cash on Delivery" checked style="display:none">
                                </div>

                                {{-- Option 2: Full bKash payment --}}
                                <div id="bkashSection">
                                    <div class="payment-item" id="bkashCard"
                                        style="border:2px solid #eee;background:#fff;border-radius:14px;padding:14px 16px;cursor:pointer;margin-bottom:10px;display:flex;align-items:center;gap:14px"
                                        onclick="selectBkash()">
                                        <div style="background:#e8001d;color:#fff;font-size:14px;font-weight:800;border-radius:8px;padding:6px 12px;flex-shrink:0">bKash</div>
                                        <div>
                                            <div style="font-size:13px;font-weight:800;color:#1a1a1a">Full Payment করে অর্ডার করতে এখানে ক্লিক করুন</div>
                                            <div style="font-size:14px;color:#666;margin-top:2px">সম্পূর্ণ ৳{{ number_format($grandTotal, 0) }} bKash-এ এখনই পে করুন</div>
                                        </div>
                                        <div style="margin-left:auto;width:20px;height:20px;border-radius:50%;border:2px solid #eee;flex-shrink:0" id="bkashCheck"></div>
                                    </div>
                                    <input type="radio" id="bkash" name="payment_method" value="Bkash" style="display:none">
                                </div>
                                @endif

                                <font color="red">
                                    {{ $errors->has('payment_method') ? $errors->first('payment_method') : '' }}
                                </font>

                                <script>
                                function selectCOD() {
                                    // Activate COD
                                    document.getElementById('cash_on_delivery').checked = true;
                                    document.getElementById('codCard').style.borderColor = '#00a855';
                                    document.getElementById('codCard').style.background = '#f0fff8';
                                    document.getElementById('codCheck').style.background = '#00a855';
                                    document.getElementById('codCheck').innerHTML = '✓';
                                    // Deactivate bKash
                                    document.getElementById('bkashCard').style.borderColor = '#eee';
                                    document.getElementById('bkashCard').style.background = '#fff';
                                    document.getElementById('bkashCheck').style.background = 'transparent';
                                    document.getElementById('bkashCheck').innerHTML = '';
                                    document.getElementById('bkashCheck').style.border = '2px solid #eee';
                                    // Update submit button
                                    @if($isFreeDelivery)
                                    document.getElementById('orderSubmitBtn').innerHTML = '✅ Cash on Delivery-তে Order করুন';
                                    document.getElementById('orderSubmitBtn').style.background = '#00a855';
                                    document.getElementById('orderSubmitBtn').style.borderColor = '#00a855';
                                    @else
                                    document.getElementById('orderSubmitBtn').innerHTML = '💳 ডেলিভারি চার্জ ৳{{ number_format($effectiveDelivery, 0) }} bKash-এ পে করুন';
                                    document.getElementById('orderSubmitBtn').style.background = '#e8001d';
                                    document.getElementById('orderSubmitBtn').style.borderColor = '#e8001d';
                                    @endif
                                }

                                function selectBkash() {
                                    // Activate bKash
                                    document.getElementById('bkash').checked = true;
                                    document.getElementById('bkashCard').style.borderColor = '#e8001d';
                                    document.getElementById('bkashCard').style.background = '#fff5f5';
                                    document.getElementById('bkashCheck').style.background = '#e8001d';
                                    document.getElementById('bkashCheck').innerHTML = '✓';
                                    document.getElementById('bkashCheck').style.border = 'none';
                                    // Deactivate COD
                                    document.getElementById('codCard').style.borderColor = '#eee';
                                    document.getElementById('codCard').style.background = '#fff';
                                    document.getElementById('codCheck').style.background = 'transparent';
                                    document.getElementById('codCheck').innerHTML = '';
                                    document.getElementById('codCheck').style.background = '#eee';
                                    // Update submit button
                                    @if($isFreeDelivery)
                                    document.getElementById('orderSubmitBtn').innerHTML = '💳 Full Payment করে Order করুন';
                                    @else
                                    document.getElementById('orderSubmitBtn').innerHTML = '💳 Full Payment ৳{{ number_format($grandTotal, 0) }} bKash-এ পে করুন';
                                    @endif
                                    document.getElementById('orderSubmitBtn').style.background = '#e8001d';
                                    document.getElementById('orderSubmitBtn').style.borderColor = '#e8001d';
                                }
                                </script>

                                <button type="submit" class="btn btn-primary text-center"
                                    style="width:100%;padding:14px;font-size:15px;font-weight:700;border-radius:12px;background:#00a855;border-color:#00a855;margin-top:4px"
                                    id="orderSubmitBtn">
                                    @if($isFreeDelivery)
                                        ✅ Cash on Delivery-তে Order করুন
                                    @else
                                        💳 ডেলিভারি চার্জ ৳{{ number_format($effectiveDelivery, 0) }} bKash-এ পে করুন
                                    @endif
                                </button>

                            </form>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
    <script type="text/javascript">
        $(document).on('change', '#payment_method', function() {
            var payment_method = $(this).val();
            if (payment_method == 'Bkash') {
                $('.show_field').show();
            } else {
                $('.show_field').hide();
            }
        });
        
    </script>
@endsection

@push('custom_script')
    <script>
        $(document).ready(function() {
            $('.payment-options .payment-item label').click(function() {
                $('.payment-options .payment-item label').removeClass('active');
                $(this).addClass('active');
            });
        });
    </script>
@endpush
