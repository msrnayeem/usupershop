@extends('frontend.layouts.seller_master')
@section('title')
    Customer Payment
@endsection
@section('custom_css')
    <style>
        .cart-wrapper {
            width: 100%;
            padding: 20px;
            background-color: #fafafa;
            border: 1px solid #f1f1f1;
            border-radius: 10px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
        }

        /* Each cart row */
        .cart-row {
            display: flex;
            flex-wrap: wrap;
            border: 1px solid #e0e0e0;
            margin-bottom: 15px;
            padding: 15px;
            border-radius: 8px;
            background-color: #fff;
            align-items: center;
            transition: box-shadow 0.2s;
        }

        .cart-row:hover {
            box-shadow: 0 0 8px rgba(0, 0, 0, 0.1);
        }

        /* Individual columns */
        .cart-sn,
        .cart-price,
        .cart-subtotal,
        .cart-action {
            flex: 0 0 10%;
            text-align: center;
            font-weight: 500;
            color: #333;
        }

        /* Product section */
        .cart-product {
            display: flex;
            flex: 1 1 30%;
            align-items: center;
            gap: 10px;
        }

        .product-image img {
            width: 100px;
            height: 100px;
            border: 1px solid #ddd;
        }

        .product-info {
            font-size: 14px;
            color: #444;
        }

        /* Quantity input */
        .cart-quantity {
            flex: 0 0 15%;
            text-align: center;
        }

        .qty-input {
            width: 60px;
            padding: 4px;
            text-align: center;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .container {
            width: 100%;
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
            color: #fff;
            background-color: #dc3545;
            padding: 6px 10px;
            border-radius: 4px;
            text-decoration: none;
            font-size: 14px;
            display: inline-block;
        }

        .delete-btn:hover {
            background-color: #c82333;
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

        @media (max-width: 480px) {
            .breadcrumb {
                margin-top: 22% !important;
            }
        }

        /* Responsive design */
        @media (max-width: 768px) {
            .cart-wrapper {
                width: 90%;
                margin: 0 auto;
                padding: 15px;
            }

            .cart-row {
                flex-direction: column;
                align-items: flex-start;
                gap: 10px;
            }

            .cart-sn,
            .cart-price,
            .cart-subtotal,
            .cart-action,
            .cart-quantity {
                flex: 1 1 100%;
                text-align: left;
            }

            .container {
                width: 96%;
            }
        }

        #paymentForm {
            max-width: 600px;
            margin-left: 46%;
            padding: 20px;
            background-color: #f9f9f9;
            border-radius: 8px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }

        /* Utility Classes */
        .sss {
            float: left;
        }

        .s888 {
            height: 40px;
            border: 1px solid #e6e6e6;
        }

        /* Typography */
        .highlight {
            color: #222;
            font-weight: bold;
            margin-bottom: 10px;
        }

        /* Payment Method Area */
        .payment_method_area {
            margin-left: 8%;
            width: 84%;
        }

        /* Payment Options */
        .payment-option {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px;
            margin-bottom: 10px;
            background-color: white;
            border-radius: 4px;
            transition: all 0.3s ease;
            cursor: pointer;
            width: 100%;
        }

        .payment-option:hover {
            background-color: #f0f0f0;
            transform: translateY(-2px);
        }

        .payment-option label {
            flex: 1;
            text-align: left;
            margin-left: 10px;
        }

        .payment-option input[type="radio"] {
            margin-left: 15px;
            transform: scale(1.2);
        }

        .payment-option input[type="radio"]:checked+label {
            font-weight: bold;
            color: #007bff;
        }

        /* Payment Containers */
        label[style*="border:4px solid"] {
            display: block;
            margin-bottom: 15px;
            padding: 10px;
            border-radius: 5px;
            background-color: white;
            border: 4px solid #2196f3 !important;
            width: 100%;
            box-sizing: border-box;
        }

        /* Error Message */
        font[color="red"] {
            display: block;
            margin-top: 10px;
            font-size: 14px;
            clear: both;
        }

        /* Responsive Adjustments */
        @media (max-width: 992px) {
            .payment_method_area {
                margin-left: 5%;
                width: 90%;
            }

            #paymentForm {
                max-width: 900px;
                margin-left: 10%;
                margin-top: 5%;
                padding: 20px;
                background-color: #f9f9f9;
                border-radius: 8px;
                box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            }
        }

        @media (max-width: 768px) {
            .form {
                padding: 15px;
            }

            .payment_method_area {
                margin-left: 2%;
                width: 96%;
            }

            .payment-option {
                flex-direction: row;
                align-items: center;
            }

            #paymentForm {
                max-width: 700px;
                margin-left: 10%;
                margin-top: 5%;
                padding: 20px;
                background-color: #f9f9f9;
                border-radius: 8px;
                box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            }
        }

        @media (max-width: 576px) {
            .payment-option {
                flex-direction: column;
                align-items: flex-start;
            }

            .payment-option input[type="radio"] {
                margin-left: 0;
                margin-top: 10px;
                align-self: flex-end;
            }

            .highlight {
                font-size: 14px;
            }

            #paymentForm {
                max-width: 600px;
                margin-left: 6%;
                margin-top: 5%;
                padding: 20px;
                background-color: #f9f9f9;
                border-radius: 8px;
                box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            }
        }
    </style>
