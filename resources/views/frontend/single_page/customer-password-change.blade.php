@extends('frontend.layouts.master')
@section('title', 'Change Password | ' . config('app.name'))

@section('meta_description', 'Change your account password securely at ' . config('app.name') . ' — update your password
    to keep your account safe.')
@section('meta_keywords', 'Change Password, Update Password, Customer Account, Secure Account, ' . config('app.name'))
@section('meta_author', config('app.name'))

@push('meta')
    {{-- Prevent indexing by search engines --}}
    <meta name="robots" content="noindex, nofollow">

    {{-- Open Graph / Facebook --}}
    <meta property="og:title" content="Change Password - {{ config('app.name') }}" />
    <meta property="og:description"
        content="Update your password securely at {{ config('app.name') }} to keep your account safe." />
    <meta property="og:image" content="{{ asset('frontend/images/og-default.jpg') }}" />
    <meta property="og:url" content="{{ url()->current() }}" />
    <meta property="og:type" content="website" />

    {{-- Twitter Card --}}
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Change Password - {{ config('app.name') }}">
    <meta name="twitter:description"
        content="Update your password securely at {{ config('app.name') }} to keep your account safe.">
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
        <h2 class="ltext-105 cl0 txt-center">Password Change</h2>
    </section> --}}
    <div class="container">
        <div class="row" style="padding: 70px 0px 70px 0px;">
            <div class="col-md-2">
                <ul class="prof">
                    <li><a href="{{ route('dashboard') }}">My Profile</a></li>
                    <li><a href="{{ route('customer.password.change') }}">Password Change</a></li>
                    <li><a href="{{ route('customer.order.list') }}">My Orders</a></li>
                </ul>
            </div>
            <div class="col-md-10">
                <h4>Password Change</h4>
                <hr>
                <div class="panel">
                    <div class="panel-body">
                        <form method="post" action="{{ route('customer.password.update') }}" id="myForm">
                            @csrf
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label for="current_password">Current Password</label>
                                    <input type="password" name="current_password" class="form-control"
                                        id="current_password">
                                </div>

                                <div class="form-group col-md-4">
                                    <label for="new_password">New Password</label>
                                    <input type="password" name="new_password" class="form-control" id="new_password">
                                </div>

                                <div class="form-group col-md-4">
                                    <label for="again_new_password">Again New Password</label>
                                    <input type="password" name="again_new_password" class="form-control">
                                </div>

                                <div class="form-group col-md-6">
                                    <input type="submit" value="Password Update" class="btn btn-primary"
                                        style="cursor: pointer">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script type="text/javascript">
        $(function() {
            $('#myForm').validate({
                rules: {
                    current_password: {
                        required: true,
                    },
                    new_password: {
                        required: true,
                        minlength: 6
                    },
                    again_new_password: {
                        required: true,
                        equalTo: '#new_password'
                    },
                },
                messages: {
                    current_password: {
                        required: "Please provide current password",
                    },
                    new_password: {
                        required: "Please provide new password",
                        minlength: "Your password must be at least 6 characters long"
                    },
                    again_new_password: {
                        required: "Please enter new confirm password",
                        equalTo: "Confirm new password does not match"
                    }
                },
                errorElement: 'span',
                errorPlacement: function(error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.form-group').append(error);
                },
                highlight: function(element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                }
            });
        });
    </script>
@endsection
