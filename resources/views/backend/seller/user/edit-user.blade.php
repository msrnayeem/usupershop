@extends('backend.seller.seller-master')
@section('content')
    <div class="content-wrapper">
        {{-- Page Header --}}
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:22px;flex-wrap:wrap;gap:12px;">
            <div>
                <h1 style="font-size:22px;font-weight:800;color:#0f172a;margin:0;">
                    <i class="fas fa-user-cog" style="color:#6366f1;margin-right:8px;"></i>
                    Edit User
                </h1>
                <p style="color:#64748b;font-size:13px;margin:2px 0 0;">
                    <a href="{{ route('seller.dashboard') }}" style="color:#6366f1;text-decoration:none;">Dashboard</a>
                    <span style="margin:0 6px;color:#cbd5e1;">/</span>
                    Edit User
                </p>
            </div>
            <a href="{{ route('users.view') }}" class="btn btn-sm btn-secondary" style="display:inline-flex;align-items:center;gap:6px;padding:9px 18px;border-radius:8px;font-size:13px;font-weight:600;text-decoration:none;">
                <i class="fas fa-list"></i> User List
            </a>
        </div>

        <section class="content">
            <div class="container-fluid">
                <div class="card">
                    <div class="card-header">
                        <span class="card-title font-weight-bold text-dark"><i class="fas fa-edit mr-1 text-primary"></i> Update User Details</span>
                    </div>
                    <div class="card-body">
                        <form method="post" action="{{ route('users.update', $editData->id) }}" id="myForm">
                            @csrf
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label for="role">User Role</label>
                                    <select name="role" id="role" class="form-control">
                                        <option value="">Select Role</option>
                                        <option value="admin" {{ $editData->role == 'admin' ? 'selected' : '' }}>Admin</option>
                                        <option value="user" {{ $editData->role == 'user' ? 'selected' : '' }}>User</option>
                                    </select>
                                </div>

                                <div class="form-group col-md-4">
                                    <label for="name">Full Name</label>
                                    <input type="text" name="name" value="{{ $editData->name }}" class="form-control" id="name" placeholder="Full name">
                                    <span style="color:red;">{{ $errors->has('name') ? $errors->first('name') : '' }}</span>
                                </div>

                                <div class="form-group col-md-4">
                                    <label for="email">Email Address</label>
                                    <input type="email" name="email" value="{{ $editData->email }}" class="form-control" id="email" placeholder="Email address">
                                    <span style="color:red;">{{ $errors->has('email') ? $errors->first('email') : '' }}</span>
                                </div>

                                <div class="form-group col-12 mt-2">
                                    <button type="submit" class="btn btn-primary px-5" style="background:#6366f1;border:none;border-radius:8px;font-weight:700;padding:10px 28px;">
                                        <i class="fas fa-save mr-1"></i> Update User
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <script type="text/javascript">
        $(function() {
            $('#myForm').validate({
                rules: {
                    name: { required: true },
                    email: { required: true, email: true },
                },
                messages: {
                    name: { required: "Please enter username" },
                    email: { required: "Please enter an email address", email: "Please enter a valid email address" },
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
