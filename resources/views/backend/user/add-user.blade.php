@extends('backend.layouts.master')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        {{-- Page Header --}}
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:22px;flex-wrap:wrap;gap:12px;">
            <div>
                <h1 style="font-size:22px;font-weight:800;color:#0f172a;margin:0;">
                    <i class="fas fa-user-plus" style="color:#6366f1;margin-right:8px;"></i>
                    Add User
                </h1>
                <p style="color:#64748b;font-size:13px;margin:2px 0 0;">
                    <a href="{{ route('home') }}" style="color:#6366f1;text-decoration:none;">Home</a>
                    <span style="margin:0 6px;color:#cbd5e1;">/</span>
                    <a href="{{ route('users.view') }}" style="color:#6366f1;text-decoration:none;">Users</a>
                    <span style="margin:0 6px;color:#cbd5e1;">/</span>
                    Add User
                </p>
            </div>
            <a class="btn btn-sm btn-primary" href="{{ route('users.view') }}" style="display:inline-flex;align-items:center;gap:6px;padding:9px 18px;background:#6366f1;border:none;border-radius:8px;font-size:13px;font-weight:600;color:#fff;text-decoration:none;">
                <i class="fas fa-list"></i> User List
            </a>
        </div>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <section class="col-md-12">
                        <form method="post" action="{{ route('users.store') }}" id="myForm">
                            @csrf
                            <div class="row">
                                <!-- Column 1: Profile Info -->
                                <div class="col-lg-4 col-md-12">
                                    <div class="card mb-4" style="border: 1px solid #e2e8f0; border-radius: 12px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); height: calc(100% - 24px);">
                                        <div class="card-header" style="background:#f8fafc; border-bottom: 1px solid #e2e8f0; border-radius: 12px 12px 0 0;">
                                            <h3 class="card-title" style="font-size:15px; font-weight:700; color:#0f172a; margin:0;">
                                                <i class="fas fa-user" style="color:#6366f1; margin-right:6px;"></i> Profile Info
                                            </h3>
                                        </div>
                                        <div class="card-body" style="padding: 20px;">
                                            <div class="form-group">
                                                <label for="name" style="font-weight:600; color:#334155;">Full Name <span class="text-danger">*</span></label>
                                                <input type="text" name="name" class="form-control" id="name" placeholder="Enter full name" required>
                                                <span style="color: red;">{{ $errors->has('name') ? $errors->first('name') : '' }}</span>
                                            </div>
                                            <div class="form-group mb-0">
                                                <label for="role" style="font-weight:600; color:#334155;">User Role <span class="text-danger">*</span></label>
                                                <select name="role" id="role" class="form-control select2" required style="width:100%;">
                                                    <option value="">Select Role</option>
                                                    <option value="admin">Admin</option>
                                                    <option value="user">User</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Column 2: Credentials -->
                                <div class="col-lg-4 col-md-12">
                                    <div class="card mb-4" style="border: 1px solid #e2e8f0; border-radius: 12px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); height: calc(100% - 24px);">
                                        <div class="card-header" style="background:#f8fafc; border-bottom: 1px solid #e2e8f0; border-radius: 12px 12px 0 0;">
                                            <h3 class="card-title" style="font-size:15px; font-weight:700; color:#0f172a; margin:0;">
                                                <i class="fas fa-key" style="color:#6366f1; margin-right:6px;"></i> Credentials
                                            </h3>
                                        </div>
                                        <div class="card-body" style="padding: 20px;">
                                            <div class="form-group">
                                                <label for="email" style="font-weight:600; color:#334155;">Email Address <span class="text-danger">*</span></label>
                                                <input type="email" name="email" class="form-control" id="email" placeholder="Enter email address" required>
                                                <span style="color: red;">{{ $errors->has('email') ? $errors->first('email') : '' }}</span>
                                            </div>
                                            <div class="form-group">
                                                <label for="password" style="font-weight:600; color:#334155;">Password <span class="text-danger">*</span></label>
                                                <input type="password" name="password" class="form-control" id="password" placeholder="Password (min 6 chars)" required>
                                            </div>
                                            <div class="form-group mb-0">
                                                <label for="password2" style="font-weight:600; color:#334155;">Confirm Password <span class="text-danger">*</span></label>
                                                <input type="password" name="password2" class="form-control" id="password2" placeholder="Confirm password" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Column 3: Action -->
                                <div class="col-lg-4 col-md-12">
                                    <div class="card mb-4" style="border: 1px solid #e2e8f0; border-radius: 12px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05); background: #f8fafc;">
                                        <div class="card-body p-3">
                                            <button type="submit" class="btn btn-primary btn-block" style="background:#6366f1; border:none; padding:12px; border-radius:8px; font-weight:700; font-size:14px; display:flex; align-items:center; justify-content:center; gap:8px; width:100%;">
                                                <i class="fas fa-save"></i> Save User
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </section>
                </div>
            </div>
        </section>
    </div>

    <script type="text/javascript">
        $(function() {
            $('.select2').select2({
                theme: 'bootstrap4'
            });

            $('#myForm').validate({
                rules: {
                    role: {
                        required: true
                    },
                    name: {
                        required: true
                    },
                    email: {
                        required: true,
                        email: true
                    },
                    password: {
                        required: true,
                        minlength: 6
                    },
                    password2: {
                        required: true,
                        equalTo: '#password'
                    }
                },
                messages: {
                    role: {
                        required: "Please select user role"
                    },
                    name: {
                        required: "Please enter username"
                    },
                    email: {
                        required: "Please enter a valid email address"
                    },
                    password: {
                        required: "Please provide a password",
                        minlength: "Your password must be at least 6 characters long"
                    },
                    password2: {
                        required: "Please enter confirm password",
                        equalTo: "Confirm password does not match"
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
