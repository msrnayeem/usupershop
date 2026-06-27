@extends('frontend.layouts.master')
@section('title', $productDetails->meta_title ?? $productDetails->name . ' | ' . config('app.name'))

@section('meta_description', $productDetails->meta_description ?? Str::limit(strip_tags($productDetails->description),
    160))
@section('meta_keywords', $productDetails->meta_keywords ?? ($productDetails->tags ?? $productDetails->name))
@section('meta_author', config('app.name'))

@push('meta')
    {{-- Open Graph / Facebook --}}
    <meta property="og:title" content="{{ $productDetails->name }} - {{ config('app.name') }}" />
    <meta property="og:description"
        content="{{ $productDetails->meta_description ?? Str::limit(strip_tags($productDetails->description), 160) }}" />
    <meta property="og:image" content="{{ !empty($productDetails->image) ? asset('upload/product_images/' . $productDetails->image) : asset('frontend/assets/images/logo.png') }}" />
    <meta property="og:url" content="{{ url()->current() }}" />
    <meta property="og:type" content="product" />

    {{-- Twitter Card --}}
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $productDetails->name }} - {{ config('app.name') }}">
    <meta name="twitter:description"
        content="{{ $productDetails->meta_description ?? Str::limit(strip_tags($productDetails->description), 160) }}">
    <meta name="twitter:image" content="{{ !empty($productDetails->image) ? asset('upload/product_images/' . $productDetails->image) : asset('frontend/assets/images/logo.png') }}">

    {{-- ── SEO: Product Schema (Rich Results) ─────────────────── --}}
    @php
        $productPrice = $productDetails->price ?? 0;
        $salePrice = $productDetails->sale_price ?? $productPrice;
        $stockStatus = $productDetails->quantity > 0 ? 'https://schema.org/InStock' : 'https://schema.org/OutOfStock';
        $productImg = !empty($productDetails->image)
            ? asset('upload/product_images/' . $productDetails->image)
            : asset('frontend/assets/images/logo.png');
        $productUrl = url('/product-details/' . $productDetails->slug);
    @endphp
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "Product",
      "name": "{{ addslashes($productDetails->name) }}",
      "description": "{{ addslashes(Str::limit(strip_tags($productDetails->description ?? ''), 500)) }}",
      "image": ["{{ $productImg }}"],
      "sku": "USP-{{ $productDetails->id }}",
      "mpn": "USP-{{ $productDetails->id }}",
      "brand": {
        "@type": "Brand",
        "name": "{{ $productDetails->brand->name ?? 'U Super Shop' }}"
      },
      "offers": {
        "@type": "Offer",
        "url": "{{ $productUrl }}",
        "priceCurrency": "BDT",
        "price": "{{ $salePrice }}",
        "priceValidUntil": "{{ now()->addYear()->format('Y-m-d') }}",
        "itemCondition": "https://schema.org/NewCondition",
        "availability": "{{ $stockStatus }}",
        "seller": {
          "@type": "Organization",
          "name": "U Super Shop"
        }
      },
      "breadcrumb": {
        "@type": "BreadcrumbList",
        "itemListElement": [
          {"@type": "ListItem", "position": 1, "name": "Home", "item": "https://usuper.shop"},
          {"@type": "ListItem", "position": 2, "name": "Products", "item": "https://usuper.shop/product-list"},
          {"@type": "ListItem", "position": 3, "name": "{{ addslashes($productDetails->name) }}", "item": "{{ $productUrl }}"}
        ]
      }
    }
    </script>
