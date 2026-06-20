@extends('frontend.layouts.master')

@section('title', 'About Us | ' . config('app.name'))

@section('meta_description', config('app.name') . ' সম্পর্কে জানুন। আমরা একটি নির্ভরযোগ্য অনলাইন শপ যা গ্রাহকদের
    মানসম্মত পণ্য, দ্রুত ডেলিভারি ও সাশ্রয়ী মূল্যে সেবা প্রদান করে থাকি।')
@section('meta_keywords', 'About ' . config('app.name') . ', আমাদের সম্পর্কে, অনলাইন শপ বাংলাদেশ, বিশ্বস্ত ইকমার্স,
    মানসম্মত পণ্য, দ্রুত ডেলিভারি')
@section('meta_author', config('app.name'))

@push('meta')
    {{-- Open Graph / Facebook --}}
    <meta property="og:title" content="About Us - {{ config('app.name') }}" />
    <meta property="og:description"
        content="{{ config('app.name') }} সম্পর্কে জানুন — আপনার নির্ভরযোগ্য অনলাইন শপ। ঘরে বসেই কিনুন গ্রোসারি, কসমেটিক্স, হেলথ কেয়ার, বেবি প্রোডাক্ট ও আরও অনেক কিছু!" />
    <meta property="og:image" content="{{ asset('frontend/images/og-default.jpg') }}" />
    <meta property="og:url" content="{{ url()->current() }}" />
    <meta property="og:type" content="website" />

    {{-- Twitter Card --}}
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="About Us - {{ config('app.name') }}">
    <meta name="twitter:description"
        content="{{ config('app.name') }} সম্পর্কে জানুন — বিশ্বস্ত ইকমার্স প্ল্যাটফর্ম বাংলাদেশে।">
    <meta name="twitter:image" content="{{ asset('frontend/images/og-default.jpg') }}">
@endpush

@section('content')
    <!-- ========================== HEADER : END ========================== -->
    <div class="breadcrumb">
        <div class="container">
            <div class="breadcrumb-inner">
                <ul class="list-inline list-unstyled">
                    <li><a href="#">Home</a></li>
                    <li class='active'>About Us</li>
                </ul>
            </div><!-- /.breadcrumb-inner -->
        </div><!-- /.container -->
    </div><!-- /.breadcrumb -->

    <div class="body-content">
        <div class="container">
            <div class="terms-conditions-page">
                <div class="row">
                    <div class="col-md-12 terms-conditions">
                        <h2 class="heading-title">About Us</h2>
                        <div class="">
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam quis diam erat. Duis
                                velit lectus, posuere a blandit sit amet, tempor at lorem. Donec ultricies, lorem sed
                                ultrices interdum.Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam quis diam
                                erat. Duis
                                velit lectus, posuere a blandit sit amet, tempor at lorem. Donec ultricies, lorem sed
                                ultrices interdum.Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam quis diam
                                erat. Duis
                                velit lectus, posuere a blandit sit amet, tempor at lorem. Donec ultricies, lorem sed
                                ultrices interdum.</p>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam quis diam erat. Duis
                                velit lectus, posuere a blandit sit amet, tempor at lorem. Donec ultricies, lorem sed
                                ultrices interdum.Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam quis diam
                                erat. Duis
                                velit lectus, posuere a blandit sit amet, tempor at lorem. Donec ultricies, lorem sed
                                ultrices interdum.Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam quis diam
                                erat. Duis
                                velit lectus, posuere a blandit sit amet, tempor at lorem. Donec ultricies, lorem sed
                                ultrices interdum.</p>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam quis diam erat. Duis
                                velit lectus, posuere a blandit sit amet, tempor at lorem. Donec ultricies, lorem sed
                                ultrices interdum.Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam quis diam
                                erat. Duis
                                velit lectus, posuere a blandit sit amet, tempor at lorem. Donec ultricies, lorem sed
                                ultrices interdum.Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam quis diam
                                erat. Duis
                                velit lectus, posuere a blandit sit amet, tempor at lorem. Donec ultricies, lorem sed
                                ultrices interdum.</p>
                        </div>
                    </div>
                </div><!-- /.row -->
            </div><!-- /.sigin-in-->
        </div><!-- /.container -->
    </div><!-- /.body-content -->
    <div style="height: 100px;"></div>
    <!-- =============================== FOOTER =========================== -->
@endsection
