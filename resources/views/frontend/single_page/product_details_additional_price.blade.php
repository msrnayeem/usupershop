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
    <meta property="og:image" content="{{ asset('storage/products/' . $productDetails->image) }}" />
    <meta property="og:url" content="{{ url()->current() }}" />
    <meta property="og:type" content="product" />

    {{-- Twitter Card --}}
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $productDetails->name }} - {{ config('app.name') }}">
    <meta name="twitter:description"
        content="{{ $productDetails->meta_description ?? Str::limit(strip_tags($productDetails->description), 160) }}">
    <meta name="twitter:image" content="{{ asset('storage/products/' . $productDetails->image) }}">
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

        /* Variant specific styles */
        .variant-stock-info {
            font-size: 14px;
            margin-top: 5px;
            color: #666;
        }

        .out-of-stock-variant {
            color: #dc3545;
            font-weight: 600;
        }

        .in-stock-variant {
            color: #28a745;
            font-weight: 600;
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
                                        <!-- Hidden inputs for variant data -->
                                        <input type="hidden" id="base_price" value="{{ $productDetails->price }}">
                                        <input type="hidden" id="base_discount" value="{{ $productDetails->discount }}">
                                        <input type="hidden" id="discount_type"
                                            value="{{ $productDetails->discount_type }}">
                                        <input type="hidden" id="variants_data"
                                            value="{{ json_encode($productDetails->variants) }}">

                                        <div class="product-info">
                                            <h3 class="name english_lang">{{ $productDetails->name }}</h3>
                                            <h3 class="name bangla_lang" style="display: none;">
                                                {{ $productDetails->name_bn }}
                                            </h3>
                                            <p class="attribute"><strong>Category :</strong>
                                                {{ $productDetails->category->name }}</p>

                                            <p class="attribute"><strong>Availability :</strong>
                                                <span id="stock_status">
                                                    {!! $productDetails->quantity > 0 || $productDetails->hasVariantsInStock()
                                                        ? '<span class="value" style="color:#4caf50 !important">In Stock</span>'
                                                        : '<span class="text-danger">Out Of Stock</span>' !!}
                                                </span>
                                            </p>

                                            <div class="variant-stock-info" id="variant_stock_info" style="display: none;">
                                                <span id="variant_stock_text"></span>
                                            </div>

                                            @if ($productDetails->sku)
                                                <p class="text-scondary mt-6 attribute"><strong>Product Code :</strong>
                                                    <span id="product_sku">{{ $productDetails->sku }}</span>
                                                </p>
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
                                                            <span class="price" id="display_price">
                                                                @if (!empty($productDetails->discount))
                                                                    @if ($productDetails->discount_type == 1)
                                                                        &#2547;{{ $productDetails->price - ($productDetails->price * $productDetails->discount) / 100 }}
                                                                    @else
                                                                        &#2547;{{ $productDetails->price - $productDetails->discount }}
                                                                    @endif
                                                                @else
                                                                    &#2547;{{ $productDetails->price }}
                                                                @endif
                                                            </span>

                                                            <span class="price-strike" id="original_price"
                                                                style="{{ empty($productDetails->discount) ? 'display: none;' : '' }}">
                                                                &#2547;{{ $productDetails->price }}
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div><!-- /.row -->


                                                @if ($productDetails->quantity > 0 || $productDetails->hasVariantsInStock())
                                                    <div class="row mt-3">
                                                        @if ($productDetails->variants && $productDetails->variants->count() > 0)
                                                            <!-- Show variant dropdowns if product has variants -->
                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <label for="color">Select Color</label>
                                                                    <select class="form-control select2 color_id"
                                                                        id="color" name="color_id">
                                                                        <option value="">Select Color</option>
                                                                        @foreach ($productDetails->getAvailableColors() as $color)
                                                                            <option value="{{ $color->id }}">
                                                                                {{ $color->name }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                    <span class="text-danger color_id_errors"></span>
                                                                </div>
                                                            </div>

                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <label for="size">Select Size</label>
                                                                    <select class="form-control select2 size_id"
                                                                        id="size" name="size_id">
                                                                        <option value="">Select Size</option>
                                                                        @foreach ($productDetails->getAvailableSizes() as $size)
                                                                            <option value="{{ $size->id }}">
                                                                                {{ $size->name }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                    <span class="text-danger size_id_errors"></span>
                                                                </div>
                                                            </div>
                                                        @else
                                                            <!-- Show original color/size dropdowns if no variants -->
                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <label for="color">Select Color</label>
                                                                    <select class="form-control select2 color_id"
                                                                        id="color" name="color_id">
                                                                        <option value="">Select Color</option>
                                                                        @foreach ($productDetails->product_colors as $color)
                                                                            <option value="{{ $color->id }}">
                                                                                {{ $color->color->name }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                    <span class="text-danger color_id_errors"></span>
                                                                </div>
                                                            </div>

                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <label for="size">Select Size</label>
                                                                    <select class="form-control select2 size_id"
                                                                        id="size" name="size_id">
                                                                        <option value="">Select Size</option>
                                                                        @foreach ($productDetails->product_sizes as $size)
                                                                            <option value="{{ $size->id }}">
                                                                                {{ $size->size->name }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                    <span class="text-danger size_id_errors"></span>
                                                                </div>
                                                            </div>
                                                        @endif
                                                    </div><!-- /.row -->
                                                @endif


                                            </div><!-- /.price-container -->

                                            @if ($productDetails->quantity > 0 || $productDetails->hasVariantsInStock())
                                                <div class="quantity-container info-container">
                                                    <div class="row">
                                                        <div class="col-sm-12">
                                                            <div class="cart-quantity-sction">
                                                                <label for="qty">QTY : </label>
                                                                <div class="cart-quantity">
                                                                    <button type="button"
                                                                        class="arrow minus gradient"><span
                                                                            class="ir"><i
                                                                                class=" fa fa-minus"></i></span></button>
                                                                    <input type="text" min="1" value="1"
                                                                        name="qty" id="qty" readonly>
                                                                    <button type="button"
                                                                        class="arrow plus gradient"><span
                                                                            class="ir"><i
                                                                                class=" fa fa-plus"></i></span></button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-12"
                                                            style="margin-top: 20px; text-align: center;">
                                                            <button type="button"
                                                                onclick="addToCartBtnForProductDetails({{ $productDetails->id }})"
                                                                class="btn btn-primary" id="add_to_cart_btn">
                                                                <i class="fa fa-shopping-cart inner-right-vs"></i> ADD TO
                                                                CART
                                                            </button>
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
                                                        @if (!empty($product->discount))
                                                            <span class="price">
                                                                @if ($product->discount_type == 1)
                                                                    &#2547;
                                                                    {{ $product->price - ($product->price * $product->discount) / 100 }}
                                                                @else
                                                                    &#2547;
                                                                    {{ $product->price - $product->discount }}
                                                                @endif
                                                            </span>
                                                        @else
                                                            <span class="price">&#2547;
                                                                {{ $product->price }}</span>
                                                        @endif

                                                        @if (!empty($product->discount))
                                                            <span class="price-before-discount">&#2547;
                                                                {{ $product->price }}</span>
                                                        @endif
                                                    </div><!-- /.product-price -->

                                                </div><!-- /.product-info -->
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

        // Product variant data
        let productVariants = JSON.parse(document.getElementById('variants_data').value);
        let basePrice = parseFloat(document.getElementById('base_price').value);
        let baseDiscount = parseFloat(document.getElementById('base_discount').value) || 0;
        let discountType = parseInt(document.getElementById('discount_type').value) || 0;
        let currentVariant = null;

        // Function to find variant by color and size
        function findVariant(colorId, sizeId) {
            return productVariants.find(variant =>
                variant.color_id == colorId && variant.size_id == sizeId
            );
        }

        // Function to update price display
        function updatePriceDisplay(variant) {
            let finalPrice = basePrice;
            let originalPrice = basePrice;

            if (variant && variant.additional_price) {
                finalPrice = parseFloat(variant.additional_price);
                originalPrice = finalPrice;
            }

            // Apply discount if exists
            let discountedPrice = finalPrice;
            if (baseDiscount > 0) {
                if (discountType == 1) { // Percentage
                    discountedPrice = finalPrice - (finalPrice * baseDiscount / 100);
                } else { // Fixed amount
                    discountedPrice = finalPrice - baseDiscount;
                }
            }

            // Update price elements
            if (baseDiscount > 0) {
                document.getElementById('display_price').innerHTML = '&#2547;' + discountedPrice.toFixed(0);
                document.getElementById('original_price').innerHTML = '&#2547;' + originalPrice.toFixed(0);
                document.getElementById('original_price').style.display = 'inline';
            } else {
                document.getElementById('display_price').innerHTML = '&#2547;' + finalPrice.toFixed(0);
                document.getElementById('original_price').style.display = 'none';
            }
        }

        // Function to update stock status
        function updateStockStatus(variant) {
            let stockStatusEl = document.getElementById('stock_status');
            let variantStockEl = document.getElementById('variant_stock_info');
            let variantStockText = document.getElementById('variant_stock_text');
            let addToCartBtn = document.getElementById('add_to_cart_btn');

            if (variant) {
                if (variant.stock_quantity > 0) {
                    stockStatusEl.innerHTML = '<span class="value" style="color:#4caf50 !important">In Stock</span>';
                    variantStockText.innerHTML = '<span class="in-stock-variant">(' + variant.stock_quantity +
                        ') Available</span>';
                    variantStockEl.style.display = 'block';
                    addToCartBtn.style.display = 'inline-block';
                } else {
                    stockStatusEl.innerHTML = '<span class="text-danger">Out Of Stock</span>';
                    variantStockText.innerHTML = '<span class="out-of-stock-variant">This variant is out of stock</span>';
                    variantStockEl.style.display = 'block';
                    addToCartBtn.style.display = 'none';
                }
            } else {
                // Reset to original stock status
                variantStockEl.style.display = 'none';
                // Show original stock status logic here
            }
        }

        // Function to update SKU if variant has one
        function updateSKU(variant) {
            let skuEl = document.getElementById('product_sku');
            if (variant && variant.sku && skuEl) {
                skuEl.textContent = variant.sku;
            }
        }

        // Event listeners for color and size selection
        document.addEventListener("DOMContentLoaded", function() {
            let slides = document.querySelectorAll('.single-product-gallery-item');
            let thumbnails = document.querySelectorAll('.single-product-gallery-thumbs .item a');
            let currentIndex = 0;
            const totalSlides = slides.length;

            function showSlide(index) {
                slides.forEach(slide => slide.style.display = "none");
                thumbnails.forEach(thumb => thumb.classList.remove("active"));
                slides[index].style.display = "block";
                thumbnails[index].classList.add("active");
            }

            showSlide(currentIndex);

            thumbnails.forEach((thumb, index) => {
                thumb.addEventListener("click", function(event) {
                    event.preventDefault();
                    let clickedIndex = Array.from(thumbnails).indexOf(this);
                    currentIndex = clickedIndex;
                    showSlide(currentIndex);
                });
            });

            // Variant selection handlers
            $('#color, #size').on('change', function() {
                let colorId = $('#color').val();
                let sizeId = $('#size').val();

                if (colorId && sizeId) {
                    currentVariant = findVariant(colorId, sizeId);
                    if (currentVariant) {
                        updatePriceDisplay(currentVariant);
                        updateStockStatus(currentVariant);
                        updateSKU(currentVariant);
                    } else {
                        // Reset to original if variant combination not found
                        currentVariant = null;
                        updatePriceDisplay(null);
                        document.getElementById('variant_stock_info').style.display = 'none';
                    }
                } else {
                    // Reset to original when either color or size is not selected
                    currentVariant = null;
                    updatePriceDisplay(null);
                    document.getElementById('variant_stock_info').style.display = 'none';
                }
            });
        });

        $(document).ready(function() {
            $('.cart-quantity').each(function() {
                var container = $(this);
                var input = container.find('input[name="qty"]');

                container.find('.plus').click(function() {
                    var currentVal = parseInt(input.val());
                    if (!isNaN(currentVal)) {
                        // Check stock limit if variant is selected
                        if (currentVariant && currentVariant.stock_quantity) {
                            if (currentVal < currentVariant.stock_quantity) {
                                input.val(currentVal + 1);
                            } else {
                                error_msg('Maximum available quantity is ' + currentVariant
                                    .stock_quantity);
                            }
                        } else {
                            input.val(currentVal + 1);
                        }
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
            var variant_id = null;

            // If product has variants and both color and size are selected
            if (productVariants.length > 0 && color_id && size_id) {
                var selectedVariant = findVariant(color_id, size_id);
                if (selectedVariant) {
                    variant_id = selectedVariant.id;

                    // Check stock for selected variant
                    if (selectedVariant.stock_quantity < quantity) {
                        error_msg('Only ' + selectedVariant.stock_quantity + ' items available for this variant');
                        return;
                    }
                } else {
                    error_msg('Selected variant is not available');
                    return;
                }
            }

            var url = "{{ route('cart.customer.customerCartStore') }}";

            $.ajax({
                type: "POST",
                dataType: 'json',
                data: {
                    product_id: product_id,
                    qty: quantity,
                    color_id: color_id,
                    size_id: size_id,
                    variant_id: variant_id, // Send variant ID if available
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
@endpush
