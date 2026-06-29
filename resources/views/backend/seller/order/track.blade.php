@extends('backend.seller.seller-master')

@section('title', 'Order Tracking')

@section('custom_css')
    <style>
        .header-item {
            font-size: 13.5px;
            color: #475569;
            line-height: 1.6;
        }
        .header-item strong {
            color: #0f172a;
            font-weight: 700;
        }

        /* Tracking Timeline */
        .track-area {
            padding: 40px 0;
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
            width: 54px;
            height: 54px;
            background: #cbd5e1;
            border-radius: 50%;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #64748b;
            font-size: 20px;
            border: 4px solid #fff;
            position: relative;
            z-index: 3;
            transition: all 0.3s ease;
        }

        .step-item.active .step-icon-box {
            background: #22c55e;
            color: #fff;
            box-shadow: 0 0 0 6px rgba(34, 197, 94, 0.15);
        }
        
        .step-item.completed .step-icon-box {
            background: #22c55e;
            color: #fff;
        }

        .step-text {
            margin-top: 15px;
            color: #475569;
            font-size: 13.5px;
            font-weight: 600;
        }
         
        /* The Gray Line */
        .track-line-bg {
            position: absolute;
            top: 27px;
            left: 8%;
            width: 84%;
            height: 6px;
            background: #e2e8f0;
            z-index: 1;
            transform: translateY(-50%);
        }

        /* The Green Line (Progress) */
        .track-line-progress {
            position: absolute;
            top: 27px;
            left: 8%;
            height: 6px;
            background: #22c55e;
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
                gap: 30px;
            }
            .step-item {
                display: flex;
                align-items: center;
                text-align: left;
                width: auto;
            }
            .step-text {
                margin-top: 0;
                margin-left: 20px;
            }
            .track-line-bg, .track-line-progress {
                left: 47px;
                top: 27px;
                width: 6px;
                height: 100%;
                transform: none;
            }
             .track-line-bg {
                 height: 90%;
             }
             .track-line-progress {
                  height: 0;
                  width: 6px;
              }
        }

        .itemside {
            display: flex;
            align-items: center;
            width: 100%;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            padding: 12px;
            border-radius: 10px;
            gap: 15px;
        }
        .img-sm {
            width: 64px;
            height: 64px;
            object-fit: cover;
            border: 1px solid #cbd5e1;
            border-radius: 8px;
            background: #fff;
        }
    </style>
@endsection

@section('content')
    <div class="content-wrapper">
        {{-- Page Header --}}
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:22px;flex-wrap:wrap;gap:12px;">
            <div>
                <h1 style="font-size:22px;font-weight:800;color:#0f172a;margin:0;">
                    <i class="fas fa-truck-moving" style="color:#6366f1;margin-right:8px;"></i>
                    Consignment Tracker
                </h1>
                <p style="color:#64748b;font-size:13px;margin:2px 0 0;">
                    <a href="{{ route('seller.dashboard') }}" style="color:#6366f1;text-decoration:none;">Dashboard</a>
                    <span style="margin:0 6px;color:#cbd5e1;">/</span>
                    Order Track
                </p>
            </div>
            <a class="btn btn-sm btn-secondary" href="{{ route('seller.orders.pending.list') }}" style="display:inline-flex;align-items:center;gap:6px;padding:9px 18px;border-radius:8px;font-size:13px;font-weight:600;text-decoration:none;">
                <i class="fas fa-arrow-left"></i> Back to Orders
            </a>
        </div>

        <section class="content">
            <div class="container-fluid">
                <div class="card">
                    <div class="card-header" style="background:#f8fafc;border-bottom:1px solid #e2e8f0;">
                        <div class="row">
                            <div class="col-md-3 mb-2">
                                <div class="header-item">
                                    <strong>Invoice No:</strong> <br>
                                    <span class="highlight text-primary font-weight-bold" style="font-family:monospace;">{{ $order->invoice_no }}</span>
                                </div>
                            </div>
                            <div class="col-md-3 mb-2">
                                <div class="header-item">
                                    <strong>Order Date:</strong> <br>
                                    {{ $order->created_at ? \Carbon\Carbon::parse($order->created_at)->setTimezone('Asia/Dhaka')->format('d M Y, h:i A') : 'N/A' }}
                                </div>
                            </div>
                            <div class="col-md-4 mb-2">
                                <div class="header-item">
                                    <strong>Recipient:</strong> <br>
                                    {{ $order->shipping->name }} | {{ $order->shipping->mobile }}
                                </div>
                            </div>
                            <div class="col-md-2 text-md-right mb-2">
                                <div class="header-item">
                                    <strong>Consignment Value:</strong> <br>
                                    <span style="color:#0f172a; font-weight:800; font-size:16px;">৳{{ number_format($order->order_total, 2) }}</span>
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
                                <div class="alert alert-danger text-center border-0" style="border-radius:10px;">
                                    <i class="fa fa-times-circle mr-1"></i> This order has been cancelled and voided.
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
                                                <span>{{ $step['label'] }}</span>
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
                                                    <div style="font-size:11px; color:#64748b; margin-top:5px; font-weight:500;">
                                                        {{ \Carbon\Carbon::parse($order->$timestampField)->format('d M Y, h:i A') }}
                                                    </div>
                                                @elseif($index > $currentStep)
                                                    <div style="font-size:11px; color:#94a3b8; margin-top:5px; font-weight:500;">
                                                        Pending
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>

                        <hr style="margin: 40px 0; border-top:1px solid #e2e8f0;">
                        
                        <!-- Order Items Grid -->
                        <h5 style="font-weight:800;color:#0f172a;font-size:15px;margin-bottom:20px;"><i class="fas fa-boxes text-primary mr-1"></i> Products Ordered</h5>
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
                                            <p style="margin-bottom:4px; font-weight:700; color:#0f172a; font-size:13px;">
                                                @if ($item->product)
                                                    {{ $item->product->name }}
                                                @else
                                                    <span class="text-danger">Product Not Available</span>
                                                @endif
                                            </p>
                                            <span class="text-muted" style="font-size: 12px; font-weight:500; display:block;">
                                                @if($item->size_name) Size: <span class="text-dark font-weight-bold">{{ $item->size_name }}</span> | @endif
                                                @if($item->color_name) Color: <span class="text-dark font-weight-bold">{{ $item->color_name }}</span> | @endif
                                                Qty: <span class="text-dark font-weight-bold">{{ $item->quantity }}</span>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
