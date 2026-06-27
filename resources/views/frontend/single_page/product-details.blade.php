@extends('frontend.layouts.master')
@section('title', $productDetails->meta_title ?? $productDetails->name . ' | ' . config('app.name'))

@section('meta_description', $productDetails->meta_description ?? Str::limit(strip_tags($productDetails->description),
    160))
@section('meta_keywords', $productDetails->meta_keywords ?? ($productDetails->tags ?? $productDetails->name))
@section('meta_author', config('app.name'))

@push('meta')
    <meta property="og:title" content="{{ $productDetails->name }} - {{ config('app.name') }}" />
    <meta property="og:description"
        content="{{ $productDetails->meta_description ?? Str::limit(strip_tags($productDetails->description), 160) }}" />
    <meta property="og:image" content="{{ asset('storage/products/' . $productDetails->image) }}" />
    <meta property="og:url" content="{{ url()->current() }}" />
    <meta property="og:type" content="product" />

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $productDetails->name }} - {{ config('app.name') }}">
    <meta name="twitter:description"
        content="{{ $productDetails->meta_description ?? Str::limit(strip_tags($productDetails->description), 160) }}">
    <meta name="twitter:image" content="{{ asset('storage/products/' . $productDetails->image) }}">

    {{-- JSON-LD Schema for Product --}}
    <script type="application/ld+json">
    {
      "@context": "https://schema.org/",
      "@type": "Product",
      "name": "{{ $productDetails->name }}",
      "image": [
        "{{ asset('storage/products/' . $productDetails->image) }}"
        @if($product_sub_image->count() > 0)
        @foreach($product_sub_image as $img)
        ,"{{ asset('upload/product_images/product_sub_images/' . $img->sub_image) }}"
        @endforeach
        @endif
       ],
      "description": "{{ Str::limit(strip_tags($productDetails->description), 160) }}",
      "sku": "{{ $productDetails->sku ?? $productDetails->id }}",
      "mpn": "{{ $productDetails->id }}",
      "brand": {
        "@type": "Brand",
        "name": "{{ $productDetails->brand->name ?? config('app.name') }}"
      },
      "offers": {
        "@type": "Offer",
        "url": "{{ url()->current() }}",
        "priceCurrency": "BDT",
        "price": "{{ $productDetails->discount > 0 ? ($productDetails->discount_type == 1 ? $productDetails->price - ($productDetails->price * $productDetails->discount / 100) : $productDetails->price - $productDetails->discount) : $productDetails->price }}",
        "availability": "{{ $productDetails->quantity > 0 ? 'https://schema.org/InStock' : 'https://schema.org/OutOfStock' }}",
        "itemCondition": "https://schema.org/NewCondition"
      }
    }
    </script>
@endpush

