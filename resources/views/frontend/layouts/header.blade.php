<style>

    .cart-item.product-summary .item {
        width: 100%;
        display: flex;
        border: 1px solid #ddd;
        margin-bottom: 4px;
        padding: 2px;
        border-radius: 4px;
        position: relative;
    }

    .cart-item.product-summary .item span.action{
        position: absolute;
        right: -1px;
        font-size: 15px;
        top: -3px;
        padding: 1px 5px;
        cursor: pointer;
        color: #f60a0a;
    }

    .cart-item.product-summary .item .image a button {
        width: 50px;
        height: 50px;
        outline: none;
        border: none;
        border-radius: 4px;
        padding: 0px;
        text-align: center;
        margin: auto;
        background: #fff;
    }

    .cart-item.product-summary .item .image a button img {
        width: 45px;
        height: 45px;
    }

    .cart-item.product-summary .item .image {
        margin-right: 5px;
    }

    .top-cart-row .dropdown-cart .dropdown-menu {
        padding: 10px;
        border-radius: 2px;
    }

    .cart-item.product-summary .item .details .name {
        margin: 0px;
        font-size: 13px !important;
        font-weight: 600;
    }

    .cart-item.product-summary .item .details .price {
        margin: 0px;
        font-size: 13px;
    }

    .cart-item.product-summary .item .details {
        margin: auto;
        vertical-align: middle;
    }
    .main-header .logo-holder {
        margin-top: 0px;
    }

    .backdrop {
        position: fixed;
        top: 0px;
        left: 0px;
        z-index: 4;
        width: 1000%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        display: none;
    }

    .header-form {
        width: 100%;
        margin: 0px 50px;
        border-radius: 8px;
        background: var(--chalk);
        border: 2px solid var(--chalk);
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        -webkit-box-align: center;
        -ms-flex-align: center;
        align-items: center;
        -webkit-box-pack: center;
        -ms-flex-pack: center;
        justify-content: center;
        transition: all linear 0.3s;
        -webkit-transition: all linear 0.3s;
        -moz-transition: all linear 0.3s;
        -ms-transition: all linear 0.3s;
        -o-transition: all linear 0.3s;
    }

    .header-form:focus-within {
        background: var(--white);
        border-color: var(--primary);
    }

    .header-form input {
        width: 100%;
        height: 45px;
        font-size: 15px;
        padding-left: 15px;
    }

    .header-form button i {
        width: 45px;
        height: 45px;
        font-size: 15px;
        line-height: 45px;
        text-align: center;
        border-radius: 8px;
        color: var(--text);
        display: inline-block;
        transition: all linear 0.3s;
        -webkit-transition: all linear 0.3s;
        -moz-transition: all linear 0.3s;
        -ms-transition: all linear 0.3s;
        -o-transition: all linear 0.3s;
    }

    .header-form button i:hover {
        color: var(--primary);
    }

    .header-media-group {
        display: none;
        -webkit-box-align: center;
        -ms-flex-align: center;
        align-items: center;
        -webkit-box-pack: justify;
        -ms-flex-pack: justify;
        justify-content: space-between;
    }

    .header-media-group a img {
        width: auto;
        height: 45px;
    }

    .header-user img,
    .header-src img {
        width: 30px;
        height: 30px;
        border-radius: 50%;
    }
    .header-user img{
        width: 33px;
        height: 33px;
    }

    .header-user i,
    .header-src i {
        width: 40px;
        height: 40px;
        font-size: 15px;
        line-height: 40px;
        text-align: center;
        display: inline-block;
        border-radius: 50%;
        color: var(--text);
        background: var(--chalk);
        transition: all linear 0.3s;
        -webkit-transition: all linear 0.3s;
        -moz-transition: all linear 0.3s;
        -ms-transition: all linear 0.3s;
        -o-transition: all linear 0.3s;
    }

    .header-user i:hover,
    .header-src i:hover {
        color: var(--white);
        background: var(--primary);
    }

    @media (max-width: 991px) {
        .header-content {
            padding: 10px 0px;
            -webkit-box-orient: vertical;
            -webkit-box-direction: normal;
            -ms-flex-direction: column;
            flex-direction: column;
        }

        .header-media-group {
            width: 100%;
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
        }

        .header-widget-group,
        .header-widget,
        .header-logo {
            display: none;
        }

        .header-form {
            display: none;
            margin: 10px 0px 0px;
        }

        .header-form.active {
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
        }

       
    }

    @media (min-width: 992px) and (max-width: 1199px) {
        .header-widget span {
            display: none;
        }


    }

    @media (min-width:598px) and (max-width:799px) {

        .orderTrackingModal {
            width: 200px !important;
            text-align: left !important;
        }

        #hero {
            /* margin-top: 4%; */
            position: relative;
        }

    }

    .navbar-part {
        background: var(--white);
    }

    .navbar-content {
        border-top: 1px solid var(--border);
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        -webkit-box-align: center;
        -ms-flex-align: center;
        align-items: center;
        -webkit-box-pack: justify;
        -ms-flex-pack: justify;
        justify-content: space-between;
    }

    .navbar-list {
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        -webkit-box-align: center;
        -ms-flex-align: center;
        align-items: center;
        -webkit-box-pack: start;
        -ms-flex-pack: start;
        justify-content: flex-start;
    }

    .navbar-item {
        margin-right: 30px;
    }

    .navbar-item:last-child {
        margin-right: 0px;
    }

    .navbar-link {
        padding: 22px 0px;
        font-weight: 500;
        color: var(--text);
        text-transform: capitalize;
        transition: all linear 0.3s;
        -webkit-transition: all linear 0.3s;
        -moz-transition: all linear 0.3s;
        -ms-transition: all linear 0.3s;
        -o-transition: all linear 0.3s;
    }

    .navbar-link:hover {
        color: var(--primary);
    }

    .navbar-focus-list {
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        -webkit-box-align: center;
        -ms-flex-align: center;
        align-items: center;
        -webkit-box-pack: end;
        -ms-flex-pack: end;
        justify-content: flex-end;
    }

    .navbar-focus-list li {
        margin-left: 30px;
    }

    .navbar-focus-list li:first-child {
        margin-left: 0px;
    }

    .navbar-focus-list li a {
        font-weight: 500;
        color: var(--text);
        text-transform: capitalize;
        transition: all linear 0.3s;
        -webkit-transition: all linear 0.3s;
        -moz-transition: all linear 0.3s;
        -ms-transition: all linear 0.3s;
        -o-transition: all linear 0.3s;
    }

    .navbar-focus-list li a:hover {
        color: var(--primary);
    }

    .navbar-focus-list li a i {
        font-size: 18px;
        margin-right: 5px;
    }

    .navbar-info-group {
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        -webkit-box-align: center;
        -ms-flex-align: center;
        align-items: center;
        -webkit-box-pack: center;
        -ms-flex-pack: center;
        justify-content: center;
    }

    .navbar-info {
        margin-right: 30px;
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        -webkit-box-align: center;
        -ms-flex-align: center;
        align-items: center;
        -webkit-box-pack: start;
        -ms-flex-pack: start;
        justify-content: flex-start;
    }

    .navbar-info:last-child {
        margin-right: 0px;
    }

    .navbar-info i {
        font-size: 30px;
        margin-right: 15px;
        color: var(--primary);
    }

    .navbar-info p small {
        font-size: 14px;
        line-height: 16px;
        display: block;
        text-align: left;
        text-transform: capitalize;
    }

    .navbar-info p span {
        font-size: 15px;
        font-weight: 500;
    }

    .top-menu>li.pricing-nav-item {
        margin-left: 8px;
    }

    .top-menu>li.pricing-nav-item>a.pricing-nav-link {
        display: inline-block;
        padding: 8px 16px !important;
        border-radius: 999px;
        background: linear-gradient(135deg, #1d4ed8 0%, #2563eb 45%, #0ea5e9 100%);
        color: #fff !important;
        font-weight: 700;
        letter-spacing: 0.2px;
        box-shadow: 0 8px 18px -10px rgba(37, 99, 235, 0.95);
        transition: all 0.25s ease;
    }

    .top-menu>li.pricing-nav-item>a.pricing-nav-link:hover,
    .top-menu>li.pricing-nav-item.active>a.pricing-nav-link {
        color: #fff !important;
        background: linear-gradient(135deg, #1e40af 0%, #1d4ed8 55%, #0284c7 100%);
        transform: translateY(-1px);
    }

    @media (max-width: 991px) {
        .navbar-part {
            display: none;
        }

        .top-menu>li.pricing-nav-item {
            margin-left: 0;
        }

        .top-menu>li.pricing-nav-item>a.pricing-nav-link {
            display: block;
            border-radius: 8px;
        }


    }

    @media (min-width: 992px) and (max-width: 1199px) {
        .navbar-list li {
            margin-right: 18px;
        }

        .navbar-link {
            font-size: 15px;
        }

        .navbar-info {
            margin-right: 15px;
        }

        .navbar-info p span {
            font-size: 14px;
        }

        .navbar-info i {
            margin-right: 10px;
        }

    }

    .nav-sidebar {
        position: fixed;
        top: 0px;
        left: -320px;
        width: 280px;
        height: 100vh;
        padding: 0px;
        z-index: 5;
        background: #fff;
        /* background: var(--white); */
        -webkit-box-shadow: 15px 0px 25px 0px rgba(0, 0, 0, 0.15);
        box-shadow: 15px 0px 25px 0px rgba(0, 0, 0, 0.15);
        transition: all linear 0.3s;
        -webkit-transition: all linear 0.3s;
        -moz-transition: all linear 0.3s;
        -ms-transition: all linear 0.3s;
        -o-transition: all linear 0.3s;
    }

    .nav-sidebar.active {
        left: 0px;
    }

    .nav-header {
        padding: 10px 0 10px 25px;
        position: relative;
        /* text-align: center; */
        border-bottom: 1px solid var(--border);
        background: #0824AC;
    }

    .nav-header a img {
        width: auto;
        height: 40px;
    }

    .nav-close {
        position: absolute;
        top: 50%;
        right: 10px;
        -webkit-transform: translateY(-50%);
        transform: translateY(-50%);
    }

    .nav-close i {
        width: 35px;
        height: 35px;
        font-size: 18px;
        line-height: 35px;
        border-radius: 50%;
        text-align: center;
        display: inline-block;
        color: var(--text);
        background: var(--white);
        text-shadow: var(--primary-tshadow);
        transition: all linear 0.3s;
        -webkit-transition: all linear 0.3s;
        -moz-transition: all linear 0.3s;
        -ms-transition: all linear 0.3s;
        -o-transition: all linear 0.3s;
    }

    .nav-close i:hover {
        color: var(--white);
        background: var(--primary);
    }

    .nav-content {
        padding: 0px 18px;
        overflow-y: scroll;
        max-height: calc(100vh - 100px);
    }

    .nav-btn {
        width: 100%;
        padding: 50px 0px;
        margin-bottom: 20px;
        text-align: center;
        background: var(--chalk);
    }

    .nav-btn .btn {
        font-size: 14px;
        padding: 12px 28px;
        letter-spacing: 0.3px;
    }

    .nav-btn .btn i {
        font-size: 14px;
    }

    .nav-profile {
        width: 100%;
        text-align: center;
        padding: 18px 0px 0px;
    }

    .nav-user {
        margin-bottom: 10px;
        border-radius: 50%;
        border: 2px solid var(--primary);
    }

    .nav-user img {
        width: 85px;
        height: 85px;
        border-radius: 50%;
        border: 2px solid var(--white);
    }

    .nav-name {
        margin-bottom: 18px;
        text-transform: capitalize;
    }

    .nav-name a {
        color: var(--heading);
        transition: all linear 0.3s;
        -webkit-transition: all linear 0.3s;
        -moz-transition: all linear 0.3s;
        -ms-transition: all linear 0.3s;
        -o-transition: all linear 0.3s;
    }

    .nav-name a:hover {
        color: var(--primary);
    }

    .nav-select-group {
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        -webkit-box-align: center;
        -ms-flex-align: center;
        align-items: center;
        -webkit-box-pack: center;
        -ms-flex-pack: center;
        justify-content: center;
        padding-bottom: 18px;
        border-bottom: 1px solid var(--border);
    }

    .nav-select {
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        -webkit-box-align: center;
        -ms-flex-align: center;
        align-items: center;
        -webkit-box-pack: center;
        -ms-flex-pack: center;
        justify-content: center;
        margin-right: 18px;
        padding-right: 18px;
        line-height: 20px;
        border-right: 1px solid var(--gray-chalk);
    }

    .nav-select:last-child {
        padding: 0px;
        margin: 0px;
        border: none;
    }

    .nav-select i {
        margin-right: 5px;
    }

    .nav-list {
        width: 100%;
    }

    .nav-list li {
        width: 100%;
        padding: 10px 0px;
    }

    .nav-link {
        width: 100%;
        font-weight: 500;
        padding: 12px 15px;
        border-radius: 8px;
        color: var(--text);
        text-transform: capitalize;
        transition: all linear 0.3s;
        -webkit-transition: all linear 0.3s;
        -moz-transition: all linear 0.3s;
        -ms-transition: all linear 0.3s;
        -o-transition: all linear 0.3s;
    }

    .nav-link:hover {
        color: var(--primary);
        background: var(--chalk);
    }

    .nav-link::before {
        right: 15px;
    }

    .nav-link i {
        font-size: 20px;
        margin-right: 12px;
    }

    .nav-link.active {
        color: var(--primary);
        background: var(--green-chalk);
    }

    .nav-link.pricing-mobile-link {
        background: linear-gradient(135deg, #1d4ed8 0%, #2563eb 50%, #0ea5e9 100%);
        color: #fff;
        font-weight: 600;
        box-shadow: 0 8px 20px -12px rgba(37, 99, 235, 0.9);
    }

    .nav-link.pricing-mobile-link i {
        color: #fff;
    }

    .nav-link.pricing-mobile-link:hover {
        color: #fff;
        background: linear-gradient(135deg, #1e40af 0%, #1d4ed8 50%, #0284c7 100%);
    }

    .nav-info-group {
        padding: 20px 0px;
        margin-top: 15px;
        margin-bottom: 25px;
        border-top: 1px solid var(--border);
        border-bottom: 1px solid var(--border);
    }

    .nav-info {
        margin-bottom: 20px;
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        -webkit-box-align: center;
        -ms-flex-align: center;
        align-items: center;
        -webkit-box-pack: start;
        -ms-flex-pack: start;
        justify-content: flex-start;
    }

    .nav-info:last-child {
        margin-bottom: 0px;
    }

    .nav-info i {
        font-size: 30px;
        margin-right: 15px;
        color: var(--primary);
    }

    .nav-info p small {
        font-size: 14px;
        line-height: 18px;
        display: block;
        text-align: left;
        text-transform: capitalize;
    }

    .nav-info p span {
        font-size: 16px;
        font-weight: 500;
    }

    .nav-footer {
        text-align: center;
    }

    .nav-footer p {
        font-size: 14px;
        color: var(--gray);
    }

    .nav-footer p a {
        color: var(--primary);
    }

    .mobile-header {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        background: #0824ac;
        z-index: 1000;
        box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        padding: 6px 6px;
        padding-bottom: 0px;
    }

    @media (max-width: 776px) {
        .main-header .top-search-holder{
            padding-left: 6px;
        }
    }

    /* fix for the hero section */


    #hero .owl-carousel .item img {
        width: 100%;
        object-fit: cover;
    }

    @media (max-width: 480px) {
        #hero .owl-carousel .item img {
            width: 100%;
            object-fit: cover;
        }

        .breadcrumb {
            margin-top: 25%;
        }

        #login-row {
            margin-top: 18%;
        }

        .prof {
            margin-top: 18%;
        }

        .single-product-gallery-item {
            height: 50%;
        }

      

    }

    /* Custom responsive adjustment for 483px - 589px */
    @media (min-width: 483px) and (max-width: 589px) {

        /* Slider container adjustments */
        .sliderFixed {
            margin: 0 !important;
            padding: 0 !important;
        }

        /* Slider image specific adjustments */
        #hero .slide img {
            max-height: 600px !important;
            /* Control slider height */
            object-fit: cover;
        }

        #owl-main .item img {
            /* margin-top: 50px !important; */
        }
    }
    @media (max-width: 576px) {
        .home-banner-row {
            margin-top: 101px !important;
        }
    }
