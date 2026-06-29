{{--
    ══════════════════════════════════════════════════════════
    PRODUCT CARD COMPONENT — use everywhere
    ──────────────────────────────────────────────────────────
    Props:
      $product   — the product model / stdClass
      $routeName — (optional) route name for detail link. Default: 'product.details.info'
      $routeParams — (optional) array of extra route params (e.g. ['shopID' => $shopID])
      $modalTarget — (optional) modal id. Default: '#cartModal'
      $onclickFn   — (optional) JS function name. Default: 'productView'
    ══════════════════════════════════════════════════════════
--}}
@php
    /* ── Route ────────────────────────────────────── */
    $routeName   = $routeName   ?? 'product.details.info';
    $routeParams = $routeParams ?? [];
    $detailUrl   = count($routeParams)
                     ? route($routeName, array_merge([$product->slug], $routeParams))
                     : route($routeName, $product->slug);

    $modalTarget = $modalTarget ?? '#cartModal';
    $onclickFn   = $onclickFn   ?? 'productView';

    /* ── Price logic ──────────────────────────────── */
    $isDropshipper = auth()->check() && auth()->user()->usertype === 'dropshipper';
    $hasWholesale  = !empty($product->sale_price) && $product->sale_price > 0;

    if ($isDropshipper && $hasWholesale) {
        $displayPrice = (float)$product->sale_price;
        $showOriginal = false;
        $discountPct  = 0;
    } elseif (!empty($product->discount)) {
        $displayPrice = $product->discount_type == 1
            ? $product->price - ($product->price * $product->discount) / 100
            : $product->price - $product->discount;
        $showOriginal = true;
        $discountPct  = $product->discount_type == 1
            ? (int)$product->discount
            : (int)round(($product->discount / $product->price) * 100);
    } else {
        $displayPrice = (float)$product->price;
        $showOriginal = false;
        $discountPct  = 0;
    }

    $savedAmount    = $showOriginal ? ($product->price - $displayPrice) : 0;
    $isFreeDelivery = $displayPrice >= 1000;

    /* ── NEW badge ────────────────────────────────── */
    $createdAt = !empty($product->created_at) ? \Carbon\Carbon::parse($product->created_at) : null;
    $isNew     = $createdAt && $createdAt->diffInDays(now()) <= 7;

    /* ── Name ─────────────────────────────────────── */
    $nameEn = substr($product->name ?? '', 0, 26);
    $nameBn = substr($product->name_bn ?? $product->name ?? '', 0, 26);
@endphp

<div class="pcard" style="height: 100% !important; display: flex !important; flex-direction: column !important; justify-content: space-between !important;">
    {{-- ── Image ── --}}
    <div class="pcard-img-wrap">
        <a href="{{ $detailUrl }}">
            <img loading="lazy"
                 src="{{ $product->image ? url('upload/product_images/' . $product->image) : asset('frontend/no-image-icon.jpg') }}"
                 alt="{{ $product->name ?? '' }}"
                 onerror="this.onerror=null;this.src='{{ asset('frontend/no-image-icon.jpg') }}';" />
            <div class="pcard-overlay">
                <span class="pcard-arrival english_lang">ARRIVAL AT<br><strong>U SUPER<br>SHOP</strong></span>
                <span class="pcard-arrival bangla_lang" style="display:none">নতুন আগমন<br><strong>U SUPER<br>SHOP</strong></span>
                <div class="pcard-order-btn english_lang">ORDER NOW</div>
                <div class="pcard-order-btn bangla_lang" style="display:none">অর্ডার করুন</div>
            </div>
        </a>
        @if($discountPct > 0)
            <div class="pcard-discount-badge">-{{ $discountPct }}%</div>
        @endif
        @if($isNew)
            <div class="pcard-new-badge english_lang">NEW</div>
            <div class="pcard-new-badge bangla_lang" style="display:none">নতুন</div>
        @endif
        <button class="pcard-heart" onclick="addToWishlist({{ $product->id }},event)" title="Wishlist">&#9825;</button>
    </div>

    {{-- ── Info ── --}}
    <div class="pcard-info" style="display: flex !important; flex-direction: column !important; flex-grow: 1 !important; padding: 10px !important;">
        <div class="pcard-name english_lang" style="min-height: 40px !important; overflow: hidden !important;">{{ $nameEn }}</div>
        <div class="pcard-name bangla_lang" style="display:none; min-height: 40px !important; overflow: hidden !important;">{{ $nameBn }}</div>

        <div class="pcard-price">
            <span class="pcard-price-now">&#2547;{{ number_format($displayPrice, 0) }}</span>
            @if($showOriginal)
                <span class="pcard-price-old">&#2547;{{ number_format($product->price, 0) }}</span>
            @endif
        </div>

        @if($savedAmount > 0 || $isFreeDelivery)
            <div class="pcard-badges" style="display:flex !important; flex-direction:row !important; flex-wrap:nowrap !important; gap:4px !important; align-items:center !important; margin-bottom:6px !important; overflow:hidden !important; min-height:20px !important; width:100% !important;">
                @if($savedAmount > 0)
                    <span class="pcard-save-pill" style="font-size:10px !important; padding:2px 5px !important; border-radius:20px !important; white-space:nowrap !important; flex-shrink:0 !important; margin:0 !important; background:#fff8e1 !important; color:#856404 !important; border:1px solid #ffd54f !important;">Save &#2547;{{ number_format($savedAmount, 0) }}</span>
                @endif
                @if($isFreeDelivery)
                    <span class="pcard-free-del" style="font-size:10px !important; padding:2px 5px !important; border-radius:20px !important; white-space:nowrap !important; flex-shrink:0 !important; margin:0 !important; background:#e8f5e9 !important; color:#2e7d32 !important; border:1px solid #a5d6a7 !important;">&#128667; Free Delivery</span>
                @endif
            </div>
        @else
            {{-- Spacer for when there are no badges so button doesn't jump up --}}
            <div style="min-height: 26px !important; width: 100% !important;"></div>
        @endif

        <button class="pcard-cart-btn productCartBtn"
                data-toggle="modal"
                data-target="{{ $modalTarget }}"
                id="pcard-{{ $product->id }}"
                onclick="{{ $onclickFn }}({{ $product->id }})"
                style="margin-top: auto !important;">
            <span class="english_lang">+ Add to Cart</span>
            <span class="bangla_lang" style="display:none">+ কার্টে যোগ</span>
        </button>
    </div>
</div>
