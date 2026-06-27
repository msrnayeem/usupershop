@extends('frontend.layouts.master')
@section('title')
    {{ config('app.name') }} | Pricing Plans
@endsection

@section('custom_css')
    <style>
        .pricing-section {
            padding: 28px 0 40px;
            background: #f9fafb;
        }

        .pricing-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .pricing-header h2 {
            font-size: 30px;
            font-weight: 700;
            margin-bottom: 8px;
            color: #111827;
        }

        .pricing-header p {
            font-size: 14px;
            color: #6b7280;
        }

        .pricing-cards-wrapper {
            display: flex;
            flex-wrap: wrap;
            gap: 16px;
            justify-content: center;
        }

        .pricing-card-item {
            position: relative;
            flex: 0 1 calc(25% - 18px);
            min-width: 250px;
        }

        .pricing-card-item.popular .pricing-card {
            border-color: #2563eb;
            box-shadow: 0 20px 25px -5px rgba(37, 99, 235, 0.1);
            transform: translateY(-6px);
        }

        .popular-badge {
            position: absolute;
            top: -10px;
            left: 50%;
            transform: translateX(-50%);
            background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
            color: white;
            padding: 5px 12px;
            border-radius: 16px;
            font-size:13px;
            font-weight: 600;
            z-index: 1;
            white-space: nowrap;
        }

        .pricing-card {
            background: white;
            border: 1px solid #e5e7eb;
            border-radius: 10px;
            padding: 22px 18px;
            height: 100%;
            display: flex;
            flex-direction: column;
            transition: all 0.3s ease;
        }

        .pricing-card:hover {
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.08);
        }

        .pricing-title {
            font-size: 18px;
            font-weight: 600;
            color: #111827;
            margin-bottom: 6px;
        }

        .pricing-description {
            font-size: 13px;
            color: #6b7280;
            margin-bottom: 16px;
            line-height: 1.5;
        }

        .pricing-amount-wrapper {
            margin-bottom: 20px;
        }

        .pricing-amount {
            font-size: 34px;
            font-weight: 700;
            color: #111827;
            display: inline;
        }

        .pricing-currency {
            font-size: 16px;
            vertical-align: super;
        }

        .pricing-period {
            font-size: 13px;
            color: #6b7280;
            display: inline;
        }

        .pricing-savings {
            font-size:14px;
            color: #10b981;
            font-weight: 600;
            margin-top: 6px;
        }

        .pricing-divider {
            height: 1px;
            background: #e5e7eb;
            margin: 16px 0;
        }

        .pricing-features {
            list-style: none;
            padding: 0;
            margin: 0 0 20px 0;
            flex-grow: 1;
        }

        .pricing-features li {
            padding: 6px 0;
            font-size: 13px;
            color: #374151;
            display: flex;
            align-items: center;
        }

        .pricing-features li:before {
            content: "✓";
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 16px;
            height: 16px;
            background: #dbeafe;
            color: #2563eb;
            border-radius: 50%;
            margin-right: 8px;
            font-size:13px;
            font-weight: bold;
            flex-shrink: 0;
        }

        .pricing-button {
            width: 100%;
            padding: 10px 14px;
            border: none;
            border-radius: 7px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
            text-align: center;
        }

        .pricing-card-item.popular .pricing-button {
            background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
            color: white;
            box-shadow: 0 4px 15px rgba(37, 99, 235, 0.4);
        }

        .pricing-card-item.popular .pricing-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(37, 99, 235, 0.5);
        }

        .pricing-button:not(.pricing-card-item.popular .pricing-button) {
            background: #f3f4f6;
            color: #111827;
        }

        .pricing-button:not(.pricing-card-item.popular .pricing-button):hover {
            background: #e5e7eb;
        }

        @media (max-width: 1199px) {
            .pricing-card-item {
                flex: 0 1 calc(50% - 12px);
            }

            .pricing-card-item.popular .pricing-card {
                transform: none;
            }
        }

        @media (max-width: 768px) {
            .pricing-section {
                padding: 100px 0 32px;
            }

            .pricing-header h2 {
                font-size: 24px;
            }

            .pricing-cards-wrapper {
                gap: 16px;
            }

            .pricing-card-item {
                flex: 0 1 100%;
            }

            .pricing-card {
                padding: 18px 14px;
            }
        }

        .empty-state {
            text-align: center;
            padding: 60px 20px;
        }

        .empty-state-icon {
            font-size: 48px;
            margin-bottom: 16px;
        }

        .empty-state-text {
            font-size: 16px;
            color: #6b7280;
        }
    </style>
