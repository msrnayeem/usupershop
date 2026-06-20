@extends('frontend.layouts.seller_master')
@section('title')
    Customer Registration
@endsection
@section('content')
    <style type="text/css">
        #login .container #login-row #login-column #login-box {
            max-width: 600px;
            border: 1px solid #9C9C9C;
            background-color: #EAEAEA;
            margin-bottom: 70px;
            margin-top: 70px;
        }

        #login .container #login-row #login-column #login-box #login-form {
            padding: 20px;
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
    {{-- <section class="bg-img1 txt-center p-lr-15 p-tb-92" style="background-image: url('frontend/images/bg-01.jpg');">
        <h2 class="ltext-105 cl0 txt-center">Customer Signup</h2>
    </section> --}}
    <div id="login">
        <div class="container">
            <div id="login-row" class="row justify-content-center align-items-center">
                <div class="col-md-3">
                </div>
                <div id="login-column" class="col-md-6">
                    <div id="login-box" class="col-md-12">
                        @if (Session::get('success'))
                            <div class="alert alert-success alert-dismissible" role="alert">
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                <strong>{{ Session::get('success') }}</strong>
                            </div>
                        @endif
                        <form id="login-form" class="form" action="{{ route('signup.store') }}" method="post">
                            @csrf
                            <h3 class="text-center text-info english_lang">Signup</h3>
                            <h3 class="text-center text-info bangla_lang" style="display: none;">সাইন আপ করুন</h3>
                            <div class="form-group">
                                <label for="name" class="text-info english_lang">Full Name :</label>
                                <label for="name" class="text-info bangla_lang" style="display: none;">পুরো নাম :</label>
                                <br>
                                <input type="text" name="name" id="name" value="{{ old('name') }}"
                                    class="form-control">
                                <font color="red">{{ $errors->has('name') ? $errors->first('name') : '' }}</font>
                            </div>
                            <div class="form-group">
                                <label for="email" class="text-info english_lang">Email :</label>
                                <label for="email" class="text-info bangla_lang" style="display: none;">ইমেইল :</label>
                                <br>
                                <input type="email" name="email" id="email" value="{{ old('email') }}"
                                    class="form-control">
                                <font color="red">{{ $errors->has('email') ? $errors->first('email') : '' }}</font>
                            </div>
                            <div class="form-group">
                                <label for="mobile" class="text-info english_lang">Phone :</label>
                                <label for="mobile" class="text-info bangla_lang" style="display: none;">মোবাইল :</label>
                                <br>
                                <input type="text" name="mobile" id="mobile" value="{{ old('mobile') }}"
                                    class="form-control">
                                <font color="red">{{ $errors->has('mobile') ? $errors->first('mobile') : '' }}</font>
                            </div>
                            <div class="form-group">
                                <label for="password" class="text-info english_lang">Password :</label>
                                <label for="password" class="text-info bangla_lang" style="display: none;">পাসওয়ার্ড :</label>
                                <br>
                                <input type="password" name="password" id="password" class="form-control">
                                <font color="red">{{ $errors->has('password') ? $errors->first('password') : '' }}</font>
                            </div>
                            <div class="form-group">
                                <label for="confirmation_password" class="text-info english_lang">Confirm Password :</label>
                                <label for="confirmation_password" class="text-info bangla_lang" style="display: none;">পাসওয়ার্ড নিশ্চিত করুন:</label>
                                <br>
                                <input type="password" name="confirmation_password" id="confirmation_password"
                                    class="form-control">
                            </div>
                            <div class="form-group">
                                <input style="cursor: pointer;" type="submit" name="submit" class="btn btn-info btn-md"
                                    value="Signup">
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-user"></i> Have you account ? <a href="{{ route('seller.customer.login') }}"><span
                                        class="signup-link">Login Here</span></a>
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
                    name: {
                        required: true
                    },
                    email: {
                        required: true,
                        email: true,
                    },
                    mobile: {
                        required: true
                    },
                    password: {
                        required: true,
                        minlength: 9
                    },
                    confirmation_password: {
                        required: true,
                        equalTo: '#password'
                    },
                },
                messages: {
                    name: {
                        required: "Please enter your full name"
                    },
                    email: {
                        required: "Please enter a email address",
                        email: "Please enter a vaild email address"
                    },
                    mobile: {
                        required: "Please enter your mobile no"
                    },
                    password: {
                        required: "Please provide a password",
                        minlength: "Your password must be at least 9 characters long"
                    },
                    confirmation_password: {
                        required: "Please enter confirm password",
                        equalTo: "Confirm password does not match"
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
