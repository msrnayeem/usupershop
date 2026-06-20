@extends('frontend.layouts.seller_master')
@section('title')
    Password Change
@endsection
@section('content')
    <style type="text/css">
        .prof li {
            background: #1781BF;
            padding: 7px;
            margin: 3px;
            border-radius: 15px;
        }

        .prof li a {
            color: #fff;
            padding-left: 15px;
        }
    </style>
    <!-- Title page -->
    {{-- <section class="bg-img1 txt-center p-lr-15 p-tb-92" style="background-image: url('frontend/images/bg-01.jpg');">
        <h2 class="ltext-105 cl0 txt-center">Password Change</h2>
    </section> --}}
    <div class="container">
        <div class="row" style="padding: 70px 0px 70px 0px;">
            <div class="col-md-2">
                <ul class="prof">
                    <li><a href="{{ route('seller.customer.dashboard') }}">My Profile</a></li>
                    <li><a href="{{ route('seller.customer.password.change') }}">Password Change</a></li>
                    <li><a href="{{ route('seller.customer.order.list') }}">My Orders</a></li>
                </ul>
            </div>
            <div class="col-md-10">
                <h4>Password Change</h4>
                <hr>
                <form method="post" action="{{ route('seller.customer.password.update') }}" id="myForm">
                    @csrf
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="current_password">Current Password</label>
                            <input type="password" name="current_password" class="form-control" id="current_password">
                        </div>

                        <div class="form-group col-md-4">
                            <label for="new_password">New Password</label>
                            <input type="password" name="new_password" class="form-control" id="new_password">
                        </div>

                        <div class="form-group col-md-4">
                            <label for="again_new_password">Again New Password</label>
                            <input type="password" name="again_new_password" class="form-control">
                        </div>

                        <div class="form-group col-md-6">
                            <input type="submit" value="Password Update" class="btn btn-primary" style="cursor: pointer">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        $(function() {
            $('#myForm').validate({
                rules: {
                    current_password: {
                        required: true,
                    },
                    new_password: {
                        required: true,
                        minlength: 6
                    },
                    again_new_password: {
                        required: true,
                        equalTo: '#new_password'
                    },
                },
                messages: {
                    current_password: {
                        required: "Please provide current password",
                    },
                    new_password: {
                        required: "Please provide new password",
                        minlength: "Your password must be at least 6 characters long"
                    },
                    again_new_password: {
                        required: "Please enter new confirm password",
                        equalTo: "Confirm new password does not match"
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
