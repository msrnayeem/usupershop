@extends('frontend.layouts.master')
@section('title', 'Terms & Conditions | ' . config('app.name'))

@section('meta_description', 'Read the Terms & Conditions of ' . config('app.name') . ' — understand our rules,
    policies, and user responsibilities while shopping safely online.')
@section('meta_keywords', 'Terms and Conditions, Policies, Rules, User Agreement, ' . config('app.name'))
@section('meta_author', config('app.name'))

@push('meta')
    {{-- Open Graph / Facebook --}}
    <meta property="og:title" content="Terms & Conditions - {{ config('app.name') }}" />
    <meta property="og:description"
        content="Understand the rules, policies, and user responsibilities at {{ config('app.name') }} while shopping safely online." />
    <meta property="og:image" content="{{ asset('frontend/images/og-default.jpg') }}" />
    <meta property="og:url" content="{{ url()->current() }}" />
    <meta property="og:type" content="website" />

    {{-- Twitter Card --}}
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Terms & Conditions - {{ config('app.name') }}">
    <meta name="twitter:description"
        content="Understand the rules, policies, and user responsibilities at {{ config('app.name') }} while shopping safely online.">
    <meta name="twitter:image" content="{{ asset('frontend/images/og-default.jpg') }}">
@endpush

@section('content')
    <!-- ========================== HEADER : END ========================== -->
    <div class="breadcrumb">
        <div class="container">
            <div class="breadcrumb-inner">
                <ul class="list-inline list-unstyled">
                    <li><a href="#">Home</a></li>
                    <li class='active'>Terms & Conditions</li>
                </ul>
            </div><!-- /.breadcrumb-inner -->
        </div><!-- /.container -->
    </div><!-- /.breadcrumb -->

    <div class="body-content">
        <div class="container">
            <div class="row">
                <div class="col-md-12 ">
                    <div class="panel-header">
                        <h2 class="heading-title">{{ $page->name ?? 'name' }}</h2>
                    </div>
                    <div class="panel-body" style="background: #fff;">

                        @if ($page->description != null)
                            {!! $page->description !!}
                        @else
                            <p>Description</p>
                        @endif


                    </div>

                </div>
            </div>
        </div>
        <!-- /.container -->
    </div><!-- /.body-content -->
    <div style="height: 100px;"></div>
    <!-- =============================== FOOTER =========================== -->
@endsection
