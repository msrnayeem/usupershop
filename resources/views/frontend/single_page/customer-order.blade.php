@extends('frontend.layouts.master')
@section('title', 'My Orders | ' . config('app.name'))

@section('meta_description', 'View all your orders securely at ' . config('app.name') . ' — track status, check order
    history, and manage your purchases safely.')
@section('meta_keywords', 'My Orders, Order History, Customer Account, Track Orders, ' . config('app.name'))
@section('meta_author', config('app.name'))

@push('meta')
    {{-- Prevent indexing by search engines --}}
    <meta name="robots" content="noindex, nofollow">

    {{-- Open Graph / Facebook --}}
    <meta property="og:title" content="My Orders - {{ config('app.name') }}" />
    <meta property="og:description"
        content="Securely view all your orders at {{ config('app.name') }}. Track status and manage your purchases safely." />
    <meta property="og:image" content="{{ asset('frontend/images/og-default.jpg') }}" />
    <meta property="og:url" content="{{ url()->current() }}" />
    <meta property="og:type" content="website" />

    {{-- Twitter Card --}}
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="My Orders - {{ config('app.name') }}">
    <meta name="twitter:description"
        content="Securely view all your orders at {{ config('app.name') }}. Track status and manage your purchases safely.">
    <meta name="twitter:image" content="{{ asset('frontend/images/og-default.jpg') }}">
@endpush

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

        .table>thead>tr>th,
        .table>tbody>tr>th,
        .table>tfoot>tr>th,
        .table>thead>tr>td,
        .table>tbody>tr>td,
        .table>tfoot>tr>td {
            vertical-align: middle;
        }

        @media (min-width: 350px) and (max-width: 590px) {
            table {
                width: 100%;
                overflow-x: auto;
                display: block;
            }
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
                    <li><a href="{{ route('dashboard') }}">My Profile</a></li>
                    <li><a href="{{ route('customer.password.change') }}">Password Change</a></li>
                    <li><a href="{{ route('customer.order.list') }}">My Orders</a></li>
                    <li><a href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();">Logout</a>
                    </li>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </ul>

            </div>
            <div class="col-md-10">
                <table class="table table-bordered table-responsive">
                    <thead>
                        <tr>
                            <th class="text-center" width="30px">S.N</th>
                            <th>Order No</th>
                            <th class="text-center">Total Amount</th>
                            <th class="text-center">Payment Type</th>
                            <th class="text-center">Status</th>
                            <th class="text-center" width="160px">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($orders as $key => $order)
                            <tr>
                                <td class="text-center">{{ $key + 1 }}</td>
                                <td>#{{ $order->order_no }}</td>
                                <td class="text-center">{{ $order->order_total }} Tk.</td>
                                <td class="text-center">
                                    {{ $order['payment']['payment_method'] }}
                                    @if ($order['payment']['payment_method'] == 'Bkash')
                                        [ Transaction ID : {{ $order['payment']['transaction_no'] }} ]
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if ($order->status === 'return')
                                        <button type="button" class="btn btn-sm btn-warning">Return</button>
                                    @elseif ($order->status === 'confirmed')
                                        <button type="button" class="btn btn-sm btn-primary">Confirmed</button>
                                    @elseif ($order->status === 'canceled')
                                        <button type="button" class="btn btn-sm btn-danger">Canceled</button>
                                    @elseif ($order->status === 'packaging')
                                        <button type="button" class="btn btn-sm btn-secondary">Packaging</button>
                                    @elseif ($order->status === 'delivered')
                                        <button type="button" class="btn btn-sm btn-success">Delivered</button>
                                    @else
                                        <button type="button" class="btn btn-sm btn-info">Pending</button>
                                    @endif

                                </td>
                                <td class="text-center">
                                    <div style="display: flex; gap: 5px; justify-content: center;">
                                        <a style="padding: 4px 9px;" href="{{ route('customer.order.details', $order->id) }}"
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
