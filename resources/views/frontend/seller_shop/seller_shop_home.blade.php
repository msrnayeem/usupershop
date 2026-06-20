@extends('frontend.layouts.seller_master')
@section('title')
   U Super Shop
@endsection
@section('content')
    <div class="body-content" id="top-banner-and-menu">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-3" style="padding: 0px 4px;">
                            @php
                                $banners = Helper::bannerImage();
                            @endphp
                            <div class="left_advertisement">
                                <img style="width: 100%;height:360px; border-radius: 0px;"
                                    src="{{ !empty($banners->banner_small_image_one) ? url('upload/banner/' . $banners->banner_small_image_one) : url('upload/slider_images/slider-2.png') }}"
                                    alt="" />
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-6 sliderFixed" style="padding: 0px 4px;">
                            @include('frontend.layouts.slider')
                            <div class="info-boxes wow fadeInUp">
                                <div class="desktop_show">
                                    <div class="info-boxes-inner">

                                        <div class="info-box">
                                            <h4 class="info-box-heading green english_lang">money back</h4>
                                            <h4 style="display:none" class="info-box-heading green bangla_lang">টাকা ফেরত
                                            </h4>

                                            <h6 class="text english_lang">30 Days Money Back Guarantee</h6>
                                            <h6 style="display:none" class="text bangla_lang">৩০ দিনের মধ্যে টাকা ফেরত
                                                নিশ্চয়তা</h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-3" style="padding: 0px 4px;">
                            <div class="right_advertisement">
                                <img style="width: 100%;height:360px; border-radius: 0px;"
                                    src="{{ !empty($banners->banner_small_image_two) ? url('upload/banner/' . $banners->banner_small_image_two) : url('upload/slider_images/slider-1.png') }}"
                                    alt="" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12" style="padding: 0px;">
                    <div class="top-bar animate-dropdown mobile-top-menu" style="margin: 0px;">
                        <div class="header-top-inner">
                            <div class="cnt-account">
                                <ul class="list-unstyled">

                                    <li>
                                        <a class="english_lang" href="{{ route('show.cart') }}"><i
                                                class="icon fa fa-shopping-cart"></i>My Cart</a>
                                        <a class="bangla_lang" style="display:none" href="{{ route('show.cart') }}"><i
                                                class="icon fa fa-shopping-cart"></i>আমার কার্ড</a>
                                    </li>
                                    <li>
                                        <a class="english_lang" href="{{ route('show.cart') }}"><i
                                                class="icon fa fa-check"></i>Checkout</a>
                                        <a class="bangla_lang" style="display:none" href="{{ route('show.cart') }}"><i
                                                class="icon fa fa-check"></i>চেকআউট</a>
                                    </li>
                                    @if (@Auth::user()->id != null && @Auth::user()->usertype == 'customer')
                                        <li>
                                            <a class="english_lang" href="{{ route('dashboard') }}"><i
                                                    class="icon fa fa-user"></i>My Account</a>
                                            <a class="bangla_lang" style="display:none" href="{{ route('dashboard') }}"><i
                                                    class="icon fa fa-user"></i>আমার একাউন্ট</a>
                                        </li>
                                    @endif
                                    @if (@Auth::user()->id != null && @Auth::user()->usertype == 'customer')
                                        <li>
                                            <a class="english_lang" href="{{ route('logout') }}"
                                                onclick="event.preventDefault();
                                            document.getElementById('logout-form').submit();">Logout</a>
                                            <a class="bangla_lang" style="display:none" href="{{ route('logout') }}"
                                                onclick="event.preventDefault();
                                            document.getElementById('logout-form').submit();">লগআউট</a>
                                            <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                                class="d-none">
                                                @csrf
                                            </form>
                                        </li>
                                    @else
                                        <li>
                                            <a class="english_lang" href="{{ route('customer.login') }}"><i
                                                    class="icon fa fa-lock"></i>Login</a>
                                            <a class="bangla_lang" style="display:none"
                                                href="{{ route('customer.login') }}"><i
                                                    class="icon fa fa-lock"></i>লগইন</a>
                                        </li>
                                        <li>
                                            <a class="english_lang" href="{{ route('customer.signup') }}"><i
                                                    class="icon fa fa-user"></i>Register</a>
                                            <a class="bangla_lang" style="display:none"
                                                href="{{ route('customer.signup') }}"><i
                                                    class="icon fa fa-lock"></i>রেজিস্ট্রেশন</a>
                                        </li>
                                    @endif
                                </ul>
                            </div>
                            <!-- /.cnt-account -->

                            <div class="cnt-block">
                                <ul class="list-unstyled list-inline">
                                    <li class="dropdown dropdown-small">
                                        <a class="english_lang" href="{{ route('seller.signup') }}" class="dropdown-toggle"
                                            data-hover="dropdown"><span class="value">Become a Seller</span></a>
                                        <a class="bangla_lang" style="display:none" href="{{ route('seller.signup') }}"
                                            class="dropdown-toggle" data-hover="dropdown"><span class="value">সেলার /
                                                ভেন্ডর</span></a>
                                    </li>
                                    <li class="dropdown dropdown-small">
                                        <a class="english_lang" href="#" class="dropdown-toggle"
                                            data-hover="dropdown" data-toggle="modal" data-target="#exampleModal"><span
                                                class="value">Order
                                                Track</span></a>
                                        <a class="bangla_lang" style="display:none" href="#"
                                            class="dropdown-toggle" data-hover="dropdown" data-toggle="modal"
                                            data-target="#exampleModal"><span class="value">অর্ডার ট্র্যাক</span></a>
                                    </li>
                                    <li class="dropdown dropdown-small">
                                        <a class="english_lang" class="dropdown-toggle" data-hover="dropdown"
                                            data-toggle="dropdown"><span class="value">Language Change
                                            </span><b class="caret"></b></a>
                                        <a class="bangla_lang" style="display: none;" class="dropdown-toggle"
                                            data-hover="dropdown" data-toggle="dropdown"><span class="value">ভাষা
                                                পরিবর্তন করুন
                                            </span><b class="caret"></b></a>
                                        <ul class="dropdown-menu">

                                            <li><a class="changeLng english" style="display:none" lang="english"
                                                    href="#">English</a>
                                            </li>

                                            <li><a class="changeLng bangla" lang="bangla" href="#">বাংলা</a>
                                            </li>

                                        </ul>
                                    </li>
                                </ul>
                                <!-- /.list-unstyled -->
                            </div>
                            <!-- /.cnt-cart -->
                            <!--========== Modal ===========-->
                            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog"
                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal"
                                                aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ route('order.tracksave') }}" method="POST">
                                                @csrf
                                                <div class="form-group">
                                                    <label class="english_lang" for="exampleInputEmail1">Invoice
                                                        No</label>
                                                    <label class="bangla_lang" style="display: none;"
                                                        for="exampleInputEmail1">ইনভয়েস নং</label>
                                                    <input type="text" name="invoice_no" class="form-control"
                                                        id="exampleInputEmail1" aria-describedby="emailHelp"
                                                        placeholder="invoice no...">
                                                </div>
                                                <button type="submit" class="btn btn-primary english_lang">Track
                                                    Now</button>
                                                <button type="submit" class="btn btn-primary bangla_lang"
                                                    style="display: none;">এখন ট্র্যাকিং</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--========== End Modal ===========-->
                            <div class="clearfix"></div>
                        </div>
                        <!-- /.header-top-inner -->
                    </div>

                </div>
            </div>

       

            <div class="row">
                <!-- =================== SIDEBAR ===================== -->
                {{-- @include('frontend.layouts.sidebar') --}}
                <!-- /.sidemenu-holder -->
                <!-- ================= SIDEBAR : END ================= -->
                <!-- ====================== CONTENT ===================== -->
                <div class="col-xs-12 col-sm-12 col-md-12 homebanner-holder"
                    style="padding-left: 5px;padding-right: 5px;">

                    <!-- =============== SCROLL TABS ================ -->
                    @include('frontend.layouts.shop_product_tab')

                    @include('frontend.layouts.shop_special_offer_products')

                  @include('frontend.layouts.shop_special_deals_products')

                    @include('frontend.layouts.shop_featured_product')


                    <div class="row">
                        <div class="col-md-12">
                            <a href="{{ route('speacial.offers') }}">
                                <div class="wide-banner cnt-strip">
                                    <div class="image">
                                        <img style="width:100%; height:100px" class="img-responsive"
                                            src="{{ !empty($banners->category_banner_image) ? url('upload/banner/' . $banners->category_banner_image) : url('frontend/assets/images/banners/home-banner1212.jpg') }}"
                                            alt="" />
                                    </div>

                                    <!-- /.new-label -->
                                </div>
                            </a>

                            <!-- /.wide-banner -->
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->


                    <!-- =============== CATEGORY PRODUCTS ================ -->
                
                 
                   @include('frontend.layouts.shop_category_product')
              


                    <!-- /.section -->
                    <!-- /.scroll-tabs -->


               


                </div>
                <!-- ====================== CONTENT : END =================== -->
            </div>
        </div>
    </div>