</style>
<header class="header-style-1">
    <!-- =============== TOP MENU ================ -->
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="top-bar animate-dropdown">
                    <div class="header-top-inner">
                        <div class="cnt-account">
                            <ul class="list-unstyled">

                                <li>
                                    <a class="english_lang" href="{{ route('show.cart') }}"><i
                                            class="icon fa fa-shopping-cart"></i>My Cart</a>
                                    <a class="bangla_lang" style="display:none" href="{{ route('show.cart') }}"><i
                                            class="icon fa fa-shopping-cart"></i>আমার কার্ড</a>
                                </li>
                                <li>
                                    <a class="english_lang" href="{{ route('show.cart') }}"><i
                                            class="icon fa fa-check"></i>Checkout</a>
                                    <a class="bangla_lang" style="display:none" href="{{ route('show.cart') }}"><i
                                            class="icon fa fa-check"></i>চেকআউট</a>
                                </li>
                                @auth
                                    @if (auth()->user()->usertype === 'customer')
                                        <li>
                                            <a class="english_lang" href="{{ route('dashboard') }}"><i
                                                    class="icon fa fa-user"></i>{{ __('app.my_account') }}</a>
                                            <a class="bangla_lang" style="display:none" href="{{ route('dashboard') }}"><i
                                                    class="icon fa fa-user"></i>আমার একাউন্ট</a>
                                        </li>
                                    @endif
                                    @if (auth()->user()->usertype === 'vendor')
                                        <li>
                                            <a class="english_lang" href="{{ route('seller.dashboard') }}"><i
                                                    class="icon fa fa-user"></i>{{ __('app.my_account') }}</a>
                                            <a class="bangla_lang" style="display:none" href="{{ route('seller.dashboard') }}"><i
                                                    class="icon fa fa-user"></i>আমার একাউন্ট</a>
                                        </li>
                                    @endif
                                    @if (auth()->user()->usertype === 'seller')
                                        <li>
                                            <a class="english_lang" href="{{ route('seller.dashboard') }}"><i
                                                    class="icon fa fa-user"></i>{{ __('app.my_account') }}</a>
                                            <a class="bangla_lang" style="display:none" href="{{ route('seller.dashboard') }}"><i
                                                    class="icon fa fa-user"></i>আমার একাউন্ট</a>
                                        </li>
                                    @endif
                                    @if (auth()->user()->usertype === 'dropshipper')
                                        <li>
                                            <a class="english_lang" href="{{ route('dropshipper.dashboard') }}"><i
                                                    class="icon fa fa-user"></i>{{ __('app.my_account') }}</a>
                                            <a class="bangla_lang" style="display:none" href="{{ route('seller.dashboard') }}"><i
                                                    class="icon fa fa-user"></i>আমার একাউন্ট</a>
                                        </li>
                                    @endif
                                @else
                                    <li>
                                        <a class="english_lang" href="{{ route('customer.login') }}"><i
                                                class="icon fa fa-lock"></i>{{ __('app.login') }}</a>
                                        <a class="bangla_lang" style="display:none"
                                            href="{{ route('customer.login') }}"><i
                                                class="icon fa fa-lock"></i>লগইন</a>
                                        
                                    </li>
                                @endauth
                            </ul>
                        </div>
                        <!-- /.cnt-account -->

                        <div class="cnt-block">
                            <ul class="list-unstyled list-inline">

                                @auth
                                    
                                @else
                                    <li class="dropdown dropdown-small">
                                        <a class="english_lang dropdown-toggle" href="{{ route('seller.signup') }}"
                                            data-hover="dropdown"><span class="value">Become a Seller</span></a>
                                        <a class="bangla_lang dropdown-toggle" style="display:none" href="{{ route('seller.signup') }}"
                                            data-hover="dropdown"><span class="value">সেলার /
                                                ভেন্ডর</span></a>
                                    </li>
                                @endauth
                                <li class="dropdown dropdown-small">
                                    <a class="english_lang dropdown-toggle" href="#" data-hover="dropdown"
                                        data-toggle="modal" data-target="#orderTrackingModal"><span class="value">Order
                                            Track</span></a>
                                    <a class="bangla_lang dropdown-toggle" style="display:none" href="#"
                                        data-hover="dropdown" data-toggle="modal"
                                        data-target="#orderTrackingModal"><span class="value">অর্ডার ট্র্যাক</span></a>
                                </li>
                                <li class="dropdown dropdown-small">
                                    <a class="english_lang dropdown-toggle" href="#" data-hover="dropdown"
                                        data-toggle="dropdown"><span class="value">Language Change
                                        </span><b class="caret"></b></a>
                                    <a class="bangla_lang dropdown-toggle" href="#" style="display: none;"
                                        data-hover="dropdown" data-toggle="dropdown"><span class="value">ভাষা পরিবর্তন
                                            করুন
                                        </span><b class="caret"></b></a>
                                    <ul class="dropdown-menu">

                                        <li><a class="changeLng english" style="display:none" lang="english"
                                                href="#">English</a>
                                        </li>

                                        <li><a class="changeLng bangla" lang="bangla"
                                        href="{{ route('bangla.language') }}"
                                        style="font-weight:700;color:#111">
                                        🇧🇩 বাংলা
                                    </a>
                                        </li>

                                    </ul>
                                </li>

                            </ul>
                        </div>
                        <!-- /.cnt-cart -->
                        <!--========== Modal ===========-->
                        <div class="modal fade" id="orderTrackingModal" tabindex="-1" role="dialog"
                            aria-labelledby="orderTrackingModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title english_lang" id="orderTrackingModalLabel">Order
                                            Tracking</h5>
                                        <button type="button" class="close" data-dismiss="modal"
                                            aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ route('order.tracksave') }}" method="POST">
                                            @csrf
                                            <div class="form-group">
                                                <label class="english_lang" for="exampleInputEmail1">Invoice
                                                    No</label>
                                                <label class="bangla_lang" style="display: none;"
                                                    for="exampleInputEmail1">ইনভয়েস নং</label>
                                                <input type="text" name="invoice_no" class="form-control"
                                                    id="invoice_no" aria-describedby="emailHelp"
                                                    placeholder="e.g. USP00044">
                                            </div>
                                            <button type="submit" class="btn btn-primary english_lang">Track
                                                Now</button>
                                            <button type="submit" class="btn btn-primary bangla_lang"
                                                style="display: none;">এখন ট্র্যাকিং</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--========== End Modal ===========-->
                        <div class="clearfix"></div>
                    </div>
                    <!-- /.header-top-inner -->
                </div>
            </div>
        </div>
    </div>
    <!-- /.header-top -->
    <!-- ================= TOP MENU : END ================= -->
    <div class="main-header">
        <div class="container">
            <div class="mobile-header">
                <aside class="nav-sidebar">
                    <div class="nav-header">
                        <a href="#"><img src="{{ asset('upload/logo_image/' . Helper::getLogo()->image) }}"
                                alt="logo" /></a><button class="nav-close"><i class="icofont-close"></i></button>
                    </div>
                    <div class="nav-content">
                        <ul class="nav-list">
                            <li>
                                <a href="{{ url('/') }}" class="nav-link"><i class="icofont-home"></i>Home</a>
                            </li>
                            <li>
                                <a href="{{ route('product.list') }}" class="nav-link"><i
                                        class="icofont-cart"></i>Shop</a>
                            </li>
                            <li>
                                <a href="{{ route('pricing.cards') }}" class="nav-link pricing-mobile-link"><i
                                        class="fa fa-tags"></i>Pricing Plans</a>
                            </li>
                            <li>
                                <a href="{{ route('speacial.offers') }}" class="nav-link"><i
                                        class="icofont-cart"></i>Special Offer</a>
                            </li>
                            @php
                                $categories = Helper::get_categories();
                                $footercontent = Helper::getfootercontacts();
                            @endphp
                            @foreach ($categories as $category)
                                <li>
                                    <a class="nav-link"
                                        href="{{ route('category.wise.product', $category->id) }}"><i
                                            class="icofont-contacts"></i>{{ $category->name }}</a>
                                </li>
                            @endforeach
                        </ul>
                        <div class="nav-info-group">
                            <div class="nav-info">
                                <i class="icofont-ui-touch-phone"></i>
                                <p><small>Contact Us WhatsApp</small><span>{{ $footercontent->mobile ?? '' }}</span>
                                </p>
                            </div>
                            <div class="nav-info">
                                <i class="icofont-ui-email"></i>
                                <p><small>Email us</small><span>{{ $footercontent->email ?? '' }}</span></p>
                            </div>
                        </div>
                    </div>
                </aside>
                <div class="row mobile-header-row">
                    <div class="mobile-logo-col">
                        <a href="{{ url('/') }}">
                            <img class="mobile-logo" src="{{ asset('upload/logo_image/' . Helper::getLogo()->image) }}"
                                alt="{{ Helper::getLogo()->name }}">
                        </a>
                    </div>
                    <div class="mobile-search-col">
                        <!-- ==================== SEARCH AREA =================== -->
                        <div class="search-area">
                            <form action="{{ route('search.product') }}" method="GET">
                                <div class="control-group" style="position: relative;">
                                    <input class="search-field" onfocus="showSearchResult()"
                                        onblur="hideSearchResult()" name="search" id="search"
                                        placeholder="Search here..." />
                                    <button type="button" class="search-button"></button>
                                </div>
                            </form>
                            <div id="suggestProduct"></div>
                        </div><!-- /.search-area -->
                    </div>
                    <div class="mobile-cart-col animate-dropdown top-cart-row">
                        <!-- ================== SHOPPING CART DROPDOWN ================= -->
                        <div class="dropdown dropdown-cart">
                            <a href="#" class="dropdown-toggle lnk-cart" data-toggle="dropdown">
                                <div class="items-cart-inner">
                                    <div class="basket" style="border: none; font-size: 18px; margin: 0; position: relative;">
                                        <i class="glyphicon glyphicon-shopping-cart"></i>
                                    </div>
                                    <div class="basket-item-count">
                                        <span class="count"></span>
                                    </div>
                                </div>
                            </a>
                            <ul class="dropdown-menu">
                                <li class="addTotalCartItemSection">
                                    <div class="cart-item product-summary addToCartProducts">
                                    </div>
                                    <!-- /.cart-item -->
                                    <div class="clearfix"></div>
                                    {{--  <hr /> --}}

                                    <div class="clearfix cart-total">
                                        <div class="pull-right">
                                            <span class="text">Sub Total :</span>TK. <span class="price">0.00</span>
                                        </div>
                                        <div class="clearfix"></div>
                                        <a href="{{ route('show.cart') }}"
                                            class="btn btn-upper btn-primary btn-block m-t-20">Checkout</a>
                                    </div>
                                    <!-- /.cart-total-->
                                </li>
                            </ul>
                            <!-- /.dropdown-menu-->
                        </div>
                        <!-- /.dropdown-cart -->
                        <!-- =============== SHOPPING CART DROPDOWN : END ============== -->
                        <!-- /.top-cart-row -->
                    </div>
                </div>
            </div>
            <div class="row desktop-header">
                <div class="col-xs-12 col-sm-12 col-md-3 logo-holder">
                    <!-- ================ LOGO ============== -->
                    <div class="logo">
                        <a href="{{ url('/') }}">
                            <img class="desktop-logo" src="{{ asset('upload/logo_image/' . Helper::getLogo()->image) }}"
                                alt="{{ Helper::getLogo()->name }}">
                            <!-- <img class="mobile-logo" src="{{ asset('frontend') }}/images/favicon.png"
                                alt="{{ Helper::getLogo()->name }}"> -->
                        </a>
                    </div>
                    <!-- /.logo -->
                    <!-- ============ LOGO : END ============ -->
                </div>
                <!-- /.logo-holder -->
                <div class="col-xs-10 col-sm-12 col-md-7 top-search-holder">
                    <!-- /.contact-row -->
                    <!-- ==================== SEARCH AREA =================== -->
                        <form action="{{ route('search.product') }}" method="GET">
                            <div class="control-group">
                                <input class="search-field" onfocus="showSearchResult_desktop()"
                                    onblur="hideSearchResult_desktop()" name="search_desktop" id="search_desktop"
                                    placeholder="Search here..." />
                                <button type="button" class="search-button"></button>
                            </div>
                        </form>
                        <div id="suggestProduct_desktop"></div>
                    <!-- ================= SEARCH AREA : END ================= -->
                </div>
                <!-- /.top-search-holder -->

                <div class="col-xs-12 col-sm-12 col-md-2 animate-dropdown top-cart-row">
                    <!-- ================== SHOPPING CART DROPDOWN ================= -->
                    <div class="dropdown dropdown-cart">
                        <a href="#" class="dropdown-toggle lnk-cart" data-toggle="dropdown">
                            <div class="items-cart-inner">
                                <div class="basket" style="border: none;font-size: 18px;">
                                    <i class="glyphicon glyphicon-shopping-cart"></i>
                                </div>
                                <div class="basket-item-count">
                                    <span class="count">0</span>
                                </div>
                            </div>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="addTotalCartItemSection">
                                <div class="cart-item product-summary addToCartProducts">
                                    
                                </div>
                                <!-- /.cart-item -->
                                <div class="clearfix"></div>
                                {{--  <hr /> --}}

                                <div class="clearfix cart-total">
                                    <div class="pull-right">
                                        <span class="text">Sub Total :</span>Tk.<span class="price"> 0.00</span>
                                    </div>
                                    <div class="clearfix"></div>
                                    <a href="{{ route('show.cart') }}"
                                        class="btn btn-upper btn-primary btn-block m-t-20">Checkout</a>
                                </div>
                                <!-- /.cart-total-->
                            </li>
                        </ul>
                        <!-- /.dropdown-menu-->
                    </div>
                    <!-- /.dropdown-cart -->
                    <!-- =============== SHOPPING CART DROPDOWN : END ============== -->
                </div>
                <!-- /.top-cart-row -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container -->
    </div>

    <!-- ================= NAVBAR ================== -->
    <div class="header-nav animate-dropdown">
        <div class="container">
            <div class="yamm navbar navbar-default" role="navigation">
                <div class="navbar-header">
                    <button data-target="#mc-horizontal-menu-collapse" data-toggle="collapse"
                        class="navbar-toggle collapsed" type="button">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                </div>
                <div class="nav-bg-class">
                    <div class="navbar-collapse collapse" id="mc-horizontal-menu-collapse">
                        <div class="nav-outer">
                            <ul class="nav navbar-nav top-menu">
                                <li class="active">
                                    <a class="english_lang" href="{{ url('./') }}">Home</a>
                                    <a class="bangla_lang" style="display:none" href="{{ url('./') }}">হোম</a>
                                </li>

                                <?php 
                                    $limit=6;
                                    $categories = Helper::get_categories();
                                    $total=count($categories);
                                    foreach ($categories as $key=>$category):
                                    if($key<$limit){
                                ?>
                                <li>
                                    <a class="english_lang"
                                        href="{{ route('category.wise.product', $category->id) }}">
                                        <?php echo $category->name; ?>
                                    </a>
                                    <a class="bangla_lang" style="display:none"
                                        href="{{ route('category.wise.product', $category->id) }}">
                                        <?php echo $category->name_bn; ?>
                                    </a>
                                </li>
                                <?php }else{
                                    if($key==$limit){
                                        ?>
                                <li class="nav-item dropdown">
                                    <a class="english_lang nav-link dropdown-toggle" href="#" role="button"
                                        data-toggle="dropdown"> More.. </a>
                                    <a class="bangla_lang nav-link dropdown-toggle" href="#" role="button"
                                        data-toggle="dropdown">আরও </a>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <a class="english_lang dropdown-item"
                                                href="{{ route('category.wise.product', $category->id) }}">
                                                <?php echo $category->name; ?>
                                            </a>
                                            <a class="dropdown-item bangla_lang" style="display:none"
                                                href="{{ route('category.wise.product', $category->id) }}">
                                                <?php echo $category->name_bn; ?>
                                            </a>
                                        </li>


                                        <?php }else{ ?>
                                        <li>
                                            <a class="english_lang dropdown-item"
                                                href="{{ route('category.wise.product', $category->id) }}">
                                                <?php echo $category->name; ?>
                                            </a>
                                            <a class="dropdown-item bangla_lang" style="display:none"
                                                href="{{ route('category.wise.product', $category->id) }}">
                                                <?php echo $category->name_bn; ?>
                                            </a>
                                        </li>

                                        <?php } 
                                    if($total==($key+1)){
                                        echo "</ul></li>";
                                    }
                                } endforeach ?>

                                        <li>
                                            <a class="english_lang" href="{{ route('product.list') }}">Shop</a>
                                            <a class="bangla_lang" style="display:none"
                                                href="{{ route('product.list') }}">শপ</a>
                                        </li>
                                        <li class="pricing-nav-item">
                                            <a class="english_lang pricing-nav-link" href="{{ route('pricing.cards') }}">Pricing</a>
                                            <a class="bangla_lang pricing-nav-link" style="display:none"
                                                href="{{ route('pricing.cards') }}">প্রাইসিং</a>
                                            <span class="menu-label new-menu hidden-xs english_lang">OFFER</span>
                                            <span class="menu-label new-menu hidden-xs bangla_lang"
                                                style="display:none">অফার</span>
                                        </li>
                                        <!--<li>
                                    <a class="english_lang" href="{{ route('hot.deals') }}">Hot Deals</a>
                                    <a class="bangla_lang" style="display:none" href="{{ route('hot.deals') }}">হট
                                        ডেলস</a>
                                    <span class="menu-label hot-menu hidden-xs english_lang">Hot</span>
                                    <span class="menu-label hot-menu hidden-xs bangla_lang"
                                        style="display:none">হট</span>
                                </li-->
                                        <li>
                                            <a class="english_lang" href="{{ route('speacial.offers') }}">Special
                                                Offer</a>
                                            <a class="bangla_lang" style="display:none"
                                                href="{{ route('speacial.offers') }}">স্পেশাল অফার</a>
                                            <span class="menu-label new-menu hidden-xs english_lang">offer</span>
                                            <span class="menu-label new-menu hidden-xs bangla_lang"
                                                style="display:none">অফার</span>
                                        </li>
                                        {{-- <li>
                                    <a href="{{ route('contact.us') }}">Contact Us</a>
                                </li> --}}
                                        <!--<li class="dropdown navbar-right special-menu">
                                    <a class="english_lang" href="#">Todays offer</a>
                                    <a class="bangla_lang" style="display:none" href="#">আজকের অফার</a>
                                </li>-->
                                    </ul>
                                    <!-- /.navbar-nav -->
                                    <div class="clearfix"></div>
                        </div>
                        <!-- /.nav-outer -->
                    </div>
                    <!-- /.navbar-collapse -->
                </div>
                <!-- /.nav-bg-class -->
            </div>
            <!-- /.navbar-default -->
        </div>
        <!-- /.container-class -->
    </div>
    <!-- ============== NAVBAR : END =============== -->
