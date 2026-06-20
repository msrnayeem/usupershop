<style>
    .main-header .logo-holder {
        margin-top: 0px;
    }
</style>
<header class="header-style-1">
    <!-- =============== TOP MENU ================ -->
    <div class="top-bar animate-dropdown">
        <div class="container">
            <div class="header-top-inner">
                <div class="cnt-account">
                    <ul class="list-unstyled">
                       
                        <li>
                            <a class="english_lang" href="{{ route('show.seller.cart') }}"><i
                                    class="icon fa fa-shopping-cart"></i>My Cart</a>
                            <a class="bangla_lang" style="display:none" href="{{ route('show.seller.cart') }}"><i
                                    class="icon fa fa-shopping-cart"></i>আমার কার্ড</a>
                        </li>
                        <li>
                            <a class="english_lang" href="{{ route('show.seller.cart') }}"><i
                                    class="icon fa fa-check"></i>Checkout</a>
                            <a class="bangla_lang" style="display:none" href="{{ route('show.seller.cart') }}"><i
                                    class="icon fa fa-check"></i>চেকআউট</a>
                        </li>
                        @if (@Auth::user()->id != null && @Auth::user()->usertype == 'customer')
                            <li>
                                <a class="english_lang" href="{{ route('seller.customer.dashboard') }}"><i
                                        class="icon fa fa-user"></i>My Account</a>
                                <a class="bangla_lang" style="display:none" href="{{ route('seller.customer.dashboard') }}"><i
                                        class="icon fa fa-user"></i>আমার একাউন্ট</a>
                            </li>
                        @endif
                        @if (@Auth::user()->id != null && @Auth::user()->usertype == 'customer')
                            <li>
                                <a class="english_lang" href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                            document.getElementById('logout-form').submit();">Logout</a>
                                <a class="bangla_lang" style="display:none" href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                            document.getElementById('logout-form').submit();">লগআউট</a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </li>
                        @else
                            <li>
                                <a class="english_lang" href="{{ route('seller.customer.login') }}"><i
                                        class="icon fa fa-lock"></i>Login</a>
                                <a class="bangla_lang" style="display:none" href="{{ route('seller.customer.login') }}"><i
                                        class="icon fa fa-lock"></i>লগইন</a>
                            </li>
                            <li>
                                <a class="english_lang" href="{{ route('seller.customer.signup') }}"><i
                                        class="icon fa fa-user"></i>Registration</a>
                                <a class="bangla_lang" style="display:none" href="{{ route('seller.customer.signup') }}"><i
                                        class="icon fa fa-lock"></i>রেজিস্ট্রেশন</a>
                            </li>
                        @endif
                    </ul>
                </div>
                <!-- /.cnt-account -->

                <div class="cnt-block">
                    <ul class="list-unstyled list-inline">
                        <!-- <li class="dropdown dropdown-small">
                            <a class="english_lang" href="{{ route('seller.login') }}" class="dropdown-toggle"
                                data-hover="dropdown"><span class="value">Become a Seller</span></a>
                            <a class="bangla_lang" style="display:none" href="{{ route('seller.login') }}"
                                class="dropdown-toggle" data-hover="dropdown"><span class="value">সেলার /
                                    ভেন্ডর</span></a>
                        </li> -->
                       
                        <li class="dropdown dropdown-small">
                            <a class="english_lang" class="dropdown-toggle" data-hover="dropdown"
                                data-toggle="dropdown"><span class="value">Language Change
                                </span><b class="caret"></b></a>
                            <a class="bangla_lang" style="display: none;" class="dropdown-toggle" data-hover="dropdown"
                                data-toggle="dropdown"><span class="value">ভাষা পরিবর্তন করুন
                                </span><b class="caret"></b></a>
                            <ul class="dropdown-menu">

                                <li><a class="changeLng english" style="display:none" lang="english"
                                        href="#">English</a>
                                </li>

                                <li><a class="changeLng bangla" lang="bangla" href="#">বাংলা</a>
                                </li>

                            </ul>
                        </li>

                        <!-- <li class="dropdown dropdown-small">
                            <a href="#" class="dropdown-toggle" data-hover="dropdown" data-toggle="dropdown"><span
                                    class="value">English </span><b class="caret"></b></a>
                            <ul class="dropdown-menu">
                                <li><a href="#">English</a></li>
                                <li><a href="#">বাংলা</a></li>
                            </ul>
                        </li> -->
                    </ul>
                    <!-- /.list-unstyled -->
                </div>
                <!-- /.cnt-cart -->
                <!--========== Modal ===========-->
                <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog"
                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('order.track') }}" method="GET">
                                   
                                    <div class="form-group">
                                        <label class="english_lang" for="exampleInputEmail1">Invoice No</label>
                                        <label class="bangla_lang" style="display: none;"
                                            for="exampleInputEmail1">ইনভয়েস নং</label>
                                        <input type="text" name="invoice_no" class="form-control"
                                            id="exampleInputEmail1" aria-describedby="emailHelp"
                                            placeholder="invoice no...">
                                    </div>
                                    <button type="submit" class="btn btn-primary english_lang">Track Now</button>
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
        <!-- /.container -->
    </div>
    <!-- /.header-top -->
    <!-- ================= TOP MENU : END ================= -->
    <div class="main-header">
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-3 logo-holder">
                    <!-- ================ LOGO ============== -->
                    <div class="logo">
                        <a href="{{ url('') }}">
                            <img src="{{ asset('upload/logo_image/' . Helper::getLogo()->image) }}"
                                alt="{{ Helper::getLogo()->name }}" style="width:160px;height:60px;">
                        </a>
                    </div>
                    <!-- /.logo -->
                    <!-- ============ LOGO : END ============ -->
                </div>
                <!-- /.logo-holder -->

                <div class="col-xs-12 col-sm-12 col-md-7 top-search-holder">
                    <!-- /.contact-row -->

                    <!-- ==================== SEARCH AREA =================== -->
                    <div class="search-area">
                        <form action="{{ route('search.product') }}" method="GET">
                            <div class="control-group">
                                <input class="search-field" onfocus="showSearchResult()" onblur="hideSearchResult()"
                                    name="search" id="search" placeholder="Search here..." />
                                <button class="search-button"></button>
                            </div>
                        </form>
                        <div id="suggestProduct"></div>
                    </div><!-- /.search-area -->
                    <!-- ================== SEARCH AREA : END ================ -->


                    <!-- =================== SEARCH AREA ===================== -->
                    <!-- <div class="search-area">
                        <form>
                            <div class="control-group">
                                <ul class="categories-filter animate-dropdown">
                                    <li class="dropdown">
                                        <a class="dropdown-toggle" data-toggle="dropdown"
                                            href="category.html">Categories <b class="caret"></b></a>

                                        <ul class="dropdown-menu" role="menu">
                                            <li class="menu-header">Computer</li>
                                            <li role="presentation">
                                                <a role="menuitem" tabindex="-1" href="category.html">-
                                                    Clothing</a>
                                            </li>
                                            <li role="presentation">
                                                <a role="menuitem" tabindex="-1" href="category.html">-
                                                    Electronics</a>
                                            </li>
                                            <li role="presentation">
                                                <a role="menuitem" tabindex="-1" href="category.html">-
                                                    Shoes</a>
                                            </li>
                                            <li role="presentation">
                                                <a role="menuitem" tabindex="-1" href="category.html">-
                                                    Watches</a>
                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                                <input class="search-field" onfocus="showSearchResult()" onblur="hideSearchResult()"
                                    name="search" id="search" placeholder="Search here..." />
                                <button class="search-button"></button>
                            </div>
                        </form>
                    </div> -->
                    <!-- /.search-area -->
                    <!-- ================= SEARCH AREA : END ================= -->
                </div>
                <!-- /.top-search-holder -->

                <div class="col-xs-12 col-sm-12 col-md-2 animate-dropdown top-cart-row">
                    <!-- ================== SHOPPING CART DROPDOWN ================= -->
                    <div class="dropdown dropdown-cart">
                        <a href="#" class="dropdown-toggle lnk-cart" data-toggle="dropdown">
                            <div class="items-cart-inner">
                                <div class="basket">
                                    <i class="glyphicon glyphicon-shopping-cart"></i>
                                </div>
                                <div class="basket-item-count">
                                    <span class="count">{{ Cart::count() }}</span>
                                </div>
                                <div class="total-price-basket">
                                    <span class="lbl english_lang">Cart-</span>
                                    <span style="display:none" class="lbl bangla_lang">কার্ড-</span>
                                    <span class="total-price">
                                        <span class="sign"></span><span
                                            class="value">{{ Cart::subtotal() }}</span>
                                    </span>
                                </div>
                            </div>
                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                @php
                                    $contents = Cart::content();
                                    $total = 0;
                                @endphp
                                <div class="cart-item product-summary">
                                    @foreach ($contents as $content)
                                        <div class="row">
                                            <div class="col-xs-4">
                                                <div class="image">
                                                    <a href=""><img
                                                            src="{{ url('upload/product_images/' . $content->options->image) }}"
                                                            alt="" /></a>
                                                </div>
                                            </div>
                                            <div class="col-xs-7">
                                                <h3 class="name">
                                                    <a href="">{{ $content->name }}</a>
                                                </h3>
                                                <div class="price">{{ $content->qty }} x {{ $content->price }} Tk.
                                                </div>
                                            </div>
                                            <div class="col-xs-1 action">
                                                <a href="{{ route('delete.cart', $content->rowId) }}"><i
                                                        class="fa fa-trash"></i></a>
                                            </div>
                                        </div>
                                        <hr />
                                        @php
                                            $total += $content->subtotal;
                                        @endphp
                                    @endforeach

                                </div>
                                <!-- /.cart-item -->
                                <div class="clearfix"></div>
                                <!-- {{--  <hr /> --}} -->

                                <div class="clearfix cart-total">
                                    <div class="pull-right">
                                        <span class="text">Sub Total :</span><span class="price"> Tk.
                                            {{ number_format($total, 2) }}</span>
                                    </div>
                                    <div class="clearfix"></div>

                                    <a href="{{ route('show.seller.cart') }}"
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
    <!-- /.main-header -->

    
    <!-- ============== NAVBAR : END =============== -->
</header>
<script type="text/javascript">
    $(document).ready(function() {

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
                        $('#suggestProduct').html(result)
                    }
                });
            }

            if (searchData.length < 1) $('#suggestProduct').html("");
        });

        function showSearchResult() {
            $('#suggestProduct').slideDown();
        }

        function hideSearchResult() {
            $('#suggestProduct').slideUp();
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
