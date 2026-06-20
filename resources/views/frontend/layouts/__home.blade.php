@extends('frontend.layouts.master')
@section('title')
    U Super Shop
@endsection
@section('content')
    <div class="body-content outer-top-xs" id="top-banner-and-menu">
        <div class="container-fluide">
            
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-2">
                            <img style="width:100%;height:450px;" src="https://img.ltwebstatic.com/images3_pi/2024/08/27/9f/1724740839d2574128381b6cab54d41008d7baafeb_wk_1729993310_thumbnail_336x.webp" alt="" />
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-8">
                            @include('frontend.layouts.slider')
                            @include('frontend.layouts.info')
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-2">
                            <img style="width:100%;height:450px;" src="https://img.ltwebstatic.com/images3_pi/2024/06/13/7f/17182633162a1bc395360a66c07a72b7bc70d23a5d_thumbnail_405x552.webp" alt="" />
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="wide-banners wow fadeInUp outer-bottom-xs">
                            <div class="row">
                                <div style="padding-top:40px;padding-left:60px">
                                @php
                                    $categories = App\Models\Category::orderBy('id', 'DESC')->get();
                                @endphp
                                @foreach ($categories as $category)
                                    <div style="margin-right:40px;clear:right;float:left;">
                                        <a href="{{ route('category.wise.product', $category->id) }}">
                                        <img style="width:140px;height:140px; background:#fff;padding:8px; border: 1px solid #000;" class="img-circle"
                                            src="{{ !empty($category->image) ? url('upload/category_images/' . $category->image) : url('frontend/no-image-icon.jpg') }}" alt="" />
                                            <h5 style="text-align:center;margin-bottom:40px;">{{ $category->name }}</h5>
                                        </a>
                                    </div>
                                @endforeach
                               
                                </div>
                            </div>
                            <!-- /.row -->
                        </div>
                </div>
            </div>
            
            <div class="row">
                <!-- =================== SIDEBAR ===================== -->
                @include('frontend.layouts.sidebar')
                <!-- /.sidemenu-holder -->
                <!-- ================= SIDEBAR : END ================= -->
                <!-- ======================== CONTENT ======================= -->
                <div class="col-xs-12 col-sm-12 col-md-9 homebanner-holder">
                    
                    <!-- =============== SCROLL TABS ================ -->
                    @include('frontend.layouts.product_tab')
                    <!-- /.scroll-tabs -->
                    <!-- ============== SCROLL TABS : END ============== -->
                    <!-- =============== WIDE PRODUCTS ================= -->
                    <div class="wide-banners wow fadeInUp outer-bottom-xs">
                        <div class="row">
                            <div class="col-md-7 col-sm-7">
                                <div class="wide-banner cnt-strip">
                                    <div class="image">
                                        <img style="width:100%; height:120px" class="img-responsive"
                                            src="{{ asset('frontend') }}/assets/images/banners/food-animation.gif"
                                            alt="" />
                                    </div>
                                </div>
                                <!-- /.wide-banner -->
                            </div>
                            <!-- /.col -->
                            <div class="col-md-5 col-sm-5">
                                <div class="wide-banner cnt-strip">
                                    <div class="image">
                                        <img style="width:100%; height:120px" class="img-responsive"
                                            src="{{ asset('frontend') }}/assets/images/banners/home-banner2.jpg"
                                            alt="" />
                                    </div>
                                </div>
                                <!-- /.wide-banner -->
                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- /.row -->
                    </div>
                    <!-- /.wide-banners -->

                    <!-- ============== WIDE PRODUCTS : END =============== -->
                    <!-- =============== FEATURED PRODUCTS ================ -->
                    @include('frontend.layouts.featured_product')
                    <!-- /.section -->
                    <!-- ============= FEATURED PRODUCTS : END ============ -->

                    <!-- =============== CATEGORY PRODUCTS ================ -->
                    @include('frontend.layouts.category_product')
                    <!-- /.section -->
                    <!-- ============ CATEGORY PRODUCTS : END ============= -->

                    <!-- ================== WIDE PRODUCTS ================= -->
                    <div class="wide-banners wow fadeInUp outer-bottom-xs">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="wide-banner cnt-strip">
                                    <div class="image">
                                        <img style="width:100%; height:120px" class="img-responsive"
                                            src="{{ asset('frontend') }}/assets/images/banners/home-banner1212.jpg"
                                            alt="" />
                                    </div>
                                    <div class="strip strip-text">
                                        <div class="strip-inner">
                                            <h2 class="text-right">
                                                New Mens Fashion<br />
                                                <span class="shopping-needs">Save up to 20% off</span>
                                            </h2>
                                        </div>
                                    </div>
                                    <!--<div class="new-label">
                                        <div class="text">NEW</div>
                                    </div>-->
                                    <!-- /.new-label -->
                                </div>
                                <!-- /.wide-banner -->
                            </div>
                            <!-- /.col -->
                        </div>
                        <!-- /.row -->
                    </div>
                    <!-- /.wide-banners -->
                    <!-- ================ WIDE PRODUCTS : END =============== -->
                    <!-- ================== BEST SELLER ===================== -->
                    @include('frontend.layouts.best_sale')
                    <!-- /.sidebar-widget -->
                    <!-- =============== BEST SELLER : END ================== -->
    
                </div>
                <!-- /.homebanner-holder -->
                <!-- ====================== CONTENT : END =================== -->
            </div>
            <!-- /.row -->
            <!-- ================ BRANDS CAROUSEL =============== -->
            @include('frontend.layouts.brand')
            <!-- /.logo-slider -->
            <!-- ============= BRANDS CAROUSEL : END ============ -->
        </div>
        <!-- /.container -->
    </div>
@endsection
