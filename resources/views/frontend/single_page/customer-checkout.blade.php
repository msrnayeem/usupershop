@extends('frontend.layouts.master')
@section('title', 'Checkout | ' . config('app.name'))

@section('meta_description', 'Secure and fast checkout at ' . config('app.name') . '. Complete your order quickly and
    safely with multiple payment options and reliable delivery.')
@section('meta_keywords', 'Checkout, Secure Payment, Online Shopping, ' . config('app.name') . ', Fast Delivery')
@section('meta_author', config('app.name'))

@push('meta')
    {{-- Open Graph / Facebook --}}
    <meta property="og:title" content="Checkout - {{ config('app.name') }}" />
    <meta property="og:description"
        content="Secure and fast checkout at {{ config('app.name') }}. Complete your order safely and get your products delivered quickly." />
    <meta property="og:image" content="{{ asset('frontend/images/og-default.jpg') }}" />
    <meta property="og:url" content="{{ url()->current() }}" />
    <meta property="og:type" content="website" />

    {{-- Twitter Card --}}
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Checkout - {{ config('app.name') }}">
    <meta name="twitter:description"
        content="Secure and fast checkout at {{ config('app.name') }}. Complete your order safely with reliable delivery.">
    <meta name="twitter:image" content="{{ asset('frontend/images/og-default.jpg') }}">
@endpush
@section('content')
    <!-- Title page -->
    {{-- <section class="bg-img1 txt-center p-lr-15 p-tb-92" style="background-image: url('frontend/images/bg-01.jpg');">
        <h2 class="ltext-105 cl0 txt-center">Shipping Information</h2>
    </section> --}}
    <div class="container">
        <div class="row" style="padding: 50px 0px 50px 0px;">
            <div class="col-md-12">
                <h4>Order Checkout</h4>
                <hr>
                <div class="panel mb-3">
                    <div class="panel-body">
                        <form id="login-form" class="form" action="{{ route('customer.checkout.store') }}" method="post">
                            @csrf
                            {{-- Always treat as guest checkout (no login required) --}}
                            <input type="hidden" name="guest_checkout" value="1">
                            @auth
                                <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                            @endauth
                            <div class="row">
                                <div class="col-md-4 form-group">
                                    <label for="name">Full Name :</label>
                                    <input type="text" name="name" id="name" class="form-control" value="{{ auth()->user()->name ?? old('name') }}" required>
                                    <font color="red">{{ $errors->has('name') ? $errors->first('name') : '' }}</font>
                                </div>
                                <div class="col-md-4 form-group">
                                    <label for="email">Email :</label>
                                    <input type="email" name="email" id="email" class="form-control" value="{{ auth()->user()->email ?? old('email') }}">
                                </div>
                                <div class="col-md-4 form-group">
                                    <label for="mobile">Phone No :</label>
                                    <input type="text" name="mobile" id="mobile" class="form-control" value="{{ auth()->user()->mobile ?? old('mobile') }}" required>
                                    <font color="red">{{ $errors->has('mobile') ? $errors->first('mobile') : '' }}</font>
                                </div>
                                <div class="col-md-4 form-group">
                                    <label for="address">Address :</label>
                                    <input type="text" name="address" id="address" class="form-control" value="{{ auth()->user()->address ?? old('address') }}" required>
                                    <font color="red">{{ $errors->has('address') ? $errors->first('address') : '' }}
                                    </font>
                                </div>
                                <div class="col-md-4" style="padding-top:30px;">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
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
                    mobile: {
                        required: true
                    },
                    address: {
                        required: true
                    },
                },
                messages: {
                    name: {
                        required: "Please enter your full name"
                    },
                    mobile: {
                        required: "Please enter your mobile no"
                    },
                    address: {
                        required: "Please enter your address"
                    },
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