@endsection
@section('content')
    <!-- Shoping Cart -->
    <div class="bg0 p-t-75 p-b-85" style="padding: 60px 0">
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-lg-12 col-xl-12" style="padding-bottom: 30px;">
                     <div class="cart-wrapper">
                            @php
                                $i = 1;
                                $contents = Cart::content();
                                $total = 0;
                                $deliveryArea = Helper::getdeliveryZone();
                            @endphp

                            @foreach ($contents as $content)
                                <div class="cart-row">
                                    <div class="cart-sn">ID {{ $i++ }}</div>

                                    <div class="cart-product">
                                        <div class="product-image">
                                            <img src="{{ url('upload/product_images/' . $content->options->image) }}"
                                                alt="{{ $content->name }}">
                                        </div>
                                        <div class="product-info">
                                            <h4>{{ $content->name }}</h4>
                                            <p>Color: {{ $content->options->color_name }}</p>
                                            <p>Size: {{ $content->options->size_name }}</p>
                                        </div>
                                    </div>

                                    <div class="cart-price">Price : &#2547; {{ $content->price }}</div>

                                    <div class="cart-quantity">
                                        <form method="post" action="{{ route('update.seller.cart') }}">
                                            @csrf
                                            <input type="number" name="qty" value="{{ $content->qty }}"
                                                class="qty-input">
                                            <input type="hidden" name="rowId" value="{{ $content->rowId }}">
                                            <button type="submit" class="update-btn">Update</button>
                                        </form>
                                    </div>

                                    <div class="cart-subtotal">Subtotal: &#2547; {{ $content->subtotal }}</div>

                                    <div class="cart-action">
                                        <a href="{{ route('delete.cart', $content->rowId) }}" class="delete-btn"><i
                                                class="fa fa-times"></i></a>
                                    </div>
                                </div>
                                @php $total += $content->subtotal; @endphp
                            @endforeach

                            @if ($contents->isEmpty())
                                <div class="empty-cart-message">
                                    <h4 class="text-danger">Cart is Empty... !!!</h4>
                                </div>
                            @endif

                            <div class="cart-footer">
                                <a href="{{ route('shop') }}" class="btn btn-primary">Continue Shopping</a>
                            </div>
                        </div>
                </div>
            </div>
            <div class="row">

                <div class="col-md-8">
                    @if (Session::get('message'))
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <strong>{{ Session::get('message') }}</strong>
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif

                    <form action="{{ route('seller.customer.payment.store') }}" method="POST" id="paymentForm"
                        class="form">
                        @csrf
                        @foreach ($contents as $content)
                            <input type="hidden" name="product_id" value="{{ $content->id }}">
                        @endforeach

                        <p class="highlight">আপনার অর্ডার কনফার্ম করার জন্য ডেলিভারি চার্জ পে করুন বিকাশ এবং নগদের মাধ্যমে
                        </p>
                        <input type="hidden" name="order_total" value="{{ $total }}">

                        <label style="border:4px solid #000;width:100%;padding:2px;">
                            <p class="highlight">ক্যাশ অন ডেলিভারি অর্ডার কনফার্ম করার জন্য এখানে ক্লিক করুন</p>
                            <div class="payment-option">
                                <label for="payment_method"><strong>Cash on Delivery</strong></label>
                                <input type="radio" id="payment_method" name="payment_method" value="Cash on Delivery">
                            </div>
                        </label><br />

                        <label style="border:4px solid #000;width:100%;padding:2px;">
                            <p class="highlight">সম্পূর্ণ মূল্য পেমেন্ট করে অর্ডার কনফার্ম করতে এখানে ক্লিক করুন</p>
                            <div class="payment-option">
                                <label for="bkash"><strong>Bkash</strong></label>
                                <input type="radio" id="bkash" name="payment_method" value="Bkash">
                            </div>
                        </label>
                        <font color="red">{{ $errors->has('payment_method') ? $errors->first('payment_method') : '' }}
                        </font>

                        <p></p>
                        <p></p>
                        <button type="submit" class="btn btn-primary" style="float: right;margin-top:8%;">Submit</button>
                    </form>
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
