<style>
    .profile-nav-btn {
        position: relative;
    }

    ul.profile-nav-items {
        position: absolute;
        width: 200px;
        background: #fff;
        right: 10px;
        bottom: 50px;
        border: 1px solid #ddd;
        padding: 5px;
        border-radius: 4px;
        display: none;
    }

    ul.profile-nav-items li {
        padding: 10px 5px;
        border: none;
        border-radius: 2px;
        transition: 0.3s;
    }

    ul.profile-nav-items li:hover {
        background: #0824ac1c;
    }

    ul.profile-nav-items li a {
        color: #333;
        font-weight: 600;
        font-size: 14px;
    }

    ul.profile-nav-items.show {
        display: block;
    }

    .footer .footer-bottom .module-body ul li p {
        margin: 0px !important;
    }

    .footer .footer-bottom .module-body ul li {
        margin: auto;
        vertical-align: middle;
        display: flex;
    }

    .footer .footer-bottom .module-body ul li .media-body {
        margin: auto;
        margin-left: 0px;
    }

    .footer .footer-bottom .module-body ul li {
        margin-bottom: 5px;
    }

    .footer .footer-bottom .module-body ul li:last-child {
        margin-bottom: 0px;
    }
    ul.payment-methods {
        margin: auto;
        display: flex;
    }
    ul.payment-methods li {
        margin: 0px !important;
        padding: 0px !important;
        margin-right: 4px !important;
    }
    ul.payment-methods li a {
        height: 36px;
        width: 55px;
    }


    @media (max-width: 576px){
        footer#footer {
            margin-bottom: 40px;
        }
        ul.payment-methods li a {
            height: 30px;
            width: 45px;
        }
        ul.payment-methods li a img {
            width: 45px !important;
            height: 30px !important;
        }
    }

</style>
@php
    $footercontent = Helper::getfootercontacts();
@endphp