@section('custom_css')
    <style>
        .card {
            border: 1px solid #ddd;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 .5rem 1rem rgba(0, 0, 0, .15);
            margin-top: 15px;
        }

        /* Gallery Styles */
        #custom-single-product .single-product-gallery-item {
            position: relative;
        }

        #custom-single-product .single-product-gallery-item button {
            max-height: 520px;
            width: 100%;
            outline: none;
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 8px;
            background: #fff;
            position: relative;
            overflow: hidden;
        }

        #custom-single-product .single-product-gallery-item button img {
            max-width: 100%;
            height: auto;
            border-radius: 4px;
            transition: transform 0.3s ease;
        }

        /* Single Image Download Button */
        .download-btn {
            position: absolute;
            bottom: 15px;
            right: 15px;
            background: rgba(0, 0, 0, 0.7);
            color: white;
            border: none;
            border-radius: 50px;
            width: 50px;
            height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            cursor: pointer;
            opacity: 0;
            transition: opacity 0.3s ease;
            z-index: 10;
        }

        .single-product-gallery-item:hover .download-btn {
            opacity: 1;
        }

        .download-btn:hover {
            background: rgba(8, 36, 172, 0.9);
        }

        /* Download All Button - Inside Gallery, Bottom-Right Corner */
        .download-all-btn {
            position: absolute;
            bottom: 80px;
            /* Above thumbnails */
            right: 15px;
            background: rgba(247, 25, 154, 0.95);
            color: white;
            border: none;
            border-radius: 50px;
            width: 56px;
            height: 56px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            cursor: pointer;
            z-index: 20;
            box-shadow: 0 4px 15px rgba(247, 25, 154, 0.4);
            transition: all 0.3s ease;
        }

        .download-all-btn:hover {
            background: #e6007e;
            transform: scale(1.1);
            box-shadow: 0 6px 20px rgba(247, 25, 154, 0.6);
        }

        /* Optional: Small badge showing image count */ 
        .download-count {
            position: absolute;
            top: -8px;
            right: -8px;
            background: #ff006e;
            color: white;
            font-size:13px;
            font-weight: bold;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Mobile Adjustments */
        @media (max-width: 767px) {
            .download-all-btn {
                bottom: 70px;
                /* Adjust for smaller thumbnail row */
                right: 10px;
                width: 50px;
                height: 50px;
                font-size: 18px;
            }

            .download-count {
                font-size:13px;
                width: 18px;
                height: 18px;
                top: -6px;
                right: -6px;
            }
        }

        @media (max-width: 576px) {
            .download-all-btn {
                bottom: 65px;
            }
        }

        #custom-single-product-thumbnails {
            overflow-x: auto;
            display: flex;
            width: 100%;
            -webkit-overflow-scrolling: touch;
        }

        #custom-single-product-thumbnails::-webkit-scrollbar {
            display: none;
        }

        #custom-single-product-thumbnails .item {
            margin: 0 5px;
            flex-shrink: 0;
        }

        #custom-single-product-thumbnails .item button {
            width: 100px;
            height: 100px;
            border: 1px solid #ddd;
            border-radius: 6px;
            padding: 4px;
            background: #fff;
        }

        #custom-single-product-thumbnails .item button img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 4px;
        }

        /* Product Info */
        .product-info .attribute {
            font-size: 15px;
            margin-bottom: 8px;
            color: #555;
        }

        .single-product .product-info-block .name {
            font-size: 24px;
            font-weight: 600;
            margin-top: 0;
        }

        .price-box .price {
            font-size: 28px;
            font-weight: 700;
            color: #0824ac;
        }

        .price-box .price-strike {
            font-size: 18px;
            color: #999;
            text-decoration: line-through;
            margin-left: 12px;
        }

        /* Quantity Selector */
        .cart-quantity-sction {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .cart-quantity-sction label {
            font-weight: 600;
            margin: 0;
            font-size: 16px;
            /*min-width: 60px;*/
        }

        .cart-quantity {
            display: flex;
            align-items: center;
        }

        .cart-quantity button {
            /*width: 40px;
                                                                                                                            height: 40px;*/
            border: 1px solid #ddd;
            border-radius: 8px;
            background: #f8f9fa;
            font-size: 16px;
        }

        .cart-quantity input {
            width: 50px;
            height: 40px;
            text-align: center;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 16px;
            font-weight: bolder !important;
        }

        /* Color & Size Checkbox Buttons */
        .color-checkbox-group,
        .size-checkbox-group {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            margin-top: 10px;
        }

        .color-checkbox-group .form-check,
        .size-checkbox-group .form-check {
            margin: 0;
        }

        .color-checkbox-group .form-check-input,
        .size-checkbox-group .form-check-input {
            display: none;
        }

        .form-check-label {
            background-color: rgba(247, 25, 154, 0.9) !important;
            color: white;
            font-weight: 600;
        }

        .color-checkbox-group .form-check-label,
        .size-checkbox-group .form-check-label {
            /*min-width: 90px;*/
            padding: 3px 10px;
            text-align: center;
            border: 2px solid #ddd;
            border-radius: 8px;
            background-color: #ffffff;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .color-checkbox-group .form-check-input:checked+.form-check-label,
        .size-checkbox-group .form-check-input:checked+.form-check-label {
            background-color: #0824ac;
            color: #ffffff;
            border-color: #0824ac;
            box-shadow: 0 4px 12px rgba(8, 36, 172, 0.25);
        }

        /* Responsive */
        @media (max-width: 767px) {
            section.single-product {
                padding-top: 100px;
            }

            .single-product .product-info-block .name {
                font-size: 20px;
            }

            .price-box .price {
                font-size: 24px;
            }

            .download-btn {
                /*opacity: 1;*/
                bottom: 10px;
                right: 10px;
                width: 44px;
                height: 44px;
                font-size: 18px;

                background: rgba(247, 25, 154, 0.9);
                color: white;
                border: none;
                border-radius: 6px;
                padding: 8px 16px;
                font-size: 14px;
                cursor: pointer;
                z-index: 10;
                display: flex;
                align-items: center;
                gap: 8px;
                box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
            }

            .download-all-btn {
                top: 10px;
                right: 10px;
                font-size: 13px;
                padding: 6px 12px;
            }
        }

        @media (max-width: 576px) {

            .color-checkbox-group .form-check-label,
            .size-checkbox-group .form-check-label {
                /*min-width: 70px;
                                                                                                                            padding: 10px 15px;*/
                font-size: 14px;
            }
        }

        .product {
            border: 1px solid #eee;
            border-radius: 8px;
            overflow: hidden;
            transition: transform 0.2s;
        }

        .product:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        }

        .minus-btn {
            background-color: red !important;
            color: white;
        }

        .plus-btn {
            background-color: #28a745 !important;
            color: white;
        }

        .copy-btn {
            background-color: rgba(247, 25, 154, 0.9) !important;
            color: white;
        }

        .add-to-cart-btn {
            background-color: rgba(247, 25, 154, 0.9) !important;
            color: white;
        }

        /* FORCE price & quantity side by side on mobile */
        @media (max-width: 767.98px) {
            .price-qty-row {
                display: flex !important;
                flex-wrap: nowrap !important;
            }

            /* Reduce column padding */
            .price-qty-row .price-col,
            .price-qty-row .qty-col {
                flex: 0 0 50% !important;
                max-width: 50% !important;
                padding-left: 5px !important;
                padding-right: 5px !important;
            }

            .price-qty-row .qty-col {
                text-align: right;
            }

            /* Reduce space inside quantity */
            .cart-quantity {
                justify-content: flex-end;
                gap: 4px;
            }

            /* Smaller buttons for mobile */
            .cart-quantity button {
                padding: 2px 6px;
                font-size:14px;
            }

            /* Smaller input */
            .cart-quantity input {
                width: 38px;
                padding: 2px;
                font-size: 16px;
                text-align: center;
                font-weight: bolder !important;
            }

            /* Reduce label spacing */
            .cart-quantity-sction label {
                margin-right: 4px;
                font-size:14px;
            }
        }

        /* add to cart button */
        /* Mobile only */
        @media (max-width: 767.98px) {
            .add-to-cart-wrapper {
                display: flex;
                gap: 8px;
            }

            .add-to-cart-wrapper .cart-btn {
                width: 50%;
                padding: 10px 5px;
                font-size: 13px;
                text-align: center;
            }
        }
    </style>
@endsection

@section('content')
    <div class="body-content outer-top-xs">
        <section class="single-product">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <!-- Product Gallery -->
                                    <div class="col-12 col-md-6 gallery-holder">
                                        <div class="product-item-holder size-big single-product-gallery small-gallery"
                                            style="position: relative;">
                                            <!-- Main Gallery Images -->
                                            <div id="custom-single-product">
                                                @foreach ($product_sub_image as $sub_image)
                                                    <div class="single-product-gallery-item"
                                                        id="slide_{{ $sub_image->id }}">
                                                        <a data-lightbox="gallery"
                                                            href="{{ !empty($sub_image->sub_image) ? asset('upload/product_images/product_sub_images/' . $sub_image->sub_image) : asset('frontend/assets/images/no-image.png') }}">
                                                            <button style="position: relative; display: block;">
                                                                <img class="img-responsive"
                                                                    style="width:100%; height:auto; border-radius: 8px;"
                                                                    src="{{ !empty($sub_image->sub_image) ? asset('upload/product_images/product_sub_images/' . $sub_image->sub_image) : asset('frontend/assets/images/no-image.png') }}"
                                                                    alt="Product Image">
                                                            </button>
                                                        </a>
                                                    </div>
                                                @endforeach
                                            </div>

                                            <!-- Download All Button - Bottom Right of Gallery Area -->
                                            <button type="button" class="download-all-btn" onclick="downloadAllImages()"
                                                title="Download All Images ({{ $product_sub_image->count() }})">
                                                <i class="fa fa-download"></i>
                                                @if ($product_sub_image->count() > 1)
                                                    <span class="download-count">{{ $product_sub_image->count() }}</span>
                                                @endif
                                            </button>

                                            <!-- Thumbnails -->
                                            <div class="single-product-gallery-thumbs gallery-thumbs mt-3">
                                                <div id="custom-single-product-thumbnails">
                                                    @foreach ($product_sub_image as $sub_image)
                                                        <div class="item">
                                                            <a class="horizontal-thumb" data-target="#custom-single-product"
                                                                data-slide="{{ $sub_image->id }}"
                                                                href="#slide_{{ $sub_image->id }}">
                                                                <button>
                                                                    <img src="{{ !empty($sub_image->sub_image) ? asset('upload/product_images/product_sub_images/' . $sub_image->sub_image) : asset('frontend/assets/images/no-image.png') }}"
                                                                        alt="Thumbnail">
                                                                </button>
                                                            </a>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Product Info -->
                                    <div class="col-12 col-md-6 product-info-block add_to_cart_product_info">
                                        <input type="hidden" id="product_id" value="{{ $productDetails->id }}">

                                        <div class="product-info">
                                            <h1 class="name english_lang">{{ $productDetails->name }}</h1>
                                            <h1 class="name bangla_lang" style="display:none;">
                                                {{ $productDetails->name_bn }}</h1>

                                            <p class="attribute"><strong>Category:</strong>
                                                {{ $productDetails->category->name }}</p>

                                            <p class="attribute">
                                                <strong>Availability:</strong>
                                                {!! $productDetails->quantity > 0
                                                    ? '<span style="color:#28a745; font-weight:600;">(' . $productDetails->quantity . ') In Stock</span>'
                                                    : '<span class="text-danger font-weight-bold">Out of Stock</span>' !!}
                                            </p>

                                            @if ($productDetails->sku)
                                                <p class="attribute"><strong>Product Code:</strong>
                                                    {{ $productDetails->sku }}</p>
                                            @endif

                                            @if ($productDetails->short_desc)
                                                <div class="description-container english_lang mt-3">{!! $productDetails->short_desc !!}
                                                </div>
                                            @endif
                                            @if ($productDetails->short_desc_bn)
                                                <div class="description-container bangla_lang" style="display:none;">
                                                    {!! $productDetails->short_desc_bn !!}</div>
                                            @endif

                                            <!-- Price and Quantity in One Row (2 Columns) -->
                                            {{-- <div class="price-container mt-4">
                                                <div class="row align-items-center">
                                                    <div class="col-6 ">
                                                        <div class="price-box">
                                                            @php
                                                                $price = $productDetails->price;
                                                                $discount = $productDetails->discount ?? 0;
                                                                $finalPrice =
                                                                    $discount > 0
                                                                        ? ($productDetails->discount_type == 1
                                                                            ? $price - ($price * $discount) / 100
                                                                            : $price - $discount)
                                                                        : $price;
                                                            @endphp

                                                            <span id="product-price"
                                                                class="price">৳{{ number_format($finalPrice, 2) }}</span><br>
                                                            @if ($discount > 0)
                                                                <span id="product-original-price"
                                                                    class="price-strike">৳{{ number_format($price, 2) }}</span>
                                                            @else
                                                                <span id="product-original-price"
                                                                    class="price-strike d-none">৳{{ number_format($price, 2) }}</span>
                                                            @endif
                                                        </div>
                                                    </div>

                                                    @if ($productDetails->quantity > 0)
                                                        <div class="col-6">
                                                            <div class="cart-quantity-sction">
                                                                <label for="qty">QTY:</label>
                                                                <div class="cart-quantity">
                                                                    <button type="button"
                                                                        class="arrow minus-btn btn-outline-danger  btn-sm">
                                                                        <i class="fa fa-minus"></i>
                                                                    </button>
                                                                    <input type="text" id="qty" name="qty"
                                                                        value="1" readonly>
                                                                    <button type="button"
                                                                        class="arrow plus-btn btn-outline-success btn-sm">
                                                                        <i class="fa fa-plus"></i>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div> --}}

                                            <!-- Price and Quantity in One Row -->
                                            <div class="price-container mt-4">
                                                <div class="row align-items-center price-qty-row">

                                                    <!-- Price -->
                                                    <div class="col-6 col-md-6 price-col">
                                                        <div class="price-box">
                                                            @php
                                                                $price = $productDetails->price;
                                                                $discount = $productDetails->discount ?? 0;
                                                                
                                                                // Check if user is dropshipper and product has hole sale price
                                                                if (auth()->check() && auth()->user()->usertype === 'dropshipper' && isset($productDetails->sale_price) && $productDetails->sale_price > 0) {
                                                                    $finalPrice = $productDetails->sale_price;
                                                                    $showOriginalPrice = false;
                                                                } else {
                                                                    // Regular customer pricing
                                                                    $finalPrice =
                                                                        $discount > 0
                                                                            ? ($productDetails->discount_type == 1
                                                                                ? $price - ($price * $discount) / 100
                                                                                : $price - $discount)
                                                                            : $price;
                                                                    $showOriginalPrice = $discount > 0;
                                                                }
                                                            @endphp

                                                            <span id="product-price"
                                                                class="price">৳{{ number_format($finalPrice, 2) }}</span>
                                                            
                                                            @if (auth()->check() && auth()->user()->usertype === 'dropshipper' && isset($productDetails->sale_price) && $productDetails->sale_price > 0)
                                                                <span class="badge badge-success ml-2">Wholesale Price</span>
                                                            @endif
                                                            
                                                            <br>
                                                            @if ($showOriginalPrice ?? false)
                                                                <span id="product-original-price"
                                                                    class="price-strike">৳{{ number_format($price, 2) }}</span>
                                                            @else
                                                                <span id="product-original-price"
                                                                    class="price-strike d-none">৳{{ number_format($price, 2) }}</span>
                                                            @endif
                                                        </div>
                                                    </div>

                                                    <!-- Quantity -->
                                                    @if ($productDetails->quantity > 0)
                                                        <div class="col-6 col-md-6 qty-col">
                                                            <div class="cart-quantity-sction">
                                                                <label for="qty" class="me-1">QTY:</label>
                                                                <div class="cart-quantity d-flex align-items-center">
                                                                    <button type="button"
                                                                        class="arrow minus-btn btn-outline-danger btn-sm">
                                                                        <i class="fa fa-minus"></i>
                                                                    </button>

                                                                    <input type="text" id="qty" name="qty"
                                                                        value="1" readonly class="mx-1">

                                                                    <button type="button"
                                                                        class="arrow plus-btn btn-outline-success btn-sm">
                                                                        <i class="fa fa-plus"></i>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif

                                                </div>
                                            </div>


                                            <!-- Color & Size Selection -->
                                            @if ($productDetails->quantity > 0 && $productDetails->product_colors->isNotEmpty())
                                                <div class="row mt-4">
                                                    <div class="col-12" style="margin-left: 10px;">
                                                        <label class="font-weight-bold">Select Color <span
                                                                class="text-danger">*</span></label>
                                                        <div class="color-checkbox-group">
                                                            @foreach ($productDetails->product_colors as $color)
                                                                <div class="form-check">
                                                                    <input class="form-check-input color-checkbox"
                                                                        type="checkbox" name="color_id"
                                                                        value="{{ $color->id }}"
                                                                        id="color_{{ $color->id }}"
                                                                        data-color-id="{{ $color->color_id }}">
                                                                    <label class="form-check-label"
                                                                        for="color_{{ $color->id }}">
                                                                        {{ $color->color->name }}
                                                                    </label>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                        <span class="text-danger color_id_errors"></span>
                                                    </div>
                                                </div>
                                            @endif

                                            @if ($productDetails->quantity > 0 && $productDetails->product_sizes->isNotEmpty())
                                                <div class="row mt-4">
                                                    <div class="col-12 " style="margin-left: 10px;">
                                                        <label class="font-weight-bold">Select Size <span
                                                                class="text-danger">*</span></label>
                                                        <div class="size-checkbox-group">
                                                            @foreach ($productDetails->product_sizes as $size)
                                                                <div class="form-check">
                                                                    <input class="form-check-input size-checkbox"
                                                                        type="checkbox" name="size_id"
                                                                        value="{{ $size->id }}"
                                                                        id="size_{{ $size->id }}"
                                                                        data-size-id="{{ $size->size_id }}">
                                                                    <label class="form-check-label"
                                                                        for="size_{{ $size->id }}">
                                                                        {{ $size->size->name }}
                                                                    </label>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                        <span class="text-danger size_id_errors"></span>
                                                    </div>
                                                </div>
                                            @endif

                                            <!-- Add to Cart / Dropshipper -->
                                            @if ($productDetails->quantity > 0)
                                                <div class="mt-5">
                                                    @if (auth()->check() && auth()->user()->usertype === 'dropshipper')
                                                        <div class="row mb-4">
                                                            <!-- My Selling Price -->
                                                            <div class="col-md-6 col-12 mb-3 mb-md-0">
                                                                <div class="form-group">
                                                                    <label class="font-weight-bold">My Selling Price</label>
                                                                    <input type="number" id="selling_price" name="selling_price"
                                                                        step="0.01"
                                                                        class="form-control @error('selling_price') is-invalid @enderror"
                                                                        placeholder="Enter your selling price"
                                                                        oninput="showProfit()" required>
                                                                    <small class="text-info d-block mt-2 fw-bold"
                                                                        style="font-size:14px; font-weight: 600;">
                                                                        Allowed Range: ৳{{ number_format($productDetails->min_price, 2) }} - ৳{{ number_format($productDetails->max_price, 2) }}
                                                                    </small>
                                                                    <input type="hidden" id="product-dropshipper-price"
                                                                        value="{{ $finalPrice }}">
                                                                    @error('selling_price')
                                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                                    @enderror
                                                                </div>
                                                            </div>

                                                            <!-- My Profit -->
                                                            <div class="col-md-6 col-12">
                                                                <div class="form-group">
                                                                    <label class="font-weight-bold">My Profit</label>
                                                                    <div class="form-control bg-light" 
                                                                        style="font-size: 18px; font-weight: 700; color: #28a745; border: 2px solid #28a745;">
                                                                        <span id="profit_display_main">৳0.00</span>
                                                                    </div>
                                                                    <small class="text-muted d-block mt-2" style="font-size:14px;">
                                                                        Base Price: ৳<span id="base_price_display">{{ number_format($finalPrice, 2) }}</span>
                                                                    </small>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif

                                                    <div class="add-to-cart-wrapper">
                                                        <button type="button"
                                                            onclick="addToCartBtnForProductDetails({{ $productDetails->id }})"
                                                            class="btn add-to-cart-btn btn-lg shadow cart-btn">
                                                            <i class="fa fa-shopping-cart me-1"></i> ADD TO CART
                                                        </button>

                                                        <a href="javascript:void(0)"
                                                            onclick="addToCartBtnForProductDetails({{ $productDetails->id }}, true)"
                                                            class="btn add-to-cart-btn btn-lg shadow cart-btn">
                                                            <i class="fa fa-shopping-cart me-1"></i> Buy Now
                                                        </a>
                                                    </div>

                                                </div>

                                                <div class="alert alert-info text-center mt-4 border border-primary"
                                                    style="margin-top: 20px;">
                                                    <strong>Please pay the delivery charge before confirming the
                                                        order.</strong>
                                                </div>
                                            @else
                                                <div class="alert alert-danger text-center mt-4">
                                                    <strong>Stock Out</strong>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Description -->
                        <div class="row mt-4">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header d-flex justify-content-between align-items-center">
                                        <h4 class="card-title mb-0">Description</h4>
                                        <button class="btn btn-sm btn-outline-primary copy-btn"
                                            onclick="copyDescription()">
                                            <i class="fa fa-copy"></i> Copy
                                        </button>
                                    </div>
                                    <div class="card-body">
                                        <div id="productDescription">{!! $productDetails->long_desc !!}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Related Products -->
        <section class="section featured-product py-5">
            <div class="container">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title mb-0">
                            {{ session()->get('language') == 'bangla' ? 'রিলেটেড প্রোডাক্টস' : 'Related Products' }}
                        </h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            @forelse($relatedProduct as $product)
                                <div class="col-sm-12 col-md-3 col-xs-12 mt-1">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="product">
                                                <div class="product-image">
                                                    <a href="{{ route('product.details.info', $product->slug) }}">
                                                        <img src="{{ $product->image ? asset('upload/product_images/' . $product->image) : asset('frontend/assets/images/no-image.png') }}"
                                                            alt="{{ $product->name }}" class="w-100"
                                                            style="height:200px; object-fit:contain; background:#f8f9fa;">
                                                    </a>
                                                </div>
                                                <div class="product-info p-2">
                                                    <h6 class="name">
                                                        <a href="{{ route('product.details.info', $product->slug) }}">
                                                            {{ Str::limit($product->name, 30, '...') }}
                                                        </a>
                                                    </h6>
                                                    <div class="product-price mt-1">
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
                                                        <strong class="text-primary">৳{{ number_format($displayPrice, 2) }}</strong>
                                                        @if ($showOriginalPrice)
                                                            <del class="text-muted small">৳{{ number_format($product->price, 2) }}</del>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="col-12 text-center py-5">
                                    <h5>No related products found.</h5>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('custom_script')
    <script>
        //var buyNowFlag = false;
        $(document).ready(function() {

            window.gotoCheckoutPage = () => {
                if (buyNowFlag) {
                    window.location.href = "{{ route('show.cart') }}";
                }
            }
            /* ==============================
                ADD TO CART
            ============================== */
            window.addToCartBtnForProductDetails = function(product_id, buyNowFlag = false) {

                $('.color_id_errors, .size_id_errors').text('');

                let quantity = $('#qty').val() || 1;
                let color_id = $('.color-checkbox:checked').val() || '';
                let size_id = $('.size-checkbox:checked').val() || '';
                let drop_selling_price = $('#selling_price').val() || '';
                let url = "{{ route('cart.customer.customerCartStore') }}";

                $.ajax({
                    type: "POST",
                    url: url,
                    dataType: 'json',
                    data: {
                        product_id: product_id,
                        qty: quantity,
                        color_id: color_id,
                        size_id: size_id,
                        drop_selling_price: drop_selling_price,
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(res) {

                        if (res.status === true) {

                            if (res.type === 'success' || res.type === 'increase') {
                                success_msg(res.message);
                                getAddToCartData();
                                if (buyNowFlag) {
                                    window.location.href = "{{ route('show.cart') }}";
                                }

                            } else {
                                error_msg(res.message);
                            }

                        } else {

                            if (res.errors) {
                                $.each(res.errors, function(field, messages) {

                                    if (field === 'color_id') {
                                        $('.color_id_errors').text(messages[0]);
                                    }

                                    if (field === 'size_id') {
                                        $('.size_id_errors').text(messages[0]);
                                    }

                                    $.each(messages, function(_, msg) {
                                        error_msg(msg);
                                    });
                                });
                            } else {
                                error_msg(res.message);
                            }
                        }
                    },
                    error: function() {
                        console.log('Something went wrong!');
                    }
                });
            };

            /* ==============================
                GALLERY SLIDER
            ============================== */
            let $slides = $('.single-product-gallery-item');
            let $thumbs = $('#custom-single-product-thumbnails a');

            function showSlide(index) {
                $slides.hide();
                $thumbs.removeClass('active');

                $slides.eq(index).show();
                $thumbs.eq(index).addClass('active');
            }

            if ($slides.length) {
                showSlide(0);

                $thumbs.on('click', function(e) {
                    e.preventDefault();
                    let clickedIndex = $thumbs.index(this);
                    showSlide(clickedIndex);
                });
            }

            /* ==============================
                QUANTITY BUTTONS
            ============================== */
            $(document).on('click', '.plus-btn', function() {
                let val = parseInt($('#qty').val()) || 1;
                $('#qty').val(val + 1);
                showProfit();
            });

            $(document).on('click', '.minus-btn', function() {
                let val = parseInt($('#qty').val()) || 1;

                if (val > 1) {
                    $('#qty').val(val - 1);
                    showProfit();
                }
            });

            /* ==============================
                COLOR & SIZE (SINGLE SELECT)
            ============================== */
            $('.color-checkbox-group .form-check-input').on('change', function() {
                $('.color-checkbox-group .form-check-input').not(this).prop('checked', false);
                updatePrice();
            });

            $('.size-checkbox-group .form-check-input').on('change', function() {
                $('.size-checkbox-group .form-check-input').not(this).prop('checked', false);
                updatePrice();
            });

            /* ==============================
                PRICE & VARIANT LOGIC
            ============================== */
            const variants = @json($productDetails->activeVariants ?? []);
            const basePrice = {{ $productDetails->price }};
            const discount = {{ $productDetails->discount ?? 0 }};
            const discountType = {{ $productDetails->discount_type ?? 0 }};

            /* ==============================
                PROFIT CALCULATION (DEFINED FIRST)
            ============================== */
            window.showProfit = function() {
                let sellingInput = $('#selling_price').val();
                let selling = parseFloat(sellingInput) || 0;
                let cost = parseFloat($('#product-dropshipper-price').val()) || 0;
                let qty = parseInt($('#qty').val()) || 1;

                // Only calculate profit if selling price is entered
                if (sellingInput && sellingInput.trim() !== '' && selling > 0) {
                    let profit = (selling * qty) - (cost * qty);
                    $('#profit_display_main').text('৳' + profit.toFixed(2));
                } else {
                    // Show 0 or placeholder when no selling price
                    $('#profit_display_main').text('৳0.00');
                }
                
                // Update base price display
                $('#base_price_display').text(cost.toFixed(2));
            };

            function updatePrice() {
                // Get the initial price from PHP (already calculated with Hole Sale Price if dropshipper)
                let initialPrice = parseFloat($('#product-dropshipper-price').val()) || {{ $finalPrice }};
                
                // Don't recalculate - just use the PHP-calculated price
                $('#product-price').text('৳' + initialPrice.toFixed(2));
                $('#product-dropshipper-price').val(initialPrice.toFixed(2));
                showProfit();
            }

            updatePrice();



            /* ==============================
                COPY DESCRIPTION
            ============================== */
            window.copyDescription = function() {
                let text = $('#productDescription').text().trim();

                navigator.clipboard.writeText(text)
                    .then(() => alert('Description copied!'))
                    .catch(() => alert('Copy failed'));
            };

        });

        /* ==============================
            IMAGE DOWNLOAD
        ============================== */
        function downloadImage(url) {
            $('<a>', {
                href: url,
                download: '{{ $productDetails->slug }}-image.jpg'
            })[0].click();
        }

        function downloadAllImages() {

            let imageUrls = [
                @foreach ($product_sub_image as $sub_image)
                    "{{ !empty($sub_image->sub_image) ? asset('upload/product_images/product_sub_images/' . $sub_image->sub_image) : asset('frontend/assets/images/no-image.png') }}",
                @endforeach
            ];

            if (!imageUrls.length) {
                alert('No images available to download.');
                return;
            }

            let index = 0;

            function downloadNext() {
                if (index < imageUrls.length) {
                    $('<a>', {
                        href: imageUrls[index],
                        download: '{{ $productDetails->slug }}-image-' + (index + 1) + '.jpg'
                    })[0].click();

                    index++;
                    setTimeout(downloadNext, 800);
                }
            }

            downloadNext();
        }
    </script>
@endpush
