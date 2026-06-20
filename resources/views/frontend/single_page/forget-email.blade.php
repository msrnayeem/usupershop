@extends('frontend.layouts.master')
@section('title', 'Forgot Password | ' . config('app.name'))

@section('meta_description', 'Reset your password securely at ' . config('app.name') . ' — enter your email to receive
    password reset instructions and access your account safely.')
@section('meta_keywords', 'Forgot Password, Password Reset, Customer Account, Account Recovery, ' . config('app.name'))
@section('meta_author', config('app.name'))

@push('meta')
    {{-- Prevent indexing by search engines --}}
    <meta name="robots" content="noindex, nofollow">

    {{-- Open Graph / Facebook --}}
    <meta property="og:title" content="Forgot Password - {{ config('app.name') }}" />
    <meta property="og:description"
        content="Reset your password securely at {{ config('app.name') }} — receive instructions to access your account safely." />
    <meta property="og:image" content="{{ asset('frontend/images/og-default.jpg') }}" />
    <meta property="og:url" content="{{ url()->current() }}" />
    <meta property="og:type" content="website" />

    {{-- Twitter Card --}}
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Forgot Password - {{ config('app.name') }}">
    <meta name="twitter:description"
        content="Reset your password securely at {{ config('app.name') }} — receive instructions to access your account safely.">
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
                        <h3 class="text-center logintext">Forget Password</h3>
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
                        <form class="form" action="{{ route('forget.email_verify') }}" method="post">
                            @csrf

                            <div class="form-group">
                                <label for="content" class="text-info">Email / Phone Number <span
                                        class="text-danger">*</span></label>
                                <input type="text" name="content" id="content" class="form-control"
                                    placeholder="Enter Email / Phone...">
                                @error('content')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <input style="cursor: pointer;" type="submit" class="btn loginBtn btn-block"
                                    value="Forget Now">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
