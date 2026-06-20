<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Meta -->
    <meta charset="utf-8" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="" />
    <meta name="author" content="" />
    <meta name="keywords" content="" />
    <meta name="robots" content="all" />
    <title>@yield('title')</title>
    <!-- Bootstrap Core CSS -->
    <link rel="stylesheet" href="{{ asset('frontend') }}/assets/css/bootstrap.min.css" />
    <!-- Customizable CSS -->
    <link rel="icon" type="image/x-icon" href="{{ asset('frontend') }}/images/favicon.ico">
    <link rel="stylesheet" href="{{ asset('frontend') }}/assets/css/main.css" />
    <link rel="stylesheet" href="{{ asset('frontend') }}/assets/css/blue.css" />
    <link rel="stylesheet" href="{{ asset('frontend') }}/assets/owl-carousel/css/owl.carousel.min.css" />
    <link rel="stylesheet" href="{{ asset('frontend') }}/assets/owl-carousel/css/owl.theme.default.min.css" />
    <link rel="stylesheet" href="{{ asset('frontend') }}/assets/css/animate.min.css" />
    <link rel="stylesheet" href="{{ asset('frontend') }}/assets/css/rateit.css" />
    <link rel="stylesheet" href="{{ asset('frontend') }}/assets/css/bootstrap-select.min.css" />
    <link rel="stylesheet" href="{{ asset('css/jquery-ui.css') }}" type="text/css" media="all" />

    <link rel="stylesheet" type="text/css" href="{{ asset('frontend') }}/assets/css/select2.min.css">
    <link rel="stylesheet" href="{{ asset('frontend') }}/assets/css/lightbox.css" />
    <!-- Icons/Glyphs -->
    <link rel="stylesheet" href="{{ asset('frontend') }}/assets/css/font-awesome.css" />
    <link rel="stylesheet" href="{{ asset('frontend') }}/assets/fonts/icofont.min.css" />
    <!-- Fonts -->
    <link href="http://fonts.googleapis.com/css?family=Roboto:300,400,500,700" rel="stylesheet" type="text/css" />
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,300,400italic,600,600italic,700,700italic,800"
        rel="stylesheet" type="text/css" />
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css" />
    <!-- {{-- <script src="{{ asset('frontend') }}/assets/js/jquery-1.11.1.min.js"></script> --}} -->
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
    <script type="text/javascript" src="{{ asset('js/jquery.cookie.min.js') }}"></script>

    <script src="{{ asset('js/notify.min.js') }}"></script>
    @php
        use App\Models\ColorSetting;
        $colors = ColorSetting::getAllColors();
    @endphp
    <style>
        :root {
            --header-bg: {{ $colors['header_bg'] ?? '#0824AC' }};
            --sub-header-bg: {{ $colors['sub_header_bg'] ?? '#0a00a1' }};
            --header-text: {{ $colors['header_text'] ?? '#000000' }};
            --footer-bg: {{ $colors['footer_bg'] ?? '#202020' }};
            --footer-text: {{ $colors['footer_text'] ?? '#ffffff' }};
            --search-icon-bg: {{ $colors['search_icon_bg'] ?? '#007bff' }};
            --search-icon-color: {{ $colors['search_icon_color'] ?? '#ffffff' }};
            --add-to-cart-bg: {{ $colors['add_to_cart_bg'] ?? '#0824ac' }};
            --add-to-cart-text: {{ $colors['add_to_cart_text'] ?? '#ffffff' }};
            --price-color: {{ $colors['price_color'] ?? '#0824AC' }};
            --primary-button: {{ $colors['primary_button'] ?? '#007bff' }};
            --secondary-button: {{ $colors['secondary_button'] ?? '#6c757d' }};
        }
    </style>

    <style type="text/css">
        @media (min-width: 1200px) {

            .container,
            .container-lg,
            .container-md,
            .container-sm,
            .container-xl {
                width: 80%;
                margin: 0 auto;
            }
        }

        .mobile-footer-nav {
            z-index: 2100 !important;
        }

        .notifyjs-corner {
            z-index: 10000 !important;
        }

        .product-slider {
            padding: 15px;
        }

        .product-item-carousel .product {
            padding: 5px;
            border: 1px solid #ddd;
            height: 328px;
            max-height: 329px;
            box-shadow: 0 2px 4px 0 rgba(0, 0, 0, 0.08);
            margin: 0px 5px;
            overflow: hidden;
        }

        .product-item-carousel .product .image button {
            border: none;
            outline: none;
            height: 225px;
            overflow: hidden;
            width: 100%;
        }

        .product-item-carousel .product .image button img {
            height: 100%;
            width: 100%;
        }

        .product .product-info .name {
            margin-top: 10px;
            font-weight: 600;
        }

        .home-ads-banner1,
        .home-ads-banner2 {
            margin-bottom: 15px;
        }

        @media (max-width: 992px) {
            .product-item-carousel .product {
                max-height: 250px;
            }

            .product-item-carousel .product .image button {
                height: 160px;
            }

            .product .cart {
                top: 44%;
                left: 49%;
            }

            .speacial-offers {
                margin: 0 !important;
            }
        }

        @media (max-width: 776px) {
            .product-slider {
                padding: 5px;
            }

            .product-item-carousel .product {
                max-height: 250px;
            }

            .product-item-carousel .product .image button {
                height: 155px;
            }

            .product .cart {
                top: 40%;
                left: 49%;
            }

            .home-ads-banner1 img {
                border-radius: 0px !important;
            }

            .home-ads-banner2 {
                display: none;
            }

            .home-ads-banner1,
            .home-ads-banner2 {
                margin-top: 15px;
            }

            .speacial-offers {
                margin: 0 !important;
            }

            .orderTrackingModal {
                width: 200px;
            }

        }

        @media (max-width: 576px) {
            .product-item-carousel .product {
                max-height: 242px;
            }

            .product-item-carousel .product .image button {
                height: 152px;
            }

            .product .cart {
                top: 15%;
                left: 49%;
            }

            .scroll-tabs {
                margin-bottom: 0px;
            }

            .speacial-offers {
                margin: 0 !important;
            }

            .speacial-offers {
                height: 220 !important;
            }

            #cartModal {
                height: 350px;
            }

            .orderTrackingModal {
                width: 200px;
            }
        }

        @media (max-width: 430px) {
            .owl-wrapper {
                transform: translate3d(0px, 0px, 0px) !important;
                width: 50%;
            }

            .speacial-offers {
                margin: 0 !important;
            }

            .speacial-offers {
                height: 220 !important;
            }

            #cartModal {
                height: 350px;
            }

            .orderTrackingModal {
                width: 200px;
            }
        }

        @media (max-width: 590px) {
            .owl-wrapper {
                transform: translate3d(0px, 0px, 0px) !important;
                width: 50%;
            }

            .speacial-offers {
                margin: 0 !important;
            }

            .speacial-offers {
                height: 220 !important;
            }

            #cartModal {
                height: 350px;
            }

            .orderTrackingModal {
                width: 200px;
            }
        }

        @media (max-width: 725px) {
            .owl-wrapper {
                transform: translate3d(0px, 0px, 0px) !important;
                width: 50%;
            }

            .home-owl-carousel {
                margin-bottom: 0 !important;
            }

            .speacial-offers {
                margin: 0 !important;
            }

            .speacial-offers {
                height: 220 !important;
            }

            .orderTrackingModal {
                width: 200px;
            }
        }

        @media (min-width: 350px) and (max-width: 490px) {
            .owl-wrapper {
                transform: translate3d(0px, 0px, 0px) !important;
                width: 50%;
            }

            .home-owl-carousel {
                margin-bottom: 0 !important;
            }

            .owl-stage-outer.owl-stage {
                height: 300px !important;
            }

            .speacial-offers {
                margin: 0 !important;
            }

            .speacial-offers {
                height: 220 !important;
            }

            #cartModal {
                height: 320px;
            }

            .orderTrackingModal {
                width: 200px;
            }

            #mobile-nav {
                margin-bottom:3% !important;
            }
        }

        @media screen and (max-width: 381px) {
            #policy ul>li {
                margin-bottom: 4px;
            }

            .link {
                margin-bottom: 5px;
            }

            .speacial-offers {
                margin: 0 !important;
            }

            .speacial-offers {
                height: 220 !important;
            }

            #cartModal {
                height: 350px;
            }

            .orderTrackingModal {
                width: 200px;
            }

          
        }

        @media (max-width: 720px) {
            .product-slider.owl-wrapper {
                transform: translate3d(0px, 0px, 0px) !important;
                width: 50%;
            }

            .home-owl-carousel {
                margin-bottom: 0 !important;
            }

            .speacial-offers {
                margin: 0 !important;
            }

            .speacial-offers {
                height: 220 !important;
            }

            .orderTrackingModal {
                width: 200px;
            }


        }

        @media (max-width: 320px) {
            .home-owl-carousel {
                margin-bottom: 0 !important;
            }

            .home-owl-carousel {
                max-height: 300px;
                overflow: hidden;
            }

            .owl-stage {
                display: flex;
                flex-wrap: wrap;
            }

            .speacial-offers {
                margin: 0 !important;
            }

            .speacial-offers {
                height: 220 !important;
            }

            #cartModal {
                height: 300px;
            }

            .orderTrackingModal {
                width: 200px;
            }


        }

        @media screen and (max-width: 381px) {
            #policy ul>li {
                margin-bottom: 4px;
            }

            .link {
                margin-bottom: 5px;
            }

            .speacial-offers {
                margin: 0 !important;
            }

            .speacial-offers {
                height: 220 !important;
            }

            #cartModal {
                height: 350px;
            }

            .orderTrackingModal {
                width: 200px;
            }


        }

        @media screen and (max-width: 481px) {
            #policy ul>li {
                margin-bottom: 4px;
            }

            .link {
                margin-bottom: 5px;
            }

            .speacial-offers {
                margin: 0 !important;
            }

            .speacial-offers {
                height: 220px !important;
            }

            #cartModal {
                height: 350px;
            }

            .orderTrackingModal {
                width: 200px;
            }

            .breadcrumb ul li.active {
                margin-top: 10%;
            }


        }
    </style>
    <style>
        .search-area {
            position: relative;
        }

        #suggestProduct {
            position: absolute;
            top: 100%;
            left: 0;
            width: 100%;
            background: #fff;
            z-index: 999;
            border-radius: 4px;
            margin-top: 2px;
        }

        .product button {
            background: #fff;
        }

        .owl-dots {
            display: none !important;
        }

        .product {
            height: 300px !important;
            margin: 0 !important;
        }

        .product-item-carousel {
            padding: 5px !important;
        }

        .speacial-offers {
            height: 330px !important;
        }

        .speacial-offers img {
            height: 240px !important;
        }

        .arrows-modal {
            display: flex;
            align-items: center;
        }

        .arrows-modal {
            cursor: pointer;
        }
    </style>
    @yield('custom_css')
