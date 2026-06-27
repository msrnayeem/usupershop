@extends('frontend.layouts.master')
@section('title', 'Shopping Cart | ' . config('app.name'))

@section('meta_description',
    'View your shopping cart securely at ' .
    config('app.name') .
    ' — review selected products,
    update quantities, and proceed to checkout safely.')
@section('meta_keywords', 'Shopping Cart, Cart, Checkout, Customer Account, ' . config('app.name'))
@section('meta_author', config('app.name'))

@push('meta')
    {{-- Prevent indexing by search engines --}}
    <meta name="robots" content="noindex, nofollow">

    {{-- Open Graph / Facebook --}}
    <meta property="og:title" content="Shopping Cart - {{ config('app.name') }}" />
    <meta property="og:description"
        content="Review your selected products, update quantities, and proceed to checkout securely at {{ config('app.name') }}." />
    <meta property="og:image" content="{{ asset('frontend/images/og-default.jpg') }}" />
    <meta property="og:url" content="{{ url()->current() }}" />
    <meta property="og:type" content="website" />

    {{-- Twitter Card --}}
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Shopping Cart - {{ config('app.name') }}">
    <meta name="twitter:description"
        content="Review your selected products, update quantities, and proceed to checkout securely at {{ config('app.name') }}.">
    <meta name="twitter:image" content="{{ asset('frontend/images/og-default.jpg') }}">
@endpush

@section('custom_css')
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

        .payment-options .payment-item label:hover,
        .payment-options .payment-item label.active {
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

        .cart-shopping-total {
            padding: 0px;
        }

        .estimate-ship-tax {
            padding: 10px;
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




        }
    </style>
@endsection
@section('content')
    <!-- =============== HEADER : END =================== -->
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class=" breadcrumb" style="padding: 10px 0px;">
                    <div class="breadcrumb-inner">
                        <ul class="list-inline list-unstyled">
                            <li><a href="{{ url('/') }}">Home</a></li>
                            <li class='active'>Shopping Cart</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- /.breadcrumb -->

    <div class="body-content outer-top-xs">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="shopping-cart-table">
                        <div class="cart-wrapper">
                            @php
                                $deliveryArea = Helper::getdeliveryZone();
                            @endphp

                            <div id="preloader" style="display:none; text-align:center;">
                                <span>Loading...</span>
                            </div>

                            <div class="cart-data-items">
                            </div>

                            <div class="cart-footer">
                                <a href="{{ route('product.list') }}" class="btn btn-primary">Continue Shopping</a>
                            </div>

                            <br>

                            <div class="row OrderCheckout">
                                <!-- Left Side: Coupon Section -->
                                <div class="col-md-6 col-sm-12 estimate-ship-tax">
                                    <table class="table">
                                        <tbody>
                                            <tr style="width:100%; ">
                                                <div class="col-md-12 form-group mt-3">
                                                    <label class="form-label english_lang" for="name">Full Name <span
                                                            class="text-danger">*</span></label>
                                                    <label class="form-label bangla_lang" for="name"
                                                        style="display: none;">পুরো নাম <span
                                                            class="text-danger">*</span></label>
                                                    <input type="text" name="name" id="name"
                                                        class="form-control name">
                                                    <span class="text-danger name_error"></span>
                                                </div>
                                            </tr>
                                            <tr>
                                                <div class="col-md-6 form-group">
                                                    <label class="english_lang" for="email">Email <span
                                                            class="text-danger">*</span></label>
                                                    <label class="bangla_lang" for="email" style="display: none;">ইমেইল
                                                        <span class="text-danger">*</span></label>
                                                    <input type="email" name="email" id="email"
                                                        class="form-control email">
                                                    <span class="text-danger email_error"></span>
                                                </div>
                                            </tr>

                                            <tr>
                                                <div class="col-md-6 form-group">
                                                    <label for="mobile" class="english_lang">Phone No <span
                                                            class="text-danger">*</span></label>
                                                    <label for="mobile" class="bangla_lang" style="display: none;">
                                                        মোবাইল নম্বর <span class="text-danger">*</span></label>
                                                    <input type="text" name="mobile" id="mobile"
                                                        class="form-control mobile">
                                                    <span class="text-danger mobile_error"></span>
                                                </div>
                                            </tr>
                                            <tr>
                                                <div class="col-md-12 form-group">
                                                    <label for="address" class="english_lang">Full Address <span
                                                            class="text-danger">*</span></label>
                                                    <label for="address" class="bangla_lang" style="display: none;">পূর্ণ
                                                        ঠিকানা <span class="text-danger">*</span></label>

                                                    <textarea name="address" id="address" class="form-control address" rows="4"></textarea>
                                                    <span class="text-danger address_error"></span>
                                                </div>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                                <!-- Right Side: Checkout Form -->
                                <div class="col-md-6 col-sm-12 cart-shopping-total">
                                    <div class="card-body" style="margin-top:20px;">
                                        <table class="table">

                                            <tr>
                                                <th style="border-top: none;">
                                                    <span class="estimate-title english_lang">Discount Code</span>
                                                    <span class="estimate-title bangla_lang"
                                                        style="display: none;">ডিসকাউন্ট
                                                        কোড</span>
                                                    <p class="english_lang">Enter your coupon code if you have one..</p>
                                                    <p class="bangla_lang" style="display: none;">আপনার কুপন কোড থাকলে তা
                                                        লিখুন..
                                                    </p>
                                                </th>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <form method="post" action="{{ route('save.coupon') }}">
                                                        @csrf
                                                        <div class="form-group" style="position: relative;">
                                                            <input type="text"
                                                                class="form-control unicase-form-control text-input"
                                                                id="coupon_code" name="coupon_code"
                                                                placeholder="Coupon Code...">
                                                            <input type="hidden" name="totalAmm" class="totalAmm"
                                                                value="0">

                                                            <input type="submit" value="APPLY"
                                                                class="btn-upper btn btn-primary"
                                                                style="position: absolute; right: 0; top: 1px; padding: 9px 15px;">
                                                        </div>
                                                    </form>
                                                </td>
                                            </tr>
                                            <!-- Delivery Zone Selection -->

                                            <tr>
                                                <th>
                                                    <label for="address" class="english_lang">Delivery Area <span
                                                            class="text-danger">*</span></label>
                                                    <label for="address" class="bangla_lang"
                                                        style="display: none;">ডেলিভারি এলাকা <span
                                                            class="text-danger">*</span></label>
                                                    @foreach ($deliveryArea as $i => $deliveryzone)
                                                        <div>
                                                            <label for="zone_{{ $deliveryzone->id }}"
                                                                style="width:200px; color:#3a39399f;">
                                                                {{ $deliveryzone->zone_area ?? '' }}
                                                                ({{ $deliveryzone->zone_charge ?? '' }})
                                                            </label>
                                                            <input type="radio" id="zone_{{ $deliveryzone->id }}"
                                                                name="zone_charge"
                                                                value="{{ $deliveryzone->zone_charge }}"
                                                                class="unicase-form-control"
                                                                area-id="{{ $deliveryzone->id }}">


                                                        </div>
                                                    @endforeach
                                                    <input type="hidden" name="delivery_area_id"
                                                        class="delivery_area_id" value="0">
                                                    <div class="alert alert-danger delivery_area_error_alert"
                                                        style="display: none;">
                                                        <span class="delivery_area_error"></span>
                                                    </div>
                                                </th>
                                            </tr>

                                            <!-- Totals Section -->
                                            <tr style="width: 300px;">
                                                <th style="width: 300px; text-align: left;">
                                                    <div class="cart-sub-total english_lang">
                                                        Subtotal<span class="inner-left-md " style="float: right;">&#2547;
                                                            <span class="total_subtotal_amount">0.00</span>
                                                        </span>
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
                                                    ?>

                                                    <div class="cart-grand-total" style="font-weight: bold;">
                                                        Grand Total <span class="inner-left-md grand_total"
                                                            style="float: right;">&#2547;
                                                            <span class="grand_total_text">0.00</span></span>
                                                    </div>

                                                    <input type="hidden" name="order_total" class="order_total_amount"
                                                        value="0">
                                                    <input type="hidden" name="grand_total" class="grand_total_amount"
                                                        value="0">
                                                </th>
                                            </tr>

                                            <tr>
                                                <td>
                                                    <div class="alert alert-danger text-center"
                                                        style="margin-bottom: 0px;">
                                                        <strong>Pay your delivery charge to confirm the order.</strong>
                                                        <br>
                                                        <strong>অর্ডার কনফার্ম করার জন্য আপনার ডেলিভারি চার্জ পেমেন্ট
                                                            করুন</strong>
                                                    </div>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td>
                                                    <div class="payment-options">
                                                        <div class="payment-item">
                                                            <label for="cash_on_delivery">
                                                                <img class="img-fluid"
                                                                    src="{{ asset('/') }}frontend/cash-on-delivery.png"
                                                                    alt="cash on delivery" style="margin-top: 10px;">
                                                            </label>
                                                            <input type="radio" id="cash_on_delivery"
                                                                class="payment_method" name="payment_method"
                                                                value="cod">
                                                        </div>

                                                        <div class="payment-item">
                                                            <label for="bkash">
                                                                <img class="img-fluid"
                                                                    src="{{ asset('/') }}frontend/bkash.png"
                                                                    alt="bKash">
                                                            </label>
                                                            <input type="radio" id="bkash" class="payment_method"
                                                                name="payment_method" value="bkash">
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>

                                            <!-- Proceed to Checkout Button -->

                                            <tr>
                                                <td>
                                                    <div class="cart-checkout-btn pull-right">
                                                        <div style="display: flex; gap: 10px; flex-wrap: wrap; justify-content: flex-end; align-items: center;">
                                                            <button type="button" class="btn btn-primary checkout-btn"
                                                                style="padding: 10px 15px;" onclick="checkoutBtn('guest');">Order as Guest</button>
                                                            <a href="{{ route('customer.login') }}" class="btn btn-outline-success"
                                                                style="padding: 10px 15px;">Login / Register</a>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- /.body-content -->
@endsection

@push('custom_script')
    <script type="text/javascript">
        $('input[name="zone_charge"]').change(function() {
            var delivery_area_id = $(this).attr('area-id');
            $('.delivery_area_id').val(delivery_area_id);
            updateGrandTotalAmount();
        });
        $(function() {
            $('.select2').select2();
        });
        $(document).ready(function() {
            getCartData();
        });

        function updateSubTotal() {
            var totalSubTotal = 0;
            $(".total_product_price").each(function() {
                totalSubTotal += parseFloat($(this).val()) || 0;
            });
            return totalSubTotal;
        }

        function updateGrandTotalAmount() {
            let orderTotal = updateSubTotal();
            let couponDiscount = parseFloat({{ Session::get('coupon_discount', 0) }}) || 0;
            // Get delivery charge
            let deliveryCharge = parseFloat($('input[name="zone_charge"]:checked').val()) || 0;
            // Calculate grand total (order_total - coupon_discount + delivery_charge)
            let grandTotal = orderTotal - couponDiscount + deliveryCharge;
            // Update UI
            $('#delCharge').text('৳ ' + deliveryCharge.toFixed(2));
            $('.grand_total').text('৳ ' + grandTotal.toFixed(2));

            // Update hidden fields for form submission
            $('#delivery_charge').val(deliveryCharge);
            $('input[name="grand_total"]').val(grandTotal.toFixed(2));
            $('input[name="order_total"]').val(orderTotal.toFixed(2));


            $('.total_subtotal_amount').text(orderTotal.toFixed(2));
            $('.order_total_amount').val(orderTotal);
            $('.totalAmm').val(orderTotal);

            $('.grand_total_text').text(grandTotal.toFixed(2));
            $('.grand_total_amount').val(grandTotal);
        }

        function getCartData() {
            $('#preloader').show();

            var url = "{{ route('cart.customer.customerCartData') }}";
            $.ajax({
                type: "GET",
                dataType: 'json',
                url: url,
                success: function(res) {
                    $('#preloader').hide();
                    $('.cart-data-items').html('');
                    var subtotal_amount = 0;
                    var html = '';

                    if (res.length > 0) {
                        res.forEach(function(content) {
                            // Price per unit (already discounted + variant price)
                            var price = parseFloat(content.product.price);
                            // Total price for this cart row
                            var line_total = price * parseInt(content.qty);

                            // Add to subtotal
                            subtotal_amount += line_total;

                            html += `
                        <div class="cart-row">
                            <div class="cart-product">
                                <div class="product-image" style="margin-right: 5px;">
                                    <img src="${content.product.image}" alt="">
                                </div>
                                <div class="product-info">
                                    <h4>${content.product.name.length > 20 ? content.product.name.substring(0, 20) + '...' : content.product.name}</h4>
                                    <p><strong>Color : </strong> ${content.color_name || 'N/A'}</p>
                                    <p><strong>Size : </strong> ${content.size_name || 'N/A'}</p>
                                    <p><strong>Price :</strong> &#2547; ${price.toFixed(2)}</p>
                                </div>
                            </div>

                            <input type="hidden" class="product_id" name="product_id[]" value="${content.product.id}">
                            <input type="hidden" class="product_price" name="product_price[]" value="${price}">
                            <input type="hidden" class="total_product_price" name="total_product_price[]" value="${line_total}">
                            <input type="hidden" name="rowId[]" class="cart_id" value="${content.id}">

                            <div class="cart-quantity cart-item" data-price="${price}">
                                <button class="qty-minus" id="decrement"><i class="fa fa-minus" aria-hidden="true"></i></button>
                                <input type="text" class="qty-input quantity_row" name="qty[]" value="${content.qty}" readonly>
                                <button class="qty-plus" id="increment"><i class="fa fa-plus" aria-hidden="true"></i></button>
                                
                                <div class="cart-subtotal">Price : &#2547; <span class="total_product_price_show">${line_total.toFixed(2)}</span></div>
                            </div>

                            <a href="javascript:void(0);" onclick="destroyCart(${content.id})" class="delete-btn">
                                <i class="fa fa-times"></i>
                            </a>
                        </div>
                    `;
                        });
                    } else {
                        html = `
                    <div class="empty-cart-message">
                        <h4 class="text-danger">Cart is Empty... !!!</h4>
                    </div>
                `;
                    }

                    $('.cart-data-items').html(html);

                    // Update grand total (you should have this function)
                    if (typeof updateGrandTotalAmount === "function") {
                        updateGrandTotalAmount(subtotal_amount);
                    }
                },
                error: function() {
                    error_msg('Something went wrong!');
                    $('#preloader').hide();
                    $('.cart-data-items').html(`
                <div class="empty-cart-message">
                    <h4 class="text-danger">Cart is Empty... !!!</h4>
                </div>
            `);
                }
            });
        }


        function destroyCart(cart_id) {
            if (cart_id) {
                $('#preloader').show();
                var url = "{{ route('cart.customer.customerCartDestroy', ['cart_id' => ':cart_id']) }}";
                url = url.replace(':cart_id', cart_id);

                $.ajax({
                    type: "GET",
                    dataType: 'json',
                    url: url,
                    success: function(res) {
                        $('#preloader').hide();
                        if (res.status == true) {
                            success_msg('' + res.message);
                            getCartData();
                        } else {
                            error_msg('' + res.message);
                        }
                    },
                    error: function() {
                        $('#preloader').hide();
                        error_msg('Something went wrong!');
                    }
                });
            }
        }

        $('.payment-options .payment-item label').click(function() {
            $('.payment-options .payment-item label').removeClass('active');
            $(this).addClass('active');
        });

        $(document).on("click", "#decrement", function() {
            var row = $(this).closest(".cart-row");
            var product_id = parseInt(row.find(".product_id").val()) || 0;
            var quantity_row = parseInt(row.find(".quantity_row").val()) || 0;
            var product_price = parseFloat(row.find(".product_price").val()) || 0;
            var cart_id = parseFloat(row.find(".cart_id").val()) || 0;
            if (quantity_row > 1) {
                var result_qty = parseInt(quantity_row - 1);
                row.find(".quantity_row").val(result_qty);
                row.find(".total_product_price").val((product_price * result_qty));
                row.find(".total_product_price_show").text((product_price * result_qty).toFixed(2));
                updateGrandTotalAmount();
                updateCookie(cart_id, result_qty);
            }
        });

        $(document).on("click", "#increment", function() {
            var row = $(this).closest(".cart-row");
            var product_id = parseInt(row.find(".product_id").val()) || 0;
            var quantity_row = parseInt(row.find(".quantity_row").val()) || 0;
            var product_price = parseFloat(row.find(".product_price").val()) || 0;
            var cart_id = parseFloat(row.find(".cart_id").val()) || 0;
            var result_qty = parseInt(quantity_row + 1);
            row.find(".quantity_row").val(result_qty);
            row.find(".total_product_price").val((product_price * result_qty));
            row.find(".total_product_price_show").text((product_price * result_qty).toFixed(2));
            updateGrandTotalAmount();
            updateCookie(cart_id, result_qty);
        });

        function updateCookie(cart_id, qty) {
            url = "{{ route('cart.customer.customerCartUpdate') }}";
            $.ajax({
                type: "POST",
                dataType: "json",
                data: {
                    cart_id: cart_id,
                    qty: qty,
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                url: url,
                success: function(res) {
                    getCartData();
                }
            });
        }

        function checkoutBtn(mode = 'guest') {
            var name = $('.OrderCheckout .name').val();
            var email = $('.OrderCheckout .email').val();
            var mobile = $('.OrderCheckout .mobile').val();
            var address = $('.OrderCheckout .address').val();
            var delivery_area = $('.OrderCheckout .delivery_area_id').val();
            var payment_method = $('.OrderCheckout .payment_method:checked').val();

            var mobileRegex = /^[0-9]{11}$/;
            var gmailRegex = /^[a-zA-Z0-9._%+-]+@gmail\.com$/;

            // Clear previous errors
            $('.OrderCheckout .name_error').text('');
            $('.OrderCheckout .email_error').text('');
            $('.OrderCheckout .mobile_error').text('');
            $('.OrderCheckout .address_error').text('');

            let errors = {};

            // Required field checks
            if (!name) errors.name = "Name is required.";
            if (!email) errors.email = "Email is required.";
            if (!mobile) errors.mobile = "Mobile number is required.";
            if (!address) errors.address = "Address is required.";
            if (!delivery_area) errors.delivery_area = "Delivery area is required.";
            if (delivery_area == 0) errors.delivery_area = "Delivery area is required.";
            if (!payment_method) errors.payment_method = "Payment method is required.";

            // Format validations
            if (mobile && !mobileRegex.test(mobile)) {
                errors.mobile = "Mobile number must be exactly 11 digits.";
            }

            if (email && !gmailRegex.test(email)) {
                errors.email = "Please enter a valid Gmail address (e.g. example@gmail.com).";
            }

            if (Object.keys(errors).length > 0) {
                // Display errors
                if (errors.name) $('.OrderCheckout .name_error').text(errors.name);
                if (errors.email) $('.OrderCheckout .email_error').text(errors.email);
                if (errors.mobile) $('.OrderCheckout .mobile_error').text(errors.mobile);
                if (errors.address) $('.OrderCheckout .address_error').text(errors.address);
                if (errors.delivery_area) error_msg('' + errors.delivery_area);
                if (errors.payment_method) error_msg('' + errors.payment_method);

                return;
            }

            if (mode !== 'guest' && !{{ auth()->check() && (auth()->user()->usertype === 'customer' || auth()->user()->usertype === 'dropshipper') ? 'true' : 'false' }}) {
                // Guest allowed — proceed as guest checkout
                mode = 'guest';
            }

            var url = mode === 'guest' ? "{{ route('guest.order.checkout') }}" : "{{ route('customer.order.checkout') }}";

            $.ajax({
                type: "POST",
                dataType: "json",
                data: {
                    name: name,
                    email: email,
                    mobile: mobile,
                    address: address,
                    delivery_area: delivery_area,
                    delivery_zone: delivery_area,
                    payment_method: payment_method,
                    guest_checkout: mode === 'guest' ? 1 : 0,
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                url: url,
                success: function(res) {
                    if (res.status == true) {
                        success_msg('' + res.message);
                        setTimeout(() => {
                            window.location.href = res.url;
                        }, 1000);

                    } else {
                        // Show error message for failed checkout
                        error_msg('' + res.message);
                        
                        // Optional: Display detailed error if available
                        if (res.error_msg) {
                            console.error('Checkout Error Details:', res.error_msg);
                        }
                        
                        setTimeout(() => {
                            if (res.type === 'auth') {
                                window.location.href = "{{ route('customer.login') }}";
                            } else if (res.type === 'delivery_area') {
                                window.location.href = "{{ route('show.cart') }}";
                            } else if (res.type === 'stock') {
                                window.location.href = "{{ route('show.cart') }}";
                            } else if (res.type === 'cart') {
                                window.location.href = "{{ route('show.cart') }}";
                            }
                            // Don't redirect on general errors, let user retry
                        }, 2000);
                    }
                },
                error: function(error) {
                    if (error.status === 422) {
                        var response = error.responseJSON;
                        if (response && response.errors) {
                            $.each(response.errors, function(key, messages) {
                                $.each(messages, function(index, msg) {
                                    error_msg(msg);
                                });
                            });
                        } else if (response && response.message) {
                            error_msg(response.message);
                        } else {
                            error_msg('Validation error occurred.');
                        }
                    } else if (error.statusText === "Unauthorized" || error.status === 401) {
                        warning_msg('Customer Login Required!');
                        setTimeout(() => {
                            window.location.href = "{{ route('customer.login') }}";
                        }, 1000);
                    } else {
                        console.log('Checkout error:', error);
                        error_msg('Something went wrong. Please try again.');
                    }
                }


            });
        }
    </script>
@endpush
