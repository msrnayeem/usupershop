@extends('frontend.layouts.seller_master')
@section('title')
    Customer Order
@endsection
@section('content')
    <style type="text/css">
        .prof li {
            background: #1781BF;
            padding: 7px;
            margin: 3px;
            border-radius: 15px;
        }

        .prof li a {
            color: #fff;
            padding-left: 15px;
        }

        .btn-primary {
            line-height: none;
            background: #66ad44;
        }
    </style>
    <!-- Title page -->
    {{-- <section class="bg-img1 txt-center p-lr-15 p-tb-92" style="background-image: url('frontend/images/bg-01.jpg');">
        <h2 class="ltext-105 cl0 txt-center">My Orders</h2>
    </section> --}}
    <div class="container">
        <div class="row" style="padding: 50px 0px 30px 0px;">
            <div class="col-md-2">
                <ul class="prof">
                    <li><a href="{{ route('seller.customer.dashboard') }}">My Profile</a></li>
                    <li><a href="{{ route('seller.customer.password.change') }}">Password Change</a></li>
                    <li><a href="{{ route('seller.customer.order.list') }}">My Orders</a></li>
                </ul>
            </div>
            <div class="col-md-10">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th width="6%">S.N</th>
                            <th>Order No</th>
                            <th>Total Amount</th>
                            <th>Payment Type</th>
                            <th>Status</th>
                            <th width="12%">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orders as $key => $order)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>#{{ $order->order_no }}</td>
                                <td>{{ $order->order_total }} Tk.</td>
                                <td>
                                    {{ $order['payment']['payment_method'] }}
                                    @if ($order['payment']['payment_method'] == 'Bkash')
                                        [ Transaction ID : {{ $order['payment']['transaction_no'] }} ]
                                    @endif
                                </td>
                                <td>
                                    @if ($order->status == 0)
                                        <span
                                            style="background:#DD4F42;color: #fff;padding:5px 8px;border-radius:3px;">Pending</span>
                                    @else
                                        <span
                                            style="background:#1BA160;color: #fff;padding:5px 8px;border-radius:3px;">Approved</span>
                                    @endif
                                </td>
                                <td>
                                    <div style="display: flex; gap: 5px; justify-content: center;">
                                        <a href="{{ route('seller.customer.order.details', $order->id) }}"
                                            class="btn btn-primary btn-sm"><i class="fa fa-eye"></i> Details</a>
                                        <a href="{{ route('order.track', $order->id) }}" class="btn btn-info btn-sm"><i
                                                class="fa fa-map-marker" aria-hidden="true"></i> Track</a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
