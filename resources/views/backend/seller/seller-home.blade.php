@extends('backend.seller.seller-master')
@section('content')
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
