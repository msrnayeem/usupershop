<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Usupershop Login System</title>
    <link rel="icon" type="image/png" href="{{ asset('frontend') }}/images/icons/favicon.png" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="{{ asset('frontend') }}/assets/css/font-awesome.css" />
    <link rel="stylesheet" href="{{ asset('frontend') }}/assets/fonts/icofont.min.css" />
    <style>
        .card {
            margin-top: 25%;
        }

        .brand_logo_container {
            margin: auto;
            text-align: center;
        }

        .brand_logo_container img {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            border: 1px solid #ddd;
            margin-bottom: 15px;
        }
    </style>
</head>
<!--Coded with love by Mutiullah Samim-->

<body>
    <div class="container">
        <div class="row">
            <div class="col-12 col-md-5 mx-auto">
                <div class="card">
                    <div class="card-body">

                        <div class="brand_logo_container">
                            <img src="{{ asset('frontend') }}/images/login_logo.png" class="brand_logo" alt="Logo">
                        </div>

                        <form method="POST" action="{{ route('adminlogin') }}">

                            @csrf

                            @if (Session::get('message'))
                                <div class="alert alert-danger" role="alert">
                                    <span>{{ Session::get('message') }}</span>
                                </div>
                            @endif

                            <div class="form-group mb-3">
                                <input id="content" type="text"
                                    class="form-control @error('content') is-invalid @enderror" name="content"
                                    placeholder="Email Address or phone number" autocomplete="" autofocus>
                                @error('content')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group mb-2" style="position: relative;">
                                <input id="password" type="password"
                                    class="form-control @error('password') is-invalid @enderror" name="password"
                                    placeholder="Password" autocomplete="current-password">

                                <!-- Eye icon for toggle -->
                                <span class="fa fa-eye toggle-password"
                                    style="position: absolute; top: 10px; right: 12px; cursor: pointer; color: #555;"></span>

                                @error('password')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="customControlInline">
                                    <label class="custom-control-label" for="customControlInline">Remember me</label>
                                </div>
                            </div>
                            <div class="d-flex justify-content-center mt-3 login_container">
                                <button type="submit" name="button"
                                    class="btn btn-success form-control">Login</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="{{ asset('frontend') }}/assets/css/font-awesome.css" />
    <link rel="stylesheet" href="{{ asset('frontend') }}/assets/fonts/icofont.min.css" />


    <script>
        $(document).ready(function() {
            $('.toggle-password').on('click', function() {
                var $icon = $(this);
                var $password = $('#password');
                var isPassword = $password.attr('type') === 'password';

                // Clone and replace input to safely change type
                var $newInput = $password.clone();
                $newInput.attr('type', isPassword ? 'text' : 'password');
                $password.replaceWith($newInput);

                // Update reference to the new input
                $password = $newInput;

                // Toggle the icon and color
                $icon.toggleClass('fa-eye fa-eye-slash');
                $icon.css('color', isPassword ? '#007bff' : '#555');
            });
        });
    </script>


</body>

</html>
