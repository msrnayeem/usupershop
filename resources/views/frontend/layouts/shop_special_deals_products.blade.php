<div id="product-tabs-slider" class="scroll-tabs outer-top-vs">
    <div class="more-info-tab clearfix">
        <h3 class="new-product-title pull-left english_lang">Special Deals</h3>
        <h3 style="display: none;" class="new-product-title pull-left bangla_lang">স্পেশাল ডেলস</h3>
    </div>

    <div class="tab-content outer-top-xs" style="padding-left: 0px;">
        <div class="tab-pane in active" id="all">
            <div class="product-slider">
                <div class="owl-carousel special_deals_err custom-carousel owl-theme" data-item="6">
                    @forelse ($special_deals as $items)
                        <div class="item item-carousel product-item-carousel">
                            <div class="product">
                                <div class="product-image">
                                    <div class="image">
                                        <a
                                            href="{{ route('seller.product.details', ['slug' => $items->slug, 'shopID' => $shopID]) }}">
                                            <button>
                                                <img src="{{ $items->image ? url('upload/product_images/' . $items->image) : asset('frontend/no-image-icon.jpg') }}"
                                                    alt="{{ $items->slug }}"
                                                    onerror="this.onerror=null;this.src='{{ asset('frontend/no-image-icon.jpg') }}';" />

                                                >
                                            </button>
                                        </a>
                                    </div>
                                </div>

                                <div class="product-info text-left">
                                    <h3 class="name english_lang">
                                        <a title="{{ $items->name }}"
                                            href="{{ route('seller.product.details', ['slug' => $items->slug, 'shopID' => $shopID]) }}">
                                            @php
                                                $myStr = $items->name;
                                                $subStr = substr($myStr, 0, 22);
                                                echo $subStr . '...';
                                            @endphp
                                        </a>
                                    </h3>
                                    <h3 class="name bangla_lang" style="display: none;">
                                        <a title="{{ $items->name_bn }}"
                                            href="{{ route('seller.product.details', ['slug' => $items->slug, 'shopID' => $shopID]) }}">
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
                                                    data-toggle="modal" data-target="#shopcartModal"
                                                    id="{{ $items->id }}" onclick="ShopProductView(this.id)">
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
                <!-- /.home-owl-carousel -->
            </div>
            <!-- /.product-slider -->
        </div>
    </div>
    <!-- /.tab-content -->
</div>


