@extends('frontend.layouts.master')
@section('title', 'Login | ' . config('app.name'))

@section('meta_description',
    'Secure login to your account at ' .
    config('app.name') .
    ' — access your dashboard,
    orders, and profile safely.')
@section('meta_keywords', 'Login, Customer Login, My Account, Secure Login, ' . config('app.name'))
@section('meta_author', config('app.name'))

@push('meta')
    {{-- Prevent indexing by search engines --}}
    <meta name="robots" content="noindex, nofollow">

    {{-- Open Graph / Facebook --}}
    <meta property="og:title" content="Login - {{ config('app.name') }}" />
    <meta property="og:description"
        content="Secure login to your account at {{ config('app.name') }} — access your dashboard, orders, and profile safely." />
    <meta property="og:image" content="{{ asset('frontend/images/og-default.jpg') }}" />
    <meta property="og:url" content="{{ url()->current() }}" />
    <meta property="og:type" content="website" />

    {{-- Twitter Card --}}
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Login - {{ config('app.name') }}">
    <meta name="twitter:description"
        content="Secure login to your account at {{ config('app.name') }} — access your dashboard, orders, and profile safely.">
    <meta name="twitter:image" content="{{ asset('frontend/images/og-default.jpg') }}">
@endpush

@section('content')
    <style type="text/css">
        .login-section {
            padding: 70px 0px;
        }

        .social-auth-links {
            padding: 0px 20px 20px 20px;
        }

        .signup-link {
            background: red;
            padding: 5px;
            color: #fff;
        }

        .forgetBtn {
            float: right;
        }

        .card {
            border: 1px solid #ddd;
            padding: 35px 25px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 4px;
        }

        .logintext {
            margin-bottom: 20px;
            margin-top: 0px;
            font-weight: 700;
        }

        .form-control {
            height: 40px;
            font-size: 16px;
            padding: 10px;
            border-radius: 4px;
            border: 1px solid #ddd;
        }

        .loginBtn {
            background: #007bff;
            color: #fff;
            font-weight: 600;
            font-size: 16px;
            height: 43px;
            outline: none;
            border: 1px solid #007bff;
            transition: all 0.3s ease;
        }

        .loginBtn:hover {
            background: #fff;
            color: #007bff;
        }

        .btn:focus,
        .btn:active:focus,
        .btn.active:focus {
            outline: none;
        }

        @media (max-width: 786px) {
            .login-section {
                padding-right: 15px;
                padding-left: 15px;
                margin: 80px auto;
            }

            .login-form {
                width: 100%;
                padding: 10px;
                margin: 0;
            }

            .login-form label,
            .login-form input {
                font-size: 14px;
                margin-top: 3%;
            }

            .login-form .btn {
                font-size: 14px;
                padding: 8px;
            }

            .forgetBtn {
                margin-top: 10px;
                display: block;
                float: right;
            }

            .signup-link {
                font-size: 11px;
                display: inline-block;
                margin-top: 10px;
            }

        }
    </style>


    <div class="container login-section">
        <div class="row">
            <div class="col-xs-12 col-sm-10 col-md-6 col-lg-5 col-xl-4" style="margin: 0 auto; float: none;">
                <div class="card">
                    <div class="card-header">
                        <h3 class="text-center text-info logintext english_lang">Login Here</h3>
                        <h3 class="text-center text-info logintext bangla_lang" style="display: none;">লগইন</h3>
                    </div>
                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                @foreach ($errors->all() as $error)
                                    <strong>{{ $error }}</strong></br>
                                @endforeach
                            </div>
                        @endif
                        @if (Session::get('message'))
                            <div class="alert alert-warning alert-dismissible" role="alert">
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                <strong>{{ Session::get('message') }}</strong>
                            </div>
                        @endif
                        <form id="login-form" class="form" action="{{ route('userlogin') }}" method="post">

                            @csrf

                            <div class="form-group">
                                <label for="email" class="text-info english_lang">Email / Phone <span
                                        class="text-danger">*</span></label>
                                <label for="email" class="text-info bangla_lang" style="display: none;">ইমেইল/ ফোন নম্বর
                                    <span class="text-danger">*</span></label>
                                <input type="text" name="content" id="content" class="form-control"
                                    placeholder="Enter Email or Phone">
                            </div>

                            <div class="form-group" style="margin-bottom: 5px; position: relative;">
                                <label for="password" class="text-info english_lang">Password <span
                                        class="text-danger">*</span></label>
                                <label for="password" class="text-info bangla_lang" style="display: none;">পাসওয়ার্ড <span
                                        class="text-danger">*</span></label>

                                <input type="password" name="password" id="password" class="form-control"
                                    placeholder="Enter Password">
                                <span class="fa fa-eye toggle-password"
                                    style="position: absolute; top: 38px; right: 10px; cursor: pointer; color: #555;"></span>
                            </div>


                            <div class="form-check text-left">
                                <input type="checkbox" class="form-check-input" id="remember" name="remember">
                                <label class="form-check-label english_lang" for="remember">Remember Me</label>
                                <label class="form-check-label bangla_lang" for="remember" style="display: none;">আমাকে মনে
                                    রাখুন</label>

                            </div>
                            <div class="form-group" style="margin-top: 10px;">
                                <button style="cursor: pointer;" type="submit" class="btn loginBtn form-control"> Login
                                    Now</button>
                            </div>
                        </form>

                        <div class="form-group text-center">
                            <p for="" style="margin: 0px;">You don't have any account?
                                <a class="english_lang" style="color: #0824ac; font-weight: 700;"
                                    href="{{ route('customer.signup') }}">Create account</a>
                                <a class="bangla_lang" style="display: none; color: #0824ac; font-weight: 700;"
                                    href="{{ route('customer.signup') }}">অ্যাকাউন্ট তৈরি</a>
                            </p>
                            <p for="">Have you Forget password?
                                <a href="{{ route('forget.email') }}" style="color: #0824ac; font-weight: 700;"
                                    class="english_lang">
                                    Forget Now
                                </a>
                                <a href="{{ route('forget.email') }}"
                                    style="color: #0824ac; font-weight: 700;display: none;" class="bangla_lang">
                                    মনে করুন
                                </a>
                            </p>
                        </div>

                        <p class="text-center">- OR -</p>


                        <div class="form-group text-center mb-3">

                            <a href="{{ route('login.google') }}" class="btn btn-block btn-danger"
                                style="height: 40px; font-size: 15px; font-weight: 600; line-height: 28px;">
                                <i class="fa fa-google-plus mr-2"></i> Sign In With Google
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@push('custom_script')
    <script>
        $(document).ready(function() {
            $('.toggle-password').on('click', function() {
                var $icon = $(this);
                var $password = $('#password');
                var isPassword = $password.attr('type') === 'password';

                // Clone and replace input to safely change type
                var $newInput = $password.clone();
                $newInput.attr('type', isPassword ? 'text' : 'password');
                $password.replaceWith($newInput);

                // Update reference to the new input
                $password = $newInput;

                // Toggle the icon and color
                $icon.toggleClass('fa-eye fa-eye-slash');
                $icon.css('color', isPassword ? '#007bff' : '#555');
            });
        });
    </script>
@endpush