@endsection

@push('custom_script')
    <script>
        $('.category-slide').owlCarousel({
            nav: false,
            loop: true,
            margin: 0,
            autoplay: true,
            autoplayTimeout: 3000,
            autoplayHoverPause: true,
            items: 8,
            dots: false,
            // slideBy: 8,
            responsive: {
                0: {
                    items: 4
                },
                568: {
                    items: 4
                },
                768: {
                    items: 6
                },
                1000: {
                    items: 8
                }
            }
            // stagePadding: 50,
            // margin: 10
        });

        $('.categoryProducts').owlCarousel({
            loop: true,
            autoplay: true,
            autoplayTimeout: 2000, // Adjust autoplay speed (3 seconds)
            autoplayHoverPause: false, // Pause autoplay when hovering
            dots: false,
            nav: false, // Updated from `navigation: false`
            pagination: false,
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
      
          

          
           $('.featuredProducts').owlCarousel({
                loop: true, // ✅ Must be true for autoplay to loop
                autoplay: true,
                autoplayTimeout: 2000,
                autoplayHoverPause: false,
                dots: false,
                nav: false,
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
    </script>
    <!--Start of Tawk.to Script-->
    <script type="text/javascript">
        var Tawk_API = Tawk_API || {},
            Tawk_LoadStart = new Date();
        (function() {
            var s1 = document.createElement("script"),
                s0 = document.getElementsByTagName("script")[0];
            s1.async = true;
            s1.src = 'https://embed.tawk.to/67769592af5bfec1dbe5cfa4/1igjjqi4t';
            s1.charset = 'UTF-8';
            s1.setAttribute('crossorigin', '*');
            s0.parentNode.insertBefore(s1, s0);
        })();
    </script>
    <!--End of Tawk.to Script-->
@endpush