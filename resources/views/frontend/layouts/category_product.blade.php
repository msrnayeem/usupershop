@if ($categoryproducts != null)
    @foreach ($categoryproducts as $categoryproduct)
        <section class="section featured-product">
            <h3 class="section-title english_lang">{{ $categoryproduct['category']->name }}</h3>
            <h3 class="section-title bangla_lang" style="display:none">{{ $categoryproduct['category']->name_bn }}</h3>
            <div class="product-slider">
                <div class="owl-carousel categoryProducts owl-theme" style="padding: 0px;">
                    @forelse ($categoryproduct['products'] as $product)
                        <div class="item item-carousel product-item-carousel" style="padding: 5px;">
                            @include('frontend.components.product-card', ['product' => $product])
                        </div>
                    @empty
                        <h5 class="text-danger">No Product Found</h5>
                    @endforelse
                </div>
            </div>
        </section>
    @endforeach
@endif
