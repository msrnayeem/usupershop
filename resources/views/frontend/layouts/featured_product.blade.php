<section class="section featured-product">
    <h3 class="section-title english_lang">Featured Products</h3>
    <h3 style="display: none;" class="section-title bangla_lang">ফিচার্ড প্রোডাক্টস</h3>
    <div class="product-slider">
        <div class="owl-carousel featuredProducts custom-carousel owl-theme" style="padding: 0px;" data-item="6">
            @forelse ($featureds as $items)
                <div class="item item-carousel product-item-carousel">
                    @include('frontend.components.product-card', ['product' => $items])
                </div>
            @empty
                <h5 class="text-danger">No Product Found</h5>
            @endforelse
        </div>
    </div>
</section>
