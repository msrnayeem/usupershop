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
                font-size:14px !important;
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
            .products {
                height: 274px !important;
                margin-bottom: 5px !important;
            }

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
                                    <div class="row store-products" style="display:flex;flex-wrap:wrap;">
                                        @forelse ($allData as $product)
                                            <div class="col-sm-6 col-md-3 col-xs-6" style="display:flex;padding:6px;">
                                                @include('frontend.components.product-card', ['product' => $product])
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
