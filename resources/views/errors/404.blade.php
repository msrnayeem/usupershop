@extends('frontend.layouts.master')

@section('title', 'Page Not Found - ' . config('app.name'))

@section('content')
<div class="body-content outer-top-bd">
    <div class="container">
        <div class="x-page inner-bottom-sm">
            <div class="row">
                <div class="col-md-12 x-text text-center">
                    <h1 style="font-size: 100px; color: #59b210;">404</h1>
                    <p>We are sorry, the page you've requested is not available. </p>
                    <a href="{{ url('/') }}" class="btn btn-primary"><i class="fa fa-home"></i> Go To Homepage</a>
                    <a href="{{ route('product.list') }}" class="btn btn-info"><i class="fa fa-shopping-cart"></i> Continue Shopping</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 