<div id="mobile-nav">
    <div class="mobile-footer-nav"
        style="display: flex; justify-content: space-around; background-color:#0824ac; padding:0;margin:0 !important;height:50px;">


        <a href="{{ route('product.list') }}"
            style="color: white; text-align: center; font-size: 10px; vertical-align: middle; margin: auto;">
            <img src="{{ asset('frontend/icon/category-svgrepo-com.svg') }}"
                style="width: 23px; height: 23px;filter: invert(1);" alt="Shop Icon">
            <br>Shop
        </a>


        <a href="javascript::void(0)" data-toggle="modal" data-target="#exampleModal"
            style="color: white; text-align: center; font-size: 10px; vertical-align: middle; margin: auto;">
            <img src="{{ asset('frontend/icon/location-target-svgrepo-com.svg') }}"
                style="width: 23px; height: 23px;filter: invert(1);" alt="Location Icon">
            <br>Order Track
        </a>

        <a href="{{ url('./') }}"
            style="color: white; text-align: center; font-size: 10px; vertical-align: middle; margin: auto;">
            <img src="{{ asset('frontend/icon/home-1-svgrepo-com.svg') }}"
                style="width: 25px; height: 25px;filter: invert(1);" alt="Home Icon">
            <br>Home
        </a>

        <a href="{{ route('show.cart') }}"
            style="color: white; text-align: center; font-size: 10px; vertical-align: middle; margin: auto;">
            <img src="{{ asset('frontend/icon/cart-large-svgrepo-com.svg') }}"
                style="width: 25px; height: 25px;filter: invert(1);" alt="Cart Icon">
            <br>My Cart
        </a>
        {{-- <a href="{{ url('/customer/dashboard') }}" style="color: white; text-align: center; font-size: 12px;">
            <img src="{{ asset('frontend/icon/profile-circle-svgrepo-com.svg') }}"
                style="width: 25px; height: 25px;filter: invert(1);" alt="">
            <br>Profile
        </a> --}}
        <a href="javascript::void(0)" class="profile-nav-btn"
            style="color: white; text-align: center; font-size: 12px;">
            @auth
                <img src="{{ asset('frontend/icon/profile-circle-svgrepo-com.svg') }}"
                    style="width: 25px; height: 25px;filter: invert(1);" alt="">
                <br>Profile
            @else
                <img src="{{ asset('frontend/icon/profile-circle-svgrepo-com.svg') }}"
                    style="width: 25px; height: 25px;filter: invert(1);" alt="">
                <br>Me
            @endauth

        </a>
        <ul class="profile-nav-items">
            <li>
                @auth
                    @php
                        $auth_user = auth()->user();
                    @endphp

                    @if ($auth_user->usertype === 'customer')
                        <a href="{{ route('dashboard') }}" class="english_lang"><img
                                src="{{ asset('frontend/icon/profile-circle-svgrepo-com.svg') }}"
                                style="width: 22px; height: 22px;" alt=""> My Account</a>
                        <a href="{{ route('dashboard') }}" class="bangla_lang"><img
                                src="{{ asset('frontend/icon/profile-circle-svgrepo-com.svg') }}"
                                style="width: 22px; height: 22px;" alt=""> আমার একাউন্ট</a>
                    @endif
                    @if ($auth_user->usertype === 'vendor')
                        <a href="{{ route('seller.dashboard') }}" class="english_lang"><img
                                src="{{ asset('frontend/icon/profile-circle-svgrepo-com.svg') }}"
                                style="width: 22px; height: 22px;" alt=""> My Account</a>
                        <a href="{{ route('seller.dashboard') }}" class="bangla_lang"><img
                                src="{{ asset('frontend/icon/profile-circle-svgrepo-com.svg') }}"
                                style="width: 22px; height: 22px;" alt=""> আমার একাউন্ট</a>
                    @endif
                    @if ($auth_user->usertype === 'seller')
                        <a href="{{ route('seller.dashboard') }}" class="english_lang"><img
                                src="{{ asset('frontend/icon/profile-circle-svgrepo-com.svg') }}"
                                style="width: 22px; height: 22px;" alt=""> My Account</a>
                        <a href="{{ route('seller.dashboard') }}" class="bangla_lang"><img
                                src="{{ asset('frontend/icon/profile-circle-svgrepo-com.svg') }}"
                                style="width: 22px; height: 22px;" alt=""> আমার একাউন্ট</a>
                    @endif
                    @if ($auth_user->usertype === 'dropshipper')
                        <a href="{{ route('seller.dashboard') }}" class="english_lang"><img
                                src="{{ asset('frontend/icon/profile-circle-svgrepo-com.svg') }}"
                                style="width: 22px; height: 22px;" alt=""> My Account</a>
                        <a href="{{ route('seller.dashboard') }}" class="bangla_lang"><img
                                src="{{ asset('frontend/icon/profile-circle-svgrepo-com.svg') }}"
                                style="width: 22px; height: 22px;" alt=""> আমার একাউন্ট</a>
                    @endif
                @else
                    <a class="english_lang" href="{{ route('customer.login') }}"><img
                            src="{{ asset('frontend/icon/profile-circle-svgrepo-com.svg') }}"
                            style="width: 22px; height: 22px;" alt=""> User Login</a>

                    <a class="bangla_lang" style="display:none;" href="{{ route('customer.login') }}"><img
                            src="{{ asset('frontend/icon/profile-circle-svgrepo-com.svg') }}"
                            style="width: 22px; height: 22px;" alt=""> লগইন</a>
                @endauth
            </li>
            @auth

            @else
                <li>
                    {{-- Customer signup removed — guests can order directly --}}
                    <a class="english_lang" href="{{ route('show.cart') }}"><img
                            src="{{ asset('frontend/icon/profile-circle-svgrepo-com.svg') }}"
                            style="width: 22px; height: 22px;" alt=""> Order Without Login</a>
                    <a class="bangla_lang" style="display:none;" href="{{ route('show.cart') }}"><img
                            src="{{ asset('frontend/icon/profile-circle-svgrepo-com.svg') }}"
                            style="width: 22px; height: 22px;" alt=""> লগইন ছাড়া অর্ডার</a>
                </li>
                <li>
                    <a class="english_lang" href="{{ route('seller.signup') }}"><img
                            src="{{ asset('frontend/icon/seller-in-shop-person-offer-sell-svgrepo-com.svg') }}"
                            style="width: 22px; height: 22px;" alt=""> Become a Seller</a>
    
                    <a class="bangla_lang" style="display:none;" href="{{ route('seller.signup') }}"><img
                            src="{{ asset('frontend/icon/seller-in-shop-person-offer-sell-svgrepo-com.svg') }}"
                            style="width: 22px; height: 22px;" alt=""> সেলার/ভেন্ডর</a>
                </li>
            @endauth
            <li>
                <a href="javascript::void(0);" class="dropdown-toggle english_lang" data-hover="dropdown"
                    data-toggle="dropdown"><img src="{{ asset('frontend/icon/language-svgrepo-com.svg') }}"
                        style="width: 22px; height: 22px;" alt=""> Change Language</a>

                <a href="javascript::void(0);" style="display: none;" class="dropdown-toggle bangla_lang"
                    data-hover="dropdown" data-toggle="dropdown"><img
                        src="{{ asset('frontend/icon/language-svgrepo-com.svg') }}" style="width: 22px; height: 22px;"
                        alt=""> ভাষা পরিবর্তন করুন</a>

                <ul class="dropdown-menu" style="margin-top: -50px; width: 190px; left: 4px;">
                    <li style="display:none" class="changeLng english" lang="english" style="padding: 2px 10px;">
                        English</li>
                    <li class="changeLng bangla" lang="bangla" style="padding: 2px 10px;"> বাংলা</li>
                </ul>
            </li>
            @auth
                {{-- <li>
                    <a class="english_lang" href="{{ route('logout') }}"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><img
                            src="{{ asset('frontend/icon/logout-2-svgrepo-com.svg') }}" style="width: 22px; height: 22px;"
                            alt=""> Logout</a>

                    <a class="bangla_lang" style="display:none" href="{{ route('logout') }}"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><img
                            src="{{ asset('frontend/icon/logout-2-svgrepo-com.svg') }}" style="width: 22px; height: 22px;"
                            alt=""> লগআউট</a>


                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </li> --}}
            @endauth
        </ul>



    </div>