</head>

<body class="cnt-home">

    <!--End of Tawk.to Script-->
    <!-- ============ HEADER ============= -->

    @include('frontend.layouts.shop_header')

    <!-- ============ HEADER : END ============ -->

    @yield('content')

    <!-- /#top-banner-and-menu -->

    <!-- ============ FOOTER ============ -->

    @include('frontend.layouts.footer')


    {{-- =============== product view  modal ============= --}}
    <!-- Modal -->
    <div class="modal fade" id="shopcartModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">
                        <span id="pname"></span>
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="closeModal">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST" id="CardFormData">

                        <div class="row">
                            <div class="col-md-4">
                                <div class="card" style="width:16rem;">
                                    <img src="" class="card-img-top" id="pimage" alt=""
                                        style="height: 200px;">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <ul class="list-group">
                                    <li class="list-group-item">Price: <strong class="text-danger">&#2547;<span
                                                id="pprice"></span> </strong>
                                        <del id="oldprice">&#2547;</del>
                                    </li>
                                    <li class="list-group-item">Product Code: <strong id="pcode"></strong></li>
                                    <li class="list-group-item">Category: <strong id="pcategory"></strong></li>
                                    <li class="list-group-item">Brand: <strong id="pbrand"></strong> </li>
                                    <li class="list-group-item">Stock: <span class="badge badge-pill badge-success"
                                            id="aviable" style="background:green; color:white;"></span>
                                        <span class="badge badge-pill badge-danger" id="stockout"
                                            style="background:red; color:white;"></span>
                                    </li>
                                </ul>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="color">Select Color</label>
                                    <select class="form-control" id="color" name="color">
                                    </select>
                                </div>
                                <input type="hidden" name="shopID" id="shopID" value="{{ request()->segment(2) }}"/>
                                <div class="form-group" id="sizeArea">
                                    <label for="size">Select Size</label>
                                    <select class="form-control" id="size" name="size">
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="qty">Quantity</label>
                                    <div class="arrows clearfix">
                                        <div class="pull-left arrow minus gradient">
                                            <span class="ir"><i class="fa fa-minus"></i></span>
                                        </div>
                                        <input type="number" class="form-control text-center pull-left" id="qty" value="1" min="1" style="width: 60px;">
                                        <div class="pull-left arrow plus gradient">
                                            <span class="ir"><i class="fa fa-plus"></i></span>
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" id="product_id">
                                <button type="submit" class="btn btn-danger">Add To Cart</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <!-- ============= FOOTER : END ============ -->

    <!-- For demo purposes – can be removed on production -->

    <!-- For demo purposes – can be removed on production : End -->

    <!-- JavaScripts placed at the end of the document so the pages load faster -->

    {{-- <script src="{{ asset('frontend') }}/assets/js/jquery-1.11.1.min.js"></script> --}}
    <script src="{{ asset('frontend') }}/assets/js/bootstrap.min.js"></script>

    <script src="{{ asset('frontend') }}/assets/js/bootstrap-hover-dropdown.min.js"></script>
    <script src="{{ asset('frontend') }}/assets/owl-carousel/js/owl.carousel.min.js"></script>

    <script src="{{ asset('frontend') }}/assets/js/echo.min.js"></script>
    <script src="{{ asset('frontend') }}/assets/js/jquery.easing-1.3.min.js"></script>
    <script src="{{ asset('frontend') }}/assets/js/bootstrap-slider.min.js"></script>
    <script src="{{ asset('frontend') }}/assets/js/jquery.rateit.min.js"></script>
    <script src="{{ asset('frontend') }}/assets/js/lightbox.min.js"></script>
    <script src="{{ asset('frontend') }}/assets/js/bootstrap-select.min.js"></script>
    <script src="{{ asset('frontend') }}/assets/js/wow.min.js"></script>
    <script src="{{ asset('frontend') }}/assets/js/scripts.js"></script>
    <script src="{{ asset('frontend') }}/assets/js/select2.min.js"></script>
    <script>
        $(".js-select2").each(function() {
            $(this).select2({
                minimumResultsForSearch: 20,
                dropdownParent: $(this).next('.dropDownSelect2')
            });
        });
        $(document).ready(function() {
            $(".plus").click(function() {
                let qty = $("#qty");
                let currentVal = parseInt(qty.val());
                if (!isNaN(currentVal)) {
                    qty.val(currentVal + 1);
                }
            });

            $(".minus").click(function() {
                let qty = $("#qty");
                let currentVal = parseInt(qty.val());
                if (!isNaN(currentVal) && currentVal > 1) {
                    qty.val(currentVal - 1);
                }
            });
        });
    </script>

    <script src="{{ asset('frontend') }}/assets/js/sweetalert.min.js"></script>
    <script type="text/javascript" src="{{ asset('js/jquery.cookie.js') }}"></script>
    <script src="{{ asset('backend') }}/plugins/jquery-validation/jquery.validate.min.js"></script>
    <script type="text/javascript" src="{{ asset('backend') }}/toastr/toastr.min.js"></script>

    <script>
        @if (Session::has('message'))
            var type = "{{ Session::get('alert-type', 'info') }}"
            switch (type) {
                case 'info':
                    toastr.info(" {{ Session::get('message') }} ");
                    break;

                case 'success':
                    toastr.success(" {{ Session::get('message') }} ");
                    break;

                case 'warning':
                    toastr.warning(" {{ Session::get('message') }} ");
                    break;

                case 'error':
                    toastr.error(" {{ Session::get('message') }} ");
                    break;
            }
        @endif
    </script>

    @if (session()->has('success'))
        <script type="text/javascript">
            $(function() {
                $.notify("{{ session()->get('success') }}", {
                    globalPosition: 'top right',
                    className: 'success'
                });
            });
        </script>
    @endif
    @if (session()->has('error'))
        <script type="text/javascript">
            $(function() {
                $.notify("{{ session()->get('error') }}", {
                    globalPosition: 'top right',
                    className: 'error'
                });
            });
        </script>
    @endif


    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        })

        //start product view with modal
         function ShopProductView(id) {
            $.ajax({
                type: 'GET',
                url: "{{ url('/product/view/modal/') }}/" + id,
                dataType: 'json',
                success: function(data) {
                    let discount = data.product.discount;
                    let product_price = data.product.price;
                    let discount_price = product_price - discount;
                    $('#pname').text(data.product.name);
                    $('#price').text(data.product.price);
                    $('#pcode').text(data.product.id);
                    $('#pcategory').text(data.product.category.name);
                    $('#pbrand').text(data.product.brand.name);
                    $('#pimage').attr('src', '{{ asset('/upload/product_images') }}/' + data.product.image);
                    $('#product_id').val(id);
                    $('#qty').val(1);
                    //product price
                    if (data.product.discount == null) {
                        $('#pprice').text('');
                        $('#oldprice').text('');
                        $('#pprice').text(data.product.price);
                    } else {
                        $('#pprice').text(discount_price);
                        $('#oldprice').text(data.product.price);
                    }

                    //stock
                    if (data.product.quantity > 0) {
                        $('#aviable').text('');
                        $('#stockout').text('');
                        $('#aviable').text('aviable');
                    } else {
                        $('#aviable').text('');
                        $('#stockout').text('');
                        $('#stockout').text('stockout');
                    }

                    //color
                    $('select[name="color"]').empty();
                    $.each(data.color, function(key, value) {
                        $('select[name="color"]').append('<option value="' + value.color_id + '">' +
                            value.color.name +
                            '</option>')
                    })
                    //size
                    $('select[name="size"]').empty();
                    $.each(data.size, function(key, value) {
                        $('select[name="size"]').append('<option value="' + value.size_id + '">' + value
                            .size.name +
                            '</option>')
                        if (data.size == "") {
                            $('#sizeArea').hide();
                        } else {
                            $('#sizeArea').show();
                        }
                    })
                }
            })
        }
       
        //Start add to cart product
        $('#CardFormData').on('submit', function(event) {
            event.preventDefault();
            var shopID = $('#shopID').val();
            var crproduct_name = $('#pname').text();
            var id = $('#product_id').val();
            var crcolor = $('#color option:selected').val();
            var crsize = $('#size option:selected').val();
            var crquantity = $('#qty').val();
           
            $.ajax({
                url: "{{ url('/cart/seller/data/store/') }}/" + id,
                type: "POST",
                dataType: 'json',
                data: {
                    color: crcolor,
                    shopID: shopID,
                    size: crsize,
                    quantity: crquantity,
                    product_name: crproduct_name
                },
                success: function(data) {
                    console.log(data);
                    $('#closeModal').click();
                    if (data.success) {
                        $.notify(data.success);
                        setTimeout(function() {}, 8000);
                        location.reload();
                    } else {
                        $.notify(data.error);
                        location.reload();
                    }
                }
            });
        });

        //End add to cart product


        function categoryMobile() {
            $(".mobile-header .nav-sidebar").toggleClass("active");
        }
     
    </script>
    <script>
        $("#owl-main").owlCarousel({
            items: 1,
            loop: true,
            autoplay: true,
            autoplayTimeout: 3000,
            autoplayHoverPause: true,
            nav: true,
            dots: false,
        });
        $('.new_productsTab').each(function() {
            var owlhotone = $(this);
            owlhotone.owlCarousel({
                loop: false,
                autoplay: true,
                items: 2,
                dots: false,
                navigation: false,
                pagination: false,
                navigationText: ["", ""],
                responsive: {
                    0: {
                        items: 2
                    },
                    350: {
                        items: 2
                    },
                    380: {
                        items: 2
                    },
                    450: {
                        items: 2
                    },
                    480: {
                        items: 2
                    },
                    556: {
                        items: 3
                    },
                    650: {
                        items: 3
                    },
                    768: {
                        items: 4
                    },
                    1000: {
                        items: 6
                    }
                }
            });
        });
        $('.special_offer_carousel').each(function() {
            var offerone = $(this);
            offerone.owlCarousel({
                loop: false,
                autoplay: true,
                items: 2,
                dots: false,
                navigation: false,
                pagination: false,
                navigationText: ["", ""],
                responsive: {
                    0: {
                        items: 2
                    },
                    350: {
                        items: 2
                    },
                    380: {
                        items: 2
                    },
                    450: {
                        items: 2
                    },
                    480: {
                        items: 2
                    },
                    556: {
                        items: 3
                    },
                    650: {
                        items: 3
                    },
                    768: {
                        items: 4
                    },
                    1000: {
                        items: 6
                    }
                }
            });
        });
        $('.special_deals_err').each(function() {
            var deals = $(this);
            deals.owlCarousel({
                loop: false,
                autoplay: true,
                items: 2,
                dots: false,
                navigation: false,
                pagination: false,
                navigationText: ["", ""],
                responsive: {
                    0: {
                        items: 2
                    },
                    350: {
                        items: 2
                    },
                    380: {
                        items: 2
                    },
                    450: {
                        items: 2
                    },
                    480: {
                        items: 2
                    },
                    556: {
                        items: 3
                    },
                    650: {
                        items: 3
                    },
                    768: {
                        items: 4
                    },
                    1000: {
                        items: 6
                    }
                }
            });
        });
          $('.featuredProducts').each(function() {
            var deals = $(this);
            deals.owlCarousel({
                loop: false,
                autoplay: true,
                items: 2,
                dots: false,
                navigation: false,
                pagination: false,
                navigationText: ["", ""],
                responsive: {
                    0: {
                        items: 2
                    },
                    350: {
                        items: 2
                    },
                    380: {
                        items: 2
                    },
                    450: {
                        items: 2
                    },
                    480: {
                        items: 2
                    },
                    556: {
                        items: 3
                    },
                    650: {
                        items: 3
                    },
                    768: {
                        items: 4
                    },
                    1000: {
                        items: 6
                    }
                }
            });
        });
        $('.categoryProducts').each(function() {
            var catProducts = $(this);
            catProducts.owlCarousel({
                loop: false,
                autoplay: true,
                items: 2,
                dots: false,
                navigation: false,
                pagination: false,
                navigationText: ["", ""],
                responsive: {
                    0: {
                        items: 2
                    },
                    350: {
                        items: 2
                    },
                    380: {
                        items: 2
                    },
                    450: {
                        items: 2
                    },
                    480: {
                        items: 2
                    },
                    556: {
                        items: 3
                    },
                    650: {
                        items: 3
                    },
                    768: {
                        items: 4
                    },
                    1000: {
                        items: 6
                    }
                }
            });
        });
    </script>
    @stack('custom_script')
</body>

</html>
