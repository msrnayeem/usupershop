@extends('frontend.layouts.seller_master')
@section('title')
    Seller Customer Login
@endsection
@section('content')
    <style type="text/css">
        #login .container #login-row #login-column #login-box {
            max-width: 600px;
            /* height: 320px; */
            border: 1px solid #9C9C9C;
            background-color: #EAEAEA;
            margin-bottom: 70px;
            margin-top: 70px;
            padding-bottom: 30px;
        }

        .social-auth-links {
            padding: 0px 20px 20px 20px;
        }

        #login .container #login-row #login-column #login-box #login-form {
            padding: 20px 20px 0 20px;
        }

        #login .container #login-row #login-column #login-box #login-form #register-link {
            margin-top: -85px;
        }

        .signup-link {
            background: red;
            padding: 5px;
            color: #fff;
        }
       
        @media (max-width: 489px) {
            #login-form {
                width: 100%;
                padding: 10px;
            }
            #login-form label,
            #login-form input {
                font-size: 14px;
            }
            #login-form .btn {
                font-size: 14px;
                padding: 8px;

            }
            .forgetBtn {
                margin-top: 10px;
            }
            .signup-link {
                font-size: 13px;
            }
        }
        @media (max-width: 430px) {
            #login-form {
                width: 100%;
                padding: 10px;
            }
            #login-form label,
            #login-form input {
                font-size: 14px;
            }
            #login-form .btn {
                font-size: 14px;
                padding: 8px;

            }
            .forgetBtn {
                margin-top: 10px;
            }
            .signup-link {
                font-size: 13px;
            }
        }
        @media (max-width: 589px) {
            #login-form {
                width: 100%;
                padding: 10px;
            }
            #login-form label,
            #login-form input {
                font-size: 14px;
            }
            #login-form .btn {
                font-size: 14px;
                padding: 8px;

            }
            .forgetBtn {
                margin-top: 10px;
            }
            .signup-link {
                font-size: 13px;
            }
        } 
    </style>
    <!-- Title page -->
    <!-- <section class="bg-img1 txt-center p-lr-15 p-tb-92" style="background-image: url('frontend/images/bg-01.jpg');">
            <h2 class="ltext-105 cl0 txt-center">Customer Login</h2>
        </section> -->
    <div id="login">
        <div class="container">
            <div id="login-row" class="row justify-content-center align-items-center">
                <div class="col-md-3">
                </div>
                <div id="login-column" class="col-md-6">
                    <div id="login-box" class="col-md-12">
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
                            @csrf
                            <h3 class="text-center text-info english_lang">Login</h3>
                            <h3 class="text-center text-info bangla_lang" style="display: none;">লগইন</h3>
                            <div class="form-group">
                                <label for="email" class="text-info english_lang">Email Or Phone Number :</label>
                                <label for="email" class="text-info bangla_lang" style="display: none;">ইমেইল অথবা ফোন নম্বর:</label>
                                <br>
                                <input type="text" name="content" id="content" class="form-control"
                                    placeholder="Customer Email or phone number">
                            </div>
                            <div class="form-group">
                                <label for="password" class="text-info english_lang">Password :</label>
                                <label for="password" class="text-info bangla_lang" style="display: none;">পাসওয়ার্ড :</label>
                                <br>
                                <input type="password" name="password" id="password" class="form-control"
                                    placeholder="Password...">
                            </div>
                            <div class="form-group">
                                <input style="cursor: pointer;" type="submit" class="btn btn-info btn-md" value="Login">
                                <i class="fa fa-user"></i> No account yet ?  <a class="signup-link english_lang"
                                href="{{ route('customer.signup') }}">
                                Create
                                new account
                            </a>
                            <a class="signup-link bangla_lang"  style="display: none;"
                                href="{{ route('customer.signup') }}">
                                নতুন অ্যাকাউন্ট তৈরি করুন
                            </a>
                            <a href="{{ route('forget.email') }}" style="cursor: pointer;"
                            class="forgetBtn btn btn-info btn-md text-right english_lang">
                            Forget Password
                        </a>
                        <a href="{{ route('forget.email') }}" style="cursor: pointer;display: none;"
                        class="forgetBtn btn btn-info btn-md text-right bangla_lang">
                        পাসওয়ার্ড ভুলে গেছেন 
                    </a>

                            </div>
                        </form>

                        <div class="social-auth-links text-center mb-3">
                            <p>- OR -</p>

                            <a href="{{ route('login.google') }}" class="btn btn-block btn-danger">
                                <i class="fa fa-google-plus mr-2"></i> Sign in using Google
                            </a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