@endsection

@section('content')
    <div class="body-content outer-top-xs pricing-section" id="top-banner-and-menu">
        <div class="container">
            <div class="pricing-header">
                <h2>{{ $pageTitle ?? 'Pricing Plans' }}</h2>
                <p>Choose the subscription plan that fits your business needs</p>
            </div>

            @if ($plans->isEmpty())
                <div class="empty-state">
                    <div class="empty-state-icon">📊</div>
                    <div class="empty-state-text">No pricing plans are available right now.</div>
                </div>
            @else
                <div class="pricing-cards-wrapper">
                    @foreach ($plans as $index => $plan)
                        @php
                            $features = is_array($plan->plan_features) ? $plan->plan_features : [];
                            $isPopular = ($index === 1) || ($plans->count() > 2 && $index === 2);
                        @endphp
                        <div class="pricing-card-item {{ $isPopular ? 'popular' : '' }}">
                            @if ($isPopular)
                                <div class="popular-badge">⭐ Most Popular</div>
                            @endif
                            <div class="pricing-card">
                                <h3 class="pricing-title">{{ $plan->account_type_of_myshop }}</h3>
                                <p class="pricing-description">
                                    @if ($index === 0)
                                        Try all features free
                                    @elseif ($isPopular)
                                        Best value for growing businesses
                                    @elseif ($index === $plans->count() - 1)
                                        Maximum savings for established businesses
                                    @else
                                        Perfect for getting started
                                    @endif
                                </p>

                                <div class="pricing-amount-wrapper">
                                    @if ($plan->subscription_fees == 0)
                                        <span class="pricing-amount">Free</span>
                                    @else
                                        <span class="pricing-currency">৳</span><span class="pricing-amount">{{ number_format((int) $plan->subscription_fees) }}</span>
                                        <span class="pricing-period">
                                            /{{ ($plan->duration ?? 'monthly') == 'yearly' ? 'Year' : 'Month' }}
                                        </span>
                                    @endif

                                    @if ($isPopular && $plan->subscription_fees > 0)
                                        <div class="pricing-savings">Save ৳{{ number_format((int) ($plan->subscription_fees * 0.4)) }}</div>
                                    @endif
                                </div>

                                <div class="pricing-divider"></div>

                                <ul class="pricing-features">
                                    @forelse ($features as $feature)
                                        <li>{{ $feature }}</li>
                                    @empty
                                        <li>Standard features included</li>
                                    @endforelse
                                </ul>

                                @php
                                    $whatsappNumber = '8801816622128';
                                    $planName = $plan->account_type_of_myshop;
                                    $price = number_format((int) $plan->subscription_fees);
                                    
                                    if ($plan->subscription_fees == 0) {
                                        $message = "Hello! I'm interested in starting with the *$planName* plan (Free Trial) at U Super Shop. Could you please help me get started?";
                                    } else {
                                        $message = "Hello! I'm interested in the *$planName* plan (৳$price) at U Super Shop. I would like to know more details and proceed with the subscription. Please guide me through the process.";
                                    }
                                    
                                    $whatsappUrl = 'https://wa.me/' . $whatsappNumber . '?text=' . urlencode($message);
                                @endphp
                                <a href="{{ $whatsappUrl }}" target="_blank" class="pricing-button">
                                    @if ($plan->subscription_fees == 0)
                                        Start Free Trial
                                    @else
                                        Get Started
                                    @endif
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
@endsection
