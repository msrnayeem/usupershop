<div id="product-tabs-slider" class="scroll-tabs outer-top-vs">
    <div class="more-info-tab clearfix">
        <h3 class="new-product-title pull-left english_lang">New Products</h3>
        <h3 style="display: none;" class="new-product-title pull-left bangla_lang">নিউ প্রোডাক্টস</h3>
    </div>

    <div class="tab-content outer-top-xs" style="padding-left: 0px;">
        <div class="tab-pane in active" id="all">
            @php
                $allProducts = App\Models\Product::orderBy('id', 'DESC')->where('status', 1)->get()->take(20);
            @endphp

            <div class="product-slider">
                <div class="owl-carousel new_productsTab home-owl-carouseltab custom-carousel owl-theme" data-item="6">
                    @forelse ($allProducts as $items)
                        @php
                            // ── Price calc — Wholesale ONLY for Dropshipper ──────────
                            $isDropshipper = auth()->check() && auth()->user()->usertype === 'dropshipper';
                            $hasWholesale  = !empty($items->sale_price) && $items->sale_price > 0;

                            if ($isDropshipper && $hasWholesale) {
                                // Dropshipper দেখবে: Wholesale price
                                $displayPrice = (float)$items->sale_price;
                                $showOriginal = false;
                                $discountPct  = 0;
                            } elseif (!empty($items->discount)) {
                                // Customer / Seller / Vendor দেখবে: খুচরা (retail) price with discount
                                $displayPrice = $items->discount_type == 1
                                    ? $items->price - ($items->price * $items->discount) / 100
                                    : $items->price - $items->discount;
                                $showOriginal = true;
                                $discountPct  = $items->discount_type == 1
                                    ? (int)$items->discount
                                    : (int)round(($items->discount / $items->price) * 100);
                            } else {
                                // Default: খুচরা price
                                $displayPrice = (float)$items->price;
                                $showOriginal = false;
                                $discountPct  = 0;
                            }
                            // Created within last 7 days = NEW
                            $isNew = $items->created_at && $items->created_at->diffInDays(now()) <= 7;
                        @endphp
                        <div class="item item-carousel product-item-carousel">
                            <div class="pcard">
                                {{-- ── Image area ── --}}
                                <div class="pcard-img-wrap">
                                    <a href="{{ route('product.details.info', $items->slug) }}">
                                        <img loading="lazy"
                                             src="{{ $items->image ? url('upload/product_images/' . $items->image) : asset('frontend/no-image-icon.jpg') }}"
                                             alt="{{ $items->name }}"
                                             onerror="this.onerror=null;this.src='{{ asset('frontend/no-image-icon.jpg') }}';" />
                                        {{-- Overlay --}}
                                        <div class="pcard-overlay">
                                            <span class="pcard-arrival english_lang">ARRIVAL AT<br><strong>U SUPER<br>SHOP</strong></span>
                                            <span class="pcard-arrival bangla_lang" style="display:none">নতুন আগমন<br><strong>U SUPER<br>SHOP</strong></span>
                                            <div class="pcard-order-btn english_lang">ORDER NOW</div>
                                            <div class="pcard-order-btn bangla_lang" style="display:none">অর্ডার করুন</div>
                                        </div>
                                    </a>
                                    {{-- Discount badge --}}
                                    @if($discountPct > 0)
                                    <div class="pcard-discount-badge">-{{ $discountPct }}%</div>
                                    @endif
                                    {{-- NEW badge --}}
                                    @if($isNew)
                                    <div class="pcard-new-badge english_lang">NEW</div>
                                    <div class="pcard-new-badge bangla_lang" style="display:none">নতুন</div>
                                    @endif
                                    {{-- Wishlist heart --}}
                                    <button class="pcard-heart" onclick="addToWishlist({{ $items->id }},event)" title="Wishlist">&#9825;</button>
                                </div>
                                {{-- ── Info area ── --}}
                                <div class="pcard-info">
                                    <div class="pcard-name english_lang">{{ substr($items->name ?? '', 0, 26) }}</div>
                                    <div class="pcard-name bangla_lang" style="display:none">{{ substr($items->name_bn ?? $items->name ?? '', 0, 26) }}</div>
{{-- Category name removed --}}
                                    <div class="pcard-price">
                                        <span class="pcard-price-now">&#2547;{{ number_format($displayPrice, 0) }}</span>
                                        @if($showOriginal)
                                        <span class="pcard-price-old">&#2547;{{ number_format($items->price, 0) }}</span>
                                        @endif
                                    </div>
                                    {{-- Save & Free Delivery badges --}}
                                    @php
                                        $savedAmount = $showOriginal ? ($items->price - $displayPrice) : 0;
                                        $isFreeDelivery = $displayPrice >= 1000;
                                    @endphp
                                    @if($savedAmount > 0 || $isFreeDelivery)
                                    <div class="pcard-badges">
                                        @if($savedAmount > 0)
                                        <span class="pcard-save-pill">Save &#2547;{{ number_format($savedAmount, 0) }}</span>
                                        @endif
                                        @if($isFreeDelivery)
                                        <span class="pcard-free-del">&#128667; Free Delivery</span>
                                        @endif
                                    </div>
                                    @endif
                                    {{-- Add to cart button --}}
                                    <button class="pcard-cart-btn productCartBtn"
                                        data-toggle="modal" data-target="#cartModal"
                                        id="{{ $items->id }}" onclick="productView({{ $items->id }})">
                                        <span class="english_lang">+ Add to Cart</span>
                                        <span class="bangla_lang" style="display:none">+ কার্টে যোগ</span>
                                    </button>
                                </div>
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