@endpush
@section('custom_css')
    <style>
        .card {
            border: 1px solid #ddd;
            padding: 15px;
            border-radius: 4px;
            box-shadow: 0 .5rem 1rem rgba(0, 0, 0, .15);
            margin-top: 15px;
        }

        #custom-single-product .single-product-gallery-item button {
            max-height: 520px;
            width: 100%;
            outline: none;
            border: 1px solid #ddd;
            border-radius: 4px;
            padding: 6px;
            overflow: hidden;
            margin: auto;
            text-align: center;
            background: #fff;
        }

        #custom-single-product .single-product-gallery-item button img {
            max-width: 500px;
            text-align: center;
            margin: auto;
            border: none;
            border-radius: 2px;
        }

        #custom-single-product-thumbnails {
            overflow-x: scroll;
            display: flex;
            width: 100%;
        }

        #custom-single-product-thumbnails {
            overflow-x: scroll;
            display: flex;
            width: 100%;
        }

        #custom-single-product-thumbnails::-webkit-scrollbar {
            display: none;
        }

        #custom-single-product-thumbnails .item {
            margin: 0px 4px;
        }

        #custom-single-product-thumbnails .item:first-child {
            margin-left: 0px;
        }

        #custom-single-product-thumbnails .item:last-child {
            margin-right: 0px;
        }

        #custom-single-product-thumbnails .item button {
            width: 100px;
            border: 1px solid #ddd;
            border-radius: 3px;
            padding: 2px;
            overflow: hidden;
            margin: auto;
            text-align: center;
            background: #fff;
            height: 100px;
        }

        #custom-single-product-thumbnails .item button img {
            width: 100px;
            height: 94px !important;
            border-radius: 2px;
        }

        .product-info .attribute {
            font-size: 15px;
            margin-bottom: 7px;
            color: #636363;
        }

        .single-product .product-info-block .name {
            margin-top: 0px;
            font-weight: 600;
            letter-spacing: 0.3px;
            font-size: 24px;
        }

        .single-product .product-info .price-container .price-box .price {
            font-size: 24px;
            font-weight: 700;
            color: #0824ac;
            margin-right: 2px;
        }

        .single-product .product-info .price-container .price-box .price-strike {
            color: #aaa !important;
            font-size: 18px !important;
            font-weight: 600 !important;
            text-decoration: line-through !important;
        }

        .single-product .product-info .price-container {
            padding-bottom: 10px !important;
        }

        .cart-quantity-sction {
            display: flex;
        }

        .cart-quantity-sction label {
            font-size: 16px;
            text-transform: uppercase;
            color: #333;
            margin-right: 12px;
            margin-bottom: 5px;
            margin-top: 5px;
        }

        .cart-quantity {
            margin: auto 0px;
            vertical-align: middle;
        }

        .cart-quantity button {
            width: 30px;
            height: 30px;
            border: 1px solid #ddd;
            border-radius: 4px;
            color: #333;
        }

        .cart-quantity button i {
            color: #333;
        }

        .cart-quantity input {
            width: 50px;
            height: 30px;
            border: 1px solid #ddd;
            border-radius: 2px;
            text-align: center;
            outline: none;
        }

        .card-header {
            padding: 2px 0px;
            border-bottom: 1px solid #ddd;
        }

        .card-header .card-title {
            font-size: 16px;
            font-weight: 700;
            letter-spacing: 0.3px;
        }


        @media (max-width: 767px) {
            section.single-product {
                padding-top: 100px;
            }

            .single-product .product-info-block .name {
                font-size: 18px;
                margin-top: 10px;
            }
        }

        @media (max-width: 576px) {
            .product-info .attribute {
                font-size: 14px;
                margin-bottom: 2px;
            }
        }

        .product {
            margin: 0 !important;
            border: 1px solid #ddd;
            padding: 4px;
            border-radius: 2px;
            box-shadow: 0 .5rem 1rem rgba(0, 0, 0, .15);
        }

        .product .product-image button {
            border: 1px solid #ddd;
            border-radius: 2px;
            width: 100%;
            height: 150px;
            padding: 5px;
            background: #f8f9fa;
            overflow: hidden;
        }

        .product .product-image button img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        .product-column {
            padding-left: 6px;
            padding-right: 6px;
        }

        .product .product-info .name a {
            font-size:14px;
        }

        @media (max-width: 576px) {
            .product-info .name a {
                font-size:14px !important;
            }

            .product-price {
                font-size: 14px;
            }

            .add-cart-button .btn {
                font-size: 13px;
                padding: 6px 10px;
            }

            .product .product-info .name a {
                font-size:13px;
            }
        }

        @media (max-width: 376px) {
            .product-info .name a {
                font-size:14px !important;
            }

            .product-price {
                font-size:14px;
            }

            .add-cart-button .btn {
                font-size: 13px;
                padding: 6px 4px;
            }
        }

        @media (max-width: 476px) {

            .product-info .name a {
                font-size:14px !important;
            }

            .product-price {
                font-size:14px;
            }

            .add-cart-button .btn {
                font-size:13px;
                padding: 4px 4px;
            }
        }
    </style>
