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

<footer id="footer" class="footer color-bg">
    <div class="footer-bottom">
        <div class="container">
            <div class="row">
                {{-- ── Contact Us ── --}}
                <div class="col-xs-6 col-sm-6 col-md-3">
                    <div class="module-heading">
                        <h4 class="module-title">যোগাযোগ করুন</h4>
                    </div>
                    <div class="module-body">
                        <ul class="toggle-footer">
                            <li class="media">
                                <div class="pull-left">
                                    <span class="icon fa-stack fa-lg">
                                        <i class="fa fa-map-marker fa-stack-1x fa-inverse"></i>
                                    </span>
                                </div>
                                <div class="media-body">
                                    <p>{{ $footercontent->address ?? 'Dhaka, Bangladesh' }}</p>
                                </div>
                            </li>
                            <li class="media">
                                <div class="pull-left">
                                    <span class="icon fa-stack fa-lg">
                                        <i class="fa fa-mobile fa-stack-1x fa-inverse"></i>
                                    </span>
                                </div>
                                <div class="media-body">
                                    <p>{{ $footercontent->mobile ?? '+8801816622128' }}</p>
                                </div>
                            </li>
                            <li class="media">
                                <div class="pull-left">
                                    <span class="icon fa-stack fa-lg">
                                        <i class="fa fa-envelope fa-stack-1x fa-inverse"></i>
                                    </span>
                                </div>
                                <div class="media-body">
                                    <span>
                                        <a href="mailto:{{ $footercontent->email ?? 'usupershopbd@gmail.com' }}">
                                            {{ $footercontent->email ?? 'usupershopbd@gmail.com' }}
                                        </a>
                                    </span>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>

                {{-- ── Customer Service ── --}}
                <div class="col-xs-6 col-sm-6 col-md-3">
                    <div class="module-heading">
                        <h4 class="module-title">Customer Service</h4>
                    </div>
                    <div class="module-body">
                        <ul class="list-unstyled">
                            <li class="first">
                                <a title="About Us" href="{{ route('about.us') }}">About Us</a>
                            </li>
                            <li>
                                <a href="{{ route('pricing.cards') }}" title="Pricing Plans">Pricing Plans <span class="pricing-mini-badge">NEW</span></a>
                            </li>
                            <li>
                                <a href="{{ route('show.cart') }}" title="My Cart">My Cart</a>
                            </li>
                            <li>
                                <a href="{{ route('customer.checkout') }}" title="Checkout">Checkout</a>
                            </li>
                            @guest
                            <li class="last">
                                <a href="{{ route('seller.signup') }}" title="Become a Seller">Become a Seller</a>
                            </li>
                            @endguest
                        </ul>
                    </div>
                </div>

                {{-- ── Policies ── --}}
                <div class="col-xs-6 col-sm-6 col-md-3">
                    <div class="module-heading">
                        <h4 class="module-title">Our Valuable Policies</h4>
                    </div>
                    <div class="module-body">
                        <ul class="list-unstyled">
                            <li class="first">
                                <a href="{{ route('terms.and.condition') }}" title="Terms & Conditions">Terms &amp; Conditions</a>
                            </li>
                            <li>
                                <a href="{{ route('privacy.policy') }}" title="Privacy Policy">Privacy Policy</a>
                            </li>
                            <li>
                                <a href="{{ route('return.policy') }}" title="Return Policy">Return Policy</a>
                            </li>
                            <li class="last">
                                <a href="{{ route('contact.us') }}" title="Contact Us">Contact Us</a>
                            </li>
                        </ul>
                    </div>
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
