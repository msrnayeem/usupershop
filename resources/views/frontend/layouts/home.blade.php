@extends('frontend.layouts.master')
@section('title')
    {{ config('app.name') }} | Best Online Shop In Bangladesh
@endsection

@section('meta_description', 'U Super Shop | Best Online Shop কেনাকাটা আর আয়ের সেরা ঠিকানা! সেরা ডিলে প্রিমিয়াম শপিং করুন অথবা সেলার ও ড্রপশিপার হয়ে ইনভেস্টমেন্ট ছাড়াই ব্যবসা শুরু করুন। দ্রুত ডেলিভারি ও বিশ্বস্ততার নিশ্চয়তা। আজই যোগ দিন | আনলিমিটেড রেফার বোনাসের সেরা প্ল্যাটফর্ম। এখনই ভিজিট করুন!')
@section('meta_keywords', 'online shop, ecommerce, bangladesh, grocery, fashion, electronics, ' . config('app.name'))
@section('meta_author', config('app.name'))

@push('meta')
    <meta property="og:title" content="{{ config('app.name') }} | Best Online Shop In Bangladesh" />
    <meta property="og:description" content="U Super Shop | Best Online Shop কেনাকাটা আর আয়ের সেরা ঠিকানা! সেরা ডিলে প্রিমিয়াম শপিং করুন অথবা সেলার ও ড্রপশিপার হয়ে ইনভেস্টমেন্ট ছাড়াই ব্যবসা শুরু করুন। আজই যোগ দিন | আনলিমিটেড রেফার বোনাসের সেরা প্ল্যাটফর্ম।" />
    <meta property="og:image" content="{{ asset('frontend/assets/images/banners/home-banner1212.jpg') }}" />
    <meta property="og:url" content="{{ url('/') }}" />
    <meta property="og:type" content="website" />
    
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ config('app.name') }} | Best Online Shop">
    <meta name="twitter:description" content="বেস্ট অনলাইন শপিং প্ল্যাটফর্ম। আপনার কেনাকাটা আর আয়ের সেরা ঠিকানা।">
    {{-- ── SEO: Organization + WebSite + LocalBusiness Schema ── --}}
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@graph": [
        {
          "@type": "Organization",
          "@id": "https://usuper.shop/#organization",
          "name": "U Super Shop",
          "alternateName": ["উ সুপার শপ", "U Super Shop BD"],
          "url": "https://usuper.shop",
          "logo": {
            "@type": "ImageObject",
            "url": "https://usuper.shop/frontend/assets/images/logo.png",
            "width": 200,
            "height": 60
          },
          "description": "কেনাকাটা আর আয়ের সেরা ঠিকানা — Bangladesh's best online shop for dropshipping, reselling and shopping.",
          "foundingDate": "2024",
          "areaServed": "BD",
          "contactPoint": [
            {
              "@type": "ContactPoint",
              "telephone": "+8801816622128",
              "contactType": "customer service",
              "areaServed": "BD",
              "availableLanguage": ["Bengali", "English"]
            }
          ],
          "address": {
            "@type": "PostalAddress",
            "addressCountry": "BD",
            "addressRegion": "Dhaka"
          },
          "sameAs": [
            "https://www.facebook.com/share/1VjqK6xoDm/",
            "https://youtube.com/@usupershop",
            "https://www.instagram.com/usupershop",
            "https://t.me/usupershop1",
            "https://tiktok.com/@usupershop"
          ]
        },
        {
          "@type": "WebSite",
          "@id": "https://usuper.shop/#website",
          "url": "https://usuper.shop",
          "name": "U Super Shop",
          "description": "Best Online Shop in Bangladesh — কেনাকাটা আর আয়ের সেরা ঠিকানা",
          "publisher": {"@id": "https://usuper.shop/#organization"},
          "inLanguage": ["bn-BD", "en"],
          "potentialAction": {
            "@type": "SearchAction",
            "target": {
              "@type": "EntryPoint",
              "urlTemplate": "https://usuper.shop/product-list?search={search_term_string}"
            },
            "query-input": "required name=search_term_string"
          }
        },
        {
          "@type": "Store",
          "@id": "https://usuper.shop/#store",
          "name": "U Super Shop",
          "url": "https://usuper.shop",
          "image": "https://usuper.shop/frontend/assets/images/logo.png",
          "description": "U Super Shop — Bangladesh's trusted online shopping platform for fashion, electronics, cosmetics and more.",
          "priceRange": "৳৳",
          "areaServed": "BD",
          "currenciesAccepted": "BDT",
          "paymentAccepted": "Cash, bKash",
          "openingHoursSpecification": {
            "@type": "OpeningHoursSpecification",
            "dayOfWeek": ["Monday","Tuesday","Wednesday","Thursday","Friday","Saturday","Sunday"],
            "opens": "09:00",
            "closes": "22:00"
          },
          "address": {
            "@type": "PostalAddress",
            "addressCountry": "BD",
            "addressRegion": "Dhaka"
          },
          "telephone": "+8801816622128",
          "sameAs": ["https://usuper.shop"]
        }
      ]
    }
    </script>
    {{-- FAQ Schema — helps rank for "U Super Shop কি?" searches --}}
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "FAQPage",
      "mainEntity": [
        {
          "@type": "Question",
          "name": "U Super Shop কি?",
          "acceptedAnswer": {
            "@type": "Answer",
            "text": "U Super Shop (usuper.shop) বাংলাদেশের একটি বিশ্বস্ত অনলাইন শপিং প্ল্যাটফর্ম যেখানে আপনি কেনাকাটা করতে পারবেন এবং সেলার, ভেন্ডর বা ড্রপশিপার হিসেবে আয় করতে পারবেন।"
          }
        },
        {
          "@type": "Question",
          "name": "U Super Shop-এ কিভাবে সেলার হওয়া যায়?",
          "acceptedAnswer": {
            "@type": "Answer",
            "text": "usuper.shop/seller/signup পেজে গিয়ে রেজিস্ট্রেশন করুন। সেলার প্যাকেজ নিন এবং আপনার পণ্য বিক্রি শুরু করুন। ড্রপশিপার হিসেবে ইনভেস্টমেন্ট ছাড়াই ব্যবসা করা সম্ভব।"
          }
        },
        {
          "@type": "Question",
          "name": "U Super Shop-এ ডেলিভারি কতদিনে হয়?",
          "acceptedAnswer": {
            "@type": "Answer",
            "text": "U Super Shop থেকে সাধারণত ঢাকার মধ্যে ১-২ কার্যদিবসে এবং ঢাকার বাইরে ২-৫ কার্যদিবসে ডেলিভারি দেওয়া হয়।"
          }
        },
        {
          "@type": "Question",
          "name": "U Super Shop-এর রিটার্ন পলিসি কি?",
          "acceptedAnswer": {
            "@type": "Answer",
            "text": "পণ্য গ্রহণের সময় ডেলিভারি ম্যান সামনে থাকা অবস্থায় পণ্য চেক করুন। কোনো সমস্যা থাকলে সাথে সাথে জানান। ডেলিভারি ম্যান চলে যাওয়ার পর অভিযোগ গ্রহণযোগ্য নয়।"
          }
        },
        {
          "@type": "Question",
          "name": "U Super Shop-এ পেমেন্ট কিভাবে করবো?",
          "acceptedAnswer": {
            "@type": "Answer",
            "text": "U Super Shop-এ bKash এবং Cash on Delivery (COD) পেমেন্ট গ্রহণযোগ্য। COD অর্ডারেও ডেলিভারি চার্জ bKash-এ আগে পরিশোধ করতে হয়।"
          }
        }
      ]
    }
    </script>

