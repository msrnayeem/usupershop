<section class="section featured-product">
    <h3 class="section-title english_lang">Featured Products</h3>
    <h3 style="display: none;" class="section-title bangla_lang">ফিচার্ড প্রোডাক্টস</h3>
    <div class="product-slider">
        <div class="owl-carousel featuredProducts custom-carousel owl-theme" style="padding: 0px;" data-item="6">
            @forelse ($featureds as $items)
                <div class="item item-carousel product-item-carousel">
                    <div class="product">
                        <div class="product-image">
                            <div class="image">
                                <a href="{{ route('seller.product.details',['slug'=> $items->slug,'shopID'=>$shopID]) }}">
                                    <button>
                                        @if (!empty($items->image))
                                            <img style="height:200px"
                                                src="{{ asset('upload/product_images/' . $items->image) }}"
                                                alt="{{ $items->slug }}" onerror="this.src='{{ asset('/frontend/no-image-icon.jpg') }}'"
/>
                                        @else
                                            <img style="height:200px"
                                                src="{{ asset('frontend/assets/images/no-image.png') }}"
                                                alt="{{ $items->name }}" />
                                        @endif
                                    </button>
                                </a>
                            </div>
                            <!-- /.image -->
                        </div>
                        <!-- /.product-image -->

                        <div class="product-info text-left">
                            <h3 class="name english_lang">
                                <a title="{{ $items->slug }}" href="{{ route('seller.product.details',['slug'=> $items->slug,'shopID'=>$shopID]) }}">
                                    @php
                                        $myStr = $items->name;
                                        $subStr = substr($myStr, 0, 22);
                                        echo $subStr . '...';
                                    @endphp
                                </a>
                            </h3>
                            <h3 class="name bangla_lang" style="display: none;">
                                <a title="{{ $items->slug }}"
                                    href="{{ route('seller.product.details',['slug'=> $items->slug,'shopID'=>$shopID]) }}">
                                    @php
                                        $myStr = $items->name_bn;
                                        $subStr = substr($myStr, 0, 22);
                                        echo $subStr . '...';
                                    @endphp
                                </a>
                            </h3>
                           
                            <div class="description"></div>

                            <div class="product-price">
                                @if (!empty($items->discount))
                                    <span class="price">
                                        @if ($items->discount_type == 1)
                                            &#2547;
                                            {{ $items->price - ($items->price * $items->discount) / 100 }}
                                        @else
                                            &#2547; {{ $items->price - $items->discount }}
                                        @endif
                                    </span>
                                @else
                                    <span class="price">&#2547;
                                        {{ $items->price }}</span>
                                @endif

                                @if (!empty($items->discount))
                                    <span class="price-before-discount">&#2547;
                                        {{ $items->price }}</span>
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
                                            data-toggle="modal" data-target="#shopcartModal" id="{{ $items->id }}"
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
            @empty
                <h5 class="text-danger">No Product Found</h5>
            @endforelse
        </div>
    </div>
    <!-- /.home-owl-carousel -->

</section>

