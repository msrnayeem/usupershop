@extends('frontend.layouts.master')
@section('title', 'My Dashboard | ' . config('app.name'))

@section('meta_description',
    'Your personal dashboard at ' .
    config('app.name') .
    ' — manage your orders, profile, and
    account settings securely.')
@section('meta_keywords', 'Customer Dashboard, My Account, Orders, Profile, ' . config('app.name'))
@section('meta_author', config('app.name'))

@push('meta')
    {{-- Prevent indexing by search engines --}}
    <meta name="robots" content="noindex, nofollow">

    {{-- Open Graph / Facebook (optional) --}}
    <meta property="og:title" content="My Dashboard - {{ config('app.name') }}" />
    <meta property="og:description"
        content="Manage your orders, profile, and account settings securely at {{ config('app.name') }}." />
    <meta property="og:image" content="{{ asset('frontend/images/og-default.jpg') }}" />
    <meta property="og:url" content="{{ url()->current() }}" />
    <meta property="og:type" content="website" />

    {{-- Twitter Card (optional) --}}
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="My Dashboard - {{ config('app.name') }}">
    <meta name="twitter:description"
        content="Manage your orders, profile, and account settings securely at {{ config('app.name') }}.">
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
    </style>
    <!-- Title page -->
    {{-- <section class="bg-img1 txt-center p-lr-15 p-tb-92" style="background-image: url('frontend/images/bg-01.jpg');">
        <h2 class="ltext-105 cl0 txt-center">My Profile</h2>
    </section> --}}
    <div class="container">
        <div class="row" style="padding: 70px 0px 70px 0px;">
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
                <div class="row">
                    <div class="col-md-2"></div>
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-body">
                                <div class="img-circle text-center">
                                    <img src="{{ !empty($user->image) ? url('public/upload/user_images/' . $user->image) : url('upload/profile.jpg') }}"
                                        alt="" style="width: 130px;height:130px;border-radius:50%">
                                </div>
                                <h3 class="text-center">{{ $user->name }}</h3>
                                <p class="text-center">{{ $user->address }}</p>
                                <br>
                                <table class="table table-bordered">
                                    <tbody>
                                        <tr>
                                            <td>Phone No</td>
                                            <td>{{ $user->mobile }}</td>
                                        </tr>
                                        <tr>
                                            <td>Email</td>
                                            <td>{{ $user->email }}</td>
                                        </tr>
                                        <tr>
                                            <td>Gender</td>
                                            <td>{{ $user->gender }}</td>
                                        </tr>
                                        <tr>
                                            <td>Created Date</td>
                                            <td>{{ $user->created_at }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                                <a class="btn btn-primary btn-block" href="{{ route('customer.edit.profile') }}">Edit
                                    Profile</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
