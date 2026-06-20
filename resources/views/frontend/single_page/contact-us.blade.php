@extends('frontend.layouts.master')
@section('title', 'Contact Us | ' . config('app.name'))

@section('meta_description', 'যোগাযোগ করুন ' . config('app.name') . ' এর সাথে। আমাদের অফিস ঠিকানা, ফোন, ইমেইল এবং গ্রাহক
    সেবা তথ্য। ঘরে বসেই আপনার প্রশ্ন বা অভিযোগ পাঠান, আমরা দ্রুত সাড়া দেব।')
@section('meta_keywords', 'Contact ' . config('app.name') . ', যোগাযোগ, Customer Service, Office Address, Email, Phone')
@section('meta_author', config('app.name'))

@push('meta')
    {{-- Open Graph / Facebook --}}
    <meta property="og:title" content="Contact Us - {{ config('app.name') }}" />
    <meta property="og:description"
        content="যোগাযোগ করুন {{ config('app.name') }} এর সাথে। অফিস ঠিকানা, ফোন ও ইমেইল সহ দ্রুত সেবা।" />
    <meta property="og:image" content="{{ asset('frontend/images/og-default.jpg') }}" />
    <meta property="og:url" content="{{ url()->current() }}" />
    <meta property="og:type" content="website" />

    {{-- Twitter Card --}}
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Contact Us - {{ config('app.name') }}">
    <meta name="twitter:description"
        content="যোগাযোগ করুন {{ config('app.name') }} এর সাথে। অফিস ঠিকানা, ফোন ও ইমেইল সহ দ্রুত সেবা।">
    <meta name="twitter:image" content="{{ asset('frontend/images/og-default.jpg') }}">
@endpush
@section('content')
    <!-- Content page -->
    <section class="bg0 p-t-104 p-b-116">
        <div class="container">
            <div class="flex-w flex-tr">
                <div class="size-210 bor10 p-lr-70 p-t-55 p-b-70 p-lr-15-lg w-full-md">
                    @if (Session::get('success'))
                        <div class="alert alert-success alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            <strong>{{ Session::get('success') }}</strong>
                        </div>
                    @endif
                    <div class="row">
                        <div class="col-xs-12">
                            <form method="post" action="{{ route('communication.store') }}" id="myForm"
                                class="form-group"
                                style="border: 1px solid #ddd; padding: 15px; border-radius: 5px;margin-top:5%;margin-bottom:2%;">
                                @csrf
                                <h4 class="text-left">Send Us A Message</h4>
                                <div class="col-xs-6">
                                    <div class="form-group text-center">
                                        <input class="form-control" type="text" name="name" placeholder="Your Name"
                                            required="" style="width: 80%; display: inline-block;">
                                        <img class="pointer-none" src="{{ asset('frontend') }}/images/userOne.png"
                                            alt="ICON" width="20px" style="margin-left: 10px; width:20px;">
                                        <font color="red">{{ $errors->has('name') ? $errors->first('name') : '' }}
                                        </font>
                                    </div>
                                </div>
                                <div class="col-xs-6">

                                    <div class="form-group text-center">
                                        <input class="form-control" type="email" name="email"
                                            placeholder="Your Email Address" required=""
                                            style="width: 80%; display: inline-block;">
                                        <img class="pointer-none" src="{{ asset('frontend') }}/images/icon-email.png"
                                            alt="ICON" width="20px" style="margin-left: 10px;width:20px;">
                                        <font color="red">{{ $errors->has('email') ? $errors->first('email') : '' }}
                                        </font>
                                    </div>
                                </div>
                                <div class="col-xs-6">
                                    <div class="form-group text-center">
                                        <input class="form-control" type="text" name="mobile"
                                            placeholder="Your Phone Number" required=""
                                            style="width: 80%; display: inline-block;">
                                        <img class="pointer-none" src="{{ asset('frontend') }}/images/mobile.png"
                                            alt="ICON" width="20px" style="margin-left: 10px;width:20px;">
                                        <font color="red">{{ $errors->has('mobile') ? $errors->first('mobile') : '' }}
                                        </font>
                                    </div>
                                </div>

                                <div class="col-xs-6">
                                    <div class="form-group">
                                        <textarea class="form-control" name="message" placeholder="Your Message" required=""
                                            style="width: 80%; margin: auto; display: block;"></textarea>
                                        <font color="red">{{ $errors->has('message') ? $errors->first('message') : '' }}
                                        </font>
                                    </div>
                                </div>



                                <div class="text-right">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>



                </div>

                <div class="size-210 bor10 flex-w flex-col-m p-lr-93 p-tb-30 p-lr-15-lg w-full-md">
                    <div class="col-xs-4">
                        <div class="flex-w w-full p-b-42">
                            <span class="fs-18 cl5 txt-center size-211">
                                <span class="lnr lnr-map-marker"></span>
                            </span>

                            <div class="size-212 p-t-2">
                                <span class="mtext-110 cl2">Address</span>
                                <p class="stext-115 cl6 size-213 p-t-18">
                                    {{ $contact->address }}
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-4">
                        <div class="flex-w w-full p-b-42">
                            <span class="fs-18 cl5 txt-center size-211">
                                <span class="lnr lnr-phone-handset"></span>
                            </span>

                            <div class="size-212 p-t-2">
                                <span class="mtext-110 cl2">Lets Talk</span>
                                <p class="stext-115 cl1 size-213 p-t-18">
                                    {{ $contact->mobile }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="col-xs-4">
                        <div class="flex-w w-full">
                            <span class="fs-18 cl5 txt-center size-211">
                                <span class="lnr lnr-envelope"></span>
                            </span>

                            <div class="size-212 p-t-2">
                                <span class="mtext-110 cl2">Sale Support</span>
                                <p class="stext-115 cl1 size-213 p-t-18">
                                    {{ $contact->email }}
                                </p>
                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </section>

    <!-- Map -->
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m16!1m12!1m3!1d3652.468724879056!2d90.40966991478368!3d23.73065908459905!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!2m1!1sH.M%20Siddik%20Mansion%2055%2FA%20Purana%20Paltan(8th%20floor)%2C%20Dhaka!5e0!3m2!1sen!2sbd!4v1660657792567!5m2!1sen!2sbd"
                    width="100%" height="350px" frameborder="0" style="border:0" allowfullscreen></iframe>
            </div>
        </div>
    </div><br />
    <script type="text/javascript">
        $(function() {
            $('#myForm').validate({
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
                    message: {
                        required: true,
                        minlength: 10
                    },
                },
                messages: {
                    name: {
                        required: "Please enter your name"
                    },
                    email: {
                        required: "Please enter a email address",
                        email: "Please enter a vaild email address"
                    },
                    mobile: {
                        required: "Please enter your mobile no"
                    },
                    message: {
                        required: "Please enter your message",
                        minlength: "Your message must be at least 10 characters long"
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
