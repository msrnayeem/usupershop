@extends('backend.layouts.master')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        {{-- Page Header --}}
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:22px;flex-wrap:wrap;gap:12px;">
            <div>
                <h1 style="font-size:22px;font-weight:800;color:#0f172a;margin:0;">
                    <i class="fas fa-user-circle" style="color:#6366f1;margin-right:8px;"></i>
                    My Profile
                </h1>
                <p style="color:#64748b;font-size:13px;margin:2px 0 0;">
                    <a href="{{ route('home') }}" style="color:#6366f1;text-decoration:none;">Home</a>
                    <span style="margin:0 6px;color:#cbd5e1;">/</span>
                    Profile
                </p>
            </div>
            <a class="btn btn-sm btn-primary" href="{{ route('profiles.edit') }}" style="display:inline-flex;align-items:center;gap:6px;padding:9px 18px;background:#6366f1;border:none;border-radius:8px;font-size:13px;font-weight:600;color:#fff;text-decoration:none;">
                <i class="fas fa-user-edit"></i> Edit Profile
            </a>
        </div>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <section class="col-md-6">
                        <div class="card border-0" style="border:1px solid #e2e8f0 !important;border-radius:10px;box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);">
                            <div class="card-body" style="padding:30px;">
                                <div class="text-center mb-4">
                                    <img style="width:110px;height:110px;border-radius:50%;object-fit:cover;border:3px solid #f1f5f9;box-shadow:0 4px 6px -1px rgba(0,0,0,0.1);"
                                        src="{{ !empty($user->image) ? url('public/upload/user_images/' . $user->image) : url('public/upload/profile.jpg') }}"
                                        alt="User profile picture">
                                    <h5 class="mt-3 mb-1" style="font-weight:800;color:#0f172a;">{{ $user->name }}</h5>
                                    <p class="text-muted" style="font-size:13px;margin:0;"><i class="fas fa-map-marker-alt text-danger mr-1"></i> {{ $user->address ?? 'No address set' }}</p>
                                </div>

                                <table class="table table-bordered" style="font-size:14px;border-radius:8px;overflow:hidden;margin-bottom:0;">
                                    <tbody>
                                        <tr>
                                            <td style="background:#f8fafc;font-weight:600;color:#475569;" width="35%">Phone No</td>
                                            <td>{{ $user->mobile ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <td style="background:#f8fafc;font-weight:600;color:#475569;">Email</td>
                                            <td>{{ $user->email }}</td>
                                        </tr>
                                        <tr>
                                            <td style="background:#f8fafc;font-weight:600;color:#475569;">Gender</td>
                                            <td>{{ $user->gender ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <td style="background:#f8fafc;font-weight:600;color:#475569;">Created At</td>
                                            <td>{{ $user->created_at ? \Carbon\Carbon::parse($user->created_at)->format('d M Y, h:i A') : 'N/A' }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </section>
    </div>
@endsection
