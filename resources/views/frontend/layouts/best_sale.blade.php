<div class="best-deal wow fadeInUp outer-bottom-xs">
    <h3 class="section-title english_lang">Best Seller</h3>
    <h3 class="section-title bangla_lang" style="display:none">বেস্ট সেলার</h3>
    <div class="sidebar-widget-body outer-top-xs">
        {{-- @php
            var_dump($topProducts);
        @endphp --}}
        <div class="owl-carousel best-seller custom-carousel owl-theme outer-top-xs">
            <div class="item">
                <div class="products special-product">
                    <?php
                        foreach ($topProducts as $key => $items) {
                            if (($key+1) % 3 == 0) {
                                echo '</div>
                </div> <div class="item">
                    <div class="products special-product">';
                            }else{ ?>
                    <div class="product" style="height:350px;">
                        <div class="product-micro">
                            <div class="row product-micro-row">
                                <div class="col col-xs-5">
                                    <div class="product-image">
                                        <div class="image" style="border: radius:1px solid;">
                                            <a href="#">
                                                @if(!empty($items->image))
                                                <img style="max-height:120px;"
                                                src="{{ asset('upload/product_images/' . $items->image)}}" 
                                                alt="{{ $items->name }}" />
                                                @else
                                                <img style="max-height:120px;"
                                                src="{{asset('frontend/assets/images/no-image.png') }}" 
                                                alt="{{ $items->name }}" />
                                                @endif
                                            </a>
                                        </div>
                                        <!-- /.image -->
                                    </div>
                                    <!-- /.product-image -->
                                </div>
                                <!-- /.col -->
                                <div class="col col-xs-7">
                                    <div class="product-info">
                                        <h3 class="name">
                                            <a
                                                href="{{ route('product.details.info', $items->slug) }}">
                                                @php
                                                    $myStr = $items->name;
                                                    $subStr = substr($myStr, 0,20); // Start from 0 and get 50 characters
                                                    echo $subStr . (strlen($myStr) > 30 ? '...' : ''); // Add "..." if the string exceeds 50 characters
                                                @endphp
                                            </a>
                                        </h3>
                                       
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
                                        </div>
                                        <!-- /.product-price -->
                                    </div>
                                </div>
                                <!-- /.col -->
                            </div>
                            <!-- /.product-micro-row -->
                        </div>
                        <!-- /.product-micro -->
                    </div>
                    <?php
                            }
                        }
                        ?>
                </div>
            </div>
        </div>
    </div>
    <!-- /.sidebar-widget-body -->
</div>
