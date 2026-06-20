@extends('frontend.layouts.seller_master')
@section('title')
    Shopping Cart
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
    </style>
@endsection
@section('content')
    @php
        $shopID = request()->segment(2) ?? 216;
    @endphp
    <!-- =============== HEADER : END =================== -->
    <div class="container">
        <div class=" breadcrumb">
            <div class="breadcrumb-inner">
                <ul class="list-inline list-unstyled">
                    <li><a href="{{ route('seller.home', $shopID) }}">Home</a></li>
                    <li class='active'>Shopping Cart</li>
                </ul>
            </div><!-- /.breadcrumb-inner -->
        </div><!-- /.container -->
    </div><!-- /.breadcrumb -->

    <div class="body-content outer-top-xs">
        <div class="container"style="width:99%;">
            <div class="row">
                <div class="shopping-cart">
                    <div class="shopping-cart-table ">
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
                    </div><!-- /.shopping-cart-table -->
                    <br>
                    <div class="row">
                        <!-- Left Side: Coupon Section -->
                        <div class="col-md-6 col-sm-12 estimate-ship-tax">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>
                                            <span class="estimate-title english_lang">Discount Code</span>
                                            <span class="estimate-title bangla_lang" style="display: none;">ডিসকাউন্ট
                                                কোড</span>
                                            <p class="english_lang">Enter your coupon code if you have one..</p>
                                            <p class="bangla_lang" style="display: none;">আপনার কুপন কোড থাকলে তা লিখুন..
                                            </p>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <form method="post" action="{{ route('seller.save.coupon') }}">
                                                @csrf
                                                <div class="form-group">
                                                    <input type="text"
                                                        class="form-control unicase-form-control text-input"
                                                        id="coupon_code" name="coupon_code" placeholder="Coupon Code...">
                                                    <input type="hidden" name="totalAmm" value="{{ $total }}">
                                                </div>
                                                <div class="clearfix pull-right">
                                                    <input type="submit" value="APPLY COUPON"
                                                        class="btn-upper btn btn-primary">
                                                </div>
                                            </form>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- Right Side: Checkout Form -->
                        <div class="col-md-6 col-sm-12 cart-shopping-total">
                            <div class="card-body" style="margin-top:20px;">
                                <form id="checkout-form" class="form"
                                    action="{{ route('seller.customer.checkout.store') }}" method="post">
                                    @csrf
                                    <div class="table-responsive">
                                        <table class="table">
                                            <!-- Delivery Zone Selection -->
                                            <tr style="width:100%; ">
                                                <div class="col-md-12 form-group mt-3">
                                                    <label class="form-label english_lang" for="name">Full Name
                                                        :</label>
                                                    <label class="form-label bangla_lang" for="name"
                                                        style="display: none;">পুরো নাম :</label>
                                                    <input type="text" name="name" id="name"
                                                        class="form-control">
                                                    <font color="red">
                                                        {{ $errors->has('name') ? $errors->first('name') : '' }}</font>
                                                </div>
                                            </tr>
                                            <tr>
                                                <div class="col-md-6 form-group">
                                                    <label class="english_lang" for="email">Email :</label>
                                                    <label class="bangla_lang" for="email"
                                                        style="display: none;">ইমেইল:</label>
                                                    <input type="email" name="email" id="email"
                                                        class="form-control">
                                                </div>
                                            </tr>

                                            <tr>
                                                <div class="col-md-6 form-group">
                                                    <label for="mobile" class="english_lang">Phone No :</label>
                                                    <label for="mobile" class="bangla_lang" style="display: none;">
                                                        মোবাইল নম্বর :</label>
                                                    <input type="text" name="mobile" id="mobile"
                                                        class="form-control">
                                                    <font color="red">
                                                        {{ $errors->has('mobile') ? $errors->first('mobile') : '' }}</font>
                                                </div>
                                            </tr>
                                            <tr>
                                                <div class="col-md-12 form-group">
                                                    <label for="address" class="english_lang">Full Address :</label>
                                                    <label for="address" class="bangla_lang"
                                                        style="display: none;">পূর্ণ ঠিকানা:</label>

                                                    <textarea name="address" id="address" class="form-control" rows="4"></textarea>
                                                    <font color="red">
                                                        {{ $errors->has('address') ? $errors->first('address') : '' }}
                                                    </font>
                                                </div>
                                            </tr>

                                            <tr>
                                                <th>
                                                    <label for="address" class="english_lang">Delivery Area :</label>
                                                    <label for="address" class="bangla_lang"
                                                        style="display: none;">ডেলিভারি এলাকা:</label>
                                                    @foreach ($deliveryArea as $deliveryzone)
                                                        <div>
                                                            <label for="zone_{{ $deliveryzone->id }}"
                                                                style="width:200px; color:#3a39399f;">
                                                                {{ $deliveryzone->zone_area ?? '' }}
                                                                ({{ $deliveryzone->zone_charge ?? '' }})
                                                            </label>
                                                            <input type="radio" id="zone_{{ $deliveryzone->id }}"
                                                                name="zone_charge"
                                                                value="{{ $deliveryzone->zone_charge }}"
                                                                class="unicase-form-control">
                                                        </div>
                                                    @endforeach
                                                </th>
                                            </tr>

                                            <!-- Totals Section -->
                                            <tr style="width: 300px;">
                                                <th style="width: 300px; text-align: left;">
                                                    <div class="cart-sub-total english_lang">
                                                        Subtotal<span class="inner-left-md" style="float: right;">&#2547;
                                                            {{ number_format($total, 2) }}</span>
                                                    </div>

                                                    @if (Session::get('coupon_discount'))
                                                        <div class="cart-sub-total">
                                                            Coupon Discount<span class="inner-left-md"
                                                                style="float: right;">&#2547;
                                                                {{ Session::get('coupon_discount') }}</span>
                                                        </div>
                                                    @endif

                                                    <div class="cart-sub-total">
                                                        Delivery Charge<span class="inner-left-md" id="delCharge"
                                                            style="float: right;">&#2547; 0.00</span>
                                                    </div>
                                                    <input type="hidden" class="form-control" name="delivery_charge"
                                                        id="delivery_charge" value="" />
                                                    <?php
                                                    $cDiss = Session::get('coupon_discount');
                                                    $deliveryCharged = 0;
                                                    $gTotal = $total - $cDiss;
                                                    ?>

                                                    <div class="cart-grand-total" style="font-weight: bold;">
                                                        Grand Total <span class="inner-left-md grand_total"
                                                            style="float: right;">&#2547;
                                                            {{ number_format($gTotal, 2) }}</span>
                                                    </div>

                                                    <input type="hidden" name="order_total"
                                                        value="{{ $total }}">
                                                    <input type="hidden" name="grand_total"
                                                        value="{{ $gTotal }}">
                                                </th>
                                            </tr>

                                            <!-- Proceed to Checkout Button -->
                                            <tr>
                                                <td>
                                                    <div class="cart-checkout-btn pull-right">
                                                        @if (@Auth::user()->id != null)
                                                            <button type="submit"
                                                                class="btn btn-primary checkout-btn">Confirm To
                                                                Order</button>
                                                        @else
                                                            <a class="btn btn-primary checkout-btn"
                                                                href="{{ route('seller.customer.login') }}">Confirm To
                                                                Order</a>
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </form>
                            </div>

                        </div>
                    </div>

                    <!-- /.cart-shopping-total -->
                </div>
            </div>
            <!-- /.shopping-cart -->
        </div> <!-- /.row -->
        <!-- ================ BRANDS CAROUSEL ================ -->
        @include('frontend.layouts.brand')
        <!-- ============= BRANDS CAROUSEL : END ============= -->
    </div><!-- /.container -->
    </div>

    <!-- /.body-content -->

    <script type="text/javascript">
        $(document).ready(function() {
            // Initialize values
            let orderTotal = parseFloat({{ $total }}); // Original cart total
            let couponDiscount = parseFloat({{ Session::get('coupon_discount', 0) }}); // Coupon discount

            $('input[name="zone_charge"]').change(function() {
                // Get delivery charge
                let deliveryCharge = parseFloat($(this).val()) || 0;
                // Calculate grand total (order_total - coupon_discount + delivery_charge)
                let grandTotal = orderTotal - couponDiscount + deliveryCharge;
                // Update UI
                $('#delCharge').text('৳ ' + deliveryCharge.toFixed(2));
                $('.grand_total').text('৳ ' + grandTotal.toFixed(2));

                // Update hidden fields for form submission
                $('#delivery_charge').val(deliveryCharge);
                $('input[name="grand_total"]').val(grandTotal.toFixed(2));
                $('input[name="order_total"]').val(orderTotal.toFixed(2));
            });
        });
    </script>
    <script>
        $(function() {
            $('.select2').select2();
        });
    </script>
@endsection
