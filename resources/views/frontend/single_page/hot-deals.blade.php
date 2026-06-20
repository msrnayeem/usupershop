@extends('frontend.layouts.master')
@section('title', 'Hot Deals | ' . config('app.name'))

@section('meta_description', 'Discover the latest hot deals at ' . config('app.name') . ' — grab discounts on groceries, cosmetics, healthcare, baby products, and more. Limited time offers, shop now!')
@section('meta_keywords', 'Hot Deals, Discounts, Offers, Sale, Special Deals, ' . config('app.name'))
@section('meta_author', config('app.name'))

@push('meta')
    {{-- Open Graph / Facebook --}}
    <meta property="og:title" content="Hot Deals - {{ config('app.name') }}" />
    <meta property="og:description" content="Grab the latest hot deals on groceries, cosmetics, healthcare, baby products, and more at {{ config('app.name') }}. Limited time offers!" />
    <meta property="og:image" content="{{ asset('frontend/images/og-default.jpg') }}" />
    <meta property="og:url" content="{{ url()->current() }}" />
    <meta property="og:type" content="website" />

    {{-- Twitter Card --}}
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Hot Deals - {{ config('app.name') }}">
    <meta name="twitter:description" content="Grab the latest hot deals on groceries, cosmetics, healthcare, baby products, and more at {{ config('app.name') }}. Limited time offers!">
    <meta name="twitter:image" content="{{ asset('frontend/images/og-default.jpg') }}">
@endpush