</div>

<footer id="footer" class="footer color-bg">
    <div class="footer-bottom">
        <div class="container">
            <div class="row">
                <div class="col-xs-6 col-sm-6 col-md-3">
                    <div class="module-heading">
                        <h4 class="module-title">{{ __('app.contact_us') }}</h4>
                    </div>
                    <!-- /.module-heading -->

                    <div class="module-body">
                        <ul class="toggle-footer" style="">
                            <li class="media">
                                <div class="pull-left">
                                    <span class="icon fa-stack fa-lg">
                                        <i class="fa fa-map-marker fa-stack-1x fa-inverse"></i>
                                    </span>
                                </div>
                                <div class="media-body">
                                    <p>{{ $footercontent->address ?? 'Dhaka Bangladesh' }}</p>
                                </div>
                            </li>

                            <li class="media">
                                <div class="pull-left">
                                    <span class="icon fa-stack fa-lg">
                                        <i class="fa fa-mobile fa-stack-1x fa-inverse"></i>
                                    </span>
                                </div>
                                <div class="media-body">
                                    <p>{{ $footercontent->mobile ?? '' }}</p>
                                </div>
                            </li>

                            <li class="media">
                                <div class="pull-left">
                                    <span class="icon fa-stack fa-lg">
                                        <i class="fa fa-envelope fa-stack-1x fa-inverse"></i>
                                    </span>
                                </div>
                                <div class="media-body">
                                    <span><a href="mailto:{{ $footercontent->email ?? 'info@usupershop.com' }}">{{ $footercontent->email ?? 'info@usupershop.com' }}</a></span>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <!-- /.module-body -->
                </div>
                <!-- /.col -->

                <div class="col-xs-6 col-sm-6 col-md-3">
                    <div class="module-heading">
                        <h4 class="module-title">Customer Service</h4>
                    </div>
                    <!-- /.module-heading -->

                    <div class="module-body">
                        <ul class="list-unstyled">
                            <li class="first">
                                <a title="Your Account" href="{{ route('about.us') }}">About us</a>
                            </li>
                            <li>
                                <a href="{{ route('pricing.cards') }}" class="footer-pricing-link" title="Pricing Plans">Pricing Plans <span class="pricing-mini-badge">NEW</span></a>
                            </li>
                            <li>
                                <a href="{{ route('show.cart') }}" title="Contact us">My Cart</a>
                            </li>
                            <li><a href="{{ route('customer.checkout') }}" title="About us">Checkout</a></li>
                            @auth

                            @else
                                <li class="last">
                                    <a href="{{ route('seller.signup') }}" title="Where is my order?">Become a seller</a>
                                </li>
                            @endauth
                        </ul>
                    </div>
                    <!-- /.module-body -->
                </div>
                <!-- /.col -->

                <div class="col-xs-6 col-sm-6 col-md-3">
                    <div class="module-heading">
                        <h4 class="module-title">Our Valuable Policies</h4>
                    </div>
                    <!-- /.module-heading -->

                    <div class="module-body">
                        <ul class="list-unstyled">
                            <li class="first">
                                <a href="{{ route('terms.and.condition') }}" title="Terms abd Condition">{{ __('app.terms_conditions') }}</a>
                            </li>
                            <li><a href="{{ route('privacy.policy') }}" title="Privacy Policy">{{ __('app.privacy_policy') }}</a>
                            </li>
                            <li><a href="{{ route('return.policy') }}" title="Return Policy">{{ __('app.return_policy') }}</a></li>
                            <li class="last">
                                <a href="{{ route('contact.us') }}" title="Contact Us">{{ __('app.contact_us') }}</a>
                            </li>
                        </ul>
                    </div>
                    <!-- /.module-body -->
                </div>

                <div class="col-xs-6 col-sm-6 col-md-3">
                    <div class="module-heading">
                        <h4 class="module-title">Social Links</h4>
                    </div>
                    <!-- /.module-heading -->

                    <div class="module-body social">
                        <ul class="link">
                            <li class="pull-left">
                                <a target="_blank" rel="nofollow" href="{{ $footercontent->facebook ?? 'https://www.facebook.com/share/1VjqK6xoDm/' }}"
                                    title="Facebook">
                                    <img src="{{ asset('upload/contact/' . $footercontent->facebook_icon) }}"
                                        width="30" style="border-radius:10%;" alt="Facebook" />
                                </a>
                            </li>
                            <li class="pull-left">
                                <a target="_blank" rel="nofollow" href="{{ $footercontent->youtube ?? 'https://youtube.com/@usupershop?feature=shared' }}"
                                    title="youtube">
                                    <img src="{{ asset('upload/contact/' . $footercontent->youtube_icon) }}"
                                        width="30" style="border-radius:10%;" alt="Youtube" />
                                </a>
                            </li>
                            <li class="pull-left">
                                <a target="_blank" rel="nofollow" href="{{ $footercontent->twitter }}"
                                    title="twitter">
                                    <img src="{{ asset('upload/contact/' . $footercontent->twitter_icon) }}"
                                        width="30" style="border-radius:10%;" alt="Twitter" />
                                </a>
                            </li>
                            <li class="pull-left">
                                <a target="_blank" rel="nofollow" href="{{ $footercontent->instagram ?? 'https://www.instagram.com/usupershop?igsh=MXducXBidGE5NzRsNQ==' }}"
                                    title="Instagram">
                                    <img src="{{ asset('upload/contact/' . $footercontent->instagram_icon) }}"
                                        width="30" style="border-radius:10%;" alt="Instagram" />
                                </a>
                            </li>
                            <li class="pull-left">
                                <a target="_blank" rel="nofollow" href="{{ $footercontent->telegram ?? 'https://t.me/usupershop1' }}"
                                    title="Telegram">
                                    <img src="{{ asset('upload/contact/' . $footercontent->telegram_icon) }}"
                                        width="30" style="border-radius:10%;" alt="Telegram" />
                                </a>
                            </li>
                            <li class="pull-left">
                                <a target="_blank" rel="nofollow" href="{{ $footercontent->whatsapp ?? 'https://wa.me/88017' }}"
                                    title="WhatsApp">
                                    <img src="{{ asset('upload/contact/' . $footercontent->whatsapp_icon) }}"
                                        width="30" style="border-radius:10%;" alt="WhatsApp" />
                                </a>
                            </li>
                            <li class="pull-left">
                                <a target="_blank" rel="nofollow" href="https://tiktok.com/@usupershop"
                                    title="TikTok">
                                    <img src="https://cdn-icons-png.flaticon.com/512/3046/3046121.png"
                                        width="30" style="border-radius:10%;" alt="TikTok" />
                                </a>
                            </li>

                        </ul>
                    </div>

                    <div class="module-heading">
                        <h4 class="module-title">Payment & Apps</h4>
                    </div>
                    <div class="module-body social">
                        <ul class="payment-methods">
                            <li style="padding:4px;">
                                <a href="#" class="image">
                                    <img src="{{ asset('frontend') }}/assets/images/bkash.png" alt="bKash"
                                        style="background: #fff; padding: 4px; border-radius: 2px;    height: 36px;width: 55px;" />
                                </a>
                            </li>
                            <li style="padding:4px;">
                                <a href="#" class="image">
                                    <img src="{{ asset('frontend') }}/assets/images/nagad.png" alt="Nagad"
                                        style="background: #fff; padding: 4px; border-radius: 2px;height: 36px;width: 55px;" />
                                </a>
                            </li>
                            <li style="padding:4px;">
                                <a href="https://play.google.com/store/apps/details?id=com.usuper.shop&pli=1"
                                    class="image">
                                    <img src="{{ asset('frontend') }}/assets/images/Google-play.png" alt="Google Play Store"
                                        style="background: #fff; padding: 4px; border-radius: 2px;height: 36px;width: 55px;" />
                                </a>
                            </li>

                        </ul>
                    </div>
                    <!-- /.module-body -->
                </div>
            </div>
        </div>
    </div>
</footer>

<!--========== Modal ===========-->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 style="    margin: 0px;">Order Tracking</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('order.tracksave') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label class="english_lang" for="exampleInputEmail1">Invoice
                            No</label>
                        <label class="bangla_lang" style="display: none;" for="exampleInputEmail1">ইনভয়েস নং</label>
                        <input type="text" name="invoice_no" class="form-control" id="exampleInputEmail1"
                            aria-describedby="emailHelp" placeholder="invoice no...">
                    </div>
                    <button type="submit" class="btn btn-primary english_lang">Track
                        Now</button>
                    <button type="submit" class="btn btn-primary bangla_lang" style="display: none;">এখন
                        ট্র্যাকিং</button>
                </form>
            </div>
        </div>
    </div>
</div>

@push('custom_script')
    <script>
        $('a.profile-nav-btn').click(function() {
            $('ul.profile-nav-items').toggle('show');
        });
    </script>
@endpush
