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