@section('content')
    <div class="breadcrumb">
        <div class="container">
            <div class="breadcrumb-inner">
                <ul class="list-inline list-unstyled">
                    <li><a href="{{ url('./') }}">Home</a></li>
                    <li class='active'>Hot Deals</li>
                </ul>
            </div><!-- /.breadcrumb-inner -->
        </div><!-- /.container -->
    </div><!-- /.breadcrumb -->
    <div class="body-content outer-top-xs">
        <div class='container-fluid'>
            <div class='row'>
                <div class='col-md-3 sidebar'>
                    <!-- ============ TOP NAVIGATION ============== -->
                    <div class="side-menu animate-dropdown outer-bottom-xs">
                        <div class="head english_lang"><i class="icon fa fa-align-justify fa-fw"></i> Categories</div>
                        <div class="head bangla_lang" style="display: none;"><i class="icon fa fa-align-justify fa-fw"></i>
                            ক্যাটাগোরি</div>
                        <nav class="yamm megamenu-horizontal" role="navigation">
                            <ul class="nav">
                                @php
                                    $categories = Helper::getCategories();
                                @endphp
                                @foreach ($categories as $category)
                                    <li class="dropdown menu-item">
                                        <a class="english_lang"
                                            href="{{ route('category.wise.product', $category->category_id) }}"><i
                                                class="icon fa fa-{{ $category['category']['cat_icon'] }}"></i>
                                            {{ $category['category']['name'] }}
                                        </a>

                                        <a class="bangla_lang" style="display: none"
                                            href="{{ route('category.wise.product', $category->category_id) }}"><i
                                                class="icon fa fa-{{ $category['category']['cat_icon'] }}"></i>
                                            {{ $category['category']['name_bn'] }}
                                        </a>
                                        <!-- /.dropdown-menu -->
                                    </li>
                                @endforeach
                            </ul><!-- /.nav -->
                        </nav><!-- /.megamenu-horizontal -->
                    </div><!-- /.side-menu -->
                    <!-- ============ TOP NAVIGATION : END ============ -->
                    <div class="sidebar-module-container">
                        <div class="sidebar-filter">
                            <!-- ============== Testimonials ================ -->
                            <div class="sidebar-widget  wow fadeInUp outer-top-vs ">
                                <div id="advertisement" class="advertisement">
                                    <div class="item">
                                        <div class="avatar"><img
                                                src="{{ asset('frontend') }}/assets/images/testimonials/member1.png"
                                                alt="Image"></div>
                                        <div class="testimonials"><em>"</em> Vtae sodales aliq uam morbi non sem lacus port
                                            mollis. Nunc condime tum metus eud molest sed consectetuer.<em>"</em></div>
                                        <div class="clients_author">John Doe <span>Abc Company</span> </div>
                                        <!-- /.container-fluid -->
                                    </div><!-- /.item -->

                                    <div class="item">
                                        <div class="avatar"><img
                                                src="{{ asset('frontend') }}/assets/images/testimonials/member3.png"
                                                alt="Image"></div>
                                        <div class="testimonials"><em>"</em>Vtae sodales aliq uam morbi non sem lacus port
                                            mollis. Nunc condime tum metus eud molest sed consectetuer.<em>"</em></div>
                                        <div class="clients_author">Stephen Doe <span>Xperia Designs</span> </div>
                                    </div><!-- /.item -->

                                    <div class="item">
                                        <div class="avatar"><img
                                                src="{{ asset('frontend') }}/assets/images/testimonials/member2.png"
                                                alt="Image"></div>
                                        <div class="testimonials"><em>"</em> Vtae sodales aliq uam morbi non sem lacus port
                                            mollis. Nunc condime tum metus eud molest sed consectetuer.<em>"</em></div>
                                        <div class="clients_author">Saraha Smith <span>Datsun &amp; Co</span> </div>
                                        <!-- /.container-fluid -->
                                    </div><!-- /.item -->
                                </div><!-- /.owl-carousel -->
                            </div>
                            <!-- ============= Testimonials END ============= -->

                            <div class="home-banner">
                                <a href=""><img src="{{ asset('frontend') }}/assets/images/banners/app_download.gif" alt="Image" /></a>
                            </div>

                        </div><!-- /.sidebar-filter -->
                    </div><!-- /.sidebar-module-container -->
                </div><!-- /.sidebar -->
                <div class='col-md-9'>
                    <!-- ============ SECTION – HERO =========== -->

                    <div id="category" class="category-carousel hidden-xs">
                        <div class="item">
                            <div class="image">
                                <img style="width: 100%;height:200px" src="{{ asset('frontend') }}/assets/images/banners/order_animation.jpg" alt="" class="img-responsive">
                            </div>
                        </div>
                    </div>

                    <!-- ================ SECTION – HERO : END ============== -->
                    <div class="clearfix filters-container m-t-10">
                        <div class="row">
                            <div class="col col-sm-6 col-md-2">
                                <div class="filter-tabs">
                                    <ul id="filter-tabs" class="nav nav-tabs nav-tab-box nav-tab-fa-icon">
                                        <li class="active">
                                            <a data-toggle="tab" href="#grid-container"><i
                                                    class="icon fa fa-th-large"></i>Grid</a>
                                        </li>
                                        <li><a data-toggle="tab" href="#list-container"><i
                                                    class="icon fa fa-th-list"></i>List</a></li>
                                    </ul>
                                </div><!-- /.filter-tabs -->
                            </div><!-- /.col -->
                            <div class="col col-sm-12 col-md-6">
                                <div class="col col-sm-3 col-md-6 no-padding">

                                </div><!-- /.col -->
                                <div class="col col-sm-3 col-md-6 no-padding">
                                    
                                </div><!-- /.col -->
                            </div><!-- /.col -->
                            <div class="col col-sm-6 col-md-4 text-right">
                                <div class="lbl-cnt">
                                    <span class="lbl">Sort by</span>
                                    <div class="fld inline">
                                        <select class="form-control" name="sortBy" onchange="this.form.submit();">
                                            <option value="">Sort By Products</option>
                                            <option value="priceLowtoHigh"
                                                @if (!empty($_GET['sortBy']) && $_GET['sortBy'] == 'priceLowtoHigh') selected @endif>Price:Lower to Higher
                                            </option>
                                            <option value="priceHightoLow"
                                                @if (!empty($_GET['sortBy']) && $_GET['sortBy'] == 'priceHightoLow') selected @endif>Price:Higher to Lower
                                            </option>
                                            <option value="nameAtoZ" @if (!empty($_GET['sortBy']) && $_GET['sortBy'] == 'nameAtoZ') selected @endif>
                                                Product Name:A to Z
                                            </option>
                                            <option value="nameZtoA" @if (!empty($_GET['sortBy']) && $_GET['sortBy'] == 'nameZtoA') selected @endif>
                                                Product Name:Z to A
                                            </option>
                                        </select>
                                    </div><!-- /.fld -->
                                </div><!-- /.lbl-cnt -->
                            </div><!-- /.col -->
                        </div><!-- /.row -->
                    </div>
                    <div class="search-result-container ">
                        <div id="myTabContent" class="tab-content category-list">
                            <div class="tab-pane active " id="grid-container">
                                <div class="category-product">
                                    <div class="row">
                                        @foreach ($products as $product)
                                            <div class="col-sm-6 col-md-3 wow fadeInUp">
                                                <div class="products">
                                                    <div class="product">
                                                        <div class="product-image">
                                                            <div class="image">
                                                                <a
                                                                    href="{{ route('product.details.info', $product->slug) }}"><img
                                                                        src="{{ url('upload/product_images/' . $product->image) }}"
                                                                        alt="{{ $product->name }}"></a>
                                                            </div><!-- /.image -->

                                                            <div class="tag new">
                                                                <span class="english_lang">hot</span>
                                                                <span class="bangla_lang" style="display: none;">হট</span>
                                                            </div>
                                                        </div><!-- /.product-image -->


                                                        <div class="product-info text-left">

                                                            <h3 class="name"><a title="{{ $product->name }}"
                                                                    href="{{ route('product.details.info', $product->slug) }}">
                                                                    @php
                                                                        $myStr = $product->name;
                                                                        $subStr = substr($myStr, 0, 25);
                                                                        echo $subStr . '...';
                                                                    @endphp
                                                                </a>
                                                            </h3>
                                                            <div class="rating rateit-small"></div>
                                                            <div class="description"></div>

                                                            <div class="product-price">
                                                                @php
                                                                    if (auth()->check() && auth()->user()->usertype === 'dropshipper' && isset($product->sale_price) && $product->sale_price > 0) {
                                                                        $displayPrice = $product->sale_price;
                                                                        $showOriginalPrice = false;
                                                                    } else {
                                                                        if (!empty($product->discount)) {
                                                                            $displayPrice =
                                                                                $product->discount_type == 1
                                                                                    ? $product->price - ($product->price * $product->discount) / 100
                                                                                    : $product->price - $product->discount;
                                                                        } else {
                                                                            $displayPrice = $product->price;
                                                                        }
                                                                        $showOriginalPrice = !empty($product->discount);
                                                                    }
                                                                @endphp
                                                                <span class="price">&#2547; {{ $displayPrice }}</span>

                                                                @if ($showOriginalPrice)
                                                                    <span class="price-before-discount">&#2547;
                                                                        {{ $product->price }}</span>
                                                                @endif
                                                            </div><!-- /.product-price -->

                                                        </div><!-- /.product-info -->
                                                        <div class="cart clearfix animate-effect">
                                                            <div class="action">
                                                                <ul class="list-unstyled">
                                                                    <li class="add-cart-button btn-group">
                                                                        <button class="btn btn-primary icon" type="button" title="Add Cart"
                                                                            data-toggle="modal" data-target="#cartModal" id="{{ $product->id }}"
                                                                            onclick="productView(this.id)">
                                                                            <i class="fa fa-shopping-cart"></i>
                                                                        </button>
                                                                        <button class="btn btn-primary cart-btn" type="button">
                                                                            Add to cart
                                                                        </button>
                                                                    </li>
                                
                                                                    {{-- <button class="btn btn-primary icon" type="button" title="Add to Wishlist"
                                                                        id="{{ $product->id }}" onclick="addToWishlist(this.id)">
                                                                        <i class="icon fa fa-heart"></i>
                                                                    </button> --}}
                                                                </ul>
                                                            </div><!-- /.action -->
                                                        </div><!-- /.cart -->
                                                    </div><!-- /.product -->

                                                </div><!-- /.products -->
                                            </div><!-- /.item -->
                                        @endforeach
                                    </div><!-- /.row -->
                                </div><!-- /.category-product -->
                            </div><!-- /.tab-pane -->

                            <div class="tab-pane " id="list-container">
                                <div class="category-product">
                                    @foreach ($products as $product)
                                        <div class="category-product-inner wow fadeInUp">
                                            <div class="products">
                                                <div class="product-list product">
                                                    <div class="row product-list-row">
                                                        <div class="col col-sm-4 col-lg-4">
                                                            <div class="product-image">
                                                                <div class="image">
                                                                    <img src="{{ url('upload/product_images/' . $product->image) }}" alt="{{ $product->name }}">
                                                                </div>
                                                            </div><!-- /.product-image -->
                                                        </div><!-- /.col -->
                                                        <div class="col col-sm-8 col-lg-8">
                                                            <div class="product-info">
                                                                <h3 class="name"><a
                                                                        href="{{ route('product.details.info', $product->slug) }}">{{ $product->name }}</a>
                                                                </h3>
                                                                <div class="rating rateit-small"></div>
                                                                <div class="product-price">
                                                                    @php
                                                                        if (auth()->check() && auth()->user()->usertype === 'dropshipper' && isset($product->sale_price) && $product->sale_price > 0) {
                                                                            $displayPrice = $product->sale_price;
                                                                            $showOriginalPrice = false;
                                                                        } else {
                                                                            if (!empty($product->discount)) {
                                                                                $displayPrice =
                                                                                    $product->discount_type == 1
                                                                                        ? $product->price - ($product->price * $product->discount) / 100
                                                                                        : $product->price - $product->discount;
                                                                            } else {
                                                                                $displayPrice = $product->price;
                                                                            }
                                                                            $showOriginalPrice = !empty($product->discount);
                                                                        }
                                                                    @endphp
                                                                    <span class="price">&#2547; {{ $displayPrice }}</span>

                                                                    @if ($showOriginalPrice)
                                                                        <span class="price-before-discount">&#2547;
                                                                            {{ $product->price }}</span>
                                                                    @endif
                                                                </div><!-- /.product-price -->
                                                                <div class="description m-t-10">{{ $product->short_desc }}
                                                                </div>
                                                                <div class="cart clearfix animate-effect">
                                                                    <div class="action">
                                                                        <ul class="list-unstyled">
                                                                            <li class="add-cart-button btn-group">
                                                                                <button class="btn btn-primary icon" type="button" title="Add Cart"
                                                                                    data-toggle="modal" data-target="#cartModal" id="{{ $product->id }}"
                                                                                    onclick="productView(this.id)">
                                                                                    <i class="fa fa-shopping-cart"></i>
                                                                                </button>
                                                                                <button class="btn btn-primary cart-btn" type="button">
                                                                                    Add to cart
                                                                                </button>
                                                                            </li>
                                        
                                                                            {{-- <button class="btn btn-primary icon" type="button" title="Add to Wishlist"
                                                                                id="{{ $product->id }}" onclick="addToWishlist(this.id)">
                                                                                <i class="icon fa fa-heart"></i>
                                                                            </button> --}}
                                                                        </ul>
                                                                    </div><!-- /.action -->
                                                                </div><!-- /.cart -->
                                                            </div><!-- /.product-info -->
                                                        </div><!-- /.col -->
                                                    </div><!-- /.product-list-row -->
                                                </div><!-- /.product-list -->
                                            </div><!-- /.products -->
                                        </div><!-- /.category-product-inner -->
                                    @endforeach
                                </div><!-- /.category-product -->
                            </div><!-- /.tab-pane #list-container -->
                        </div><!-- /.tab-content -->
                        {{ $products->links('vendor.pagination.custom') }}
                    </div><!-- /.search-result-container -->
                </div><!-- /.col -->
            </div><!-- /.row -->
            <!-- ======== BRANDS CAROUSEL ========== -->
            @include('frontend.layouts.brand')
            <!-- ========= BRANDS CAROUSEL : END ========== -->
        </div><!-- /.container -->
    </div><!-- /.body-content -->
@endsection
