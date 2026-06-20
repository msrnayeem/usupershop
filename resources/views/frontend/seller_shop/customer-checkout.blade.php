@extends('frontend.layouts.seller_master')
@section('title')
    Seller Checkout
@endsection
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
                <div class="panel">
                    <div class="panel-body">
                        <form id="login-form" class="form" action="{{ route('seller.customer.checkout.store') }}" method="post">
                            @csrf
                            <div class="row">
                                <div class="col-md-4 form-group">
                                    <label for="name">Full Name :</label>
                                    <input type="text" name="name" id="name" class="form-control">
                                    <font color="red">{{ $errors->has('name') ? $errors->first('name') : '' }}</font>
                                </div>
                                <div class="col-md-4 form-group">
                                    <label for="email">Email :</label>
                                    <input type="email" name="email" id="email" class="form-control">
                                </div>
                                <div class="col-md-4 form-group">
                                    <label for="mobile">Phone No :</label>
                                    <input type="text" name="mobile" id="mobile" class="form-control">
                                    <font color="red">{{ $errors->has('mobile') ? $errors->first('mobile') : '' }}</font>
                                </div>
                                <div class="col-md-4 form-group">
                                    <label for="address">Address :</label>
                                    <input type="text" name="address" id="address" class="form-control">
                                    <font color="red">{{ $errors->has('address') ? $errors->first('address') : '' }}</font>
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
                        required: "Please enter your Phone no"
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