@endpush
@section('custom_css')
    <style>

        #categorySliderSection .category-slide-new {
            padding: 10px 0px 0px 0px;
            background: #fff;
        }
        #categorySliderSection .owl-item {
            text-align: center;
            margin: 0px;
        }

        #categorySliderSection .owl-item a {
            text-align: center;
        }

        #categorySliderSection .category_area img {
            width: 80px;
            height: 80px;
        }

        #categorySliderSection .category_area h5 {
            text-align: center;
            font-size: 13px;
            font-weight: 700;
            margin-top: 6px !important;
            font-family: 'Hind Siliguri', sans-serif;
            color: #333;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 80px;
            margin-left: auto;
            margin-right: auto;
        }

        #categorySliderSection .category-slide-new .item {
            opacity: 1 !important;
            filter: none !important;
        }

        #categorySliderSection .category_area img {
            border: 2px solid #eee;
            border-radius: 50%;
            padding: 3px;
            text-align: center;
            margin: auto;
            object-fit: cover;
            background: #f8f8f8;
            transition: border-color .2s, transform .2s;
        }
        #categorySliderSection .category_area:hover img {
            border-color: #e8001d;
            transform: scale(1.05);
        }

        @media (max-width: 1140px) {
            #categorySliderSection .category_area img {
                width: 80px;
                height: 80px;
            }
        }

        @media (max-width: 992px) {
            #categorySliderSection .category_area img {
                width: 75px;
                height: 75px;
            }
        }

        @media (max-width: 768px) {
            #categorySliderSection .category_area img {
                width: 72px;
                height: 72px;
            }
            #categorySliderSection .category_area h5 {
                font-size: 12px;
                max-width: 72px;
            }
            #categorySliderSection .col-xs-12 {
                padding: 0px;
            }
                padding: 0px;
            }

            #categorySliderSection .category_area h5{
                width:70px;
                font-size:13px !important;
                margin-bottom:10px;
                text-align:center;
            }


        }

        /* @media (min-width: 598px) and (max-width: 875px) {
            #hero {
                margin-top: 0 !important;
            }

        } */
        .home-banner-row{
            margin-top: 5px;
        }
        .left_advertisement img {
            width: 100%;
        }
    </style>
