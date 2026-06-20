@extends('frontend.layouts.master')
@section('title', 'Guest Order Confirmation | ' . config('app.name'))

@section('meta_description', 'Guest order confirmation for ' . config('app.name'))
@section('meta_keywords', 'Guest Order Confirmation, Checkout, ' . config('app.name'))
@section('meta_author', config('app.name'))

@push('meta')
    <meta name="robots" content="noindex, nofollow">
@endpush

@section('content')
    <div class="container" style="padding: 60px 0;">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10">
                <div class="card" style="border: 1px solid #e5e5e5; border-radius: 18px; box-shadow: 0 20px 50px rgba(0,0,0,0.06); overflow: hidden;">
                    <div style="background: linear-gradient(135deg, #0f172a, #1d4ed8); color: #fff; padding: 28px 32px;">
                        <h2 style="margin: 0; font-size: 30px; font-weight: 700;">Order placed successfully</h2>
                        <p style="margin: 10px 0 0; opacity: 0.9;">Your order has been received. You do not need an account to complete this purchase.</p>
                    </div>

                    <div style="padding: 32px; background: #fff;">
                        <div style="display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 16px; margin-bottom: 24px;">
                            <div style="background: #f8fafc; border-radius: 14px; padding: 16px;">
                                <div style="font-size: 12px; text-transform: uppercase; letter-spacing: .08em; color: #64748b;">Order No</div>
                                <div style="font-size: 20px; font-weight: 700; color: #0f172a;">#{{ $order->order_no }}</div>
                            </div>
                            <div style="background: #f8fafc; border-radius: 14px; padding: 16px;">
                                <div style="font-size: 12px; text-transform: uppercase; letter-spacing: .08em; color: #64748b;">Status</div>
                                <div style="font-size: 20px; font-weight: 700; color: #0f172a;">{{ ucfirst((string) $order->status) }}</div>
                            </div>
                            <div style="background: #f8fafc; border-radius: 14px; padding: 16px;">
                                <div style="font-size: 12px; text-transform: uppercase; letter-spacing: .08em; color: #64748b;">Customer</div>
                                <div style="font-size: 18px; font-weight: 600; color: #0f172a;">{{ $order->shipping->name ?? 'Guest Customer' }}</div>
                            </div>
                            <div style="background: #f8fafc; border-radius: 14px; padding: 16px;">
                                <div style="font-size: 12px; text-transform: uppercase; letter-spacing: .08em; color: #64748b;">Total</div>
                                <div style="font-size: 18px; font-weight: 700; color: #0f172a;">৳ {{ number_format((float) $order->grand_total, 2) }}</div>
                            </div>
                        </div>

                        <div style="background: #f8fafc; border-radius: 14px; padding: 16px 18px; margin-bottom: 24px;">
                            <div style="font-weight: 700; margin-bottom: 8px; color: #0f172a;">Delivery information</div>
                            <div style="color: #475569; line-height: 1.8;">
                                <div>{{ $order->shipping->address ?? 'N/A' }}</div>
                                <div>{{ $order->shipping->mobile ?? '' }}</div>
                                <div>{{ $order->shipping->email ?? '' }}</div>
                            </div>
                        </div>

                        <div style="display: flex; flex-wrap: wrap; gap: 12px;">
                            <a href="{{ route('frontend.home') }}" class="btn btn-primary" style="padding: 10px 18px; border-radius: 10px;">Back to home</a>
                            <a href="{{ route('customer.login') }}" class="btn btn-outline-secondary" style="padding: 10px 18px; border-radius: 10px;">Login or register for order tracking</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection