@extends('backend.layouts.master')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        {{-- Page Header --}}
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:22px;flex-wrap:wrap;gap:12px;">
            <div>
                <h1 style="font-size:22px;font-weight:800;color:#0f172a;margin:0;">
                    <i class="fas fa-user-edit" style="color:#6366f1;margin-right:8px;"></i>
                    Edit User
                </h1>
                <p style="color:#64748b;font-size:13px;margin:2px 0 0;">
                    <a href="{{ route('home') }}" style="color:#6366f1;text-decoration:none;">Home</a>
                    <span style="margin:0 6px;color:#cbd5e1;">/</span>
                    <a href="{{ route('users.view') }}" style="color:#6366f1;text-decoration:none;">Users</a>
                    <span style="margin:0 6px;color:#cbd5e1;">/</span>
                    Edit
                </p>
            </div>
            <a class="btn btn-sm btn-primary" href="{{ route('users.view') }}" style="display:inline-flex;align-items:center;gap:6px;padding:9px 18px;background:#6366f1;border:none;border-radius:8px;font-size:13px;font-weight:600;color:#fff;text-decoration:none;">
                <i class="fas fa-list"></i> User List
            </a>
        </div>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" style="border:none;border-radius:8px;background:#f0fdf4;color:#15803d;">
                        <i class="fas fa-check-circle"></i> {{ session('success') }}
                        <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" style="border:none;border-radius:8px;background:#fef2f2;color:#b91c1c;">
                        <button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>
                        @foreach($errors->all() as $err)
                            <div><i class="fas fa-exclamation-circle"></i> {{ $err }}</div>
                        @endforeach
                    </div>
                @endif

                <div class="row">
                    <div class="col-md-8">
                        <form method="POST" action="{{ route('users.update', $editData->id) }}" id="editUserForm">
                            @csrf

                            <!-- User Info Section -->
                            <div class="card border-0 mb-4" style="border:1px solid #e2e8f0 !important;border-radius:10px;">
                                <div class="card-header" style="background:#f8fafc;border-bottom:1px solid #e2e8f0;">
                                    <span class="card-title" style="font-size:14px;font-weight:700;"><i class="fas fa-user mr-1" style="color:#6366f1;"></i> User Information</span>
                                    <span class="badge badge-light float-right" style="font-size:11px;background:#e2e8f0;color:#334155;">ID: #{{ $editData->id }}</span>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6 form-group">
                                            <label class="font-weight-bold">Full Name <span class="text-danger">*</span></label>
                                            <input type="text" name="name" value="{{ old('name', $editData->name) }}" class="form-control" placeholder="User's full name" required>
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <label class="font-weight-bold">Role</label>
                                            <select name="role" class="form-control select2" required>
                                                <option value="user" {{ ($editData->role ?? 'user') == 'user' ? 'selected' : '' }}>User (Customer)</option>
                                                <option value="admin" {{ ($editData->role ?? '') == 'admin' ? 'selected' : '' }}>Admin</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Contact Info Section -->
                            <div class="card border-0 mb-4" style="border:1px solid #e2e8f0 !important;border-radius:10px;">
                                <div class="card-header" style="background:#f8fafc;border-bottom:1px solid #e2e8f0;">
                                    <span class="card-title" style="font-size:14px;font-weight:700;"><i class="fas fa-phone-alt mr-1" style="color:#6366f1;"></i> Contact Information</span>
                                </div>
                                <div class="card-body">
                                    <div class="alert alert-warning border-0" style="font-size:13px;background:#fffbeb;color:#b45309;border-radius:8px;">
                                        <i class="fas fa-shield-alt"></i> As an Administrator, you can update the User's login email and phone number.
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 form-group">
                                            <label class="font-weight-bold">Email Address</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-envelope"></i></span></div>
                                                <input type="email" name="email" value="{{ old('email', $editData->email) }}" class="form-control" placeholder="user@example.com" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <label class="font-weight-bold">Phone Number</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-phone"></i></span></div>
                                                <input type="text" name="mobile" value="{{ old('mobile', $editData->mobile) }}" class="form-control" placeholder="01XXXXXXXXX" maxlength="11">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Password Section -->
                            <div class="card border-0 mb-4" style="border:1px solid #e2e8f0 !important;border-radius:10px;">
                                <div class="card-header" style="background:#f8fafc;border-bottom:1px solid #e2e8f0;">
                                    <span class="card-title" style="font-size:14px;font-weight:700;"><i class="fas fa-lock mr-1" style="color:#ef4444;"></i> Change Password</span>
                                    <span class="badge badge-light float-right" style="font-size:11px;background:#fee2e2;color:#ef4444;">Optional</span>
                                </div>
                                <div class="card-body">
                                    <div class="alert alert-info border-0" style="font-size:13px;background:#f0f9ff;color:#0369a1;border-radius:8px;">
                                        <i class="fas fa-info-circle"></i> Leave these fields blank if you do not want to change the user's password.
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 form-group">
                                            <label class="font-weight-bold">New Password</label>
                                            <div class="input-group">
                                                <input type="password" name="new_password" id="newPass" class="form-control" placeholder="Min 6 characters" autocomplete="new-password">
                                                <div class="input-group-append">
                                                    <button type="button" class="btn btn-outline-secondary" onclick="togglePass('newPass')" style="border-color:#cbd5e1;">
                                                        <i class="fas fa-eye" id="eye1"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <label class="font-weight-bold">Confirm Password</label>
                                            <div class="input-group">
                                                <input type="password" name="new_password_confirmation" id="confPass" class="form-control" placeholder="Re-type password" autocomplete="new-password">
                                                <div class="input-group-append">
                                                    <button type="button" class="btn btn-outline-secondary" onclick="togglePass('confPass')" style="border-color:#cbd5e1;">
                                                        <i class="fas fa-eye" id="eye2"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group text-right" style="margin-top:20px;border-top:1px solid #e2e8f0;padding-top:20px;">
                                <a href="{{ route('users.view') }}" class="btn btn-secondary mr-2" style="border-radius:8px;padding:9px 24px;font-weight:600;">Cancel</a>
                                <button type="submit" class="btn btn-primary" style="background:#6366f1;border:none;padding:9px 24px;border-radius:8px;font-weight:600;">
                                    <i class="fas fa-save mr-1"></i> Update User Details
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- User Meta details panel -->
                    <div class="col-md-4">
                        <div class="card border-0" style="border:1px solid #e2e8f0 !important;border-radius:10px;">
                            <div class="card-header" style="background:#f8fafc;border-bottom:1px solid #e2e8f0;">
                                <span class="card-title" style="font-size:14px;font-weight:700;"><i class="fas fa-id-card mr-1" style="color:#6366f1;"></i> User Account Status</span>
                            </div>
                            <div class="card-body">
                                <div class="text-center mb-4">
                                    @if($editData->image)
                                        <img src="{{ asset('upload/user_images/' . $editData->image) }}" style="width:80px;height:80px;border-radius:50%;object-fit:cover;border:3px solid #f1f5f9;box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1);">
                                    @else
                                        <div style="width:80px;height:80px;border-radius:50%;background:#6366f1;display:flex;align-items:center;justify-content:center;font-size:28px;font-weight:800;color:#fff;margin:0 auto;box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1);">
                                            {{ strtoupper(substr($editData->name ?? 'U', 0, 1)) }}
                                        </div>
                                    @endif
                                    <h6 class="mt-3 mb-1" style="font-weight:700;color:#0f172a;">{{ $editData->name }}</h6>
                                    <span class="text-muted" style="font-size:12px;">ID: #{{ $editData->id }}</span>
                                </div>

                                <table class="table table-bordered table-sm" style="font-size:13px;border-radius:6px;overflow:hidden;">
                                    <tr>
                                        <td class="font-weight-bold" style="background:#f8fafc;color:#475569;" width="40%">Account Type</td>
                                        <td>
                                            @php
                                                $typeMap = ['user'=>'Customer','vendor'=>'Vendor','dropshipper'=>'Dropshipper','admin'=>'Admin'];
                                                $typeColor = ['user'=>'info','vendor'=>'success','dropshipper'=>'danger','admin'=>'warning'];
                                                $ut = $editData->usertype ?? 'user';
                                            @endphp
                                            <span class="badge badge-{{ $typeColor[$ut] ?? 'secondary' }}">{{ $typeMap[$ut] ?? ucfirst($ut) }}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="font-weight-bold" style="background:#f8fafc;color:#475569;">Status</td>
                                        <td>
                                            @if($editData->status)
                                                <span class="badge badge-success">Active</span>
                                            @else
                                                <span class="badge badge-danger">Inactive</span>
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="font-weight-bold" style="background:#f8fafc;color:#475569;">Registered</td>
                                        <td>{{ $editData->created_at ? \Carbon\Carbon::parse($editData->created_at)->format('d M Y') : 'N/A' }}</td>
                                    </tr>
                                    @if($editData->subscription_plan)
                                        <tr>
                                            <td class="font-weight-bold" style="background:#f8fafc;color:#475569;">Subscription</td>
                                            <td>{{ \Carbon\Carbon::createFromTimestamp($editData->subscription_plan)->format('d M Y') }}</td>
                                        </tr>
                                    @endif
                                    @if($editData->balance)
                                        <tr>
                                            <td class="font-weight-bold" style="background:#f8fafc;color:#475569;">Balance</td>
                                            <td><strong style="color:#16a34a;">৳{{ number_format($editData->balance, 2) }}</strong></td>
                                        </tr>
                                    @endif
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <script type="text/javascript">
        function togglePass(id) {
            var input = document.getElementById(id);
            input.type = input.type === 'password' ? 'text' : 'password';
        }

        $(function() {
            $('.select2').select2({
                theme: 'bootstrap4'
            });

            $('#editUserForm').validate({
                rules: {
                    name: {
                        required: true
                    },
                    email: {
                        required: true,
                        email: true
                    },
                    new_password: {
                        minlength: 6
                    },
                    new_password_confirmation: {
                        equalTo: '#newPass'
                    }
                },
                errorElement: 'span',
                errorPlacement: function(error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.form-group').append(error);
                },
                highlight: function(element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                }
            });
        });
    </script>
@endsection
