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
            font-size: 10px;
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
            font-size: 12px;
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

                        <div class="payment-method">
                            @if (Session::get('message'))
                                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                    <strong>{{ Session::get('message') }}</strong>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif
                            <form action="{{ route('customer.payment.store') }}" method="POST" id="paymentForm"
                                class="form">
                                @csrf
                                @foreach ($contents as $content)
                                    <input type="hidden" name="product_id" value="{{ $content->id }}">
                                @endforeach

                                <div style="background:#fff3cd; border:1px solid #ffc107; border-radius:8px; padding:12px 14px; margin-bottom:14px;">
                                    <strong style="color:#856404; font-size:14px; display:block; margin-bottom:4px;">⚠️ ডেলিভারি চার্জ পেমেন্ট বাধ্যতামূলক</strong>
                                    <p style="color:#856404; font-size:12px; margin:0; line-height:1.6;">
                                        অর্ডার কনফার্ম করতে অবশ্যই ডেলিভারি চার্জ পেমেন্ট করতে হবে।<br>
                                        <strong>Cash on Delivery</strong> অর্ডারেও bKash-এ ডেলিভারি চার্জ পেমেন্ট করুন।
                                    </p>
                                </div>
                                <input type="hidden" name="order_total" value="{{ $total }}">

                                <div class="payment-options">
                                    <div class="payment-item">
                                        <label for="cash_on_delivery">
                                            <img class="img-fluid" src="{{ asset('/') }}frontend/cash-on-delivery.png" alt="cash on delivery" style="margin-top: 10px;">
                                        </label>
                                        <input type="radio" id="cash_on_delivery" name="payment_method"
                                            value="Cash on Delivery">
                                    </div>

                                    <div class="payment-item">
                                        <label for="bkash">
                                            <img class="img-fluid" src="{{ asset('/') }}frontend/bkash.png"
                                                alt="bKash">
                                        </label>
                                        <input type="radio" id="bkash" name="payment_method" value="Bkash">
                                    </div>
                                </div>

                                {{-- <label style="border:4px solid #2f2e2e;width:100%;padding:2px;">
                                    <p class="highlight">ই পি এস এ পেমেন্ট করে অর্ডার কনফার্ম করতে এখানে ক্লিক করুন</p>
                                    <div class="payment-option">
                                        <div>
                                            <img src="{{ asset('/') }}frontend/assets/images/eps.png" width="40" alt="EPS">
                                            <label for="eps"><strong>EPS</strong></label>
                                        </div>
                                        <input type="radio" id="eps" name="payment_method" value="EPS">
                                    </div>
                                </label> --}}

                                <font color="red">
                                    {{ $errors->has('payment_method') ? $errors->first('payment_method') : '' }}
                                </font>
                                <button type="submit" class="btn btn-primary text-center">Confirm Order</button>
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
