@extends('backend.seller.seller-master')
@section('content')
    <div class="content-wrapper">
        {{-- Page Header --}}
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:22px;flex-wrap:wrap;gap:12px;">
            <div>
                <h1 style="font-size:22px;font-weight:800;color:#0f172a;margin:0;">
                    <i class="fas fa-key" style="color:#6366f1;margin-right:8px;"></i>
                    Change Password
                </h1>
                <p style="color:#64748b;font-size:13px;margin:2px 0 0;">
                    <a href="{{ route('seller.dashboard') }}" style="color:#6366f1;text-decoration:none;">Dashboard</a>
                    <span style="margin:0 6px;color:#cbd5e1;">/</span>
                    Security Settings
                </p>
            </div>
        </div>

        <section class="content">
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-md-7">
                        <div class="card">
                            <div class="card-header">
                                <span class="card-title font-weight-bold text-dark"><i class="fas fa-lock mr-1 text-primary"></i> Update Account Password</span>
                            </div>
                            <div class="card-body">
                                <form method="post" action="{{ route('sellers.password.update') }}" id="myForm">
                                    @csrf
                                    <div class="form-group">
                                        <label for="current_password">Current Password</label>
                                        <input type="password" name="current_password" class="form-control" id="current_password" placeholder="Enter your current password">
                                    </div>

                                    <div class="form-group">
                                        <label for="new_password">New Password</label>
                                        <input type="password" name="new_password" class="form-control" id="new_password" placeholder="Enter new password (min 6 characters)">
                                    </div>

                                    <div class="form-group">
                                        <label for="again_new_password">Confirm New Password</label>
                                        <input type="password" name="again_new_password" class="form-control" id="again_new_password" placeholder="Re-enter new password">
                                    </div>

                                    <div class="mt-3">
                                        <button type="submit" class="btn btn-primary px-5" style="background:#6366f1;border:none;border-radius:8px;font-weight:700;padding:11px 28px;">
                                            <i class="fas fa-save mr-1"></i> Update Password
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <script type="text/javascript">
        $(function() {
            $('#myForm').validate({
                rules: {
                    current_password: { required: true },
                    new_password: { required: true, minlength: 6 },
                    again_new_password: { required: true, equalTo: '#new_password' },
                },
                messages: {
                    current_password: { required: "Please provide current password" },
                    new_password: { required: "Please provide new password", minlength: "Password must be at least 6 characters" },
                    again_new_password: { required: "Please enter confirm password", equalTo: "Confirm password does not match" }
                },
                errorElement: 'span',
                errorPlacement: function(error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.form-group').append(error);
                },
                highlight: function(element) { $(element).addClass('is-invalid'); },
                unhighlight: function(element) { $(element).removeClass('is-invalid'); }
            });
        });
    </script>
@endsection
