@extends('backend.seller.seller-master')
@section('content')


                {{-- ── My Shop Page & Share Links ──────────────────────────── --}}
                @php
                    $myUserType = auth()->user()->usertype; // 'seller' or 'vendor'
                    $shopURL    = route('seller.home', ['shopID' => auth()->id()]);
                    $refCode    = auth()->user()->refer_code;
                    $refURL     = $refCode ? url('/ref/' . $refCode) : null;
                    $shopName   = auth()->user()->shop_name ?? auth()->user()->name;
                @endphp
                <div class="row mb-4">
                    {{-- Shop Page Card --}}
                    <div class="col-md-6 mb-3">
                        <div class="card shadow-sm h-100">
                            <div class="card-header" style="background:linear-gradient(135deg,#00a855,#005c30)">
                                <h3 class="card-title text-white mb-0">
                                    {{ $myUserType === 'vendor' ? '🏭 আমার Vendor Shop' : '🏪 আমার Seller Shop' }}
                                </h3>
                            </div>
                            <div class="card-body">
                                <div style="font-size:13px;color:#555;margin-bottom:10px">
                                    <strong>{{ $shopName }}</strong>-এর Shop Page।
                                    Link share করলে Customer সরাসরি আপনার সব পণ্য দেখতে পাবে।
                                </div>

                                {{-- Shop Page URL --}}
                                <label style="font-size:12px;font-weight:700;color:#333">🌐 Shop Page URL:</label>
                                <div class="input-group mb-2">
                                    <input type="text" class="form-control form-control-sm"
                                        style="font-size:12px;font-family:monospace"
                                        id="shopPageLink" value="{{ $shopURL }}"
                                        readonly onclick="this.select()">
                                    <div class="input-group-append">
                                        <a href="{{ $shopURL }}" target="_blank" class="btn btn-success btn-sm">
                                            <i class="fas fa-eye"></i> দেখুন
                                        </a>
                                        <button class="btn btn-primary btn-sm" onclick="copyLink('shopPageLink','shopMsg')">
                                            <i class="fas fa-copy"></i>
                                        </button>
                                    </div>
                                </div>
                                <small id="shopMsg" style="color:#00a855;display:none">✅ Copied!</small>

                                {{-- Social Share --}}
                                <div class="d-flex flex-wrap" style="gap:6px;margin-top:8px">
                                    <a target="_blank" class="btn btn-sm btn-success"
                                        href="https://api.whatsapp.com/send?text={{ rawurlencode('🏪 ' . $shopName . '-এর Shop দেখুন — সেরা দামে কিনুন! ' . $shopURL) }}">
                                        <i class="fab fa-whatsapp mr-1"></i>WhatsApp
                                    </a>
                                    <a target="_blank" class="btn btn-sm btn-primary"
                                        href="https://www.facebook.com/sharer/sharer.php?u={{ rawurlencode($shopURL) }}">
                                        <i class="fab fa-facebook mr-1"></i>Facebook
                                    </a>
                                    <a target="_blank" class="btn btn-sm btn-info"
                                        href="https://t.me/share/url?url={{ rawurlencode($shopURL) }}&text={{ rawurlencode('🏪 ' . $shopName . '-এর Shop দেখুন!') }}">
                                        <i class="fab fa-telegram mr-1"></i>Telegram
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Commission Share Link --}}
                    <div class="col-md-6 mb-3">
                        <div class="card shadow-sm h-100">
                            <div class="card-header" style="background:linear-gradient(135deg,#1e25fa,#0d1280)">
                                <h3 class="card-title text-white mb-0">
                                    🔗 Commission Link — প্রতি Order-এ 10%
                                </h3>
                            </div>
                            <div class="card-body">
                                <div style="font-size:13px;color:#555;margin-bottom:10px">
                                    এই Link দিয়ে কেউ Order করলে → Admin <strong>Delivered</strong> করলে →
                                    <strong style="color:#00a855">10% Commission</strong> আপনার Wallet-এ।
                                </div>

                                @if($refURL)
                                <label style="font-size:12px;font-weight:700;color:#333">🔗 Referral URL:</label>
                                <div class="input-group mb-2">
                                    <input type="text" class="form-control form-control-sm"
                                        style="font-size:12px;font-family:monospace"
                                        id="siteRefLink" value="{{ $refURL }}"
                                        readonly onclick="this.select()">
                                    <div class="input-group-append">
                                        <button class="btn btn-primary btn-sm" onclick="copyLink('siteRefLink','refMsg')">
                                            <i class="fas fa-copy"></i>
                                        </button>
                                    </div>
                                </div>
                                <small id="refMsg" style="color:#00a855;display:none">✅ Copied!</small>

                                <div class="d-flex flex-wrap" style="gap:6px;margin-top:8px">
                                    <a target="_blank" class="btn btn-sm btn-success"
                                        href="https://api.whatsapp.com/send?text={{ rawurlencode('🛍️ U Super Shop-এ কেনাকাটা করুন! সেরা দাম, দ্রুত ডেলিভারি। ' . $refURL) }}">
                                        <i class="fab fa-whatsapp mr-1"></i>WhatsApp
                                    </a>
                                    <a target="_blank" class="btn btn-sm btn-primary"
                                        href="https://www.facebook.com/sharer/sharer.php?u={{ rawurlencode($refURL) }}">
                                        <i class="fab fa-facebook mr-1"></i>Facebook
                                    </a>
                                    <a target="_blank" class="btn btn-sm btn-danger"
                                        href="https://www.tiktok.com/">
                                        <i class="fab fa-tiktok mr-1"></i>TikTok
                                    </a>
                                </div>
                                @else
                                <div class="alert alert-warning py-2 mb-0" style="font-size:13px">
                                    ⚠️ Refer code নেই। Admin-এর সাথে যোগাযোগ করুন।
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <script>
                function copyLink(inputId, msgId) {
                    var inp = document.getElementById(inputId);
                    if (!inp) return;
                    inp.select(); inp.setSelectionRange(0, 99999);
                    try { document.execCommand('copy'); } catch(e) {
                        if (navigator.clipboard) navigator.clipboard.writeText(inp.value);
                    }
                    if (msgId) {
                        var msg = document.getElementById(msgId);
                        if (msg) { msg.style.display='inline'; setTimeout(function(){msg.style.display='none';},2000); }
                    }
                }
                </script>




                <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <!-- Small boxes (Stat box) -->
                <marquee>

                </marquee>
                @if (auth()->user()->payment_status == 1)
                    <div class="row">
                        <div class="col-md-12">
                            @if (auth()->user()->usertype === 'seller')
                                <div class="chart tab-pane active" id="revenue-chart">
                                    <h2 style="color:green;font-weight:bold;text-align:center">Welcome ! You are a General
                                        Reseller in our Shop !!!</h2>
                                </div>
                            @endif

                            @if (auth()->user()->usertype === 'vendor')
                                <div class="chart tab-pane active" id="revenue-chart">
                                    <h2 style="color:green;font-weight:bold;text-align:center">Welcome ! You are a General
                                        Vendor in our Shop !!!</h2>
                                </div>
                            @endif
                        </div>
                    </div>

                    @if (auth()->user()->usertype === 'vendor')
                        <div class="row">

                            <div class="col-lg-3 col-6">
                                <!-- small box -->
                                <div class="small-box bg-info">
                                    <div class="inner">
                                        <h3>{{ number_format($data['user_balance'], 2) }}</h3>
                                        <p>Main Balance</p>
                                    </div>
                                    <div class="icon">
                                        <i class="ion ion-bag"></i>
                                    </div>

                                </div>
                            </div>

                            <div class="col-lg-3 col-6">
                                <!-- small box -->
                                <div class="small-box bg-success">
                                    <div class="inner">
                                        <h3>{{ number_format($data['user_refer_commission'], 2) }}</h3>
                                        <p>Refer Commission</p>
                                    </div>
                                    <div class="icon">
                                        <i class="ion ion-stats-bars"></i>
                                    </div>

                                </div>
                            </div>

                            <div class="col-lg-3 col-6">
                                <!-- small box -->
                                <div class="small-box bg-warning">
                                    <div class="inner">
                                        <h3>{{ $data['active_product_count'] }}</h3>

                                        <p>Active Product</p>
                                    </div>
                                    <div class="icon">
                                        <i class="ion ion-person-add"></i>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-3 col-6">
                                <!-- small box -->
                                <div class="small-box bg-danger">
                                    <div class="inner">
                                        <h3>{{ number_format($data['vendor_product_sales_commission'], 2) }}</h3>
                                        <p>Total Sales</p>
                                    </div>
                                    <div class="icon">
                                        <i class="ion ion-pie-graph"></i>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-3 col-6">
                                <!-- small box -->
                                <div class="small-box bg-info">
                                    <div class="inner">
                                        <h3>{{ $data['pending_order_item_count'] }}</h3>
                                        <p>Total Pending Order</p>
                                    </div>
                                    <div class="icon">
                                        <i class="ion ion-bag"></i>
                                    </div>

                                </div>
                            </div>

                            <div class="col-lg-3 col-6">
                                <!-- small box -->
                                <div class="small-box bg-success">
                                    <div class="inner">
                                        <h3>{{ $data['delivered_order_item_count'] }}<sup style="font-size: 20px"></sup>
                                        </h3>
                                        <p>Total Delivered Order</p>
                                    </div>
                                    <div class="icon">
                                        <i class="ion ion-stats-bars"></i>
                                    </div>

                                </div>
                            </div>

                            <div class="col-lg-3 col-6">
                                <!-- small box -->
                                <div class="small-box bg-warning">
                                    <div class="inner">
                                        <h3>{{ $data['return_order_item_count'] }}</h3>

                                        <p>Total Return Order</p>
                                    </div>
                                    <div class="icon">
                                        <i class="ion ion-person-add"></i>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-3 col-6">
                                <!-- small box -->
                                <div class="small-box bg-danger">
                                    <div class="inner">
                                        <h3>{{ $data['canceled_order_item_count'] }}</h3>
                                        <p>Total Cancel Order</p>
                                    </div>
                                    <div class="icon">
                                        <i class="ion ion-pie-graph"></i>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-3 col-6">
                                <!-- small box -->
                                <div class="small-box bg-info">
                                    <div class="inner">
                                        <h3>0</h3>
                                        <p>Total Withdraw</p>
                                    </div>
                                    <div class="icon">
                                        <i class="ion ion-pie-graph"></i>
                                    </div>
                                </div>
                            </div>

                        </div>
                    @endif

                    @if (auth()->user()->usertype === 'seller')
                        <div class="row">

                            <div class="col-lg-3 col-6">
                                <!-- small box -->
                                <div class="small-box bg-info">
                                    <div class="inner">
                                        <h3>{{ number_format($data['user_balance'], 2) }}</h3>
                                        <p>Main Balance</p>
                                    </div>
                                    <div class="icon">
                                        <i class="ion ion-bag"></i>
                                    </div>

                                </div>
                            </div>

                            <div class="col-lg-3 col-6">
                                <!-- small box -->
                                <div class="small-box bg-success">
                                    <div class="inner">
                                        <h3>{{ number_format($data['user_refer_commission'], 2) }}</h3>
                                        <p>Refer Commission</p>
                                    </div>
                                    <div class="icon">
                                        <i class="ion ion-stats-bars"></i>
                                    </div>

                                </div>
                            </div>

                            <div class="col-lg-3 col-6">
                                <!-- small box -->
                                <div class="small-box bg-danger">
                                    <div class="inner">
                                        <h3>{{ number_format($data['reseller_sales_commission'], 2) }}</h3>
                                        <p>Total Sales</p>
                                    </div>
                                    <div class="icon">
                                        <i class="ion ion-pie-graph"></i>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-3 col-6">
                                <!-- small box -->
                                <div class="small-box bg-info">
                                    <div class="inner">
                                        <h3>{{ $data['pending_order_item_count'] }}</h3>
                                        <p>Total Pending Order</p>
                                    </div>
                                    <div class="icon">
                                        <i class="ion ion-bag"></i>
                                    </div>

                                </div>
                            </div>

                            <div class="col-lg-3 col-6">
                                <!-- small box -->
                                <div class="small-box bg-success">
                                    <div class="inner">
                                        <h3>{{ $data['delivered_order_item_count'] }}<sup style="font-size: 20px"></sup>
                                        </h3>
                                        <p>Total Delivered Order</p>
                                    </div>
                                    <div class="icon">
                                        <i class="ion ion-stats-bars"></i>
                                    </div>

                                </div>
                            </div>

                            <div class="col-lg-3 col-6">
                                <!-- small box -->
                                <div class="small-box bg-warning">
                                    <div class="inner">
                                        <h3>{{ $data['return_order_item_count'] }}</h3>

                                        <p>Total Return Order</p>
                                    </div>
                                    <div class="icon">
                                        <i class="ion ion-person-add"></i>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-3 col-6">
                                <!-- small box -->
                                <div class="small-box bg-danger">
                                    <div class="inner">
                                        <h3>{{ $data['canceled_order_item_count'] }}</h3>
                                        <p>Total Cancel Order</p>
                                    </div>
                                    <div class="icon">
                                        <i class="ion ion-pie-graph"></i>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-3 col-6">
                                <!-- small box -->
                                <div class="small-box bg-info">
                                    <div class="inner">
                                        <h3>0</h3>
                                        <p>Total Withdraw</p>
                                    </div>
                                    <div class="icon">
                                        <i class="ion ion-pie-graph"></i>
                                    </div>
                                </div>
                            </div>

                        </div>
                    @endif
                @endif

                @if (auth()->user()->payment_status == 0)
                    <div class="row">
                        <!-- Left col -->
                        <section class="col-lg-12 col-md-12 col-sm-12 connectedSortable">
                            <!-- Custom tabs (Charts with tabs)-->
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">
                                        <i class="fas fa-chart-pie mr-1"></i>
                                        Please Pay First for Subscription
                                    </h3>

                                </div>
                                <!-- /.card-header -->
                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                @if (session()->has('message'))
                                    <div class="alert alert-{{ session('type') }}">
                                        {{ session('message') }}
                                    </div>
                                @endif
                                <div class="card-body">
                                    <div class="tab-content p-0">

                                        <div class="chart tab-pane active" id="revenue-chart"
                                            style="position: relative; height: 380px">
                                            <div class="row">
                                                <div class="col-12 col-sm-8 col-md-6 col-lg-5 6 col-xl-4"
                                                    style="margin: auto;">
                                                    <div class="card">
                                                        <div class="card-header text-center " style="background: #dddd;">
                                                            <h4 style="margin-bottom: 0px;">Subscription Payment</h4>
                                                        </div>
                                                        <div class="card-body">
                                                            <form action="{{ route('seller.processPayment') }}"
                                                                method="POST">
                                                                @csrf
                                                                <div class="form-group">
                                                                    <label for="colFormLabelSm"
                                                                        class="col-form-label col-form-label-sm">Seller
                                                                        Type
                                                                        <span class="text-danger">*</span></label>
                                                                    <select name="seller_type" id="seller_type"
                                                                        class="form-control form-control-md">
                                                                        <option value="">Select Type</option>
                                                                        @foreach ($sellerfees as $fee)
                                                                            <option
                                                                                value="{{ $fee->account_type_of_myshop }}">
                                                                                {{ $fee->account_type_of_myshop ?? '' }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>

                                                                <div class="form-group">
                                                                    <label for="colFormLabelSm"
                                                                        class="col-form-label col-form-label-sm">Subscription
                                                                        Fee <span class="text-danger">*</span></label>
                                                                    <input type="text" name="subscription_fee"
                                                                        class="form-control form-control-md"
                                                                        id="subscription_fee" placeholder="Tk."
                                                                        value="0" readonly="readonly" required>
                                                                </div>

                                                                <div class="form-group mb-2">
                                                                    <button class="btn btn-success btn-md form-control"
                                                                        type="submit">Pay Now</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                    </div>
                                </div>
                                <!-- /.card-body -->
                            </div>
                            <!-- /.card -->
                            <!-- /.card -->
                        </section>
                        <!-- /.Left col -->
                    </div>
                @endif
                <!-- /.row (main row) -->
                {{--<div class="row">
                    <div class="col-12">
                        <a class="small-box bg-info" href="{{ route('frontend.home') }}">
                            <div class="inner">
                                <h3>Goto Home Page</h3>
                            </div>
                            <div class="icon">
                                <i class="ion ion-arrow-right-a"></i>
                            </div>
                    </div>
                </div>--}}
            </div>
            <!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection
@section('custom_js')
    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            },
        });

        $("#seller_type").change(function() {
            const sellerType = $(this).val();
            //   alert(sellerType);
            if (!sellerType) {
                alert('Please select a valid seller type.');
                return; // Prevent further execution
            }

            $.ajax({
                url: "{{ route('seller.subscriptionfee') }}",
                method: 'GET',
                dataType: 'json',
                data: {
                    seller_type: sellerType,
                },
                success: function(response) {
                    if (response.status === 'success' && response.sellerfees) {
                        const subscriptionFee = response.sellerfees.subscription_fees || 0;
                        // console.log(subscriptionFee);
                        $('#subscription_fee').val(subscriptionFee);
                    } else {
                        console.warn(response.message);
                        alert(response.message || 'No data found.');
                        $('#subscription_fee').val(0);
                    }
                },
                error: function(xhr) {
                    console.error('Error Status:', xhr.status); // Debug error
                    console.error('Response Text:', xhr.responseText);
                    alert('Failed to fetch subscription fee. Please try again.');
                },
            });
        });
    </script>
@endsection
