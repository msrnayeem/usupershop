@extends('frontend.layouts.master')
@section('title')
    Verify Otp
@endsection
@section('content')
    <style type="text/css">
        #login .container #login-row #login-column #login-box {
            max-width: 600px;
            border: 1px solid #9C9C9C;
            background-color: #fff;
            margin-bottom: 70px;
            margin-top: 70px;
            padding-bottom: 30px;
            border-radius: 6px;
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
    </style>
    <!-- Title page -->

    <div id="login">
        <div class="container">
            <div id="login-row" class="row">
                <div id="login-column" class="col-12 col-sm-6 col-md-4" style="margin: auto; float: inherit;">
                    <div id="login-box" style="margin-left: auto; margin-right: auto;">
                        <form id="login-form" class="form" action="{{ route('forget.verify.otp') }}" method="post">
                            @csrf
                            <h3 class="text-center text-info" style="font-weight: 600; margin-bottom: 20px;">Verify OTP</h3>

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

                            <div class="form-group mb-3">
                                <label for="context" class="form-labrl text-info">Email or Phone Number <span
                                        class="text-danger">*</span></label><br>
                                <input type="text" name="context" id="context" class="form-control"
                                    value="{{ Session::get('verify_content') }}" readonly
                                    placeholder="Customer email or phone number..">
                            </div>
                            <div class="form-group mb-3">
                                <label for="otp" class="text-info form-label">OTP <span
                                        class="text-danger">*</span></label><br>
                                <input type="text" name="otp" id="otp" class="form-control"
                                    placeholder="Enter OTP">
                            </div>
                            <div class="form-group">
                                <input style="cursor: pointer;" type="submit" class="btn btn-primary btn-md form-control" value="Verify Now">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
