@php
    $categories = DB::table('my_shops')->join('products', 'products.id', '=',
            'my_shops.product_id')->where('my_shops.user_id', $shopID)
            ->join('categories', 'products.category_id', '=', 
            'categories.id')->select('categories.name', 'categories.id', 
            'categories.name_bn', 'categories.cat_icon')->groupBy('categories.name', 
            'categories.id', 'categories.name_bn', 'categories.cat_icon')->distinct()->get();
@endphp
@foreach ($categories as $category)
    <section class="section featured-product wow fadeInUp">
        <h3 class="section-title english_lang">{{ $category->name }}</h3>
        <h3 class="section-title bangla_lang" style="display:none">{{ $category->name_bn }}</h3>

        <div class="product-slider">
            <div class="owl-carousel categoryProducts custom-carousel owl-theme" style="padding: 0px;" data-item="6">
                @php
                    $catwiseProduct = App\Models\Product::where('category_id', $category->id)
                        ->orderBy('id', 'DESC')
                        ->get();
                @endphp
               
                @forelse ($catwiseProduct as $product)
                    <div class="item item-carousel product-item-carousel">
                        <div class="product">
                            <div class="product-image">
                                <div class="image">
                                    <a href="{{ route('seller.product.details',['slug'=>$product->slug,'shopID'=>$shopID]) }}">
                                        <button>
                                            @if(!empty($product->image))
                                                <img src="{{ asset('upload/product_images/'.$product->image)}}" alt="{{ $product->name }}" />
                                            @else 
                                                <img src="{{asset('frontend/assets/images/no-image.png') }}" alt="{{ $product->name }}" />
                                            @endif
                                        </button>
                                    </a>
                                </div>
                                
                            </div>
                            <!-- /.product-image -->
    
                            <div class="product-info text-left" style="padding-left:5px !important;">
                                <h3 class="name english_lang">
                                    <a title="{{$product->name}}" href="{{ route('seller.product.details',['slug'=>$product->slug,'shopID'=>$shopID]) }}">
                                        @php
                                            $myStr = $product->name;
                                            $subStr = substr($myStr, 0, 22);
                                            echo $subStr . '...';
                                        @endphp
                                    </a>
                                </h3>
                                <h3 class="name bangla_lang" style="display: none;">
                                    <a title="{{$product->name_bn}}" href="{{ route('seller.product.details',['slug'=>$product->slug,'shopID'=>$shopID]) }}">
                                        @php
                                            $myStr = $product->name_bn;
                                            $subStr = substr($myStr, 0, 22);
                                            echo $subStr . '...';
                                        @endphp
                                    </a>
                                </h3>
                             
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
                                        <span class="price-before-discount">&#2547; {{ $product->price }}</span>
                                    @endif
                                </div>
                                <!-- /.product-price -->
                            </div>
                            <!-- /.product-info -->
                            <div class="cart clearfix animate-effect">
                                <div class="action">
                                    <ul class="list-unstyled">
                                        <li class="add-cart-button btn-group">
                                            <button class="btn btn-primary icon" type="button" title="Add Cart"
                                                data-toggle="modal" data-target="#shopcartModal" id="{{ $product->id }}"
                                                onclick="ShopProductView(this.id)">
                                                <i class="fa fa-shopping-cart"></i> Add to cart
                                            </button>
                                          
                                        </li>
                                    </ul>
                                </div>
                                <!-- /.action -->
                            </div>
                            <!-- /.cart -->
                        </div>
                    </div>
                    <!-- /.item -->
                @empty
                    <h5 class="text-danger">No Product Found</h5>
                @endforelse
                
            </div>
        </div>
        <!-- /.home-owl-carousel -->
    </section>
@endforeach
