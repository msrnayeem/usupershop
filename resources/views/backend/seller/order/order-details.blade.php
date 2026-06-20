@extends('backend.seller.seller-master')

@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h5 class="m-0"><i class='fas fa-hand-point-right'></i> Manage Delivered Orders</h5>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('seller.dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active">Delivered Orders</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.content-header -->

        @php
            $footercontent = Helper::getfootercontacts();
        @endphp

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card card-success card-outline">
                            <div class="card-header">
                                <h3 class="card-title">Delivered Order Details</h3>
                                <a class="btn btn-sm btn-secondary float-right"
                                    href="{{ route('seller.orders.approved.list') }}">
                                    <i class="fas fa-list"></i> Delivered Orders List
                                </a>
                            </div>

                            <div class="card-body">
                                <style>
                                    @media (max-width: 768px) {
                                        .myTable {
                                            display: block;
                                            border: none !important;
                                        }
                                        .myTable tr {
                                            display: flex;
                                            flex-direction: column;
                                            width: 100%;
                                            border: 1px solid #dee2e6;
                                            margin-bottom: 12px;
                                            border-radius: 8px;
                                            overflow: hidden;
                                        }
                                        .myTable td {
                                            display: block;
                                            width: 100% !important;
                                            padding: 10px !important;
                                            text-align: center !important;
                                            border: none !important;
                                            border-bottom: 1px solid #f0f0f0 !important;
                                        }
                                        .myTable td:last-child {
                                            border-bottom: none !important;
                                        }
                                        .myTable img {
                                            max-width: 130px !important;
                                            margin: 0 auto;
                                        }

                                        /* Compact Header Layout */
                                        .myTable tr:first-child {
                                            flex-direction: row !important;
                                            flex-wrap: wrap;
                                            margin-bottom: 8px;
                                        }
                                        .myTable tr:first-child td:nth-child(1) {
                                            width: 50% !important;
                                            border-right: 1px solid #f0f0f0 !important;
                                            padding: 8px !important;
                                        }
                                        .myTable tr:first-child td:nth-child(3) {
                                            width: 50% !important;
                                            padding: 8px !important;
                                            display: flex;
                                            flex-direction: column;
                                            justify-content: center;
                                            font-size: 0.85rem;
                                        }
                                        .myTable tr:first-child td:nth-child(2) {
                                            width: 100% !important;
                                            order: 3;
                                            padding: 6px !important;
                                            background: #fcfcfc;
                                            font-size: 0.85rem;
                                        }
                                        
                                        .myTable tr:nth-child(2) {
                                            margin-bottom: 8px;
                                        }
                                        .myTable tr:nth-child(2) td:first-child {
                                            background: #f8f9fa;
                                            font-weight: bold;
                                            padding: 6px !important;
                                            font-size: 0.9rem;
                                        }
                                        .myTable tr:nth-child(2) td:last-child {
                                            text-align: left !important;
                                            padding: 10px !important;
                                            font-size: 0.9rem;
                                        }
                                        .myTable tr:nth-child(2) td:last-child strong {
                                            display: block;
                                            margin-top: 6px;
                                            color: #444;
                                        }
                                        .myTable tr:nth-child(2) td:last-child strong:first-child {
                                            margin-top: 0;
                                        }

                                        /* Product table specific adjustments */
                                        .myTable tr:nth-child(n+5) {
                                            margin-bottom: 15px;
                                        }
                                        .myTable tr:nth-child(n+5) td {
                                            text-align: left !important;
                                            display: flex;
                                            flex-direction: column;
                                            align-items: flex-start;
                                            gap: 4px;
                                            padding: 8px 12px !important;
                                        }
                                        .myTable tr:nth-child(n+5) td::before {
                                            content: attr(data-label);
                                            font-weight: bold;
                                            color: #1781BF;
                                            font-size: 0.75rem;
                                            text-transform: uppercase;
                                        }
                                        .myTable tr:nth-child(n+5) td:first-child::before {
                                            display: none;
                                        }
                                        .myTable tr:nth-child(3) {
                                            background: #f8f9fa;
                                            font-weight: bold;
                                            color: #1781BF;
                                            margin-bottom: 2px;
                                        }
                                        .myTable tr:nth-child(3) td {
                                            padding: 6px !important;
                                        }
                                        .myTable tr:nth-child(4) {
                                            display: none;
                                        }
                                        
                                        /* Fix for subtotal/grand total rows */
                                        .myTable tr:nth-last-child(-n+4) {
                                            flex-direction: row;
                                            justify-content: space-between;
                                            margin-bottom: 0;
                                            border-radius: 0;
                                            border-top: none;
                                        }
                                        .myTable tr:nth-last-child(-n+4) td {
                                            width: auto !important;
                                            border: none !important;
                                            padding: 8px !important;
                                        }
                                    }
                                </style>
                                <table class="text-center myTable" border="1" width="100%">
                                    <tr>
                                        <td width="30%">
                                            <img src="{{ asset('frontend/assets/images/12345.png') }}" 
                                            style="color:blue;width:100%;max-width:220px;"
                                                alt="{{ $logo->name ?? '' }}">
                                        </td>
                                        <td width="40%">
                                            <span><strong>Mobile No : </strong>{{ $footercontent->mobile ?? ''}}</span><br>
                                            <span><strong>Email : </strong> {{ $footercontent->email ?? '' }}</span><br>
                                            <span>{{ $footercontent->address ?? ''  }}</span>
                                        </td>
                                        <td width="30%">
                                            <?php if(!empty($order->shop_id)){?>
                                            <strong>Shop ID : {{ $order->shop_id }}</strong> </br>
                                            <?php } ?>
                                            <strong>Order No : ODR-#{{ $order->order_no }}</strong>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><strong>Billing/Shipping Info :</strong></td>
                                        <td colspan="2">
                                            <strong>Name : </strong> {{ $order['shipping']['name'] }}
                                            &nbsp;&nbsp;&nbsp;&nbsp;
                                            <strong>Mobile No : </strong> {{ $order['shipping']['mobile'] }}
                                            &nbsp;&nbsp;&nbsp;&nbsp;
                                            <strong>Email : </strong> {{ $order['shipping']['email'] }}
                                            &nbsp;&nbsp;&nbsp;&nbsp;
                                            <strong>Address : </strong> {{ $order['shipping']['address'] }}
                                            &nbsp;&nbsp;&nbsp;&nbsp;
                                            <strong>Payment Method : </strong>
                                            {{ $order['payment']['payment_method'] }}
                                           
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="3"><strong>Order Details</strong></td>
                                    </tr>
                                    <tr>
                                        <td><strong>Product name & Image</strong></td>
                                        <td><strong>Color & Size</strong></td>
                                        <td><strong>Quantity & Price</strong></td>
                                    </tr>
                                    @php
                                    $subtotal = 0;
                                @endphp
                                
                                @foreach ($order->order_details as $details)
                                    <tr>
                                        <td data-label="Product" style="text-align: left;">
                                            @if ($details->product)
                                                <img style="width: 50px;height:30px; border: 1px solid #000;background: #fff;padding: 3px;margin: 3px;"
                                                    src="{{ url('upload/product_images/' . $details->product->image) }}" alt="Product Image">
                                                &nbsp;
                                                {{ $details->product->name }}
                                            @else
                                                No product information available
                                            @endif
                                        </td>
                                        <td data-label="Color & Size">
                                            {{ $details->color_name ?? 'N/A' }} & {{ $details->size_name ?? 'N/A' }}
                                        </td>
                                        <td data-label="Qty & Price">
                                            @if ($details->product)
                                                @php
                                                    $item_price = $details->sell_price;
                                                    $item_total = $details->quantity * $item_price;
                                                    $subtotal += $item_total;
                                                @endphp
                                                {{ $details->quantity }} X {{ $item_price }} = {{ $item_total }} Tk.
                                            @else
                                                0 Tk.
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                                
                                <tr>
                                    <td colspan="2" style="text-align: right;"><strong>Sub Total : </strong></td>
                                    <td><strong>{{ $subtotal }} Tk.</strong></td>
                                </tr>
                                
                                @if ($order->coupon_discount != null)
                                    <tr>
                                        <td colspan="2" style="text-align: right;">Coupon Discount : </td>
                                        <td>{{ $order->coupon_discount }} Tk.</td>
                                    </tr>
                                @endif
                                
                                <tr>
                                    <td colspan="2" style="text-align: right;">Delivery Charge : </td>
                                    <td>{{ $order->delivery_charge }} Tk.</td>
                                </tr>
                                
                                @php
                                    $grandTotal = round($subtotal - ($order->coupon_discount ?? 0) + $order->delivery_charge);
                                @endphp
                                
                                <tr>
                                    <td colspan="2" style="text-align: right;"><strong>Grand Total : </strong></td>
                                    <td><strong>{{ $grandTotal }} Tk.</strong></td>
                                </tr>
                                
                                </table>
                            </div>
                            <!-- /.card-body -->
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@endsection

@push('styles')
    <style>
        @media print {
            body * {
                visibility: hidden;
            }

            .invoice,
            .invoice * {
                visibility: visible;
            }

            .invoice {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
            }

            .card-header,
            .no-print,
            .content-header,
            .main-sidebar,
            .navbar {
                display: none !important;
            }

            .content-wrapper {
                background: white !important;
                margin: 0 !important;
            }

            body {
                padding: 0 !important;
            }
        }

        .invoice {
            border: 1px solid #dee2e6;
            border-radius: .5rem;
            background: #fff;
        }
/* Better scrollbar on mobile */
        .table-responsive {
            border-radius: 0.5rem;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }

        .table-responsive::-webkit-scrollbar {
            height: 10px;
        }

        .table-responsive::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        .table-responsive::-webkit-scrollbar-thumb {
            background: #c0c0c0;
            border-radius: 10px;
        }

        .table-responsive::-webkit-scrollbar-thumb:hover {
            background: #a8a8a8;
        }
    </style>
@endpush
