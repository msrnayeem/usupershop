@extends('backend.seller.seller-master')

@section('title', 'Order Tracking')

@section('custom_css')
    <style>
        @import url('https://fonts.googleapis.com/css?family=Open+Sans:400,600,700&display=swap');

        .card {
            border: 1px solid #ebebeb;
            border-radius: 5px;
            background-color: #fff;
            margin-bottom: 30px;
            box-shadow: 0 1px 4px rgba(0,0,0,0.05);
        }

        .card-header {
            background-color: #fcfcfc;
            border-bottom: 1px solid #ebebeb;
            padding: 15px 20px;
        }

        .header-item {
            font-family: 'Open Sans', sans-serif;
            font-size: 13px;
            color: #555;
            line-height: 1.6;
        }

        .header-item strong {
            color: #333;
            font-weight: 700;
        }

        .header-item span.highlight {
            font-weight: 600;
            color: #222;
        }

        /* Tracking Timeline */
        .track-area {
            padding: 50px 0;
            position: relative;
        }

        .steps-wrapper {
            display: flex;
            justify-content: space-between;
            position: relative;
            margin-bottom: 20px;
            z-index: 2;
        }

        .step-item {
            position: relative;
            text-align: center;
            width: 100%;
            z-index: 2;
        }

        .step-icon-box {
            width: 50px;
            height: 50px;
            background: #e0e0e0;
            border-radius: 50%;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 20px;
            border: 4px solid #fff; /* whitespace around circle */
            position: relative;
            z-index: 3;
            transition: all 0.3s ease;
        }

        .step-item.active .step-icon-box {
            background: #6bbd23; /* Bright green from screenshot */
            box-shadow: 0 0 0 4px #e8f5e9; /* Light green ring */
        }
        
        .step-item.completed .step-icon-box {
            background: #6bbd23;
        }

        .step-text {
            margin-top: 15px;
            color: #666;
            font-size: 14px;
            font-weight: 500;
        }
         
        /* The Gray Line */
        .track-line-bg {
            position: absolute;
            top: 25px; /* Center of 50px circle is 25px */
            left: 8%; /* Start slightly in */
            width: 84%; /* End slightly in */
            height: 6px;
            background: #e0e0e0;
            z-index: 1;
            transform: translateY(-50%);
        }

        /* The Green Line (Progress) */
        .track-line-progress {
            position: absolute;
            top: 25px;
            left: 8%;
            height: 6px;
            background: #6bbd23;
            z-index: 1;
            transform: translateY(-50%);
            transition: width 0.5s ease;
        }

        /* Responsive */
        @media screen and (max-width: 768px) {
            .steps-wrapper {
                flex-direction: column;
                align-items: flex-start;
                padding-left: 20px;
            }
            .step-item {
                display: flex;
                align-items: center;
                margin-bottom: 30px;
                text-align: left;
                width: auto;
            }
            .step-text {
                margin-top: 0;
                margin-left: 20px;
            }
            .track-line-bg, .track-line-progress {
                left: 45px;
                top: 25px;
                width: 6px;
                height: 100%; /* Cover height */
                transform: none;
            }
             .track-line-bg {
                 height: 90%; /* Approximate vertical length */
             }
             .track-line-progress {
                  height: 0; /* JS or style to control vertical height */
                  width: 6px;
              }
        }

        .itemside {
            display: flex;
            width: 100%;
        }
        .aside {
            position: relative;
            flex-shrink: 0;
            margin-right: 15px;
        }
        .info {
            padding-top: 5px;
        }
        .img-sm {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border: 1px solid #eee;
            border-radius: 4px;
        }
    </style>
