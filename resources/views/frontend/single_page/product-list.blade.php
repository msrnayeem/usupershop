@extends('frontend.layouts.master')
@section('title', $meta_title ?? 'Products | ' . config('app.name'))

@section('meta_description', $meta_description ?? 'Browse our wide range of products at ' . config('app.name') . '. Shop
    high-quality items, enjoy fast delivery and affordable prices.')

@section('meta_keywords', $meta_keywords ?? 'Products, Online Shop, ' . config('app.name') . ', Best Products, Quality
    Items')

@section('meta_author', config('app.name'))

@push('meta')
    {{-- Open Graph / Facebook --}}
    <meta property="og:title" content="{{ $meta_title ?? 'Products - ' . config('app.name') }}" />
    <meta property="og:description"
        content="{{ $meta_description ?? 'Browse high-quality products at ' . config('app.name') . '. Shop easily with fast delivery and affordable prices.' }}" />
    <meta property="og:image" content="{{ $meta_image ?? asset('frontend/images/og-default.jpg') }}" />
    <meta property="og:url" content="{{ url()->current() }}" />
    <meta property="og:type" content="website" />

    {{-- Twitter Card --}}
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $meta_title ?? 'Products - ' . config('app.name') }}">
    <meta name="twitter:description"
        content="{{ $meta_description ?? 'Browse high-quality products at ' . config('app.name') . '. Shop easily with fast delivery and affordable prices.' }}">
    <meta name="twitter:image" content="{{ $meta_image ?? asset('frontend/images/og-default.jpg') }}">
@endpush


@section('custom_css')
    <style>
        .store-products {
            margin: auto !important;
        }

        .store-products .col-sm-6 {
            padding: 6px;
        }

        .category-carousel .item {
            margin: 0px;
        }

        .products {
            height: 274px;
        }

        .products {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        @media (max-width: 576px) {
            .col-xs-6 {
                flex: 0 0 100%;
                max-width: 100%;
            }

            .products {
                height: 274px !important;
                margin-bottom: 5px !important;
            }

            .product-info .name a {
                font-size: 12px !important;
            }

            .product-price {
                font-size: 14px;
            }

            .add-cart-button .btn {
                font-size: 13px;
                padding: 6px 10px;
            }
        }

        @media (max-width: 376px) {
            .products {
                margin-bottom: 5px !important;
            }

            .product-info .name a {
                font-size: 12px !important;
            }

            .product-price {
                font-size: 12px;
            }

            .add-cart-button .btn {
                font-size: 13px;
                padding: 6px 4px;
            }
        }

        @media (max-width: 476px) {
            .products {
                height: 274px !important;
                margin-bottom: 5px !important;
            }

            .product-info .name a {
                font-size: 12px !important;
            }

            .product-price {
                font-size: 12px;
            }

            .add-cart-button .btn {
                font-size: 11px;
                padding: 4px 4px;
            }
        }
    </style>
@endsection
@section('content')

    <div class="body-content" style="margin-top: 4px;">
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
                                    $categories = Helper::getCategories();
                                @endphp
                                @foreach ($categories as $category)
                                    <li class="dropdown menu-item">
                                        <a class="english_lang"
                                            href="{{ route('category.wise.product', $category->category_id) }}"><i
                                                class="icon fa fa-arrow-circle-o-right"></i>
                                            {{ $category['category']['name'] }}
                                        </a>

                                        <a class="bangla_lang" style="display: none"
                                            href="{{ route('category.wise.product', $category->category_id) }}"><i
                                                class="icon fa fa-arrow-circle-o-right"></i>
                                            {{ $category['category']['name_bn'] }}
                                        </a>
                                        <!-- /.dropdown-menu -->
                                    </li>
                                @endforeach
                            </ul><!-- /.nav -->
                        </nav>
                    </div>

                </div><!-- /.sidebar -->
                <div class='col-md-9'>
                    <div class="row">
                        <div class="col-md-12">
                            <div id="category" class="category-carousel hidden-xs">
                                <div class="item">
                                    <div class="image">
                                        <img style="width: 100%;height:200px"
                                            src="{{ asset('frontend') }}/assets/images/banners/order_animation.jpg"
                                            alt="" class="img-responsive">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- ================ SECTION – HERO : END ============== -->
                    <div class="row">
                        <div class="col-md-12" style="padding: 0px 5px;">
                            <div class="card">
                                <div class="card-header">
                                    <div class="breadcrumb" style="padding: 10px 0px;">
                                        <div class="breadcrumb-inner">
                                            <ul class="list-inline list-unstyled">
                                                <li><a href="#">Home</a></li>
                                                <li class='active'>{{ $pageTitle }}</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <div class="row store-products">
                                        @forelse ($allData as $product)
                                            <div class="col-sm-6 col-md-3 col-xs-6 ">
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
                                                    <div class="productButtons">
                                                        <span class="icon productCartBtn" title="Add Cart"
                                                            data-toggle="modal" data-target="#cartModal"
                                                            id="{{ $product->id }}"
                                                            onclick="productView({{ $product->id }})">
                                                            <i class="fa fa-shopping-cart"></i></span>
                                                    </div>
                                                </div>
                                            </div>
                                        @empty
                                            <div class="col-sm-12 col-md-12 col-xs-12 " style="margin: 10px 0px;">
                                                <div class="product">
                                                    <div class="product-info text-center">
                                                        <h3 class="name">No products found in this category.</h3>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforelse
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            {{ $allData->links('vendor.pagination.custom') }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container -->
    </div><!-- /.body-content -->
@endsection
