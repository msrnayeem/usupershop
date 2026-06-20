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
                                <a href="{{ route('product.details.info', $items->slug) }}">
                                    <button type="button">

                                        @if (!empty($items->image))
                                            <img
                                                style="max-height:200px"
                                                loading="lazy"
                                                src="{{ asset('upload/product_images/' . $items->image) }}"
                                                alt="{{ $items->slug }}"
                                                onerror="this.src='{{ asset('frontend/no-image-icon.jpg') }}'" />
                                        @else
                                            <img
                                                style="max-height:200px"
                                                src="{{ asset('frontend/assets/images/no-image.png') }}"
                                                alt="{{ $items->name }}" />
                                        @endif

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
                                    if (
                                        auth()->check() &&
                                        auth()->user()->usertype === 'dropshipper' &&
                                        isset($items->sale_price) &&
                                        $items->sale_price > 0
                                    ) {
                                        $displayPrice = $items->sale_price;
                                        $showOriginal = false;
                                    } else {
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

                                <span class="price">
                                    &#2547; {{ number_format($displayPrice, 2) }}
                                </span>

                                @if ($showOriginal)
                                    <span class="price-before-discount">
                                        &#2547; {{ number_format($items->price, 2) }}
                                    </span>
                                @endif

                            </div>

                        </div>

                        <div class="productButtons">
                            <span
                                class="icon productCartBtn"
                                title="Add Cart"
                                data-toggle="modal"
                                data-target="#cartModal"
                                id="{{ $items->id }}"
                                onclick="productView({{ $items->id }})">
                                <i class="fa fa-shopping-cart"></i>
                            </span>
                        </div>

                    </div>
                </div>
            @empty
                <h5 class="text-danger">No Product Found</h5>
            @endforelse

        </div>
    </div>
</section>