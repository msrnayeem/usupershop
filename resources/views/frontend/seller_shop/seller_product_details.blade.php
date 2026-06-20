@extends('frontend.layouts.seller_master')
@section('title')
    {{ $productDetails->name }}
@endsection
@section('content')
    <div class="breadcrumb">
        <div class="container">
            <div class="breadcrumb-inner">
                <ul class="list-inline list-unstyled">
                    <li><a href="{{ url('./') }}">Home</a></li>
                    <li><a href="#">Shop</a></li>
                    <li class='active'>{{ $productDetails->name }}</li>
                </ul>
            </div><!-- /.breadcrumb-inner -->
        </div><!-- /.container -->
    </div><!-- /.breadcrumb -->
    <div class="body-content outer-top-xs">
        <div class='container'>
            <div class='row single-product'>
                <div class='col-md-3 sidebar'>
                    <div class="sidebar-module-container">
                     
                        <!-- =============== HOT DEALS ============= -->
                        <!-- <div class="sidebar-widget hot-deals wow fadeInUp outer-top-vs"> -->
                        <div class="sidebar-widget hot-deals wow fadeInUp">
                            <h3 class="section-title">hot deals</h3>
                            <div class="owl-carousel sidebar-carousel custom-carousel owl-theme outer-top-xs">
                               
                                @forelse ($hot_deals as $items)
                                    <div class="item">
                                        <div class="products" style="border:1px solid #eee;">
                                            <div class="hot-deal-wrapper">
                                                <div class="image">
                                                    <img src="{{ url('upload/product_images/' . $items->image) }}"
                                                        alt="{{ $items->name }}">
                                                </div>
                                                <div class="sale-offer-tag"><span>35%<br>off</span></div>
                                                <div class="timing-wrapper">
                                                    <div class="box-wrapper">
                                                        <div class="date box">
                                                            <span class="key">120</span>
                                                            <span class="value">Days</span>
                                                        </div>
                                                    </div>

                                                    <div class="box-wrapper">
                                                        <div class="hour box">
                                                            <span class="key">20</span>
                                                            <span class="value">HRS</span>
                                                        </div>
                                                    </div>

                                                    <div class="box-wrapper">
                                                        <div class="minutes box">
                                                            <span class="key">36</span>
                                                            <span class="value">MINS</span>
                                                        </div>
                                                    </div>

                                                    <div class="box-wrapper hidden-md">
                                                        <div class="seconds box">
                                                            <span class="key">60</span>
                                                            <span class="value">SEC</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div><!-- /.hot-deal-wrapper -->

                                            <div class="product-info text-left m-t-20" style="padding:5px;">
                                                <h3 class="name"><a
                                                        href="{{ route('seller.product.details',['slug'=>$items->slug,'shopID'=>$shopID]) }}">{{ $items->name }}</a>
                                                </h3>
                                                <div class="rating rateit-small"></div>

                                                <div class="product-price">
                                                    <span class="price">
                                                        $600.00
                                                    </span>

                                                    <span class="price-before-discount">$800.00</span>

                                                </div><!-- /.product-price -->

                                            </div><!-- /.product-info -->

                                            <div class="cart clearfix animate-effect">
                                                <div class="action">

                                                    <div class="add-cart-button btn-group">
                                                        <button class="btn btn-primary icon" data-toggle="dropdown"
                                                            type="button">
                                                            <i class="fa fa-shopping-cart"></i>
                                                        </button>
                                                        <button class="btn btn-primary cart-btn" type="button">Add to
                                                            cart</button>
                                                    </div>
                                                </div><!-- /.action -->
                                            </div><!-- /.cart -->
                                        </div>
                                    </div>
                                @empty
                                    <h5 class="text-danger">No Product Found</h5>
                                @endforelse
                            </div><!-- /.sidebar-widget -->
                        </div>
                        <!-- ============ HOT DEALS: END =============== -->

                        <!-- ============= NEWSLETTER ============== -->
                        <!-- <div class="sidebar-widget newsletter wow fadeInUp outer-bottom-small outer-top-vs">
                            <h3 class="section-title">Newsletters</h3>
                            <div class="sidebar-widget-body outer-top-xs">
                                <p>Sign Up for Our Newsletter!</p>
                                <form role="form">
                                    <div class="form-group">
                                        <label class="sr-only" for="exampleInputEmail1">Email address</label>
                                        <input type="email" class="form-control" id="exampleInputEmail1"
                                            placeholder="Subscribe to our newsletter">
                                    </div>
                                    <button class="btn btn-primary">Subscribe</button>
                                </form>
                            </div>
                        </div> -->
                        <!-- ================= NEWSLETTER: END ================== -->

                       
                    </div>
                </div><!-- /.sidebar -->
                <div class='col-md-9'>
                    <div class="detail-block">
                        <div class="row  wow fadeInUp">
                            <div class="col-xs-12 col-sm-6 col-md-5 gallery-holder">
                                <div class="product-item-holder size-big single-product-gallery small-gallery">
                                    <div id="owl-single-product">
                                        @foreach ($product_sub_image as $sub_image)
                                            <div class="single-product-gallery-item" id="slide_{{ $sub_image->id }}" style="min-height:300px;">
                                                <a data-lightbox="image-1" data-title="Product Gallery"
                                                    href="{{ url('upload/product_images/product_sub_images/'.$sub_image->sub_image) }}">
                                                    <img style="width:100%;" class="img-responsive" alt=""
                                                        src="{{ url('upload/product_images/product_sub_images/'.$sub_image->sub_image) }}" style="max-height: 200px;"
                                                        data-echo="{{ url('upload/product_images/product_sub_images/'.$sub_image->sub_image) }}" />
                                                </a>
                                            </div><!-- /.single-product-gallery-item -->
                                        @endforeach
                                    </div><!-- /.single-product-slider -->

                                    <div class="single-product-gallery-thumbs gallery-thumbs">
                                        <div id="owl-single-product-thumbnails">
                                            @foreach ($product_sub_image as $sub_image)
                                                <div class="item">
                                                    <a class="horizontal-thumb active" data-target="#owl-single-product"
                                                        data-slide="{{ $sub_image->id }}"
                                                        href="#slide_{{ $sub_image->id }}">
                                                        <img class="img-responsive" width="85" alt=""
                                                            src="{{ url('upload/product_images/product_sub_images/' . $sub_image->sub_image) }}" style="max-height: 200px;"
                                                            data-echo="{{ url('upload/product_images/product_sub_images/' . $sub_image->sub_image) }}" />
                                                    </a>
                                                </div>
                                            @endforeach
                                        </div><!-- /#owl-single-product-thumbnails -->
                                    </div><!-- /.gallery-thumbs -->
                                </div><!-- /.single-product-gallery -->
                            </div><!-- /.gallery-holder -->
                            <div class='col-sm-6 col-md-7 product-info-block'>
                                <form method="POST" action="{{ route('add.seller.cart') }}">
                                    @csrf
                                    <?php //echo $_GET['shopid'];?>
                                    <input type="hidden" name="id" value="{{ $productDetails->id }}">
                                    <input type="hidden" name="shopID" value="{{ $shopID }}">
                                  
                                    <div class="product-info">
                                        <h3 class="name">{{ $productDetails->name }}</h3>
                                        

                                        <div class="stock-container info-container m-t-10">
                                            <div class="row">
                                                <div class="col-sm-2">
                                                    <div class="stock-box">
                                                        <span class="label">Availability :</span>
                                                    </div>
                                                </div>
                                                <div class="col-sm-9">
                                                    <div class="stock-box">
                                                        @if ($productDetails->quantity > 0)
                                                            <span class="value">In Stock</span>
                                                        @else
                                                            <span class="value">Out of Stock</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div><!-- /.row -->
                                        </div><!-- /.stock-container -->

                                        <div class="description-container m-t-20 english_lang">
                                            {{ $productDetails->short_desc }}
                                        </div><!-- /.description-container -->
                                        <div class="description-container m-t-20 bangla_lang" style="display: none">
                                            {{ $productDetails->short_desc_bn }}
                                        </div><!-- /.description-container -->

                                        <div class="price-container info-container m-t-20">
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="price-box">
                                                        @if (!empty($productDetails->discount))
                                                            <span class="price-strike">&#2547;
                                                                {{ $productDetails->price }}</span>
                                                        @endif

                                                        @if (!empty($productDetails->discount))
                                                            <span class="price">
                                                                @if ($productDetails->discount_type == 1)
                                                                    {{ $productDetails->price - ($productDetails->price * $productDetails->discount) / 100 }}
                                                                @else
                                                                    {{ $productDetails->price - $productDetails->discount }}
                                                                @endif
                                                            </span>
                                                        @else
                                                            <span class="price">&#2547;
                                                                {{ $productDetails->price }}</span>
                                                        @endif

                                                    </div>
                                                </div>

                                                <div class="col-sm-6">
                                                    <div class="favorite-button m-t-10">
                                                        
                                                       
                                                      
                                                    </div>
                                                </div>
                                            </div><!-- /.row -->


                                            <div class="row mt-3">

                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label for="color">Select Color</label>
                                                        <select class="form-control" id="color" name="color_id">
                                                            <option value="">Select Color</option>
                                                            @foreach ($product_color as $color)
                                                                <option value="{{ $color->color_id }}">
                                                                    {{ $color['color']['name'] }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label for="size">Select Size</label>
                                                        <select class="form-control" id="size" name="size_id">
                                                            <option value="">Select Size</option>
                                                            @foreach ($product_size as $size)
                                                                <option value="{{ $size->size_id }}">
                                                                    {{ $size['size']['name'] }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div><!-- /.row -->

                                        </div><!-- /.price-container -->

                                        <div class="quantity-container info-container">
                                            <div class="row">
                                                <div class="col-sm-2">
                                                    <span class="label">Qty :</span>
                                                </div>
                                             <div class="col-sm-2">
    <div class="cart-quantity">
        <div class="quant-input">
            <div class="arrows">
                <div class="arrow plus gradient">
                    <span class="ir">
                        <i class="fa fa-plus"></i> <!-- Plus Icon -->
                    </span>
                </div>
                <div class="arrow minus gradient">
                    <span class="ir">
                        <i class="fa fa-minus"></i> <!-- Minus Icon -->
                    </span>
                </div>
            </div>
            <input type="number" min="1" value="1" name="qty">
        </div>
    </div>
</div>



                                                <div class="col-sm-7">
                                                    {{-- @if ($productDetails->quantity > 0) --}}
                                                    <button type="submit" class="btn btn-primary">
                                                        <i class="fa fa-shopping-cart inner-right-vs"></i> ADD TO CART
                                                    </button>
                                                    {{-- <a href="#" class="btn btn-primary"><i
                                                            class="fa fa-shopping-cart inner-right-vs"></i> ADD TO CART</a> --}}
                                                    {{-- @endif --}}
                                                </div>
                                            </div><!-- /.row -->
                                        </div><!-- /.quantity-container -->
                                    </div><!-- /.product-info -->
                                </form>
                            </div><!-- /.col-sm-7 -->
                        </div><!-- /.row -->
                    </div>

                   

                    <!-- =================== RELATED PRODUCTS ================ -->
                    <section class="section featured-product wow fadeInUp">
                        <h3 class="section-title">
                            @if (session()->get('language') == 'bangla')
                                রিলেটেড প্রোডাক্টস
                            @else
                                Related products
                            @endif
                        </h3>
                        <div class="owl-carousel home-owl-carousel upsell-product custom-carousel owl-theme outer-top-xs">

                            @forelse ($relatedProduct as $items)
                                <div class="item item-carousel">
                                    <div class="products" style="height:380px;">
                                        <div class="product" style="border:1px solid #eee;">
                                            <div class="product-image">
                                                <div class="image">
                                                    <a href="{{ route('seller.product.details',['slug'=>$items->slug,'shopID'=>$shopID]) }}">
                                                        <img
                                                            src="{{ url('upload/product_images/' . $items->image) }}"
                                                            alt="{{ $items->name }}" style="max-height:200px;"></a>
                                                </div><!-- /.image -->

                                                <div class="tag sale"><span>sale</span></div>
                                            </div><!-- /.product-image -->
                                            <div class="product-info text-left" style="padding:5px;">
                                                <h3 class="name"><a
                                                        href="{{ route('seller.product.details',['slug'=>$items->slug,'shopID'=>$shopID]) }}">  @php
                                                        $myStr = $items->name;
                                                        $subStr = substr($myStr, 0, 30);
                                                        echo $subStr . '...';
                                                    @endphp</a>
                                                </h3>
                                                <div class="rating rateit-small"></div>
                                                <div class="description"></div>

                                                <div class="product-price">
                                                    @if (!empty($productDetails->discount))
                                                        <span class="price-strike">&#2547;
                                                            {{ $productDetails->price }}</span>
                                                    @endif

                                                    @if (!empty($productDetails->discount))
                                                        <span class="price">
                                                            @if ($productDetails->discount_type == 1)
                                                                {{ $productDetails->price - ($productDetails->price * $productDetails->discount) / 100 }}
                                                            @else
                                                                {{ $productDetails->price - $productDetails->discount }}
                                                            @endif
                                                        </span>
                                                    @else
                                                        <span class="price">&#2547;
                                                            {{ $productDetails->price }}</span>
                                                    @endif

                                                    {{-- <span class="price"> $650.99</span>
                                                    <span class="price-before-discount">$ 800</span> --}}
                                                </div><!-- /.product-price -->

                                            </div><!-- /.product-info -->
                                            <div class="cart clearfix animate-effect">
                                                <div class="action">
                                                    <ul class="list-unstyled">
                                                        <li class="add-cart-button btn-group">
                                                            
                                                            <button class="btn btn-primary icon" type="button" title="Add Cart"
                                                            data-toggle="modal" data-target="#shopcartModal" id="{{ $items->id }}"
                                                            onclick="productView(this.id)">
                                                            <i class="fa fa-shopping-cart"></i>Add to
                                                            cart
                                                        </button>
                                                           
                                                        </li>
                                                    </ul>
                                                </div><!-- /.action -->
                                            </div><!-- /.cart -->
                                        </div><!-- /.product -->
                                    </div><!-- /.products -->
                                </div><!-- /.item -->
                            @empty
                                <h5 class="text-danger">No Product Found</h5>
                            @endforelse
                        </div><!-- /.home-owl-carousel -->
                    </section><!-- /.section -->
                    <!-- =============== UPSELL PRODUCTS : END ================= -->
                </div><!-- /.col -->
                <div class="clearfix"></div>
            </div><!-- /.row -->

            <!-- ================== BRANDS CAROUSEL ================= -->
           @include('frontend.layouts.brand')
            <!-- ============= BRANDS CAROUSEL : END ============== -->
        </div><!-- /.container -->
    </div><!-- /.body-content -->
@endsection
