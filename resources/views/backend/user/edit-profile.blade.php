@extends('backend.layouts.master')
@section('content')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        {{-- Page Header --}}
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:22px;flex-wrap:wrap;gap:12px;">
            <div>
                <h1 style="font-size:22px;font-weight:800;color:#0f172a;margin:0;">
                    <i class="fas fa-user-edit" style="color:#6366f1;margin-right:8px;"></i>
                    Edit Profile
                </h1>
                <p style="color:#64748b;font-size:13px;margin:2px 0 0;">
                    <a href="{{ route('home') }}" style="color:#6366f1;text-decoration:none;">Home</a>
                    <span style="margin:0 6px;color:#cbd5e1;">/</span>
                    <a href="{{ route('profiles.view') }}" style="color:#6366f1;text-decoration:none;">Profile</a>
                    <span style="margin:0 6px;color:#cbd5e1;">/</span>
                    Edit
                </p>
            </div>
            <a class="btn btn-sm btn-primary" href="{{ route('profiles.view') }}" style="display:inline-flex;align-items:center;gap:6px;padding:9px 18px;background:#6366f1;border:none;border-radius:8px;font-size:13px;font-weight:600;color:#fff;text-decoration:none;">
                <i class="fas fa-user"></i> My Profile
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
                                    <i class="fas fa-edit" style="color:#6366f1;margin-right:6px;"></i>
                                    Update Profile Info
                                </span>
                            </div>
                            <div class="card-body">
                                <form method="post" action="{{ route('profiles.update') }}" id="myForm" enctype="multipart/form-data">
                                    @csrf
                                    <div class="form-row">
                                        <div class="form-group col-md-4">
                                            <label for="name">Name</label>
                                            <input type="text" name="name" value="{{ $editData->name }}" class="form-control" id="name" required>
                                            <span style="color: red;">{{ $errors->has('name') ? $errors->first('name') : '' }}</span>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="email">Email</label>
                                            <input type="email" name="email" value="{{ $editData->email }}" class="form-control" id="email" required>
                                            <span style="color: red;">{{ $errors->has('email') ? $errors->first('email') : '' }}</span>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="mobile">Phone No</label>
                                            <input type="text" name="mobile" value="{{ $editData->mobile }}" class="form-control" id="mobile" required>
                                            <span style="color: red;">{{ $errors->has('mobile') ? $errors->first('mobile') : '' }}</span>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="address">Address</label>
                                            <input type="text" name="address" value="{{ $editData->address }}" class="form-control" id="address">
                                            <span style="color: red;">{{ $errors->has('address') ? $errors->first('address') : '' }}</span>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="gender">Gender</label>
                                            <select name="gender" class="form-control select2" id="gender">
                                                <option value="">Select Gender</option>
                                                <option value="Male" {{ $editData->gender == 'Male' ? 'selected' : '' }}>Male</option>
                                                <option value="Female" {{ $editData->gender == 'Female' ? 'selected' : '' }}>Female</option>
                                            </select>
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label for="image">Profile Image</label>
                                            <input type="file" name="image" id="image" class="form-control">
                                        </div>

                                        <div class="form-group col-md-2" style="display:flex;align-items:flex-end;">
                                            <img id="showImage" style="width: 80px;height:80px;border-radius:8px;border:1px solid #e2e8f0;object-fit:cover;"
                                                src="{{ !empty($editData->image) ? url('public/upload/user_images/' . $editData->image) : url('upload/profile.jpg') }}">
                                        </div>

                                        <div class="form-group col-md-12 text-right" style="margin-top:20px;border-top:1px solid #e2e8f0;padding-top:20px;">
                                            <button type="submit" class="btn btn-primary" style="background:#6366f1;border:none;padding:9px 24px;border-radius:8px;font-weight:600;">
                                                <i class="fas fa-save mr-1"></i> Update Profile
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
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

            // Live preview
            $('#image').change(function(e) {
                var reader = new FileReader();
                reader.onload = function(event) {
                    $('#showImage').attr('src', event.target.result);
                };
                reader.readAsDataURL(e.target.files[0]);
            });

            $('#myForm').validate({
                rules: {
                    name: {
                        required: true
                    },
                    email: {
                        required: true,
                        email: true
                    },
                    mobile: {
                        required: true
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
