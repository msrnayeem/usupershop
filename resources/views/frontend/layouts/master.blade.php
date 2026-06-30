<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    {{-- Google Search Console Verification --}}
    @php
        try {
            $seoSettings = \App\Models\Setting::first();
            $seoTitle       = $seoSettings->seo_site_title ?? 'U Super Shop | Best Online Shop in Bangladesh';
            $seoDesc        = $seoSettings->seo_meta_description ?? '';
            $seoKeywords    = $seoSettings->seo_meta_keywords ?? '';
            $seoGoogleVerif = $seoSettings->seo_google_verification ?? '';
            $seoOgImage     = !empty($seoSettings->seo_og_image) ? asset('upload/seo/' . $seoSettings->seo_og_image) : asset('frontend/images/og-default.jpg');
            $socialFb       = $seoSettings->social_facebook ?? '';
            $socialYt       = $seoSettings->social_youtube ?? '';
            $socialIg       = $seoSettings->social_instagram ?? '';
            $socialTg       = $seoSettings->social_telegram ?? '';
            $socialTk       = $seoSettings->social_tiktok ?? '';
            $bizAddress     = $seoSettings->business_address ?? 'Dhaka, Bangladesh';
            $bizEmail       = $seoSettings->business_email ?? 'usupershopbd@gmail.com';
            $seoFavicon     = !empty($seoSettings->seo_favicon) ? asset('upload/seo/' . $seoSettings->seo_favicon) : asset('frontend/images/favicon.ico');
            $seoLogo        = !empty($seoSettings->seo_logo) ? asset('upload/seo/' . $seoSettings->seo_logo) : asset('upload/logo/' . (\App\Models\Logo::first()->image ?? 'logo.png'));
        } catch (\Exception $e) {
            $seoTitle = 'U Super Shop | Best Online Shop in Bangladesh';
            $seoDesc = $seoKeywords = $seoGoogleVerif = '';
            $seoOgImage = asset('frontend/images/og-default.jpg');
            $socialFb = $socialYt = $socialIg = $socialTg = $socialTk = '';
            $bizAddress = 'Dhaka, Bangladesh'; $bizEmail = 'usupershopbd@gmail.com';
            $seoFavicon = asset('frontend/images/favicon.ico');
            $seoLogo = asset('frontend/images/logo.png');
        }
    @endphp

    @if($seoGoogleVerif && $seoGoogleVerif !== 'ADD_YOUR_VERIFICATION_CODE_HERE')
    <meta name="google-site-verification" content="{{ $seoGoogleVerif }}" />
    @endif
    {{-- Preconnect for performance --}}
    <link rel="preconnect" href="https://fonts.googleapis.com" crossorigin>
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://cdnjs.cloudflare.com" crossorigin>
    <link rel="dns-prefetch" href="https://embed.tawk.to">
    {{-- PWA / Mobile App Meta --}}
    <link rel="manifest" href="/manifest.json">
    <meta name="theme-color" content="#e8001d">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="apple-mobile-web-app-title" content="U Super Shop">
    <meta name="msapplication-TileColor" content="#1e25fa">
    {{-- Mobile UX --}}
    <meta name="format-detection" content="telephone=yes">
    <style>
      /* PWA / Mobile App feel */
      html { -webkit-tap-highlight-color: transparent; scroll-behavior: smooth; }
      body { -webkit-overflow-scrolling: touch; }
      * { -webkit-tap-highlight-color: rgba(0,0,0,0); }
      /* Bottom safe area for iPhone notch */
      .body-content { padding-bottom: env(safe-area-inset-bottom, 0px); }
    </style>

    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0, viewport-fit=cover" />
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="apple-mobile-web-app-title" content="U Super Shop">
    <meta name="theme-color" content="#ffffff" media="(prefers-color-scheme: light)">
    <meta name="theme-color" content="#ffffff">
    <style>
      html { -webkit-tap-highlight-color: transparent; scroll-behavior: smooth; }
      body { -webkit-overflow-scrolling: touch; }
      * { -webkit-tap-highlight-color: rgba(0,0,0,0); }
      /* iPhone safe area */
      body { padding-top: env(safe-area-inset-top, 0px); }
      .body-content { padding-bottom: env(safe-area-inset-bottom, 0px); }
    </style>
    <meta name="csrf-token" content="{{ csrf_token() }}">


    {{-- SEO Meta Tags --}}
    <meta name="description" content="@yield('meta_description', 'U Super Shop (usuper.shop) | Best Online Shop & Dropshipping Platform in Bangladesh. কেনাকাটা আর আয়ের সেরা ঠিকানা! সেরা ডিলে প্রিমিয়াম শপিং করুন অথবা সেলার ও ড্রপশিপার হয়ে ইনভেস্টমেন্ট ছাড়াই ব্যবসা শুরু করুন।')" />
    <meta name="keywords" content="@yield('meta_keywords', 'U Super Shop, usuper.shop, dropshipping bangladesh, reselling platform bd, online shop bangladesh, best online shopping site in bangladesh, online shop bd, অনলাইন শপ বাংলাদেশ, উ সুপার শপ, কেনাকাটা, ইনভেস্টমেন্ট ছাড়া ব্যবসা, reseller bangladesh, zero investment business bd, online grocery bd, cosmetics online shop bangladesh')" />
    <meta name="author" content="U Super Shop" />
    <meta name="robots" content="@yield('meta_robots', 'index, follow, max-image-preview:large')" />

    {{-- Geo / Local SEO --}}
    <meta name="geo.region" content="BD" />
    <meta name="geo.placename" content="Dhaka, Bangladesh" />
    <meta name="language" content="Bengali, English" />

    {{-- Open Graph --}}
    <meta property="og:site_name" content="U Super Shop" />
    <meta property="og:title" content="@yield('og_title', 'U Super Shop | Best Online Shop in Bangladesh')" />
    <meta property="og:description" content="@yield('og_description', 'মানসম্মত পণ্য, দ্রুত ডেলিভারি, বিশ্বস্ত সেবা — U Super Shop-এ কেনাকাটা করুন। সেলার বা ড্রপশিপার হিসেবে আজই যোগ দিন!')" />
    <meta property="og:image" content="@yield('og_image', $seoOgImage)" />
    <meta property="og:image:width" content="1200" />
    <meta property="og:image:height" content="630" />
    <meta property="og:url" content="{{ url()->current() }}" />
    <meta property="og:type" content="@yield('og_type', 'website')" />
    <meta property="og:locale" content="bn_BD" />
    <link rel="canonical" href="{{ url()->current() }}" />

    {{-- Twitter Card --}}
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:site" content="@usupershop" />
    <meta name="twitter:title" content="@yield('twitter_title', 'U Super Shop | Best Online Shop in Bangladesh')" />
    <meta name="twitter:description" content="@yield('twitter_description', 'U Super Shop — আপনার নির্ভরযোগ্য অনলাইন শপ। সেরা দামে কেনাকাটা করুন!')" />
    <meta name="twitter:image" content="@yield('twitter_image', $seoOgImage)" />

    {{-- Per-page extra meta --}}
    @stack('meta')

    <title>@yield('title', 'U Super Shop | Best Online Shop in Bangladesh')</title>

    {{-- JSON-LD: Organization Schema --}}
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "Organization",
      "name": "U Super Shop",
      "url": "https://usuper.shop",
      "logo": "{{ $seoLogo }}",
      "description": "U Super Shop — বাংলাদেশের বিশ্বস্ত অনলাইন শপিং প্ল্যাটফর্ম। সেলার, ভেন্ডর ও ড্রপশিপার হওয়ার সুযোগ।",
      "address": {
        "@type": "PostalAddress",
        "addressLocality": "Dhaka",
        "addressCountry": "BD"
      },
      "contactPoint": {
        "@type": "ContactPoint",
        "telephone": "+8801816622128",
        "contactType": "customer service",
        "areaServed": "BD",
        "availableLanguage": ["Bengali", "English"]
      },
      "sameAs": [
        "https://www.facebook.com/share/1VjqK6xoDm/",
        "https://youtube.com/@usupershop",
        "https://www.instagram.com/usupershop",
        "https://t.me/usupershop1",
        "https://tiktok.com/@usupershop"
      ]
    }
    </script>

    @if(!empty($seoSettings->google_analytics_id) && $seoSettings->google_analytics_id !== '')
    {{-- Google Analytics --}}
    <script async src="https://www.googletagmanager.com/gtag/js?id={{ $seoSettings->google_analytics_id }}"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', '{{ $seoSettings->google_analytics_id }}');
    </script>
    @endif
    <!-- Bootstrap Core CSS -->
    <link rel="stylesheet" href="{{ asset('frontend') }}/assets/css/bootstrap.min.css" />
    <!-- Customizable CSS -->
    <link rel="icon" type="image/x-icon" href="{{ $seoFavicon }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{ $seoFavicon }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ $seoLogo }}">
    <link rel="stylesheet" href="{{ asset('frontend') }}/assets/css/main.css" />
    <link rel="stylesheet" href="{{ asset('frontend') }}/assets/css/blue.css" />
    <link rel="stylesheet" href="{{ asset('frontend') }}/assets/owl-carousel/css/owl.carousel.min.css" />
    <link rel="stylesheet" href="{{ asset('frontend') }}/assets/owl-carousel/css/owl.theme.default.min.css" />
    <link rel="stylesheet" href="{{ asset('frontend') }}/assets/css/animate.min.css" />
    <link rel="stylesheet" href="{{ asset('frontend') }}/assets/css/rateit.css" />
    <link rel="stylesheet" href="{{ asset('frontend') }}/assets/css/bootstrap-select.min.css" />
    <link rel="stylesheet" href="{{ asset('css/jquery-ui.css') }}" type="text/css" media="all" />
    <link rel="stylesheet" href="{{ asset('vendor/flasher/flasher.min.css') }}">

    <link rel="stylesheet" type="text/css" href="{{ asset('frontend') }}/assets/css/select2.min.css">
    <link rel="stylesheet" href="{{ asset('frontend') }}/assets/css/lightbox.css" />
    <!-- Icons/Glyphs -->
    <link rel="stylesheet" href="{{ asset('frontend') }}/assets/css/font-awesome.css" />
    <link rel="stylesheet" href="{{ asset('frontend') }}/assets/fonts/icofont.min.css" />
    <!-- Fonts -->
    {{-- Non-blocking Google Fonts --}}
    <link rel="preload" href="https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@400;500;600;700&family=Roboto:wght@300;400;500;700&family=Open+Sans:wght@400;600;700&display=swap" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript><link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@400;500;600;700&family=Roboto:wght@300;400;500;700&display=swap"></noscript>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script type="text/javascript" src="{{ asset('js/jquery.cookie.min.js') }}"></script>

    <script src="{{ asset('js/notify.min.js') }}"></script>
    <script>
        (function() {
            var notifyClassMap = {
                error: 'error',
                warning: 'warn',
                success: 'success',
                info: 'info'
            };

            window.flasher = window.flasher || {};
            ['error', 'warning', 'success', 'info'].forEach(function(type) {
                if (typeof window.flasher[type] !== 'function') {
                    window.flasher[type] = function(message) {
                        if (window.$ && typeof $.notify === 'function') {
                            $.notify(message, {
                                globalPosition: 'top right',
                                className: notifyClassMap[type] || 'info'
                            });
                            return;
                        }

                        if (window.console) {
                            if (type === 'error') {
                                console.error(message);
                            } else {
                                console.log(message);
                            }
                        }
                    };
                }
            });
        })();
    </script>
    @php
        use App\Models\ColorSetting;
        $colors = ColorSetting::getAllColors();

    @endphp
    <style>
        :root {
            --header-bg: {{ $colors['header_bg'] ?? '#0824AC' }};
            --sub-header-bg: {{ $colors['sub_header_bg'] ?? '#0a00a1' }};
            --header-text: {{ $colors['header_text'] ?? '#000000' }};
            --footer-bg: {{ $colors['footer_bg'] ?? '#202020' }};
            --footer-text: {{ $colors['footer_text'] ?? '#ffffff' }};
            --search-icon-bg: {{ $colors['search_icon_bg'] ?? '#007bff' }};
            --search-icon-color: {{ $colors['search_icon_color'] ?? '#ffffff' }};
            --add-to-cart-bg: {{ $colors['add_to_cart_bg'] ?? '#0824ac' }};
            --add-to-cart-text: {{ $colors['add_to_cart_text'] ?? '#ffffff' }};
            --price-color: {{ $colors['price_color'] ?? '#0824AC' }};
            --primary-button: {{ $colors['primary_button'] ?? '#007bff' }};
            --secondary-button: {{ $colors['secondary_button'] ?? '#6c757d' }};
        }
    </style>


    @include('frontend.layouts.css')
    @yield('custom_css')
