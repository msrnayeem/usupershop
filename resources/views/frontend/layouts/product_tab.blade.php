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
                        <div class="item item-carousel product-item-carousel">
                            @include('frontend.components.product-card', ['product' => $items])
                        </div>
                    @empty
                        <h5 class="text-danger">No Product Found</h5>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
