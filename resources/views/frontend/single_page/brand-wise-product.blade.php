@extends('frontend.layouts.master')
@section('title', $brand->name . ' Products | ' . config('app.name'))

@section('meta_description',
    $brand->description ??
    $brand->name .
    ' ব্র্যান্ডের জনপ্রিয় পণ্যসমূহ। ঘরে বসেই কিনুন
    মানসম্মত ও আসল ' .
    $brand->name .
    ' পণ্য, দ্রুত ডেলিভারি সহ।')
@section('meta_keywords',
    $brand->name .
    ', ' .
    config('app.name') .
    ', ব্র্যান্ড প্রোডাক্ট, অনলাইন শপ, বাংলাদেশ, আসল
    পণ্য, ' .
    $brand->name .
    ' প্রোডাক্ট')

@section('meta_author', config('app.name'))

@push('meta')
    {{-- Open Graph / Facebook --}}
    <meta property="og:title" content="{{ $brand->name }} Products - {{ config('app.name') }}" />
    <meta property="og:description"
        content="{{ $brand->description ?? $brand->name . ' ব্র্যান্ডের আসল ও মানসম্মত পণ্য ঘরে বসেই অর্ডার করুন। দ্রুত ডেলিভারি ও সাশ্রয়ী দাম।' }}" />
    <meta property="og:image"
        content="{{ $brand->image ? asset('uploads/brands/' . $brand->image) : asset('frontend/images/og-default.jpg') }}" />
    <meta property="og:url" content="{{ url()->current() }}" />
    <meta property="og:type" content="website" />

    {{-- Twitter Card --}}
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $brand->name }} Products - {{ config('app.name') }}">
    <meta name="twitter:description"
        content="{{ $brand->description ?? $brand->name . ' ব্র্যান্ডের আসল ও জনপ্রিয় পণ্য বাংলাদেশে।' }}">
    <meta name="twitter:image"
        content="{{ $brand->image ? asset('uploads/brands/' . $brand->image) : asset('frontend/images/og-default.jpg') }}">
@endpush
@section('content')
    <style>
        .brand {
            border: 1px solid;
            padding: 3px 10px;
        }
    </style>
    <!-- Title page -->
    <section class="bg-img1 txt-center p-lr-15 p-tb-92" style="background-image: url('../frontend/images/bg-01.jpg');">
        <h2 class="ltext-105 cl0 txt-center">
            Brand Wise Product
        </h2>
    </section>

    <!-- Product -->
    <section class="bg0 p-t-23 p-b-140">
        <div class="container">
            <div class="flex-w flex-sb-m p-b-52">
                <div class="flex-w flex-l-m filter-tope-group m-tb-10">
                    <a href="{{ route('product.list') }}" class="stext-106 cl6 hov1 bor3 trans-04 m-r-32 m-tb-5 how-active1"
                        data-filter="*">All
                        Products</a>
                    @foreach ($categories as $category)
                        <a href="{{ route('category.wise.product', $category->category_id) }}"
                            class="stext-106 cl6 hov1 bor3 trans-04 m-r-32 m-tb-5"
                            data-filter=".{{ $category->category_id }}">{{ $category['category']['name'] }}</a>
                    @endforeach
                </div>

                <div class="flex-w flex-c-m m-tb-10">
                    <div class="flex-c-m stext-106 cl6 size-104 bor4 pointer hov-btn3 trans-04 m-r-8 m-tb-4 js-show-filter">
                        <i class="icon-filter cl2 m-r-6 fs-15 trans-04 zmdi zmdi-filter-list"></i>
                        <i class="icon-close-filter cl2 m-r-6 fs-15 trans-04 zmdi zmdi-close dis-none"></i>
                        Filter
                    </div>

                    <div class="flex-c-m stext-106 cl6 size-105 bor4 pointer hov-btn3 trans-04 m-tb-4 js-show-search">
                        <i class="icon-search cl2 m-r-6 fs-15 trans-04 zmdi zmdi-search"></i>
                        <i class="icon-close-search cl2 m-r-6 fs-15 trans-04 zmdi zmdi-close dis-none"></i>
                        Search
                    </div>
                </div>

                <!-- Search product -->
                <div class="dis-none panel-search w-full p-t-10 p-b-15">
                    <div class="bor8 dis-flex p-l-15">
                        <button class="size-113 flex-c-m fs-16 cl2 hov-cl1 trans-04">
                            <i class="zmdi zmdi-search"></i>
                        </button>
                        <input class="mtext-107 cl2 size-114 plh2 p-r-15" type="text" name="search-product"
                            placeholder="Search">
                    </div>
                </div>

                <!-- Filter -->
                <div class="dis-none panel-filter w-full">
                    <div class="wrap-filter flex-w w-full" style="background-color: #858585;">
                        <div>
                            <div style="padding: 20px; font-size: 25px; color: #fff">
                                Brands
                            </div>
                            <div style="padding: 0px 20px 20px 20px;">
                                @foreach ($brands as $brand)
                                    <a class="stext-106 cl6 hov1 bor3 trans-04 m-r-32 m-tb-5 brand"
                                        href="{{ route('brand.wise.product', $brand->brand_id) }}"
                                        class="filter-link stext-106 trans-04" style="color: #fff">
                                        {{ $brand['brand']['name'] }}
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row isotope-grid">
                @foreach ($products as $product)
                    <div class="col-sm-6 col-md-3 col-lg-3 col-xs-6 p-b-35 isotope-item {{ $product->category_id }}">
                        <!-- Block2 -->
                        <div class="block2">
                            <div class="block2-pic hov-img0">
                                <img src="{{ url('upload/product_images/' . $product->image) }}"
                                    alt="{{ $product->name }}">
                                <a href="{{ route('product.details.info', $product->slug) }}"
                                    class="block2-btn flex-c-m stext-103 cl2 size-102 bg0 bor2 hov-btn1 p-lr-15 trans-04">
                                    Add to Cart
                                </a>
                            </div>
                            <div class="block2-txt flex-w flex-t p-t-14">
                                <div class="block2-txt-child1 flex-col-l ">
                                    <a href="{{ route('product.details.info', $product->slug) }}"
                                        class="stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6">
                                        {{ $product->name }}
                                    </a>
                                    <div style="display: flex;justify-content: space-between;width:100%">
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
                                        @if ($showOriginalPrice)
                                            <span class="stext-105 cl3" style="color:red;">
                                                &#2547; <s>{{ $product->price }}</s>
                                            </span>
                                        @endif
                                        <span class="stext-105 cl3">&#2547; {{ $displayPrice }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="float-right">
                        {{ $products->links('pagination::bootstrap-4') }}
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