@endsection
@section('content')
    <div class="body-content" id="top-banner-and-menu">
        <h1 class="sr-only" style="position:absolute; width:1px; height:1px; padding:0; margin:-1px; overflow:hidden; clip:rect(0,0,0,0); border:0;">U Super Shop - Best Online Shop কেনাকাটা আর আয়ের সেরা ঠিকানা!</h1>
        <div class="container">
            <div class="row home-banner-row">
                <div class="col-xs-12 col-sm-12 col-md-8 sliderFixed">
                    @include('frontend.layouts.slider')

                    {{-- ── Free Delivery Banner ── --}}
                    <div style="background:linear-gradient(90deg,#00a855,#007a3d);padding:10px 16px;display:flex;align-items:center;gap:10px;border-radius:0 0 10px 10px;margin-bottom:10px;">
                        <span style="font-size:22px;flex-shrink:0;">🚚</span>
                        <div style="flex:1;">
                            <strong style="color:#fff;font-size:13px;display:block;line-height:1.3;">১,০০০ টাকার উপরে অর্ডারে FREE DELIVERY!</strong>
                            <span style="color:rgba(255,255,255,.88);font-size:13px;">আজই অর্ডার করুন — সারাদেশে দ্রুত ডেলিভারি</span>
                        </div>
                        <span style="background:#fff;color:#00a855;font-size:13px;font-weight:800;padding:5px 14px;border-radius:20px;white-space:nowrap;flex-shrink:0;">FREE 🎉</span>
                    </div>
                    {{-- <div class="info-boxes wow fadeInUp">
                        <div class="desktop_show">
                            <div class="info-boxes-inner">

                                <div class="info-box">
                                    <h4 class="info-box-heading green english_lang">money back</h4>
                                    <h4 style="display:none" class="info-box-heading green bangla_lang">টাকা ফেরত
                                    </h4>

                                    <h6 class="text english_lang">30 Days Money Back Guarantee</h6>
                                    <h6 style="display:none" class="text bangla_lang">৩০ দিনের মধ্যে টাকা ফেরত
                                        নিশ্চয়তা</h6>
                                </div>
                            </div>
                        </div>
                    </div> --}}
                </div>
                <div class="col-xs-12 col-sm-12 col-md-4" >
                    @php
                        $banners = Helper::bannerImage();
                    @endphp
                    <div class="left_advertisement">
                        <img 
                            src="{{ !empty($banners->banner_small_image_one) ? url('upload/banner/' . $banners->banner_small_image_one) : url('upload/slider_images/slider-2.png') }}"
                            alt="Banner Advertisement" />
                    </div>
                </div>
            </div>

            <div class="row" id="categorySliderSection">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="owl-carousel owl-theme category-slide-new "style="margin: 0px;">

                        @php
                            $categories = App\Models\Category::orderBy('id', 'ASC')->get();
                            
                        @endphp

                        @foreach ($categories as $key => $category)
                            <div class="item category_area">
                                <a href="{{ route('category.wise.product', $category->id) }}">
                                    <img loading="lazy" class="img-circle" src="{{ !empty($category->image) ? url('upload/category_images/' . $category->image) : url('frontend/no-image-icon.jpg') }}" alt="{{ $category->name }}" />
                                    <h5 style="margin: 0px;">{{ substr($category->name, 0, 10) }}</h5>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- ====================== CONTENT ===================== -->
                <div class="col-xs-12 col-sm-12 col-md-12 homebanner-holder">

                    {{-- ── Homepage Feature Sections ─────────────── --}}
                    @include('frontend.layouts.home_sections')

                    <!-- =============== SCROLL TABS ================ -->
                    @include('frontend.layouts.product_tab')
                    @include('frontend.layouts.special_offer_products')

                    @include('frontend.layouts.special_deals_products')

                    @include('frontend.layouts.featured_product')


                    <div class="row">
                        <div class="col-md-12">
                            <a href="{{ route('speacial.offers') }}">
                                <div class="wide-banner cnt-strip">
                                    <div class="image">
                                        <img style="width:100%; height:100px" class="img-responsive"
                                            src="{{ !empty($banners->category_banner_image) ? url('upload/banner/' . $banners->category_banner_image) : url('frontend/assets/images/banners/home-banner1212.jpg') }}"
                                            alt="Category Offer Banner" />
                                    </div>

                                    <!-- /.new-label -->
                                </div>
                            </a>

                            <!-- /.wide-banner -->
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->


                    <!-- =============== CATEGORY PRODUCTS ================ -->
                 
                    @include('frontend.layouts.category_product')


                    @include('frontend.layouts.best_selling_products')


                </div>
                <!-- ====================== CONTENT : END =================== -->
            </div>

        </div>
    </div>
