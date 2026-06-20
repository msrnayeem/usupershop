@if ($categoryproducts != null)

    @foreach ($categoryproducts as $categoryproduct)
        <section class="section featured-product">

            <h3 class="section-title english_lang">
                {{ $categoryproduct['category']->name }}
            </h3>

            <h3 class="section-title bangla_lang" style="display:none">
                {{ $categoryproduct['category']->name_bn }}
            </h3>

            <div class="product-slider">
                <div class="owl-carousel categoryProducts owl-theme" style="padding: 0px;">

                    @forelse ($categoryproduct['products'] as $product)

                        <div class="item item-carousel product-item-carousel" style="padding: 5px;">
                            <div class="product">

                                <div class="product-image">
                                    <div class="image">
                                        <a href="{{ route('product.details.info', $product->slug) }}">
                                            <button type="button">

                                                @if (!empty($product->image))
                                                    <img
                                                        loading="lazy"
                                                        src="{{ asset('upload/product_images/' . $product->image) }}"
                                                        alt="{{ $product->slug }}"
                                                        onerror="this.src='{{ asset('frontend/no-image-icon.jpg') }}'" />
                                                @else
                                                    <img
                                                        src="{{ asset('frontend/assets/images/no-image.png') }}"
                                                        alt="{{ $product->slug }}" />
                                                @endif

                                            </button>
                                        </a>
                                    </div>
                                </div>

                                <!-- /.product-image -->

                                <div class="product-info text-left" style="float:left;">

                                    <h3 class="name english_lang">
                                        <a title="{{ $product->name }}"
                                            href="{{ route('product.details.info', $product->slug) }}">
                                            @php
                                                $myStr = $product->name;
                                                $subStr = substr($myStr, 0, 22);
                                                echo $subStr . '...';
                                            @endphp
                                        </a>
                                    </h3>

                                    <h3 class="name bangla_lang" style="display: none;">
                                        <a title="{{ $product->name_bn }}"
                                            href="{{ route('product.details.info', $product->slug) }}">
                                            @php
                                                $myStr = $product->name_bn;
                                                $subStr = substr($myStr, 0, 22);
                                                echo $subStr . '...';
                                            @endphp
                                        </a>
                                    </h3>

                                    <div class="product-price">

                                        @php
                                            if (
                                                auth()->check() &&
                                                auth()->user()->usertype === 'dropshipper' &&
                                                isset($product->sale_price) &&
                                                $product->sale_price > 0
                                            ) {
                                                $displayPrice = $product->sale_price;
                                                $showOriginal = false;
                                            } else {
                                                if (!empty($product->discount)) {
                                                    $displayPrice = $product->discount_type == 1
                                                        ? $product->price - ($product->price * $product->discount) / 100
                                                        : $product->price - $product->discount;

                                                    $showOriginal = true;
                                                } else {
                                                    $displayPrice = $product->price;
                                                    $showOriginal = false;
                                                }
                                            }
                                        @endphp

                                        <span class="price">
                                            &#2547; {{ number_format($displayPrice, 2) }}
                                        </span>

                                        @if ($showOriginal)
                                            <span class="price-before-discount">
                                                &#2547; {{ number_format($product->price, 2) }}
                                            </span>
                                        @endif

                                    </div>

                                    <!-- /.product-price -->

                                </div>

                                <!-- /.product-info -->

                                <div class="productButtons">
                                    <span
                                        class="icon productCartBtn"
                                        title="Add Cart"
                                        data-toggle="modal"
                                        data-target="#cartModal"
                                        id="{{ $product->id }}"
                                        onclick="productView({{ $product->id }})">
                                        <i class="fa fa-shopping-cart"></i>
                                    </span>
                                </div>

                                <!-- /.cart -->

                            </div>
                        </div>

                    @empty

                        <h5 class="text-danger">No Product Found</h5>

                    @endforelse

                </div>
            </div>

        </section>
    @endforeach

@endif