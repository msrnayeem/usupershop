<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="icon" type="image/png" href="{{ asset('frontend') }}/images/icons/favicon.png" />
    <title>Usupershop</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/v4-shims.min.css') }}" />
    <script src="{{ asset('js/jquery-3.6.1.min.js') }}"></script>
</head>

<body
    style="
       background-image: url({{ asset('frontend/images/109428.png') }});
      background-repeat: no-repeat;
      background-attachment: fixed;
      background-size: cover;
    ">
    <section class="vh-100">
        <div class="container py-5 ">
            <div class="row d-flex align-items-center">
                <div class="col-12 col-md-12 col-lg-12 col-xl-12">
                    <div class="card shadow-2-strong" style="border-radius: 1rem">
                        <div style="text-align: center;">
                            <a href="{{ url('/') }}">
                                <img class="card-img-top" style="width: 300px;margin-top:50px;opacity:0.8;"
                                    src="{{ asset('frontend/assets/images/seller.jpg') }}"
                                    alt="{{ $logo->name }}"></a>
                        </div>
                        <div class="card-body p-5">
                            <!--  <h2 class="mb-5">WELCOME TO <span style="font-weight: 700;font-size: 3rem;letter-spacing: 2px;">SELLER Registration</span></h2> -->
                            <div class="row">
                                <div class="offset-md-1 col-md-10">
                                    <div class="card">
                                        <div class="card-header text-center text-danger">
                                            <strong>SELLER SIGN UP </strong>
                                        </div>
                                        <div class="card-body">
                                            @if (Session::get('success'))
                                                <div class="alert alert-success alert-dismissible" role="alert">
                                                    <strong>{{ Session::get('success') }}</strong>
                                                    <button type="button" class="close"
                                                        data-dismiss="alert">&times;</button>
                                                </div>
                                            @endif
                                            <form id="login-form" class="form" action="{{ route('seller.store') }}"
                                                method="post">
                                                @csrf
                                                <div class="row">
                                                    <div class="col-md-3"></div>
                                                    <div class="col-md-6">
                                                        <fieldset class="form-group">
                                                            <div class="row">
                                                                <legend class="col-form-label col-sm-4 pt-0 mb-3">
                                                                    Account Type :</legend>
                                                                <div class="col-sm-4 mb-3 form-group">
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="radio"
                                                                            name="account_type" id="account_type"
                                                                            value="vendor">
                                                                        <label class="form-check-label"
                                                                            for="account_type">
                                                                            Vendor
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-4 mb-3 form-group">
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="radio"
                                                                            name="account_type" id="account_type"
                                                                            value="seller" checked>
                                                                        <label class="form-check-label"
                                                                            for="account_type">
                                                                            Seller
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </fieldset>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-3 mb-3 form-group">
                                                        <label for="name" class="mb-2">Your Name <span
                                                                style="color: red;">*</span></label>
                                                        <input type="text" name="name" class="form-control"
                                                            placeholder="Enter name">
                                                        <font color="red">
                                                            {{ $errors->has('name') ? $errors->first('name') : '' }}
                                                        </font>
                                                    </div>

                                                    <div class="col-md-3 mb-3 form-group">
                                                        <label for="shop_name" class="mb-2">Shop Name <span
                                                                style="color: red;">*</span></label>
                                                        <input type="text" name="shop_name" id="shop_name"
                                                            class="form-control" placeholder="Shop name">
                                                        <font color="red">
                                                            {{ $errors->has('shop_name') ? $errors->first('shop_name') : '' }}
                                                        </font>
                                                    </div>

                                                    <div class="col-md-3 mb-3 form-group">
                                                        <label for="email" class="mb-2">Your Email <span
                                                                style="color: red;">*</span></label>
                                                        <input type="email" name="email" class="form-control"
                                                            placeholder="Email address">
                                                        <font color="red">
                                                            {{ $errors->has('email') ? $errors->first('email') : '' }}
                                                        </font>
                                                    </div>
                                                    <div class="col-md-3 mb-3 form-group">
                                                        <label for="subscription_plan" class="mb-2">Subscription Plan <span
                                                                style="color: red;">*</span></label>
                                                        <input type="text" name="subscription_plan" class="form-control"
                                                            placeholder="subscription plan" value="{{ date('d M Y') }}" readonly>
                                                        <font color="red">
                                                            {{ $errors->has('subscription_plan') ? $errors->first('subscription_plan') : '' }}
                                                        </font>
                                                    </div>
                                                    <div class="col-md-3 mb-3 form-group">
                                                        <label for="Phone" class="mb-2">Phone Number <span
                                                                style="color: red;">*</span></label>
                                                        <input type="text" name="mobile" class="form-control"
                                                            placeholder="Phone no">
                                                        <font color="red">
                                                            {{ $errors->has('mobile') ? $errors->first('mobile') : '' }}
                                                        </font>
                                                    </div>

                                                    <div class="col-md-3 mb-3 form-group">
                                                        <label for="password" class="mb-2">Password <span
                                                                style="color: red;">*</span></label>
                                                        <input type="password" name="password" id="password"
                                                            class="form-control" placeholder="Password">
                                                        <font color="red">
                                                            {{ $errors->has('password') ? $errors->first('password') : '' }}
                                                        </font>
                                                    </div>

                                                    <div class="col-md-3 mb-3 form-group">
                                                        <label for="confirmation_password" class="mb-2">Confirm
                                                            Password
                                                            <span style="color: red;">*</span></label>
                                                        <input type="password" name="confirmation_password"
                                                            class="form-control" placeholder="Confirm Password">
                                                    </div>
                                                    <div class="col-md-3 mb-3 form-group">
                                                        <label for="code" class="mb-2">Referrar Code
                                                            <span style="color: red;">*</span></label>
                                                        <input type="text" name="code"
                                                            class="form-control" placeholder="code">
                                                    </div>
                                                    <div class="col-md-12 mb-3 form-group">
                                                        <label for="address" class="mb-2">Address <span
                                                                style="color: red;">*</span></label>
                                                        <textarea name="address" class="form-control" rows="2"></textarea>
                                                        <font color="red">
                                                            {{ $errors->has('address') ? $errors->first('address') : '' }}
                                                        </font>
                                                    </div>
                                                   
                                                    <div class="form-group row">
                                                        <div class="col-sm-12 form-group">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox"
                                                                    name="terms" value="yes" id="terms">
                                                                <label class="form-check-label" for="terms">
                                                                    I've read everything and clear about U Super Shop<a
                                                                        href="{{ route('terms.and.condition') }}">Terms
                                                                        & Conditions</a>
                                                                </label>
                                                            </div>
                                                            <font color="red">
                                                                {{ $errors->has('terms') ? $errors->first('terms') : '' }}
                                                            </font>
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <div class="offset-sm-4 col-sm-6">
                                                            <button
                                                                style="background: #37b629!important;border: 1px solid #37b629!important;min-width: 200px;margin-top: 20px;font-weight: 700;border-radius: 20px;"
                                                                type="submit" class="btn btn-success">Sign
                                                                Up</button>
                                                        </div>
                                                    </div>
                                                    <p class="mt-4 text-center">Already have an account ? <a
                                                            href="{{ route('seller.login') }}"> Sign In </a></p>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script> --}}
    <script src="{{ asset('frontend') }}/vendor/bootstrap/js/bootstrap.min.js"></script>
    <script src="{{ asset('backend') }}/plugins/jquery-validation/jquery.validate.min.js"></script>
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
</body>

</html>
