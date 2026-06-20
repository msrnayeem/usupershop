@extends('frontend.layouts.seller_master')
@section('title', $category->name . ' Products | ' . config('app.name'))

@section('meta_description',
    $category->description ??
    $category->name .
    ' ক্যাটাগরির জনপ্রিয় পণ্যসমূহ। মানসম্মত পণ্য
    ঘরে বসেই কিনুন, দ্রুত ডেলিভারি ও সাশ্রয়ী মূল্যে।')
@section('meta_keywords',
    $category->name .
    ', ' .
    config('app.name') .
    ', ক্যাটাগরি প্রোডাক্ট, অনলাইন শপ, বাংলাদেশ,
    মানসম্মত পণ্য')

@section('meta_author', config('app.name'))

@push('meta')
    {{-- Open Graph / Facebook --}}
    <meta property="og:title" content="{{ $category->name }} Products - {{ config('app.name') }}" />
    <meta property="og:description"
        content="{{ $category->description ?? $category->name . ' ক্যাটাগরির মানসম্মত পণ্য ঘরে বসেই অর্ডার করুন। দ্রুত ডেলিভারি ও সাশ্রয়ী দাম।' }}" />
    <meta property="og:image"
        content="{{ $category->image ? asset('uploads/categories/' . $category->image) : asset('frontend/images/og-default.jpg') }}" />
    <meta property="og:url" content="{{ url()->current() }}" />
    <meta property="og:type" content="website" />

    {{-- Twitter Card --}}
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $category->name }} Products - {{ config('app.name') }}">
    <meta name="twitter:description"
        content="{{ $category->description ?? $category->name . ' ক্যাটাগরির জনপ্রিয় ও মানসম্মত পণ্যসমূহ।' }}">
    <meta name="twitter:image"
        content="{{ $category->image ? asset('uploads/categories/' . $category->image) : asset('frontend/images/og-default.jpg') }}">
