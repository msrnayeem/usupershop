<div id="product-tabs-slider" class="scroll-tabs outer-top-vs">
    <div class="more-info-tab clearfix">
        <h3 class="new-product-title pull-left english_lang">Special Deals</h3>
        <h3 style="display: none;" class="new-product-title pull-left bangla_lang">স্পেশাল ডেলস</h3>
    </div>

    <div class="tab-content outer-top-xs" style="padding-left: 0px;margin-bottom:0;">
        <div class="tab-pane in active" id="all">
            <div class="product-slider">
                <div class="owl-carousel special_deals_err custom-carousel owl-theme" data-item="6">
                    @forelse ($special_deals as $items)
                        <div class="item item-carousel product-item-carousel">
                            <div class="product">
                                <div class="product-image">
                                    <div class="image">
                                        <a href="{{ route('product.details.info', $items->slug) }}">
                                            <button>
                                                <img loading="lazy" src="{{ $items->image ? url('upload/product_images/' . $items->image) : asset('frontend/no-image-icon.jpg') }}"
                                                    alt="{{ $items->slug }}"
                                                    onerror="this.onerror=null;this.src='{{ asset('frontend/no-image-icon.jpg') }}';" />

                                            </button>
                                        </a>
                                    </div>
                                </div>

                                <div class="product-info text-left">
                                    <h3 class="name english_lang">
                                        <a title="{{ $items->name }}"
                                            href="{{ route('product.details.info', $items->slug) }}">
                                            @php
                                                $myStr = $items->name;
                                                $subStr = substr($myStr, 0, 22);
                                                echo $subStr . '...';
                                            @endphp
                                        </a>
                                    </h3>
                                    <h3 class="name bangla_lang" style="display: none;">
                                        <a title="{{ $items->name_bn }}"
                                            href="{{ route('product.details.info', $items->slug) }}">
                                            @php
                                                $myStr = $items->name_bn;
                                                $subStr = substr($myStr, 0, 22);
                                                echo $subStr . '...';
                                            @endphp
                                        </a>
                                    </h3>

                                    <div class="description"></div>

                                    <div class="product-price">
                                        @php
                                            // Check if user is dropshipper and product has hole sale price
                                            if (auth()->check() && auth()->user()->usertype === 'dropshipper' && isset($items->sale_price) && $items->sale_price > 0) {
                                                $isDropshipper = auth()->check() && auth()->user()->usertype === 'dropshipper';
                            $displayPrice = ($isDropshipper && !empty($items->sale_price)) ? $items->sale_price : $items->price;
                                                $showOriginal = false;
                                            } else {
                                                // Regular customer pricing
                                                if (!empty($items->discount)) {
                                                    $displayPrice = $items->discount_type == 1
                                                        ? $items->price - ($items->price * $items->discount) / 100
                                                        : $items->price - $items->discount;
                                                    $showOriginal = true;
                                                } else {
                                                    $displayPrice = $items->price;
                                                    $showOriginal = false;
                                                }
                                            }
                                        @endphp
                                        
                                        <span class="price">&#2547; {{ number_format($displayPrice, 2) }}</span>
                                        
                                        @if ($showOriginal)
                                            <span class="price-before-discount">&#2547; {{ number_format($items->price, 2) }}</span>
                                        @endif
                                    </div>
                                    <!-- /.product-price -->
                                </div>
                                <!-- /.product-info -->
                                <div class="productButtons">
                                    <span class="icon productCartBtn" title="Add Cart"
                                        data-toggle="modal" data-target="#cartModal"
                                        id="{{ $items->id }}" onclick="productView({{ $items->id }})">
                                        <i class="fa fa-shopping-cart"></i></span>
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
