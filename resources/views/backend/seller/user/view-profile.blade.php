@extends('backend.seller.seller-master')
@section('content')
    <div class="content-wrapper">
        {{-- Page Header --}}
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:22px;flex-wrap:wrap;gap:12px;">
            <div>
                <h1 style="font-size:22px;font-weight:800;color:#0f172a;margin:0;">
                    <i class="fas fa-user-circle" style="color:#6366f1;margin-right:8px;"></i>
                    My Profile
                </h1>
                <p style="color:#64748b;font-size:13px;margin:2px 0 0;">
                    <a href="{{ route('seller.dashboard') }}" style="color:#6366f1;text-decoration:none;">Dashboard</a>
                    <span style="margin:0 6px;color:#cbd5e1;">/</span>
                    View Profile
                </p>
            </div>
            <a href="{{ route('sellers.edit.profile') }}" class="btn btn-sm btn-primary" style="display:inline-flex;align-items:center;gap:6px;padding:9px 18px;background:#6366f1;border:none;border-radius:8px;font-size:13px;font-weight:600;color:#fff;text-decoration:none;">
                <i class="fas fa-user-edit"></i> Edit Profile
            </a>
        </div>

        <section class="content">
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body text-center" style="padding-top:32px;">
                                <div style="margin-bottom:20px;">
                                    <img style="width:100px;height:100px;border-radius:50%;object-fit:cover;border:4px solid #e0e7ff;box-shadow:0 4px 16px rgba(99,102,241,0.15);"
                                        src="{{ !empty($user->image) ? url('public/upload/user_images/' . $user->image) : url('public/upload/profile.jpg') }}"
                                        alt="User Profile Picture">
                                </div>
                                <h3 style="font-size:20px;font-weight:800;color:#0f172a;margin-bottom:4px;">{{ $user->name }}</h3>
                                <p style="color:#64748b;font-size:13px;margin-bottom:20px;">{{ $user->address }}</p>

                                <div style="text-align:left;">
                                    @php
                                        $rows = [
                                            ['Mobile No', $user->mobile, 'fas fa-phone'],
                                            ['Shop Name', $user->shop_name ?? 'N/A', 'fas fa-store'],
                                            ['Account Type', $user->account_type ?? 'N/A', 'fas fa-id-badge'],
                                            ['Commission (%)', ($user->commission ?? '0') . '%', 'fas fa-percent'],
                                            ['Refer Code', $user->code ?? 'N/A', 'fas fa-share-alt'],
                                            ['Email', $user->email, 'fas fa-envelope'],
                                            ['Gender', $user->gender ?? 'N/A', 'fas fa-venus-mars'],
                                            ['Member Since', \Carbon\Carbon::parse($user->created_at)->format('d M Y'), 'fas fa-calendar-alt'],
                                        ];
                                    @endphp
                                    @foreach ($rows as [$label, $value, $icon])
                                        <div style="display:flex;align-items:center;justify-content:space-between;padding:10px 0;border-bottom:1px solid #f1f5f9;">
                                            <span style="font-size:13px;color:#64748b;font-weight:600;display:flex;align-items:center;gap:8px;">
                                                <i class="{{ $icon }}" style="color:#a5b4fc;width:16px;text-align:center;"></i>
                                                {{ $label }}
                                            </span>
                                            <span style="font-size:13px;font-weight:700;color:#0f172a;">{{ $value }}</span>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
