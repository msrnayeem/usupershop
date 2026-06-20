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
                            <a href="{{ url('') }}">
                                <img class="card-img-top" style="width: 300px;margin-top:50px;"
                                    src="{{ asset('upload/logo_image/' . $logo->image) }}"
                                    alt="{{ $logo->name }}"></a>
                        </div>
                        <div class="card-body p-5">
                            <!--  <h2 class="mb-5">WELCOME TO <span style="font-weight: 700;font-size: 3rem;letter-spacing: 2px;">SELLER Registration</span></h2> -->
                            <div class="row">
                                <div class="offset-md-2 col-md-8">
                                    <div class="card">
                                        <div class="card-header text-center text-danger">
                                            <strong>ACCOUNT VERIFY</strong>
                                        </div>
                                        <div class="card-body">
                                            @if (Session::get('success'))
                                                <div class="alert alert-success alert-dismissible" role="alert">
                                                    <strong>{{ Session::get('success') }}</strong>
                                                    <button type="button" class="close"
                                                        data-dismiss="alert">&times;</button>
                                                </div>
                                            @endif
                                            @if (Session::get('error'))
                                            <div class="alert alert-danger alert-dismissible" role="alert">
                                                <strong>{{ Session::get('error') }}</strong>
                                                <button type="button" class="close"
                                                    data-dismiss="alert">&times;</button>
                                            </div>
                                        @endif
                                            <form id="login-form" class="form"
                                                action="{{ route('seller.verify.kafi') }}" method="post">
                                                @csrf
                                                <div class="row">
                                                    <div class="offset-sm-3 col-sm-6">
                                                        <div class="form-group">
                                                            <label for="content" class="mb-2">Your Email or Phone Number <span
                                                                    style="color: red;">*</span></label>
                                                            <input type="text" name="content" class="form-control"
                                                                placeholder="Email address/Phone Number" value="{{ Session::get('seller_verify') }}" readonly>
                                                            <font color="red">
                                                                {{ $errors->has('content') ? $errors->first('content') : '' }}
                                                            </font>
                                                        </div>
                                                        </br>
                                                        <div class="form-group">
                                                            <label for="code" class="mb-2">Verification Code<span
                                                                    style="color: red;">*</span></label>
                                                            <input type="text" name="code" class="form-control"
                                                                placeholder="Code">
                                                            <font color="red">
                                                                {{ $errors->has('code') ? $errors->first('code') : '' }}
                                                            </font>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group row">
                                                    <div class="offset-sm-4 col-sm-6">
                                                        <button
                                                            style="background: #37b629!important;border: 1px solid #37b629!important;min-width: 200px;margin-top: 20px;font-weight: 700;border-radius: 20px;"
                                                            type="submit" class="btn btn-success">Verify</button>
                                                    </div>
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

                    email: {
                        required: true,
                        email: true,
                    },
                    code: {
                        required: true
                    }
                },
                messages: {
                    email: {
                        required: "Please enter a email address",
                        email: "Please enter a vaild email address"
                    },
                    code: {
                        required: "Please enter your code no"
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
