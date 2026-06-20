@extends('frontend.layouts.master')
@section('title', 'Privacy Policy | ' . config('app.name'))

@section('meta_description', 'Read the privacy policy of ' . config('app.name') . ' — learn how we collect, use, and
    protect your personal information while providing a secure shopping experience.')
@section('meta_keywords', 'Privacy Policy, Data Protection, Customer Privacy, Secure Shopping, ' . config('app.name'))
@section('meta_author', config('app.name'))

@push('meta')
    {{-- Open Graph / Facebook --}}
    <meta property="og:title" content="Privacy Policy - {{ config('app.name') }}" />
    <meta property="og:description"
        content="Learn how {{ config('app.name') }} collects, uses, and protects your personal information to ensure a secure shopping experience." />
    <meta property="og:image" content="{{ asset('frontend/images/og-default.jpg') }}" />
    <meta property="og:url" content="{{ url()->current() }}" />
    <meta property="og:type" content="website" />

    {{-- Twitter Card --}}
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Privacy Policy - {{ config('app.name') }}">
    <meta name="twitter:description"
        content="Learn how {{ config('app.name') }} collects, uses, and protects your personal information to ensure a secure shopping experience.">
    <meta name="twitter:image" content="{{ asset('frontend/images/og-default.jpg') }}">
@endpush

@section('content')
    <!-- ========================== HEADER : END ========================== -->
    <div class="breadcrumb">
        <div class="container">
            <div class="breadcrumb-inner">
                <ul class="list-inline list-unstyled">
                    <li><a href="#">Home</a></li>
                    <li class='active'>Privacy Policy</li>
                </ul>
            </div><!-- /.breadcrumb-inner -->
        </div><!-- /.container -->
    </div><!-- /.breadcrumb -->

    <div class="body-content">
        <div class="container">
            <div class="row">
                <div class="col-md-12 ">
                    <div class="panel">
                        <div class="panel-body">
                            <h2 class="heading-title">{{ $page->name ?? '' }}</h2>

                            {!! $page->description !!}

                        </div>
                    </div>



                </div><!-- /.row -->
            </div><!-- /.sigin-in-->
        </div><!-- /.container -->
    </div><!-- /.body-content -->
    <div style="height: 100px;"></div>
    <!-- =============================== FOOTER =========================== -->
@endsection