</head>

<body class="cnt-home">
    <!-- ============ HEADER ============= -->
    @include('frontend.layouts.header')
    <!-- ============ HEADER : END ============ -->

    @yield('content')


    <!-- ============ FOOTER ============ -->
    @include('frontend.layouts.footer')

    {{-- =============== product view  modal ============= --}}
    <!-- Modal -->
    {{-- <div class="modal fade" id="cartModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"><span id="pname"></span></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="closeModal">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="padding-bottom: 30px;">
                    <form method="POST" id="CardFormData">
                        <div class="row">
                            <div class="col-sm-5">
                                <button class="modal-product-image-btn" style="margin-bottom: 10px;">
                                    <img src="" class="card-img-top" id="pimage" alt=""
                                        style="height: 200px;width:160px;"
                                        onerror="this.src='{{ asset('/frontend/no-image-icon.jpg') }}'">
                                </button>
                            </div>
                            <div class="col-sm-7">
                               
                                <table class="table table-bordered">
                                    <tbody>
                                        <tr>
                                            <th>Product Code : </th>
                                            <th><span id="pcode"></span></th>
                                        </tr>
                                        <tr>
                                            <th>Category : </th>
                                            <th><span id="pcategory"></span></th>
                                        </tr>
                                        <tr>
                                            <th>Brand : </th>
                                            <th><span id="pbrand"></span></th>
                                        </tr>
                                        <tr>
                                            <th>Stock : </th>
                                            <th>
                                                <span class="badge badge-pill badge-success" id="aviable" style="background:green; color:white;"></span>
                                                <span class="badge badge-pill badge-danger" id="stockout" style="background:red; color:white;"></span>
                                            </th>
                                        </tr>
                                        <tr>
                                            <th>Price : </th>
                                            <td id="pprice"></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-sm-12">
                                <div class="row" style="margin-top: 10px;">
                                    <div class="col-sm-6 col-xs-6">
                                        <div class="form-group">
                                            <label for="color">Select Color</label>
                                            <select class="form-control" id="color" name="color">
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-xs-6">
                                        <div class="form-group" id="sizeArea">
                                            <label for="size">Select Size</label>
                                            <select class="form-control" id="size" name="size">
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group" style="display: flex ; margin: auto; vertical-align: middle;">
                                    <label for="qty" style="line-height: 28px; text-transform: uppercase; margin-right: 10px;">QTY : </label>
                                    <div class=" clearfix arrows-modal">
                                        <button type="button" class="pull-left arrow minus gradient" style="padding: 7px 12px; border: 1px solid #ddd; border-top-left-radius: 4px; border-bottom-left-radius: 4px;">
                                            <span class="ir"><i class="fa fa-minus"></i></span>
                                        </button>
                                        <input type="text" readonly class="form-control text-center pull-left"
                                            id="qty" value="1" min="1" style="width: 50px; border-radius: 0px; border: 1px solid #ddd; font-weight: 600; font-size: 16px;">
                                        <button type="button" class="pull-left arrow plus gradient" style="padding: 7px 12px; border: 1px solid #ddd; border-top-right-radius: 4px; border-bottom-right-radius: 4px;">
                                            <span class="ir"><i class="fa fa-plus"></i></span>
                                        </button>
                                    </div>
                                    <input type="hidden" id="product_id">
                                    <div class="addcartBtnSection" style="margin: auto; margin-left: 0px;">
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div> --}}

    <div class="modal fade" id="cartModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"><span id="pname"></span></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="closeModal">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="padding-bottom: 30px;">
                    <div class="add_to_cart_product_data">
                        <div class="row">
                            <div class="col-xs-4 col-sm-5">
                                <button class="modal-product-image-btn" style="margin-bottom: 10px; width: 100%;">
                                    <img src="" class="card-img-top img-responsive" id="pimage" alt=""
                                        style="height: auto; max-height: 200px; width: auto; max-width: 100%; margin: auto;"
                                        onerror="this.src='{{ asset('/frontend/no-image-icon.jpg') }}'">
                                </button>
                            </div>
                            <div class="col-xs-8 col-sm-7">
                                <table class="table table-bordered" style="margin-bottom: 10px; font-size: 13px;">
                                    <tbody>
                                        <tr>
                                            <th style="padding: 6px 8px;">Product Code : </th>
                                            <td style="padding: 6px 8px;"><span id="pcode"></span></td>
                                        </tr>
                                        <tr>
                                            <th style="padding: 6px 8px;">Category : </th>
                                            <td style="padding: 6px 8px;"><span id="pcategory"></span></td>
                                        </tr>
                                        <tr>
                                            <th style="padding: 6px 8px;">Brand : </th>
                                            <td style="padding: 6px 8px;"><span id="pbrand"></span></td>
                                        </tr>
                                        <tr>
                                            <th style="padding: 6px 8px;">Stock : </th>
                                            <td style="padding: 6px 8px;">
                                                <span class="badge badge-pill badge-success" id="aviable"
                                                    style="background:green; color:white; font-size: 11px; padding: 2px 6px;"></span>
                                                <span class="badge badge-pill badge-danger" id="stockout"
                                                    style="background:red; color:white; font-size: 11px; padding: 2px 6px;"></span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th style="padding: 6px 8px;">Price : </th>
                                            <td id="pprice" style="padding: 6px 8px; font-weight: bold;"></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-sm-12">
                                <div class="row" style="margin-top: 10px;">
                                    <div class="col-sm-6 col-xs-6">
                                        <div class="form-group custom-select-wrap">
                                            <label>Select Color</label>
                                            <div class="custom-select-box" id="colorBox">
                                                <div class="custom-select-trigger" id="colorTrigger">Select Color <span class="caret-icon">&#9660;</span></div>
                                                <div class="custom-select-options" id="colorOptions"></div>
                                            </div>
                                            <input type="hidden" id="color" name="color" value="">
                                            <span class="text-danger color_id_errors"></span>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-xs-6">
                                        <div class="form-group custom-select-wrap" id="sizeArea">
                                            <label>Select Size</label>
                                            <div class="custom-select-box" id="sizeBox">
                                                <div class="custom-select-trigger" id="sizeTrigger">Select Size <span class="caret-icon">&#9660;</span></div>
                                                <div class="custom-select-options" id="sizeOptions"></div>
                                            </div>
                                            <input type="hidden" id="size" name="size" value="">
                                            <span class="text-danger size_id_errors"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group" style="display: flex ; margin: auto; vertical-align: middle;">
                                    <label for="qty"
                                        style="line-height: 28px; text-transform: uppercase; margin-right: 10px;">QTY :
                                    </label>
                                    <div class=" clearfix arrows-modal">
                                        <button type="button" class="pull-left arrow minus gradient"
                                            style="padding: 7px 12px; border: 1px solid #ddd; border-top-left-radius: 4px; border-bottom-left-radius: 4px;">
                                            <span class="ir"><i class="fa fa-minus"></i></span>
                                        </button>
                                        <input type="text" readonly class="form-control text-center pull-left"
                                            id="qty" value="1" min="1"
                                            style="width: 50px; border-radius: 0px; border: 1px solid #ddd; font-weight: 600; font-size: 16px;">
                                        <button type="button" class="pull-left arrow plus gradient"
                                            style="padding: 7px 12px; border: 1px solid #ddd; border-top-right-radius: 4px; border-bottom-right-radius: 4px;">
                                            <span class="ir"><i class="fa fa-plus"></i></span>
                                        </button>
                                    </div>
                                    <input type="hidden" id="product_id">

                                    @if (auth()->check() && auth()->user()->usertype == 'dropshipper')
                                        <div class="col-lg-6 col-md-6 col-sm-12">
                                            <input type="hidden" id="product-dropshipper-price" class="form-control"
                                                value="0">
                                            <label>Your Selling Price</label>
                                            <input type="number" oninput="showProfitt()" name="selling_price"
                                                step="0.01" id="selling_price" value="{{ old('selling_price') }}"
                                                class="form-control @error('selling_price') is-invalid @enderror"
                                                placeholder="Enter your selling price" required>
                                            <small class="text-muted dropshipper-range" id="dropshipper-range">
                                                Allowed range:

                                            </small><br>
                                            <small id="profit_display" class="text-muted text-danger">

                                            </small>
                                            @error('selling_price')
                                                <div class="invalid-feedback">
                                                    {{ $message }}</div>
                                            @enderror
                                        </div>
                                    @endif


                                    <div class="addcartBtnSection" style="margin: auto; margin-left: 0px;">

                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ============= FOOTER : END ============ -->
    <script src="{{ asset('frontend') }}/assets/js/bootstrap.min.js"></script>
    <script src="{{ asset('frontend') }}/assets/js/bootstrap-hover-dropdown.min.js"></script>
    <script src="{{ asset('frontend') }}/assets/owl-carousel/js/owl.carousel.min.js"></script>

    <script src="{{ asset('frontend') }}/assets/js/echo.min.js"></script>
    <script src="{{ asset('frontend') }}/assets/js/jquery.easing-1.3.min.js"></script>
    <script src="{{ asset('frontend') }}/assets/js/bootstrap-slider.min.js"></script>
    <script src="{{ asset('frontend') }}/assets/js/jquery.rateit.min.js"></script>
    <script src="{{ asset('frontend') }}/assets/js/lightbox.min.js"></script>
    <script src="{{ asset('frontend') }}/assets/js/bootstrap-select.min.js"></script>
    <script src="{{ asset('frontend') }}/assets/js/wow.min.js"></script>
    <script src="{{ asset('frontend') }}/assets/js/scripts.js"></script>
    <script src="{{ asset('frontend') }}/assets/js/select2.min.js"></script>
    <script>
        $(".js-select2").each(function() {
            $(this).select2({
                minimumResultsForSearch: 20,
                dropdownParent: $(this).next('.dropDownSelect2')
            });
        });
        $(document).ready(function() {
            $(".plus").click(function() {
                let qty = $("#qty");
                let currentVal = parseInt(qty.val());
                if (!isNaN(currentVal)) {
                    qty.val(currentVal + 1);
                }
            });

            $(".minus").click(function() {
                let qty = $("#qty");
                let currentVal = parseInt(qty.val());
                if (!isNaN(currentVal) && currentVal > 1) {
                    qty.val(currentVal - 1);
                }
            });
        });
    </script>

    <script src="{{ asset('frontend') }}/assets/js/sweetalert.min.js"></script>
    <script type="text/javascript" src="{{ asset('js/jquery.cookie.js') }}"></script>
    <script src="{{ asset('backend') }}/plugins/jquery-validation/jquery.validate.min.js"></script>

    <script src="{{ asset('vendor/flasher/flasher.min.js') }}"></script>
    @if (session()->has('success'))
        {{ session()->get('success') }}
    @endif
    @if (session()->has('error'))
        {{ session()->get('error') }}
    @endif
    @if (session()->has('warning'))
        {{ session()->get('warning') }}
    @endif
    @if (session()->has('info'))
        {{ session()->get('info') }}
    @endif


    <script>
        function error_msg(message) {
            window.flasher.error(message, {
                timeout: 1500
            });
        }

        function warning_msg(message) {
            window.flasher.warning(message, {
                timeout: 1500
            });
        }

        function success_msg(message) {
            window.flasher.success(message, {
                timeout: 1500
            });
        }

        function info_msg(message) {
            window.flasher.info(message, {
                timeout: 1500
            });
        }
    </script>


    {{-- ── Custom inline select JS ── --}}
    <script>
    $(document).ready(function () {

        /* Toggle open/close */
        $(document).on('click', '.custom-select-trigger', function (e) {
            e.stopPropagation();
            var $box = $(this).closest('.custom-select-box');
            // Close all other open boxes
            $('.custom-select-box').not($box).removeClass('open');
            $box.toggleClass('open');
        });

        /* Pick an item – color */
        $(document).on('click', '#colorOptions .cso-item', function (e) {
            e.stopPropagation();
            var val  = $(this).data('value');
            var text = $(this).text();
            $('#colorOptions .cso-item').removeClass('selected');
            $(this).addClass('selected');
            $('#colorTrigger').html(text + ' <span class="caret-icon">&#9660;</span>');
            $('#color').val(val);
            $('#colorBox').removeClass('open');
        });

        /* Pick an item – size */
        $(document).on('click', '#sizeOptions .cso-item', function (e) {
            e.stopPropagation();
            var val  = $(this).data('value');
            var text = $(this).text();
            $('#sizeOptions .cso-item').removeClass('selected');
            $(this).addClass('selected');
            $('#sizeTrigger').html(text + ' <span class="caret-icon">&#9660;</span>');
            $('#size').val(val);
            $('#sizeBox').removeClass('open');
        });

        /* Close when clicking outside */
        $(document).on('click', function () {
            $('.custom-select-box').removeClass('open');
        });

        /* Reset dropdowns when modal closes */
        $('#cartModal').on('hidden.bs.modal', function () {
            $('.custom-select-box').removeClass('open');
            $('#colorTrigger').html('Select Color <span class="caret-icon">&#9660;</span>');
            $('#sizeTrigger').html('Select Size <span class="caret-icon">&#9660;</span>');
            $('#color').val('');
            $('#size').val('');
            $('#colorOptions').empty();
            $('#sizeOptions').empty();
        });
    });
    </script>


    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        })

        const isDropshipperUser = @json(auth()->check() && auth()->user()->usertype === 'dropshipper');

        //start product view with modal
        function productView(id) {
            $.ajax({
                type: 'GET',
                url: "{{ url('/product/view/modal/') }}/" + id,
                dataType: 'json',
                success: function(data) {
                    console.log(data);
                    let hasWholesalePrice = isDropshipperUser && Number(data.product.sale_price) > 0;
                    let discount = hasWholesalePrice ? 0 : Number(data.product.discount || 0);
                    let discountType = Number(data.product.discount_type || 0);
                    let product_price = hasWholesalePrice ? Number(data.product.sale_price) : Number(data.product.price);
                    let discount_price = discount > 0 ?
                        (discountType === 1 ? product_price - (product_price * discount) / 100 : product_price - discount) :
                        product_price;
                    discount_price = Math.max(discount_price, 0);
                    //console.log(discount_price);
                    $('#pname').text(data.product.name);
                    $('#price').text(product_price.toFixed(2));
                    $('#price').text(product_price.toFixed(2));

                    $('#product-dropshipper-price').val(product_price.toFixed(2));
                    $('#dropshipper-range').text("Allow Range: " + data.product.min_price + " - " + data.product
                        .max_price);
                    $('#pcode').text(data.product.id);
                    $('#pcategory').text(data.product.category.name);
                    $('#pbrand').text(data.product.brand.name);
                    $('#pimage').attr('src', '{{ asset('/upload/product_images') }}/' + data.product.image);
                    $('#product_id').val(id);
                    $('#qty').val(1);
                    //product price
                    if (discount > 0) {
                        $('#pprice').html('<strong><span>&#2547;' + discount_price.toFixed(2) +
                            '</span> <del style="color: #989191;">&#2547;' + product_price.toFixed(2) +
                            '</del></strong>');
                    } else {
                        $('#pprice').html('<span>&#2547; ' + product_price.toFixed(2) + '</span>');
                    }

                    //stock
                    if (data.product.quantity > 0) {
                        $('#aviable').text('');
                        $('#stockout').text('');
                        $('#aviable').text('Available');

                        $('.addcartBtnSection').html(
                            `<button type="button" class="btn btn-success cartBtn" onclick="addToCart(this, ${data.product.id});" style="margin-left: 12px;">Add To Cart</button>`
                        );
                    } else {
                        $('#aviable').text('');
                        $('#stockout').text('');
                        $('#stockout').text('Stock Out');
                        $('.addcartBtnSection').html(
                            `<span style="border: 1px solid #ff00009c; padding: 8px 15px; font-weight: 600; border-radius: 4px; margin: 15px; background: #ff00000a; color: #ff0000;">Stock Out</span>`
                        );
                    }

                    // color — custom dropdown
                    $('#color').val('');
                    $('#colorTrigger').html('Select Color <span class="caret-icon">&#9660;</span>');
                    var colorOpts = '';
                    $.each(data.color, function(key, value) {
                        colorOpts += '<div class="cso-item" data-value="' + value.id + '">' + value.color.name + '</div>';
                    });
                    $('#colorOptions').html(colorOpts);

                    // size — custom dropdown
                    $('#size').val('');
                    $('#sizeTrigger').html('Select Size <span class="caret-icon">&#9660;</span>');
                    var sizeOpts = '';
                    if (data.size && data.size.length > 0) {
                        $('#sizeArea').show();
                        $.each(data.size, function(key, value) {
                            sizeOpts += '<div class="cso-item" data-value="' + value.id + '">' + value.size.name + '</div>';
                        });
                    } else {
                        $('#sizeArea').hide();
                    }
                    $('#sizeOptions').html(sizeOpts);
                }
            })
        }
        //end product view with modal
        // $('#CardFormData').on('submit', function(event) {
        //     event.preventDefault();
        //     var crproduct_name = $('#pname').text();
        //     var id = $('#product_id').val();
        //     var crcolor = $('#color option:selected').val();
        //     var crsize = $('#size option:selected').val();
        //     var crquantity = $('#qty').val();
        //     $.ajax({
        //         url: "{{ url('/cart/data/store/') }}/" + id,
        //         type: "POST",
        //         dataType: 'json',
        //         data: {
        //             _token: "{{ csrf_token() }}",
        //             color: crcolor,
        //             size: crsize,
        //             quantity: crquantity,
        //             product_name: crproduct_name
        //         },
        //         success: function(data) {
        //             console.log(data);
        //             $('#closeModal').click();
        //             if (data.success) {
        //                 $.notify(data.success, "success");
        //                 // Redirect to shopping cart page after a delay
        //                 setTimeout(function() {
        //                     location.reload();
        //                 }, 2000);
        //             } else {
        //                 location.reload();
        //                 $.notify(data.error, "error");
        //             }
        //         }
        //     })
        // });

        // //Start add to cart product
        // function addToCart() {
        //     var product_name = $('#pname').text();
        //     var id = $('#product_id').val();
        //     var color = $('#color option:selected').val();
        //     var size = $('#size option:selected').val();
        //     var quantity = $('#qty').val();

        //     $.ajax({
        //         type: "POST",
        //         dataType: 'json',
        //         data: {
        //             color: color,
        //             size: size,
        //             quantity: quantity,
        //             product_name: product_name
        //         },
        //         url: "{{ url('/cart/data/store/') }}/" + id,
        //         success: function(data) {

        //             $('#closeModal').click();
        //             //  start message
        //             const Toast = Swal.mixin({
        //                 toast: true,
        //                 position: 'top-end',
        //                 showConfirmButton: false,
        //                 timer: 3000
        //             })

        //             if ($.isEmptyObject(data.error)) {
        //                 Toast.fire({
        //                     type: 'success',
        //                     title: data.success
        //                 })
        //             } else {
        //                 Toast.fire({
        //                     type: 'error',
        //                     title: data.error
        //                 })
        //             }
        //             //  end message
        //         }
        //     })
        // }
        // //End add to cart product



        function addToCart(cartBtn, product_id) {
            var closest = $(cartBtn).closest('.add_to_cart_product_data');

            closest.find('.color_id_errors').text('');
            closest.find('.size_id_errors').text('');

            var quantity = closest.find('#qty').val() || 1;
            var color_id = closest.find('#color').val() || '';
            var size_id = closest.find('#size').val() || '';
            var drop_selling_price = $('#selling_price').val() || '';

            var url = "{{ route('cart.customer.customerCartStore') }}";

            $.ajax({
                type: "POST",
                dataType: 'json',
                data: {
                    product_id: product_id,
                    qty: quantity,
                    color_id: color_id,
                    size_id: size_id,
                    drop_selling_price: drop_selling_price,
                    _token: "{{ csrf_token() }}"
                },
                url: url,
                success: function(res) {

                    if (res.status == true) {
                        if (res.type == 'success') {
                            success_msg('' + res.message);
                            getAddToCartData();
                        } else if (res.type == 'increase') {
                            success_msg('' + res.message);
                            getAddToCartData();
                        } else {
                            error_msg('' + res.message);
                        }
                    } else {
                        if (res.errors && Object.keys(res.errors).length > 0) {
                            Object.entries(res.errors).forEach(([field, messages]) => {
                                // Display field-specific error messages
                                if (field === 'color_id') {
                                    closest.find('.color_id_errors').text(messages[0]);
                                }
                                if (field === 'size_id') {
                                    closest.find('.size_id_errors').text(messages[0]);
                                }

                                // Optionally show all messages as general error notifications
                                messages.forEach(message => {
                                    error_msg(message);
                                });
                            });
                        } else {
                            error_msg('' + res.message);
                        }
                    }
                },
                error: function() {
                    console.log('something went wrong!');
                }
            })
        }

        $(document).ready(function() {
            getAddToCartData();
        })

        function getDiscountPrice(price, discount, discountType) {

            var finalPrice;

            if (!isNaN(discount) && discount > 0) {
                if (discountType == 1) {
                    finalPrice = price - (price * discount) / 100;
                } else {
                    finalPrice = price - discount;
                }
            } else {
                finalPrice = price;
            }

            return finalPrice;
        }

        function getAddToCartData() {
            $.ajax({
                type: "GET",
                dataType: "json",
                url: "{{ route('cart.customer.customerCartData') }}",

                success: function(res) {
                    let subtotal = 0;
                    let html = "";

                    if (Array.isArray(res) && res.length > 0) {

                        res.forEach(item => {
                            const product = item.product;

                            // Safe price conversion
                            const price = Number(product.price) || 0;
                            const qty = Number(item.qty) || 1;

                            // subtotal calculation (price × quantity)
                            const totalForItem = price * qty;
                            subtotal += totalForItem;

                            html += `
                        <div class="item">
                            <div class="image">
                                <a href="#">
                                    <button><img src="${product.image}" alt="" /></button>
                                </a>
                            </div>

                            <div class="details">
                                <h3 class="name">
                                    ${product.name.length > 20 ? product.name.substring(0, 20) + "..." : product.name}
                                </h3>
                                <p class="price">${qty} x ${price} Tk.</p>
                            </div>

                            <span class="action" onclick="destroyCartItem(${item.id})">
                                <i class="fa fa-close"></i>
                            </span>
                        </div>
                    `;
                        });
                    }

                    // Insert HTML
                    $(".addToCartProducts").html(html);

                    // Subtotal update
                    $(".addTotalCartItemSection .cart-total .price").text(subtotal.toFixed(2));

                    // Total item count
                    $(".items-cart-inner .basket-item-count .count").text(res.length);
                },

                error: function() {
                    console.log("Something went wrong!");
                }
            });
        }


        function destroyCartItem(cart_id) {
            if (cart_id) {
                var url = "{{ route('cart.customer.customerCartDestroy', ['cart_id' => ':cart_id']) }}";
                url = url.replace(':cart_id', cart_id);

                $.ajax({
                    type: "GET",
                    dataType: 'json',
                    url: url,
                    success: function(res) {
                        if (res.status == true) {
                            success_msg('' + res.message);
                            getAddToCartData();
                        } else {
                            error_msg('' + res.message);
                        }
                    },
                    error: function() {
                        console.log('Something went wrong!');
                    }
                });
            }
        }


        function addToWishlist(product_id) {
            $.ajax({
                type: "POST",
                dataType: 'json',
                url: "{{ url('/add_to_wishlist/') }}/" + product_id,
                success: function(data) {
                    //  start message
                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000
                    })

                    if ($.isEmptyObject(data.error)) {
                        Toast.fire({
                            type: 'success',
                            title: data.success
                        })
                    } else {
                        Toast.fire({
                            type: 'error',
                            title: data.error
                        })
                    }
                    //  end message
                }
            })
        }


        function categoryMobile() {
            $(".mobile-header .nav-sidebar").toggleClass("active");
        }

        $("#owl-main").owlCarousel({
            items: 1,
            loop: true,
            autoplay: true,
            autoplayTimeout: 3000,
            autoplayHoverPause: true,
            nav: false,
            dots: false,
        });

        $('.new_productsTab').each(function() {
            var owlhotone = $(this);
            owlhotone.owlCarousel({
                loop: true,
                autoplay: true,
                items: 2,
                dots: false,
                navigation: false,
                pagination: false,
                navigationText: ["", ""],
                responsive: {
                    0: {
                        items: 2
                    },
                    350: {
                        items: 2
                    },
                    380: {
                        items: 2
                    },
                    450: {
                        items: 2
                    },
                    480: {
                        items: 2
                    },
                    556: {
                        items: 3
                    },
                    650: {
                        items: 3
                    },
                    768: {
                        items: 4
                    },
                    1000: {
                        items: 6
                    }
                }
            });
        });

        $('.special_offer_carousel').each(function() {
            var offerone = $(this);
            offerone.owlCarousel({
                loop: true,
                autoplay: true,
                items: 2,
                dots: false,
                navigation: false,
                pagination: false,
                navigationText: ["", ""],
                responsive: {
                    0: {
                        items: 2
                    },
                    350: {
                        items: 2
                    },
                    380: {
                        items: 2
                    },
                    450: {
                        items: 2
                    },
                    480: {
                        items: 2
                    },
                    556: {
                        items: 3
                    },
                    650: {
                        items: 3
                    },
                    768: {
                        items: 4
                    },
                    1000: {
                        items: 6
                    }
                }
            });
        });

        $('.special_deals_err').each(function() {
            var deals = $(this);
            deals.owlCarousel({
                loop: true,
                autoplay: true,
                items: 2,
                dots: false,
                navigation: false,
                pagination: false,
                navigationText: ["", ""],
                responsive: {
                    0: {
                        items: 2
                    },
                    350: {
                        items: 2
                    },
                    380: {
                        items: 2
                    },
                    450: {
                        items: 2
                    },
                    480: {
                        items: 2
                    },
                    556: {
                        items: 3
                    },
                    650: {
                        items: 3
                    },
                    768: {
                        items: 4
                    },
                    1000: {
                        items: 6
                    }
                }
            });
        });

        $('.featuredProducts').each(function() {
            var deals = $(this);
            deals.owlCarousel({
                loop: true,
                autoplay: true,
                items: 2,
                dots: false,
                navigation: false,
                pagination: false,
                navigationText: ["", ""],
                responsive: {
                    0: {
                        items: 2
                    },
                    350: {
                        items: 2
                    },
                    380: {
                        items: 2
                    },
                    450: {
                        items: 2
                    },
                    480: {
                        items: 2
                    },
                    556: {
                        items: 3
                    },
                    650: {
                        items: 3
                    },
                    768: {
                        items: 4
                    },
                    1000: {
                        items: 6
                    }
                }
            });
        });

        $('.categoryProducts').each(function() {
            var catProducts = $(this);
            catProducts.owlCarousel({
                loop: true,
                autoplay: true,
                items: 2,
                dots: false,
                navigation: false,
                pagination: false,
                navigationText: ["", ""],
                responsive: {
                    0: {
                        items: 2
                    },
                    350: {
                        items: 2
                    },
                    380: {
                        items: 2
                    },
                    450: {
                        items: 2
                    },
                    480: {
                        items: 2
                    },
                    556: {
                        items: 3
                    },
                    650: {
                        items: 3
                    },
                    768: {
                        items: 4
                    },
                    1000: {
                        items: 6
                    }
                }
            });
        });

        $(document).ready(function() {
            function updatePriceAndStock() {
                let product_id = $('#product_id').val(); // hidden input with product ID
                let color_id = $('#color').val();
                let size_id = $('#size').val();

                if (!product_id) return;

                $.ajax({
                    url: "{{ route('get.product.price') }}",
                    type: "GET",
                    data: {
                        product_id: product_id,
                        color_id: color_id,
                        size_id: size_id
                    },
                    success: function(response) {
                        // Response contains: price, original_price, discount
                        let price = response.price;
                        let original_price = response.original_price;
                        let discount = response.discount;

                        if (discount && discount > 0) {
                            $('#pprice').html(
                                `<strong>&#2547; ${price}</strong> 
                        <del style="color: #989191;">&#2547; ${original_price}</del>`
                            );
                        } else {
                            $('#pprice').html(`<span>&#2547; ${price}</span>`);
                        }
                    },
                    error: function(xhr) {
                        console.error(xhr.responseText);
                        $('#pprice').html(`<span style="color:red;">Error!</span>`);
                    }
                });
            }

            // Trigger update on color/size change
            $('#color, #size').on('change', updatePriceAndStock);


        });

        function showProfitt() {
            const sellingPrice = parseFloat(document.getElementById('selling_price').value) || 0;
            const defaultPrice = parseFloat(document.getElementById('product-dropshipper-price').value) || 0;
            const profit = sellingPrice - defaultPrice;
            if (!isNaN(profit)) {
                $("#profit_display").text('Profit: ৳' + profit.toFixed(2));
            }
        }

        $(document).ready(function() {
            // SEO Fix: Ensure all links are crawlable (especially Lightbox navigation)
            const fixLinks = () => {
                $('a.lb-close, a.lb-prev, a.lb-next, a.nav-close').each(function() {
                    if (!$(this).attr('href') || $(this).attr('href') === 'javascript:void(0)') {
                        $(this).attr('href', '#');
                        $(this).attr('rel', 'nofollow');
                        // Prevent jumping while being crawlable
                        $(this).on('click', function(e) {
                            e.preventDefault();
                        });
                    }
                });
            };
            
            // Run on load and on any click that might open a dynamic element
            fixLinks();
            $(document).on('click', '[data-lightbox], .header-user, .profile-nav-btn', function() {
                setTimeout(fixLinks, 500);
            });
        });
    </script>





    {{-- ── Live Chat (Tawk.to) — Admin Panel থেকে ON/OFF করা যাবে ── --}}
    @php
        try {
            $livechatSetting = \App\Models\Setting::first();
            $livechatEnabled  = $livechatSetting->livechat_enabled ?? 1;
            $tawkPropertyId   = $livechatSetting->tawkto_property_id ?? '67769592af5bfec1dbe5cfa4';
            $tawkWidgetId     = $livechatSetting->tawkto_widget_id ?? '1j8nukq3o';
        } catch (\Exception $e) {
            $livechatEnabled = 1;
            $tawkPropertyId  = '67769592af5bfec1dbe5cfa4';
            $tawkWidgetId    = '1j8nukq3o';
        }
    @endphp

    @if($livechatEnabled)
    <!--Start of Tawk.to Script-->
    <script type="text/javascript">
        var Tawk_API = Tawk_API || {}, Tawk_LoadStart = new Date();
        (function(){
            var s1 = document.createElement("script"),
                s0 = document.getElementsByTagName("script")[0];
            s1.async = true;
            s1.src = 'https://embed.tawk.to/{{ $tawkPropertyId }}/{{ $tawkWidgetId }}';
            s1.charset = 'UTF-8';
            s1.setAttribute('crossorigin', '*');
            s0.parentNode.insertBefore(s1, s0);
        })();
    </script>
    <!--End of Tawk.to Script-->
    @endif

    {{-- ── Mobile Bottom Navigation (App-like) ──────────────────────── --}}
    <style>
    .mobile-bottom-nav {
        display: none;
        position: fixed; bottom: 0; left: 0; right: 0; z-index: 1001;
        background: #fff;
        border-top: 1px solid #f0f0f0;
        padding: 6px 0 calc(6px + env(safe-area-inset-bottom, 0px));
        box-shadow: 0 -4px 24px rgba(0,0,0,.10);
    }
    .mobile-bottom-nav .nav-items {
        display: grid;
        grid-template-columns: repeat(5, 1fr);
        max-width: 500px;
        margin: 0 auto;
    }
    .mobile-bottom-nav .nav-item {
        display: flex; flex-direction: column;
        align-items: center; gap: 2px;
        text-decoration: none;
        color: #999;
        font-size:13px; font-weight: 700;
        padding: 4px 0;
        transition: color .15s, transform .15s;
        font-family: 'Hind Siliguri', sans-serif;
        position: relative;
    }
    .mobile-bottom-nav .nav-item:active { transform: scale(.9); }
    .mobile-bottom-nav .nav-item .ni {
        font-size: 22px; line-height: 1;
        transition: transform .2s;
    }
    .mobile-bottom-nav .nav-item.active {
        color: #e8001d;
    }
    .mobile-bottom-nav .nav-item.active .ni {
        transform: translateY(-2px) scale(1.12);
    }
    /* Active indicator dot */
    .mobile-bottom-nav .nav-item.active::after {
        content: '';
        position: absolute;
        bottom: 1px;
        left: 50%; transform: translateX(-50%);
        width: 4px; height: 4px;
        border-radius: 50%;
        background: #e8001d;
    }
    .mobile-bottom-nav .nav-item .cart-badge {
        position: absolute; top: 2px; left: 50%;
        transform: translateX(2px);
        background: #e8001d; color: #fff;
        font-size:13px; font-weight: 800;
        min-width: 16px; height: 16px;
        border-radius: 10px;
        display: flex; align-items: center; justify-content: center;
        padding: 0 4px;
        line-height: 1;
        border: 1.5px solid #fff;
    }
    @media (max-width: 768px) {
        .mobile-bottom-nav { display: block; }
        body { 
            padding-bottom: calc(68px + env(safe-area-inset-bottom, 0px)) !important;
            padding-top: 54px !important;
        }
    }

    /* Bottom Sheet Category Drawer */
    .mobile-sheet-backdrop {
        position: fixed;
        top: 0; left: 0; right: 0; bottom: 0;
        background: rgba(0,0,0,0.6);
        z-index: 2000;
        opacity: 0;
        pointer-events: none;
        transition: opacity 0.3s ease;
    }
    .mobile-sheet-backdrop.show {
        opacity: 1;
        pointer-events: auto;
    }
    .mobile-category-sheet {
        position: fixed;
        bottom: 0; left: 0; right: 0;
        background: #fff;
        border-radius: 24px 24px 0 0;
        z-index: 2001;
        max-height: 80vh;
        display: flex;
        flex-direction: column;
        box-shadow: 0 -10px 30px rgba(0,0,0,0.15);
        transform: translateY(100%);
        visibility: hidden;
        transition: transform 0.3s cubic-bezier(0.16, 1, 0.3, 1), visibility 0.3s;
        font-family: 'Hind Siliguri', sans-serif;
    }
    .mobile-category-sheet.show {
        transform: translateY(0);
        visibility: visible;
    }
    .sheet-header {
        padding: 12px 18px 8px;
        border-bottom: 1px solid #f0f0f0;
        display: flex;
        flex-direction: column;
        align-items: center;
        background: #fff;
        border-radius: 24px 24px 0 0;
        width: 100%;
        box-sizing: border-box;
    }
    .sheet-handle {
        width: 40px;
        height: 4px;
        background: #ddd;
        border-radius: 2px;
        margin-bottom: 12px;
    }
    .sheet-title-row {
        width: 100%;
        display: flex;
        align-items: center;
        position: relative;
        min-height: 36px;
        box-sizing: border-box;
    }
    .sheet-title {
        font-size: 18px;
        font-weight: 700;
        margin: 0;
        color: #111;
        flex: 1;
    }
    .sheet-back-btn {
        background: transparent;
        border: none;
        font-size: 16px;
        color: #333;
        margin-right: 12px;
        cursor: pointer;
        padding: 6px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .sheet-close-btn {
        background: #f5f5f5;
        border: none;
        width: 32px;
        height: 32px;
        border-radius: 50%;
        font-size: 20px;
        line-height: 1;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #666;
        margin-left: auto;
    }
    .sheet-body {
        flex: 1;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        box-sizing: border-box;
    }

    /* Screen 1: Grid View Styles */
    .category-grid-view {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 16px 8px;
        padding: 18px;
        overflow-y: auto;
        max-height: calc(80vh - 80px);
        box-sizing: border-box;
    }
    .cat-grid-item {
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
        cursor: pointer;
    }
    .cat-grid-img-wrap {
        width: 60px;
        height: 60px;
        border-radius: 12px;
        background: #f8f9fa;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 8px;
        overflow: hidden;
        border: 1px solid #f1f3f5;
    }
    .cat-grid-img-wrap img {
        width: 44px;
        height: 44px;
        object-fit: contain;
    }
    .cat-grid-name {
        font-size: 13px;
        font-weight: 700;
        color: #222;
        line-height: 1.2;
        margin-bottom: 3px;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .cat-grid-count {
        font-size: 11px;
        color: #888;
        font-weight: 500;
    }

    /* Screen 2: Split View Styles */
    .category-split-view {
        display: flex;
        flex: 1;
        height: calc(80vh - 80px);
        overflow: hidden;
        box-sizing: border-box;
    }
    .split-left-col {
        width: 45%;
        border-right: 1px solid #eee;
        overflow-y: auto;
        background: #f8f9fa;
        box-sizing: border-box;
    }
    .split-right-col {
        width: 55%;
        overflow-y: auto;
        background: #fff;
        box-sizing: border-box;
    }
    .split-cat-item {
        display: flex;
        align-items: center;
        padding: 12px 10px;
        cursor: pointer;
        border-bottom: 1px solid #f1f3f5;
        border-left: 3px solid transparent;
        transition: all 0.2s;
        position: relative;
        box-sizing: border-box;
    }
    .split-cat-item.active {
        background: #fff;
        border-left-color: #25d366;
    }
    .split-cat-img-wrap {
        width: 32px;
        height: 32px;
        margin-right: 8px;
        flex-shrink: 0;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .split-cat-img-wrap img {
        width: 28px;
        height: 28px;
        object-fit: contain;
    }
    .split-cat-info {
        flex: 1;
        min-width: 0;
        text-align: left;
    }
    .split-cat-name {
        font-size: 13px;
        font-weight: 700;
        color: #333;
        display: block;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .split-cat-count {
        font-size: 11px;
        color: #888;
        display: block;
    }
    .split-cat-arrow {
        font-size: 11px;
        color: #ccc;
        margin-left: 4px;
    }
    .split-cat-item.active .split-cat-arrow {
        color: #25d366;
    }

    /* Subcategories Right Column panel */
    .subcategory-panel {
        padding: 10px;
        display: flex;
        flex-direction: column;
        gap: 6px;
        box-sizing: border-box;
    }
    .subcat-list-item {
        display: flex;
        align-items: center;
        padding: 10px;
        background: #f8f9fa;
        border-radius: 12px;
        text-decoration: none !important;
        transition: background 0.15s;
        box-sizing: border-box;
    }
    .subcat-list-item:active {
        background: #f1f3f5;
    }
    .subcat-list-item.view-all-item {
        background: #eafbf1;
        border: 1px solid #d3f4e1;
    }
    .subcat-list-img-wrap {
        width: 36px;
        height: 36px;
        border-radius: 8px;
        background: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 10px;
        flex-shrink: 0;
        overflow: hidden;
        border: 1px solid #eee;
    }
    .subcat-list-img-wrap img {
        width: 28px;
        height: 28px;
        object-fit: contain;
    }
    .subcat-list-info {
        flex: 1;
        min-width: 0;
        text-align: left;
    }
    .subcat-list-name {
        font-size: 13px;
        font-weight: 700;
        color: #333;
        display: block;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .subcat-list-count {
        font-size: 11px;
        color: #888;
        display: block;
    }
    .subcat-arrow {
        font-size: 12px;
        color: #aaa;
        margin-left: 6px;
    }
    .no-subcategories {
        text-align: center;
        color: #888;
        padding: 40px 10px;
        font-size: 14px;
        font-weight: 500;
    }
    }
    </style>

    <nav class="mobile-bottom-nav" role="navigation" aria-label="Mobile navigation">
        <div class="nav-items">
            <a href="{{ route('frontend.home') }}" class="nav-item {{ request()->routeIs('frontend.home') ? 'active' : '' }}">
                <span class="ni">🏠</span><span>হোম</span>
            </a>
            <a href="javascript:void(0)" class="nav-item" id="mobile-category-trigger">
                <span class="ni">📁</span><span>ক্যাটাগরি</span>
            </a>
            <a href="{{ route('product.list') }}" class="nav-item {{ request()->routeIs('product.list') ? 'active' : '' }}">
                <span class="ni">🛍️</span><span>পণ্য</span>
            </a>
            <a href="{{ route('show.cart') }}" class="nav-item {{ request()->routeIs('show.cart') ? 'active' : '' }}" style="position:relative">
                <span class="ni">🛒</span>
                @php $cartCount = \Cart::count(); @endphp
                @if($cartCount > 0)
                    <span class="cart-badge">{{ $cartCount > 99 ? '99+' : $cartCount }}</span>
                @endif
                <span>কার্ট</span>
            </a>
            @auth
            <a href="{{ auth()->user()->usertype === 'customer' ? route('dashboard') : route('seller.dashboard') }}"
               class="nav-item {{ request()->routeIs('dashboard') || request()->routeIs('seller.dashboard') ? 'active' : '' }}">
                <span class="ni">👤</span><span>অ্যাকাউন্ট</span>
            </a>
            @else
            <a href="{{ route('customer.login') }}" class="nav-item {{ request()->routeIs('customer.login') ? 'active' : '' }}">
                <span class="ni">👤</span><span>লগইন</span>
            </a>
            @endauth
        </div>
    </nav>

    {{-- ── Mobile Category Bottom Sheet Drawer ── --}}
    <div id="mobile-category-sheet-backdrop" class="mobile-sheet-backdrop"></div>
    <div id="mobile-category-sheet" class="mobile-category-sheet">
        <div class="sheet-header">
            <div class="sheet-handle"></div>
            <div class="sheet-title-row">
                <!-- Standard Header -->
                <h3 class="sheet-title standard-header">Categories</h3>
                
                <!-- Split View Header -->
                <button type="button" class="sheet-back-btn split-header" id="mobile-category-back" style="display: none; border: none; background: transparent;">
                    <i class="fa fa-chevron-left"></i>
                </button>
                <h3 class="sheet-title split-header" id="mobile-selected-category-title" style="display: none;">Categories</h3>
                
                <button type="button" class="sheet-close-btn" id="mobile-category-close">&times;</button>
            </div>
        </div>
        <div class="sheet-body">
            @php
                $sheetCategories = $globalCategories;
            @endphp
            <!-- Screen 1: Grid View -->
            <div class="category-grid-view" id="category-grid-view">
                @foreach($sheetCategories as $cat)
                    <div class="cat-grid-item" data-cat-id="{{ $cat->id }}" data-cat-name="{{ $cat->name }}" data-has-sub="{{ $cat->subcategories->count() > 0 ? 'true' : 'false' }}">
                        <div class="cat-grid-img-wrap">
                            <img src="{{ !empty($cat->image) ? url('upload/category_images/' . $cat->image) : url('frontend/no-image-icon.jpg') }}" alt="{{ $cat->name }}">
                        </div>
                        <span class="cat-grid-name">{{ $cat->name }}</span>
                        <span class="cat-grid-count">{{ $cat->products_count }} Products</span>
                    </div>
                @endforeach
            </div>

            <!-- Screen 2: Split View -->
            <div class="category-split-view" id="category-split-view" style="display: none;">
                <!-- Left Column: Categories List -->
                <div class="split-left-col">
                    @foreach($sheetCategories as $cat)
                        <div class="split-cat-item" id="split-cat-{{ $cat->id }}" data-cat-id="{{ $cat->id }}" data-cat-name="{{ $cat->name }}" data-has-sub="{{ $cat->subcategories->count() > 0 ? 'true' : 'false' }}">
                            <div class="split-cat-img-wrap">
                                <img src="{{ !empty($cat->image) ? url('upload/category_images/' . $cat->image) : url('frontend/no-image-icon.jpg') }}" alt="{{ $cat->name }}">
                            </div>
                            <div class="split-cat-info">
                                <span class="split-cat-name">{{ $cat->name }}</span>
                                <span class="split-cat-count">{{ $cat->products_count }} Products</span>
                            </div>
                            <i class="fa fa-chevron-right split-cat-arrow"></i>
                        </div>
                    @endforeach
                </div>

                <!-- Right Column: Subcategories List -->
                <div class="split-right-col">
                    @foreach($sheetCategories as $cat)
                        <div class="subcategory-panel" id="subcategory-panel-{{ $cat->id }}" style="display: none;">
                            <!-- View All Products link -->
                            <a href="{{ route('category.wise.product', $cat->id) }}" class="subcat-list-item view-all-item">
                                <div class="subcat-list-info">
                                    <span class="subcat-list-name" style="color: #25d366; font-weight: 700;">View all {{ $cat->name }}</span>
                                    <span class="subcat-list-count">{{ $cat->products_count }} Products</span>
                                </div>
                                <i class="fa fa-chevron-right subcat-arrow" style="color: #25d366;"></i>
                            </a>
                            
                            @forelse($cat->subcategories as $subcat)
                                <a href="{{ route('subcategory.wise.product', $subcat->id) }}" class="subcat-list-item">
                                    <div class="subcat-list-img-wrap">
                                        <img src="{{ !empty($cat->image) ? url('upload/category_images/' . $cat->image) : url('frontend/no-image-icon.jpg') }}" alt="{{ $subcat->name }}">
                                    </div>
                                    <div class="subcat-list-info">
                                        <span class="subcat-list-name">{{ $subcat->name }}</span>
                                        <span class="subcat-list-count">{{ $subcat->products_count }} Products</span>
                                    </div>
                                    <i class="fa fa-chevron-right subcat-arrow"></i>
                                </a>
                            @empty
                                <div class="no-subcategories">No subcategories available</div>
                            @endforelse
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <script>
    // PWA Install prompt (Android Chrome)
    let deferredPrompt;
    window.addEventListener('beforeinstallprompt', (e) => {
        e.preventDefault();
        deferredPrompt = e;
        const banner = document.getElementById('pwa-install-banner');
        if (banner) banner.style.display = 'flex';
    });
    document.addEventListener('DOMContentLoaded', function() {
        const installBtn = document.getElementById('pwa-install-btn');
        const dismissBtn = document.getElementById('pwa-dismiss-btn');
        if (installBtn) {
            installBtn.addEventListener('click', async () => {
                if (deferredPrompt) {
                    deferredPrompt.prompt();
                    await deferredPrompt.userChoice;
                    deferredPrompt = null;
                }
                document.getElementById('pwa-install-banner').style.display = 'none';
            });
        }
        if (dismissBtn) {
            dismissBtn.addEventListener('click', () => {
                document.getElementById('pwa-install-banner').style.display = 'none';
                sessionStorage.setItem('pwa_dismissed', '1');
            });
        }
        // Don't show if dismissed
        if (sessionStorage.getItem('pwa_dismissed') === '1') {
            const b = document.getElementById('pwa-install-banner');
            if (b) b.remove();
        }
    });
    </script>

    <style>
    #pwa-install-banner {
        display: none; position: fixed; bottom: 72px; left: 12px; right: 12px;
        z-index: 998; background: #fff; border-radius: 14px;
        box-shadow: 0 4px 24px rgba(0,0,0,.18); padding: 14px 16px;
        align-items: center; gap: 12px;
        border: 1px solid #e0e3ff;
    }
    #pwa-install-banner .pwa-icon { font-size: 32px; flex-shrink: 0; }
    #pwa-install-banner .pwa-text { flex: 1; }
    #pwa-install-banner .pwa-text strong { font-size: 13px; color: #111; display: block; }
    #pwa-install-banner .pwa-text span   { font-size:13px; color: #666; }
    #pwa-install-banner .pwa-btns { display: flex; gap: 6px; flex-shrink: 0; }
    #pwa-install-banner .pwa-install { background: #1e25fa; color: #fff; border: none; border-radius: 20px; padding: 7px 14px; font-size:14px; font-weight: 700; cursor: pointer; }
    #pwa-install-banner .pwa-dismiss { background: transparent; border: 1px solid #ddd; color: #888; border-radius: 20px; padding: 7px 10px; font-size:14px; cursor: pointer; }
    @media (min-width: 769px) { #pwa-install-banner { display: none !important; } }
    </style>

    <div id="pwa-install-banner">
        <div class="pwa-icon">📱</div>
        <div class="pwa-text">
            <strong>U Super Shop App ইনস্টল করুন</strong>
            <span>হোম স্ক্রিনে যোগ করুন — দ্রুত অ্যাক্সেস পান</span>
        </div>
        <div class="pwa-btns">
            <button class="pwa-install" id="pwa-install-btn">ইনস্টল</button>
            <button class="pwa-dismiss" id="pwa-dismiss-btn">✕</button>
        </div>
    </div>

    @stack('custom_script')

    {{-- ── WhatsApp Float Button ─────────────────────────────── --}}
    @php
        $waEnabled = $seoSettings->whatsapp_float_enabled ?? 1;
    @endphp
    @if($waEnabled)
    <a href="https://wa.me/8801816622128?text=Hello%20U%20Super%20Shop%2C%20I%20need%20help."
       target="_blank" rel="noopener"
       id="wa-float-btn"
       title="WhatsApp-এ Chat করুন"
       style="position:fixed;bottom:140px;right:16px;z-index:1000;width:52px;height:52px;background:#25d366;border-radius:50%;display:flex;align-items:center;justify-content:center;box-shadow:0 4px 16px rgba(37,211,102,.45);text-decoration:none;transition:transform .2s;"
       onmouseover="this.style.transform='scale(1.1)'"
       onmouseout="this.style.transform='scale(1)'">
        <svg width="28" height="28" viewBox="0 0 24 24" fill="white" xmlns="http://www.w3.org/2000/svg">
            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
        </svg>
    </a>
    @endif


    <script>
        $(document).ready(function() {
            // Category drawer open/close
            $('#mobile-category-trigger').click(function(e) {
                e.preventDefault();
                $('#mobile-category-sheet-backdrop').addClass('show');
                $('#mobile-category-sheet').addClass('show');
                $('body').css('overflow', 'hidden'); // Prevent background scrolling
                showGridView();
            });

            function showGridView() {
                $('.standard-header').show();
                $('.split-header').hide();
                $('#category-grid-view').show();
                $('#category-split-view').hide();
            }

            function showSplitView(catId, catName) {
                $('.standard-header').hide();
                $('.split-header').show();
                $('#mobile-selected-category-title').text(catName);
                $('#category-grid-view').hide();
                $('#category-split-view').css('display', 'flex');
                
                // Activate left column item
                $('.split-cat-item').removeClass('active');
                $('#split-cat-' + catId).addClass('active');
                
                // Show right column subcategory list
                $('.subcategory-panel').hide();
                $('#subcategory-panel-' + catId).show();
            }

            // Click category on Grid View
            $('.cat-grid-item').click(function() {
                let catId = $(this).attr('data-cat-id');
                let catName = $(this).attr('data-cat-name');
                let hasSub = $(this).attr('data-has-sub') === 'true';
                if (hasSub) {
                    showSplitView(catId, catName);
                } else {
                    window.location.href = '/category-wise-product/' + catId;
                }
            });

            // Click category on Left Column in Split View
            $('.split-cat-item').click(function() {
                let catId = $(this).attr('data-cat-id');
                let catName = $(this).attr('data-cat-name');
                let hasSub = $(this).attr('data-has-sub') === 'true';
                if (hasSub) {
                    showSplitView(catId, catName);
                } else {
                    window.location.href = '/category-wise-product/' + catId;
                }
            });

            // Back button click (return to grid view)
            $('#mobile-category-back').click(function() {
                showGridView();
            });

            function closeCategorySheet() {
                $('#mobile-category-sheet-backdrop').removeClass('show');
                $('#mobile-category-sheet').removeClass('show');
                $('body').css('overflow', '');
            }

            $('#mobile-category-close, #mobile-category-sheet-backdrop').click(function() {
                closeCategorySheet();
            });
        });
    </script>

</body>

</html>
