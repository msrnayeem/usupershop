@extends('frontend.layouts.master')
@section('title', 'Email Verification | ' . config('app.name'))

@section('meta_description', 'Verify your email securely at ' . config('app.name') . ' to activate your account and
    access your dashboard, orders, and profile safely.')
@section('meta_keywords', 'Email Verification, Verify Email, Customer Account, Account Activation, ' .
    config('app.name'))
@section('meta_author', config('app.name'))

@push('meta')
    {{-- Prevent indexing by search engines --}}
    <meta name="robots" content="noindex, nofollow">

    {{-- Open Graph / Facebook --}}
    <meta property="og:title" content="Email Verification - {{ config('app.name') }}" />
    <meta property="og:description"
        content="Verify your email securely at {{ config('app.name') }} to activate your account and access your dashboard, orders, and profile." />
    <meta property="og:image" content="{{ asset('frontend/images/og-default.jpg') }}" />
    <meta property="og:url" content="{{ url()->current() }}" />
    <meta property="og:type" content="website" />

    {{-- Twitter Card --}}
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Email Verification - {{ config('app.name') }}">
    <meta name="twitter:description"
        content="Verify your email securely at {{ config('app.name') }} to activate your account and access your dashboard, orders, and profile.">
    <meta name="twitter:image" content="{{ asset('frontend/images/og-default.jpg') }}">
@endpush

@section('custom_css')
    <style>
        /* Main Container Styling */
        #login {
            margin-bottom: 5%;
            margin-top: 2%;
        }

        /* Login Box Styling */
        #login-box {
            background: #fff;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            margin-left: 33%;
        }

        /* Form Heading */
        h3.text-center {
            margin-bottom: 25px;
            color: #17a2b8;
            font-weight: bold;
            text-align: center;
        }

        /* Form Labels */
        .form-group label {
            font-weight: 600;
            color: #333;
        }

        /* Input Focus Effect */
        .form-control:focus {
            border-color: #17a2b8;
            box-shadow: none;
        }

        /* Custom Button Styling */
        .btn-custom {
            background-color: #17a2b8;
            color: #fff;
            font-weight: bold;
            border: none;
            padding: 10px;
        }

        .btn-custom:hover {
            background-color: #138496;
        }

        /* Additional Link (Signup) */
        .additional-link {
            margin-top: 15px;
            font-size: 14px;
            color: #555;
            text-align: center;
        }

        .additional-link a {
            color: #17a2b8;
            font-weight: 600;
            text-decoration: none;
        }

        .additional-link a:hover {
            text-decoration: underline;
        }

        /* Alert Styling */
        .alert {
            margin-top: 10px;
            margin-bottom: 20px;
            padding: 10px 15px;
            border-radius: 5px;
            font-size: 15px;
        }

        /* Responsive Adjustments */
        @media (max-width: 767px) {
            #login-box {
                padding: 20px;
            }

            #login-box {
                width: 90%;
                max-width: 400px;
                margin: 0 auto;
                font-size: 14px;
            }

            #login-form {
                margin-top: 120px !important;
            }
        }
    </style>
@endsection
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
                @if (Session::get('success'))
                    <div class="alert alert-success alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                        <strong>{{ Session::get('success') }}</strong>
                    </div>
                @endif
                <div id="login">
                    <div id="login-box">
                        <form id="login-form" action="{{ route('verify.store') }}" method="post">
                            @csrf
                            <h3 class="text-center">Email or Phone Number Verify</h3>

                            <div class="form-group">
                                <label for="context">Email or Phone Number:</label>
                                <input type="text" name="context" id="context" class="form-control"
                                    value="{{ Session::get('verify_context') }}" readonly>
                            </div>

                            <div class="form-group">
                                <label for="code">Verify Code:</label>
                                <input type="text" name="code" id="code" class="form-control">
                                @if ($errors->has('code'))
                                    <small class="text-danger">{{ $errors->first('code') }}</small>
                                @endif
                            </div>

                            <div class="form-group">
                                <input type="submit" class="btn btn-custom btn-block" value="Verify">
                            </div>


                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        $(function() {
            $('#login-form').validate({
                rules: {
                    email: {
                        required: true,
                        email: true,
                    },
                    code: {
                        required: true
                    },
                },
                messages: {
                    email: {
                        required: "Please enter a email address",
                        email: "Please enter a vaild email address"
                    },
                    code: {
                        required: "Please enter your verification code"
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
