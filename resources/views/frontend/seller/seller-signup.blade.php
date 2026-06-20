@extends('frontend.layouts.master')
@section('title')
    Seller Registration
@endsection
@section('content')
    <style type="text/css">
        .is-invalid {
            color: #ff0000;
        }

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
            <div class="col-xs-12 col-sm-10 col-md-6 col-lg-6 col-xl-6" style="margin: 0 auto; float: none;">
                <div class="card">
                    <div class="card-header">
                        <h3 class="text-center text-info logintext english_lang">Seller Registration</h3>
                        <h3 class="text-center text-info logintext bangla_lang" style="display: none;">সেলার রেজিস্ট্রেশন</h3>
                    </div>
                    <div class="card-body">
                        <form id="login-form" class="form" action="{{ route('seller.store') }}" method="post">
                            @csrf

                            <div class="form-group">
                                <label for="name" class="text-info english_lang">Account Type <span
                                        class="text-danger">*</span></label>

                                <select name="account_type" id="account_type" class="form-control select2" required>
                                    <option value="">Select</option>
                                    <option value="vendor">Vendor</option>
                                    <option value="seller">Seller</option>
                                    <option value="dropshipper">Dropshipper</option>
                                </select>
                                @error('account_type')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="name" class="text-info english_lang">Full Name <span
                                        class="text-danger">*</span></label>
                                <label for="name" class="text-info bangla_lang" style="display: none;">পুরো নাম <span
                                        class="text-danger">*</span></label>
                                <input type="text" name="name" id="name" value="{{ old('name') }}"
                                    class="form-control" placeholder="Enter your full name">
                                @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="shop_name" class="mb-2 text-info">Shop Name <span
                                        style="color: red;">*</span></label>
                                <input type="text" name="shop_name" id="shop_name" class="form-control"
                                    placeholder="Shop name">
                                @error('shop_name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="email" class="text-info english_lang">Email <span
                                        class="text-danger">*</span></label>
                                <label for="email" class="text-info bangla_lang" style="display: none;">ইমেইল <span
                                        class="text-danger">*</span></label>
                                <input type="email" name="email" id="email" value="{{ old('email') }}"
                                    class="form-control" placeholder="Enter your email address">
                                @error('email')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="mobile" class="text-info english_lang">Mobile No <span
                                        class="text-danger">*</span></label>
                                <label for="mobile" class="text-info bangla_lang" style="display: none;">মোবাইল <span
                                        class="text-danger">*</span></label>
                                <input type="text" name="mobile" id="mobile" value="{{ old('mobile') }}"
                                    class="form-control" placeholder="Enter your mobile number">
                                @error('mobile')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label class="text-info english_lang">Receive OTP In <span class="text-danger">*</span></label>
                                <label class="text-info bangla_lang" style="display: none;">OTP পাবেন কোথায় <span class="text-danger">*</span></label>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="otp_delivery_method" id="seller_otp_delivery_both" value="both" {{ old('otp_delivery_method', 'both') === 'both' ? 'checked' : '' }}>
                                    <label class="form-check-label english_lang" for="seller_otp_delivery_both">Email and Phone Number</label>
                                    <label class="form-check-label bangla_lang" style="display: none;" for="seller_otp_delivery_both">ইমেইল এবং ফোন নম্বর</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="otp_delivery_method" id="seller_otp_delivery_email" value="email" {{ old('otp_delivery_method') === 'email' ? 'checked' : '' }}>
                                    <label class="form-check-label english_lang" for="seller_otp_delivery_email">Email Only</label>
                                    <label class="form-check-label bangla_lang" style="display: none;" for="seller_otp_delivery_email">শুধু ইমেইল</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="otp_delivery_method" id="seller_otp_delivery_sms" value="sms" {{ old('otp_delivery_method') === 'sms' ? 'checked' : '' }}>
                                    <label class="form-check-label english_lang" for="seller_otp_delivery_sms">Phone Number Only</label>
                                    <label class="form-check-label bangla_lang" style="display: none;" for="seller_otp_delivery_sms">শুধু ফোন নম্বর</label>
                                </div>
                                @error('otp_delivery_method')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="address" class="mb-2 text-info">Address <span
                                        style="color: red;">*</span></label>
                                <input name="address" class="form-control" placeholder="Enter Your Address">
                                @error('address')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="code" class="mb-2 text-info">Referral Code </label>
                                <input type="text" name="code" class="form-control" placeholder="Referral Code"
                                    value="{{ request()->has('refer') ? request()->refer : '' }}"
                                    @if (request()->has('refer')) readonly @endif>
                                @error('code')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="subscription_plan" class="mb-2 text-info">Subscription Plan <span
                                        style="color: red;">*</span></label>
                                <input type="text" name="subscription_plan" class="form-control"
                                    placeholder="subscription plan" value="{{ date('d M Y') }}" readonly>
                                @error('subscription_plan')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group" style="position: relative;">
                                <label for="password" class="text-info english_lang">Password <span
                                        class="text-danger">*</span></label>
                                <label for="password" class="text-info bangla_lang" style="display: none;">পাসওয়ার্ড
                                    <span class="text-danger">*</span></label>

                                <input type="password" name="password" id="password" class="form-control"
                                    placeholder="Enter your password">
                                <span class="fa fa-eye toggle-password" data-target="#password"
                                    style="position: absolute; top: 38px; right: 10px; cursor: pointer; color: #555;"></span>

                                @error('password')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group" style="position: relative;">
                                <label for="confirmation_password" class="text-info english_lang">Confirm Password <span
                                        class="text-danger">*</span></label>
                                <label for="confirmation_password" class="text-info bangla_lang"
                                    style="display: none;">পাসওয়ার্ড নিশ্চিত করুন <span
                                        class="text-danger">*</span></label>

                                <input type="password" name="confirmation_password" id="confirmation_password"
                                    class="form-control" placeholder="Confirm your password">
                                <span class="fa fa-eye toggle-password" data-target="#confirmation_password"
                                    style="position: absolute; top: 38px; right: 10px; cursor: pointer; color: #555;"></span>

                                @error('confirmation_password')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>


                            <div class="form-check text-left">
                                <input class="form-check-input" type="checkbox" name="terms" value="yes"
                                    id="terms" required>
                                <label class="form-check-label english_lang" for="terms"> I agree all with <a
                                        style="color: #0824ac; font-weight: 700;"
                                        href="{{ route('terms.and.condition') }}">Term and Conditions</a></label>
                            </div>

                            <div class="form-group" style="margin-top: 10px;">
                                <button style="cursor: pointer;" type="submit" class="btn loginBtn form-control">
                                    Register Now</button>
                            </div>


                            <div class="form-group text-center">
                                <p for="" style="margin: 0px;">You already have an account?
                                    <a class="english_lang" style="color: #0824ac; font-weight: 700;"
                                        href="{{ route('customer.login') }}">Login Now</a>
                                </p>
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
                    shop_name: {
                        required: true
                    },
                    email: {
                        required: true,
                        email: true,
                    },
                    mobile: {
                        required: true
                    },
                    otp_delivery_method: {
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
                    address: {
                        required: true
                    },
                    terms: {
                        required: true
                    }
                },
                messages: {
                    name: {
                        required: "Please enter your full name"
                    },
                    shop_name: {
                        required: "Please enter your shop name"
                    },
                    email: {
                        required: "Please enter a email address",
                        email: "Please enter a vaild email address"
                    },
                    mobile: {
                        required: "Please enter your mobile no"
                    },
                    otp_delivery_method: {
                        required: "Please choose where to receive OTP"
                    },
                    password: {
                        required: "Please provide a password",
                        minlength: "Your password must be at least 9 characters long"
                    },
                    confirmation_password: {
                        required: "Please enter confirm password",
                        equalTo: "Confirm password does not match"
                    },
                    address: {
                        required: "Please enter your full address"
                    },
                    terms: {
                        required: "Please checked your terms"
                    }
                },
                errorElement: 'span',
                errorPlacement: function(error, element) {
                    error.addClass('is-invalid');
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

        $(document).ready(function() {
            $('.toggle-password').on('click', function() {
                var $icon = $(this);
                var inputSelector = $icon.data('target');
                var $input = $(inputSelector);
                var isPassword = $input.attr('type') === 'password';

                // Safely clone & replace the input to avoid "type property can't be changed" error
                var $newInput = $input.clone();
                $newInput.attr('type', isPassword ? 'text' : 'password');
                $input.replaceWith($newInput);

                // Update the icon and color
                $icon.toggleClass('fa-eye fa-eye-slash');
                $icon.css('color', isPassword ? '#007bff' : '#555');
            });
        });
    </script>
@endsection