</header>
<script type="text/javascript">
    $(document).ready(function() {

        $(".header-user").on("click", function() {
            $("body").css("overflow", "hidden"),
                $(".nav-sidebar").addClass("active"),
                $(".nav-close").on("click", function() {
                    $("body").css("overflow", "inherit"),
                        $(".nav-sidebar").removeClass("active"),
                        $(".backdrop").fadeOut();
                });
        });

        $(".header-user, .header-cart, .header-cate, .cart-btn, .cate-btn").on(
            "click",
            function() {
                $(".backdrop").fadeIn(),
                    $(".backdrop").on("click", function() {
                        $(this).fadeOut(),
                            $("body").css("overflow", "inherit"),
                            $(".nav-sidebar").removeClass("active"),
                            $(".cart-sidebar").removeClass("active"),
                            $(".category-sidebar").removeClass("active");
                    });
            });

        let lng = $.cookie('lang');
        if (lng == 'bangla') {
            $(".english, .bangla_lang").show();
            $(".bangla, .english_lang").hide();
        } else {
            $(".english, .bangla_lang").hide();
            $(".bangla, .english_lang").show();
        }

        let currentUri = window.location.href;
        $("ul.top-menu li").removeClass('active');

        $('ul.top-menu li a').each(function(e) {
            let uri = $(this).attr('href');
            if (uri == currentUri) {
                $(this).parent().addClass('active');
            }
        });

        $("body").on("keyup", "#search", function() {
            let searchData = $("#search").val();
            //console.log(searchData);
            if (searchData.length > 0) {
                $.ajax({
                    type: 'POST',
                    url: "{{ url('/find-products') }}",
                    data: {
                        search: searchData,
                        _token: "{{ csrf_token() }}",
                    },
                    success: function(result) {

                        var html = '';
                        if (result.length > 0) {
                            result.forEach(function(product) {
                                // Generate URL from Laravel route with placeholder
                                let product_url = "{{ route('product.details.info', ['slug' => ':slug']) }}";

                                // Replace placeholder with actual slug from product
                                product_url = product_url.replace(':slug', product.slug);

                                // Append HTML for each product
                                html += `
                                    <a href="${product_url}">
                                        <li class="design-li">
                                            <img src="{{ url('upload/product_images') }}/${product.image}" alt="${product.name}" height="40" width="40" loading="lazy">
                                            <strong>${product.name}</strong>
                                        </li>
                                    </a>`;
                            })
                        } else {
                            html = '<li style="color: red; padding: 14px 20px; list-style: none; text-align: center;">Not Found</li>';
                        }
                        $('#suggestProduct').html(html)
                        
                    }
                });
            }
            if (searchData.length < 1) $('#suggestProduct').html("");
        });

        $("body").on("keyup", "#search_desktop", function() {
            let searchData = $("#search_desktop").val();
            //console.log(searchData);
            if (searchData.length > 0) {
                $.ajax({
                    type: 'POST',
                    url: "{{ url('/find-products') }}",
                    data: {
                        search: searchData,
                        _token: "{{ csrf_token() }}",
                    },
                    success: function(result) {
                        var html = '';
                        if (result.length > 0) {
                            result.forEach(function(product) {
                                // Generate URL from Laravel route with placeholder
                                let product_url = "{{ route('product.details.info', ['slug' => ':slug']) }}";

                                // Replace placeholder with actual slug from product
                                product_url = product_url.replace(':slug', product.slug);

                                // Append HTML for each product
                                html += `
                                    <a href="${product_url}">
                                        <li class="design-li">
                                            <img src="{{ url('upload/product_images') }}/${product.image}" alt="${product.name}" height="40" width="40" loading="lazy">
                                            <strong>${product.name}</strong>
                                        </li>
                                    </a>`;
                            });

                        } else {
                            html = '<li style="color: red; padding: 14px 20px; list-style: none; text-align: center;">Not Found</li>';
                        }
                        $('#suggestProduct_desktop').html(html)
                    }
                });
            }
            if (searchData.length < 1) $('#suggestProduct_desktop').html("");
        });

        function renderSearchResult(data) {
            let html = '';
            if (data.length > 0) {
                data.forEach(function(product) {
                    // Generate URL from Laravel route with placeholder
                    let product_url = "{{ route('product.details.info', ['slug' => ':slug']) }}";

                    // Replace placeholder with actual slug from product
                    product_url = product_url.replace(':slug', product.slug);

                    // Append HTML for each product
                    html += `
                        <a href="${product_url}">
                            <li class="design-li">
                                <img src="${product.image}" alt="${product.name}" height="40" width="40">
                                <strong>${product.name}</strong>
                            </li>
                        </a>`;
                });

            } else {
                html = '<li style="color: red; padding:0 20px;">Not Found</li>';
            }
            $('#suggestProduct_desktop').html(html)
        }

        function showSearchResult() {
            $('#suggestProduct').slideDown();
        }

        function showSearchResult_desktop() {
            $('#suggestProduct_desktop').slideDown();
        }

        function hideSearchResult() {
            $('#suggestProduct').slideUp();
        }

        function hideSearchResult_desktop() {
            $('#suggestProduct_desktop').slideUp();
        }

        $(".changeLng").click(function() {
            let lang = $(this).attr("lang");
            if (lang == 'bangla') {

                $.cookie('lang', 'bangla');

                $(".english, .bangla_lang").show();
                $(".bangla, .english_lang").hide();

            } else {
                $(".english, .bangla_lang").hide();
                $(".bangla, .english_lang").show();

                $.cookie('lang', 'english');
            }
            //console($.cookie('lang'));
        });

    })
</script>
