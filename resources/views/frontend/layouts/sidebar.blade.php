<div class="col-xs-12 col-sm-12 col-md-3 sidebar">
    <!-- ============== SPECIAL OFFER ================ -->
    <div class="sidebar-widget outer-bottom-small wow fadeInUp">
        <h3 class="section-title english_lang">Special Offer</h3>
        <h3 style="display: none" class="section-title bangla_lang">স্পেশাল অফার</h3>
        <div class="sidebar-widget-body outer-top-xs">
            <div class="owl-carousel sidebar-carousel special-offer custom-carousel owl-theme outer-top-xs">

                <div class="item">
                    <div class="products special-product">
                        <?php
                        foreach ($special_offers as $key => $items) {
                            if (($key+1) % 4 == 0) {
                                echo '</div>
                </div> <div class="item">
                    <div class="products special-product">';
                            }else{ ?>
                        <div class="product" style="border:1px solid #eee;padding:5px">
                            <div class="product-micro">
                                <div class="row product-micro-row">
                                    <div class="col col-xs-5">
                                        <div class="product-image">
                                            <div class="image" style="border:1px solid #eee">
                                                <a href="#">
                                                    @if (!empty($items->image))
                                                        <img src="{{ asset('upload/product_images/' . $items->image) }}"
                                                            alt="{{ $items->name }}">
                                                    @else
                                                        <img src="{{ asset('frontend/assets/images/no-image.png') }}"
                                                            alt="{{ $items->name }}">
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
                                                <a href="{{ route('product.details.info', $items->slug) }}">
                                                    @php
                                                        $myStr = $items->name;
                                                        $subStr = substr($myStr, 0, 20); // Start from 0 and get 50 characters
                                                        echo $subStr . (strlen($myStr) > 30 ? '...' : ''); // Add "..." if the string exceeds 50 characters
                                                    @endphp</a>
                                            </h3>
                                            <div class="rating rateit-small"></div>
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
    <!-- /.sidebar-widget -->
    <!-- ============ SPECIAL OFFER : END ============= -->

    <!-- ============== SPECIAL DEALS ================ -->

    <div class="sidebar-widget outer-bottom-small wow fadeInUp">
        <h3 class="section-title english_lang">Special Deals</h3>
        <h3 style="display: none" class="section-title bangla_lang">স্পেশাল ডেলস</h3>
        <div class="sidebar-widget-body outer-top-xs">
            <div class="owl-carousel sidebar-carousel special-offer custom-carousel owl-theme outer-top-xs">


                <div class="item">
                    <div class="products special-product">
                        <?php
                        foreach ($special_deals as $key => $items) {
                            if (($key+1) % 4 == 0) {
                                echo '</div>
                </div> <div class="item">
                    <div class="products special-product">';
                            }else{ ?>
                        <div class="product" style="border:1px solid #eee;padding:5px">
                            <div class="product-micro">
                                <div class="row product-micro-row">
                                    <div class="col col-xs-5">
                                        <div class="product-image">
                                            <div class="image" style="border:1px solid #eee">
                                                <a href="#">
                                                    @if (!empty($items->image))
                                                        <img src="{{ asset('upload/product_images/' . $items->image) }}"
                                                            alt="{{ $items->name }}">
                                                    @else
                                                        <img src="{{ asset('frontend/assets/images/no-image.png') }}"
                                                            alt="{{ $items->name }}">
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
                                                <a href="{{ route('product.details.info', $items->slug) }}">
                                                    @php
                                                        $myStr = $items->name;
                                                        $subStr = substr($myStr, 0, 20);
                                                        echo $subStr . (strlen($myStr) > 30 ? '...' : '');
                                                    @endphp</a>
                                            </h3>
                                            <div class="rating rateit-small"></div>
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
    <!-- /.sidebar-widget -->
    <!-- ============ SPECIAL DEALS : END ============ -->

    <div class="home-banner">
        <!--<a href=""><img src="{{ asset('frontend') }}/assets/images/banners/app_download.gif" alt="Image" style="width:100%"/></a>-->
    </div>
</div>
