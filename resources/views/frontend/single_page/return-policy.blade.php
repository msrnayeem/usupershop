@extends('frontend.layouts.master')
@section('title', 'Return Policy | ' . config('app.name'))

@section('meta_description', 'Read the return policy of ' . config('app.name') . ' — learn how to return products,
    request refunds, and shop with confidence.')
@section('meta_keywords', 'Return Policy, Refunds, Product Returns, Customer Support, ' . config('app.name'))
@section('meta_author', config('app.name'))

@push('meta')
    {{-- Open Graph / Facebook --}}
    <meta property="og:title" content="Return Policy - {{ config('app.name') }}" />
    <meta property="og:description"
        content="Learn how to return products, request refunds, and shop confidently at {{ config('app.name') }}." />
    <meta property="og:image" content="{{ asset('frontend/images/og-default.jpg') }}" />
    <meta property="og:url" content="{{ url()->current() }}" />
    <meta property="og:type" content="website" />

    {{-- Twitter Card --}}
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Return Policy - {{ config('app.name') }}">
    <meta name="twitter:description"
        content="Learn how to return products, request refunds, and shop confidently at {{ config('app.name') }}.">
    <meta name="twitter:image" content="{{ asset('frontend/images/og-default.jpg') }}">
@endpush

@section('content')
    <!-- ========================== HEADER : END ========================== -->
    <div class="breadcrumb">
        <div class="container">
            <div class="breadcrumb-inner">
                <ul class="list-inline list-unstyled">
                    <li><a href="#">Home</a></li>
                    <li class='active'>Return Policy</li>
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
                </div>
            </div>
            <!-- /.row -->
            <!-- /.sigin-in-->
        </div><!-- /.container -->
    </div><!-- /.body-content -->
@endsection