@endsection

@push('custom_script')
    <script>
    $(document).ready(function() {

        // ── 1. CATEGORY AUTO SLIDER ───────────────────────────────────
        if ($('.category-slide-new').length && $('.category-slide-new .item').length > 0) {
            var catItems = $('.category-slide-new .item').length;
            var canLoop  = catItems >= 6;

            if ($('.category-slide-new').hasClass('owl-loaded')) {
                $('.category-slide-new').trigger('destroy.owl.carousel').removeClass('owl-carousel owl-loaded');
            }

            $('.category-slide-new').owlCarousel({
                nav:                false,
                loop:               canLoop,
                rewind:             !canLoop,
                autoplay:           true,
                autoplayTimeout:    3500,
                autoplayHoverPause: true,
                smartSpeed:         700,
                dots:               false,
                stagePadding:       10,
                margin:             6,
                responsive: {
                    0:    { items: 4, margin: 6,  stagePadding: 8  },
                    360:  { items: 5, margin: 6,  stagePadding: 8  },
                    480:  { items: 5, margin: 8,  stagePadding: 10 },
                    600:  { items: 6, margin: 8  },
                    768:  { items: 7, margin: 10 },
                    992:  { items: 8, margin: 10 },
                    1200: { items: 10, margin: 12 }
                }
            });
        }

        // ── 2. PRODUCT TAB CAROUSEL ───────────────────────────────────
        function initProductCarousel(selector, timeout) {
            if (!$(selector).length) return;
            $(selector).each(function() {
                var $owl = $(this);
                if ($owl.hasClass('owl-loaded')) return;
                $owl.owlCarousel({
                    loop: true, autoplay: true,
                    autoplayTimeout: timeout || 2800,
                    autoplayHoverPause: true,
                    smartSpeed: 600,
                    dots: false, nav: false, margin: 8,
                    responsive: {
                        0:   { items: 2, margin: 8  },
                        350: { items: 2, margin: 8  },
                        480: { items: 2, margin: 8  },
                        556: { items: 3, margin: 8  },
                        650: { items: 3, margin: 8  },
                        768: { items: 4, margin: 10 },
                        992: { items: 4, margin: 10 },
                        1200:{ items: 5, margin: 12 }
                    }
                });
            });
        }

        initProductCarousel('.new_productsTab',       4500);
        initProductCarousel('.home-owl-carouseltab',   4500);
        initProductCarousel('.categoryProducts',       4000);
        initProductCarousel('.best_selling',           5000);
        initProductCarousel('.featuredProducts',       5500);
        initProductCarousel('.special_offer_carousel', 4200);
        initProductCarousel('.special_deals_err',      4300);
        initProductCarousel('.best-seller',            4800);

        // ── 3. TAB SWITCH — refresh carousel ─────────────────────────
        $(document).on('click', '.nav-tabs .nav-link, .product-tab-btn', function() {
            setTimeout(function() {
                $('.new_productsTab, .home-owl-carouseltab').each(function() {
                    if ($(this).hasClass('owl-loaded')) {
                        $(this).trigger('refresh.owl.carousel');
                    }
                });
            }, 150);
        });

    }); // end ready
    </script>
    {{-- Live Chat — DB থেকে control --}}
    @php
        try {
            $lcS = \App\Models\Setting::first();
            $lcEnabled = $lcS->livechat_enabled ?? 1;
            $lcPropId  = $lcS->tawkto_property_id ?? '67769592af5bfec1dbe5cfa4';
            $lcWidgetId = $lcS->tawkto_widget_id ?? '1igjjqi4t';
        } catch (\Exception $e) {
            $lcEnabled = 1; $lcPropId = '67769592af5bfec1dbe5cfa4'; $lcWidgetId = '1igjjqi4t';
        }
    @endphp
    @if($lcEnabled)
    <!--Start of Tawk.to Script-->
    <script type="text/javascript">
        var Tawk_API = Tawk_API || {}, Tawk_LoadStart = new Date();
        (function(){
            var s1 = document.createElement("script"), s0 = document.getElementsByTagName("script")[0];
            s1.async = true;
            s1.src = 'https://embed.tawk.to/{{ $lcPropId }}/{{ $lcWidgetId }}';
            s1.charset = 'UTF-8';
            s1.setAttribute('crossorigin','*');
            s0.parentNode.insertBefore(s1, s0);
        })();
    </script>
    <!--End of Tawk.to Script-->
    @endif

@endpush
