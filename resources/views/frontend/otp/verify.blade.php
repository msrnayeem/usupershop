@extends('frontend.layouts.master')
@section('title')
    OTP Verification
@endsection
@section('content')
    <style type="text/css">
        .login-section {
            padding: 100px 0px;
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
            padding: 45px 25px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 4px;
        }
        .logintext{
            margin-bottom: 20px;
            margin-top: 0px;
            font-weight: 700;
        }
        .form-control{
            height: 40px;
            font-size: 16px;
            padding: 10px;
            border-radius: 4px;
            border: 1px solid #ddd;
        }
        .loginBtn{
            background: #007bff;
            color: #fff;
            font-weight: 600;
            font-size: 16px;
            height: 43px;
            outline: none;
            border: 1px solid #007bff;
            transition: all 0.3s ease;
        }
        .loginBtn:hover{
            background: #fff;
            color: #007bff;
        }
        .btn:focus, .btn:active:focus, .btn.active:focus{
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
                font-size:13px;
                display: inline-block;
                margin-top: 10px;
            }

        }
        .form-control.is-invalid {
            border: 1px solid #ff0000;
        }
        .text-danger{
            color: #ff0000;
        }

        @media (max-width: 776px) {
            .login-section {
                padding: 40px 15px;
            }
        }
    </style>


    <div class="container login-section">
        <div class="row">
            <div class="col-xs-12 col-sm-10 col-md-6 col-lg-5 col-xl-4" style="margin: 0 auto; float: none;">
                <div class="card">
                    <div class="card-header">
                        <h3 class="text-center text-info logintext english_lang">OTP Verify</h3>
                            <h3 class="text-center text-info logintext bangla_lang" style="display: none;">ওটিপি যাচাই করুন</h3>
                    </div>
                    <div class="card-body">
                        <form id="login-form" class="form" action="{{ route('verify.store', $id) }}" method="post">
                            @csrf
                            @if (Session::get('warning'))
                                <div class="form-group">
                                    <div class="alert alert-warning text-left alert-dismissible" role="alert">
                                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                                        <strong>{{ Session::get('warning') }}</strong>
                                    </div>
                                </div>
                            @endif
                            <div class="form-group">
                                <div class="alert alert-warning text-left" role="alert">
                                    <strong>* We have sent an OTP to your {{ $deliveryMethod ?? 'email or phone number' }}.</strong> <br>
                                    @if(str_contains($deliveryMethod ?? 'email', 'email'))
                                        <strong>* If you don't receive the email in your inbox, please check your spam folder.</strong>
                                    @endif
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="otp" class="text-info english_lang">Enter OTP <span class="text-danger">*</span></label>
                                <label for="otp" class="text-info bangla_lang" style="display: none;">ওটিপি লিখুন <span class="text-danger">*</span></label>
                                <input type="text" name="otp" id="otp" value="{{ old('otp') }}"
                                    class="form-control @error('otp') is-invalid @enderror" placeholder="Enter OTP" required>
                                @error('otp')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            
                            <div class="form-group" style="margin-top: 10px;">
                                <button style="cursor: pointer;" type="submit" class="btn loginBtn form-control"> Verify Now</button>
                            </div>


                            <div class="form-group text-center">
                                <p for="" style="margin: 0px;">You already have an verified account? 
                                    <a class="english_lang" style="color: #0824ac; font-weight: 700;" href="{{ route('customer.login') }}">Login Now</a>
                                </p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