@endpush
@section('content')
    <div class="breadcrumb">
        <div class="container">
            <div class="breadcrumb-inner">
                <ul class="list-inline list-unstyled">
                    <li><a href="#">Home</a></li>
                    <li class='active'>{{ $category->name ?? '' }}</li>
                </ul>
            </div><!-- /.breadcrumb-inner -->
        </div><!-- /.container -->
    </div><!-- /.breadcrumb -->
    <div class="body-content outer-top-xs">
        <div class='container'>
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
                                    $categories = DB::table('my_shops')
                                        ->join('products', 'products.id', '=', 'my_shops.product_id')
                                        ->where('my_shops.user_id', $shopID)
                                        ->join('categories', 'products.category_id', '=', 'categories.id')
                                        ->select(
                                            'categories.name',
                                            'categories.id',
                                            'categories.name_bn',
                                            'categories.cat_icon',
                                        )
                                        ->groupBy(
                                            'categories.name',
                                            'categories.id',
                                            'categories.name_bn',
                                            'categories.cat_icon',
                                        )
                                        ->distinct()
                                        ->get();
                                @endphp
                                @foreach ($categories as $category)
                                    <li class="dropdown menu-item">
                                        <a class="english_lang"
                                            href="{{ route('seller.shop.category', ['category_id' => $category->id, 'shopID' => $shopID]) }}"><i
                                                class="icon fa fa-{{ $category->cat_icon }}"></i>
                                            {{ $category->name }}
                                        </a>

                                        <a class="bangla_lang" style="display: none"
                                            href="{{ route('seller.shop.category', ['category_id' => $category->id, 'shopID' => $shopID]) }}"><i
                                                class="icon fa fa-{{ $category->cat_icon }}"></i>
                                            {{ $category->name_bn }}
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
                        </div><!-- /.sidebar-filter -->
                    </div><!-- /.sidebar-module-container -->
                </div><!-- /.sidebar -->
                <div class='col-md-9'>
                    <!-- ============ SECTION – HERO =========== -->

                    <div id="category" class="category-carousel hidden-xs">
                        <div class="item">
                            <div class="image">
                                <img style="width: 100%;height:200px"
                                    src="{{ asset('frontend') }}/assets/images/banners/order_animation.jpg" alt=""
                                    class="img-responsive">
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

                        </div><!-- /.row -->
                    </div>
                    <div class="search-result-container ">
                        <div id="myTabContent" class="tab-content category-list">
                            <div class="tab-pane active " id="grid-container">
                                <div class="category-product">
                                    <div class="row">
                                        @foreach ($products as $product)
                                            <div class="col-sm-6 col-md-3 col-xs-6 ">
                                                <div class="products"style="height:380px;">
                                                    <div class="product">
                                                        <div class="product-image">
                                                            <div class="image">
                                                                <a
                                                                    href="{{ route('seller.product.details', ['slug' => $product->slug, 'shopID' => $shopID]) }}">
                                                                    @if ($product->image)
                                                                        <img src="{{ asset('upload/product_images/' . $product->image) }}"
                                                                            alt="{{ $product->name }}"
                                                                            style="height:200px;" />
                                                                    @else
                                                                        <img src="{{ asset('frontend/assets/images/no-image.png') }}"
                                                                            alt="{{ $product->name }}"
                                                                            style="height:200px;" />
                                                                    @endif

                                                                </a>

                                                            </div><!-- /.image -->

                                                            <!--<div class="tag new">
                                                                    <span class="english_lang">new</span>
                                                                    <span class="bangla_lang"
                                                                        style="display: none;">নিউ</span>
                                                                </div>-->
                                                        </div><!-- /.product-image -->


                                                        <div class="product-info text-left">

                                                            <h3 class="name english_lang"><a title="{{ $product->name }}"
                                                                    href="{{ route('seller.product.details', ['slug' => $product->slug, 'shopID' => $shopID]) }}">
                                                                    @php
                                                                        $myStr = $product->name;
                                                                        $subStr = substr($myStr, 0, 20);
                                                                        echo $subStr . '...';
                                                                    @endphp
                                                                </a>
                                                            </h3>

                                                            <h3 class="name bangla_lang" style="display: none"><a
                                                                    title="{{ $product->name_bn }}"
                                                                    href="{{ route('seller.product.details', ['slug' => $product->slug, 'shopID' => $shopID]) }}">
                                                                    @php
                                                                        $myStr = $product->name_bn;
                                                                        $subStr = substr($myStr, 0, 30);
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
                                                                        <button class="btn btn-primary icon"
                                                                            type="button" title="Add Cart"
                                                                            data-toggle="modal"
                                                                            data-target="#shopcartModal"
                                                                            id="{{ $product->id }}"
                                                                            onclick="ShopProductView(this.id)">
                                                                            <i class="fa fa-shopping-cart"></i> Add to cart
                                                                        </button>

                                                                    </li>
                                                                </ul>
                                                            </div>
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
                                        <div class="category-product-inner">
                                            <div class="products"style="height:380px;">
                                                <div class="product-list product">
                                                    <div class="row product-list-row">
                                                        <div class="col col-sm-4 col-lg-4">
                                                            <div class="product-image">
                                                                <div class="image">
                                                                    @if (!empty($product->image))
                                                                        <img src="{{ url('upload/product_images/' . $product->image) }}"
                                                                            alt="{{ $product->name }}"
                                                                            style="height: 200px;" />
                                                                    @else
                                                                        <img src="{{ asset('frontend/assets/images/no-image.png') }}"
                                                                            alt="{{ $product->name }}"
                                                                            style="height: 200px;" />
                                                                    @endif


                                                                </div>
                                                            </div><!-- /.product-image -->
                                                        </div><!-- /.col -->
                                                        <div class="col col-sm-8 col-lg-8">
                                                            <div class="product-info">
                                                                <h3 class="name"><a
                                                                        href="{{ route('seller.product.details', ['slug' => $product->slug, 'shopID' => $shopID]) }}">{{ $product->name }}</a>
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
                                                                                <button class="btn btn-primary icon"
                                                                                    type="button" title="Add Cart"
                                                                                    data-toggle="modal"
                                                                                    data-target="#shopcartModal"
                                                                                    id="{{ $product->id }}"
                                                                                    onclick="ShopProductView(this.id)">
                                                                                    <i class="fa fa-shopping-cart"></i> Add
                                                                                    to cart
                                                                                </button>

                                                                            </li>
                                                                        </ul>
                                                                    </div>
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
