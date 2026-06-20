<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="icon" type="image/png" href="{{ asset('frontend') }}/images/icons/favicon.png" />
    <title>Usupershop Seller Center</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/v4-shims.min.css') }}" />
    <script src="{{ asset('js/jquery-3.6.1.min.js') }}"></script>

    <style>
        .login-page__body-left_step {
            display: flex;
            align-items: center;
            margin-bottom: 2rem;
        }

        .login-page__body-left_step:first-child .login-page__body-left_step-icon {
            background-color: #ef5350;
        }

        .login-page__body-left_step:nth-child(2) .login-page__body-left_step-icon {
            background-color: #2196f3;
        }

        .login-page__body-left_step:last-child .login-page__body-left_step-icon {
            background-color: #4caf50;
        }

        .login-page__body-left_step-icon {
            width: 60px;
            height: 60px;
            background-color: #ddd;
            border-radius: 50%;
            margin-right: 2rem;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .login-page__body-left_step-icon div svg {
            color: #fff;
            width: 44%;
            height: 44%;
        }

        .login-page__body-left_step p {
            letter-spacing: 1px;
            font-size: 1.4rem;
            font-weight: 500;
            color: #707070;
            margin: 0;
        }
    </style>
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
                                <img class="card-img-top" style="width:200px;margin-top:50px;"
                                    src="{{ asset('frontend/assets/images/seller.jpg') }}"
                                    alt="Seller image"></a>

                        </div>
                        <div class="card-body p-5 text-center">
                            <h2 class="mb-5" style="font-size: 3rem;">WELCOME TO <span
                                    style="font-weight:600;font-size: 3rem;letter-spacing: 2px;">SELLER CENTER</span>
                            </h2>
                            <div class="row">
                                <div class="col-md-7">
                                    <div style="text-align:left;color:#f40909; margin-bottom: 50px;">
                                        <h2>3 Simple Step To Become<br>
                                            Successful Seller On Usupershop</h2>
                                    </div>
                                    <div class="login-page__body-left_steps">
                                        <div class="login-page__body-left_step">
                                            <div class="login-page__body-left_step-icon">
                                                <div>
                                                    <svg aria-hidden="true" focusable="false" data-prefix="fas"
                                                        data-icon="pen" class="svg-inline--fa fa-pen " role="img"
                                                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                                        <path fill="currentColor"
                                                            d="M290.74 93.24l128.02 128.02-277.99 277.99-114.14 12.6C11.35 513.54-1.56 500.62.14 485.34l12.7-114.22 277.9-277.88zm207.2-19.06l-60.11-60.11c-18.75-18.75-49.16-18.75-67.91 0l-56.55 56.55 128.02 128.02 56.55-56.55c18.75-18.76 18.75-49.16 0-67.91z">
                                                        </path>
                                                    </svg>
                                                </div>
                                            </div>
                                            <p>Sign Up &amp; Create Own Store</p>
                                        </div>
                                        <div class="login-page__body-left_step">
                                            <div class="login-page__body-left_step-icon">
                                                <div>
                                                    <svg aria-hidden="true" focusable="false" data-prefix="fas"
                                                        data-icon="box-open" class="svg-inline--fa fa-box-open "
                                                        role="img" xmlns="http://www.w3.org/2000/svg"
                                                        viewBox="0 0 640 512">
                                                        <path fill="currentColor"
                                                            d="M425.7 256c-16.9 0-32.8-9-41.4-23.4L320 126l-64.2 106.6c-8.7 14.5-24.6 23.5-41.5 23.5-4.5 0-9-.6-13.3-1.9L64 215v178c0 14.7 10 27.5 24.2 31l216.2 54.1c10.2 2.5 20.9 2.5 31 0L551.8 424c14.2-3.6 24.2-16.4 24.2-31V215l-137 39.1c-4.3 1.3-8.8 1.9-13.3 1.9zm212.6-112.2L586.8 41c-3.1-6.2-9.8-9.8-16.7-8.9L320 64l91.7 152.1c3.8 6.3 11.4 9.3 18.5 7.3l197.9-56.5c9.9-2.9 14.7-13.9 10.2-23.1zM53.2 41L1.7 143.8c-4.6 9.2.3 20.2 10.1 23l197.9 56.5c7.1 2 14.7-1 18.5-7.3L320 64 69.8 32.1c-6.9-.8-13.5 2.7-16.6 8.9z">
                                                        </path>
                                                    </svg>
                                                </div>
                                            </div>
                                            <p>Upload Products To Start Selling</p>
                                        </div>
                                        <div class="login-page__body-left_step">
                                            <div class="login-page__body-left_step-icon">
                                                <div>
                                                    <svg aria-hidden="true" focusable="false" data-prefix="fas"
                                                        data-icon="box-open" class="svg-inline--fa fa-box-open "
                                                        role="img" xmlns="http://www.w3.org/2000/svg"
                                                        viewBox="0 0 640 512">
                                                        <path fill="currentColor"
                                                            d="M425.7 256c-16.9 0-32.8-9-41.4-23.4L320 126l-64.2 106.6c-8.7 14.5-24.6 23.5-41.5 23.5-4.5 0-9-.6-13.3-1.9L64 215v178c0 14.7 10 27.5 24.2 31l216.2 54.1c10.2 2.5 20.9 2.5 31 0L551.8 424c14.2-3.6 24.2-16.4 24.2-31V215l-137 39.1c-4.3 1.3-8.8 1.9-13.3 1.9zm212.6-112.2L586.8 41c-3.1-6.2-9.8-9.8-16.7-8.9L320 64l91.7 152.1c3.8 6.3 11.4 9.3 18.5 7.3l197.9-56.5c9.9-2.9 14.7-13.9 10.2-23.1zM53.2 41L1.7 143.8c-4.6 9.2.3 20.2 10.1 23l197.9 56.5c7.1 2 14.7-1 18.5-7.3L320 64 69.8 32.1c-6.9-.8-13.5 2.7-16.6 8.9z">
                                                        </path>
                                                    </svg>
                                                </div>
                                            </div>
                                            <p>Adopt Tools To Maximize Sell</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-5" style="border: 1px solid #ddd;">
                                    @if ($errors->any())
                                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                            @foreach ($errors->all() as $error)
                                                <strong>{{ $error }}</strong></br>
                                            @endforeach
                                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                                        </div>
                                    @endif
                                    @if (Session::get('message'))
                                        <div class="alert alert-warning alert-dismissible" role="alert">
                                            <strong>{{ Session::get('message') }}</strong>
                                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                                        </div>
                                    @endif
                                    <form id="login-form" class="form" action="{{ route('seller.login.store') }}"
                                        method="post">
                                        @csrf
                                        <div class="row justify-content-center mb-4">
                                            <div class="form-group text-center mt-3">
                                                <h6>Account Type</h6>
                                                <h6 style="margin-bottom: 8px;">
                                                    <input class="form-check-input" type="radio" name="account_type"
                                                        id="account_type_seller" value="seller">
                                                    <label for="account_type_seller">Seller</label>
                                                </h6>
                                                <h6>
                                                    <input class="form-check-input" type="radio" name="account_type"
                                                        id="account_type_vendor" value="vendor">
                                                    <label for="account_type_vendor">Vendor</label>
                                                </h6>
                                            </div>
                                        </div>
                                        <div class="row mb-3 align-items-center">
                                            <label for="text_content"
                                                class="col-sm-4 col-form-label text-end">Email Or Phone Number</label>
                                            <div class="col-sm-6">
                                                <input type="text" name="text_content" class="form-control"
                                                    id="text_content" placeholder="Enter your email or Phone no">
                                            </div>
                                        </div>
                                       
                                        <div class="row mb-3 align-items-center">
                                            <label for="inputPassword3"
                                                class="col-sm-4 col-form-label text-end">Password</label>
                                            <div class="col-sm-6">
                                                <input type="password" name="password" class="form-control"
                                                    id="inputPassword3" placeholder="Enter your password">
                                            </div>
                                        </div>
                                        <div class="row justify-content-center">
                                            <div class="col-md-6">
                                                <hr class="my-4">
                                                <button class="w-100 btn btn-success" type="submit">Submit</button>
                                            </div>
                                        </div>
                                    </form>

                                    <div style="margin: 20px 0px;">
                                        No account yet ? <a href="{{ route('seller.signup') }}">Create new account</a>
                                    </div>
                                    <div style="margin: 20px 0px;">
                                        <a href="{{ route('seller_otp') }}">Forget Password </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script src="{{ asset('frontend') }}/vendor/bootstrap/js/bootstrap.min.js"></script>
</body>

</html>