@endsection
@section('content')

        {{-- Visible breadcrumb for SEO + UX --}}
        <nav aria-label="breadcrumb" style="background:#f8f9fa; padding:8px 0; border-bottom:1px solid #eee; margin-bottom:16px;">
            <div class="container">
                <ol class="breadcrumb" style="margin:0; padding:4px 0; background:transparent; font-size:13px;" itemscope itemtype="https://schema.org/BreadcrumbList">
                    <li class="breadcrumb-item" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                        <a href="{{ route('frontend.home') }}" itemprop="item" style="color:#1e25fa; text-decoration:none;">
                            <span itemprop="name">🏠 Home</span>
                        </a>
                        <meta itemprop="position" content="1" />
                    </li>
                    @if($productDetails->category)
                    <li class="breadcrumb-item" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                        <a href="{{ route('category.wise.product', $productDetails->category->id) }}" itemprop="item" style="color:#1e25fa; text-decoration:none;">
                            <span itemprop="name">{{ $productDetails->category->name }}</span>
                        </a>
                        <meta itemprop="position" content="2" />
                    </li>
                    @endif
                    <li class="breadcrumb-item active" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem" aria-current="page">
                        <span itemprop="name">{{ Str::limit($productDetails->name, 40) }}</span>
                        <meta itemprop="position" content="{{ $productDetails->category ? 3 : 2 }}" />
                    </li>
                </ol>
            </div>
        </nav>

    <div class="body-content outer-top-xs">
        <section class="single-product">
            <div class="container">
                <div class="row wow fadeInUp">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-xs-12 col-sm-6 col-md-6 gallery-holder">
                                        <div class="product-item-holder size-big single-product-gallery small-gallery">
                                            <div id="custom-single-product">
                                                @foreach ($product_sub_image as $sub_image)
                                                    <div class="single-product-gallery-item"
                                                        id="slide_{{ $sub_image->id }}">
                                                        <a data-lightbox="image-1" data-title="Product Gallery"
                                                            href="{{ url('upload/product_images/product_sub_images/' . $sub_image->sub_image) }}">
                                                            <button>
                                                                <img style="width:100%;" class="img-responsive"
                                                                    alt="{{ $productDetails->name ?? 'Product Image' }}"
                                                                    src="{{ !empty($sub_image->sub_image) ? asset('upload/product_images/product_sub_images/' . $sub_image->sub_image) : asset('frontend/assets/images/no-image.png') }}"
                                                                    data-echo="{{ url('upload/product_images/product_sub_images/' . $sub_image->sub_image) }}" />
                                                            </button>
                                                        </a>
                                                    </div>
                                                @endforeach
                                            </div>

                                            <div class="single-product-gallery-thumbs gallery-thumbs">
                                                <div id="custom-single-product-thumbnails">
                                                    @foreach ($product_sub_image as $sub_image)
                                                        <div class="item">
                                                            <a class="horizontal-thumb active"
                                                                data-target="#custom-single-product"
                                                                data-slide="{{ $sub_image->id }}"
                                                                href="#slide_{{ $sub_image->id }}">
                                                                <button>
                                                                    <img class="img-responsive"
                                                                        style="height:100px;width:100px;"
                                                                        src="{{ !empty($sub_image->sub_image) ? asset('upload/product_images/product_sub_images/' . $sub_image->sub_image) : asset('frontend/assets/images/no-image.png') }}"
                                                                        data-echo="{{ url('upload/product_images/product_sub_images/' . $sub_image->sub_image) }}" />
                                                                </button>
                                                            </a>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class='col-xs-12 col-sm-6 col-md-6 product-info-block add_to_cart_product_info'>

                                        <input type="hidden" name="id" class="product_id"
                                            value="{{ $productDetails->id }}">
                                        <div class="product-info">
                                            <h1 class="name english_lang" style="font-size:1.4rem;">{{ $productDetails->name }}</h1>
                                            <h1 class="name bangla_lang" style="display: none; font-size:1.4rem;">
                                                {{ $productDetails->name_bn }}
                                            </h1>
                                            <p class="attribute"><strong>Category :</strong>
                                                {{ $productDetails->category->name }}</p>

                                            <p class="attribute"><strong>Availability :</strong> {!! $productDetails->quantity > 0
                                                ? '<span class="value" style="color:#4caf50 !important">(' . $productDetails->quantity . ') In Stock</span>'
                                                : '<span class="text-danger">Out Of Stock</span>' !!}
                                            </p>

                                            @if ($productDetails->sku)
                                                <p class="text-scondary mt-6 attribute"><strong>Product Code :</strong>
                                                    {{ $productDetails->sku }}</p>
                                            @endif


                                            @if ($productDetails->short_desc)
                                                <div class="description-container english_lang">
                                                    {!! $productDetails->short_desc !!}
                                                </div>
                                            @endif
                                            @if ($productDetails->short_desc_bn)
                                                <div class="description-container bangla_lang" style="display: none">
                                                    {!! $productDetails->short_desc_bn !!}
                                                </div>
                                            @endif


                                            <div class="price-container info-container m-t-20">
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <div class="price-box">
                                                            @php
                                                                $isDropshipperWholesale =
                                                                    auth()->check() &&
                                                                    auth()->user()->usertype === 'dropshipper' &&
                                                                    isset($productDetails->sale_price) &&
                                                                    $productDetails->sale_price > 0;
                                                                $baseProductPrice = $isDropshipperWholesale ? $productDetails->sale_price : $productDetails->price;
                                                                if (!$isDropshipperWholesale && !empty($productDetails->discount)) {
                                                                    $displayPrice =
                                                                        $productDetails->discount_type == 1
                                                                            ? $baseProductPrice - ($baseProductPrice * $productDetails->discount) / 100
                                                                            : $baseProductPrice - $productDetails->discount;
                                                                } else {
                                                                    $displayPrice = $baseProductPrice;
                                                                }
                                                                $showOriginalPrice = !$isDropshipperWholesale && !empty($productDetails->discount);
                                                            @endphp
                                                            <span class="price" id="display-price">
                                                                &#2547;{{ $displayPrice }}
                                                            </span>

                                                            <span class="price-strike" id="display-original-price"
                                                                style="{{ $showOriginalPrice ? '' : 'display:none;' }}">
                                                                &#2547;<span
                                                                    id="original-price-value">{{ $baseProductPrice }}</span>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div><!-- /.row -->


                                            @if ($productDetails->quantity > 0)
                                                <div class="row mt-3">

                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label for="color">Select Color</label>
                                                            <select class="form-control select2 color_id" id="color"
                                                                name="color_id">
                                                                <option value="">Select Color</option>
                                                                @foreach ($productDetails->product_colors as $color)
                                                                    <option value="{{ $color->id }}">
                                                                        {{ $color->color->name }}
                                                                    </option>
                                                                @endforeach

                                                            </select>
                                                            <span class="text-danger color_id_errors"></span>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label for="size">Select Size</label>
                                                            <select class="form-control select2 size_id" id="size"
                                                                name="size_id">
                                                                <option value="">Select Size</option>
                                                                @foreach ($productDetails->product_sizes as $size)
                                                                    <option value="{{ $size->id }}">
                                                                        {{ $size->size->name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                            <span class="text-danger size_id_errors"></span>
                                                        </div>
                                                    </div>
                                                </div><!-- /.row -->
                                            @endif


                                        </div><!-- /.price-container -->

                                        @if ($productDetails->quantity > 0)
                                            <div class="quantity-container info-container">
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <div class="cart-quantity-sction">
                                                            <label for="qty">QTY : </label>
                                                            <div class="cart-quantity">
                                                                <button type="button" class="arrow minus gradient"><span
                                                                        class="ir"><i
                                                                            class=" fa fa-minus"></i></span></button>
                                                                <input type="text" min="1" value="1"
                                                                    name="qty" id="qty" readonly>
                                                                <button type="button" class="arrow plus gradient"><span
                                                                        class="ir"><i
                                                                            class=" fa fa-plus"></i></span></button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-12" style="margin-top: 20px; text-align: center;">
                                                        @if (auth()->check() && auth()->user()->usertype === 'dropshipper')
                                                            <div class="card mt-4">
                                                                <div class="card-header bg-success text-white">
                                                                    Dropshipper Order Form
                                                                </div>
                                                                <div class="card-body">
                                                                    <form
                                                                        action="{{ route('dropshipper.order.checkout') }}"
                                                                        method="POST">
                                                                        @csrf
                                                                        <input type="hidden" name="product_id"
                                                                            value="{{ $productDetails->id }}">
                                                                        <div class="mb-3">
                                                                            <label>Select Color</label>
                                                                            <select name="color_id" class="form-control">
                                                                                <option value="">No Color</option>
                                                                                @foreach ($productDetails->product_colors as $color)
                                                                                    <option value="{{ $color->id }}">
                                                                                        {{ $color->color->name }}</option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>

                                                                        <div class="mb-3">
                                                                            <label>Select Size</label>
                                                                            <select name="size_id" class="form-control">
                                                                                <option value="">No Size</option>
                                                                                @foreach ($productDetails->product_sizes as $size)
                                                                                    <option value="{{ $size->id }}">
                                                                                        {{ $size->size->name }}</option>
                                                                                @endforeach
                                                                            </select>
                                                                        </div>

                                                                        <div class="mb-3">
                                                                            <label>Customer Name</label>
                                                                            <input type="text" name="name"
                                                                                class="form-control" required>
                                                                        </div>

                                                                        <div class="mb-3">
                                                                            <label>Customer Mobile</label>
                                                                            <input type="text" name="mobile"
                                                                                class="form-control" required>
                                                                        </div>

                                                                        <div class="mb-3">
                                                                            <label>Customer Address</label>
                                                                            <textarea name="address" class="form-control" required></textarea>
                                                                        </div>

                                                                        <div class="mb-3">
                                                                            <label>Delivery Area</label>

                                                                        </div>

                                                                        <div class="mb-3">
                                                                            <label>Payment Method</label>
                                                                            <select name="payment_method"
                                                                                class="form-control" required>
                                                                                <option value="cod">Cash on Delivery
                                                                                </option>
                                                                                <option value="bkash">Bkash</option>
                                                                            </select>
                                                                        </div>

                                                                        <div class="mb-3">
                                                                            <label>Default Sale Price (Product
                                                                                Price)</label>
                                                                            <input type="number" class="form-control"
                                                                                value="{{ $displayPrice }}"
                                                                                readonly>
                                                                        </div>

                                                                        <div class="mb-3">
                                                                            <label class="font-weight-bold">
                                                                                💰 আপনার Selling Price
                                                                            </label>
                                                                            <div class="input-group">
                                                                                <div class="input-group-prepend">
                                                                                    <span class="input-group-text">৳</span>
                                                                                </div>
                                                                                <input type="number" name="selling_price"
                                                                                    id="dropSellingPrice"
                                                                                    class="form-control"
                                                                                    placeholder="৳{{ $productDetails->min_price }}"
                                                                                    min="{{ $productDetails->min_price }}"
                                                                                    max="{{ $productDetails->max_price > 0 ? $productDetails->max_price : '' }}"
                                                                                    value="{{ $productDetails->min_price }}"
                                                                                    required
                                                                                    oninput="calcDropProfit(this.value)">
                                                                            </div>
                                                                            <div style="margin-top:6px;font-size:13px">
                                                                                <span class="badge badge-light border" style="font-size:12px">
                                                                                    Min: ৳{{ number_format($productDetails->min_price, 0) }}
                                                                                </span>
                                                                                @if($productDetails->max_price > 0)
                                                                                <span class="badge badge-light border ml-1" style="font-size:12px">
                                                                                    Max: ৳{{ number_format($productDetails->max_price, 0) }}
                                                                                </span>
                                                                                @endif
                                                                            </div>
                                                                            <!-- Real-time profit preview -->
                                                                            <div id="profitPreview" style="background:#e8f5e9;border:1px solid #a5d6a7;border-radius:8px;padding:10px;margin-top:8px;font-size:13px;display:none">
                                                                                <strong>🧮 আপনার Profit:</strong>
                                                                                <span id="profitAmt" style="color:#00a855;font-size:16px;font-weight:800">৳0</span>
                                                                                <span style="color:#555"> / প্রতিটি পণ্যে</span>
                                                                            </div>
                                                                            <div id="priceError" style="color:#e8001d;font-size:13px;display:none;margin-top:4px"></div>
                                                                        </div>
                                                                        <script>
                                                                        var dropWholesale = {{ $productDetails->sale_price ?? $productDetails->price }};
                                                                        var dropMin = {{ $productDetails->min_price ?? 0 }};
                                                                        var dropMax = {{ $productDetails->max_price > 0 ? $productDetails->max_price : 9999999 }};
                                                                        function calcDropProfit(val) {
                                                                            var price = parseFloat(val) || 0;
                                                                            var errEl = document.getElementById('priceError');
                                                                            var prvEl = document.getElementById('profitPreview');
                                                                            var amtEl = document.getElementById('profitAmt');
                                                                            errEl.style.display = 'none';
                                                                            if (price < dropMin) {
                                                                                errEl.textContent = '❌ সর্বনিম্ন মূল্য ৳' + dropMin + ' — এর কম হবে না';
                                                                                errEl.style.display = 'block';
                                                                                prvEl.style.display = 'none';
                                                                                return;
                                                                            }
                                                                            if (dropMax < 9999999 && price > dropMax) {
                                                                                errEl.textContent = '❌ সর্বোচ্চ মূল্য ৳' + dropMax + ' — এর বেশি হবে না';
                                                                                errEl.style.display = 'block';
                                                                                prvEl.style.display = 'none';
                                                                                return;
                                                                            }
                                                                            var profit = price - dropWholesale;
                                                                            prvEl.style.display = 'block';
                                                                            amtEl.textContent = '৳' + Math.round(profit);
                                                                            amtEl.style.color = profit > 0 ? '#00a855' : '#e8001d';
                                                                        }
                                                                        // Run on load
                                                                        document.addEventListener('DOMContentLoaded', function() {
                                                                            var inp = document.getElementById('dropSellingPrice');
                                                                            if (inp) calcDropProfit(inp.value);
                                                                        });
                                                                        </script>

                                                                        <div class="mb-3">
                                                                            <label>Quantity</label>
                                                                            <input type="number" name="qty"
                                                                                class="form-control" value="1"
                                                                                min="1">
                                                                        </div>

                                                                        <button type="submit"
                                                                            class="btn btn-success w-100">Place
                                                                            Order</button>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        @else
                                                            <button type="button"
                                                                onclick="addToCartBtnForProductDetails({{ $productDetails->id }})"
                                                                class="btn btn-primary">
                                                                <i class="fa fa-shopping-cart inner-right-vs"></i> ADD TO
                                                                CART
                                                            </button>
                                                        @endif



                                                    </div>
                                                </div>
                                            </div>
                                        @else
                                            <div class="quantity-container info-container">
                                                <div class="row">
                                                    <div class="col-sm-12" style="text-align: center;">
                                                        <span
                                                            style="border: 1px solid #ff00009c; padding: 8px 15px; font-weight: 600; border-radius: 4px; margin: 15px; background: #ff00000a; color: #ff0000;">Stock
                                                            Out</span>
                                                    </div>
                                                </div>
                                            </div>

                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card" style="padding-top: 5px;">
                        <div class="card-header">
                            <h4 class="card-title">Description</h4>
                        </div>
                        <div class="card-body">
                            <div class="description-container m-t-20 ">
                                {!! $productDetails->long_desc !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </div>
    </section>

    <section class="section featured-product">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                                @if (session()->get('language') == 'bangla')
                                    রিলেটেড প্রোডাক্টস
                                @else
                                    Related products
                                @endif
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                @forelse ($relatedProduct as $product)
                                    <div class="col-sm-6 col-md-2 col-xs-6 product-column" style="margin: 10px 0px;">
                                        <div class="product">
                                            <div class="product-image">
                                                <div class="image">
                                                    <a href="{{ route('product.details.info', $product->slug) }}">
                                                        <button>
                                                            @if ($product->image)
                                                                <img src="{{ asset('upload/product_images/' . $product->image) }}"
                                                                    alt="{{ $product->slug }}"
                                                                    onerror="this.onerror=null;this.src='{{ asset('frontend/no-image-icon.jpg') }}';" />
                                                            @else
                                                                <img src="{{ asset('frontend/assets/images/no-image.png') }}"
                                                                    alt="{{ $product->slug }}" />
                                                            @endif
                                                        </button>
                                                    </a>

                                                </div>
                                            </div>


                                            <div class="product-info text-left">
                                                <h3 class="name english_lang"><a title="{{ $product->name }}"
                                                        href="{{ route('product.details.info', $product->slug) }}">
                                                        @php
                                                            $myStr = $product->name;
                                                            $subStr = substr($myStr, 0, 20);
                                                            echo $subStr . '...';
                                                        @endphp
                                                    </a>
                                                </h3>

                                                <h3 class="name bangla_lang" style="display: none"><a
                                                        title="{{ $product->name_bn }}"
                                                        href="{{ route('product.details.info', $product->slug) }}">
                                                        @php
                                                            $myStr = $product->name_bn;
                                                            $subStr = substr($myStr, 0, 30);
                                                            echo $subStr . '...';
                                                        @endphp
                                                    </a>
                                                </h3>

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
                                            {{-- <div class="productButtons">
                                                    <span class="icon productCartBtn" title="Add Cart"
                                                        data-toggle="modal" data-target="#cartModal"
                                                        id="{{ $product->id }}"
                                                        onclick="productView({{ $product->id }})">
                                                        <i class="fa fa-shopping-cart"></i></span>
                                                </div> --}}
                                        </div>
                                    </div>
                                @empty
                                    <div class="col-sm-12 col-md-12 col-xs-12" style="margin: 10px 0px;">
                                        <div class="product">
                                            <div class="product-info text-center">
                                                <h3 class="name">No products found in this category.</h3>
                                            </div>
                                        </div>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
    </div>
@endsection
@push('custom_script')
    <script>
        @if ($errors->any())
            @foreach ($errors->all() as $error)
                flasher['error'](@json($error), {
                    timeout: 1500
                });
            @endforeach
        @endif

        // Store product variants data
        const basePrice = {{ $displayPrice }};
        const discount = {{ $showOriginalPrice ? ($productDetails->discount ?? 0) : 0 }};
        const discountType = {{ $productDetails->discount_type ?? 0 }};

        // Global variable to store current price
        let currentPrice = basePrice;

        // Function to update price based on selected color and size
        function updatePrice() {
            const colorId = $('#color').val();
            const sizeId = $('#size').val();
            const productId = $('.product_id').val();

            if (colorId && sizeId) {
                $.ajax({
                    url: "/get-variant-price",
                    type: "POST",
                    data: {
                        product_id: productId,
                        color_id: colorId,
                        size_id: sizeId,
                        _token: "{{ csrf_token() }}"
                    },
                    dataType: 'json',
                    success: function(response) {
                        console.log('Response:', response);

                        if (response.success) {
                            const discountedPrice = parseFloat(response.discounted_price);
                            const originalPrice = parseFloat(response.original_price);

                            // Update global currentPrice variable
                            currentPrice = discountedPrice;

                            console.log('Discounted Price:', discountedPrice);
                            console.log('Original Price:', originalPrice);

                            // Update discounted price
                            if (!isNaN(discountedPrice)) {
                                $('#display-price').html('&#2547;' + Math.round(discountedPrice));
                            }

                            // Update original price if discount exists
                            if (response.has_discount && !isNaN(originalPrice)) {
                                $('#display-original-price').show();
                                $('#original-price-value').text(Math.round(originalPrice));
                            } else {
                                $('#display-original-price').hide();
                            }

                            console.log('Price updated successfully');
                        } else {
                            console.error('Error:', response.message);
                            // Reset to base price if error
                            currentPrice = basePrice;
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('AJAX Error:', error);
                        console.error('Response:', xhr.responseText);
                        // Reset to base price if error
                        currentPrice = basePrice;
                    }
                });
            } else {
                // No color/size selected, use base price
                currentPrice = basePrice;
            }
        }

        document.addEventListener("DOMContentLoaded", function() {
            // Image gallery code
            let slides = document.querySelectorAll('.single-product-gallery-item');
            let thumbnails = document.querySelectorAll('.single-product-gallery-thumbs .item a');
            let currentIndex = 0;

            function showSlide(index) {
                slides.forEach(slide => slide.style.display = "none");
                thumbnails.forEach(thumb => thumb.classList.remove("active"));
                if (slides[index]) {
                    slides[index].style.display = "block";
                    thumbnails[index].classList.add("active");
                }
            }

            if (slides.length > 0) {
                showSlide(currentIndex);
            }

            thumbnails.forEach((thumb, index) => {
                thumb.addEventListener("click", function(event) {
                    event.preventDefault();
                    let clickedIndex = Array.from(thumbnails).indexOf(this);
                    currentIndex = clickedIndex;
                    showSlide(currentIndex);
                });
            });
        });

        $(document).ready(function() {
            // Color change event
            $('#color').on('change', function() {
                console.log('Color changed');
                updatePrice();
            });

            // Size change event
            $('#size').on('change', function() {
                console.log('Size changed');
                updatePrice();
            });

            // Fixed quantity increment/decrement - শুধু একবার bind করুন
            var qtyInput = $('input[name="qty"]');

            // Remove all previous click handlers
            $('.plus').off('click');
            $('.minus').off('click');

            // Add new click handlers
            $('.plus').on('click', function(e) {
                e.preventDefault();
                e.stopPropagation(); // এটি important
                var currentVal = parseInt(qtyInput.val()) || 1;
                qtyInput.val(currentVal + 1);
            });

            $('.minus').on('click', function(e) {
                e.preventDefault();
                e.stopPropagation(); // এটি important
                var currentVal = parseInt(qtyInput.val()) || 1;
                if (currentVal > 1) {
                    qtyInput.val(currentVal - 1);
                }
            });
        });

        function addToCartBtnForProductDetails(product_id) {
            $('.add_to_cart_product_info .color_id_errors').text('');
            $('.add_to_cart_product_info .size_id_errors').text('');

            var quantity = $('#qty').val() || 1;
            var color_id = $('#color').val() || '';
            var size_id = $('#size').val() || '';

            var url = "{{ route('cart.customer.customerCartStore') }}";

            $.ajax({
                type: "POST",
                dataType: 'json',
                data: {
                    product_id: product_id,
                    qty: quantity,
                    color_id: color_id,
                    size_id: size_id,
                    price: currentPrice, // বর্তমান price পাঠান
                    _token: "{{ csrf_token() }}"
                },
                url: url,
                success: function(res) {
                    if (res.status == true) {
                        if (res.type == 'success') {
                            success_msg('' + res.message);
                            getAddToCartData();
                        } else if (res.type == 'increase') {
                            success_msg('' + res.message);
                            getAddToCartData();
                        } else {
                            error_msg('' + res.message);
                        }
                    } else {
                        if (res.errors && Object.keys(res.errors).length > 0) {
                            Object.entries(res.errors).forEach(([field, messages]) => {
                                if (field === 'color_id') {
                                    $('.add_to_cart_product_info .color_id_errors').text(messages[0]);
                                }
                                if (field === 'size_id') {
                                    $('.add_to_cart_product_info .size_id_errors').text(messages[0]);
                                }
                                messages.forEach(message => {
                                    error_msg(message);
                                });
                            });
                        } else {
                            error_msg('' + res.message);
                        }
                    }
                },
                error: function() {
                    error_msg('Something went wrong!');
                }
            })
        }
    </script>


    <script>
        @if ($errors->any())
            @foreach ($errors->all() as $error)
                flasher['error'](@json($error), {
                    timeout: 1500
                });
            @endforeach
        @endif

        document.addEventListener("DOMContentLoaded", function() {
            let slides = document.querySelectorAll('.single-product-gallery-item');
            let thumbnails = document.querySelectorAll('.single-product-gallery-thumbs .item a');
            let currentIndex = 0;
            const totalSlides = slides.length;

            function showSlide(index) {
                // Hide all slides
                slides.forEach(slide => slide.style.display = "none");
                thumbnails.forEach(thumb => thumb.classList.remove("active"));

                // Show the selected slide
                slides[index].style.display = "block";
                thumbnails[index].classList.add("active");
            }

            // Initialize - show the first slide
            showSlide(currentIndex);

            // When a thumbnail is clicked
            thumbnails.forEach((thumb, index) => {
                thumb.addEventListener("click", function(event) {
                    event.preventDefault();
                    let clickedIndex = Array.from(thumbnails).indexOf(this);
                    currentIndex = clickedIndex;
                    showSlide(currentIndex);
                });
            });
        });

        $(document).ready(function() {
            $('.cart-quantity').each(function() {
                var container = $(this);
                var input = container.find('input[name="qty"]');

                container.find('.plus').click(function() {
                    var currentVal = parseInt(input.val());
                    if (!isNaN(currentVal)) {
                        input.val(currentVal + 1);
                    }
                });

                container.find('.minus').click(function() {
                    var currentVal = parseInt(input.val());
                    if (!isNaN(currentVal) && currentVal > 1) {
                        input.val(currentVal - 1);
                    }
                });
            });
        });

        function addToCartBtnForProductDetails(product_id) {

            $('.add_to_cart_product_info .color_id_errors').text('');
            $('.add_to_cart_product_info .size_id_errors').text('');

            var quantity = $('.add_to_cart_product_info #qty').val() || 1;
            var color_id = $('.add_to_cart_product_info #color').val() || '';
            var size_id = $('.add_to_cart_product_info #size').val() || '';

            var url = "{{ route('cart.customer.customerCartStore') }}";

            $.ajax({
                type: "POST",
                dataType: 'json',
                data: {
                    product_id: product_id,
                    qty: quantity,
                    color_id: color_id,
                    size_id: size_id,
                    _token: "{{ csrf_token() }}"
                },
                url: url,
                success: function(res) {

                    if (res.status == true) {
                        if (res.type == 'success') {
                            success_msg('' + res.message);
                            getAddToCartData();
                        } else if (res.type == 'increase') {
                            success_msg('' + res.message);
                            getAddToCartData();
                        } else {
                            error_msg('' + res.message);
                        }
                    } else {
                        if (res.errors && Object.keys(res.errors).length > 0) {
                            Object.entries(res.errors).forEach(([field, messages]) => {
                                // Display field-specific error messages
                                if (field === 'color_id') {
                                    $('.add_to_cart_product_info .color_id_errors').text(messages[0]);
                                }
                                if (field === 'size_id') {
                                    $('.add_to_cart_product_info .size_id_errors').text(messages[0]);
                                }

                                // Optionally show all messages as general error notifications
                                messages.forEach(message => {
                                    error_msg(message);
                                });
                            });
                        } else {
                            error_msg('' + res.message);
                        }
                    }
                },
                error: function() {
                    error_msg('Somethis Errors!');
                }
            })
        }
    </script>
@endpush