@endsection

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Order Tracking</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('seller.dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">Order Tracking</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="header-item">
                                            <strong>Invoice No:</strong> <br>
                                            <span class="highlight">{{ $order->invoice_no }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="header-item">
                                            <strong>Order Date:</strong> <br>
                                            {{ $order->created_at->format('Y-m-d H:i:s') }}
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="header-item">
                                            <strong>Shipping By: <span style="font-size:14px; font-weight:700; color:#333;">{{ $order->shipping->name }}</span></strong> <br>
                                            {{ $order->shipping->address }} | <i class="fa fa-phone"></i> {{ $order->shipping->mobile }}
                                        </div>
                                    </div>
                                    <div class="col-md-2 text-md-right text-left">
                                        <div class="header-item">
                                            <strong>Status:</strong> <br>
                                            {{ ucfirst($order->status) }} 
                                            <br>
                                            <strong>Total:</strong> <span style="color: #333; font-weight:700;">৳ {{ number_format($order->order_total, 2) }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                @php
                                    $statusMap = [
                                        'pending' => 0,
                                        'confirmed' => 1,
                                        'packaging' => 2,
                                        'shipment' => 3,
                                        'delivered' => 4,
                                        'return' => 5
                                    ];
                                    
                                    $currentStep = 0;
                                    if(array_key_exists($order->status, $statusMap)) {
                                        $currentStep = $statusMap[$order->status];
                                    }
                                    
                                    $percentage = $currentStep * 20; 
                                    
                                    $isReturn = ($order->status == 'return');
                                    $isCanceled = ($order->status == 'canceled');
                                    
                                    if($isReturn) {
                                        $currentStep = 5;
                                        $percentage = 100;
                                    }

                                    $steps = [
                                        ['label' => 'Order Pending', 'icon' => 'fa-spinner'],
                                        ['label' => 'Order Confirmed', 'icon' => 'fa-shopping-cart'],
                                        ['label' => 'Packaging Order', 'icon' => 'fa-gift'],
                                        ['label' => 'Order Shipment', 'icon' => 'fa-truck'],
                                        ['label' => 'Delivered Order', 'icon' => 'fa-user'],
                                        ['label' => 'Return Order', 'icon' => 'fa-undo']
                                    ];
                                @endphp

                                <div class="track-area">
                                    @if($isCanceled)
                                        <div class="alert alert-danger text-center">
                                            <i class="fa fa-times-circle"></i> This order has been canceled.
                                        </div>
                                    @else
                                        <div class="track-line-bg"></div>
                                        <div class="track-line-progress" style="width: {{ $percentage }}%;"></div>
                                        
                                        <div class="steps-wrapper">
                                            @foreach($steps as $index => $step)
                                                @php
                                                    $isActive = $index == $currentStep;
                                                    $isCompleted = $index < $currentStep;
                                                    $statusClass = '';
                                                    if($isActive) $statusClass = 'active';
                                                    elseif($isCompleted) $statusClass = 'completed';
                                                @endphp
                                                <div class="step-item {{ $statusClass }}">
                                                    <div class="step-icon-box">
                                                        <i class="fa {{ $step['icon'] }}"></i>
                                                    </div>
                                                    <div class="step-text">
                                                        {{ $step['label'] }}
                                                        @php
                                                            $timestampField = match($index) {
                                                                0 => 'created_at',
                                                                1 => 'confirmed_at',
                                                                2 => 'packaging_at',
                                                                3 => 'shipment_at',
                                                                4 => 'delivered_at',
                                                                5 => 'returned_at',
                                                                default => null
                                                            };
                                                        @endphp
                                                        @if($timestampField && $order->$timestampField)
                                                            <div style="font-size: 11px; color: #888; margin-top: 5px; font-weight: 400;">
                                                                {{ \Carbon\Carbon::parse($order->$timestampField)->format('d M Y, h:i A') }}
                                                            </div>
                                                        @elseif($index > $currentStep)
                                                            <div style="font-size: 11px; color: #ccc; margin-top: 5px; font-weight: 400;">
                                                                Not yet
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>

                                <hr style="margin-top: 50px; border-top: 1px solid #ebebeb;">
                                
                                <!-- Order Items -->
                                <div class="row">
                                    @foreach ($orderItems as $item)
                                        <div class="col-md-6 col-lg-4 mb-4">
                                            <div class="itemside">
                                                <div class="aside">
                                                    @if (!empty($item->product->image))
                                                        <img src="{{ url('upload/product_images/' . $item->product->image) }}" class="img-sm"
                                                            onerror="this.onerror=null; this.src='{{ asset('frontend/no-image-icon.jpg') }}';" alt="Item">
                                                    @else
                                                        <img src="{{ asset('frontend/no-image-icon.jpg') }}" class="img-sm" alt="Item">
                                                    @endif
                                                </div>
                                                <div class="info">
                                                    <p style="margin-bottom: 5px; font-weight: 600; color:#333;">
                                                        @if ($item->product)
                                                            {{ $item->product->name }}
                                                        @else
                                                            <span class="text-danger">Product Not Available</span>
                                                        @endif
                                                    </p>
                                                    <span class="text-muted" style="font-size: 13px;">
                                                        @if($item->size_name) Size: {{ $item->size_name }} <br> @endif
                                                        @if($item->color_name) Color: {{ $item->color_name }} <br> @endif
                                                        Qty: {{ $item->quantity }}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                <div class="mt-4">
                                    <a href="{{ route('seller.orders.pending.list') }}" class="btn" style="background: #6c757d; color: #fff; border-radius: 4px;">
                                        <i class="fa fa-arrow-left"></i> Back to Orders
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
