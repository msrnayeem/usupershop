@extends('frontend.layouts.master')
@section('title', 'Edit Profile | ' . config('app.name'))

@section('meta_description', 'Edit your profile securely at ' . config('app.name') . ' — update your personal
    information, password, and account details safely.')
@section('meta_keywords', 'Edit Profile, Customer Account, My Account, Update Information, ' . config('app.name'))
@section('meta_author', config('app.name'))

@push('meta')
    {{-- Prevent indexing by search engines --}}
    <meta name="robots" content="noindex, nofollow">

    {{-- Open Graph / Facebook --}}
    <meta property="og:title" content="Edit Profile - {{ config('app.name') }}" />
    <meta property="og:description"
        content="Update your personal information and account details securely at {{ config('app.name') }}." />
    <meta property="og:image" content="{{ asset('frontend/images/og-default.jpg') }}" />
    <meta property="og:url" content="{{ url()->current() }}" />
    <meta property="og:type" content="website" />

    {{-- Twitter Card --}}
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Edit Profile - {{ config('app.name') }}">
    <meta name="twitter:description"
        content="Update your personal information and account details securely at {{ config('app.name') }}.">
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
        <h2 class="ltext-105 cl0 txt-center">Edit Profile</h2>
    </section> --}}
    <div class="container">
        <div class="row" style="padding: 50px 0px 50px 0px;">
            <div class="col-md-2">
                <ul class="prof">
                    <li><a href="{{ route('dashboard') }}">My Profile</a></li>
                    <li><a href="{{ route('customer.password.change') }}">Password Change</a></li>
                    <li><a href="">My Orders</a></li>
                </ul>
            </div>
            <div class="col-md-10">
                <h4>Profile History Edit</h4>
                <hr>
                <form action="{{ route('customer.update.profile') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-4">
                            <label for="name">Full Name :</label>
                            <input type="text" name="name" value="{{ $editData->name }}" id="name"
                                class="form-control">
                            <font color="red">{{ $errors->has('name') ? $errors->first('name') : '' }}</font>
                        </div>
                        <div class="col-md-4">
                            <label for="email">Email :</label>
                            <input type="email" name="email" value="{{ $editData->email }}" id="email"
                                class="form-control" readonly>
                            <font color="red">{{ $errors->has('email') ? $errors->first('email') : '' }}</font>
                        </div>
                        <div class="col-md-4">
                            <label for="mobile">Phone No :</label>
                            <input type="text" name="mobile" value="{{ $editData->mobile }}" id="mobile"
                                class="form-control" readonly>
                            <font color="red">{{ $errors->has('mobile') ? $errors->first('mobile') : '' }}</font>
                        </div>
                        <div class="col-md-4">
                            <label for="address">Address :</label>
                            <input type="text" name="address" value="{{ $editData->address }}" id="address"
                                class="form-control">
                            <font color="red">{{ $errors->has('address') ? $errors->first('address') : '' }}</font>
                        </div>
                        <div class="col-md-4">
                            <label for="gender">Gender :</label>
                            <select name="gender" id="gender" class="form-control" id="gender">
                                <option value="">Select Gender</option>
                                <option value="Male" {{ $editData->gender == 'Male' ? 'selected' : '' }}>
                                    Male</option>
                                <option value="Female" {{ $editData->gender == 'Female' ? 'selected' : '' }}>
                                    Female
                                </option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="image">Image :</label>
                            <input type="file" name="image" id="image" class="form-control">
                        </div>
                        <div class="col-md-2">
                            <img id="showImage" style="width: 100px;height:110px; border:1px solid #000"
                                src="{{ !empty($editData->image) ? url('public/upload/user_images/' . $editData->image) : url('public/upload/profile.jpg') }}">
                        </div>
                        <div class="col-md-4" style="padding-top:30px;">
                            <button type="submit" class="btn btn-primary">Edit Profile</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
