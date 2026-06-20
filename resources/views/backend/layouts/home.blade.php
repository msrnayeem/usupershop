@extends('backend.layouts.master')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header" style="padding-bottom:0px;">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Dashboard</h1>
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ol>
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <!-- Small boxes (Stat box) -->
                <marquee>
                   
                </marquee>
                <div class="row">
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-info">
                            <div class="inner">
                                <h3>{{ $orders ?? 0}}</h3>
                                <p>Total Orders</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-bag"></i>
                            </div>
                         
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3>{{ $sellers ?? 0}}<sup style="font-size: 20px"></sup></h3>
                                <p>Total Seller </p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-stats-bars"></i>
                            </div>
                           
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-warning">
                            <div class="inner">
                                <h3>{{ $customers }}</h3>
                                <p>Total Customer</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-person-add"></i>
                            </div>
                        
                        </div>
                    </div>
                    <!-- ./col -->
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-danger">
                            <div class="inner">
                                <h3>{{ $pending_products ?? 0}}</h3>
                                <p>Total Pending Products</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-pie-graph"></i>
                            </div>
                            <a href="{{ route('products.pending.view') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-info">
                            <div class="inner">
                                <h3>{{ $products ?? 0}}</h3>
                                <p>Total Products</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-pie-graph"></i>
                            </div>
                            <a href="{{ route('products.view') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-secondary">
                            <div class="inner">
                                <h3>{{ $inactive_products ?? 0}}</h3>
                                <p>Total Inactive Products</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-pie-graph"></i>
                            </div>
                            <a href="{{ route('products.inactive.view') }}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                           <!-- ./col -->
                    <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-success">
                            <div class="inner">
                               <h3>{{ $pending_order }}</h3>
                                <p>Total Pending Order</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-person-add"></i>
                            </div>
                        
                        </div>
                    </div>
                    
                        <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-warning">
                            <div class="inner">
                                <h3>{{ $confirmed_order ?? 0}}<sup style="font-size: 20px"></sup></h3>
                                <p>Total Confirm Order  </p>
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
                                <h3>{{ $delivered_order ?? 0}}</h3>
                                <p>Total Order Delivered</p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-bag"></i>
                            </div>
                         
                        </div>
                    </div>
                                            <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-info">
                            <div class="inner">
                                <h3>{{ $return_order ?? 0}}</h3>
                                <p>Total Order Return </p>
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
                                <h3>{{ $cancel_order ?? 0}}<sup style="font-size: 20px"></sup></h3>
                                <p>Total Cancel  Order  </p>
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
                                <h3>{{ $paid_sellers ?? 0}}<sup style="font-size: 20px"></sup></h3>
                                <p>Total Seller Paid  </p>
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
                               
                                <h3>{{ $unPaid_sellers ?? 0}}<sup style="font-size: 20px"></sup></h3>
                                <p>Total Seller Unpaid  </p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-stats-bars"></i>
                            </div>
                           
                        </div>
                    </div>
                           <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-info">
                            <div class="inner">
                               <!--not declare dropshipper from controller-->
                                <h3>{{ $unPaid_dropshipper ?? 0}}<sup style="font-size: 20px"></sup></h3>
                                <p>Total Dropshipper Paid  </p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-stats-bars"></i>
                            </div>
                           
                        </div>
                    </div>
                           <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-success">
                            <div class="inner">
                               <!--not declare dropshipper from controller-->
                                <h3>{{ $unPaid_dropshipper ?? 0}}<sup style="font-size: 20px"></sup></h3>
                                <p>Total Dropshipper Unpaid  </p>
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
                              
                                <h3>{{ $paid_vendor ?? 0}}<sup style="font-size: 20px"></sup></h3>
                                <p>Total Vendor Paid  </p>
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
                              
                                <h3>{{ $upPaid_vendor ?? 0}}<sup style="font-size: 20px"></sup></h3>
                                <p>Total Vendor Unpaid  </p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-stats-bars"></i>
                            </div>
                           
                        </div>
                    </div>
                    
                           <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-info">
                            <div class="inner">
                                <h3>{{ $is_profile_verify ?? 0}}<sup style="font-size: 20px"></sup></h3>
                                <p>Total Profile Verify  </p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-stats-bars"></i>
                            </div>
                           
                        </div>
                    </div>
                    
                    
                           <div class="col-lg-3 col-6">
                        <!-- small box -->
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3>{{ $user_total_balance ?? 0}}<sup style="font-size: 20px"></sup></h3>
                                <p>Total User Balance Paid  </p>
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
                                <h3>{{ $total_reffer ?? 0}}<sup style="font-size: 20px"></sup></h3>
                                <p>Total Refer Code  </p>
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
                                <h3>{{ $total_withdraw_request ?? 0}}<sup style="font-size: 20px"></sup></h3>
                                <p>Total Withdraw Request  </p>
                            </div>
                            <div class="icon">
                                <i class="ion ion-stats-bars"></i>
                            </div>
                           
                        </div>
                    </div>
                    

                    
                    <!-- ./col -->
                    
                </div>

                <!-- WhatsApp Notify Status Card (Admin only) -->
                @php $waSetting = \App\Models\Setting::first(); @endphp
                <div class="row mb-3">
                    <div class="col-md-12">
                        <div style="background:linear-gradient(135deg,#075E54,#128C7E); border-radius:12px; padding:16px 20px; display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:12px;">
                            <div style="display:flex; align-items:center; gap:14px;">
                                <div style="width:48px; height:48px; background:rgba(255,255,255,.15); border-radius:50%; display:flex; align-items:center; justify-content:center; font-size:26px; flex-shrink:0;">
                                    <i class="fab fa-whatsapp" style="color:#fff;"></i>
                                </div>
                                <div>
                                    <div style="color:#fff; font-weight:700; font-size:15px;">WhatsApp Notification</div>
                                    @if(!empty($waSetting->whatsapp_notify_number))
                                        <div style="color:rgba(255,255,255,.85); font-size:13px; margin-top:2px;">
                                            ✅ Active —
                                            <strong style="color:#fff; font-size:15px; letter-spacing:1px;">
                                                {{ $waSetting->whatsapp_notify_number }}
                                            </strong>
                                        </div>
                                        <div style="color:rgba(255,255,255,.7); font-size:11px; margin-top:3px;">
                                            নতুন order ও member payment-এ এই নম্বরে WhatsApp message আসবে
                                        </div>
                                    @else
                                        <div style="color:#FFD700; font-size:13px; margin-top:2px;">
                                            ⚠️ WhatsApp number সেট করা নেই — Settings থেকে যোগ করুন
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div style="display:flex; gap:8px; flex-wrap:wrap;">
                                <a href="{{ route('settings.view') }}" style="background:rgba(255,255,255,.2); color:#fff; padding:8px 18px; border-radius:20px; text-decoration:none; font-size:13px; font-weight:600; border:1px solid rgba(255,255,255,.3);">
                                    <i class="fas fa-cog"></i>
                                    {{ empty($waSetting->whatsapp_notify_number) ? 'Number যোগ করুন' : 'Settings' }}
                                </a>
                                @if(!empty($waSetting->whatsapp_notify_number))
                                <a href="{{ route('whatsapp.test') }}" style="background:#25D366; color:#fff; padding:8px 18px; border-radius:20px; text-decoration:none; font-size:13px; font-weight:600;" onclick="return confirm('Test WhatsApp message পাঠাবেন?')">
                                    <i class="fab fa-whatsapp"></i> Test করুন
                                </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- /.row -->
                <!-- Main row -->
                <div class="row">
                    <!-- Left col -->
                    <section class="col-lg-12 connectedSortable">
                        <!-- Custom tabs (Charts with tabs)-->
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">
                                 
                                    
                                </h3>
                               
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <div class="tab-content p-0">
                                    <!-- Morris chart - Sales -->
                                    <div class="chart tab-pane active" id="revenue-chart"
                                        style="position: relative; height: 300px">
                                        <canvas id="revenue-chart-canvas" height="300" style="height: 300px"></canvas>
                                    </div>
                                    <div class="chart tab-pane" id="sales-chart" style="position: relative; height: 300px">
                                        <canvas id="sales-chart-canvas" height="300" style="height: 300px"></canvas>
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
                <!-- /.row (main row) -->
            </div>
            <!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection
