@extends('backend.layouts.master')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        {{-- Page Header --}}
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:22px;flex-wrap:wrap;gap:12px;">
            <div>
                <h1 style="font-size:22px;font-weight:800;color:#0f172a;margin:0;">
                    <i class="fas fa-id-card" style="color:#6366f1;margin-right:8px;"></i>
                    Vendor Verification
                </h1>
                <p style="color:#64748b;font-size:13px;margin:2px 0 0;">
                    <a href="{{ route('home') }}" style="color:#6366f1;text-decoration:none;">Home</a>
                    <span style="margin:0 6px;color:#cbd5e1;">/</span>
                    Vendor Profile
                </p>
            </div>
            <a class="btn btn-sm btn-primary" href="{{ route('vendors.view') }}" style="display:inline-flex;align-items:center;gap:6px;padding:9px 18px;background:#6366f1;border:none;border-radius:8px;font-size:13px;font-weight:600;color:#fff;text-decoration:none;">
                <i class="fas fa-arrow-left"></i> Back to Vendors
            </a>
        </div>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <section class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <span class="card-title">
                                    <i class="fas fa-user-check" style="color:#6366f1;margin-right:6px;"></i>
                                    Verification Documents (NID / Passport)
                                </span>
                            </div>
                            <div class="card-body">
                                <div class="msg"></div>
                                <table class="table table-bordered table-striped nowrap dt-responsive" style="width: 100%">
                                    <thead>
                                        <tr>
                                            <th class="text-center">NID Number</th>
                                            <th class="text-center">Birth Date</th>
                                            <th class="text-center">Front Image</th>
                                            <th class="text-center">Back Image</th>
                                            <th class="text-center" width="12%">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if ($profiles!=null)
                                            <tr>
                                                <td class="text-center" style="font-weight:600;color:#0f172a;">{{ $profiles->nid_no ?? 'N/A' }}</td>
                                                <td class="text-center">{{ $profiles->birthdate ?? 'N/A' }}</td>
                                                <td class="text-center">
                                                    <a href="{{ asset('public/upload/profile_verify/' . ($profiles->front_image ?? 'default.jpg')) }}" target="_blank">
                                                        <img src="{{ asset('public/upload/profile_verify/' . ($profiles->front_image ?? 'default.jpg')) }}" 
                                                             class="img-thumbnail" alt="NID Front" style="width:120px;height:80px;object-fit:cover;"
                                                             onerror="this.onerror=null;this.src='{{ asset('frontend/assets/images/no-image.png') }}'">
                                                    </a>
                                                </td>
                                                <td class="text-center">
                                                    <a href="{{ asset('public/upload/profile_verify/' . ($profiles->back_image ?? 'default.jpg')) }}" target="_blank">
                                                        <img src="{{ asset('public/upload/profile_verify/' . ($profiles->back_image ?? 'default.jpg')) }}" 
                                                             class="img-thumbnail" alt="NID Back" style="width:120px;height:80px;object-fit:cover;"
                                                             onerror="this.onerror=null;this.src='{{ asset('frontend/assets/images/no-image.png') }}'">
                                                    </a>
                                                </td>
                                                <td class="text-center">
                                                    <a href="{{ route('vendors_profile.delete',$profiles->user_id) }}" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete verification profile?')">
                                                        <i class="fas fa-trash-alt mr-1"></i> Delete
                                                    </a>
                                                </td>
                                            </tr>
                                        @else
                                            <tr>
                                                <td colspan="5" class="text-center py-4 text-muted">
                                                    <i class="fas fa-exclamation-triangle fa-2x mb-2" style="color:#94a3b8;"></i>
                                                    <p style="margin:0;font-weight:600;">No Verification Documents Found</p>
                                                </td>
                                            </tr>
                                        @endif
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
